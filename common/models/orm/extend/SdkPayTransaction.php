<?php
namespace common\models\orm\extend;

use yii\db\Query;
class SdkPayTransaction extends \common\models\orm\base\SdkPayTransaction{
    public static function getIndexData($select,$where,$group, $start = null,$length = null){
        $query = new Query();
        $query	->select($select)
        ->from('sdkPayTransaction')
        ->join('inner join', 'sdk',
            'sdkPayTransaction.sdid = sdk.sdid')
            ->join('inner join', 'province',
                'sdkPayTransaction.prid = province.id')
                ->where($where)
                ->groupBy($group);
                if($start){
                    $query->offset($start);
                }
                if($length){
                    $query->limit($length);
                }
                $command = $query->orderBy('sdkPayTransaction.recordTime desc')->createCommand();
                $data = $command->queryAll();
                return $data;
    }
    public static function getIndexCount($where,$group){
        $count = self::find()->join('inner join', 'sdk',
            'sdkPayTransaction.sdid = sdk.sdid')
            ->join('inner join', 'province',
                'sdkPayTransaction.prid = province.id')->where($where)->groupBy($group)->count();
            return $count;
    }
}
