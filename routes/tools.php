<?php
/**
 * 插件路由
 */

Route::group(['namespace' => 'Tools'], function () {
    Route::get('getCaptcha', 'UtilsController@getCaptcha')->name('captcha');//获取验证码
    Route::match(['GET', 'POST'], 'uploadPhoto', 'UploadController@actionUpload')->name('uploadPhoto');//用户上传图片
});