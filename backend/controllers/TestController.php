<?php
namespace backend\controllers;

use common\library\BController;
use frontend\library\regchannel\Utils;

class TestController extends BController{
    public function actionMichael(){
        $str = '111';
        echo Utils::getSpSign($str);
    }
}