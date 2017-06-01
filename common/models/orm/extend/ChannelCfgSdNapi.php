<?php
namespace common\models\orm\extend;
class ChannelCfgSdNapi extends \common\models\orm\base\ChannelCfgSdNapi{
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
