<?php
namespace common\models\orm\extend;

use common\library\Utils;
use yii\db\Query;

class SdkPayDay extends \common\models\orm\base\SdkPayDay {
   //由于AR sum 一直不成功 又不想直接用sql 所以暂时先这样写。。。
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
        $data = self::find()->select(['allPay','successPay'])/*->select(['SUM(allPay) as sumallpay', 'SUM(successPay) as sumsuccesspay'])*/
            ->where($condition)
            ->all();
        foreach($data as $value){
            $return_data['sumallPay'] += $value['allPay'];
             $return_data['sumsuccessPay'] += $value['successPay'];
        }
         return $return_data;
    }
    
    public static function getIndexData($where, $start,$length){
        $query = new Query();
        $query	->select([
            'sdk.name as sdk',
            'province.name as provinceName',
            'sdkPayDay.*']
            )
            ->from('sdkPayDay')
            ->join('inner join', 'sdk',
                'sdkPayDay.sdid = sdk.sdid')
            ->join('inner join', 'province',
                'sdkPayDay.prid = province.id')
            ->where($where)
            ->offset($start)
            ->limit($length);
        $command = $query->orderBy('sdkPayDay.spdid desc')->createCommand();
        $data = $command->queryAll();
        return $data;
    }
    public static function getIndexCount($where){
        $count = self::find()->where($where)->count();
        return $count;
    }
}