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
   
    public static function findAllToArray(){
    		$datas = self::find()->all();
    		$channelArr = [];
    		if($datas){
	    		foreach($datas as $data){
	    			$channelArr[] =[
	    					'rcid' => $data->rcid,
	    					'name' => '【' . $data->rcid . '】' . $data->name,
	    			];
	    		}
    		}
    		return  $channelArr;
    }
    
    public static function findAllNeedPaginator($page=1,$perpage = 20){        
        $data = self::find();
        
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
    
    public static function findByMerchantNeedPaginator($merchantId,$page=1,$perpage = 20){
        $data = self::find()->where(['merchant' => $merchantId]);
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
    
    
    public static function getItemArrByModel(RegChannel $regChannelModel){
        $merchantName   = Merchant::getNameById($regChannelModel->merchant);
        $provider   = '';
        if($regChannelModel->useMobile){
            $provider .= '移动、';
        }
        if($regChannelModel->useTelecom){
            $provider .= '电信、';
        }
        if($regChannelModel->useUnicom){
            $provider .= '联通、';
        }
        $item   = array(
            'rcid'          => $regChannelModel->rcid,
            'merchantName'  => "[{$regChannelModel->merchant}]".$merchantName,
            'channelName'   => "[{$regChannelModel->rcid}]".$regChannelModel->name,
            'holderName'    => $regChannelModel->holder,//TODO
            'provider'      => $provider,
            'devType'       => '',
            'status'        => $regChannelModel->status,
        );
        return $item;
    }
}