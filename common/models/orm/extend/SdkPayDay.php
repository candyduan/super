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
        $data = self::find()->select(['allPay','successPay'])
            ->where($condition)
            ->all();
        foreach($data as $value){
            $return_data['sumallPay'] += $value['allPay'];
             $return_data['sumsuccessPay'] += $value['successPay'];
        }
         return $return_data;
    }
    
    public static function getIndexData($select,$where,$group, $start = null,$length = null){
        $query = new Query();
        $query	->select($select)
            ->from('sdkPayDay')
            ->join('left join', 'sdk',
                'sdkPayDay.sdid = sdk.sdid')
            ->join('left join', 'province',
                'sdkPayDay.prid = province.id')
            ->where($where)
            ->groupBy($group);
        if($start){
            $query->offset($start);
        }
        if($length){
            $query->limit($length);
        }
        $command = $query->orderBy('sdkPayDay.date desc')->createCommand();
        $data = $command->queryAll();
        return $data;
    }
    public static function getIndexCount($where,$group){
        $count = self::find()->join('left join', 'sdk',
                'sdkPayDay.sdid = sdk.sdid')
            ->join('left join', 'province',
                'sdkPayDay.prid = province.id')->where($where)->groupBy($group)->count();
        return $count;
    }
}