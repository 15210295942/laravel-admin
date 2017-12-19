<?php

namespace App\Http\Controllers\Tools;


use App\Http\Controllers\BaseController as Controller;
use App\Libs\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UploadController extends Controller
{
    /**
     * 上传图片
     * @param Request $request
     * @return array
     */
    public function actionUpload(Request $request)
    {
        $file = $request->file('file');
        $uploadClass = new Upload();
        $ret = $uploadClass->upload($file);
        return response()->json(['img' => $ret]);
    }
}