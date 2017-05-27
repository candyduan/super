<?php
namespace backend\controllers;

use common\library\Utils;
use common\models\orm\extend\AgencyAccount;
use common\library\Constant;
use common\library\BController;
use common\models\orm\extend\AgencyStack;

class AgencyController extends BController{
    public $layout = "agency";
    
    public function actionIndex(){
        return $this->render('index');
    }
    
    public function actionAccountListView(){
        return $this->render('account-list-view');
    }
    
    public function actionAccountListResult(){
        $page = Utils::getBackendParam('page',1);
        
        $res    = AgencyAccount::findAllNeedPaginator($page);
        
        $models = $res['models'];
        $pages  = $res['pages'];
        $count  = $res['count'];
        
        if($pages >= $page && $pages > 0){
            $out['resultCode']  = Constant::RESULT_CODE_SUCC;
            $out['msg']         = Constant::RESULT_MSG_SUCC;
            $out['pages']       = $pages;
            $out['page']        = $page;
            
            $list   = array();
            foreach ($models as $model){
                $item   = $model->toArray();
                array_push($list, $item);
            }
            $out['list']    = $list;
        }else{
            if($page > 1){
                $msg    = Constant::RESULT_MSG_NOMORE;
            }else{
                $msg    = Constant::RESULT_MSG_NONE;
            }
            $out['resultCode']  = Constant::RESULT_CODE_NONE;
            $out['msg']         = $msg;
        }
        Utils::jsonOut($out);
        
    }
    
    public function actionAccountSetView(){
        return $this->render('account-set-view');
    }
    
    
    public function actionAccountSetSave(){
        $aaid           = Utils::getBackendParam('aaid');
        $name           = Utils::getBackendParam('name');
        $account        = Utils::getBackendParam('account');
        $passwd         = Utils::getBackendParam('passwd');
        $verifyPort     = Utils::getBackendParam('verifyPort');
        $blockPort      = Utils::getBackendParam('blockPort');
        $verifyKeywords = Utils::getBackendParam('verifyKeywords');
        $smtKeywords    = Utils::getBackendParam('smtKeywords');
        $blockKeywords  = Utils::getBackendParam('blockKeywords');
        
        
        if(is_numeric($aaid)){
            $accountModel   = AgencyAccount::findByPk($aaid);
        }else{
            $accountModel   = new AgencyAccount();
        }
        
        $accountModel->name             = $name;
        $accountModel->account          = $account;
        if($passwd != '******'){
            $accountModel->passwd           = md5($passwd);
        }
        $accountModel->verifyPort       = $verifyPort;
        $accountModel->blockPort        = $blockPort;
        $accountModel->verifyKeywords   = $verifyKeywords;
        $accountModel->smtKeywords      = $smtKeywords;
        $accountModel->blockKeywords    = $blockKeywords;
        
        try{
            $accountModel->save();
            
            $out['resultCode']  = Constant::RESULT_CODE_SUCC;
            $out['msg']         = Constant::RESULT_MSG_SUCC;
            $out['aaid']        = $accountModel->aaid;
        }catch (\Exception $e){
            $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
            $out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
        }
        Utils::jsonOut($out);
    }
    
    
    public function actionAccountDetailResult(){
        $aaid   = Utils::getBackendParam('aaid');
        
        if(!is_numeric($aaid)){
            $out['resultCode']  = Constant::RESULT_CODE_PARAMS_ERR;
            $out['msg']         = Constant::RESULT_MSG_PARAMS_ERR;
            Utils::jsonOut($out);
            return;
        }
        
        $accountModel   = AgencyAccount::findByPk($aaid);
        if($accountModel){
            $out['resultCode']  = Constant::RESULT_CODE_SUCC;
            $out['msg']         = Constant::RESULT_MSG_SUCC;
            
            $item   = $accountModel->toArray();
            $item['passwd']= '******';
            $out['item']    = $item;
            
        }else{
            $out['resultCode']  = Constant::RESULT_CODE_NONE;
            $out['msg']         = Constant::RESULT_MSG_NONE;
        }
        Utils::jsonOut($out);
    }
    
    public function actionAccountDetailView(){
        
        return $this->render('account-detail-view');
    }
    
    public function actionAccountDel(){
        $aaid   = Utils::getBackendParam('aaid');
        
        if(!is_numeric($aaid)){
            $out['resultCode']  = Constant::RESULT_CODE_PARAMS_ERR;
            $out['msg']         = Constant::RESULT_MSG_PARAMS_ERR;
            Utils::jsonOut($out);
            return;
        }
        
        $accountModel   = AgencyAccount::findByPk($aaid);
        if($accountModel){
            try{
                if($accountModel->status == 1){
                    $status = 0;
                }else{
                    $status = 1;
                }
                
                $accountModel->status = $status;
                $accountModel->save();
                $out['resultCode']  = Constant::RESULT_CODE_SUCC;
                $out['msg']         = Constant::RESULT_MSG_SUCC;
                $out['status']      = $status;
            }catch (\Exception $e){
                $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
                $out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
            }
        }else{
            $out['resultCode']  = Constant::RESULT_CODE_NONE;
            $out['msg']         = Constant::RESULT_MSG_NONE;
        }
        Utils::jsonOut($out);
    }
    
    
    
    public function actionStackView(){
        return $this->render('stack-view');
    }
    public function actionStackResult(){
        $stime  = Utils::getBackendParam('stime');
        $etime  = Utils::getBackendParam('etime');
        $mobile = Utils::getBackendParam('mobile');
        $aaid   = Utils::getBackendParam('aaid',0);
        $page   = Utils::getBackendParam('page',1);
        $res    = AgencyStack::findByAaidMobileStimeEtimeNeedPaginator($aaid,$mobile,$stime,$etime,$page);
        $models = $res['models'];
        $pages  = $res['pages'];
        $count  = $res['count'];
        
        if($pages > 0 && $pages >= $page){
            $out['resultCode']  = Constant::RESULT_CODE_SUCC;
            $out['msg']         = Constant::RESULT_MSG_SUCC;
            $out['pages']       = $pages;
            $out['page']        = $page;
            $list   = [];
            foreach ($models as $model){
                $item   = AgencyStack::getItemArrByModel($model);
                $list[] = $item;
            }
            $out['list']    = $list;
        }else{
            if($page > 1){
                $msg    = Constant::RESULT_MSG_NOMORE;
            }else{
                $msg    = Constant::RESULT_MSG_NONE;
            }
            $out['resultCode']  = Constant::RESULT_CODE_NONE;
            $out['msg']         = $msg;
        }
        Utils::jsonOut($out);
    }
}