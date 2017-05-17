<?php
namespace backend\controllers;

use common\library\Utils;
use common\models\orm\extend\RegChannel;
use common\library\Constant;
use common\models\orm\extend\RegChannelMutex;
use common\models\orm\extend\RegChannelMutexList;
use SebastianBergmann\CodeCoverage\Util;
use common\models\orm\extend\RegProfit;
use common\library\BController;
use common\models\orm\extend\Merchant;
use common\models\orm\extend\Admin;
use common\models\orm\extend\SdkVersion;
class RegisterController extends BController{
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
    	$channelStatusList	= RegChannel::getAllChannelStatus();
        return $this->render('channel-view',array('channelStatusList'=>$channelStatusList));
        
        
    }
    
    public function actionChannelResult(){
        $merchantId = Utils::getBackendParam('merchantId');
        $channelId  = Utils::getBackendParam('channelId');
        $page       = Utils::getBackendParam('page',1);
        $status		= Utils::getBackendParam('status');
        
        if(is_numeric($channelId) && $channelId){
        	$res    = RegChannel::findByChannelNeedPaginator($status,$channelId,$page);
        }elseif (is_numeric($merchantId) && $merchantId){
            $res    = RegChannel::findByMerchantNeedPaginator($status,$merchantId,$page);
        }else{
            $res    = RegChannel::findAllNeedPaginator($status,$page);
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
     
    public function actionAddChannel(){
    	$adminList			= Admin::getAllAdmins();
    	$merchantId			= Utils::getBackendParam('merchantId');
    	$merchantList		= Merchant::findMerchantList();
    	$channelStatusList	= RegChannel::getAllChannelStatus();
    	$channelDevTypeList	= RegChannel::getAllChannelDevType();
    	$sdkVersionList		= SdkVersion::getSdkVersionList();
    	return $this->render('add-channel',array('sdkVersionList'=>$sdkVersionList,'adminList'=>$adminList,'merchantId'=>$merchantId,'merchantList'=>$merchantList,'channelStatusList'=>$channelStatusList,'channelDevTypeList'=>$channelDevTypeList));
    }
    
    public function actionAddChannelResult(){
    	$sign 			= Utils::getBackendParam('sign');
    	$merchant 		= Utils::getBackendParam('merchant');
    	$name 			= Utils::getBackendParam('name');
    	$useMobile 		= Utils::getBackendParam('useMobile');
    	$useUnicom 		= Utils::getBackendParam('useUnicom');
    	$useTelecom	 	= Utils::getBackendParam('useTelecom');
    	$sdkVersion 	= Utils::getBackendParam('sdkVersion');
    	$cutRate 		= Utils::getBackendParam('cutRate');
    	$inPrice 		= Utils::getBackendParam('inPrice');
    	$waitTime 		= Utils::getBackendParam('waitTime');
    	$devType 		= Utils::getBackendParam('devType');
    	$status 		= Utils::getBackendParam('status');
    	$priorityRate 	= Utils::getBackendParam('priorityRate');
    	$remark 		= Utils::getBackendParam('remark');
    	$holder 		= Utils::getBackendParam('holder');
    	
    	if(empty($name) || empty($sign)){
    		$out['resultCode']  = Constant::RESULT_CODE_NONE;
    		$out['msg']         = Constant::RESULT_MSG_PARAMS_ERR;
    	}else{
  			$res = RegChannel::addChannel($sign, $merchant, $name, $useMobile, $useUnicom, $useTelecom, $sdkVersion, $cutRate, $inPrice, $waitTime, $devType, $status, $priorityRate, $remark,$holder);
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
    public function actionUpdateChannel(){
    	$rcid				= Utils::getBackendParam('rcid');
    	if(!$rcid){
    		$this->redirect('channel-view');
    	}
    	$adminList			= Admin::getAllAdmins();
    	$merchantList		= Merchant::findMerchantList();
    	$regChannel			= RegChannel::findByPk($rcid);
    	$channelStatusList	= RegChannel::getAllChannelStatus();
    	$channelDevTypeList	= RegChannel::getAllChannelDevType();
    	$sdkVersionList		= SdkVersion::getSdkVersionList();
     	return $this->render('update-channel',array('sdkVersionList'=>$sdkVersionList,'adminList'=>$adminList,'merchantList'=>$merchantList,'regChannel'=>$regChannel,'channelStatusList'=>$channelStatusList,'channelDevTypeList'=>$channelDevTypeList));
    }
    public function actionUpdateChannelResult(){
    	$rcid			= Utils::getBackendParam('rcid');
    	$merchant 		= Utils::getBackendParam('merchant');
    	$name 			= Utils::getBackendParam('name');
    	$useMobile 		= Utils::getBackendParam('useMobile');
    	$useUnicom 		= Utils::getBackendParam('useUnicom');
    	$useTelecom	 	= Utils::getBackendParam('useTelecom');
    	$sdkVersion 	= Utils::getBackendParam('sdkVersion');
    	$cutRate 		= Utils::getBackendParam('cutRate');
    	$inPrice 		= Utils::getBackendParam('inPrice');
    	$waitTime 		= Utils::getBackendParam('waitTime');
    	$devType 		= Utils::getBackendParam('devType');
    	$status 		= Utils::getBackendParam('status');
    	$priorityRate 	= Utils::getBackendParam('priorityRate');
    	$remark 		= Utils::getBackendParam('remark');
    	$holder 		= Utils::getBackendParam('holder');
    	 
    	if(empty($name) || empty($rcid)){
    		$out['resultCode']  = Constant::RESULT_CODE_NONE;
    		$out['msg']         = Constant::RESULT_MSG_PARAMS_ERR;
    	}else{
    		$res = RegChannel::updateChannel($rcid, $merchant, $name, $useMobile, $useUnicom, $useTelecom, $sdkVersion, $cutRate, $inPrice, $waitTime, $devType, $status, $priorityRate, $remark,$holder);
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
    			$res = RegChannelMutexList::findChannelMutexByRcmid($channelMutexId);
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
    			$out['resultCode']  = Constant::RESULT_CODE_SUCC;
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
     * 停用/启用通道组
     */
    public function  actionChangeMutexStatus(){
    		$rcmid = Utils::getBackendParam('rcmid');
    		$out['resultCode']  = Constant::RESULT_CODE_NONE;
    		$out['msg']         = Constant::RESULT_MSG_PARAMS_ERR;
    		if(is_numeric($rcmid)){
    			$res = RegChannelMutex::changeMutexStatusById($rcmid);
    			if($res){
    				$out['resultCode']  = Constant::RESULT_CODE_SUCC;
    				$out['msg']         = Constant::RESULT_MSG_SUCC;
    			}
    		}
    		Utils::jsonOut($out);
    }
    
    /**
     * 添加通道到通道组
     */
    public function actionAddChannelToMutex(){
    		$rcid = Utils::getBackendParam('rcid');
    		$rcmid = Utils::getBackendParam('rcmid');
    		$out['resultCode']  = Constant::RESULT_CODE_NONE;
    		$out['msg']         = Constant::RESULT_MSG_PARAMS_ERR;
    		$channelModel = RegChannel::findByPk($rcid);
    		if($channelModel){
    			$res = RegChannelMutexList::addChannelToMutex($rcid, $rcmid);
    			if($res['resultCode']){
    				$out['resultCode']  = Constant::RESULT_CODE_SUCC;
    				$out['msg']         = Constant::RESULT_MSG_SUCC;
    			}else{
    				$out['msg']  =$res['msg'];
    			}
    		}
    		Utils::jsonOut($out);
    }
    
    /**
     * 改变通道组中通道的状态
     * regChannelMutexList
     */
    public  function actionChangeMutexListStatus(){
    		$rcmlid = Utils::getBackendParam('rcmlid');
    		$out['resultCode']  = Constant::RESULT_CODE_NONE;
    		if(is_numeric($rcmlid)){
    			$res = RegChannelMutexList::changeStatusById($rcmlid);
    			if($res){
    				$item = RegChannelMutexList::getItemArrByModel(RegChannelMutexList::findByPk($rcmlid));
    				$out['resultCode']  = Constant::RESULT_CODE_SUCC;
    				$out['msg']         = Constant::RESULT_MSG_SUCC;
    				$out['item'] = $item;
    			}else{
    				$out['msg']         = Constant::RESULT_MSG_PARAMS_ERR;
    			}
    		}else{
    			$out['msg']   = Constant::RESULT_MSG_PARAMS_ERR;
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
    	$checkMerchant 	= Utils::getBackendParam('checkMerchant');
    	$channel 		= Utils::getBackendParam('channel');
    	$merchant 		= Utils::getBackendParam('merchant');
    	$data = RegProfit::findProfitList($stime, $etime, $checkChannel, $checkMerchant, $channel, $merchant);
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