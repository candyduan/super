<?php
namespace common\models\orm\extend;
class ChannelCfgMain extends \common\models\orm\base\ChannelCfgMain{
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
    
    public static function backendOps($chid){
        $mainModel     = ChannelCfgMain::findByChannelId($chid);
        if(!$mainModel){
            $mainModel  = new ChannelCfgMain();
            $mainModel->channelId   = $chid;
            $mainModel->save();
        }
        return $mainModel;
    }
}
