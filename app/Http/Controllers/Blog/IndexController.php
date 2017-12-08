<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\BaseController as Controller;

class IndexController extends Controller
{

    public function __construct()
    {

    }


    /**
     * 首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionIndex()
    {

        return view('blog.index');
    }
}