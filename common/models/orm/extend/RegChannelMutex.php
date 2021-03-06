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
	
	public static function findByIdNeedPaginator($id,$page=1,$perpage = 20){
		$data = self::find()->where('rcmid = :id',[':id' => $id]);
		$totalCount =$data->count();
		$pages = ceil($totalCount/$perpage);
		$pagination = new Pagination(['totalCount' => $totalCount, 'pageSize' => $perpage, 'page' => $page ]);
		$models = $data->offset($pagination->offset)->limit($pagination->limit)->all();
		return [
				'models' => $models,
				'pages' => $pages,
				'count' => $totalCount,
		];
	}
	
	public static function getItemArrByModel(RegChannelMutex $regChannelMutexModel){
		$item   = array(
				'rcmid'          => $regChannelMutexModel->rcmid,
				'realName' => $regChannelMutexModel->name,
				'name'  => "[{$regChannelMutexModel->rcmid}]".$regChannelMutexModel->name,
				'status'        => $regChannelMutexModel->status == 0 ? '禁用' : '可用',
		);
		return $item;
	}
	
	public static function findAllToArray(){
		$datas = self::find()->all();
		$channelArr = [];
		if($datas){
			foreach($datas as $data){
				$channelArr[] =[
						'id' => $data->rcmid,
						'name' => '【' . $data->rcmid . '】' . $data->name,
				];
			}
		}
		return  $channelArr;
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