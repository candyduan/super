<?php
namespace common\models\orm\extend;
use common\library\Utils;
use yii\data\Pagination;

class RegOrder extends \common\models\orm\base\RegOrder{
    public static function findByPk($id){
        if(!is_numeric($id)){
            return null;
        }
        $condition  = array(
            'roid'  => $id,
        );
        $model  = self::find()
                        ->where($condition)
                        ->one()
                        ;
        return $model;
    }
    
    public static function findByStimeEtimeRcidMobileImsiNeedPaginator($stime,$etime,$rcid,$mobileImsi,$page=1,$perpage=20){
        
        $data = self::find();
        if(Utils::isValid($stime) && Utils::isValid($etime)){
            $min    = $stime.' 00:00:00';
            $max    = $etime.' 23:59:59';
            $data->andWhere(['>=','regOrder.recordTime',$min]);
            $data->andWhere(['<=','regOrder.recordTime',$max]);
        }
        if(is_numeric($rcid) && $rcid > 0){
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
    
    public static function getItemArrByModel(RegOrder $model){
        switch ($model->status){
            case  0:
                $status = '删除';
                break;
            case 1:
                $status = '已提交SDK';
                break;
            case 2:
                $status = 'SDK已完成';
                break;
            case 3:
                $status = '同步已完成';
                break;
            default:
                $status = '异常数据';
        }
        
        $item   = array(
            'roid'          => $model->roid,
            'imsi'          => $model->imsi,
            'mobile'        => SimCard::getMobileByImsi($model->imsi),
            'channelName'   => RegChannel::getNameByPk($model->rcid),
            'spSign'        => $model->spSign,
            'recordTime'    => $model->recordTime,
            'status'        => $status,
        );
        return $item;
    }
}