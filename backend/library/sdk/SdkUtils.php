<?php
namespace backend\library\sdk;
use common\library\Utils;
use common\models\orm\extend\CampaignPackage;

class SdkUtils{
    public static function refreshFusionSdkCache(){
        $host = 'p1.ilast.cc';
        if(Utils::isAlpha()){
            $host = 'paytest1.maimob.net';
        }
        $url = '/index.php/MC/RFSC';
        Utils::asyncRequest($host, $url);
    }
    public static function refreshCampaignPackage(CampaignPackage $model){
        if(!$model){
            return ;
        }
        // TODO 改为直接操作cache
        $host = 'p1.ilast.cc';
        if(Utils::isAlpha()){
            $host = 'paytest1.maimob.net';
        }
        $url = '/index.php/MC/RFSC?type=cp&cpid='.$model->id;
        Utils::asyncRequest($host, $url);
    }
}