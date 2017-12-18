<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 2017/6/29
 * Time: 上午12:27
 */

namespace App\Exceptions;


use App\Libs\ApiCode;
use \Exception;
class UnAuthException extends Exception
{
    public function __construct($message = '') {
        parent::__construct($message,ApiCode::UNAUTHORIZED);
    }
}