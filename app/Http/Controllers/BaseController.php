<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    protected function returnJson($code, $data = [])
    {
        return [
            'code' => $code,
            'data' => $data
        ];
    }

}