<?php
namespace common\models\orm\extend;
class ChannelCfgSms extends \common\models\orm\base\ChannelCfgSms{
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
    
    public static function backendOps($chid,$api){
        $model  = self::findByChannelId($chid);
        if(!$model){
            $model  = new ChannelCfgSms();
            $model->channelId   = $chid;
        }
        $model->api = $api;
        return $model->save();
    }
}
