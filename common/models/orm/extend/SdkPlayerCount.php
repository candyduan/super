<?php
namespace common\models\orm\extend;
use yii\db\Query;
class SdkPlayerCount extends \common\models\orm\base\SdkPlayerCount{
    public static function getCountByCondition($select,$where,$group = []){
        $query = new Query();
        $query	->select($select)
        ->from('sdkPlayerCount')
        ->join('left join', 'campaignPackage',
            'sdkPlayerCount.cpid = campaignPackage.id')
            ->where($where)
            ->groupBy($group);
        $command = $query->createCommand();
        $data = $command->queryAll();
        if(count($data) > 0){
           return $data[0];
        }
        return null;
    }
    public static function getAnalysisCountByCondition($select,$where,$group = []){
        $query = new Query();
        $query	->select($select)
        ->from('sdkPlayerCount as tmp')
        ->join('left join', 'campaignPackage',
            'tmp.cpid = campaignPackage.id')
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
