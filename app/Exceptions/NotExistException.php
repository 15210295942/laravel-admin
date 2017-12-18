<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 2017/6/28
 * Time: 下午10:57
 */

namespace App\Exceptions;


use App\Libs\ApiCode;
use \Exception;

class NotExistException extends Exception
{
    public function __construct($message = '') {
        parent::__construct($message,ApiCode::NOT_FOUND);
    }
}