<?php
/**
 * Created by PhpStorm.
 * User: maimob
 * Date: 2017/6/13
 * Time: 下午1:41
 */
namespace common\models\orm\extend;

class ChannelCfgToSync extends \common\models\orm\base\ChannelCfgToSync {
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