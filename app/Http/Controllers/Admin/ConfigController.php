<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 2017/7/22
 * Time: 上午11:05
 */

namespace App\Http\Controllers\Admin;


use App\Exceptions\ParamsException;
use App\Exceptions\PermissionException;
use App\Http\Controllers\BaseController as Controller;
use App\Models\ConfigModel;
use App\Models\AdminModel;
use Illuminate\Http\Request;
use App\Libs\ApiCode;

class ConfigController extends Controller
{

    public function viewInfo(Request $request)
    {
        $admin = $this->currentUser($request);
        if (!in_array($admin['type'], [AdminModel::TYPE_ADMIN, AdminModel::TYPE_OPERATE])) {
            throw new PermissionException('没有权限');
        }
        $configModel = new ConfigModel();
        $importDay = $configModel->getValue('IMPORT_OFF_DAY');
        return view('admin.config', ['user' => $this->currentUser($request), 'importDay' => $importDay  ? $importDay : 5]);

    }


    public function actionUpdate(Request $request){
        $configModel = new ConfigModel();
        $importOffDay = $request->input('import_off_day');
        if (!$importOffDay) {
            throw new ParamsException('导入截止日不能为空');
        }
        $result = $configModel->updateConfig('IMPORT_OFF_DAY', $importOffDay);
        if (!$result) {
            throw new ParamsException('修改失败');
        }
        return $this->returnJson(ApiCode::SUCCESS, []);
    }

}