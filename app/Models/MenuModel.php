<?php

namespace App\Models;

use App\Models\BaseModel as Model;

class MenuModel extends Model
{

    protected $table = 'menu';

    //菜单的子集
    public function hasManyChildMenu()
    {
        return $this->hasMany('App\Models\MenuModel', 'pid', 'id')->orderBy('sort', 'ASC');
    }

    /**
     * 获取全部信息
     * @return array
     */
    public function getAll()
    {
        return $this->get()->toArray();
    }

    /**
     * 获取顶级菜单
     * @return array
     */
    public function getTopMenu()
    {
        return $this->where('type', 1)->where('pid', 0)->get()->toArray();
    }

    /**
     * 添加菜单
     * @param $path
     * @param $displayName
     * @param $description
     * @param $pid
     * @param $icon
     * @param $sort
     * @param $type
     * @return bool
     */
    public function addMenu($path, $displayName, $description, $pid, $icon, $sort, $type)
    {
        $data['createTime'] = time();
        $path && $data['path'] = $path;
        $displayName && $data['display_name'] = $displayName;
        $description && $data['description'] = $description;
        $pid && $data['pid'] = $pid;
        $icon && $data['icon'] = $icon;
        $sort && $data['sort'] = $sort;
        $type && $data['type'] = $type;
        return $this->insert($data);
    }

    public function getDetailById($id)
    {
        $detail = $this->where('id', $id)->first();
        if ($detail) {
            $detail = $detail->toArray();
            $parent = $this->where('id', $detail['pid'])->first();
            $detail['parent'] = $parent ? $parent->toArray() : [];
        }
        return $detail ?: [];
    }

    /**
     * update
     * @param $id
     * @param $path
     * @param $displayName
     * @param $description
     * @param $pid
     * @param $icon
     * @param $sort
     * @param $type
     * @return bool
     */
    public function editMenu($id, $path, $displayName, $description, $pid, $icon, $sort, $type)
    {
        $data['createTime'] = time();
        $path && $data['path'] = $path;
        $displayName && $data['display_name'] = $displayName;
        $description && $data['description'] = $description;
        $pid && $data['pid'] = $pid;
        $icon && $data['icon'] = $icon;
        $sort && $data['sort'] = $sort;
        $type && $data['type'] = $type;
        return $this->where('id', $id)->update($data);
    }

    /**
     * 删除
     * @param $id
     * @return bool|null
     * @throws \Exception
     */
    public function deleteMenu($id)
    {
        return $this->where([['id', $id]])->delete();
    }
}