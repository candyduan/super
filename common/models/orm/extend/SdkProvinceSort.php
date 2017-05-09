<?php
namespace common\models\orm\extend;

use common\library\Utils;

class SdkProvinceSort extends \common\models\orm\base\SdkProvinceSort {

    public static function getSortByPridProvider($prid, $provider){
        $data = self::find()->select(['sort'])
            ->where(['prid' => $prid,'provider' => $provider,'status' => 1])
            ->one();
        return isset($data['sort']) ? $data['sort'] : '' ;
    }

    public static function deleteByProvider($provider){
        $condition = [
            'provider' => $provider
        ];
        $state = self::deleteAll($condition);
        return $state;
    }

    public static function deleteByProviderPrid($provider,$prid){
        $condition = [
            'provider' => $provider,
            'prid' => $prid
        ];
        $state = self::deleteAll($condition);
        return $state;
    }

}