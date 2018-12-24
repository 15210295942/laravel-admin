<?php

namespace App\Models;

use App\Exceptions\NotExistException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'user';

    /**
     * 登录
     */
    public function login($userName,$passWord,$loginIp){
        $userInfo = $this->where('userName',$userName)->first();
        if(empty($userInfo))
            throw new \Exception('用户名不存在');
        if(!Hash::check($passWord.$userInfo['salt'],$userInfo['passWord']))
            throw new \Exception('密码错误');

        $token = $this->makeToken($userName,$passWord,$userInfo['salt']);
        $expirate = time()+env('TOKEN_EXPIRATE');
        $this->where('userName',$userName)->update(['loginTime'=>time(),'loginIp'=>$loginIp,'token'=>$token,'tokenExpriate'=>$expirate]);
        return $token;
    }

    /**
     * 注册
     */
    public function register($userName,$passWord){
        $userInfo = $this->where('userName',$userName)->first();
        if(!empty($userInfo))
            throw new \Exception('用户已存在');
        $salt = $this->makeSalt();
        $savePassWord = Hash::make($passWord.$salt);
        $this->insert(['userName'=>$userName,'password'=>$savePassWord,'createTime'=>time(),'salt'=>$salt]);
    }

    private function makeSalt(){
        $str="QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";
        str_shuffle($str);
        return substr(str_shuffle($str),26,4);
    }

    private function makeToken($userName,$passWord,$salt){
        return md5($userName.$passWord.$salt.time());
    }

    public function getToken($userName){
        return $this->where('userName',$userName)->first();
    }
}
