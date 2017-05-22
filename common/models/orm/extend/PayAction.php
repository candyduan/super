<?php
namespace common\models\orm\extend;
use common\library\Utils;

use yii\db\Query;
class PayAction extends \common\models\orm\base\PayAction{

    public static function getNewAndActUserByCondition($checkCP,$checkAPP,$checkCmp,$checkM,$partner,$app,$channel,$stime,$etime,$dateType){
        $select = ['payAction.day','payAction.partner','payAction.app','payAction.campaignPackage','payAction.media','sum(payAction.newPlayerCount) as newCount','sum(payAction.activePlayerCount) as activeCount'];
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
                'payAction.app',
                $app
            ];
        }
        if($channel > 0){
            $where[] = [
                '=',
                'payAction.media',
                $channel
            ];
        }
    
        switch ($dateType){
            case 1:// 天
            case 3://时段
                if(Utils::isDate($stime)){
                    $where[] = [
                        '>=',
                        'payAction.day',
                        strtotime($stime.' 00:00:00')
                    ];
                }
                if(Utils::isDate($etime)){
                    $where[] = [
                        '<=',
                        'payAction.day',
                        strtotime($etime.' 23:59:59')
                    ];
                }
                break;
            case 4://月份
                $sdate = date('Y-m-01',strtotime($stime));
                $edate = date('Y-m-01',strtotime($etime));
                $edate = date("Y-m-d",strtotime("$edate 1 month -1 day"));
    
                $where[] = [
                    '>=',
                    'payAction.day',
                    strtotime($sdate.' 00:00:00')
                ];
                $where[] = [
                    '<=',
                    'payAction.day',
                    strtotime($edate.' 23:59:59')
                ];
                break;
        }
    
        $group = [];
        if(1 == $dateType){//按天统计
            $group[] = 'payAction.day';
        }
        if($checkCP){
            $group[] = 'payAction.partner';
        }
        if($checkAPP){
            $group[] = 'payAction.app';
        }
        if($checkCmp){
            $group[] = 'payAction.campaignPackage';
        }
        if($checkM){
            $group[] = 'payAction.media';
        }
    
        $query = new Query();
        $query	->select($select)
        ->from('payAction')
        ->join('inner join', 'campaignPackage',
            'payAction.campaignPackage = campaignPackage.id')
            ->join('inner join','partner',
                'payAction.partner = partner.id')
                ->join('inner join','app',
                    'payAction.app = app.id')
                    ->where($where)
                    ->groupBy($group);
        $command = $query->createCommand();
        return $command->queryAll();
    }
}
