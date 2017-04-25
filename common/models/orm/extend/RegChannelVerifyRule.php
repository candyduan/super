<?php
namespace common\models\orm\extend;
class RegChannelVerifyRule extends \common\models\orm\base\RegChannelVerifyRule{
    const TYPE_CAPTCHA  = 1;
    const TYPE_SUCC     = 2;    
    public static function findByRcid($rcid){
        if(!is_numeric($rcid)){
            return [];
        }
        $condition  = array(
            'rcid'      => $rcid,
            'status'    => 1,
            );
        $models = self::find()
                    ->where($condition)
                    ->all()
                    ;
        return $models;
    }
}