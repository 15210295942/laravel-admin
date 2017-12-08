<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\BaseController as Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __construct()
    {

    }


    /**
     * 博客列表页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionBlogList(Request $request){

        return view('blog.blog');
    }
}