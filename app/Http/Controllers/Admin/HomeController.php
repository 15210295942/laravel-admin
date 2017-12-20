<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController as Controller;
use App\Models\MenuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{

    //后台首页
    public function actionIndex()
    {
        $menu = new MenuModel();
        $menuPList = $menu->with('hasManyChildMenu')->where('type', 1)->where('pid', 0)->orderBy('sort', 'ASC')->get()->toArray();
        $menuList = $this->handleMenu($menuPList);
        return view('admin.index', ['menu' => $menuList]);
    }

    //处理菜单
    private function handleMenu($menuPList){
        $jsonMenu = '';
        foreach ($menuPList as $k => $v){
            $jsonMenu[$k]['title'] = $v['display_name'];
            $jsonMenu[$k]['icon'] = $v['icon'];
            $jsonMenu[$k]['href'] = $v['path'];
            $jsonMenu[$k]['spread'] = false;
            foreach ($v['has_many_child_menu'] as $key => $value){
                $jsonMenu[$k]['children'][] = [
                    'title'=>$value['display_name'],
                    'icon'=>$value['icon'],
                    'href'=>$value['path'],
                    'spread'=>false
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