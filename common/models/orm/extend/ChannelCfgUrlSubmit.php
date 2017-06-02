<?php
namespace common\models\orm\extend;
class ChannelCfgUrlSubmit extends \common\models\orm\base\ChannelCfgUrlSubmit{
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
