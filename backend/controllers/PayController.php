<?php
namespace backend\controllers;
use common\library\BController;
use common\library\Utils;
use common\models\orm\extend\Channel;
use common\library\Constant;

class PayController extends BController{
    public $layout = "pay";
    
    public function actionIndex(){
        return $this->render('index');
    }
    
    public function actionChannelView(){
        return $this->render('channel-view');
    }
    
    public function actionChannelResult(){
        $mid    = Utils::getBackendParam('mid');
        $chid   = Utils::getBackendParam('chid');
        $page   = Utils::getBackendParam('page',1);
        
        
        if(is_numeric($chid) && $chid > 0){
            $channelModel   = Channel::findByPk($chid);
            if($channelModel){
                $res    = array(
                    'pages' => 1,
                    'count' => 1,
                    'models'=> [$channelModel],
                );
            }else{
                $res    = [];
            }
        }elseif (is_numeric($mid) && $mid > 0){
             $res   = Channel::findByMerchantNeedPaginator($mid,$page);
        }else{
            $res    = Channel::findAllNeedPaginator($page);
        }
        
        $models = $res['models'];
        $pages  = $res['pages'];
        $count  = $res['count'];
        if($pages > 0 && $pages >= $page){
            $out['resultCode']  = Constant::RESULT_CODE_SUCC;
            $out['msg']         = Constant::RESULT_MSG_SUCC;
            $out['pages']       = $pages;
            $out['page']        = $page;
            
            $list   = array();
            foreach ($models as $model){
                $item   = Channel::getItemArrByModel($model);   
                $list[] = $item;
            }
            $out['list']    = $list;
        }else{
            if($page > 1){
                $msg    = Constant::RESULT_MSG_NOMORE;
            }else{
                $msg    = Constant::RESULT_MSG_NONE;
            }
            $out['resultCode']  = Constant::RESULT_CODE_SUCC;
            $out['msg']         = $msg;
        }
        Utils::jsonOut($out);
    }
    
    
    
    public function actionCfgIndex(){
        $chid   = Utils::getBackendParam('chid',0);
        $channelModel   = Channel::findByPk($chid);
        switch ($channelModel->devType){
            case CHANNEL_SINGLE:
            case CHANNEL_DOUBLE:
                $this->redirect('/pay/cfg-sdview?chid='.$chid);
                break;
            case CHANNEL_SMSP:
                $this->redirect('/pay/cfg-smsview?chid='.$chid);
                break;
            case CHANNEL_URLP:
                $this->redirect('/pay/cfg-urlview?chid='.$chid);
                break;
        }
    }
    
    public function actionCfgSdView(){
        $chid   = Utils::getBackendParam('chid',0);
    }
    public function actionCfgSmsView(){
        $chid   = Utils::getBackendParam('chid',0);
    }
    public function actionCfgUrlView(){
        $chid   = Utils::getBackendParam('chid',0);
    }
    
    
    
}