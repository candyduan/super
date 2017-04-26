<?php
namespace common\models\orm\extend;

use common\library\Utils;

class SdkProvinceTimeLimit extends \common\models\orm\base\SdkProvinceTimeLimit {
  /*  public static function getTimtLimitsBySplid($splid){
        $timelimits = self::find()->select(['stime','etime'])->where(['splid' => $splid,'status' => 1])->all();
        return $timelimits;
    }*/

    public static function getTimtLimitsBySdidProviderPrid($sdid, $provider, $prid){
        $timelimits = self::find()->select(['stime','etime'])
            ->where(['sdid' => $sdid, 'provider' => $provider, 'prid' => $prid,'status' => 1])
            ->all();
        return $timelimits;
    }

}