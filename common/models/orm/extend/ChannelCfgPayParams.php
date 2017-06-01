<?php
namespace common\models\orm\extend;
class ChannelCfgPayParams extends \common\models\orm\base\ChannelCfgPayParams{
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
