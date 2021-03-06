<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ParamsException;
use App\Exceptions\PermissionException;
use App\Http\Controllers\BaseController as Controller;
use App\Libs\ApiCode;
use App\Models\AdminModel;
use App\Models\MenuModel;
use App\Models\PowerModel;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    const ADMIN_SESSION_KEY = 'adminUser';
    private $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

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
        if ($codeGoogle != $checkCodeGoogle) {
            throw new ParamsException('请输入正确的验证码');
        }
        if (!$userName || !$psw) {
            throw new ParamsException('请输入用户名和密码');
        }
        if ($user = $this->adminModel->checkPsw($userName, $psw)) {
            $request->session()->put(self::ADMIN_SESSION_KEY, $user);//serialize($user)
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
        $admins = $this->adminModel->getAll();
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
        if ($request->method() !== 'POST') {
            $menuList = (new MenuModel())->with('hasManyChildMenu')->where('type', 1)->where('pid', 0)->get()->toArray();
            return view('admin.adminAdd', ['user' => $user, 'menuList' => $menuList]);
        }
        $userName = $request->input('userName');
        $userPhoto = $request->input('userPhoto');
        $pswT = $request->input('pswT');
        $menu = $request->input('menu');
        if (!$menu) {
            throw new Exception('请选择权限', ApiCode::BAD_REQUEST);
        }

        $id = $this->adminModel->addAdmin($userName, $userPhoto, $pswT);
        if ($id) {
            $powerModel = new PowerModel();
            $powerModel->add($id, $menu);
            return $this->returnJson(ApiCode::SUCCESS, ['result' => true]);
        }
        throw new Exception('添加失败', ApiCode::BAD_REQUEST);
    }

    /**
     * 修改管理员
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws Exception
     * @throws PermissionException
     */
    public function actionEdit(Request $request)
    {
        $id = $request->input('id');
        $detail = $this->adminModel->getDetailById($id);
        if ($request->method() !== 'POST') {
            $menuList = (new MenuModel())->with('hasManyChildMenu')->where('type', 1)->where('pid', 0)->get()->toArray();
            $menuMy = (new PowerModel())->where('adminId', $id)->get()->toArray();
            $menuMy = array_column($menuMy, 'menuId');
            return view('admin.adminEdit', ['detail' => $detail, 'menuList' => $menuList, 'menuMy' => $menuMy]);
        }
        $userName = $request->input('userName');
        $userPhoto = $request->input('userPhoto');
        $pswT = $request->input('pswT');
        $menu = $request->input('menu');
        if (!$menu) {
            throw new Exception('请选择权限', ApiCode::BAD_REQUEST);
        }
        $this->adminModel->editAdmin($id, $userName, $userPhoto, $pswT);
        $powerModel = new PowerModel();
        $powerModel->edit($id, $menu);
        return $this->returnJson(ApiCode::SUCCESS, ['result' => true]);

        //throw new Exception('修改失败', ApiCode::BAD_REQUEST);
    }

    /**
     * 删除管理员
     * @param Request $request
     * @return array
     * @throws Exception
     * @throws PermissionException
     */
    public function actionRemove(Request $request)
    {
        $user = $this->currentUser($request);
        $id = $request->input('id');
        if ($user['id'] == $id) {
            throw new Exception('不能删除自己', ApiCode::BAD_REQUEST);
        }
        if ((new AdminModel())->deleteUser($id)) {
            (new PowerModel())->deleteId($id);
            return $this->returnJson(ApiCode::SUCCESS, ['result' => true]);
        }
        throw new Exception('删除失败', ApiCode::BAD_REQUEST);
    }
}