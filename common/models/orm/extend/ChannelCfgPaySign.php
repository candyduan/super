<?php
namespace common\models\orm\extend;
class ChannelCfgPaySign extends \common\models\orm\base\ChannelCfgPaySign{
    public static function findByChannelId($id){
        $condition  = array(
            'channelId' => $id
        );
        $model  = self::find()
                        ->where($condition)
                        ->one()
                        ;
        return $model;
    }
}
