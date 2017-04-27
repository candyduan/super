<?php
namespace common\models\orm\extend;
use common\library\Utils;

class RegOrderUrl extends \common\models\orm\base\RegOrderUrl{
    public static function saveUrl($rcid,$url){
        if(!is_numeric($rcid) || !Utils::isValid($url)){
            return false;
        }
        $model  = self::findByRcid($rcid);
        if(!$model){
            $model = new RegOrderUrl();
            $model->rcid = $rcid;
        }
        $model->url = $url;
        $model->save();
    }
    
    
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