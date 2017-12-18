<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UtilsController extends Controller
{
    /**
     * 获取google验证码
     * @param Request $request
     */
    public function getCaptcha(Request $request)
    {
        $code = CodeGoogle::make_rand(4);
        $request->session()->put('codeGoogle', strtolower($code));
        CodeGoogle::getAuthImage($code);
    }
}