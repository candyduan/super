<?php
namespace common\models\orm\extend;
class ChannelCfgSmtParams extends \common\models\orm\base\ChannelCfgSmtParams{
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
