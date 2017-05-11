<?php
namespace backend\controllers;

use yii\base\Controller;
use common\library\Utils;
use common\models\orm\extend\RegChannel;
use common\library\Constant;
use common\models\orm\extend\RegChannelMutex;
use common\models\orm\extend\RegChannelMutexList;
use common\models\orm\extend\RegProfit;
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
    
    public function actionChannelResult(){
        $merchantId = Utils::getBackendParam('merchantId');
        $channelId  = Utils::getBackendParam('channelId');
        $page       = Utils::getBackendParam('page',1);
        
        if(is_numeric($channelId)){
            
        }elseif (is_numeric($merchantId)){
            $res    = RegChannel::findByMerchantNeedPaginator($merchantId,$page);
        }else{
            $res    = RegChannel::findAllNeedPaginator($page);
        }
        $pages  = $res['pages'];
        $models = $res['models'];
        if($pages >= $page && $pages > 0){
            $out['resultCode']  = Constant::RESULT_CODE_SUCC;
            $out['msg']         = Constant::RESULT_MSG_SUCC;
            $out['pages']       = $pages;
            $out['page']        = $page;
            
            $list   = array();
            foreach ($models as $model){
                $item   = RegChannel::getItemArrByModel($model);
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
    
    public function actionMutexView(){
        return $this->render('mutex-view');
    }
    
    public function actionMutexResult(){
    		$channelMutexId = Utils::getBackendParam('channelMutexId');
    		$page       = Utils::getBackendParam('page',1);
    		
    		if(is_numeric($channelMutexId)){
    			
    		}else{
    			$res = RegChannelMutex::findAllNeedPaginator($page);
    		}
    		$pages  = $res['pages'];
    		$models = $res['models'];
    		if($pages >= $page && $pages > 0){
    			$out['resultCode']  = Constant::RESULT_CODE_SUCC;
    			$out['msg']         = Constant::RESULT_MSG_SUCC;
    			$out['pages']       = $pages;
    			$out['page']        = $page;
    		
    			$list   = array();
    			foreach ($models as $model){
    				$item   = RegChannelMutex::getItemArrByModel($model);
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
    
    public function actionMutexlistResult(){
    		$channelMutexId = Utils::getBackendParam('rcmid');
    		
    		if(is_numeric($channelMutexId)){
    			$res = RegChannelMutexList::findChannelMutexById($channelMutexId);
    		}else{
    			
    		}
    		if($res['models']){
    			$out['resultCode']  = Constant::RESULT_CODE_SUCC;
    			$out['msg']         = Constant::RESULT_MSG_SUCC;
    			$list = [];
    			foreach ($res['models'] as $model){
    				$item = RegChannelMutexList::getItemArrByModel($model);
    				array_push($list, $item);
    			}
    			$out['list']    = $list;
    		}else{
    			$out['resultCode']  = Constant::RESULT_CODE_NONE;
    			$out['msg']         = Constant::RESULT_MSG_NONE;
    		}
    		Utils::jsonOut($out);
    }

    /**
     * 添加通道组
     */
    public function actionAddMutex(){
    		 $mutexName = Utils::getBackendParam('mutexName');
    		 $mutexStatus = Utils::getBackendParam('mutexStatus', 0);
    		 if(empty($mutexName) || !is_numeric($mutexStatus)){
    		 	$out['resultCode']  = Constant::RESULT_CODE_NONE;
    		 	$out['msg']         = Constant::RESULT_MSG_PARAMS_ERR;
    		 }else{
    		 	$params = [
    		 		'name' => $mutexName,
    		 		'status' => $mutexStatus	
    		 	];
    		 	$res = RegChannelMutex::addMutex($params);
    		 	if($res){
    		 		$out['resultCode']  = Constant::RESULT_CODE_SUCC;
    		 		$out['msg']         = Constant::RESULT_MSG_SUCC;
    		 	}else{
    		 		$out['resultCode']  = Constant::RESULT_CODE_NONE;
    		 		$out['msg']         = Constant::RESULT_MSG_PARAMS_ERR;
    		 	}
    		 }
    		 Utils::jsonOut($out);
    		 
    }
    
    
    
    
    

    /**
     * 通道收益
     */
    public function actionProfitChannelView(){
        return $this->render('profit-channel-view');
    }
     
    public function actionProfitChannelResult(){
    	$stime 			= Utils::getBackendParam('stime');
    	$etime 			= Utils::getBackendParam('etime');
    	$checkChannel 	= Utils::getBackendParam('checkChannel');
    	$data = RegProfit::findByTime($stime, $etime, $checkChannel);
    	if($data){
    		$res['resultCode']  = Constant::RESULT_CODE_SUCC;
    		$res['msg']         = Constant::RESULT_MSG_SUCC;
    		$res['data']        = $data;
    	}else{
    		$res['resultCode']  = Constant::RESULT_CODE_NONE;
    		$res['msg']         = constant::RESULT_MSG_NONE;
    		$res['data']        = '';
    	}
    	Utils::jsonOut($res);die();
    }
    
    
}