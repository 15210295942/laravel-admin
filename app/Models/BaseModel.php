<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 2017/7/9
 * Time: 下午3:44
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    const NOT_DELETED = 0;
    const DELETED = 1;

    public $timestamps = false;
    protected $hidden = [
        'isDeleted'
    ];
}