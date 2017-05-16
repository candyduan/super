<?php
namespace backend\controllers;
use common\library\BController;
use common\models\LoginForm;
use Yii;
class AuthController extends BController{
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
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->render("/site/index");
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $this->redirect("/site/index");
        } else {
            return $this->renderAjax('/auth/login', [
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
        return $this->goHome();
    }
}