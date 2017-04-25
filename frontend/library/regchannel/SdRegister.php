<?php
namespace frontend\library\regchannel;
use common\models\orm\extend\RegChannel;
use common\models\orm\extend\RegOrder;
use common\models\orm\extend\SimCard;
use common\models\orm\extend\RegChannelCfgSd;
use common\models\orm\extend\RegChannelCfgSdYapi;
use common\models\orm\extend\RegChannelCfgSdNapi;
use common\models\orm\extend\RegChannelCfgRegParams;
use common\library\Utils as commonUtils;
class SdRegister extends Register{
    protected $_regChannelModel             = null;
    protected $_regOrderModel               = null;
    protected $_simCardModel                = null;
    protected $_regChannelCfgRegParamsModel = null;
    protected $_regChannelCfgSdModel        = null;
    protected $_regChannelCfgSdNapiModel    = null;
    protected $_regChannelCfgSdYapiModel    = null;
    public function __construct(RegChannel $regChannelModel,RegOrder $regOrderModel,SimCard $simCardModel){
        $this->_regChannelModel = $regChannelModel;
        $this->_regOrderModel   = $regOrderModel;
        $this->_simCardModel    = $simCardModel;
        $this->_regChannelCfgSdModel = RegChannelCfgSd::findByRcid($regChannelModel->rcid);
        if($this->_regChannelCfgSdModel->api){//使用api
            $this->_regChannelCfgRegParamsModel = RegChannelCfgRegParams::findByRcid($regChannelModel->rcid);
            $this->_regChannelCfgSdYapiModel    = RegChannelCfgSdYapi::findByRcid($regChannelModel->rcid);
        }else{//不使用api
            $this->_regChannelCfgSdNapiModel    = RegChannelCfgSdNapi::findByRcid($regChannelModel->rcid);
        }
    }
    
    public function register(){
        if($this->_regChannelCfgSdModel->api){//使用api
            $url    = $this->_regChannelCfgSdYapiModel->url;
            if(!stristr($url, '?') && $this->_regChannelCfgSdYapiModel->sendMethod == 1){
                $url = $url.'?';
            }
            
            //api data
            $data   = $this->getDataByRegParamsProperty();
            
            //组装api
            $api    = array(
                'url'   => $url,
                'data'  => $data,
            );
            //传参方式
            if($this->_regChannelCfgSdYapiModel->sendMethod != 1){
                $api['get'] = false;
            }
            $respFmt = Utils::getRespFmt($this->_regChannelCfgSdYapiModel->respFmt);
            $result  = Utils::sendRegisterHttpResult($api,$respFmt);
            //判断是single还是double
            if($this->_regChannelModel->devType == 1){//single
                $messageKey1       = array(
                    $this->_regChannelCfgSdYapiModel->spnumberKey1,
                    $this->_regChannelCfgSdYapiModel->cmdKey1,
                    '@'.$this->_regChannelCfgSdYapiModel->sendType1,
                );
                $messagesKey    = array($messageKey1);
            }else{//double
                $messageKey1       = array(
                    $this->_regChannelCfgSdYapiModel->spnumberKey1,
                    $this->_regChannelCfgSdYapiModel->cmdKey1,
                    '@'.$this->_regChannelCfgSdYapiModel->sendType1,
                );
                $messageKey2       = array(
                    $this->_regChannelCfgSdYapiModel->spnumberKey2,
                    $this->_regChannelCfgSdYapiModel->cmdKey2,
                    '@'.$this->_regChannelCfgSdYapiModel->sendType2,
                    '@'.$this->_regChannelCfgSdYapiModel->sendInterval,
                );
                $messagesKey    = array($messageKey1,$messageKey2);
            }
            
            $messages   = Utils::getMessagesFromHttpResult($result, $this->_regChannelCfgSdYapiModel->succKey, $this->_regChannelCfgSdYapiModel->succValue, $messagesKey,$this->_regChannelCfgSdYapiModel->orderIdKey);
            $res        = Utils::getGiveSdkRegisterResult($this->_regChannelModel,$this->_regOrderModel,$messages);
        }else{
            //判断是single还是double
            if($this->_regChannelModel->devType == 1){//single
                $smsContent1    = json_decode($this->_regChannelCfgSdNapiModel->sms1,true);
                $solidResult1   = array(
                    $smsContent1['spnumber'],$smsContent1['cmd'],$smsContent1['sendtype'],
                );
                $solidResult    = array($solidResult1);
            }else{
                $smsContent1    = json_decode($this->_regChannelCfgSdNapiModel->sms1,true);
                $solidResult1   = array(
                    $smsContent1['spnumber'],$smsContent1['cmd'],$smsContent1['sendtype'],
                );
                $smsContent2    = json_decode($this->_regChannelCfgSdNapiModel->sms2,true);
                $solidResult2   = array(
                    $smsContent2['spnumber'],$smsContent2['cmd'],$smsContent2['sendtype'],5,
                );
                $solidResult    = array($solidResult1,$solidResult2);
            }
            $messages = Utils::getMessagesFromSolidResult($this->_smsTransactionModel, $solidResult);
            $res      = Utils::getGiveSdkRegisterResult($this->_regChannelModel,$this->_regOrderModel,$messages);
        }
        return $res;
    }
}