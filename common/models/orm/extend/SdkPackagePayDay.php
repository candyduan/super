<?php
namespace common\models\orm\extend;
use yii\db\Query;
class SdkPackagePayDay extends \common\models\orm\base\SdkPackagePayDay{

    public static function getIndexData($select,$where,$group, $start = null,$length = null){
        $query = new Query();
        $query	->select($select)
        ->from('sdkPackagePayDay')
        ->join('inner join', 'campaignPackage',
            'sdkPackagePayDay.cpid = campaignPackage.id')
        ->join('inner join','app',
                'campaignPackage.app = app.id')
        ->join('inner join', 'partner as partner',
                'campaignPackage.partner = partner.id')
        ->join('inner join','partner as channel',
                    'campaignPackage.media = channel.id')
        ->join('inner join','campaign',
                    'campaignPackage.campaign = campaign.id')
        ->where($where)
        ->groupBy($group);
        if($start){
            $query->offset($start);
        }
        if($length){
            $query->limit($length);
        }
        $command = $query->orderBy('sdkPackagePayDay.date desc')->createCommand();
        $data = $command->queryAll();
        return $data;
    }
    public static function getIndexCount($where,$group){
        $count = self::find()
        ->from('sdkPackagePayDay')
        ->join('inner join', 'campaignPackage',
            'sdkPackagePayDay.cpid = campaignPackage.id')
            ->join('inner join','app',
                'campaignPackage.app = app.id')
                ->join('inner join', 'partner as partner',
                    'campaignPackage.partner = partner.id')
                    ->join('inner join','partner as channel',
                        'campaignPackage.media = channel.id')
                        ->join('inner join','campaign',
                            'campaignPackage.campaign = campaign.id')
        ->where($where)->groupBy($group)->count();
        return $count;
    }
}
