<?php
namespace frontend\library\regchannel;
use common\models\orm\extend\RegChannel;
use common\models\orm\extend\RegOrder;
use common\models\orm\extend\RegChannelCfgSmtParams;
use common\models\orm\extend\RegChannelCfgSms;
use common\models\orm\extend\RegChannelCfgSmsSubmit;
use common\library\Utils as commonUtils;
use common\models\orm\extend\RegOrderUrl;
use common\library\Constant;

class SmsSubmit extends Submit{
    protected $_regChannelModel             = null;
    protected $_regOrderModel               = null;
    protected $_regChannelCfgSmtParamsModel = null;
    protected $_regChannelCfgSmsModel       = null;
    protected $_regChannelCfgSmsSubmitModel = null;
    protected $_port                        = null;
    protected $_message                     = null;
    
    public function __construct(RegChannel $regChannelModel,RegOrder $regOrderModel,$port,$message){
        $this->_regChannelModel             = $regChannelModel;
        $this->_regOrderModel               = $regOrderModel;
        $this->_regChannelCfgSmtParamsModel = RegChannelCfgSmtParams::findByRcid($regChannelModel->rcid);
        $this->_regChannelCfgSmsModel       = RegChannelCfgSms::findByRcid($regChannelModel->rcid);
        $this->_regChannelCfgSmsSubmitModel = RegChannelCfgSmsSubmit::findByRcid($regChannelModel->rcid);
        $this->_port    = $port;
        $this->_message = $message;
    }
    
    
    public function submit(){
        if($this->_regChannelCfgSmsModel->smtType == 1){//server提交
            if(commonUtils::isValid($this->_regChannelCfgSmsModel->smtKey)){//触发验证码下发时已将url给过来了
                $url    = RegOrderUrl::getUrl($this->_regOrderModel->roid);
                $verifyCode = Utils::getVerifyCodeFromMessage($this->_message,$this->_regChannelCfgSmsModel->smtKeywords);
                $api    = array(
                    'url'   => $url.$verifyCode,
                );
            }else{
                //api url
                $url    = $this->_regChannelCfgSmsSubmitModel->url;
                if(!stristr($url, '?') && $this->_regChannelCfgSmsSubmitModel->sendMethod == 1){
                    $url = $url.'?';
                }
                //api data
                $data   = $this->getDataBySmtParamsProperty();
                //组装api
                $api    = array(
                    'url'   => $url,
                    'data'  => $data,
                );
                //传参方式
                if($this->_regChannelCfgSmsSubmitModel->sendMethod != 1){
                    $api['get'] = false;
                }
            }
    
            $respFmt    = Utils::getRespFmt($this->_regChannelCfgSmsSubmitModel->respFmt);
            $result     = Utils::sendHttpResultToSp($api,$respFmt);
            $messages   = [Constant::SUBMIT_SERVER,];
    
        }else{//client提交
            $verifyCode = Utils::getVerifyCodeFromMessage($this->_message,$this->_regChannelCfgSmsModel->smtKeywords);
            $messages   = [Constant::SUBMIT_CLIENT,$this->_port,$verifyCode];
    
        }
        $res        = Utils::getGiveSdkSubmitResult($this->_regChannelModel, $this->_regOrderModel, $messages);
        return $res;
    }
    
}