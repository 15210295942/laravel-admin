<?php

namespace App\Models;

use App\Models\BaseModel as Model;

class CategoryModel extends Model
{

    protected $table = 'category';

    //子集
    public function hasManyCate()
    {
        return $this->hasMany('App\Models\CategoryModel', 'pid', 'id')->orderBy('id', 'ASC');
    }

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