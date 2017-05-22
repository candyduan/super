<?php
namespace common\models\orm\extend;
use common\library\Utils;
use yii\db\Query;

class PlayerCount extends \common\models\orm\base\PlayerCount{

    public static function getNewAndActUserByCondition($checkCP,$checkAPP,$checkCmp,$checkM,$partner,$app,$channel,$stime,$etime,$dateType){
        $select = ['sum(playerCount.newCount) as newCount','sum(playerCount.activeCount) as activeCount'];
        $where[] = 'and';
        
        if(Utils::isValid($partner)){
            $where[] = [
                'like',
                'partner.name',
                $partner
            ];
        }
        if($app > 0){
            $where[] = [
                '=',
                'app.id',
                $app
            ];
        }
        if($channel > 0){
            $where[] = [
                '=',
                'campaignPackage.partner',
                $channel
            ];
        }
        
        switch ($dateType){
            case 1:// 天
            case 3://时段
                if(Utils::isDate($stime)){
                    $where[] = [
                        '>=',
                        'FROM_UNIXTIME(playerCount.day)',
                        $stime.' 00:00:00'
                    ];
                }
                if(Utils::isDate($etime)){
                    $where[] = [
                        '<=',
                        'FROM_UNIXTIME(playerCount.day)',
                        $etime.' 23:59:59'
                    ];
                }
                break;
            case 4://月份
                $sdate = date('Y-m-01',strtotime($stime));
                $edate = date('Y-m-01',strtotime($etime));
                $edate = date("Y-m-d",strtotime("$edate 1 month -1 day"));
        
                $where[] = [
                    '>=',
                    'FROM_UNIXTIME(playerCount.day',
                    $sdate.' 00:00:00'
                ];
                $where[] = [
                    '<=',
                    'FROM_UNIXTIME(playerCount.day',
                    $edate.' 23:59:59'
                ];
                break;
        }
        
        $group = [];
        if(1 == $dateType){//按天统计
            $group[] = 'playerCount.date';
        }
        if($checkCP){
            $group[] = 'campaignPackage.partner';
        }
        if($checkAPP){
            $group[] = 'campaignPackage.app';
        }
        if($checkCmp){
            $group[] = 'campaignPackage.id';
        }
        if($checkM){
            $group[] = 'campaignPackage.media';
        }
        
        $query = new Query();
        $query	->select($select)
        ->from('playerCount')
        ->join('inner join', 'campaignPackage',
            'playerCount.mediaSign = campaignPackage.mediaSign')
            ->join('inner join','partner',
                'campaignPackage.partner = partner.id')
                ->join('inner join','app',
                    'campaignPackage.app = app.id')
        ->where($where)
        ->groupBy($group);
        $command = $query->createCommand();
        $data = $command->queryAll();
        if(count($data) > 0){
            return $data[0];
        }
        return array();
    }
}
