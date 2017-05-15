<?php
namespace common\models\orm\extend;
class RegChannelCfgSmsSubmit extends \common\models\orm\base\RegChannelCfgSmsSubmit{
    public static function findByRcid($rcid){
        if(!is_numeric($rcid)){
            return null;
        }
        $condition  = array(
            'rcid'      => $rcid,
            'status'    => 1,
        );
        $model  = self::find()
                    ->where($condition)
                    ->one()
                    ;
        return $model;
    }
    
}