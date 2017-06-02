<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\library\BController;

/**
 * Site controller
 */
class SiteController extends BController
{
    public $layout = "sdk";
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $session = \yii::$app->session;
        if (!empty($session->get('__id'))) {
            return $this->render("/site/index");
        } else {
            $this->redirect("/auth/login");
        }
    }




    
}
