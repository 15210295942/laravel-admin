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

    /**
     * 获取全部信息
     * @return array
     */
    public function getAll()
    {
        return $this->get()->toArray();
    }

    /**
     * 添加管理员
     * @param $userName
     * @param $userPhoto
     * @param $pswT
     * @return bool
     * @throws ParamsException
     */
    public function addAdmin($userName, $userPhoto, $pswT)
    {
        if ($this->unameExist($userName)) {
            throw new ParamsException('用户名已存在');
        }
        return $this->insert([
            'userName' => $userName,
            'userPhoto' => $userPhoto,
            'psw' => password_hash($pswT, PASSWORD_DEFAULT)
        ]);
    }

    /**
     * 删除管理员
     * @param $id
     * @return bool|null
     * @throws \Exception
     */
    public function deleteUser($id)
    {
        return $this->where([['id', $id]])->delete();
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



    public function getAdmin($id)
    {
        $result = $this->where([['id', $id], ['isDeleted', static::NOT_DELETED]])->first();
        return $result ? $result->toArray() : [];
    }


    //检查账号是否重复
    public function unameExist($userName)
    {
        return $this->where([['userName', $userName]])->count() > 0;
    }

}