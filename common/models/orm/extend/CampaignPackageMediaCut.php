<?php
namespace common\models\orm\extend;
use common\library\Utils;

class CampaignPackageMediaCut extends \common\models\orm\base\CampaignPackageMediaCut{
    public static function findByCpidSdate($cpid = null,$sdate = null){
        if(!is_numeric($cpid) || !Utils::isDate($sdate)){
            return null;
        }
        return self::find()->where('cpid = :cpid and sdate = :sdate',array(
            ':cpid' => $cpid,
            ':sdate' => $sdate.' 00:00:00'
        ))
        ->orderBy('cpmcid desc')->one();
    }
    
    public static function findLastUnfinishedByCpid($cpid = null){
        if(!is_numeric($cpid)){
            return null;
        }
        return self::find()->where('cpid = :cpid and edate >= :edate',array(
            ':cpid' => $cpid,
            ':edate' => '2037-01-01 00:00:00'
        ))->orderBy('sdate desc')->one();
    }
}
