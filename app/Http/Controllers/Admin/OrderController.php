<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models;

class OrderController extends Controller
{
    private $orderModel = null;
    public function __construct()
    {
        $this->orderModel = new \App\Models\OrderModel();
    }

    /**
     * 订单列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws PermissionException
     */
    public function actionList(Request $request)
    {
//        $user = $this->currentUser($request);
        $orders = $this->orderModel->getAll();
        return view('order.orderList', ['list' => $orders]);
    }
}
