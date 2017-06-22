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
        $delimiter = Utils::getBackendParam('delimiter');
        
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
        $cpparamPrefix = Utils::getBackendParam('cpparamPrefix');
        $appNameKey = Utils::getBackendParam('appNameKey');
        $goodNameKey    = Utils::getBackendParam('goodNameKey');
        $provinceNameKey    = Utils::getBackendParam('provinceNameKey');
        $linkIdKey      = Utils::getBackendParam('linkIdKey');
        $timestampKey   = Utils::getBackendParam('timestampKey');
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
            $payParamsModel->cpparamPrefix   = $cpparamPrefix;
            $payParamsModel->appNameKey  = $appNameKey;
            $payParamsModel->goodNameKey = $goodNameKey;
            $payParamsModel->provinceNameKey = $provinceNameKey;
            $payParamsModel->linkIdKey       = $linkIdKey;
            $payParamsModel->timestampKey    = $timestampKey;
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
            try{
                $smtParamsModel->save();
        
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
}