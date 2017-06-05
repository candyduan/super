<?php
namespace common\models\orm\extend;
use yii\db\Query;
use common\library\Utils;

class SdkPlayer extends \common\models\orm\base\SdkPlayer{

    public static function getCountByCondition($select,$where,$group = []){
        $query = new Query();
        $query	->select($select)
        ->from('sdkPlayer')
        ->join('left join', 'campaignPackage',
            'sdkPlayer.cpid = campaignPackage.id')
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
