<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\BaseController as Controller;

class HomeController extends Controller
{

    //后台首页
    public function actionIndex(){
        return view('admin.index');
    }
}