<?php
namespace backend\controllers;
use common\library\BController;
use common\library\Utils;
use common\models\orm\extend\Merchant;
use common\library\Constant;
use common\models\orm\extend\Admin;

class MerchantController extends BController{
    /*
     * 通道商列表
     */
    public function actionMerchantView(){
        $from   = Utils::getBackendParam('from',1);
        switch ($from){
            case 1:
                $this->layout   = 'pay';
                break;
            case 2:
                $this->layout   = 'register';
                break;
        }
        return $this->render('merchant-view');
    }
    
    /**
     * 通道商
     */
    public function actionMerchantResult(){
        $merchantId = Utils::getBackendParam('merchantId');
        $page = Utils::getBackendParam('page', 1);
        if(is_numeric($merchantId)){
            $res = Merchant::findByIdNeedPaginator($merchantId,$page);
        }else{
            $res = Merchant::findAllNeedPaginator($page);
        }
        if($res['pages'] >= $page && $res['pages'] >0){
            $out['resultCode']  = Constant::RESULT_CODE_SUCC;
            $out['msg']         = Constant::RESULT_MSG_SUCC;
            $out['pages']       = $res['pages'];
            $out['page']        = $page;
             
            $out['list'] = [];
            foreach($res['models'] as $model){
                $item = Merchant::getItemArrByModel($model);
                array_push($out['list'], $item);
            }
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
    

    public function actionGetMerchantInfo(){
        $mid = Utils::getBackendParam('mid');
        $merchantModel = Merchant::findByPk($mid);
        $holders = Admin::getAllAdmins();
        if($merchantModel && $holders){
            $out['item'] = Merchant::getItemArrByModel($merchantModel);
            $out['holders'] = $holders;
            $out['resultCode']  = Constant::RESULT_CODE_SUCC;
            $out['msg']         = Constant::RESULT_MSG_SUCC;
        }else{
            $out['resultCode']  = Constant::RESULT_CODE_NONE;
            $out['msg']         =  Constant::RESULT_MSG_NONE;
        }
        Utils::jsonOut($out);
    }
    
    public function actionMerchantSetSave(){
        $name =Utils::getBackendParam('name');
        $addr = Utils::getBackendParam('addr','0');
        $holder = Utils::getBackendParam('holder');
        $payCircle = Utils::getBackendParam('payCircle');
        $tax = Utils::getBackendParam('tax');
        $memo = Utils::getBackendParam('memo');
        $merchantId = Utils::getBackendParam('mid','');
    
        if(is_numeric($merchantId)){
            $model = Merchant::findByIdAndName($merchantId,$name);
            if($model){
                $out['resultCode']  = Constant::RESULT_CODE_NONE;
                $out['msg']         =  '通道商已存在';
                Utils::jsonOut($out);
                return;
            }
            $merchantModel = Merchant::findByPk($merchantId);
             
        }else{
            $model = Merchant::findByName($name);
            if($model){
                $out['resultCode']  = Constant::RESULT_CODE_NONE;
                $out['msg']         =  '通道商已存在';
                Utils::jsonOut($out);
                return;
            }
            $merchantModel = new Merchant();
        }
        $merchantModel->name = $name;
        $merchantModel->addr = $addr;
        $merchantModel->holder = $holder;
        $merchantModel->payCircle = $payCircle;
        $merchantModel->tax = $tax;
        $merchantModel->payer = 0;
        $merchantModel->memo = $memo;
        $merchantModel->updateTime = time();
        try{
            $merchantModel->oldSave();
            $out['resultCode']  = Constant::RESULT_CODE_SUCC;
            $out['msg']         = Constant::RESULT_MSG_SUCC;
        }catch (\Exception $e){
            $out['resultCode']  = Constant::RESULT_CODE_NONE;
            $out['msg']         =  Constant::RESULT_MSG_NONE;
        }
        Utils::jsonOut($out);
    }
    
    public  function actionHolderResult(){
        $holders = Admin::getAllAdmins();
        if($holders){
            $out['resultCode']  = Constant::RESULT_CODE_SUCC;
            $out['msg']         = Constant::RESULT_MSG_SUCC;
            $out['holders'] = $holders;
        }else{
            $out['resultCode']  = Constant::RESULT_CODE_NONE;
            $out['msg']         =  Constant::RESULT_MSG_NONE;
        }
        Utils::jsonOut($out);
    }
}