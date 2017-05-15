<?php
namespace common\models\orm\extend;
use yii\data\Pagination;
use yii\base\Object;
use common\library\Utils;
use common\library\Constant;
class RegChannelMutex extends \common\models\orm\base\RegChannelMutex{
	
	public static function findByPk($id){
		$condition = [
				'rcmid' => $id,
		];
		$model = self::find()
			->where($condition)
			->one();
		return $model;
	} 
	
	public static function findAllNeedPaginator($page=1,$perpage = 5){
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
	
	public static function getItemArrByModel(RegChannelMutex $regChannelMutexModel){
		$item   = array(
				'rcmid'          => $regChannelMutexModel->rcmid,
				'name'  => "[{$regChannelMutexModel->rcmid}]".$regChannelMutexModel->name,
				'status'        => $regChannelMutexModel->status == 0 ? '禁用' : '可用',
		);
		return $item;
	}
	
	/**
	 * 添加通道组
	 * @param unknown $params
	 * @return boolean
	 */
	public static function addMutex($params){
		$RegChannelMutex = new RegChannelMutex;
		$RegChannelMutex->name = $params['name'];
		$RegChannelMutex->status = $params['status'];
		$RegChannelMutex->recordTime = Utils::getNowTime();
		$RegChannelMutex->updateTime = Utils::getNowTime();
		return $RegChannelMutex->insert();
	}
	
	/**
	 * 改变通道组状态
	 * @param unknown $param
	 */
	public  static function changeMutexStatusById($rcmid){
		$res = ['resultCode' => '0', 'msg' => ''];
		$model = self::findByPk($rcmid);
		if($model){
			$model->status == 1 ? $model->status = 0 : $model->status =1;
			$model->save();
			$res = [
					'resultCode' => Constant::RESULT_CODE_SUCC,
					'msg' => Constant::RESULT_MSG_SUCC
			];
		}
		return $res;
		
	}
	
	
	
	
	
}