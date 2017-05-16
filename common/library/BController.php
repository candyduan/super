<?php
namespace common\library;
use yii\web\Controller;
use common\models\orm\extend\AdminAuthor;

class BController extends Controller{
    public function beforeAction($action){
        $controllerName = $action->controller->id;
        $actionName     = $action->id;
        if($controllerName != 'site' && $actionName !='login'){
            $adminUserModel   = \Yii::$app->user->identity;
            $flag   = false;
            if($adminUserModel){
                if($adminUserModel->username == 'admin'){
                    $flag   = true;
                }else{
                    $power  = $controllerName;//先简单判断到功能模块
                    $adminAuthorModel  = AdminAuthor::findByAuidPower($adminUserModel->id,$power);
                    if($adminAuthorModel){
                        $flag   = true;
                    }
                }
            }else{
                $this->redirect('/site/login');
            }
        }else{
            $flag   = true;
        }
        return $flag;
    }
}