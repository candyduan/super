<?php
namespace common\models\orm\extend;
class ChannelCfgOut extends \common\models\orm\base\ChannelCfgOut{
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
