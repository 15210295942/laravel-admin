<?php
/**
 * 后台路由
 */
use \Illuminate\Http\Request;

Route::group(['namespace' => 'Admin'], function () {
    //不需要登录的
    Route::match(['GET', 'POST'], '/login', 'AdminController@actionLogin')->name('adminLogin');//后台登录
    Route::match(['GET'], '/logout', function (Request $request) {//退出登录
        $request->session()->flush();
        return Redirect()->route('adminLogin');
    });
    //需要登录的路由
    Route::group(['middleware' => 'admin.login'], function () {
        Route::get('/index', 'HomeController@actionIndex')->name('admin');//后台首页
        Route::get('/welcome', 'HomeController@actionWelcome');//后台欢迎页

        //管理员管理
        Route::match(['GET', 'POST'], '/userPswEdit/{id?}', 'AdminController@actionPswEdit');//修改密码
        Route::get('/list', "AdminController@actionList");//列表
        Route::match(['GET', 'POST'], '/add', "AdminController@actionAdd");//添加
        Route::get('/remove', "AdminController@actionRemove");//删除管理员
    });
});