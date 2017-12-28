<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ParamsException;
use App\Exceptions\PermissionException;
use App\Http\Controllers\BaseController as Controller;
use App\Libs\ApiCode;
use App\Models\MenuModel;
use Exception;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    private $menuModel;

    public function __construct()
    {
        $this->menuModel = new MenuModel();
    }

    /**
     * 菜单列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws PermissionException
     */
    public function actionMenuList()
    {
        $list = $this->menuModel->getAll();
        return view('admin.menuList', ['list' => $list]);
    }

    /**
     * 添加菜单
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws Exception
     * @throws PermissionException
     */
    public function actionAdd(Request $request)
    {
        if ($request->method() !== 'POST') {
            $topMenu = $this->menuModel->getTopMenu();
            return view('admin.menuAdd', ['topMenu' => $topMenu]);
        }
        $path = $request->input('path');
        $displayName = $request->input('display_name');
        $description = $request->input('description');
        $pid = $request->input('pid');
        $icon = $request->input('icon');
        $sort = $request->input('sort');
        $type = $request->input('type', 1);

        if ($this->menuModel->addMenu($path, $displayName, $description, $pid, $icon, $sort, $type)) {
            return $this->returnJson(ApiCode::SUCCESS, ['result' => true]);
        }
        throw new Exception('添加失败', ApiCode::BAD_REQUEST);
    }
    /**
     * 修改菜单
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws Exception
     * @throws PermissionException
     */
    public function actionEdit(Request $request)
    {
        $id = $request->input('id');
        $detail = $this->menuModel->getDetailById($id);
        if ($request->method() !== 'POST') {
            $topMenu = $this->menuModel->getTopMenu();
            return view('admin.menuEdit', ['detail' => $detail, 'topMenu' => $topMenu]);
        }
        $path = $request->input('path');
        $displayName = $request->input('display_name');
        $description = $request->input('description');
        $pid = $request->input('pid');
        $icon = $request->input('icon');
        $sort = $request->input('sort');
        $type = $request->input('type', 1);

        if ($this->menuModel->editMenu($id, $path, $displayName, $description, $pid, $icon, $sort, $type)) {
            return $this->returnJson(ApiCode::SUCCESS, ['result' => true]);
        }
        throw new Exception('修改失败', ApiCode::BAD_REQUEST);
    }

    /**
     * 删除菜单
     * @param Request $request
     * @return array
     * @throws Exception
     * @throws PermissionException
     */
    public function actionRemove(Request $request)
    {
        $id = $request->input('id');
        if ($this->menuModel->deleteMenu($id)) {
            return $this->returnJson(ApiCode::SUCCESS, ['result' => true]);
        }
        throw new Exception('删除失败', ApiCode::BAD_REQUEST);
    }

}