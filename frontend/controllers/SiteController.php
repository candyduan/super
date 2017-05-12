<?php
namespace frontend\controllers;

use yii\web\Controller;
use common\library\FController;


/**
 * Site controller
 */
class SiteController extends FController
{


    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

}
