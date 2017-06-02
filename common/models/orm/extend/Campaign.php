<?php
namespace common\models\orm\extend;

use common\library\Utils;
use yii\db\Query;
use yii\data\Pagination;

class Campaign extends \common\models\orm\base\Campaign {

    public static function getSdkCampaigns($partner = ''){


        $query = new Query();
        $query	->select([
                'campaign.id as caid',
                'campaign.name as campaignname',
                'partner.name as partnername']
        )
            ->from('campaign')
            ->join('inner join', 'partner',
                'campaign.partner = partner.id')
            ->where(['campaign.belong' => 1,
                    //'campaign.status' =>1,
                     'partner.belong' => 1]);
         if(!empty($partner)){
             $query->where(['like', 'partner.name',$partner]);
         }

        $command = $query->orderBy('campaign.id desc')->createCommand();
        $data = $command->queryAll();
        $return_data = [];
        foreach($data as $value){
            $return_data[$value['caid']] =[
                'partner' => $value['partnername'],
                'campaign' =>  $value['campaignname'],
            ];
        }

        return $return_data;
    }

    public static function getIndexData($where, $start,$length){
        $data= self::find()
            ->join('inner join', 'app', 'campaign.app = app.id')
            ->where($where)->orderBy('id desc')
            ->offset($start)
            ->limit($length)
            ->all();
        return $data;
    }

    public static function getIndexCount($where){
        $count = self::find()->join('inner join', 'app', 'campaign.app = app.id')
            ->where($where)->count();
        return $count;
    }

    public static function findByPk($id){

        $model  = self::find()->where(['id' => $id])->one();
        return $model;
    }


    public static function getNameById($id){
        $data = self::find()->select(['name'])->where(['id' => $id])->one();
        return isset($data['name']) ? $data['name'] : '';

    }

    public static function getIdByName($name){
        $data = self::find()->select(['id'])->where(['name' => $name])->one();
        return isset($data['id']) ? $data['id'] : '';

    }
    
    public static function getCampaignByCampaignPackageId($campaignPackageId){
    	$query = new Query();
        $query	->select(['campaign.id as campaignId', 'campaign.name as campaignName','campaignPackage.mediaSign as mediaSign'])
            ->from('campaignPackage')
            ->join('left join', 'campaign', 'campaign.id = campaignPackage.campaign')
            ->where(['campaignPackage.id' => $campaignPackageId]);
        $command 	= $query->createCommand();
        $data 		= $command->queryOne();
     	return $data;
    }
    
    public static function getTypeHeaderCampaignList(){
    	$res			= array();
    	$campaignList 	= self::find()->all();
    	foreach ($campaignList as $campaign){
    		$res[]	= array('id'=>$campaign['id'],'name'=>"【".$campaign['id']."】".$campaign['name']);
    	}
    	return $res;
    }

    public static function findAllByPartnerAndApp($partner='',$app=''){
    		$condition = [];
    		if(is_numeric($partner) && $partner){
    			$condition['partner'] = $partner;
    		}
    		if(is_numeric($app) && $app){
    			$condition['app'] = $app;
    		}
    		$datas = self::find()->where($condition)->all();
    		$campaignArr = [];
    		if($datas){
    			foreach($datas as $data){
    				$campaignArr[] =[
    						'id' => $data->id,
    						'name' => '【' . $data->id . '】' . $data->name,
    				];
    			}
    		}
    		return  $campaignArr;
    }
    public static function fetchAllBelongSdkArr(){
        $data= self::find()->select(['campaign.id','campaign.name'])->join('inner join', 'partner', 'campaign.partner = partner.id')
        ->where('partner.belong = 1')
        ->all();
        return $data;
    }
    public static function fetchAllBelongSdkArrByPid($pid){
        $data= self::find()->select(['campaign.id','campaign.name'])->join('inner join', 'partner', 'campaign.partner = partner.id')
        ->where('partner.belong = 1 and partner.id = :pid',array(
            ':pid' => $pid
        ))
        ->all();
        return $data;
    }
    
    public static function findAllNeedPaginator($app,$page=1,$perpage = 20){
    	$condition	= array();
     	if(is_numeric($app) && $app){
    		$condition['app'] =  $app;
    	}
    	$data = self::find()->where($condition);
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
    
    public static function getAllCampaignStatus(){
    	return array(
    		3 => '测试中',
    		2 => '已结束',
    		1 => '进行中',
    		0 => '未审核'
    	);
    }
    
    public static function getItemArrByModel(Campaign $campaignModel){
    	$campaignStatus	= self::getAllCampaignStatus();
     	$item   = array(
     		'campaignId'  	=> $campaignModel->id,
    		'campaignName'  => "[{$campaignModel->id}]".$campaignModel->name,
    		'campaignSign'  => $campaignModel->sign,
    		'statusName'    => $campaignStatus[$campaignModel->status]
    	);
    	return $item;
    }
    
    public static function findPartnerAppbyCampaign($campaignId){
    	$query = new Query();
    	$query	->select(['partner.name as pname','campaign.name as cname','app.name as aname','partner.id as pid','campaign.id as cid','app.id as aid'])
    	->from('campaign')
    	->join('left join', 'app', 'campaign.app = app.id')
    	->join('left join', 'partner', 'partner.id = app.partner')
    	->where(['campaign.id' => $campaignId]);
    	$data = $query->createCommand()->queryOne();
     	return $data;
    }
    
}