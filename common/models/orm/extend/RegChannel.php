<?php
namespace common\models\orm\extend;
use yii\data\Pagination;
use common\library\Utils;
use common\models\orm\extend\Admin;
use common\library\Constant;

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
    
    public static function findAllNeedPaginator($status,$page=1,$perpage = 20){        
    	$condition	= array();
    	if($status >= 0){
    		$condition['status'] =  $status;
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
    
    public static function findByMerchantNeedPaginator($status,$merchantId,$page=1,$perpage = 20){
    	$condition  = array(
    		'merchant'  => $merchantId,
    	);
    	if($status >= 0){
    		$condition['status'] =  $status;
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
    
    public static function findByChannelNeedPaginator($status,$channelId,$page=1,$perpage = 20){
    	$condition  = array(
    		'rcid'  => $channelId,
    	);
    	if($status >= 0){
    		$condition['status'] =  $status;
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
    
    
    public static function getItemArrByModel(RegChannel $regChannelModel){
        $merchantName   = Merchant::getNameById($regChannelModel->merchant);
        $holderName		= Admin::getNickById($regChannelModel->holder);
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
        $channelStatusList 	= self::getAllChannelStatus();
        $channelDevTypeList	= self::getAllChannelDevType();
        $item   = array(
            'rcid'          => $regChannelModel->rcid,
            'merchantName'  => "[{$regChannelModel->merchant}]".$merchantName,
            'channelName'   => "[{$regChannelModel->rcid}]".$regChannelModel->name,
            'holderName'    => $holderName,//TODO
            'provider'      => $provider,
            'devType'       => isset($channelDevTypeList[$regChannelModel->devType]) ? $channelDevTypeList[$regChannelModel->devType]:'',
            'status'        => $channelStatusList[$regChannelModel->status],
        );
        return $item;
    }
    
    public static function findBySign($sign){
        $condition  = array(
            'sign'  => $sign,
        );
        $model  = self::find()
                        ->where($condition)
                        ->one()
                        ;
        return $model;
    }
    
    public static function getAllChannelStatus(){
    	return array(
    		3 => '测试',
    		2 => '暂停',
    		1 => '可用',
    		0 => '删除'
    	);
    }
    
    public static function getAllChannelDevType(){
    	return array(
    		1 => 'single',
    		2 => 'double',
    		3 => 'sms+',
    		4 => 'url+'
    	);
    }
    
    public static function saveChannel($rcid,$sign,$merchant,$name,$useMobile,$useUnicom,$useTelecom,$sdkVersion,$cutRate,$inPrice,$waitTime,$devType,$status,$priorityRate,$remark,$holder){
    	if(is_numeric($rcid) && $rcid){
    		$regChannel = self::findByPk($rcid);
    	}else{
    		$regChannel = new RegChannel();
    		$regChannel->recordTime		= Utils::getNowTime();
    	}
    	$regChannel->sign			= $sign;
    	$regChannel->merchant		= $merchant;
    	$regChannel->name			= $name;
    	$regChannel->useMobile		= $useMobile;
    	$regChannel->useUnicom		= $useUnicom;
    	$regChannel->useTelecom		= $useTelecom;
    	$regChannel->sdkVersion		= $sdkVersion;
    	$regChannel->cutRate		= $cutRate;
    	$regChannel->inPrice		= $inPrice;
    	$regChannel->waitTime		= $waitTime;
    	$regChannel->devType		= $devType;
    	$regChannel->status			= $status;
    	$regChannel->priorityRate	= $priorityRate;
    	$regChannel->remark			= $remark;
    	$regChannel->holder			= $holder;
    	try{
     		$res	= $regChannel->save();
     	}catch (\Exception $e){
     		return false;
     	}
    	if($res){
    		return true;
    	}
    	return false;
    }
 
    public static function getTypeHeaderChannelList(){
    	$res			= array();
    	$channelList 	= self::find()->all();
    	foreach ($channelList as $channel){
    		$res[]	= array('id'=>$channel['rcid'],'name'=>"【".$channel['rcid']."】".$channel['name']);
    	}
    	return $res;
    }
    
    public static function getNameByPk($id){
        $model  = self::findByPk($id);
        $name = '';
        if($model){
            $name = $model->name;
        }
        return $name;
    }
    
    public static function signUsed($sign,$rcid){
        $flag   = false;
        $model  = self::findBySign($sign);
        if($model){
            if($model->rcid != $rcid){
                $flag    = true;
            }
        }
        return $flag;
    }
    
    public static function getDevTypeName($devType){
        switch ($devType){
            case Constant::CHANNEL_SINGLE:
                $name   = 'single';
                break;
            case Constant::CHANNEL_DOUBLE:
                $name   = 'double';
                break;
            case Constant::CHANNEL_SMSP:
                $name   = 'sms+';
                break;
            case Constant::CHANNEL_URLP:
                $name   = 'url+';
                break;
        }
        return $name;
    }
}