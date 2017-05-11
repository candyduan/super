<?php
namespace common\models\orm\extend;
use yii\data\Pagination;
use yii\base\Object;
use common\library\Utils;
class RegChannelMutex extends \common\models\orm\base\RegChannelMutex{
	
	public static function findAllNeedPaginator($page=1,$perpage = 20){
		$data = self::find();
	
		$totalCount = $data->count();
		$pages      = ceil($totalCount/$perpage);
		$pagination = new Pagination(['totalCount' => $totalCount]);
		$pagination->setPage($page,true);
		$models = $data->offset($pagination->offset)->limit($pagination->limit)->all();
		return [
				'models'    => $models,
				'pages'     => $pages,
				'count'     => $totalCount,
		];
	}
	
	public static function getItemArrByModel(RegChannelMutex $regChannelMutexModel){
		$item   = array(
				'rcmid'          => $regChannelMutexModel->rcmid,
				'name'  => "[{$regChannelMutexModel->rcmid}]".$regChannelMutexModel->name,
				'status'        => $regChannelMutexModel->status == 0 ? '禁用' : '可用',
		);
		return $item;
	}
	
	//添加通道组
	public static function addMutex($params){
		$RegChannelMutex = new RegChannelMutex;
		$RegChannelMutex->name = $params['name'];
		$RegChannelMutex->status = $params['status'];
		$RegChannelMutex->recordTime = Utils::getNowTime();
		$RegChannelMutex->updateTime = Utils::getNowTime();
		return $RegChannelMutex->insert();
	}
}