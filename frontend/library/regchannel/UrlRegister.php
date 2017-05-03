<?php
namespace frontend\library\regchannel;
use common\models\orm\extend\RegChannel;
use common\models\orm\extend\RegOrder;
use common\models\orm\extend\SimCard;
use common\models\orm\extend\RegChannelCfgRegParams;
use common\models\orm\extend\RegChannelCfgUrl;
use common\models\orm\extend\RegChannelCfgUrlYapi;
use common\library\Constant;

class UrlRegister extends Register{
    protected $_regChannelModel             = null;
    protected $_regOrderModel               = null;
    protected $_simCardModel                = null;
    protected $_regChannelCfgRegParamsModel = null;
    protected $_regChannelCfgUrlModel       = null;
    protected $_regChannelCfgUrlYapiModel   = null;
    public function __construct(RegChannel $regChannelModel,RegOrder $regOrderModel,SimCard $simCardModel){
        $this->_regChannelModel     = $regChannelModel;
        $this->_regOrderModel       = $regOrderModel;
        $this->_simCardModel        = $simCardModel;
        $this->_regChannelCfgRegParamsModel = RegChannelCfgRegParams::findByRcid($regChannelModel->rcid);
        $this->_regChannelCfgUrlModel       = RegChannelCfgUrl::findByRcid($regChannelModel->rcid);
        $this->_regChannelCfgUrlYapiModel   = RegChannelCfgUrlYapi::findByRcid($regChannelModel->rcid);
    }
    
    public function register(){
        $url    = 'http://'.Constant::DOMAIN_REGISTER.'/register/url-plus/roid/'.$this->_regOrderModel->roid;
        $solidResult    = [$url];
        $messages = Utils::getMessagesFromSolidResult($solidResult);
        $res      = Utils::getGiveSdkRegisterResult($this->_regChannelModel,$this->_regOrderModel,$messages);
        return $res;
    }
    
    public function saveInfo($result){
        ;
    }
}