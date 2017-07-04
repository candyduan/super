<?php
namespace common\models\orm\extend;
class ChannelCfgUrlSdkSubmit extends \common\models\orm\base\ChannelCfgUrlSdkSubmit{
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
