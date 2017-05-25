<?php
namespace backend\controllers;
use common\library\BController;
use common\models\orm\extend\BackendTheme;
use common\library\Constant;
use common\library\Utils;
use common\models\orm\extend\AdminTheme;
class SystemController extends BController{
    public $layout = "system";
    public function actionIndex(){
        return $this->render('index');
    }
    
    public function actionThemeView(){
        return $this->render('theme-view');
    }
    public function actionThemeResult(){
        $backendThemeModels  = BackendTheme::findByStatus(1);
        if(count($backendThemeModels) > 0){
            $out['resultCode']  = Constant::RESULT_CODE_SUCC;
            $out['msg']         = Constant::RESULT_MSG_SUCC;
            $list   = [];
            foreach ($backendThemeModels as $backendThemeModel){
                $item   = $backendThemeModel->toArray();
                array_push($list, $item);
            }
            $out['list']    = $list;
        }else{
            $out['resultCode']  = Constant::RESULT_CODE_NONE;
            $out['msg']         = Constant::RESULT_MSG_NONE;
        }
        Utils::jsonOut($out);
    }
    public function actionThemeSet(){
        $btid  = Utils::getBackendParam('btid');
        $auid  = \Yii::$app->user->identity->id;
        
        $adminThemeModel    = AdminTheme::findByAuid($auid);
        if(!$adminThemeModel){
            $adminThemeModel    = new AdminTheme();
            $adminThemeModel->auid  = $auid;
        }
        $adminThemeModel->btid = $btid;
        try{
            $adminThemeModel->save();
            $out['resultCode']  = Constant::RESULT_CODE_SUCC;
            $out['msg']         = Constant::RESULT_MSG_SUCC;
        }catch (\Exception $e){
            $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
            $out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
        }
        Utils::jsonOut($out);
    }
    
}