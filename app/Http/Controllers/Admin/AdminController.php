<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ParamsException;
use App\Exceptions\PermissionException;
use App\Http\Controllers\BaseController as Controller;
use App\Libs\ApiCode;
use App\Models\AdminModel;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    const ADMIN_SESSION_KEY = 'adminUser';

    /**
     * 登录页面
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionLogin(Request $request)
    {
        if ($request->method() === 'POST') {
            return $this->login($request);
        }
        return view('admin.login');
    }

    /**
     * 管理员登录
     * @param Request $request
     * @return array
     * @throws ParamsException
     */
    private function login(Request $request)
    {
        $userName = $request->input('uname');
        $psw = $request->input('psw');
        $codeGoogle = $request->input('codeGoogle');
        $checkCodeGoogle = $request->session()->get('codeGoogle');
        if($codeGoogle != $checkCodeGoogle){
            throw new ParamsException('请输入正确的验证码');
        }
        if (!$userName || !$psw) {
            throw new ParamsException('请输入用户名和密码');
        }
        if ($user = (new AdminModel())->checkPsw($userName, $psw)) {
            $request->session()->put(self::ADMIN_SESSION_KEY, serialize($user));

            return $this->returnJson(ApiCode::SUCCESS, ['result' => true]);
        }
        throw new ParamsException('用户名或密码错误');
    }

    /**
     * 管理员密码设置
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionPsw(Request $request)
    {
        if ($request->method() === 'GET') {
            return view('admin.psw', ['user' => $this->currentUser($request)]);
        }
        $userModel = new AdminModel();
        $current = $this->currentUser($request);
        $oldPsw = $request->input('oldPsw');
        $newPsw = $request->input('newPsw');
        $userModel->resetPsw($current['uname'], $oldPsw, $newPsw);
        $request->session()->flush();
        return $this->returnJson(ApiCode::SUCCESS, ['result' => true]);
    }


    /**
     * 管理员列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws PermissionException
     */
    public function actionList(Request $request)
    {
        $user = $this->currentUser($request);
        if (!in_array($user['type'], [AdminModel::TYPE_ADMIN])) {
            throw new PermissionException('没有权限');
        }
        $admins = (new AdminModel())->getAll();
        foreach ($admins as &$u) {
            $u['type'] = AdminModel::$types[$u['type']];
        }
        return view('admin.adminList', ['user' => $user, 'list' => $admins]);
    }

    /**
     * 添加管理员
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws Exception
     * @throws PermissionException
     */
    public function actionAdd(Request $request)
    {
        $user = $this->currentUser($request);
        if (!in_array($user['type'], [AdminModel::TYPE_ADMIN])) {
            throw new PermissionException('没有权限');
        }
        if ($request->method() !== 'POST') {
            return view('admin.adminAdd', ['user' => $user, 'types' => AdminModel::$types]);
        }
        $uname = $request->input('uname');
        $type = $request->input('type');
        $psw = $request->input('psw');

        if ((new AdminModel())->addAdmin($uname, $type, $psw)) {
            return $this->returnJson(ApiCode::SUCCESS, ['result' => true]);
        }
        throw new Exception('添加失败', ApiCode::BAD_REQUEST);
    }

    /**
     * 删除管理员
     * @param Request $request
     * @return array
     * @throws Exception
     * @throws PermissionException
     */
    public function actionDelete(Request $request)
    {
        $user = $this->currentUser($request);
        if ($user['id'] == $request->input('id')) {
            throw new Exception('不能删除自己', ApiCode::BAD_REQUEST);
        }
        if (!in_array($user['type'], [AdminModel::TYPE_ADMIN])) {
            throw new PermissionException('没有权限', ApiCode::BAD_REQUEST);
        }
        if ((new AdminModel())->deleteUser($request->input('id'))) {
            return $this->returnJson(ApiCode::SUCCESS, ['result' => true]);
        }
        throw new Exception('删除失败', ApiCode::BAD_REQUEST);
    }
}