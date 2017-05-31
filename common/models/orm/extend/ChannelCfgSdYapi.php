<?php
namespace common\models\orm\extend;
class ChannelCfgSdYapi extends \common\models\orm\base\ChannelCfgSdYapi{
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
