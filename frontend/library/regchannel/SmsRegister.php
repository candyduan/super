<?php
namespace frontend\library\regchannel;
use common\models\orm\extend\RegChannel;
use common\models\orm\extend\RegOrder;
use common\models\orm\extend\SimCard;
use common\models\orm\extend\RegChannelCfgSms;
use common\models\orm\extend\RegChannelCfgRegParams;
use common\models\orm\extend\RegChannelCfgSmsYapi;
use common\models\orm\extend\RegChannelCfgSmsNapi;

class SmsRegister extends Register{
    protected $_regChannelModel             = null;
    protected $_regOrderModel               = null;
    protected $_simCardModel                = null;
    protected $_regChannelCfgRegParamsModel = null;
    protected $_regChannelCfgSmsModel       = null;
    protected $_regChannelCfgSmsYapiModel   = null;
    protected $_regChannelCfgSmsNapiModel   = null;
    
    public function __construct(RegChannel $regChannelModel,RegOrder $regOrderModel,SimCard $simCardModel){
        $this->_regChannelModel = $regChannelModel;
        $this->_regOrderModel   = $regOrderModel;
        $this->_simCardModel    = $simCardModel;
        $this->_regChannelCfgSmsModel= RegChannelCfgSms::findByRcid($regChannelModel->rcid);
        if($this->_regChannelCfgSmsModel->api){//使用api
            $this->_regChannelCfgRegParamsModel = RegChannelCfgRegParams::findByRcid($regChannelModel->rcid);
            $this->_regChannelCfgSmsYapiModel   = RegChannelCfgSmsYapi::findByRcid($regChannelModel->rcid);
        }else{//不使用api
            $this->_regChannelCfgSmsNapiModel   = RegChannelCfgSmsNapi::findByRcid($regChannelModel->rcid);
        }
    }
    
    
    public function register(){
        if($this->_regChannelCfgSmsModel->api){//使用api
            //TODO
        }else{//不使用api
            $solidResult    = [];
            $smsContent1    = json_decode($this->_regChannelCfgSmsNapiModel->sms1,true);
            $smsContent2    = json_decode($this->_regChannelCfgSmsNapiModel->sms2,true);
            
            if(is_array($smsContent1)){
                $solidResult1   = array(
                    $smsContent1['spnumber'],$smsContent1['cmd'],$smsContent1['sendtype'],
                );
                array_push($solidResult, $solidResult1);
            }
            if(is_array($smsContent2)){
                $solidResult2   = array(
                    $smsContent2['spnumber'],$smsContent2['cmd'],$smsContent2['sendtype'],@5,
                );
                array_push($solidResult, $solidResult2);
            }
            $messages = Utils::getMessagesFromSolidResult($solidResult);
            $res      = Utils::getGiveSdkRegisterResult($this->_regChannelModel,$this->_regOrderModel,$messages);
        }
    }
    
}
