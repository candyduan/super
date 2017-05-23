<?php
namespace backend\controllers;

use Yii;
use yii\base\ErrorException;
use yii\helpers\Html;
use yii\web\Controller;
use backend\web\util\MyHtml;
use backend\web\util\MyMail;
use common\models\orm\extend\Sdk;
use common\models\orm\extend\Admin;
use common\models\orm\extend\Partner;
use common\library\Utils;
use yii\filters\AccessControl;
use common\library\BController;
/**
 * Partner controller
 */
class PartnerDataController extends BController
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

    public function actionGain()
    {
        $holders = Admin::getAllAdmins();

        return $this->render('gain',['holders' =>$holders ]);
    }
    public function actionCpsGain(){
        return $this->render('cps-gain',[]);
    }
}
