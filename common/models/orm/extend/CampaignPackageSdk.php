<?php
namespace common\models\orm\extend;
class CampaignPackageSdk extends \common\models\orm\base\CampaignPackageSdk{
    public static function getSignByCpidSdid($cpid,$sdid){
        $data = self::find()->select(['distSign'])->where(['sdid' => $sdid,'cpid' => $cpid])->one();
        return isset($data['distSign']) ? $data['distSign'] :'';
    }
    
    public static function findByCpidSdid($cpid,$sdid){
        if(!is_numeric($cpid) || !is_numeric($sdid)){
            return null;
        }
        return self::find()->where(['sdid' => $sdid,'cpid' => $cpid])->one();
    }
}