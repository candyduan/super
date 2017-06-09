<?php
namespace common\models\orm\extend;

use yii\db\Query;
use common\library\Utils;
class SdkPayTransaction extends \common\models\orm\base\SdkPayTransaction{
    const  DISABLE_SDK_STATUS = "sdkPayTransaction.sdkStatus not in(3034,3044,3054,3064,3074,3084,9994)";
    public static function getIndexData($select,$where = [],$group, $start = null,$length = null){
        $where[] = SdkPayTransaction::DISABLE_SDK_STATUS;
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
    public static function getIndexCount($where = [],$group){
        $where[] = SdkPayTransaction::DISABLE_SDK_STATUS;
        $count = self::find()->join('inner join', 'sdk',
            'sdkPayTransaction.sdid = sdk.sdid')
            ->join('inner join', 'province',
                'sdkPayTransaction.prid = province.id')->where($where)->groupBy($group)->count();
            return $count;
    }
    
    public static function getCountByCondition($select,$where = [],$group = []){
        $where[] = SdkPayTransaction::DISABLE_SDK_STATUS;
        
        $query = new Query();
        $query	->select($select)
        ->from('sdkPayTransaction')
        ->join('left join', 'campaignPackage',
            'sdkPayTransaction.cpid = campaignPackage.id')
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
