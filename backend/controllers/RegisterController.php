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

use yii\base\Object;
use common\models\orm\extend\Merchant;
use common\models\orm\extend\Admin;
use Behat\Gherkin\Exception\Exception;
use common\models\orm\extend\SdkVersion;

use common\models\orm\extend\RegOrder;
use common\models\orm\extend\RegChannelVerifyRule;
use common\models\orm\extend\RegOrderReport;
use common\models\orm\extend\App;
use common\models\orm\extend\Campaign;
use common\models\orm\extend\CampaignPackage;
use common\models\orm\extend\RegSwitch;
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
    		}catch (Exception $e){
    			$out['resultCode']  = Constant::RESULT_CODE_NONE;
    			$out['msg']         =  Constant::RESULT_MSG_NONE;
    		}
    		Utils::jsonOut($out);
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
     
    public function actionDetailChannelResult(){
    	$rcid	= Utils::getBackendParam('rcid');
    	$out	= array();
    	if(!$rcid || !is_numeric($rcid)){
    		$out['resultCode']  = Constant::RESULT_CODE_NONE;
    		$out['msg']         = Constant::RESULT_MSG_PARAMS_ERR;
    	}else{
    		$regChannel				= RegChannel::findByPk($rcid);
    		$regChannelVerifyRule	= RegChannelVerifyRule::findAllByRcid($rcid);
    		if(!$regChannel){
    			 $out['resultCode']  = Constant::RESULT_CODE_NONE;
    			 $out['msg']         = Constant::RESULT_MSG_NONE;
    		}else{
     			$out['resultCode']  = Constant::RESULT_CODE_SUCC;
    			$out['msg']         = Constant::RESULT_MSG_SUCC;
    			$out['item']        = $regChannel->toArray();
    			$out['channelVerifyRule']	= $regChannelVerifyRule;
    		}
    		
    	}
    	Utils::jsonOut($out);
    }
    
    public function actionSaveChannelView(){
    	$adminList			= Admin::getAllAdmins();
    	$merchantList		= Merchant::findMerchantList();
     	$channelStatusList	= RegChannel::getAllChannelStatus();
    	$channelDevTypeList	= RegChannel::getAllChannelDevType();
    	$sdkVersionList		= SdkVersion::getSdkVersionList();
    	return $this->render('save-channel-view',array('sdkVersionList'=>$sdkVersionList,'adminList'=>$adminList,'merchantList'=>$merchantList,'channelStatusList'=>$channelStatusList,'channelDevTypeList'=>$channelDevTypeList));
    }
    
    public function actionSaveChannelResult(){
    	$rcid			= Utils::getBackendParam('rcid');
    	$sign 			= Utils::getBackendParam('sign');
    	$merchant 		= Utils::getBackendParam('merchant');
    	$name 			= Utils::getBackendParam('name');
    	$useMobile 		= Utils::getBackendParam('useMobile');
    	$useUnicom 		= Utils::getBackendParam('useUnicom');
    	$useTelecom	 	= Utils::getBackendParam('useTelecom');
    	$sdkVersion 	= Utils::getBackendParam('sdkVersion');
    	$cutRate 		= Utils::getBackendParam('cutRate',100);
    	$inPrice 		= Utils::getBackendParam('inPrice');
    	$waitTime 		= Utils::getBackendParam('waitTime',10);
    	$devType 		= Utils::getBackendParam('devType');
    	$status 		= Utils::getBackendParam('status');
    	$priorityRate 	= Utils::getBackendParam('priorityRate',100);
    	$remark 		= Utils::getBackendParam('remark');
    	$holder 		= Utils::getBackendParam('holder');
    	
    	$type0 			= Utils::getBackendParam('type0');
    	$portType0 		= Utils::getBackendParam('portType0');
    	$keys1Type0		= Utils::getBackendParam('keys1Type0');
    	$keys2Type0		= Utils::getBackendParam('keys2Type0');
    	$keys3Type0 	= Utils::getBackendParam('keys3Type0');
    	$statusType0	= Utils::getBackendParam('statusType0');
    	$type1			= Utils::getBackendParam('type1');
    	$portType1 		= Utils::getBackendParam('portType1');
    	$keys1Type1		= Utils::getBackendParam('keys1Type1');
    	$keys2Type1		= Utils::getBackendParam('keys2Type1');
    	$keys3Type1 	= Utils::getBackendParam('keys3Type1');
    	$statusType1	= Utils::getBackendParam('statusType1');
    	
    	if(empty($name) || empty($sign)){
    		$out['resultCode']  = Constant::RESULT_CODE_NONE;
    		$out['msg']         = Constant::RESULT_MSG_PARAMS_ERR;
    	}else{
    	    $signCheck = RegChannel::signUsed($sign,$rcid);
    	    if($signCheck){
    	        $out['resultCode'] = Constant::RESULT_CODE_PARAMS_ERR;
    	        $out['msg']        = '该代码标识已被使用，请重新命名';
    	        Utils::jsonOut($out);
    	        return;
    	    }
    	    $db    = RegChannel::getDb()->beginTransaction();
    	    try{
    	        //channel
    	        if($rcid > 0){
    	            $regChannelModel   = RegChannel::findByPk($rcid);
    	        }else{
    	            $regChannelModel   = new RegChannel();
    	        }
    	        	
    	        $regChannelModel->sign			= $sign;
    	        $regChannelModel->merchant		= $merchant;
    	        $regChannelModel->name			= $name;
    	        $regChannelModel->useMobile		= $useMobile;
    	        $regChannelModel->useUnicom		= $useUnicom;
    	        $regChannelModel->useTelecom	= $useTelecom;
    	        $regChannelModel->sdkVersion	= $sdkVersion;
    	        $regChannelModel->cutRate		= $cutRate;
    	        $regChannelModel->inPrice		= $inPrice;
    	        $regChannelModel->waitTime		= $waitTime;
    	        $regChannelModel->devType		= $devType;
    	        $regChannelModel->status		= $status;
    	        $regChannelModel->priorityRate	= $priorityRate;
    	        $regChannelModel->remark		= $remark;
    	        $regChannelModel->holder		= $holder;
    	        $regChannelModel->save();
    	        //channel verify rule 0
    	        $regChannelVerifyRule0Model    = RegChannelVerifyRule::findByRcidAndType($rcid, 0);
    	        if(!$regChannelVerifyRule0Model){
    	            $regChannelVerifyRule0Model    = new RegChannelVerifyRule();
    	            $regChannelVerifyRule0Model->type  = 0;
    	        }
    	        $regChannelVerifyRule0Model->rcid  = $regChannelModel->rcid;
    	        $regChannelVerifyRule0Model->port	= $portType0;
    	        $regChannelVerifyRule0Model->keys1	= $keys1Type0;
    	        $regChannelVerifyRule0Model->keys2	= $keys2Type0;
    	        $regChannelVerifyRule0Model->keys3	= $keys3Type0;
    	        $regChannelVerifyRule0Model->status	= $statusType0;
    	        $regChannelVerifyRule0Model->save();
    	        	
    	        //channel verify rule 1
    	        if($devType > Constant::CHANNEL_DOUBLE){
    	            $regChannelVerifyRule1Model    = RegChannelVerifyRule::findByRcidAndType($rcid, 1);
    	            if(!$regChannelVerifyRule1Model){
    	                $regChannelVerifyRule1Model    = new RegChannelVerifyRule();
    	                $regChannelVerifyRule1Model->type  = 1;
    	            }
    	            $regChannelVerifyRule1Model->rcid   = $regChannelModel->rcid;
    	            $regChannelVerifyRule1Model->port	= $portType1;
    	            $regChannelVerifyRule1Model->keys1	= $keys1Type1;
    	            $regChannelVerifyRule1Model->keys2	= $keys2Type1;
    	            $regChannelVerifyRule1Model->keys3	= $keys3Type1;
    	            $regChannelVerifyRule1Model->status	= $statusType1;
    	            $regChannelVerifyRule1Model->save();
    	        }
    	        
    	        $db->commit();
    	        
    	        $out['resultCode'] = Constant::RESULT_CODE_SUCC;
    	        $out['msg']        = Constant::RESULT_MSG_SUCC;
    	    }catch (\Exception $e){
    	        $db->rollBack();
    	        
    	        $out['resultCode'] = Constant::RESULT_CODE_SYSTEM_BUSY;
    	        $out['msg']        = Constant::RESULT_MSG_SYSTEM_BUSY;
    	        $out['msg']        = $e->getMessage();
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
    			$res = RegChannelMutex::findByIdNeedPaginator($channelMutexId, $page);
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

    public function actionMutexDetail(){
    		$rcmid = Utils::getBackendParam('rcmid');
    		if(is_numeric($rcmid)){
    			$model = RegChannelMutex::findByPk($rcmid);
    			if($model){
    				$item = RegChannelMutex::getItemArrByModel($model);
    				$out['resultCode']  = Constant::RESULT_CODE_SUCC;
    				$out['msg']         = Constant::RESULT_MSG_SUCC;
    				$out['item'] = $item;
    			}else{
    				$out['resultCode']  = Constant::RESULT_CODE_NONE;
    				$out['msg']         = Constant::RESULT_MSG_PARAMS_ERR;
    			}
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
     * 添加/修改通道组
     */
    public function actionSaveMutex(){
    		$rcmid = Utils::getBackendParam('rcmid');
    		 $mutexName = Utils::getBackendParam('mutexName');
    		 $mutexStatus = Utils::getBackendParam('mutexStatus', 0);
    		 if(is_numeric($rcmid)){
    		 	$mutexModel = RegChannelMutex::findByPk($rcmid);
    		 }else{
    		 	$mutexModel = new RegChannelMutex();
    		 }
    		 $mutexModel->name = $mutexName;
    		 $mutexModel->status = $mutexStatus;
    		 try{
    		 	$mutexModel->save();
    		 
    		 	$out['resultCode']  = Constant::RESULT_CODE_SUCC;
    		 	$out['msg']         = Constant::RESULT_MSG_SUCC;
    		 	$out['rcmid']        = $mutexModel->rcmid;
    		 }catch (\Exception $e){
    		 	$out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
    		 	$out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
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
    
    
    /*
     * 注册记录查询
     */
    public function actionOrderView(){
        return $this->render('/register/order-view');
    }
    
    public function actionOrderResult(){
        $stime 			= Utils::getBackendParam('stime');
        $etime 			= Utils::getBackendParam('etime');
        $rcid           = Utils::getBackendParam('rcid');
        $mobileImsi     = Utils::getBackendParam('mobile-imsi');
        $page           = Utils::getBackendParam('page',1);
        $res    = RegOrder::findByStimeEtimeRcidMobileImsiNeedPaginator($stime,$etime,$rcid,$mobileImsi,$page);
        
        $pages  = $res['pages'];
        $count  = $res['count'];
        $models = $res['models'];
        
        if($pages > 0 && $pages >= $page){
            $out['resultCode']  = Constant::RESULT_CODE_SUCC;
            $out['msg']         = Constant::RESULT_MSG_SUCC;
            $out['pages']       = $pages;
            $out['page']        = $page;
            
            $list   = [];
            foreach ($models as $model){
                $item   = RegOrder::getItemArrByModel($model);
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

    public function actionOrderDel(){
        $roid   = Utils::getBackendParam('roid');
        
        $regOrderModel  = RegOrder::findByPk($roid);
        if($regOrderModel){
          try{
              $regOrderModel->delete();
              $out['resultCode']    = Constant::RESULT_CODE_SUCC;
              $out['msg']           = Constant::RESULT_MSG_SUCC;
          }catch (\Exception $e){
              $out['resultCode']    = Constant::RESULT_CODE_SYSTEM_BUSY;
              $out['msg']           = Constant::RESULT_MSG_SYSTEM_BUSY;
          }
        }else{
            $out['resultCode']  = Constant::RESULT_CODE_NONE;
            $out['msg']         = Constant::RESULT_MSG_NONE;
        }
        Utils::jsonOut($out);
    }
    
    
    public function actionOrderReportView(){
        return $this->render('order-report-view');
    }
    
    public function actionOrderReportResult(){
        $stime 			= Utils::getBackendParam('stime');
        $etime 			= Utils::getBackendParam('etime');
        $rcid           = Utils::getBackendParam('rcid');
        $mobileImsi     = Utils::getBackendParam('mobile-imsi');
        $page           = Utils::getBackendParam('page',1);
        
        $res    = RegOrderReport::findByStimeEtimeRcidMobileImsiNeedPaginator($stime,$etime,$rcid,$mobileImsi,$page);
        
        $pages  = $res['pages'];
        $count  = $res['count'];
        $models = $res['models'];
        
        if($pages > 0 && $pages >= $page){
            $out['resultCode']  = Constant::RESULT_CODE_SUCC;
            $out['msg']         = Constant::RESULT_MSG_SUCC;
            $out['pages']       = $pages;
            $out['page']        = $page;
        
            $list   = [];
            foreach ($models as $model){
                $item   = RegOrderReport::getItemArrByModel($model);
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
        
    public function actionCampaignView(){
    	return $this->render('campaign-view');
    }
    
    public function actionCampaignResult(){
    	$app 		= Utils::getBackendParam('app');
    	$page       = Utils::getBackendParam('page',1);
    	$res		= Campaign::findAllNeedPaginator($app,$page);
    	$pages  	= $res['pages'];
    	$models 	= $res['models'];
    	if($pages >= $page && $pages > 0){
    		$out['resultCode']  = Constant::RESULT_CODE_SUCC;
    		$out['msg']         = Constant::RESULT_MSG_SUCC;
    		$out['pages']       = $pages;
    		$out['page']        = $page;
     		$list   = array();
    		foreach ($models as $model){
    			$list[]   = Campaign::getItemArrByModel($model);
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
    
    public function actionGetAppByPartnerResult(){
    	$res 		= array();
    	$partner  	= Utils::getBackendParam('partner');
    	if(!is_numeric($partner) || !$partner){
    		$res['resultCode']  = Constant::RESULT_CODE_NONE;
    		$res['msg']  		= Constant::RESULT_MSG_PARAMS_ERR;
    		Utils::jsonOut($res);exit();
    	}
    	$list		= App::findByPartner($partner);
    	if(!$list){
    		$res['resultCode']  = Constant::RESULT_CODE_NONE;
    		$res['msg']  		= Constant::RESULT_MSG_NONE;
    		Utils::jsonOut($res);exit();
    	}
    	$res['resultCode']  = Constant::RESULT_CODE_SUCC;
    	$res['msg']         = Constant::RESULT_MSG_SUCC;
    	$res['list']        = $list;
    	Utils::jsonOut($res);
    }
    
    public function actionCampaignPackageView(){
    	return $this->render('campaign-package-view');
    }
    
    public function actionCampaignPackageResult(){
    	$campaignId	= Utils::getBackendParam('campaignId');
    	if(!is_numeric($campaignId) || !$campaignId){
    		$out['resultCode']  = Constant::RESULT_CODE_NONE;
    		$out['msg']         = Constant::RESULT_MSG_PARAMS_ERR;
    		Utils::jsonOut($out);exit();
    	}
    	$page       = Utils::getBackendParam('page',1);
    	$res		= CampaignPackage::findAllNeedPaginator($campaignId,$page);
    	$pages  	= $res['pages'];
    	$models 	= $res['models'];
    	if($pages >= $page && $pages > 0){
    		$out['resultCode']  = Constant::RESULT_CODE_SUCC;
    		$out['msg']         = Constant::RESULT_MSG_SUCC;
    		$out['pages']       = $pages;
    		$out['page']        = $page;
    		$list   = array();
    		foreach ($models as $model){
    			$list[]   = CampaignPackage::getItemArrByModel($model);
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
    
    public function actionSwitchResult(){
    	$campaignPackageId	= Utils::getBackendParam('campaignPackageId');
    	if(!is_numeric($campaignPackageId) || !$campaignPackageId){
    		$out['resultCode']  = Constant::RESULT_CODE_NONE;
    		$out['msg']         = Constant::RESULT_MSG_PARAMS_ERR;
    		Utils::jsonOut($out);exit();
    	}
    	$regSwitchModel		= RegSwitch::findByCampaignPackage($campaignPackageId);
     	if(!$regSwitchModel){
    		$out['resultCode']  = Constant::RESULT_CODE_NONE;
    		$out['msg']         = Constant::RESULT_MSG_NONE;
    	}else{
     		$out['resultCode']  = Constant::RESULT_CODE_SUCC;
    		$out['msg']         = Constant::RESULT_MSG_SUCC;
    		$out['item']        = $regSwitchModel->toArray();
    	}
    	Utils::jsonOut($out);
    }
    
    public function actionSaveSwitchResult(){
    	$campaignPackageId	= Utils::getBackendParam('campaignPackageId');
    	$stime				= Utils::getBackendParam('stime');
    	$etime				= Utils::getBackendParam('etime');
    	$status				= Utils::getBackendParam('status');
    	if(!is_numeric($campaignPackageId) || !$campaignPackageId){
    		$out['resultCode']  = Constant::RESULT_CODE_NONE;
    		$out['msg']         = Constant::RESULT_MSG_PARAMS_ERR;
    		Utils::jsonOut($out);exit();
    	}
    	$regSwitchModel		= RegSwitch::findByCampaignPackage($campaignPackageId);
    	if(!$regSwitchModel){
    		$regSwitchModel	= new RegSwitch();
    		$regSwitchModel->campaignPackageId	= $campaignPackageId;
    		$regSwitchModel->stime				= $stime;
    		$regSwitchModel->etime				= $etime;
    		$regSwitchModel->status				= $status;
    		$regSwitchModel->recordTime			= Utils::getNowTime();
    		$res = $regSwitchModel->save();
    		if(!$res){
    			$out['resultCode']  = Constant::RESULT_CODE_NONE;
    			$out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
    			Utils::jsonOut($out);exit();
    		}
    	}else{
     		$regSwitchModel->stime				= $stime;
    		$regSwitchModel->etime				= $etime;
    		$regSwitchModel->status				= $status;
     		$res = $regSwitchModel->save();
    		if(!$res){
    			$out['resultCode']  = Constant::RESULT_CODE_NONE;
    			$out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
    			Utils::jsonOut($out);exit();
    		}
    	}
    	$out['resultCode']  = Constant::RESULT_CODE_SUCC;
    	$out['msg']         = Constant::RESULT_MSG_SUCC;
    	Utils::jsonOut($out);
    }
    
    public function actionCampaignPackageBarResult(){
    	$campaignId	= Utils::getBackendParam('campaignId');
    	if(!is_numeric($campaignId) || !$campaignId){
    		$out['resultCode']  = Constant::RESULT_CODE_NONE;
    		$out['msg']         = Constant::RESULT_MSG_PARAMS_ERR;
    		Utils::jsonOut($out);exit();
    	}
    	$regCampaign		= Campaign::findPartnerAppbyCampaign($campaignId);
    	if(!$regCampaign){
    		$out['resultCode']  = Constant::RESULT_CODE_NONE;
    		$out['msg']         = Constant::RESULT_MSG_NONE;
    	}else{
    		$out['resultCode']  = Constant::RESULT_CODE_SUCC;
    		$out['msg']         = Constant::RESULT_MSG_SUCC;
    		$out['item']        = $regCampaign;
    	}
    	Utils::jsonOut($out);
    }
    
}