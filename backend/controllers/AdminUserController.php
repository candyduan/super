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
                $powerNames = self::_getPowerNames();
                $powerNamesStr = '';
                foreach($powers as $v){
                    $powerNamesStr .= isset($powerNames[$v]) ?  $powerNames[$v] . MyHtml::br() : '';
                }
                $operation = MyHtml::aElement('javascript:void(0)', 'modifyPowers',$value['id'],'修改权限') . MyHtml::br();
                $operation .=  MyHtml::aElement('javascript:void(0)', 'deleteUser',$value['id'],'删除用户');
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
        if (isset($username) && AdminUser::usernameNotExist($username)) {
            $transaction =  AdminUser::getDb()->beginTransaction();
            try {
                $resultState = $this->_addUser();
                $transaction->commit();
            } catch (ErrorException $e) {
                $resultState = false;
                $transaction->rollBack();
                MyMail::sendMail($e->getMessage(), 'Error From add User');
            }
        }else{
            $resultState = -1;
        }

        echo json_encode($resultState);
        exit;
    }

    private function _addUser(){
        $resultState = 0;
        $model = new AdminUser();
        $model->username = Utils::getBParam('username');
        $model->password_hash = md5(Utils::getBParam('password'));
        $model->auth_key = '1';
        $model->password_reset_token = '1';
        $model->email = Utils::getBParam('email');;
        $model->status = 1;
        $resultState = $model->save();
        if($resultState  > 0 && $model->getId()){
            self::_addPower($model->getId());
        }
        return $resultState;
    }

    private function _addPower($auid){
        $powers = self::_getPowers();
        foreach($powers as $power) {
            if (Utils::getBParam($power) == 'on') {
                $model = new AdminAuthor();
                $model->auid = $auid;
                $model->power = $power;
                $model->status = 1;
                $model->save();
            }
        }
    }

    private function _getPowers(){
        return [
            'sdk',
            'sort',
            'app-partner-campaign',
            'sdk-promotion-result',
            'modify-passowrd'
        ];
    }

    private function _getPowerNames(){
        return [
            'sdk' => 'SDK管理',
            'sort' => 'SDK计费排序',
            'app-partner-campaign' => 'SDK内容中心',
            'sdk-promotion-result' => 'SDK成果录入',
            'modify-passowrd' => '修改密码'
        ];
    }

    private function _getCondition(){
        $condition = [
            '=',
            'status',
            1
        ];

        return $condition;
    }


}
