<?php
namespace common\models\orm\extend;
class ChannelCfgSmsNapi extends \common\models\orm\base\ChannelCfgSmsNapi{
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
