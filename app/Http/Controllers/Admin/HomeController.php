<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 2017/6/29
 * Time: 上午12:23
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\BaseController as Controller;

class HomeController extends Controller
{

    public function actionIndex(){
        return redirect()->route('stuList');
    }
}