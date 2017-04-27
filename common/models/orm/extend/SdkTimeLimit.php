<?php
namespace common\models\orm\extend;

use common\library\Utils;

class SdkTimeLimit extends \common\models\orm\base\SdkTimeLimit {

    public static function getTimtLimitsBySdid($sdid){
        $timelimits = self::find()->select(['stime','etime'])
            ->where(['sdid' => $sdid,'status' => 1])
            ->all();
        return $timelimits;
    }

    public static function deleteBySdid($sdid){
        $state = self::deleteAll(['sdid' => $sdid]);
        return $state;
    }

}