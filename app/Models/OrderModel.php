<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    //
    protected $table = 'orders';
    /**
     * 获取全部信息
     * @return array
     */
    public function getAll()
    {
        return $this->get()->toArray();
    }
}
