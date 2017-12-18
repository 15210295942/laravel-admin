<?php

namespace App\Exceptions;


use App\Libs\ApiCode;
use \Exception;

class ParamsException extends Exception
{
    public function __construct($message = '') {
        parent::__construct($message,ApiCode::INPUT_ERROR);
    }
}