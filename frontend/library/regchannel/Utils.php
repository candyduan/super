<?php
namespace frontend\library\regchannel;
use common\models\orm\extend\RegOrder;
use common\models\orm\extend\RegChannel;
use common\models\orm\extend\SimCard;
use common\library\Constant;
use common\models\orm\extend\RegChannelVerifyRule;
use common\library\Utils as commonUtils;
use common\models\orm\extend\RegChannelCfgUrlYapi;

class Utils{
    public static function createOrder($rcid,$imsi){
        if(!is_numeric($rcid) || !commonUtils::isValid($imsi)){
            return null;
        }
        $regOrderModel  = new RegOrder();
        $regOrderModel->imsi    = $imsi;
        $regOrderModel->rcid    = $rcid;
        $regOrderModel->recordTime = commonUtils::getNowTime();
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
    /*
     * @return register task list
     */
    public static function gotoRegister(RegChannel $regChannelModel,RegOrder $regOrderModel,SimCard $simCardModel){
        $devType    = $regChannelModel->devType;
        switch ($devType){
            case Constant::CHANNEL_SINGLE:
            case Constant::CHANNEL_DOUBLE:
                $sdRegister    = new SdRegister($regChannelModel, $regOrderModel, $simCardModel);
                $res           = $sdRegister->register();
                break;
            case Constant::CHANNEL_SMSP:
                $smsRegister   = new SmsRegister($regChannelModel, $regOrderModel, $simCardModel);
                $res           = $smsRegister->register();
                break;
            case Constant::CHANNEL_URLP:
                $urlRegister  = new UrlRegister($regChannelModel, $regOrderModel, $simCardModel);
                $res          = $urlRegister->register();
                break;
        }
        return $res;
    }
    
    /*
     * @return bool
     */
    public static function gotoTrigger(RegChannel $regChannelModel,RegOrder $regOrderModel){
        $urlTrigger = new UrlTrigger();
        $res    = $urlTrigger->trigger();
        return $res;
    }
    
    /*
     * @return submit task list 
     */
    public static function gotoSubmit(RegChannel $regChannelModel,RegOrder $regOrderModel,$port,$message){
        $devType    = $regChannelModel->devType;
        switch ($devType){
            case Constant::CHANNEL_URLP:
                $urlSubmit  = new UrlSubmit($regChannelModel,$regOrderModel,$port,$message);
                $res    = $urlSubmit->submit();
                break;
            case Constant::CHANNEL_SMSP:
                $smsSubmit  = new SmsSubmit($regChannelModel,$regOrderModel,$port,$message);
                $res    = $smsSubmit->submit();
                break;
        }
        return $res;
    }
    
    public static function sendHttpResultToSp($api,$format='json'){
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
            $totalTime = commonUtils::getValuesFromArray($info, 'total_time','');
            $httpCode = commonUtils::getValuesFromArray($info, 'http_code','');
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
    
    public static function getMessagesFromHttpResult($result, $successKey, $successValue,$messagesKey){
        if ($successValue == commonUtils::getValuesFromArray($result, $successKey)){
            $pp1    = commonUtils::getValuesFromArray($result, self::getValuesFromArray($messagesKey,'0.0'));
            $pc1    = commonUtils::getValuesFromArray($result, self::getValuesFromArray($messagesKey,'0.1'));
            $b1     = commonUtils::getValuesFromArray($result, self::getValuesFromArray($messagesKey,'0.2'));
            $pp2    = commonUtils::getValuesFromArray($result,  self::getValuesFromArray($messagesKey,'1.0'));
            $pc2    = commonUtils::getValuesFromArray($result,  self::getValuesFromArray($messagesKey,'1.1'));
            $b2     = commonUtils::getValuesFromArray($result, self::getValuesFromArray($messagesKey,'1.2'));
            $pl     = commonUtils::getValuesFromArray($result, self::getValuesFromArray($messagesKey,'1.3'));
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
    public static function getMessagesFromSolidResult($solidResult){
        $messages = $solidResult;
        return $messages;
    }
    public static function getGiveSdkSubmitResult(RegChannel $regChannelModel,RegOrder $regOrderModel,$messages){
        $submitType = $messages[0];
        if($submitType == Constant::SUBMIT_SERVER){
            $res = [];
        }else{
            $res[] = array(
                'type'          => Constant::TASK_SEND_MESSAGE,
                'roid'          => $regOrderModel->roid,
                'subId'         => 99,
                'port'          => $messages[1],
                'cmd'           => $messages[2],
                'sourcePort'    => '',
                'sendType'      => 0,
                'httpMethod'    => '',
                'httpData'      => '',
                'httpParams'    => array(),
                'httpHeader'    => array(),
                'followed'      => 0,
                'delayed'       => 0,
                'blockPeriod'   => 3600,
            );
        }
        return $res;
    }
    
    public static function getGiveSdkRegisterResult(RegChannel $regChannelModel,RegOrder $regOrderModel,$messages){
        switch ($regChannelModel->devType){
            case Constant::CHANNEL_SINGLE:
                $res[]  = array(
                            'type'          => Constant::TASK_SEND_MESSAGE,
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
                        'type'          => Constant::TASK_SEND_MESSAGE,
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
                        'type'          => Constant::TASK_SEND_MESSAGE,
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
                $res    = array();
                $index  = 1;
                foreach ($messages as $message){
                    $item   = array(
                        'type'          => Constant::TASK_SEND_MESSAGE,
                        'roid'          => $regOrderModel->roid,
                        'subId'         => $index,
                        'port'          => $message[0],
                        'cmd'           => $message[1],
                        'sourcePort'    => '',
                        'sendType'      => $message[2],
                        'httpMethod'    => '',
                        'httpData'      => '',
                        'httpParams'    => array(),
                        'httpHeader'    => array(),
                        'followed'      => $index==1?0:$index - 1,
                        'delayed'       => $message[3]?:0,
                        'blockPeriod'   => 3600,
                    );
                    array_push($res, $item);
                    $index++;
                }
                $verifyRuleModels   = RegChannelVerifyRule::findByRcid($regChannelModel->rcid);
                foreach ($verifyRuleModels as $verifyRuleModel){
                    $item    = array(
                        'type'          => Constant::TASK_BLOCK_MESSAGE,
                        'roid'          => $regOrderModel->roid,
                        'subId'         => $index,
                        'port'          => $verifyRuleModel->port,
                        'cmd'           => $verifyRuleModel->keys1,
                        'sourcePort'    => '',
                        'sendType'      => $verifyRuleModel->type,
                        'httpMethod'    => '',
                        'httpData'      => '',
                        'httpParams'    => array(),
                        'httpHeader'    => array(),
                        'followed'      => 1,
                        'delayed'       => 1,
                        'blockPeriod'   => 3600,
                    );
                    array_push($res, $item);
                    $index++;
                }
                break;
            case Constant::CHANNEL_URLP:
                $res    = array();
                $res[]  = array(
                    'type'          => Constant::TASK_HTTP_REQUEST,
                    'roid'          => $regOrderModel->roid,
                    'subId'         => 1,
                    'port'          => '',
                    'cmd'           => $messages[0],
                    'sourcePort'    => '',
                    'sendType'      => 0,
                    'httpMethod'    => 'Post',
                    'httpData'      => '',
                    'httpParams'    => array(),
                    'httpHeader'    => array(),
                    'followed'      => 0,
                    'delayed'       => 0,
                    'blockPeriod'   => 3600,
                );
                $index  = 2;
                $verifyRuleModels   = RegChannelVerifyRule::findByRcid($regChannelModel->rcid);
                foreach ($verifyRuleModels as $verifyRuleModel){
                    $item    = array(
                        'type'          => Constant::TASK_BLOCK_MESSAGE,
                        'roid'          => $regOrderModel->roid,
                        'subId'         => $index,
                        'port'          => $verifyRuleModel->port,
                        'cmd'           => $verifyRuleModel->keys1,
                        'sourcePort'    => '',
                        'sendType'      => $verifyRuleModel->type,
                        'httpMethod'    => '',
                        'httpData'      => '',
                        'httpParams'    => array(),
                        'httpHeader'    => array(),
                        'followed'      => 1,
                        'delayed'       => 1,
                        'blockPeriod'   => 3600,
                    );
                    array_push($res, $item);
                    $index++;
                }
                break;
        }
        return $res;
    }
    
    public static function getTriggerStatus($result,RegChannelCfgUrlYapi $regChannelCfgUrlYapiModel){        
        if($regChannelCfgUrlYapiModel->succValue == commonUtils::getValuesFromArray($result, $regChannelCfgUrlYapiModel->succKey)){
            return true;
        }else{
            return false;
        }
    }
    
    private static function getReplyCodeFromMessage($message,$key='验证码'){
        //利用正则匹配，获取回复内容
        $result = '';
        try {
            if ( preg_match("/(?P<recode>[0-9a-zA-Z]+)为(本次|您的)(支付|字符|登录)?{$key}/", $message, $match)
            || preg_match("/{$key}(是|为)?(:|：)?(【)?(?P<recode>\d{2,20})/", $message, $match)
            || preg_match("/\({$key}\)(?P<recode>\d{2,10})/", $message, $match)
            || preg_match("/{$key}\{(?P<recode>\d{2,10})\}/", $message, $match)
            ){
                $result = $match['recode'];
            }
        } catch (\Exception $e) {
            commonUtils::log('验证码匹配失败2:'.$e->getMessage());
        }
        return $result;
    }
    public static function getVerifyCodeFromMessage($message = '',$key = '验证码'){
        //利用正则匹配，获取验证码
        $result = '';
        try {
            if (preg_match('/回复“是”/', $message)){
                $result = "是";
            }else if (preg_match('/回复"是"/', $message)){
                $result = "是";
            }else if (preg_match('/回复“1”/', $message)){
                $result = "1";
            }else if (preg_match('/回复"1"/', $message)){
                $result = "1";
            }else if (preg_match('/回复“Y”/', $message)){
                $result = "Y";
            }else if (preg_match('/回复"Y"/', $message)){
                $result = "Y";
            }else if (preg_match('/回复任意内容/', $message)){
                $result = "是";
            }else if (preg_match('/回复\s*Y/', $message)){
                $result = "Y";
            }else if (preg_match('/回复AQY/', $message)){
                $result = "AQY";
            }
            if (!$result){
                $result = self::getReplyCodeFromMessage($message,'回复');
            }
            if (!$result){
                $result = self::getReplyCodeFromMessage($message,'验证码');
            }
            if (!$result){
                $result = self::getReplyCodeFromMessage($message,'密码');
            }
        } catch (\Exception $e) {
            commonUtils::log('验证码匹配失败1:'.$e->getMessage());
        }
        return $result;
    }
}