<?php
namespace common\models\orm\extend;
class ChannelCfgSmsSdkSubmit extends \common\models\orm\base\ChannelCfgSmsSdkSubmit{
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
