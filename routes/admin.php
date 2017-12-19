<?php
/**
 * 后台路由
 */
use \Illuminate\Http\Request;

Route::group(['namespace' => 'Admin'], function () {
    Route::match(['GET', 'POST'], '/login', 'AdminController@actionLogin')->name('adminLogin');//后台登录
    //需要登录的路由
    Route::group(['middleware' => 'admin.login'], function () {
        Route::get('/index', 'HomeController@actionIndex')->name('admin');//后台首页
        Route::get('/welcome', 'HomeController@actionWelcome');//后台欢迎页
    });
    //退出登录
    Route::match(['GET'], '/logout', function (Request $request) {
        $request->session()->flush();
        return Redirect()->route('adminLogin');
    });
});