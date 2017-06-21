<?php
namespace common\models\orm\extend;
use yii\db\Query;
class SdkPlayerPay extends \common\models\orm\base\SdkPlayerPay{
    public static function getCountByCondition($select,$where = [],$group = []){
    
        $query = new Query();
        $query	->select($select)
        ->from('sdkPlayerPay')
        ->join('left join', 'campaignPackage',
            'sdkPlayerPay.cpid = campaignPackage.id')
            ->where($where)
            ->groupBy($group);
            $command = $query->createCommand();
            $data = $command->queryAll();
            if(count($data) > 0){
                return $data[0];
            }
            return null;
    }
}
