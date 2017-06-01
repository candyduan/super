<?php
namespace common\models\orm\extend;
class ChannelCfgSms extends \common\models\orm\base\ChannelCfgSms{
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
