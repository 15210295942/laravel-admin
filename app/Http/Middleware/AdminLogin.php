<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Admin\AdminController;
use App\Libs\ApiCode;
use Closure;
use Illuminate\Http\Response;

class AdminLogin
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
        $user = $request->session()->get(AdminController::ADMIN_SESSION_KEY);
        if(!$user){
            if($request->ajax()){
                return (new Response())->setContent(['code'=>ApiCode::UNAUTHORIZED,'msg'=>'请先登录']);
            }
            return redirect()->route('adminLogin');
        }
        return $next($request);
    }
}
