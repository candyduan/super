<?php
namespace common\models\orm\extend;

use common\library\Utils;

class SdkSort extends \common\models\orm\base\SdkSort {

    public static function getSortByProvider($provider){
        $data = self::find()->select(['sort'])
            ->where(['provider' => $provider,'status' => 1])
            ->all();
        return isset($data['sort']) ? $data['sort'] : '' ;
    }

    public static function deleteBySdid($sdid){
        $state = self::deleteAll(['sdid' => $sdid]);
        return $state;
    }

}