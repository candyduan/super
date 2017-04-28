<?php
namespace backend\controllers;

use yii\base\Controller;
use common\library\Utils;
class RegisterController extends Controller{
    public $layout = "register";
    public function actionTest(){
        $out= array(1,2,3,4,5,6);
        Utils::jsonOut($out);
    }
    public function actionIndex(){
        echo 111;
        $this->render('index');
    }
    
}