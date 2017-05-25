<?php
namespace common\library;
use common\models\orm\extend\Partner;
use yii\web\Controller;
use common\models\orm\extend\AdminAuthor;
use common\models\orm\extend\Outuser;
use common\models\orm\extend\AgencyAccount;
use common\library\Constant;
class BController extends Controller{
    /*
     * @return 1-已授权，2-已登录未授权；3-未登录,4-不需要登录
     */
    public function beforeAction($action){
        $controllerName = $action->controller->id;
        $actionName     = $action->id;

        $session = \Yii::$app->getSession();
        $ouid = $session->get('__outuserid');
        if(!empty($ouid)){
            $outuser = OutUser::findByPk($ouid);
            \yii::$app->user->setIdentity($outuser);
        };

        if($controllerName == 'out-auth'){
            return true;
        }else if(($controllerName == 'partner-data') && !empty($ouid)){ //外部的 1 通过  2 不通过 3 未登陆
            $outflag = 3;
            if(empty($outuser)){
                $outflag = 3;
            }else{
                $partner = Partner::findByPk($outuser->partner);
                if(!$partner){
                    $outflag = 2;
                }else{
                    if($partner->utype == Constant::PARTNER_BOTH){
                        $outflag = 1;
                    }else if($partner->utype == Constant::PARTNER_ONLY){
                        \yii::$app->params['partnerDataLayout'] = 'out';
                        if($actionName == 'gain'){
                            $outflag = 1;
                        } else {
                            $outflag = 2;
                        }
                    } else if($partner->utype == Constant::PARTNER_CP){
                        if($actionName == 'cps-gain'){
                            $outflag = 1;
                        } else {
                            $outflag = 2;
                        }
                    }
                }
                switch ($outflag){
                    case 1:
                        return true;
                        break;
                    case 2:
                        $this->redirect('/out-auth/noauth');
                        break;
                    case 3:
                        $this->redirect('/out-auth/login');
                        break;
                    default :
                        $this->redirect('/out-auth/login');
                        break;
                }
            }
        }else{
            $flag = 3;
            \yii::$app->params['partnerDataLayout'] = 'sdk';
            if($controllerName != 'auth' && $actionName !='login'){ //内部的
                if(!empty($session->get('__id'))) {
                    $adminUserModel = \Yii::$app->user->identity;
                    $flag = 3;
                    if ($adminUserModel) {
                        $flag = 2;
                        if ($adminUserModel->username == 'admin') {
                            $flag = 1;
                        } else {
                            $power = $controllerName . '/';//先简单判断到功能模块 !!斜杠很重要
                            $adminAuthorModel = AdminAuthor::findByAuidPower($adminUserModel->id, $power);
                            if ($adminAuthorModel) {
                                $flag = 1;
                            }
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