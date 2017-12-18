<?php

namespace App\Models;


use App\Exceptions\NotExistException;
use App\Exceptions\ParamsException;
use App\Models\BaseModel as Model;
use Illuminate\Support\Facades\Log;

class AdminModel extends Model
{

    protected $table = 'admin';
    protected $hidden = [
        'psw',
    ];
    const TYPE_ADMIN = 1;
    const TYPE_OPERATE = 2;
    const TYPE_FINANCE = 3;
    public static $types = [
        self::TYPE_ADMIN => '管理员',
        self::TYPE_OPERATE => '操作员',
        self::TYPE_FINANCE => '财务员'
    ];

    /**
     * 检查用户名密码是否正确
     * @param string $userName 用户名
     * @param string $psw 明文密码
     * @return bool|user 登录成功返回用户信息；失败返回false
     * @throws NotExistException
     */
    public function checkPsw($userName, $psw)
    {
        $user = $this->where([['userName', $userName], ['isDeleted', static::NOT_DELETED]])->first();
        if (!$user) {
            throw new NotExistException('用户不存在');
        }

        if (password_verify($psw, $user->psw)) {
            return $user->toArray();
        }
        return false;
    }

    public function resetPsw($uname, $oldPsw, $newPsw)
    {
        if (!$newPsw) {
            return false;
        }
        if ($user = $this->checkPsw($uname, $oldPsw)) {
            return $this->where([['uname', $uname]])->update(['psw' => password_hash($newPsw, PASSWORD_DEFAULT)]);
        }
        throw new ParamsException('旧密码错误');
    }


    public function getAll()
    {
        return $this->where([['isDeleted', static::NOT_DELETED]])->get()->toArray();
    }

    public function getAdmin($id)
    {
        $result = $this->where([['id', $id], ['isDeleted', static::NOT_DELETED]])->first();
        return $result ? $result->toArray() : [];
    }

    public function addAdmin($uname, $type, $psw)
    {
        if ($this->unameExist($uname)) {
            throw new ParamsException('用户名已存在');
        }
        return $this->insert([
            'uname' => $uname,
            'type' => $type,
            'psw' => password_hash($psw, PASSWORD_DEFAULT)
        ]);
    }

    public function unameExist($uname)
    {
        return $this->where([['uname', $uname]])->count() > 0;
    }

    public function deleteUser($id)
    {
        return $this->where([['id', $id]])->delete();
    }
}