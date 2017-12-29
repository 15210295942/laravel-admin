<?php

namespace App\Models;

use App\Models\BaseModel as Model;

class CategoryModel extends Model
{

    protected $table = 'category';

    /**
     * 子集
     */
    public function hasManyCate()
    {
        return $this->hasMany('App\Models\CategoryModel', 'pid', 'id')->orderBy('id', 'ASC');
    }

    /**
     * 获取顶级
     * @return array
     */
    public function getTopCate()
    {
        return $this->where('pid', 0)->get()->toArray();
    }

    public function add($name, $description, $pid)
    {
        $data['createTime'] = time();
        $name && $data['name'] = $name;
        $description && $data['description'] = $description;
        $pid && $data['pid'] = $pid;

        return $this->insert($data);
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