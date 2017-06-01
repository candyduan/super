<?php
namespace common\models\orm\extend;
class ChannelCfgSmsSubmit extends \common\models\orm\base\ChannelCfgSmsSubmit{
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
