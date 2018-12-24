<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController as Controller;
use App\Models\MenuModel;
use App\Models\PowerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{

    //后台首页
    public function actionIndex(Request $request)
    {
        $menu = new MenuModel();
        $current = $this->currentUser($request);
        $power = new PowerModel();
        $menuPower = $power->where('adminId', $current['id'])->get();
        $menuIds = $menuPower ? array_column($menuPower->toArray(), 'menuId') : [];
        $menuPList = $menu->with('hasManyChildMenu')->where('type', 1)->where('pid', 0)->whereIn('id', $menuIds)->orderBy('sort', 'ASC')->get()->toArray();
        $menuList = $this->handleMenu($menuPList, $menuIds);
        return view('admin.index', ['menu' => $menuList]);
    }

    //处理菜单
    private function handleMenu($menuPList, $menuIds)
    {
        $jsonMenu = [];
        foreach ($menuPList as $k => $v) {
            $jsonMenu[$k]['title'] = $v['display_name'];
            $jsonMenu[$k]['icon'] = $v['icon'];
            $jsonMenu[$k]['href'] = $v['path'];
            $jsonMenu[$k]['spread'] = false;
            foreach ($v['has_many_child_menu'] as $key => $value) {
                if (!in_array($value['id'], $menuIds)) {
                    continue;
                }
                $jsonMenu[$k]['children'][] = [
                    'title' => $value['display_name'],
                    'icon' => $value['icon'],
                    'href' => $value['path'],
                    'spread' => false
                ];
            }
        }
        return json_encode($jsonMenu);
    }

    //后台欢迎页
    public function actionWelcome(Request $request)
    {
        return view('admin.welcome');
    }
}