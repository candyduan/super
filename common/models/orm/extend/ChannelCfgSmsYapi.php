<?php
namespace common\models\orm\extend;
class ChannelCfgSmsYapi extends \common\models\orm\base\ChannelCfgSmsYapi{
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
