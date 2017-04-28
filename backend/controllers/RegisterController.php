<?php
namespace backend\controllers;

use yii\base\Controller;
use common\library\Utils;
class RegisterController extends Controller{
    public function actionTest(){
        $out= array(1,2,3,4,5,6);
        Utils::jsonOut($out);
    }
    
    
}