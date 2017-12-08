<?php

/*
  前台路由
*/


Route::group(['namespace' => 'Blog'/*, 'middleware' => ['blog.login']*/], function () {
    Route::get('/', 'IndexController@actionIndex');//首页
    Route::get('/blogList', 'BlogController@actionBlogList');//博客

});