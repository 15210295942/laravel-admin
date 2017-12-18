<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 2017/7/12
 * Time: 下午11:18
 */

namespace App\Exceptions;

use App\Libs\ApiCode;
use \Exception;

class PermissionException extends Exception
{
    public function __construct($message = '') {
        parent::__construct($message,ApiCode::NO_PERMISSION);
    }
}