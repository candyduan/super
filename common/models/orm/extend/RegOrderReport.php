<?php
namespace common\models\orm\extend;
use common\library\Utils;
use yii\data\Pagination;

class RegOrderReport extends \common\models\orm\base\RegOrderReport{
    public static function findByStimeEtimeRcidMobileImsiNeedPaginator($stime,$etime,$rcid,$mobileImsi,$page=1,$perpage=20){
    
        $data = self::find();
        if(Utils::isValid($stime) && Utils::isValid($etime)){
            $min    = $stime.' 00:00:00';
            $max    = $etime.' 23:59:59';
            $data->andWhere(['>=','regOrderReport.recordTime',$min]);
            $data->andWhere(['<=','regOrderReport.recordTime',$max]);
        }
        if(is_numeric($rcid) && $rcid > 0){
            $data->innerJoin('regOrder','regOrder.roid = regOrderReport.roid');
            $data->andWhere(['=','regOrder.rcid',$rcid]);
        }
    
        if(Utils::isValid($mobileImsi)){
            $data->innerJoin('simCard','regOrder.imsi = simCard.imsi');
            $data->andWhere('(regOrder.imsi = :imsi OR simCard.mobile = :imsi)',array(':imsi' => $mobileImsi));
        }
        //         $sql = $data->createCommand()->getRawSql();
        //         echo $sql;exit;
        $totalCount = $data->count();
        $pages      = ceil($totalCount/$perpage);
        $pagination = new Pagination(['totalCount' => $totalCount,'pageSize' => $perpage,'page' => $page]);
        $models = $data->offset($pagination->offset)->limit($pagination->limit)->all();
        return [
            'models'    => $models,
            'pages'     => $pages,
            'count'     => $totalCount,
        ];
    
    }
    
    public static function getTypeName($type){
        switch ($type){
            case 1:
                $name   ='register';
                break;
            case 2:
                $name   = 'submit';
                break;
            case 3:
                $name   = 'trigger';
                break;
            case 4:
                $name   = 'sync';
                break;
            default:
                $name   = '';
        }
        return $name;
    }
    public static function getItemArrByModel(RegOrderReport $reportModel){
        $channel    = '';
        $devType    = '';
        $mobile     = '';
        $imsi       = '';
        $regOrderModel  = RegOrder::findByPk($reportModel->roid);
        if($regOrderModel){
            $imsi               = $regOrderModel->imsi;
            $simCardModel       = SimCard::findByImsi($imsi);
            if($simCardModel){
                $mobile = $simCardModel->mobile;
            }
            
            $regChannelModel    = RegChannel::findByPk($regOrderModel->rcid);
            if($regChannelModel){
                $channel    = "[{$regChannelModel->rcid}]{$regChannelModel->name}";
                $devType    = RegChannel::getDevTypeName($regChannelModel->devType);
            }
            
        }
        $item   = array(
            'roid'      => $reportModel->roid,
            'recv'      => $reportModel->content1,
            'send'      => $reportModel->content2,
            'type'      => self::getTypeName($reportModel->type),
            'time'      => $reportModel->recordTime,
            'channel'   => $channel,
            'devType'   => $devType,
            'mobile'    => $mobile,
            'imsi'      => $imsi,
        );
        return $item;
    }
}
