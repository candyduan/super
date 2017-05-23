<?php
namespace frontend\library\hndchannel;
use common\models\orm\extend\RegChannel;
use common\models\orm\extend\RegOrder;
use common\models\orm\extend\SimCard;
use frontend\library\regchannel\Utils;

class Channel_1{
    public static function register(RegChannel $regChannelModel, RegOrder $regOrderModel, SimCard $simCardModel){
        $solidResult    = [['12306','999','0']];
        $messages = Utils::getMessagesFromSolidResult($solidResult);
        $res      = Utils::getGiveSdkRegisterResult($regChannelModel,$regOrderModel,$messages);
        return $res;        
    }
    
    
    public static function submit(RegChannel $regChannelModel,RegOrder $regOrderModel,$port,$message){
    }
}