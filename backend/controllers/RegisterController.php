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
    
    /*
     * 首页
     */
    public function actionIndex(){
        return $this->render('index');     
    }
    
    
    public function actionMerchantView(){
        return $this->render('merchant-view');
    }
    
    public function actionChannelView(){
        return $this->render('channel-view');
        
        
    }
    
    public function actionMutexView(){
        return $this->render('mutex-view');
    }
    
    
}