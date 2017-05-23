<?php
namespace backend\controllers;
use common\library\BController;
use common\library\Utils;
use common\models\LoginForm;
use common\models\orm\extend\OutUser;
use yii\web\Controller;
use Yii;

class OutAuthController extends Controller{//controller yaogaila
    public $layout = "out";
    /*
     * 未授权页面
     */
    public function actionNoauth(){
        return $this->render('noauth');
    }

    /**
     * Login action.
     *
     * @return string
     */

    public function actionIndex()
    {
        $ouid = Yii::$app->getSession()->get('__outuserid');
        $outuser = OutUser::findByPk($ouid);
        yii::$app->user->setIdentity($outuser);
        if (!Yii::$app->user->isGuest) {
            return $this->render("/out-auth/index");
        } else {
            $this->redirect("/out-auth/login");
        }
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->render("/out-login/index");
        }
        $model= new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->outlogin()) {
            $id =  Yii::$app->getSession()->get('__id');
            Yii::$app->getSession()->set('__outuserid', $id);
            Yii::$app->getSession()->set('__id', '');
            $this->redirect("/out-auth/index");
        } else {
            $model = new LoginForm();
            return $this->renderAjax('/out-auth/login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        $this->redirect("/out-auth/index");
    }

}