<?php
namespace common\models\orm\extend;

use common\library\Utils;

class CampaignSdk extends \common\models\orm\base\CampaignSdk {

    public static function getSdidAppidByCaid($caid)
    {
        $data = self::find()->select(['sdid','appid','status'])->where(['caid' => $caid])->all();
        $return_data = [];
        foreach($data as $value){
            $return_data[] = [
                'sdid' => $value['sdid'],
                'appid' =>$value['appid'],
                'status' => $value['status']
            ];
        }
        return $return_data;
    }

    public static function findBySdidCaid($sdid,$caid){

        $model  = self::find()->where(['sdid' => $sdid,'caid' => $caid])->one();
        return $model;
    }

    public static function fetchAllByCaid($caid){
        $data = self::find()->where(['caid' => $caid])->all();
        if(count($data <= 0)){
            return array();
        }
        return $data;
    }
    public static function sdidCaidNotExist($sdid,$caid){
        if(!Utils::isValid($sdid) || !Utils::isValid($caid) ){
            return NULL;
        }
        $model  = self::find()->where(['caid' => $caid,'sdid' =>$sdid])->one();
        return (empty($model)) ? true : false;

    }

}