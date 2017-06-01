<?php
namespace common\models\orm\extend;
class ChannelCfgSd extends \common\models\orm\base\ChannelCfgSd{
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
            $model  = new ChannelCfgSd();
            $model->channelId   = $chid;
        }
        $model->api = $api;
        return $model->save();
    }
}
