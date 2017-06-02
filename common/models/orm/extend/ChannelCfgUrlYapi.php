<?php
namespace common\models\orm\extend;
class ChannelCfgUrlYapi extends \common\models\orm\base\ChannelCfgUrlYapi{
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
