<?php
namespace frontend\library\regchannel;
use common\library\Utils as commonUtils;
use common\library\Constant;

class Submit{
    public function getDataBySmtParamsProperty(){
        //smt data
        $data   = array();
        
        //是否需要orderid
        if(commonUtils::isValid($this->_regChannelCfgSmtParamsModel->orderIdKey)){
            $data[$this->_regChannelCfgSmtParamsModel->orderIdKey] = $this->_regOrderModel->spOrderId;
        }
        //是否需要验证码
        if(commonUtils::isValid($this->_regChannelCfgSmtParamsModel->verifyCodeKey)){
            switch ($this->_regChannelModel->devType){
                case Constant::CHANNEL_SMSP:
                    $smtKeywords    = $this->_regChannelCfgSmsModel->smtKeywords;
                    break;
                case Constant::CHANNEL_URLP:
                    $smtKeywords    = $this->_regChannelCfgUrlModel->smtKeywords;
                    break;
            }
            $verifyCode = Utils::getVerifyCodeFromMessage($this->_message,$smtKeywords);
            $data[$this->_regChannelCfgSmtParamsModel->verifyCodeKey]  = $verifyCode;
        }
        return $data;
    }
}