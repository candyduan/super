<?php
namespace common\models\orm\extend;
class RegChannelCfgSmtParams extends \common\models\orm\base\RegChannelCfgSmtParams{
    public static function findByRcid($rcid){
        $condition  = array(
            'rcid'  => $rcid,
        );
        $model  = self::find()
                    ->where($condition)
                    ->one()
                    ;
        return $model;
    }
}