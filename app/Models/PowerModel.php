<?php

namespace App\Models;

use App\Models\BaseModel as Model;

class PowerModel extends Model
{

    protected $table = 'power';

    public function add($id, $menu)
    {
        $menuList = explode(',', $menu);
        foreach ($menuList as $v) {
            if ($v)
                $this->insert(['adminId' => $id, 'menuId' => $v]);
        }
        return true;
    }

    public function edit($id, $menu)
    {
        $ret = $this->deleteId($id);
        $ret && $this->add($id, $menu);
        return true;
    }

    public function deleteId($id)
    {
        return $this->where('adminId', $id)->delete();
    }
}