<?php
namespace common\models\orm\extend;
class ChannelMonitorRule extends \common\models\orm\base\ChannelMonitorRule{
    public static function findbyChid($chid){
        $condition  = array(
            'channel'   => $chid,
        );
        $model  = self::find()
                        ->where($condition)
                        ->one()
                        ;
        return $model;
    }
}
