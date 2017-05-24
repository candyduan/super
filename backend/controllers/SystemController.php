<?php
namespace backend\controllers;
use common\library\BController;
class SystemController extends BController{
    public $layout = "system";
    public function actionIndex(){
        return $this->render('index');
    }
}