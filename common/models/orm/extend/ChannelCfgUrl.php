<?php
namespace common\models\orm\extend;
class ChannelCfgUrl extends \common\models\orm\base\ChannelCfgUrl{
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
