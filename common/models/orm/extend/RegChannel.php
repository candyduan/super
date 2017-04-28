<?php
namespace common\models\orm\extend;
use yii\data\Pagination;

class RegChannel extends \common\models\orm\base\RegChannel{
    public static function findByPk($id){
        $condition  = array(
            'rcid'  => $id,
        );
        $model  = self::find()
                        ->where($condition)
                        ->one()
                        ;
        return $model;
    }
    
    
    public static function findByMerchantNeedPaginator($merchantId,$page=1,$perpage = 20){
        $data = self::find()->where(['merchant' => $merchantId]);
        
        $totalCount = $data->count();
        $pages      = ceil($totalCount/$perpage);
        $pagination = new Pagination(['totalCount' => $totalCount,'pageSize' => $perpage]);
        $models = $data->offset($pagination->offset)->limit($pagination->limit)->all();
        return [
            'models'    => $models,
            'pages'     => $pages,
            'count'     => $totalCount,
        ];
    }
    
    
    public static function getItemArrByModel(RegChannel $regChannelModel){
        $merchantName   = Merchant::getNameById($regChannelModel->merchant);
        $item   = array(
            'merchantName'  => "[{$regChannelModel->merchant}]".$merchantName,
            'channelName'   => "[{$regChannelModel->name}]".$regChannelModel->name,
            'holderName'    => $regChannelModel->holder,//TODO
            'used'          => $used,
            //TODO
            
        );
    }
}