<?php

/*
  前台路由
*/


Route::group(['namespace' => 'Blog'/*, 'middleware' => ['blog.login']*/], function () {
    Route::get('/', 'IndexController@actionIndex');//首页
});