<?php
namespace common\models\orm\extend;

use common\library\Utils;

class SdkProvinceLimit extends \common\models\orm\base\SdkProvinceLimit {
    public static function getlimitPrids($sdid,$provider){
        $data  = self::find()->select(['prid'])->where(['sdid' => $sdid, 'provider' => $provider, 'status' => 0])->all();
        $return_data = [];
        foreach($data as $value){
            $return_data[]= $value['prid'];
        }
        return $return_data;
    }

    /*    public static function getByPridSdidProvider($sdid,$provider,$prid){
            $model  = self::find()->where(['sdid' => $sdid, 'provider' => $provider, 'prid' => $prid])->all();
            return empty($model) ? false : true;
        }*/

    public static function deleteByPridSdidProvider($prid,$sdid,$provider){
        $state = self::deleteAll(['prid' => $prid, 'sdid' => $sdid, 'provider' =>$provider]);
        return $state;
    }

    public static function getLimitCountByProviderandPrid($provider,$prid){
        $condition = [
            'provider' => $provider,
            'prid' => $prid,
            'status' => 0 //表示屏蔽
        ];
        $count = self::find()->where($condition)->count();
        return $count;
    }

}