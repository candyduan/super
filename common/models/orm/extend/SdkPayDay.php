<?php
namespace common\models\orm\extend;

use common\library\Utils;

class SdkPayDay extends \common\models\orm\base\SdkPayDay {

    public static function getTodayByPridProvider($prid, $provider,$date){
        $condition = [
            'provider' => $provider,
            'date' => $date,
            'status'   => 1
        ];
        if(!$prid > 0){
            $condition['prid'] = $prid;
        }
        $data = self::find()->select(['sum(allPay) as sumallpay', 'sum(successPay) as sumsuccesspay'])
            ->where($condition)
            ->all();
         return $data;
    }

}