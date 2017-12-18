<?php
/**
 * 后台路由
 */

Route::group(['namespace' => 'Admin'], function () {
    Route::match(['GET', 'POST'], '/login', 'AdminController@actionLogin')->name('adminLogin');//后台登录
    //需要登录的路由
    Route::group(['middleware' => 'admin.login'], function () {
        Route::get('/index', 'HomeController@actionIndex')->name('admin');//后台首页
    });
});