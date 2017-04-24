<?php
namespace frontend\library\regchannel;
use common\library\Utils;
use common\models\orm\base\RegOrder;
use common\models\orm\base\RegChannel;
use common\models\orm\base\SimCard;
use common\library\Constant;

class Utils{
    public static function createOrderByRcidImsi($rcid,$imsi){
        if(!is_numeric($rcid) || !Utils::isValid($imsi)){
            return null;
        }
        $regOrderModel  = new RegOrder();
        $regOrderModel->imsi    = $imsi;
        $regOrderModel->rcid    = $rcid;
        $regOrderModel->recordTime = Utils::getNowTime();
        $regOrderModel->save();
        return $regOrderModel;
    }
    
    public static function gotoRegister(RegChannel $regChannelModel,RegOrder $regOrderModel,SimCard $simCardModel){
        $devType    = $regChannelModel->devType;
        switch ($devType){
            case Constant::CHANNEL_SINGLE:
            case Constant::CHANNEL_DOUBLE:
                $sdRegister    = new SdRegister($regChannelModel, $regOrderModel, $simCardModel);
                $res                = $sdRegister->register();
                break;
            case Constant::CHANNEL_SMSP:
                $smsRegister             = new SmsRegister($regChannelModel, $regOrderModel, $simCardModel);
                $res                = $smsRegister->register();
                break;
            case Constant::CHANNEL_URLP:
                $urlRegister             = new UrlRegister($regChannelModel, $regOrderModel, $simCardModel);
                $res                = $urlRegister->register();
                break;
            case Constant::CHANNEL_MULTURL:
                //TODO
                break;
            case Constant::CHANNEL_MULTSMS:
                //TODO
                break;
        }
        return $res;
    }
}