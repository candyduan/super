<?php
namespace frontend\library\regchannel;
use common\models\orm\extend\RegOrder;
use common\models\orm\extend\RegChannel;
use common\models\orm\extend\SimCard;
use common\library\Constant;
use yii\helpers\ArrayHelper;
use common\models\orm\extend\RegChannelVerifyRule;

class Utils{
    public static function createOrder($rcid,$imsi){
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
    public static function getRespFmt($respFmt){
        switch ($respFmt){
            case Constant::RESP_FMT_JSON:
                $respFmt    = 'json';
                break;
            case Constant::RESP_FMT_XML:
                $respFmt    = 'xml';
                break;
            case Constant::RESP_FMT_TEXT:
                $respFmt    = 'text';
                break;
            default:
                $respFmt    = 'text';
        }
        return $respFmt;
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
    
    public static function sendRegisterHttpResult($api,$format='json'){
        $response = self::httpRequest($api);
        $result = self::formatHttpResponseToArray($response,$format);
        return $result;
    }
    
    public static function httpRequest(array $api){
        $result = '';
        $url 		= $api['url'];
        $data 		= $api['data'];
        $get 		= $api['get'];
        $header 	= $api['header'];
        $timeout = $api['timeout'];
        $closeSSL 	= $api['closeSSL'];
        try {
            if($get){
                if (is_array($data) && !empty($data)){
                    $url .= http_build_query($data);
                }elseif (is_string($data)){
                    $url .= trim($data);
                }
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ;
                curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ;
            }else{
                $ch = curl_init();
                curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
                curl_setopt($ch,CURLOPT_COOKIEJAR,null);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
                curl_setopt($ch,CURLOPT_URL,$url);
                curl_setopt($ch,CURLOPT_POST,true);
                curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
            }
            if (is_array($header) && !empty($header) ) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            }
            if ($closeSSL){
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            }
            if (is_int($timeout) && $timeout > 0) {
                curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            }
            $response =  curl_exec($ch);
            $info = curl_getinfo($ch);
            $totalTime = self::getValuesFromArray($info, 'total_time','');
            $httpCode = self::getValuesFromArray($info, 'http_code','');
            if(curl_errno($ch)){
                $result = curl_error($ch);
            }elseif ($httpCode < 500){
                $response = trim($response);
                $order = array("\r\n", "\n", "\r");
                $result = str_replace($order, '', $response);
            }else{
                $result = 'httpCode: '.$httpCode.', totalTime: ' .$totalTime.' second ';
            }
            curl_close($ch);
        } catch (\Exception $e) {
            Utils::log($e->getMessage());
        }
        return $result;
    }
    
    public static function formatHttpResponseToArray($response,$format='json'){
        $result = array();
        $response = trim($response);
        try {
            switch (strtolower($format)){
                case 'json' :
                    $result = self::jsonDecode($response,true); break;
                case 'xml' :
                    $result = json_decode(json_encode((array) simplexml_load_string($response)), true);	break;
                default:
                    $result = array($response); break;
            }
        } catch (\Exception $e) {
            Utils::log($e->getMessage());
        }
        return $result;
    }
    
    public static function getValuesFromArray($result,$key,$defaultValue=null){
        $value = null;
        $key = trim($key);
        try {
            if($key === null){
                $value = null;
            }elseif($key === ''){
                $value = null;
            }elseif(substr($key, 0, 1) === '@'){
                $value = substr($key, 1);
            }else{
                $value = ArrayHelper::getValue($result,$key,$defaultValue);
            }
        } catch (\Exception $e) {
            Utils::log($e->getMessage());
        }
        return $value;
    }
    
    public static function getMessagesFromHttpResult($result, $successKey, $successValue,$messagesKey,$spOidKey=''){
        if ($successValue == self::getValuesFromArray($result, $successKey)){
            $pp1 = self::getValuesFromArray($result, self::getValuesFromArray($messagesKey,'0.0'));
            $pc1 = self::getValuesFromArray($result, self::getValuesFromArray($messagesKey,'0.1'));
            $b1 =  self::getValuesFromArray($result, self::getValuesFromArray($messagesKey,'0.2'));
            $pp2 = self::getValuesFromArray($result,  self::getValuesFromArray($messagesKey,'1.0'));
            $pc2 = self::getValuesFromArray($result,  self::getValuesFromArray($messagesKey,'1.1'));
            $b2 =  self::getValuesFromArray($result, self::getValuesFromArray($messagesKey,'1.2'));
            $pl = self::getValuesFromArray($result, self::getValuesFromArray($messagesKey,'1.3'));
            if ($pp1 && $pc1){
                $messages = [[$pp1,$pc1,$b1]];
            }else{
                $messages = [];
            }
            if ($pp2 && $pc2){
                if (empty($messages)){
                    $messages[0] = [$pp2,$pc2,$b2];
                }else{
                    $messages[1] = [$pp2,$pc2,$b2,$pl];
                }
    
            }
        }else{
            $messages = [];
        }
        return $messages;
    }
    
    public static function getGiveSdkRegisterResult(RegChannel $regChannelModel,RegOrder $regOrderModel,$messages){
        switch ($regChannelModel->devType){
            case Constant::CHANNEL_SINGLE:
                $res[]  = array(
                            'type'          => 1,
                            'roid'          => $regOrderModel->roid,
                            'subId'         => 1,
                            'port'          => $messages[0][0],
                            'cmd'           => $messages[0][1],
                            'sourcePort'    => '',
                            'sendType'      => $messages[0][2],
                            'httpMethod'    => '',
                            'httpData'      => '',
                            'httpParams'    => array(),
                            'httpHeader'    => array(),
                            'followed'      => 0,
                            'delayed'       => 0,
                            'blockPeriod'   => 3600,
                );
                break;
            case Constant::CHANNEL_DOUBLE:
                $res = array(
                    array(
                        'type'          => 1,
                        'roid'          => $regOrderModel->roid,
                        'subId'         => 1,
                        'port'          => $messages[0][0],
                        'cmd'           => $messages[0][1],
                        'sourcePort'    => '',
                        'sendType'      => $messages[0][2],
                        'httpMethod'    => '',
                        'httpData'      => '',
                        'httpParams'    => array(),
                        'httpHeader'    => array(),
                        'followed'      => 0,
                        'delayed'       => 0,
                        'blockPeriod'   => 3600,
                    ),
                    array(
                        'type'          => 1,
                        'roid'          => $regOrderModel->roid,
                        'subId'         => 2,
                        'port'          => $messages[1][0],
                        'cmd'           => $messages[1][1],
                        'sourcePort'    => '',
                        'sendType'      => $messages[1][2],
                        'httpMethod'    => '',
                        'httpData'      => '',
                        'httpParams'    => array(),
                        'httpHeader'    => array(),
                        'followed'      => 1,
                        'delayed'       => $messages[1][3],
                        'blockPeriod'   => 3600,
                    ),
                );
                break;                
            case Constant::CHANNEL_SMSP:
                //TODO
                break;
            case Constant::CHANNEL_URLP:
                //TODO
                break;
        }
        return $res;
    }
    
    
    public static function getMessagesFromSolidResult($solidResult,$spOid=''){
        $messages = $solidResult;
        return $messages;
    }
}