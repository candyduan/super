<?php
namespace backend\controllers;

use Yii;
use yii\base\ErrorException;
use yii\helpers\Html;
use yii\web\Controller;
use common\models\AdminUser;
use common\library\Utils;
use yii\filters\AccessControl;
use common\library\BController;
use backend\web\util\MyMail;
/**
 * ModifyPassword controller
 */
class ModifyPasswordController extends BController
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

    public function actionModifyPassword()
    {
        $resultState = 0;
        $auid = Utils::getBParam('auid',0);
        $oldpassword = trim(Utils::getBParam('oldpassword',''));
        $newpassowrd =  trim(Utils::getBParam('newpassword',''));
        if(!empty($auid) && !empty($oldpassword) && !empty($newpassowrd)){
            if(AdminUser::isPasswordValid($auid, md5($oldpassword))){
                $transaction =  AdminUser::getDb()->beginTransaction();
                try {
                    $model = AdminUser::findByPk($auid);
                    $model->password_hash = md5($newpassowrd);
                    $resultState = $model->save();
                    $transaction->commit();
                }catch (ErrorException $e){
                    $resultState = 0;
                    $transaction->rollBack();
                    MyMail::sendMail($e->getMessage(), 'Error From modify password');
                }
            }else{
                $resultState = -1;
            }
        }

        Utils::jsonOut($resultState);
    }
}
