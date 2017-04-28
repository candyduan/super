<?php
namespace frontend\library\regchannel;
use common\models\orm\extend\RegChannel;
use common\models\orm\extend\RegOrder;
use common\models\orm\extend\RegChannelCfgRegParams;
use common\models\orm\extend\RegChannelCfgUrl;
use common\models\orm\extend\RegChannelCfgUrlYapi;
use common\models\orm\extend\SimCard;
use common\library\Utils as commonUtils;
use common\models\orm\extend\RegOrderUrl;

class UrlTrigger extends Register{
    protected $_regChannelModel             = null;
    protected $_regOrderModel               = null;
    protected $_regChannelCfgRegParamsModel = null;
    protected $_regChannelCfgUrlModel       = null;
    protected $_regChannelCfgUrlYapiModel   = null;
    protected $_simCardModel                = null;
    
    public function __construct(RegChannel $regChannelModel,RegOrder $regOrderModel){
        $this->_regChannelModel              = $regChannelModel;
        $this->_regOrderModel                = $regOrderModel;
        $this->_regChannelCfgRegParamsModel  = RegChannelCfgRegParams::findByRcid($regChannelModel->rcid);
        $this->_regChannelCfgUrlModel        = RegChannelCfgUrl::findByRcid($regChannelModel->rcid);
        $this->_regChannelCfgUrlYapiModel    = RegChannelCfgUrlYapi::findByRcid($regChannelModel->rcid);
        $this->_simCardModel                 = SimCard::findByImsi($regOrderModel->imsi);
    }
    
    public function trigger(){
        //api url
        $url    = $this->_regChannelCfgUrlYapiModel->url;
        if(!stristr($url, '?') && $this->_regChannelCfgUrlYapiModel->sendMethod == 1){
            $url = $url.'?';
        }
        //api data
        $data   = $this->getDataByRegParamsProperty();
        
        //组装api
        $api    = array(
            'url'       => $url,
            'data'      => $data,
        );
        //传参方式
        if($this->_regChannelCfgUrlYapiModel->sendMethod != 1){
            $api['get'] = false;
        }
        $respFmt = Utils::getRespFmt($this->_regChannelCfgUrlYapiModel->respFmt);
        $result  = Utils::sendHttpResultToSp($api,$respFmt);
        
        $res = Utils::getTriggerStatus($result,$this->_regChannelCfgUrlYapiModel);
        $this->saveInfo($result);
        return $res;
    }
    
    
    public function saveInfo($result){
        if(commonUtils::isValid($this->_regChannelCfgUrlYapiModel->smtKey)){
            $smtUrl = commonUtils::getValuesFromArray($result, $this->_regChannelCfgUrlYapiModel->smtKey);
            RegOrderUrl::saveUrl($this->_regOrderModel->roid,$smtUrl);
        }
        if(commonUtils::isValid($this->_regChannelCfgUrlYapiModel->orderIdKey)){
            $orderId = self::getValuesFromArray($result,$this->_regChannelCfgUrlYapiModel->orderIdKey);
            $this->_regOrderModel->spOrderId = $orderId;
            $this->_regOrderModel->save();
        }
    }
}