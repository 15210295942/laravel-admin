<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models;
class UserController extends Controller
{
    protected $model;
    public function __construct()
    {
        $this->model = new Models\UserModel();
    }

    /**
     * 用户登录
     */
    public function login(Request $request){
        $userName = $request->input('userName');
        $passWord = $request->input('passWord');
        if(empty($userName) || !isset($userName) || empty($passWord) || !isset($passWord)){
            return ['code'=>-1,'msg'=>'缺少必要参数','data'=>[]];
        }

        try{
            $token = $this->model->login($userName,$passWord,$request->getClientIp());
            return ['code'=>200,'msg'=>'','data'=>['token'=>$token]];
        }catch(\Exception $e){
            return ['code'=>-1,'msg'=>$e->getMessage()];
        }
    }

    /**
     * 注册
     */
    public function register(Request $request){
        $userName = $request->input('userName');
        $passWord = $request->input('passWord');
        if(empty($userName) || !isset($userName) || empty($passWord) || !isset($passWord)){
            return ['code'=>-1,'msg'=>'缺少必要参数','data'=>[]];
        }

        try{
            $this->model->register($userName,$passWord);
            return ['code'=>200,'msg'=>'注册成功'];
        }catch(\Exception $e){
            return ['code'=>-1,'msg'=>$e->getMessage()];
        }
    }
}
