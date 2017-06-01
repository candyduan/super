<?php
namespace common\models\orm\extend;
class ChannelCfgSync extends \common\models\orm\base\ChannelCfgSync{
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
