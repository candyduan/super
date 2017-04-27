<?php
namespace common\models\orm\extend;
use common\library\Utils;

class RegOrderUrl extends \common\models\orm\base\RegOrderUrl{
    public static function saveUrl($roid,$url){
        if(!is_numeric($roid) || !Utils::isValid($url)){
            return false;
        }
        $model  = self::findByRoid($roid);
        if(!$model){
            $model = new RegOrderUrl();
            $model->roid = $roid;
        }
        $model->url = $url;
        return $model->save();
    }
    
    public static function getUrl($roid){
        if(!is_numeric($roid)){
            return '';
        }
        $model  = self::findByRoid($roid);
        $url = '';
        if($model){
            $url = $model->url;
        }
        return $url;
    }
    
    
    public static function findByRoid($roid){
        $condition  = array(
                        'roid'  => $roid,
                    );
        $model  = self::find()
                        ->where($condition)
                        ->one()
                        ;
        return $model;
    }
}