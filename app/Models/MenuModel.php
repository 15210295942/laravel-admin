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
}