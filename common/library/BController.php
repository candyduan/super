<?php
namespace common\library;
use yii\web\Controller;
use common\models\orm\extend\AdminAuthor;

class BController extends Controller{
    /*
     * @return 1-已授权，2-已登录未授权；3-未登录,4-不需要登录
     */
    public function beforeAction($action){
        $controllerName = $action->controller->id;
        $actionName     = $action->id;
        if($controllerName == '' || $controllerName ==''){

        }else{
            if($controllerName != 'auth' && $actionName !='login'){
                $adminUserModel   = \Yii::$app->user->identity;
                $flag   = 3;
                if($adminUserModel){
                    $flag   = 2;
                    if($adminUserModel->username == 'admin'){
                        $flag   = 1;
                    }else{
                        $power  = $controllerName.'/';//先简单判断到功能模块 !!斜杠很重要
                        $adminAuthorModel  = AdminAuthor::findByAuidPower($adminUserModel->id,$power);
                        if($adminAuthorModel){
                            $flag   = 1;
                        }
                    }
                }
            }else{
                $flag   = 4;
            }
            switch ($flag){
                case 1:
                    return true;
                    break;
                case 2:
                    $this->redirect('/auth/noauth');
                    break;
                case 3:
                    $this->redirect('/auth/login');
                    break;
                case 4:
                    return true;
                    break;
            }
        }
    }
}