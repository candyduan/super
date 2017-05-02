<?php
namespace common\models\orm\extend;

use common\library\Utils;

class SdkProvinceSort extends \common\models\orm\base\SdkProvinceSort {

    public static function getSortByPridProvider($prid, $provider){
        $data = self::find()->select(['sort'])
            ->where(['prid' => $prid,'provider' => $provider,'status' => 1])
            ->all();
        return isset($data['sort']) ? $data['sort'] : '' ;
    }

    public static function deleteBySdid($sdid){
        $state = self::deleteAll(['sdid' => $sdid]);
        return $state;
    }

}