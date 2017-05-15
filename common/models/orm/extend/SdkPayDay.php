<?php
namespace common\models\orm\extend;

use common\library\Utils;

class SdkPayDay extends \common\models\orm\base\SdkPayDay {
   //由于AR sum 一直不成功 所以暂时先这样写。。。
    public static function getTodayByPridProvider($sdid, $prid, $provider,$date){
        $condition = [
            'sdid' => $sdid,
            'provider' => $provider,
            'date' => $date,
            'status'   => 1
        ];
        if($prid > 0){
            $condition['prid'] = $prid;
        }
        $return_data = [
            'sumallPay' => 0,
            'sumsuccessPay' => 0
        ];
        $data = self::find()->select(['allPay','successPay'])/*->select('SUM(allPay) as sumallpay, SUM(successPay) as sumsuccesspay')*/
            ->where($condition)
            ->all();
        foreach($data as $value){
            $return_data['sumallPay'] += $value['allPay'];
             $return_data['sumsuccessPay'] += $value['successPay'];
        }
         return $return_data;
    }

}