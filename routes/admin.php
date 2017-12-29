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
        Route::match(['GET', 'POST'], '/adminPswEdit', 'AdminController@actionPswEdit');//修改密码
        Route::get('/list', "AdminController@actionList");//列表
        Route::match(['GET', 'POST'], '/adminAdd', "AdminController@actionAdd");//添加
        Route::match(['GET', 'POST'], '/adminEdit', "AdminController@actionEdit");//修改
        Route::post('/adminRemove', "AdminController@actionRemove");//删除管理员

        //菜单管理
        Route::get('/menu/list', "MenuController@actionMenuList");//列表
        Route::match(['GET', 'POST'], '/menu/add', "MenuController@actionAdd");//添加
        Route::match(['GET', 'POST'], '/menu/edit', "MenuController@actionEdit");//修改
        Route::post('/menu/remove', "MenuController@actionRemove");//删除

        //博客管理
        Route::get('/blog/list', "BlogController@actionBlogList");//列表
        Route::match(['GET', 'POST'], '/blog/add', "BlogController@actionAdd");//添加
        Route::match(['GET', 'POST'], '/blog/edit', "BlogController@actionEdit");//修改
        Route::post('/blog/remove', "BlogController@actionRemove");//删除
        //分类管理
        Route::get('/category/list', "CategoryController@actionList");//列表
        Route::match(['GET', 'POST'], '/category/add', "CategoryController@actionAdd");//添加
        Route::match(['GET', 'POST'], '/category/edit', "CategoryController@actionEdit");//修改
        Route::post('/category/remove', "CategoryController@actionRemove");//删除
    });
});