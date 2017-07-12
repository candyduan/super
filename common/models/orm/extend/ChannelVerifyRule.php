<?php
namespace common\models\orm\extend;
class ChannelVerifyRule extends \common\models\orm\base\ChannelVerifyRule{
    public static function findByChannelType($chid,$type){
        $condition  = array(
            'channel'   => $chid,
            'type'      => $type,
        );
        $models = self::find()
                        ->where($condition)
                        ->all()
                        ;
        return $models;
    }
}
