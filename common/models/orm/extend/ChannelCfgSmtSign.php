<?php
namespace common\models\orm\extend;
class ChannelCfgSmtSign extends \common\models\orm\base\ChannelCfgSmtSign{
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
