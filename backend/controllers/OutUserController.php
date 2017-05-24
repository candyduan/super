<?php
namespace backend\controllers;

use common\library\Utils;
use common\models\orm\extend\Partner;
use common\models\orm\extend\Admin;
use common\models\orm\extend\OutUser;
use Yii;
use yii\base\ErrorException;
use yii\web\Controller;
use backend\web\util\MyHtml;
use backend\web\util\MyMail;
use common\models\AdminUser;
use backend\library\sdk\SdkUtils;
use yii\filters\AccessControl;
use common\library\BController;
use common\library\Constant;

/**
 * AdminUser controller
 */
class OutUserController extends BController
{
    public $layout = "system";
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
        $searchStr = trim(Utils::getBParam('searchStr', ''));
        $condition = self::_getCondition($searchStr);
        $data = OutUser::getIndexData($condition, $start,$length);
        $count = OutUser::getIndexCount($condition);
        $tabledata = [];
        foreach($data as $value){
            $utypes = [
                1 => '内容供应',
                2 => '内容推广',
                3 => '综合'
            ];
            $partner  = Partner::findByPk($value['partner'])->toArray();
            $partner_str = $utype = $holder = '';
            if($partner){
                $partner_str = '['.$partner['id'] .']'.$partner['name'];
                $utype = isset($utypes[$partner['utype']]) ? $utypes[$partner['utype']] : '';
                $holder = Admin::getNickById($partner['holder']);
            }
            $tabledata[] = [
                $value['username'],
                $value['email'],
                $partner_str,
                $utype,
                $holder,
                 MyHtml::aElement('javascript:void(0);' ,'modifyOutUser', $value['ouid'],'编辑') .MyHtml::br().
                 MyHtml::aElement('javascript:void(0);' ,'deleteOutUser', $value['ouid'],'删除') .MyHtml::br()
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
        if (isset($username) && OutUser::usernameEmailNotExist($username,0) && OutUser::usernameEmailNotExist($email,0)) { //由于邮箱和用户名都可以用作登录 所以确保 唯一性
            $transaction =  OutUser::getDb()->beginTransaction();
            try {
                $resultState = $this->_addUser();
                $transaction->commit();
            } catch (ErrorException $e) {
                $resultState = 0;
                $transaction->rollBack();
                MyMail::sendMail($e->getMessage(), 'Error From add out User');
            }
        }else{
            $resultState = -1;
        }

        echo json_encode($resultState);
        exit;
    }

    public function actionDeleteOutUser(){
        $resultState = 0;
        $ouid = Utils::getBParam('ouid');
        if(isset($ouid)) {
            $transaction = OutUser::getDb()->beginTransaction();
            try {
                $resultState = OutUser::deleteAll(['ouid'=>$ouid]);
                $transaction->commit();
            } catch (ErrorException $e) {
                $resultState = 0;
                $transaction->rollBack();
                MyMail::sendMail($e->getMessage(), 'Error From delete out user');
            }
        }
        Utils::jsonOut($resultState);
        exit;
    }

    public function actionModifyUser() {
        $resultState = 0;
        $ouid = Utils::getBParam('ouid');
        $email=  Utils::getBParam('email');
        $password  = Utils::getBParam('password');
        $partner = Utils::getBParam('partner');
        if (is_numeric($ouid) && OutUser::usernameEmailNotExist($email,$ouid)) {
            $transaction =  OutUser::getDb()->beginTransaction();
            try {
                $model = OutUser::findByPk($ouid);
                if($model){
                    $model->email = $email;
                    $model->partner = $partner;
                    if($password!== ''){
                        $model->password_hash = md5($password);
                    }
                    $resultState = $model->save() == true ? 1:0;
                }
                $transaction->commit();
            } catch (ErrorException $e) {
                $resultState = false;
                $transaction->rollBack();
                MyMail::sendMail($e->getMessage(), 'Error From modify out user');
            }
        }else{
            $resultState = -1;
        }
        Utils::jsonOut($resultState);
        exit;
    }

    public function actionGetAllPartners() {
        $data = Partner::getAllPartnersByBelong(Constant::BELONG_SDK,'');
        Utils::jsonOut($data);
        exit;
    }

    public function actionGetUser() {
        $data = [
            'user' => [],
            'partners' => []
        ];
        $ouid = Utils::getBParam('ouid');
        if ($ouid > 0) {
            $data['user'] = OutUser::findByPK($ouid)->toArray();
            $data['partners'] = Partner::getAllPartnersByBelong(Constant::BELONG_SDK,'');
        }
        Utils::jsonOut($data);
        exit;
    }

    public function actionGetPartner() {
        $name = Utils::getBParam('name');
        $data = [];
        if(isset($name)) {
            $data = Partner::getAllPartnersByBelong(Constant::BELONG_SDK, $name);
        }
        Utils::jsonOut($data);
        exit;
    }

    private function _addUser(){
        $resultState = 0;
        $model = new OutUser();
        $model->username = Utils::getBParam('username');
        $model->password_hash = md5(Utils::getBParam('password'));
        $model->email = Utils::getBParam('email');
        $model->partner = Utils::getBParam('partner');
        $model->status = 1;
        $resultState = $model->save() == true ? 1 : 0;
        return $resultState;
    }

    private function _getCondition($searchStr){
        $condition[] = 'or';
        if($searchStr !== '') {
            $condition[] = [
                'like',
                'outUser.email',
                $searchStr
            ];
            $condition[] = [
                'like',
                'outUser.username',
                $searchStr
            ];
            $condition[] = [
                'like',
                'partner.name',
                $searchStr
            ];

        }

        return $condition;
    }


}
