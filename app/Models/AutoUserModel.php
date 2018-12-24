<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class AutoUserModel extends Model implements JWTSubject,Authenticatable
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getAuthIdentifierName()
    {
        return 'id';
    }
    public function getAuthIdentifier()
    {

    }
    public function getAuthPassword()
    {

    }
    public function getRememberToken()
    {

    }
    public function setRememberToken($value)
    {

    }
    public function getRememberTokenName()
    {

    }
    public function JWTSubject()
    {

    }
}
