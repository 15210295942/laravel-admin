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
    protected function currentUser(Request $request)
    {
        $user = $request->session()->get(AdminController::ADMIN_SESSION_KEY);
        //$user = unserialize($user);
        if (!$user) {
            throw new UnAuthException('请先登录');
        }
        return $user;
    }

    function getIp()
    {
        $ip = false;
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(', ', $_SERVER['HTTP_X_FORWARDED_FOR']);
            if ($ip) {
                array_unshift($ips, $ip);
                $ip = FALSE;
            }
            for ($i = 0; $i < count($ips); $i++) {
                if (!eregi('^(10│172.16│192.168).', $ips[$i])) {
                    $ip = $ips[$i];
                    break;
                }
            }
        }
        return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
    }

}