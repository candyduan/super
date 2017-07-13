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
use common\models\orm\extend\ChannelVerifyRule;

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
        $data   = array(
            'channelModel'      => $channelModel,
            'mainModel'         => $mainModel,
            'payParamsModel'    => $payParamsModel,
            'sdModel'           => $sdModel,
            'sdNApiModel'       => $sdNApiModel,
            'sdYApiModel'       => $sdYApiModel,
            'syncModel'         => $syncModel,
            'outModel'          => $outModel,
            'channelCfgToSync'  => $channelCfgToSync
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
        
        return $this->render('channel-log-view');
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
            //TODO 刷新该表缓存
            $out['resultCode']  = Constant::RESULT_CODE_SUCC;
            $out['msg']         = Constant::RESULT_MSG_SUCC;
        }catch (\Exception $e){
            $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
            $out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
        }
        Utils::jsonOut($out);
    }
}