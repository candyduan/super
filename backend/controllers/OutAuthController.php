<?php
namespace backend\controllers;
use common\library\BController;
use common\library\Utils;
use common\models\LoginForm;
use common\models\orm\extend\OutUser;
use yii\web\Controller;
use Yii;

class OutAuthController extends BController{//controller yaogaila
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
        $session =  Yii::$app->getSession();
        if (!empty($session->get('__outuserid'))) {
            return $this->render("/out-auth/index");
        } else {
            $this->redirect("/out-auth/login");
        }
    }

    public function actionLogin()
    {
        $session =  Yii::$app->getSession();
        if (!empty($session->get('__outuserid'))) {
            return $this->render("/out-auth/index");
        }
        $model= new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->outlogin()) {
            $id =  $session->get('__id');
            $session->set('__outuserid', $id);
            $session->set('__id', '');
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
        Yii::$app->getSession()->set('__outuserid', '');
        Yii::$app->user->logout();
        $this->redirect("/out-auth/login");
    }

}