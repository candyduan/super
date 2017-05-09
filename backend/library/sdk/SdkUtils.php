<?php
namespace backend\library\sdk;
use common\library\Utils;

class SdkUtils{
    public static function refreshFusionSdkCache(){
        $host = 'p1.ilast.cc';
        if(Utils::isAlpha()){
            $host = '127.0.0.1';
        }
        $url = '/index.php/MC/RFSC';
        Utils::asyncRequest($host, $url);
    }
}