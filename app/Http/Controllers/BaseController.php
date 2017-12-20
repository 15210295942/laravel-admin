<?php

namespace App\Http\Controllers;

use App\Exceptions\UnAuthException;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    protected function returnJson($code, $data = [])
    {
        return [
            'code' => $code,
            'data' => $data
        ];
    }

    //验证获取信息
    protected function currentUser(Request $request){
        $user = $request->session()->get(AdminController::ADMIN_SESSION_KEY);
        //$user = unserialize($user);
        if(!$user){
            throw new UnAuthException('请先登录');
        }
        return $user;
    }

}