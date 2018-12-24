<?php

namespace App\Http\Middleware;

use Closure;

class ApiCkeckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userInfo = (new \App\Models\UserModel())->getToken($request->input('userName'));
        if(empty($userInfo['token'])){
            return response()->json(['code'=>-1,'msg'=>'请先登录','data'=>[]]);
        }
        if($userInfo['tokenExpriate'] < time()){
            return response()->json(['code'=>-1,'msg'=>'token 失效','data'=>[]]);
        }
        return $next($request);
    }
}
