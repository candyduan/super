<?php
namespace backend\controllers;
use common\library\BController;
use common\library\Utils;
use common\models\orm\extend\ChannelCfgToSync;
use common\models\orm\extend\Channel;
use common\models\orm\extend\DeveloperChannelCount;
use common\library\Constant;
use common\models\orm\extend\ChannelCfgMain;
use common\models\orm\extend\ChannelCfgPayParams;
use common\models\orm\extend\ChannelCfgSdNapi;
use common\models\orm\extend\ChannelCfgSdYapi;
use common\models\orm\extend\ChannelCfgSync;
use common\models\orm\extend\ChannelCfgSd;
use common\models\orm\extend\ChannelCfgSms;
use common\models\orm\extend\ChannelCfgSmtParams;
use common\models\orm\extend\ChannelCfgSmsYapi;
use common\models\orm\extend\ChannelCfgSmsNapi;
use common\models\orm\extend\ChannelCfgSmsSubmit;
use common\models\orm\extend\ChannelCfgUrl;
use common\models\orm\extend\ChannelCfgUrlYapi;
use common\models\orm\extend\ChannelCfgUrlSubmit;
use common\models\orm\extend\ChannelCfgOut;
use common\models\orm\extend\ChannelCfgPaySign;
use common\models\orm\extend\ChannelCfgSmtSign;
use common\models\orm\extend\ChannelCfgSmsSdkSubmit;
use common\models\orm\extend\ChannelCfgUrlSdkSubmit;
use common\models\orm\extend\ChannelGroup;
use common\models\orm\extend\ChannelCfgDialtest;
use common\models\orm\extend\ChannelVerifyRule;
use common\models\orm\extend\TimeLimit;
use common\models\orm\extend\TimeProvinceLimit;
use common\models\orm\extend\Province;
use common\models\orm\extend\ChannelPrice;
use common\library\ShortHash;
use common\models\orm\extend\ChannelProvincePrice;
use common\models\orm\extend\ChannelMonitorRule;
use backend\library\cache\OrigApi;

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
        $channelStatus = Utils::getBackendParam('channelStatus','-1');
        
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
             $res   = Channel::findByMerchantStatusNeedPaginator($mid,$channelStatus,$page);
        }else{
            $res    = Channel::findByStatusNeedPaginator($channelStatus,$page);
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
            $out['resultCode']  = Constant::RESULT_CODE_NONE;
            $out['msg']         = $msg;
        }
        Utils::jsonOut($out);
    }
    
    public function actionCfgSdView(){        
        $chid   = Utils::getBackendParam('chid',0);
        $channelModel       = Channel::findByPk($chid);
        $mainModel          = ChannelCfgMain::findByChannelId($chid);
        $payParamsModel     = ChannelCfgPayParams::findByChannelId($chid);
        $sdModel            = ChannelCfgSd::findByChannelId($chid);
        $sdNApiModel        = ChannelCfgSdNapi::findByChannelId($chid);
        $sdYApiModel        = ChannelCfgSdYapi::findByChannelId($chid);
        $syncModel          = ChannelCfgSync::findByChannelId($chid);
        $outModel           = ChannelCfgOut::findByChannelId($chid);
        $channelCfgToSync   = ChannelCfgToSync::findByChannelId($chid);
        $DialtestModel 		= ChannelCfgDialtest::findByChannelId($chid);
        $data   = array(
            'chid'              => $chid,
            'channelModel'      => $channelModel,
            'mainModel'         => $mainModel,
            'payParamsModel'    => $payParamsModel,
            'sdModel'           => $sdModel,
            'sdNApiModel'       => $sdNApiModel,
            'sdYApiModel'       => $sdYApiModel,
            'syncModel'         => $syncModel,
            'outModel'          => $outModel,
        	'channelCfgToSync'  => $channelCfgToSync,
        	'DialtestModel'		=> $DialtestModel,
        );
        
        return $this->render('cfg-sd-view',$data);
    }
    public function actionCfgSdNapiSave(){
        $chid       = Utils::getBackendParam('chid',0);
        $useapi     = Utils::getBackendParam('useapi');
        $needExt    = Utils::getBackendParam('needExt',0);
        $sms1Arr    = json_decode(Utils::getBackendParam('sms1'),true);
        $sms2Arr    = json_decode(Utils::getBackendParam('sms2'),true);
        
        $channelModel   = Channel::findByPk($chid);
        if($channelModel){
            $sdNApiModel   = ChannelCfgSdNapi::findByChannelId($chid);
            if(!$sdNApiModel){
                $sdNApiModel   = new ChannelCfgSdNapi();
                $sdNApiModel->channelId    = $chid;
            }
            $sdNApiModel->needExt   = $needExt;
            if(count($sms1Arr) > 0){
                $sms1   = array();
                foreach ($sms1Arr as $item){
                    $sms1[$item['fee']] = array(
                        'spnumber'      => $item['spnumber'],
                        'cmd'           => $item['cmd'],
                        'sendtype'      => $item['sendtype'],
                        //'ext'           => $item['ext']?:0,
                    );
                }
                $sms1   = json_encode($sms1);
            }else{
                $sms1   = '';
            }
            $sdNApiModel->sms1             = $sms1;
        
            if(count($sms2Arr) > 0){
                $sms2   = array();
                foreach ($sms2Arr as $item){                   
                    $sms2[$item['fee']] = array(
                        'spnumber'      => $item['spnumber'],
                        'cmd'           => $item['cmd'],
                        'sendtype'      => $item['sendtype'],
                        //'ext'           => $item['ext']?:0,
                    );
                }
                $sms2   = json_encode($sms2);
            }else{
                $sms2   = '';
            }
            $sdNApiModel->sms2             = $sms2;
        
            try{
                ChannelCfgMain::backendOps($chid);
                ChannelCfgSd::backendOps($chid,$useapi);
                
                $sdNApiModel->save();
                
                $out['resultCode']  = Constant::RESULT_CODE_SUCC;
                $out['msg']         = '保存成功';
            }catch (\Exception $e){
                $out['resultCode']  = SYSTEM_BUSY;
                $out['msg']         = '保存失败，请稍后重试！';
            }
        }else{
            $out['resultCode'] = Constant::RESULT_CODE_NONE;
            $out['msg']        = '该通道不存在';
        }
        Utils::jsonOut($out);
    }
    
    public function actionCfgSdYapiSave(){
        $chid               = Utils::getBackendParam('chid');
        $useapi             = Utils::getBackendParam('useapi');
        $spnumberKey1       = Utils::getBackendParam('spnumberKey1');
        $cmdKey1            = Utils::getBackendParam('cmdKey1');
        $sendType1          = Utils::getBackendParam('sendType1');
        $spnumberKey2       = Utils::getBackendParam('spnumberKey2');
        $cmdKey2            = Utils::getBackendParam('cmdKey2');
        $sendType2          = Utils::getBackendParam('sendType2');
        $sendInterval       = Utils::getBackendParam('sendInterval');
        $succKey            = Utils::getBackendParam('succKey');
        $succValue          = Utils::getBackendParam('succValue');
        $orderIdKey         = Utils::getBackendParam('orderIdKey');
        $url                = Utils::getBackendParam('url');
        $sendMethod         = Utils::getBackendParam('sendMethod');
        $respFmt            = Utils::getBackendParam('respFmt');
        $delimiter          = Utils::getBackendParam('delimiter');
        $respHandle         = Utils::getBackendParam('respHandle');
        
        $channelModel   = Channel::findByPk($chid);
        if($channelModel){
            $sdYApiModel   = ChannelCfgSdYapi::findByChannelId($chid);
            if(!$sdYApiModel){
                $sdYApiModel   = new ChannelCfgSdYapi();
                $sdYApiModel->channelId    = $chid;
            }
            $sdYApiModel->spnumberKey1 = $spnumberKey1;
            $sdYApiModel->cmdKey1      = $cmdKey1;
            if($sendType1 == '[]'){
                $sendType1  = '';
            }
            $sdYApiModel->sendType1    = $sendType1;
            $sdYApiModel->spnumberKey2 = $spnumberKey2;
            $sdYApiModel->cmdKey2      = $cmdKey2;
            if($sendType2 == '[]'){
                $sendType2  = '';
            }
            $sdYApiModel->sendType2    = $sendType2;
            $sdYApiModel->sendInterval = $sendInterval;
            $sdYApiModel->succKey      = $succKey;
            $sdYApiModel->succValue    = $succValue;
            $sdYApiModel->orderIdKey   = $orderIdKey;
            $sdYApiModel->url          = $url;
            $sdYApiModel->sendMethod   = $sendMethod;
            $sdYApiModel->respFmt      = $respFmt;
            $sdYApiModel->delimiter = $delimiter;
            $sdYApiModel->respHandle    = $respHandle;
        
            try{
                ChannelCfgMain::backendOps($chid);
                ChannelCfgSd::backendOps($chid, $useapi);
                $sdYApiModel->save();
                $out['resultCode']  = Constant::RESULT_CODE_SUCC;
                $out['msg']         = Constant::RESULT_MSG_SUCC;
            }catch (\Exception $e){
                $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
                $out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
            }
        }else{
            $out['resultCode'] = Constant::RESULT_CODE_NONE;
            $out['msg']        = '该通道不存在';
        }
        Utils::jsonOut($out);
    }
    
    public function actionCfgDialtestSave(){
    	$chid               = Utils::getBackendParam('chid');
    	$useapi             = Utils::getBackendParam('useapi');
    	$dialYes			= Utils::getBackendParam('dialYes');
    	$dialurl            = Utils::getBackendParam('dialurl');
    	$dialSuccKey       	= Utils::getBackendParam('dialSuccKey');
    	$dialSuccVal        = Utils::getBackendParam('dialSuccVal');
    	$dialParam          = Utils::getBackendParam('dialParam');
    	$dialSign			= Utils::getBackendParam('dialSign');
    	
    	$channelModel   = Channel::findByPk($chid);
    	if($channelModel){
    		$dialtestModel   = ChannelCfgDialtest::findByChannelId($chid);
    		if(!$dialtestModel){
    			$dialtestModel   = new ChannelCfgDialtest();
    			$dialtestModel->channelId = $chid;
    		}
    		$dialtestModel->dialYes		= $dialYes;
    		$dialtestModel->dialurl 	= $dialurl;
    		$dialtestModel->dialSuccKey = $dialSuccKey;
    		$dialtestModel->dialSuccVal = $dialSuccVal;
    		$dialtestModel->dialParam	= $dialParam;
    		$dialtestModel->dialSign	= $dialSign;
    		
    		try{
    			ChannelCfgMain::backendOps($chid);
    			ChannelCfgSd::backendOps($chid, $useapi);
    			$dialtestModel->save();
    			
    			$out['resultCode']  = Constant::RESULT_CODE_SUCC;
    			$out['msg']         = Constant::RESULT_MSG_SUCC;
    		}catch (\Exception $e){
    			$out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
    			$out['msg']         = $e->getMessage();
    		}
    	}else{
    		$out['resultCode'] = Constant::RESULT_CODE_NONE;
    		$out['msg']        = '该通道不存在';
    	}
    	Utils::jsonOut($out);
    }
    
    public function actionCfgPayParamsSave(){
        $chid       = Utils::getBackendParam('chid');
        $useapi     = Utils::getBackendParam('useapi');
        $mobileKey  = Utils::getBackendParam('mobileKey');
        $imeiKey    = Utils::getBackendParam('imeiKey');
        $imsiKey    = Utils::getBackendParam('imsiKey');
        $iccidKey   = Utils::getBackendParam('iccidKey');
        $ipKey      = Utils::getBackendParam('ipKey');
        $feeKey     = Utils::getBackendParam('feeKey');
        $feeUnit    = Utils::getBackendParam('feeUnit');
        $feeCodeKey = Utils::getBackendParam('feeCodeKey');
        $feePackages= Utils::getBackendParam('feePackages');
        $customs    = Utils::getBackendParam('customs');
        $provinceMap= Utils::getBackendParam('provinceMap');
        $provinceMapKey = Utils::getBackendParam('provinceMapKey');
        $cpparamKey = Utils::getBackendParam('cpparamKey');
        $cpparamLen = Utils::getBackendParam('cpparamLen',10);
        $cpparamPrefix = Utils::getBackendParam('cpparamPrefix');
        $cpparamHandle  = Utils::getBackendParam('cpparamHandle');
        $appNameKey = Utils::getBackendParam('appNameKey');
        $goodNameKey    = Utils::getBackendParam('goodNameKey');
        $provinceNameKey    = Utils::getBackendParam('provinceNameKey');
        $linkIdKey      = Utils::getBackendParam('linkIdKey');
        $timestampKey   = Utils::getBackendParam('timestampKey');
        $unixTimestampKey   = Utils::getBackendParam('unixTimestampKey');
        $signKey        = Utils::getBackendParam('signKey');
        
        $signMethod     = Utils::getBackendParam('signMethod');
        $signParameters = str_replace('，', ',', Utils::getBackendParam('signParameters'));
        $signResHandle   = Utils::getBackendParam('signResHandle');
        
        $channelModel   = Channel::findByPk($chid);
        if($channelModel){
            $payParamsModel  = ChannelCfgPayParams::findByChannelId($chid);
            if(!$payParamsModel){
                $payParamsModel  = new ChannelCfgPayParams();
                $payParamsModel->channelId   = $chid;
            }
        
            if($feePackages == '[]'){
                $feePackages    = '';
            }
            if($customs == '[]'){
                $customs    = '';
            }
        
            if($provinceMap == '[]'){
                $provinceMap    = '';
            }
        
            $payParamsModel->mobileKey   = $mobileKey;
            $payParamsModel->imeiKey     = $imeiKey;
            $payParamsModel->imsiKey     = $imsiKey;
            $payParamsModel->iccidKey    = $iccidKey;
            $payParamsModel->ipKey       = $ipKey;
            $payParamsModel->feeKey      = $feeKey;
            $payParamsModel->feeUnit     = $feeUnit;
            $payParamsModel->feeCodeKey  = $feeCodeKey;
            $payParamsModel->feePackages = $feePackages;
            $payParamsModel->customs     = $customs;
            $payParamsModel->provinceMap = $provinceMap;
            $payParamsModel->provinceMapKey  = $provinceMapKey;
            $payParamsModel->cpparamKey  = $cpparamKey;
            $payParamsModel->cpparamLen  = $cpparamLen;
            $payParamsModel->cpparamPrefix   = $cpparamPrefix;
            $payParamsModel->cpparamHandle   = $cpparamHandle;
            $payParamsModel->appNameKey  = $appNameKey;
            $payParamsModel->goodNameKey = $goodNameKey;
            $payParamsModel->provinceNameKey = $provinceNameKey;
            $payParamsModel->linkIdKey       = $linkIdKey;
            $payParamsModel->timestampKey    = $timestampKey;
            $payParamsModel->unixTimestampKey   = $unixTimestampKey;
            $payParamsModel->signKey         = $signKey;
            try{
                ChannelCfgMain::backendOps($chid);
                $payParamsModel->save();
                if(Utils::isValid($payParamsModel->signKey)){
                    $paySignModel   = ChannelCfgPaySign::findByChannelId($chid);
                    if(!$paySignModel){
                        $paySignModel   = new ChannelCfgPaySign();
                        $paySignModel->channelId    = $chid;
                    }
                    $paySignModel->method   = $signMethod;
                    $paySignModel->parameters   = $signParameters;
                    $paySignModel->resHandle     = $signResHandle;
                    $paySignModel->save();
                }
                $out['resultCode']  = Constant::RESULT_CODE_SUCC;
                $out['msg']         = Constant::RESULT_MSG_SUCC;
            }catch (\Exception $e){
                $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
                $out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
            }
        }else{
            $out['resultCode'] = Constant::RESULT_CODE_NONE;
            $out['msg']        = '该通道不存在';
        }
        Utils::jsonOut($out);
    }
    
    public function actionCfgSyncSave(){
        $chid       = Utils::getBackendParam('chid');
        $useapi     = Utils::getBackendParam('useapi');
        $succKey    = Utils::getBackendParam('succKey');
        $succValue  = Utils::getBackendParam('succValue');
        $cpparamKey = Utils::getBackendParam('cpparamKey');
        $spOidKey   = Utils::getBackendParam('spOidKey');
        $mobileKey  = Utils::getBackendParam('mobileKey');
        $feeKey     = Utils::getBackendParam('feeKey');
        $feeUnit    = Utils::getBackendParam('feeUnit');
        $succReturn = Utils::getBackendParam('succReturn');
        $feeFixed   = Utils::getBackendParam('feeFixed');
        $cmdKey     = Utils::getBackendParam('cmdKey');
        
        $channelModel   = Channel::findByPk($chid);
        if($channelModel){
            $syncModel   = ChannelCfgSync::findByChannelId($chid);
            if(!$syncModel){
                $syncModel   = new ChannelCfgSync();
                $syncModel->channelId    = $chid;
            }
            $syncModel->succKey      = $succKey;
            $syncModel->succValue    = $succValue;
            $syncModel->cpparamKey   = $cpparamKey;
            $syncModel->spOidKey     = $spOidKey;
            $syncModel->mobileKey    = $mobileKey;
            $syncModel->feeKey       = $feeKey;
            $syncModel->feeUnit      = $feeUnit;
            $syncModel->succReturn   = $succReturn;
            $syncModel->feeFixed     = $feeFixed;
            $syncModel->cmdKey       = $cmdKey;
            try{
                ChannelCfgMain::backendOps($chid);
                $syncModel->save();
                $out['resultCode']  = Constant::RESULT_CODE_SUCC;
                $out['msg']         = Constant::RESULT_MSG_SUCC;
            }catch (\Exception $e){
                $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
                $out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
            }
        }else{
            $out['resultCode'] = Constant::RESULT_CODE_NONE;
            $out['msg']        = '该通道不存在';
        }
        Utils::jsonOut($out);
    }
    public function actionCfgSmsView(){
        $chid   = Utils::getBackendParam('chid',0);
        
        $channelModel       = Channel::findByPk($chid);
        $mainModel          = ChannelCfgMain::findByChannelId($chid);
        $payParamsModel     = ChannelCfgPayParams::findByChannelId($chid);
        $smsModel           = ChannelCfgSms::findByChannelId($chid);
        $smsYApiModel       = ChannelCfgSmsYapi::findByChannelId($chid);
        $smsNApiModel       = ChannelCfgSmsNapi::findByChannelId($chid);
        $submitModel        = ChannelCfgSmsSubmit::findByChannelId($chid);
        $sdkSubmitModel     = ChannelCfgSmsSdkSubmit::findByChannelId($chid);
        $syncModel                = ChannelCfgSync::findByChannelId($chid);
        $smtParamsModel           = ChannelCfgSmtParams::findByChannelId($chid);
        $outModel           = ChannelCfgOut::findByChannelId($chid);
        $channelCfgToSync   = ChannelCfgToSync::findByChannelId($chid);
        $data   = array(
            'chid'                        => $chid,
            'channelModel'                => $channelModel,
            'mainModel'                   => $mainModel,
            'payParamsModel'              => $payParamsModel,
            'smsModel'                    => $smsModel,
            'smsYApiModel'                => $smsYApiModel,
            'smsNApiModel'                => $smsNApiModel, 
            'submitModel'                 => $submitModel,
            'sdkSubmitModel'              => $sdkSubmitModel,
            'syncModel'                   => $syncModel,
            'smtParamsModel'              => $smtParamsModel,
            'outModel'                    => $outModel,
            'channelCfgToSync'            => $channelCfgToSync,
        );
        
        return $this->render('cfg-sms-view',$data);
    }
    
    public function actionCfgSmsYapiSave(){
        $chid       = Utils::getBackendParam('chid',0);
        $useapi     = Utils::getBackendParam('useapi');
        $spnumberKey1   = Utils::getBackendParam('spnumberKey1');
        $cmdKey1        = Utils::getBackendParam('cmdKey1');
        $sendType1      = Utils::getBackendParam('sendType1');
        $succKey        = Utils::getBackendParam('succKey');
        $succValue      = Utils::getBackendParam('succValue');
        $orderIdKey     = Utils::getBackendParam('orderIdKey');
        $url            = Utils::getBackendParam('url');
        $sendMethod     = Utils::getBackendParam('sendMethod');
        $respFmt        = Utils::getBackendParam('respFmt');
        $delimiter = Utils::getBackendParam('delimiter');
        $respHandle         = Utils::getBackendParam('respHandle');
        
        $channelModel   = Channel::findByPk($chid);
        if($channelModel){
            $smsYApiModel   = ChannelCfgSmsYapi::findByChannelId($chid);
            if(!$smsYApiModel){
                $smsYApiModel   = new ChannelCfgSmsYapi();
                $smsYApiModel->channelId    = $chid;
            }
            $smsYApiModel->spnumberKey1 = $spnumberKey1;
            $smsYApiModel->cmdKey1      = $cmdKey1;
            $smsYApiModel->succKey      = $succKey;
            $smsYApiModel->succValue    = $succValue;
            $smsYApiModel->orderIdKey   = $orderIdKey;
            $smsYApiModel->url          = $url;
            $smsYApiModel->sendMethod   = $sendMethod;
            $smsYApiModel->respFmt      = $respFmt;
            $smsYApiModel->delimiter = $delimiter;
            $smsYApiModel->respHandle   = $respHandle;
            if($sendType1 == '[]'){
                $sendType1  = '';
            }
            $smsYApiModel->sendType1    = $sendType1;
            try{
                $smsYApiModel->save();
                ChannelCfgMain::backendOps($chid);
                ChannelCfgSms::backendOps($chid, $useapi);
                $out['resultCode']  = Constant::RESULT_CODE_SUCC;
                $out['msg']         = Constant::RESULT_MSG_SUCC;
            }catch (\Exception $e){
                $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
                $out['msg']         = $e->getMessage();
            }
        }else{
            $out['resultCode']  = Constant::RESULT_CODE_NONE;
            $out['msg']         = '该通道不存在';
        }
        Utils::jsonOut($out);
    }
    
    public function actionCfgSmsNapiSave(){
        $chid       = Utils::getBackendParam('chid',0);
        $useapi     = Utils::getBackendParam('useapi');
        $needExt    = Utils::getBackendParam('needExt',0);
        $sms1Arr    = json_decode(Utils::getBackendParam('sms1'),true);
        $channelModel   = Channel::findByPk($chid);
        if($channelModel){
            $smsNApiModel   = ChannelCfgSmsNapi::findByChannelId($chid);
            if(!$smsNApiModel){
                $smsNApiModel   = new ChannelCfgSmsNapi();
                $smsNApiModel->channelId    = $chid;
            }
            $smsNApiModel->needExt  = $needExt;
            if(count($sms1Arr) > 0){
                $sms1   = array();
                foreach ($sms1Arr as $item){
                    $sms1[$item['fee']] = array(
                        'spnumber'      => $item['spnumber'],
                        'cmd'           => $item['cmd'],
                        'sendtype'      => $item['sendtype'],
                        //'ext'           => $item['ext']?:0,
                    );
                }
                $sms1   = json_encode($sms1);
            }else{
                $sms1   = '';
            }
            
            $smsNApiModel->sms1 = $sms1;
            try{
                ChannelCfgMain::backendOps($chid);
                ChannelCfgSms::backendOps($chid, $useapi);
                $smsNApiModel->save();
                $out['resultCode']  = Constant::RESULT_CODE_SUCC;
                $out['msg']         = Constant::RESULT_MSG_SUCC;
            }catch (\Exception $e){
                $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
                $out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
            }
        }else{
            $out['resultCode']  = Constant::RESULT_CODE_NONE;
            $out['msg']         = '该通道不存在';
        }
        Utils::jsonOut($out);
    }
    public function actionCfgSmsSubmitSave(){
        $chid           = Utils::getBackendParam('chid');
        $smtType        = Utils::getBackendParam('smtType');
        $smtKeywords    = Utils::getBackendParam('smtKeywords');
        $url            = Utils::getBackendParam('url');
        $sendMethod     = Utils::getBackendParam('sendMethod');
        $respFmt        = Utils::getBackendParam('respFmt');
        $succKey        = Utils::getBackendParam('succKey');
        $succValue      = Utils::getBackendParam('succValue');  
        $portFixed      = Utils::getBackendParam('portFixed');
        $channelModel   = Channel::findByPk($chid);
        if($channelModel){
            $smsModel   = ChannelCfgSms::findByChannelId($chid);
            if(!$smsModel){
                $smsModel   = new ChannelCfgSms();
                $smsModel->channelId    = $chid;
            }
            $smsModel->smtType  = $smtType;
            $smsModel->smtKeywords  = $smtKeywords;
            $submitModel    = ChannelCfgSmsSubmit::findByChannelId($chid);
            if(!$submitModel){
                $submitModel    = new ChannelCfgSmsSubmit();
                $submitModel->channelId = $chid;
            }
            $submitModel->url           = $url;
            $submitModel->sendMethod    = $sendMethod;
            $submitModel->respFmt       = $respFmt;
            $submitModel->succKey       = $succKey;
            $submitModel->succValue     = $succValue;
            
            try{
                $smsModel->save();
                $submitModel->save();
                if(Utils::isValid($portFixed)){
                    $sdkSubmitModel = ChannelCfgSmsSdkSubmit::findByChannelId($chid);
                    if(!$sdkSubmitModel){
                        $sdkSubmitModel = new ChannelCfgSmsSdkSubmit();
                        $sdkSubmitModel->channelId  = $chid;
                    }
                    $sdkSubmitModel->portFixed  = $portFixed;
                    $sdkSubmitModel->save();
                }
                $out['resultCode']  = Constant::RESULT_CODE_SUCC;
                $out['msg']         = Constant::RESULT_MSG_SUCC;
            }catch (\Exception $e){
                $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
                $out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
            }
        }else{
            $out['resultCode'] = Constant::RESULT_CODE_NONE;
            $out['msg']        = '该通道不存在';
        }
        Utils::jsonOut($out);        
    }
    
    public function actionCfgSmtParamsSave(){
        $chid           = Utils::getBackendParam('chid');
        $orderIdKey     = Utils::getBackendParam('orderIdKey');
        $verifyCodeKey  = Utils::getBackendParam('verifyCodeKey');
        $mobileKey      = Utils::getBackendParam('mobileKey');
        $cpparamKey     = Utils::getBackendParam('cpparamKey');
        $imeiKey        = Utils::getBackendParam('imeiKey');
        $imsiKey        = Utils::getBackendParam('imsiKey');
        $iccidKey       = Utils::getBackendParam('iccidKey');
        $ipKey          = Utils::getBackendParam('ipKey');   
        $smsNumberKey   = Utils::getBackendParam('smsNumberKey');
        $smsContentKey  = Utils::getBackendParam('smsContentKey');
        $timestampKey   = Utils::getBackendParam('timestampKey');
        $unixTimestampKey   = Utils::getBackendParam('unixTimestampKey');
        $signKey        = Utils::getBackendParam('signKey');
        
        $signMethod     = Utils::getBackendParam('signMethod');
        $signParameters = str_replace('，', ',', Utils::getBackendParam('signParameters'));
        $signResHandle   = Utils::getBackendParam('signResHandle');
        
        $channelModel   = Channel::findByPk($chid);
        if($channelModel){
            $smtParamsModel   = ChannelCfgSmtParams::findByChannelId($chid);
            if(!$smtParamsModel){
                $smtParamsModel               = new ChannelCfgSmtParams();
                $smtParamsModel->channelId    = $chid;
            }
            $smtParamsModel->orderIdKey       = $orderIdKey;
            $smtParamsModel->verifyCodeKey    = $verifyCodeKey;
            $smtParamsModel->mobileKey        = $mobileKey;
            $smtParamsModel->cpparamKey       = $cpparamKey;
            $smtParamsModel->imeiKey          = $imeiKey;
            $smtParamsModel->imsiKey          = $imsiKey;
            $smtParamsModel->iccidKey         = $iccidKey;
            $smtParamsModel->ipKey            = $ipKey;
            $smtParamsModel->smsContentKey    = $smsContentKey;
            $smtParamsModel->smsNumberKey     = $smsNumberKey;
            $smtParamsModel->timestampKey     = $timestampKey;
            $smtParamsModel->unixTimestampKey = $unixTimestampKey;
            $smtParamsModel->signKey          = $signKey;
            try{
                $smtParamsModel->save();
        
                if(Utils::isValid($smtParamsModel->signKey)){
                    $smtSignModel   = ChannelCfgSmtSign::findByChannelId($chid);
                    if(!$smtSignModel){
                        $smtSignModel   = new ChannelCfgSmtSign();
                        $smtSignModel->channelId    = $chid;
                    }
                    $smtSignModel->method       = $signMethod;
                    $smtSignModel->parameters   = $signParameters;
                    $smtSignModel->resHandle    = $signResHandle;
                    $smtSignModel->save();
                }
                
                $out['resultCode']  = Constant::RESULT_CODE_SUCC;
                $out['msg']         = Constant::RESULT_MSG_SUCC;
        
            }catch (\Exception $e){
                $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
                $out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
            }
        }else{
            $out['resultCode'] = Constant::RESULT_CODE_NONE;
            $out['msg']        = '该通道不存在';
        }
        Utils::jsonOut($out);
    }
    public function actionCfgUrlView(){
        $chid   = Utils::getBackendParam('chid',0);
        $channelModel       = Channel::findByPk($chid);
        $mainModel          = ChannelCfgMain::findByChannelId($chid);
        $payParamsModel     = ChannelCfgPayParams::findByChannelId($chid);
        $urlModel           = ChannelCfgUrl::findByChannelId($chid);
        $urlYApiModel       = ChannelCfgUrlYapi::findByChannelId($chid);
        $submitModel        = ChannelCfgUrlSubmit::findByChannelId($chid);
        $sdkSubmitModel     = ChannelCfgUrlSdkSubmit::findByChannelId($chid);
        $syncModel          = ChannelCfgSync::findByChannelId($chid);
        $smtParamsModel     = ChannelCfgSmtParams::findByChannelId($chid);
        $outModel           = ChannelCfgOut::findByChannelId($chid);
        $channelCfgToSync   = ChannelCfgToSync::findByChannelId($chid);
        $data   = array(
            'chid'                        => $chid,
            'channelModel'                => $channelModel,
            'mainModel'                   => $mainModel,
            'payParamsModel'              => $payParamsModel,
            'urlModel'                    => $urlModel,
            'urlYApiModel'                => $urlYApiModel,
            'submitModel'                 => $submitModel,
            'sdkSubmitModel'              => $sdkSubmitModel,
            'syncModel'                   => $syncModel,
            'smtParamsModel'              => $smtParamsModel,
            'outModel'                    => $outModel,
            'channelCfgToSync'            => $channelCfgToSync,
        );
        
        return $this->render('cfg-url-view',$data);
    }
    public function actionCfgUrlYapiSave(){        
        $chid           = Utils::getBackendParam('chid',0);
        $url            = Utils::getBackendParam('url');
        $sendMethod     = Utils::getBackendParam('sendMethod');
        $respFmt        = Utils::getBackendParam('respFmt');
        $delimiter = Utils::getBackendParam('delimiter');
        $succKey        = Utils::getBackendParam('succKey');
        $succValue      = Utils::getBackendParam('succValue');
        $orderIdKey     = Utils::getBackendParam('orderIdKey');
        $smtKey         = Utils::getBackendParam('smtKey');
        $respHandle     = Utils::getBackendParam('respHandle');
        
        $channelModel   = Channel::findByPk($chid);
        if($channelModel){
            $urlYApiModel   = ChannelCfgUrlYapi::findByChannelId($chid);
            if(!$urlYApiModel){
                $urlYApiModel   = new ChannelCfgUrlYapi();
                $urlYApiModel->channelId    = $chid;
            }
            $urlYApiModel->url          = $url;
            $urlYApiModel->sendMethod   = $sendMethod;
            $urlYApiModel->respFmt      = $respFmt;
            $urlYApiModel->succKey      = $succKey;
            $urlYApiModel->succValue    = $succValue;
            $urlYApiModel->orderIdKey   = $orderIdKey;
            $urlYApiModel->smtKey       = $smtKey;
            $urlYApiModel->delimiter = $delimiter;
            $urlYApiModel->respHandle   = $respHandle;

            try{
                $urlYApiModel->save();
                ChannelCfgMain::backendOps($chid);
                $out['resultCode']  = Constant::RESULT_CODE_SUCC;
                $out['msg']         = Constant::RESULT_MSG_SUCC;
            }catch (\Exception $e){
                $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
                $out['msg']         = $e->getMessage();
            }
        }else{
            $out['resultCode']  = Constant::RESULT_CODE_NONE;
            $out['msg']         = '该通道不存在';
        }
        Utils::jsonOut($out);
    }
    public function actionCfgUrlSubmitSave(){
        $chid           = Utils::getBackendParam('chid');
        $smtType        = Utils::getBackendParam('smtType');
        $smtKeywords    = Utils::getBackendParam('smtKeywords');
        $url            = Utils::getBackendParam('url');
        $sendMethod     = Utils::getBackendParam('sendMethod');
        $respFmt        = Utils::getBackendParam('respFmt');
        $succKey        = Utils::getBackendParam('succKey');
        $succValue      = Utils::getBackendParam('succValue');
        $portFixed      = Utils::getBackendParam('portFixed');
        $channelModel   = Channel::findByPk($chid);
        if($channelModel){
            $urlModel   = ChannelCfgUrl::findByChannelId($chid);
            if(!$urlModel){
                $urlModel   = new ChannelCfgUrl();
                $urlModel->channelId    = $chid;
            }
            $urlModel->smtType      = $smtType;
            $urlModel->smtKeywords  = $smtKeywords;
            $submitModel    = ChannelCfgUrlSubmit::findByChannelId($chid);
            if(!$submitModel){
                $submitModel    = new ChannelCfgUrlSubmit();
                $submitModel->channelId = $chid;
            }
            $submitModel->url           = $url;
            $submitModel->sendMethod    = $sendMethod;
            $submitModel->respFmt       = $respFmt;
            $submitModel->succKey       = $succKey;
            $submitModel->succValue     = $succValue;
            try{
                $urlModel->save();
                $submitModel->save();
                if(Utils::isValid($portFixed)){
                    $sdkSubmitModel = ChannelCfgUrlSdkSubmit::findByChannelId($chid);
                    if(!$sdkSubmitModel){
                        $sdkSubmitModel = new ChannelCfgUrlSdkSubmit();
                        $sdkSubmitModel->channelId  = $chid;
                    }
                    $sdkSubmitModel->portFixed  = $portFixed;
                    $sdkSubmitModel->save();
                }
                $out['resultCode']  = Constant::RESULT_CODE_SUCC;
                $out['msg']         = Constant::RESULT_MSG_SUCC;
            }catch (\Exception $e){
                $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
                $out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
            }
        }else{
            $out['resultCode'] = Constant::RESULT_CODE_NONE;
            $out['msg']        = '该通道不存在';
        }
        Utils::jsonOut($out);
    }
    
    public function actionDutyView(){
    		return $this->render('duty-view');
    }
    
    public function actionDevelopersResult(){
    		$models = DeveloperChannelCount::findAllByCountAsc();
    		$datas = [];
    		if($models){
    			foreach ($models as $model){
    				$datas[] = [
    						'id' => $model->id,
    						'name' => $model->name,
    						'count' => $model->count,
    						'status' => $model->status,
    				];
    			}
    			$out['datas'] = $datas;
    			$out['resultCode']  = Constant::RESULT_CODE_SUCC;
    			$out['msg']         = Constant::RESULT_MSG_SUCC;
    		}else{
    			$out['resultCode']  = Constant::RESULT_CODE_SUCC;
    			$out['msg']         = Constant::RESULT_MSG_NONE;
    		}
    		Utils::jsonOut($out);
    }
    
    public function actionAddDeveloperChannelCount(){
    		$id = Utils::getBackendParam('id');
    		$out['resultCode']  = Constant::RESULT_CODE_NONE;
    		$out['msg']         = Constant::RESULT_MSG_NONE;
    		$model = DeveloperChannelCount::findByPk($id);
    		if($model){
    			$model->count = $model->count + 1;
    			try {
    				$model->save();
    				$out['resultCode']  = Constant::RESULT_CODE_SUCC;
    				$out['msg']         = Constant::RESULT_MSG_SUCC;
    			} catch (\Exception $e) {
    				$out['resultCode']  = Constant::RESULT_CODE_NONE;
    				$out['msg']         = Constant::RESULT_MSG_NONE;
    			}
    		}
    		Utils::jsonOut($out);
    		
    }
    

    public function actionCfgMainStatus(){
    	$chid	= Utils::getBackendParam('chid');    	
    	$mainModel	= ChannelCfgMain::findByChannelId($chid);
    	if(!$mainModel){
    		$mainModel = new ChannelCfgMain();
    		$mainModel->channelId	= $chid;
    	}
    	if($mainModel->status){
    		$status = 0;
    	}else{
    		$status = 1;
    	}
    	$mainModel->status = $status;
    	try{
    		$mainModel->save();
    		$out['resultCode']	= Constant::RESULT_CODE_SUCC;
    		$out['msg']			= Constant::RESULT_MSG_SUCC;
    	}catch (\Exception $e){
    		$out['resultCode']	= Constant::RESULT_CODE_SYSTEM_BUSY;
    		$out['msg']			= Constant::RESULT_MSG_SYSTEM_BUSY;
    	}
    	Utils::jsonOut($out);
    }
    
    
    public function actionChannelCfgUseage(){
        return $this->render('channel-cfg-useage');
    }
    
    public function actionCfgOutSave(){
        $chid	        = Utils::getBackendParam('chid');
        $spSignPrefix   = Utils::getBackendParam('spSignPrefix');
        $url            = Utils::getBackendParam('url');
        
        $outModel   = ChannelCfgOut::findByChannelId($chid);
        if(!$outModel){
            $outModel   = new ChannelCfgOut();
            $outModel->channelId    = $chid;
        }
        $outModel->spSignPrefix = $spSignPrefix;
        $outModel->url          = $url;
        
        try{
            $outModel->save();
            $out['resultCode']  = Constant::RESULT_CODE_SUCC;
            $out['msg']         = Constant::RESULT_MSG_SUCC;
        }catch (\Exception $e){
            $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
            $out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
        }
        Utils::jsonOut($out);
    }

    public function actionCfgSyncSingle() {
        $chid	        = Utils::getBackendParam('chid');
        $syncPort   = Utils::getBackendParam('syncPort');
        $syncCommand           = Utils::getBackendParam('syncCommand');
        $channelCfgToSync   = ChannelCfgToSync::findByChannelId($chid);
        if(!$channelCfgToSync) {
            $channelCfgToSync   = new ChannelCfgToSync();
            $channelCfgToSync->channelId  = $chid;
        }
        $channelCfgToSync->port     = $syncPort;
        $channelCfgToSync->command  = $syncCommand;

        try{
            $channelCfgToSync->save();
            $out['resultCode']  = Constant::RESULT_CODE_SUCC;
            $out['msg']         = Constant::RESULT_MSG_SUCC;
        }catch (\Exception $e) {
            $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
            $out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
        }
        Utils::jsonOut($out);
    }
    
    public function actionChannelDevType(){
    	$chid 		= Utils::getBackendParam('chid');
    	$devType 	= Utils::getBackendParam('devType');
    	$channelModel 	= Channel::findByPk($chid);
    	if ($channelModel){
    		$channelModel->devType = $devType;
    		try{
    			$channelModel->save();
    			$out['resultCode']	= Constant::RESULT_CODE_SUCC;
    			$out['msg']			= Constant::RESULT_MSG_SUCC;
    		}catch (\Exception $e){
    			$out['resultCode']	= Constant::RESULT_CODE_SYSTEM_BUSY;
    			$out['msg']			= Constant::RESULT_MSG_SYSTEM_BUSY;
    		}
    	}else{
    		$out['resultCode']	= Constant::RESULT_CODE_NONE;
    		$out['msg']			= Constant::RESULT_MSG_NONE;
    	}
    	Utils::jsonOut($out);
    }
    
    public function actionChannelLogView(){
        $chid   = Utils::getBackendParam('chid');
        $data   = array(
            'chid'  => $chid,
        );
        return $this->render('channel-log-view',$data);
    }
    
    public function actionJsonstringView(){
        return $this->render('jsonstring-view');
    }
    
    /*
     * 通道地域覆盖展示
     */
    public function actionChannelCoverView(){
        return $this->render('channel-cover-view');
    }
    
    /*
     * 通道组列表
     */
    public function actionCgroupView(){
        return $this->render('cgroup-view');
    }
    
    /*
     * 通道组数据
     */
    public function actionCgroupResult(){
        $page   = Utils::getBackendParam('page',1);
        
        $res    = ChannelGroup::findAllNeedPaginator($page);
        
        $pages  = $res['pages'];
        $models = $res['models'];
        
        if($pages > 0 && $pages >= $page){
            $out['resultCode']  = Constant::RESULT_CODE_SUCC;
            $out['msg']         = Constant::RESULT_MSG_SUCC;
            $out['pages']       = $pages;
            $out['page']        = $page;
            
            $list   = [];
            foreach ($models as $channlGroupModel){
                $item   = ChannelGroup::getItemArrByModel($channlGroupModel);
                array_push($list, $item);
            }
            $out['list']    = $list;
        }else{
            $out['resultCode']  = Constant::RESULT_CODE_NONE;
            if($page > 1){
                $msg    = Constant::RESULT_MSG_NOMORE;
            }else{
                $msg    = Constant::RESULT_MSG_NONE;
            }
            $out['msg'] = $msg;
        }
        Utils::jsonOut($out);
    }
    
    public function actionCgroupSetView(){
        return $this->render('cgroup-set-view');
    }
    public function actionCgroupDetailResult(){
        $id = Utils::getBackendParam('id');
        $channelGroupModel  = ChannelGroup::findByPk($id);
        if($channelGroupModel){
            $out['resultCode']  = Constant::RESULT_CODE_SUCC;
            $out['msg']         = Constant::RESULT_MSG_SUCC;
            $out['item']        = $channelGroupModel->toArray();
        }else{
            $out['resultCode']  = Constant::RESULT_CODE_NONE;
            $out['msg']         = Constant::RESULT_MSG_NONE;
        }
        Utils::jsonOut($out);
    }
    
    public function actionCgroupSetSave(){
        $id     = Utils::getBackendParam('id');
        $name   = Utils::getBackendParam('name');
        $uniqueLimit    = Utils::getBackendParam('uniqueLimit');
        $cdTime = Utils::getBackendParam('cdTime');
        $dayLimit   = Utils::getBackendParam('dayLimit');
        $dayRequestLimit    = Utils::getBackendParam('dayRequestLimit');
        $monthLimit = Utils::getBackendParam('monthLimit');
        $monthRequestLimit  = Utils::getBackendParam('monthRequestLimit');
        
        if(is_numeric($id)){
            $channelGroupModel  = ChannelGroup::findByPk($id);
        }else{
            $channelGroupModel  = new ChannelGroup();
        }
        $channelGroupModel->name    = $name;
        $channelGroupModel->uniqueLimit = $uniqueLimit;
        $channelGroupModel->cdTime  = $cdTime;
        $channelGroupModel->dayLimit    = $dayLimit;
        $channelGroupModel->dayRequestLimit = $dayRequestLimit;
        $channelGroupModel->monthLimit  = $monthLimit;
        $channelGroupModel->monthRequestLimit   = $monthRequestLimit;
        try{
            $channelGroupModel->oldSave();
            //TODO delete MS_Channel_Groups cache
            $out['resultCode']  = Constant::RESULT_CODE_SUCC;
            $out['msg']         = Constant::RESULT_MSG_SUCC;
        }catch (\Exception $e){
            $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
            $out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
        }
        Utils::jsonOut($out);
    }
    
    public function actionCgroupChannelListView(){
        return $this->render('cgroup-channel-list-view');
    }
    public function actionCgroupChannelListResult(){
        $gid    = Utils::getBackendParam('gid');        
        $channelModels  = Channel::findByGroupId($gid);
        
        $channelGroupItem   = ChannelGroup::getItemArrByModel(ChannelGroup::findByPk($gid));
        $out['item']    = $channelGroupItem;
        if(count($channelModels) > 0){
            $out['resultCode']  = Constant::RESULT_CODE_SUCC;
            $out['msg']         = Constant::RESULT_MSG_SUCC;
            $list   = [];
            foreach ($channelModels as $channelModel){
                $item   = Channel::getItemArrByModel($channelModel);
                array_push($list, $item);
            }
            $out['list']    = $list;
        }else{
            $out['resultCode']  = Constant::RESULT_CODE_NONE;
            $out['msg']         = Constant::RESULT_MSG_NONE;
        }
        Utils::jsonOut($out);
    }
    
    public function actionCgroupJoin(){
        $chid   = Utils::getBackendParam('chid');
        $gid    = Utils::getBackendParam('gid');
        
        if($chid > 0 && $gid > 0){
            $channelModel   = Channel::findByPk($chid);
            try{
                $channelModel->groupID  = $gid;
                $channelModel->updateTime   = time();
                $channelModel->save();
                
                $out['resultCode']  = Constant::RESULT_CODE_SUCC;
                $out['msg']         = Constant::RESULT_MSG_SUCC;
                
                //TODO 更新通道cache
            }catch (\Exception $e){
                $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
                $out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
            }
        }else{
            $out['resultCode']  = Constant::RESULT_CODE_PARAMS_ERR;
            $out['msg']         = Constant::RESULT_MSG_PARAMS_ERR;
        }
        Utils::jsonOut($out);
    }
    public function actionCgroupMove(){
        $chid   = Utils::getBackendParam('chid');
        $channelModel   = Channel::findByPk($chid);
        try{
            $channelModel->groupID = 0;
            $channelModel->groupUnique  = 0;
            $channelModel->groupLimit   = 0;
            $channelModel->updateTime   = time();
            $channelModel->save();
            $out['resultCode']  = Constant::RESULT_CODE_SUCC;
            $out['msg']         = Constant::RESULT_MSG_SUCC;
            
            //TODO 更新通道cache
        }catch (\Exception $e){
            $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
            $out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
        }
        Utils::jsonOut($out);
    }
    
    
    public function actionChannelVerifyRuleView(){
        $chid   = Utils::getBackendParam('chid');
        $channelModel   = Channel::findByPk($chid);
        $verifyRuleModels   = ChannelVerifyRule::findByChannelType($chid,0);
        $succRuleModels     = ChannelVerifyRule::findByChannelType($chid,1);
        $data   = array(
            'chid'              => $chid,
            'channelModel'      => $channelModel,
            'verifyRuleModels'  => $verifyRuleModels,
            'succRuleModels'    => $succRuleModels,
        );
        return $this->render('channel-verify-rule-view',$data);   
    }
    
    public function actionChannelVerifyRuleSave(){        
        $cvrid  = Utils::getBackendParam('cvrid');
        $chid   = Utils::getBackendParam('chid');
        $port   = Utils::getBackendParam('port');
        $keys1  = str_replace('，', ',', Utils::getBackendParam('keys1'));
        $keys2  = str_replace('，', ',', Utils::getBackendParam('keys2'));
        $keys3  = str_replace('，', ',', Utils::getBackendParam('keys3'));
        $type   = Utils::getBackendParam('type');
        $memo   = Utils::getBackendParam('memo');
        if($cvrid > 0){
            $ruleModel  = ChannelVerifyRule::findByPk($cvrid);
        }else{
            $ruleModel  = new ChannelVerifyRule();
        }
        $ruleModel->channel = $chid;
        $ruleModel->port    = $port;
        $ruleModel->keys1   = $keys1;
        $ruleModel->keys2   = $keys2;
        $ruleModel->keys3   = $keys3;
        $ruleModel->type    = $type;
        $ruleModel->memo    = $memo;
        $ruleModel->updateTime  = time();
        
        try{
            $ruleModel->oldSave();      
            sleep(1);            
            //刷新该表缓存
            $cFlag = OrigApi::deleteChannelVerifyRuleCache();
            $out['resultCode']  = Constant::RESULT_CODE_SUCC;
            $out['msg']         = Constant::RESULT_MSG_SUCC.',缓存：'.$cFlag;
        }catch (\Exception $e){
            $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
            $out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
        }
        Utils::jsonOut($out);
    }
    
    
    public function actionChannelTimeLimitView(){
        $chid   = Utils::getBackendParam('chid');
        $data   = array(
            'chid'  => $chid,
        );
        return $this->render('channel-time-limit-view',$data);
    }
    
    public function actionChannelTimeLimitResult(){
        $chid   = Utils::getBackendParam('chid');
        $channelModel   = Channel::findByPk($chid);
        
        $timeLimit = TimeLimit::getItemArrByChid($chid);
        $out['resultCode']  = Constant::RESULT_CODE_SUCC;
        $out['msg']         = Constant::RESULT_MSG_SUCC;
        //$out['channel']     = Channel::getItemArrByModel($channelModel);
        $out['timeLimit']   = $timeLimit;
        Utils::jsonOut($out);
    }
    
    public function actionChannelTimeLimitSave(){
        $chid   = Utils::getBackendParam('chid');
        $h0      = Utils::getBackendParam('h0');    
        $h1      = Utils::getBackendParam('h1');
        $h2      = Utils::getBackendParam('h2');
        $h3      = Utils::getBackendParam('h3');
        $h4      = Utils::getBackendParam('h4');
        $h5      = Utils::getBackendParam('h5');
        $h6      = Utils::getBackendParam('h6');
        $h7      = Utils::getBackendParam('h7');
        $h8      = Utils::getBackendParam('h8');
        $h9      = Utils::getBackendParam('h9');
        $h10      = Utils::getBackendParam('h10');
        $h11      = Utils::getBackendParam('h11');
        $h12      = Utils::getBackendParam('h12');
        $h13      = Utils::getBackendParam('h13');
        $h14      = Utils::getBackendParam('h14');
        $h15      = Utils::getBackendParam('h15');
        $h16      = Utils::getBackendParam('h16');
        $h17      = Utils::getBackendParam('h17');
        $h18      = Utils::getBackendParam('h18');
        $h19      = Utils::getBackendParam('h19');
        $h20      = Utils::getBackendParam('h20');
        $h21      = Utils::getBackendParam('h21');
        $h22      = Utils::getBackendParam('h22');
        $h23      = Utils::getBackendParam('h23');
        
        $timeLimitModel = TimeLimit::findByChid($chid);
        if(!$timeLimitModel){
            $timeLimitModel = new TimeLimit();
            $timeLimitModel->channel    = $chid;
        }
        $hours  = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23];
        $timeLimitModel->h0 = $h0;
        $timeLimitModel->h1 = $h1;
        $timeLimitModel->h2 = $h2;
        $timeLimitModel->h3 = $h3;
        $timeLimitModel->h4 = $h4;
        $timeLimitModel->h5 = $h5;
        $timeLimitModel->h6 = $h6;
        $timeLimitModel->h7 = $h7;
        $timeLimitModel->h8 = $h8;
        $timeLimitModel->h9 = $h9;
        $timeLimitModel->h10    = $h10;
        $timeLimitModel->h11    = $h11;
        $timeLimitModel->h12    = $h12;
        $timeLimitModel->h13    = $h13;
        $timeLimitModel->h14    = $h14;
        $timeLimitModel->h15    = $h15;
        $timeLimitModel->h16    = $h16;
        $timeLimitModel->h17    = $h17;
        $timeLimitModel->h18    = $h18;
        $timeLimitModel->h19    = $h19;
        $timeLimitModel->h20    = $h20;
        $timeLimitModel->h21    = $h21;
        $timeLimitModel->h22    = $h22;
        $timeLimitModel->h23    = $h23;
        
        $timeProvinceModels = [];
        $provinces  = Province::getAllProvinceId();
        foreach ($provinces as $provinceId){
            $timeProvinceModel  = TimeProvinceLimit::findByChidProvince($chid,$provinceId);
            if(!$timeProvinceModel){
                $timeProvinceModel  = new TimeProvinceLimit();
                $timeProvinceModel->channel = $chid;
                $timeProvinceModel->province    = $provinceId;
            }
            $timeProvinceModel->h0     = $h0;
            $timeProvinceModel->h1     = $h1;
            $timeProvinceModel->h2     = $h2;
            $timeProvinceModel->h3     = $h3;
            $timeProvinceModel->h4     = $h4;
            $timeProvinceModel->h5     = $h5;
            $timeProvinceModel->h6     = $h6;
            $timeProvinceModel->h7     = $h7;
            $timeProvinceModel->h8     = $h8;
            $timeProvinceModel->h9     = $h9;
            $timeProvinceModel->h10    = $h10;
            $timeProvinceModel->h11    = $h11;
            $timeProvinceModel->h12    = $h12;
            $timeProvinceModel->h13    = $h13;
            $timeProvinceModel->h14    = $h14;
            $timeProvinceModel->h15    = $h15;
            $timeProvinceModel->h16    = $h16;
            $timeProvinceModel->h17    = $h17;
            $timeProvinceModel->h18    = $h18;
            $timeProvinceModel->h19    = $h19;
            $timeProvinceModel->h20    = $h20;
            $timeProvinceModel->h21    = $h21;
            $timeProvinceModel->h22    = $h22;
            $timeProvinceModel->h23    = $h23;
            
            array_push($timeProvinceModels, $timeProvinceModel);
        }
        $tra    = TimeLimit::getDb()->beginTransaction();
        try {
            $timeLimitModel->origSave();
            foreach ($timeProvinceModels as $timeProvinceModel){                
                $timeProvinceModel->origSave();
            }
            
            $tra->commit();
            //cache
            sleep(1);
            $cFlag  = OrigApi::FreshAllChannelInfo();
            $out['resultCode']  = Constant::RESULT_CODE_SUCC;
            $out['msg']         = Constant::RESULT_MSG_SUCC.'缓存:'.$cFlag;
        }catch (\Exception $e){
            $tra->rollBack();
            $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
            $out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
            $out['msg']         = $e->getMessage();
        }
        Utils::jsonOut($out);
    }
    
    
    public function actionChannelPriceView(){
       $chid    = Utils::getBackendParam('chid');
       $data    = array(
           'chid'   => $chid,
       );
       return $this->render('channel-price-view',$data); 
    }
    
    public function actionChannelPriceResult(){
        $chid   = Utils::getBackendParam('chid');
        
        $models = ChannelPrice::findByChid($chid);
        if($models > 0){
            $out['resultCode']  = Constant::RESULT_CODE_SUCC;
            $out['msg']         = Constant::RESULT_MSG_SUCC;
            $list   = [];
            foreach ($models as $channelPriceModel){
                $item   = $channelPriceModel->toArray();
                $item['updateTime'] = date('Y-m-d H:i:s',$item['updateTime']);
                array_push($list, $item);
            }
            $out['list']    = $list;
        }else{
            $out['resultCode']  = Constant::RESULT_CODE_NONE;
            $out['msg']         = Constant::RESULT_MSG_NONE;
        }
        $channelModel       = Channel::findByPk($chid);
        //$out['channel']     = Channel::getItemArrByModel($channelModel);
        
        Utils::jsonOut($out);
    }
    
    public function actionChannelPriceSave(){
        $chid   = Utils::getBackendParam('chid');
        $price   = Utils::getBackendParam('price');
        
        if($price > 0){
            $channelPriceModel  = ChannelPrice::findByChidPrice($chid,$price);
            if(!$channelPriceModel){
                $channelPriceModel  = new ChannelPrice();
                $channelPriceModel->channel = $chid;
                $channelPriceModel->code    = ShortHash::MD5_24($chid.$price.time());
            }
            $channelPriceModel->price   = $price;
            $channelPriceModel->status  = 0;
            
            //为通道的所有省份新增该价格点
            $channelProvincePriceModels = [];
            $provinceIds    = Province::getAllProvinceId();
            foreach ($provinceIds as $provinceId){
                $channelProvincePriceModel  = ChannelProvincePrice::findByChidProvincePrice($chid,$provinceId,$price);
                if($channelProvincePriceModel){
                    continue;
                }else{
                    $channelProvincePriceModel  = new ChannelProvincePrice();
                    $channelProvincePriceModel->channel   = $chid;
                    $channelProvincePriceModel->province  = $provinceId;
                    $channelProvincePriceModel->price     = $price;
                    $channelProvincePriceModel->status    = 0;
                    array_push($channelProvincePriceModels, $channelProvincePriceModel);
                }
            }
            $tra   = ChannelPrice::getDb()->beginTransaction();
            try{
                $channelPriceModel->oldSave();
                foreach ($channelProvincePriceModels as $channelProvincePriceModel){
                    $channelProvincePriceModel->oldSave();
                }
                $tra->commit();
                //cache
                sleep(1);
                $cFlag  = OrigApi::FreshAllChannelInfo();
                $out['resultCode']  = Constant::RESULT_CODE_SUCC;
                $out['msg']         = Constant::RESULT_MSG_SUCC.'缓存:'.$cFlag;
            }catch(\Exception $e){
                $tra->rollBack();
                $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
                $out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
            }
        }else{
            $out['resultCode']  = Constant::RESULT_CODE_PARAMS_ERR;
            $out['msg']         = Constant::RESULT_MSG_PARAMS_ERR;
        }
        Utils::jsonOut($out);
    }
    
    public function actionChannelPriceOps(){
        $cpid   = Utils::getBackendParam('cpid');
        
        $channelPriceModel  = ChannelPrice::findByPk($cpid);
        if($channelPriceModel){           
            $channelProvincePriceModels = ChannelProvincePrice::findByChidPrice($channelPriceModel->channel,$channelPriceModel->price);
            $tra   = ChannelPrice::getDb()->beginTransaction();
            try {
                $status = $channelPriceModel->status == 0 ? 1 : 0;
                $channelPriceModel->status  = $status;
                $channelPriceModel->oldSave();
                foreach ($channelProvincePriceModels as $channelProvincePriceModel){
                    $channelProvincePriceModel->status  = $status;
                    $channelProvincePriceModel->oldSave();
                }
                
                $tra->commit();
                //cache
                sleep(1);
                $cFlag  = OrigApi::FreshAllChannelInfo();
                $out['resultCode']  = Constant::RESULT_CODE_SUCC;
                $out['msg']         = Constant::RESULT_MSG_SUCC.'缓存:'.$cFlag;
            }catch (\Exception $e){
                $tra->rollBack();
                $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
                $out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
            }
        }else{
            $out['resultCode']  = Constant::RESULT_CODE_NONE;
            $out['msg']         = Constant::RESULT_MSG_NONE;
        }
        Utils::jsonOut($out);
    }
    
    
    public function actionChannelStatusView(){
        $chid   = Utils::getBackendParam('chid');
        $data   = array(
            'chid'  => $chid,
        );
        return $this->render('channel-status-view',$data);
    }
    
    public function actionChannelStatusResult(){
        $chid   = Utils::getBackendParam('chid');
        
        $channelModel   = Channel::findByPk($chid);
        if($channelModel){
            $out['resultCode']  = Constant::RESULT_CODE_SUCC;
            $out['msg']         = Constant::RESULT_MSG_SUCC;
            $out['channel']        = Channel::getItemArrByModel($channelModel);
        }else{
            $out['resultCode']  = Constant::RESULT_CODE_NONE;
            $out['msg']         = Constant::RESULT_MSG_NONE;
        }
        Utils::jsonOut($out);
    }
    public function actionChannelStatusSet(){
        $chid   = Utils::getBackendParam('chid');
        $status = Utils::getBackendParam('status');
        
        $channelModel   = Channel::findByPk($chid);
        if($channelModel){
            $channelMonitorModel    = ChannelMonitorRule::findByChid($chid);
            $tra    = Channel::getDb()->beginTransaction();
            try{
                $channelModel->status   = $status;
                $channelModel->oldSave();
                if($channelMonitorModel){
                    if($status == 0){//通道状态变为使用中时：启用通道监控规则
                        $channelMonitorModel->status = 1;
                    }else{//通道状态分为非使用中是：停用通道监控规则
                        $channelMonitorModel->status = 0;
                    }
                    $channelMonitorModel->oldSave();
                }
                $tra->commit();
                
                //cache
                sleep(1);
                $cFlag  = OrigApi::ChannelStatusChg();
                $out['resultCode']  = Constant::RESULT_CODE_SUCC;
                $out['msg']         = Constant::RESULT_MSG_SUCC.'缓存:'.$cFlag;
            }catch (\Exception $e){
                $tra->rollBack();
                $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
                $out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
            }

        }else{
            $out['resultCode']  = Constant::RESULT_CODE_NONE;
            $out['msg']         = Constant::RESULT_MSG_NONE;
        }
        Utils::jsonOut($out);
    }
    
    public function actionChannelDetailView(){
        $chid   = Utils::getBackendParam('chid');
        $data   = array(
            'chid'  => $chid,
        );
        return $this->render('channel-detail-view',$data);
    }
    
    
    public function actionChannelInfoResult(){
        $chid   = Utils::getBackendParam('chid');
        if($chid > 0){
            $channelModel   = Channel::findByPk($chid);
            if($channelModel){
                $out['resultCode']  = Constant::RESULT_CODE_SUCC;
                $out['msg']         = Constant::RESULT_MSG_SUCC;
                $out['channel']     = Channel::getItemArrByModel($channelModel);
            }else{
                $out['resultCode']  = Constant::RESULT_CODE_NONE;
                $out['msg']         = Constant::RESULT_MSG_NONE;
            }
        }else{
            $out['resultCode']  = Constant::RESULT_CODE_NONE;
            $out['msg']         = Constant::RESULT_MSG_NONE;
        }
        Utils::jsonOut($out);
    }
    
}