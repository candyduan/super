<?php
namespace common\models\orm\extend;
class RegChannelCfgMain extends \common\models\orm\base\RegChannelCfgMain{
    public static function useCfgChannel($rcid = 0){
        if(!is_numeric($rcid)){
            return false;
        }
        $model  = self::findByRcid($rcid);
        if($model){
            return true;
        }else{
            return false;
        }
    }
    
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