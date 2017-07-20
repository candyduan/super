<?php
namespace backend\library\cache;
use common\library\Utils;

class OrigApi {
    const SIGN = 'helloworld';
    public static function getCacheHost(){
        if(Utils::isAlphaBackend()){
            $host = 'pluto.com';
        }else{
            $host = '120.27.153.169:82';
        }
        return $host;
    }
    public static function deleteChannelVerifyRuleCache(){
        $url    = 'http://'.self::getCacheHost().'/index.php/cache/DelChannelVerifyRule?sign='.self::SIGN;
        $res    = Utils::zsCurl($url);
        $arr    = json_decode($res,true);
        
        if($arr['resultCode'] == 1){
            $flag   = true;
        }else{
            $flag   = false;
        }
        return $flag;
    }
}