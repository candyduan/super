<?php
namespace common\models\orm\extend;
class ChannelPrice extends \common\models\orm\base\ChannelPrice{
    public static function findByChid($chid){
        $condition  = array(
            'channel'   => $chid,
        );
        $models = self::find()
                        ->where($condition)
                        ->orderBy('price DESC')
                        ->all()
                        ;
        return $models;
    }
    
    public static function findByChidPrice($chid,$price){
        $condition  = array(
            'channel'   => $chid,
            'price'     => $price,
        );
        $model  = self::find()
                        ->where($condition)
                        ->one()
                        ;
        return $model;
    }
    
    public static function findByPk($id){
        $condition  = array(
            'id'    => $id,
        );
        $model  = self::find()
                        ->where($condition)
                        ->one()
                        ;
        return $model;
    }
}
