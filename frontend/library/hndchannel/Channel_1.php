<?php
namespace frontend\library\hndchannel;
use common\models\orm\extend\RegChannel;
use common\models\orm\extend\RegOrder;
use common\models\orm\extend\SimCard;
use frontend\library\regchannel\Utils;
use common\library\Constant;

class Channel_1{
    public static function register(RegChannel $regChannelModel, RegOrder $regOrderModel, SimCard $simCardModel){
        $solidResult    = [['12306','999','0']];
        $regOrderModel->spSign = Utils::getSpSign($regOrderModel);
        $regOrderModel->save();
        $messages = Utils::getMessagesFromSolidResult($solidResult);
        $res      = Utils::getGiveSdkRegisterResult($regChannelModel,$regOrderModel,$messages);
        Utils::afterRegister($regOrderModel,$messages,$res);
        return $res;        
    }
    
    
    public static function submit(RegChannel $regChannelModel,RegOrder $regOrderModel,$port,$message){
        $simCardModel   = SimCard::findByImsi($regOrderModel->imsi);
        $api = array(
            'url'	=> "http://120.55.87.166/tbServer/shsuwangDXsms?",
            'data'	=> array(
                'productId'     => 'hd005',
                'cpid'          => '10jf0000168',
                'tel'           => $simCardModel->mobile,
                'ext'           => $regOrderModel->spSign,
                'imsi'          => $regOrderModel->imsi,
                'smsContent'    => $message,
            ),
        );
        $respFmt    = 'text';
        $result     = Utils::sendHttpResultToSp($api,$respFmt);
        $messages   = [Constant::SUBMIT_SERVER,];
        $res        = Utils::getGiveSdkSubmitResult($regChannelModel, $regOrderModel, $messages);
        Utils::afterSubmit($regOrderModel,$result,$res);
        return $res;            
    }
    
    public static function sync(RegChannel $regChannelModel,array $data){
        $status = \common\library\Utils::getValuesFromArray($data, 'status') == "DELIVRD" ? 1 : 0;
        if($status){            
            $spSign = \common\library\Utils::getValuesFromArray($data, 'cpparam');
            $regOrderModel  = RegOrder::findBySpSign($spSign);
            $regOrderModel->status = RegOrder::STATUS_SYNCDONE;
            $regOrderModel->save();
            $res = '{code:"0",msg:"shi"}';
        }else{
            $res = '{code:"1",msg:"fail"}';
        }
        Utils::afterSync($regOrderModel,$data,$res);
        return $res;
    }
}