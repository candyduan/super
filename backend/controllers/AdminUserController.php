<?php
namespace backend\controllers;

use common\library\Utils;
use Yii;
use yii\base\ErrorException;
use yii\helpers\Html;
use yii\web\Controller;
use backend\web\util\MyHtml;
use backend\web\util\MyMail;
use common\models\AdminUser;
use common\models\orm\extend\AdminAuthor;
use backend\library\sdk\SdkUtils;
use yii\filters\AccessControl;
use common\library\BController;

/**
 * AdminUser controller
 */
class AdminUserController extends BController
{
    public $layout = "sdk";
    public function behaviors()
    {
        return [

            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['index','create','update','view'],
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // everything else is denied
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAjaxIndex(){
        $start = intval(Utils::getBParam('start', 0));
        $length = intval(Utils::getBParam('length', 100));
        $condition = self::_getCondition();
        $data = AdminUser::getIndexData($condition, $start,$length);
        $count = AdminUser::getIndexCount($condition);
        $tabledata = [];
        foreach($data as $value){
            if($value['username'] == 'admin') {
                $powerNamesStr = '所有';
                $operation = '';
            }else{
                $powers = AdminAuthor::getPowersByAuid($value['id']);
                $allbackend = ['sdk/' => '融合sdk后台','register/' =>'主动上行后台','agency/' => '注册中介后台'];
                $powerNamesStr = '';
                foreach($powers as $k => $v){
                    if(isset($allbackend[$v])){
                        $powerNamesStr .= $allbackend[$v] .'<br/>';
                    }
                }
             /*   $powerNames = self::_getPowerNames();
                $powerNamesStr = '';
                foreach($powers as $v){
                    $powerNamesStr .= isset($powerNames[$v]) ?  $powerNames[$v] . MyHtml::br() : '';
                }*/
                $operation = MyHtml::aElement('javascript:void(0)', 'modifyPowers',$value['id'],'修改权限') . MyHtml::br();
                $operation .=  MyHtml::aElement('javascript:void(0)', 'deleteAdminUser',$value['id'],'删除用户');
            }

            $tabledata[] = [
                $value['username'],
                $powerNamesStr,
                $operation
            ];
        }

        $data = [
            'searchData' => [

            ],
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'tableData' => $tabledata,
        ];
        Utils::jsonOut($data);
        exit;
    }

    public function actionAddUser() {
        $resultState = 0;
        $username = Utils::getBParam('username');
        $email = Utils::getBParam('email');
        if (isset($username) && AdminUser::usernameNotExist($username)  && AdminUser::emailNotExist($email)) {
            $transaction =  AdminUser::getDb()->beginTransaction();
            try {
                $resultState = $this->_addUser();
                $transaction->commit();
            } catch (ErrorException $e) {
                $resultState = 0;
                $transaction->rollBack();
                MyMail::sendMail($e->getMessage(), 'Error From add User');
            }
        }else{
            $resultState = -1;
        }

        echo json_encode($resultState);
        exit;
    }

    public function actionDeleteAdminUser(){
        $resultState = 0;
        $auid = Utils::getBParam('auid');
        if(isset($auid)) {
            $transaction = AdminUser::getDb()->beginTransaction();
            try {
                $resultState = AdminUser::deleteAll(['id'=>$auid]);
                AdminAuthor::deleteAll(['auid' => $auid]);
                $transaction->commit();
            } catch (ErrorException $e) {
                $resultState = 0;
                $transaction->rollBack();
                MyMail::sendMail($e->getMessage(), 'Error From delete admin user');
            }
        }
        Utils::jsonOut($resultState);
        exit;
    }

    public function actionModifyUser() {
        $resultState = 0;
        $auid = Utils::getBParam('auid');
        if (isset($auid)) {
            $transaction =  AdminUser::getDb()->beginTransaction();
            try {
                $model = AdminUser::findByPk($auid);
                if($model){
                    $model->email = Utils::getBParam('email','');
                    $resultState = $model->save() == true ? 1:0;
                    if($resultState  > 0 && $model->id){
                        AdminAuthor::deleteAll(['auid' => $auid]);
                        self::_addPower($model->id);
                    }
                }
                $transaction->commit();
            } catch (ErrorException $e) {
                $resultState = false;
                $transaction->rollBack();
                MyMail::sendMail($e->getMessage(), 'Error From modify user power');
            }
        }
        Utils::jsonOut($resultState);
        exit;
    }

    public function actionGetUserPowers() {
        $data = [
            'user' => [],
            'powers' => []
        ];
        $auid = Utils::getBParam('auid');
        if ($auid > 0) {
            $data['user'] = AdminUser::findByPK($auid)->toArray();
            $powers = AdminAuthor::getPowersByAuid($auid);
            foreach($powers as $power){
                $data['powers'][] = str_replace('/','',$power);
            }
        }
        Utils::jsonOut($data);
        exit;
    }

    private function _addUser(){
        $resultState = 0;
        $model = new AdminUser();
        $model->username = Utils::getBParam('username');
        $model->password_hash = md5(Utils::getBParam('password'));
        $model->generateAuthKey();
        $model->generatePasswordResetToken();
        $model->email = Utils::getBParam('email');
        $model->status = 1;
        $resultState = $model->save() == true ? 1:0;
        if($resultState  > 0 && $model->getId()){
            self::_addPower($model->getId());
        }
        return $resultState;
    }

    private function _addPower($auid){
        $powers = self::_getPowers();
        foreach($powers as $power) {
            if (Utils::getBParam($power) == "on") {
                if($power == 'sdk'){
                    $powerdetails = [
                        'sdk',
                        'sort',
                        'partner',
                        'app',
                        'campaign',
                        'sdk-promotion-result',
                        'sdk-pay',
                        'package-pay',
                        'modify-password' ,
                        'package',
                        'site'
                    ];
                    foreach($powerdetails as $powerdetail){
                        self::_addPowerDetail($powerdetail, $auid);
                    }
                }else{
                    self::_addPowerDetail($power, $auid);
                }
            }
        }
    }

    private function _addPowerDetail($power, $auid){
        $model = new AdminAuthor();
        $model->auid = $auid;
        $model->power = $power.'/';
        $model->status = 1;
        $model->save();
    }

    private function _getPowers(){
        return [
            'sdk',
            'agency',
            'register'
        ];
    }

 /*   private function _getPowerNames(){
        return [
            'sdk/' => 'SDK管理',
            'sort/' => 'SDK计费排序',
            'partner/' => 'SDK内容中心(内容商列表)',
            'app/' => 'SDK内容中心(应用列表)',
            'campaign/' => 'SDK内容中心(活动列表)',
            'sdk-promotion-result/' => 'SDK成果录入',
            'sdk-pay/' => '数据中心(计费转化)',
            'modify-password/' => '修改密码',
            'package/' => 'SDK内容中心(活动包列表)'
        ];
    }*/

    private function _getCondition(){
        $condition = [
            '=',
            'status',
            1
        ];

        return $condition;
    }


}
