<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\PermissionException;
use App\Http\Controllers\BaseController as Controller;
use App\Libs\ApiCode;
use App\Models\CategoryModel;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $cateModel;

    public function __construct()
    {
        $this->cateModel = new CategoryModel();
    }

    /**
     * 列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws PermissionException
     */
    public function actionList()
    {
        $list = $this->cateModel->with('hasManyCate')->where('pid', 0)->get()->toArray();

        return view('admin.categoryList', ['list' => $list]);
    }

    /**
     * 添加
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws Exception
     * @throws PermissionException
     */
    public function actionAdd(Request $request)
    {
        if ($request->method() !== 'POST') {
            $topCate = $this->cateModel->getTopCate();
            return view('admin.categoryAdd', ['topCate' => $topCate]);
        }
        $name = $request->input('name');
        $description = $request->input('description');
        $pid = $request->input('pid');

        if ($this->cateModel->add($name, $description, $pid)) {
            return $this->returnJson(ApiCode::SUCCESS, ['result' => true]);
        }
        throw new Exception('添加失败', ApiCode::BAD_REQUEST);
    }
    /**
     * 修改
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
     * 删除
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