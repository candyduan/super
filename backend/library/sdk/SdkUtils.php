<?php
namespace backend\library\sdk;
use common\library\Utils;

class SdkUtils{
    public static function refreshFusionSdkCache(){
        $host = '127.0.0.1';// TODO
        $url = '/index.php/MC/RFSC';
        Utils::asyncRequest($host, $url);
    }
}