<?php
namespace common\models\orm\extend;
use yii\db\Query;
class SdkPlayerPayCount extends \common\models\orm\base\SdkPlayerPayCount{
    
    public static function getPayUsers($select,$where,$group = []){
        $query = new Query();
        $query	->select($select)
        ->from('sdkPlayerPayCount as tmp')
        ->join('left join', 'campaignPackage',
            'tmp.cpid = campaignPackage.id')
            ->where($where)
            ->groupBy($group);
            $command = $query->createCommand();
            $data = $command->queryAll();
            if(count($data) > 0){
                $payUsers = $data[0]['payUsers'];
                if(!is_numeric($payUsers)){
                    $payUsers = 0;
                }
                return $payUsers;
            }
            return 0;
    }
}
