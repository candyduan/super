<?php
namespace common\models\orm\extend;

use common\library\Utils;

class SdkCampaignLimit extends \common\models\orm\base\SdkCampaignLimit {
    public static function getlimitCaids($sdid,$type){
        $data  = self::find()->select(['caid'])->where(['sdid' => $sdid, 'type' => $type, 'status' => 1])->all();
        $return_data = [];
        foreach($data as $value){
            $return_data[]= $value['caid'];
        }
        return $return_data;
    }

    /*    public static function getByPridSdidProvider($sdid,$provider,$prid){
            $model  = self::find()->where(['sdid' => $sdid, 'provider' => $provider, 'prid' => $prid])->all();
            return empty($model) ? false : true;
        }*/

    public static function deleteBySdid($sdid){
        $state = self::deleteAll([ 'sdid' => $sdid]);
        return $state;
    }

}