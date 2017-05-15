<?php
namespace common\models\orm\extend;
use yii\base\Object;
use common\library\Utils;
use common\library\Constant;
class RegChannelMutexList extends \common\models\orm\base\RegChannelMutexList{
	public static function findByPk($id){
		$condition  = array(
				'rcmlid'  => $id,
		);
		$model  = self::find()
		->where($condition)
		->one()
		;
		return $model;
	} 
	
	public static function findChannelMutexByRcmid($rcmid){
		$models = self::find()
			->where(['rcmid'=>$rcmid])
			->all();
		return $res= [
			'models' => $models,	
		];
	}
	
	public static  function getItemArrByModel(RegChannelMutexList $RegChannelMutexListModel){
		$channelName = RegChannel::findByPk($RegChannelMutexListModel->rcid)->name;
		return $item = [
				'rcmlid' => $RegChannelMutexListModel->rcmlid,
				'rcmid' => $RegChannelMutexListModel->rcmid,
				'rcid' => $RegChannelMutexListModel->rcid,
				'name' => '['.$RegChannelMutexListModel->rcid.']'.$channelName,
				'status' => $RegChannelMutexListModel->status == 0 ? '禁用' : '可用',
		];
	}
	
	public static function addChannelToMutex($rcid, $rcmid){
		$res = ['resultCode' => '0', 'msg' => ''];
		$channelMutexList = self::find()->where('rcid=:rcid and rcmid=:rcmid', [':rcid' => $rcid, ':rcmid'=>$rcmid])->one();
		if($channelMutexList){
			$res['msg'] = '此通道已存在';
		}else{
			$regChannelMutexList = new RegChannelMutexList();
			$regChannelMutexList->rcid = $rcid;
			$regChannelMutexList->rcmid = $rcmid;
			$regChannelMutexList->recordTime = Utils::getNowTime();
			$regChannelMutexList->updateTime = Utils::getNowTime();
			$regChannelMutexList->status = 1;
			$regChannelMutexList->insert();
			$res = [
					'resultCode' => Constant::RESULT_CODE_SUCC,
					'msg' => Constant::RESULT_MSG_SUCC
			];
		}
		return $res;
	}
	
	public static function changeStatusById($id){
		$res = ['resultCode' => '0', 'msg' => ''];
		$RegChannelMutexListModel = RegChannelMutexList::findByPk($id);
		if($RegChannelMutexListModel){
			$RegChannelMutexListModel->status == 1 ? $RegChannelMutexListModel->status = 0 : $RegChannelMutexListModel->status = 1;
			$RegChannelMutexListModel->updateTime = Utils::getNowTime();
			$RegChannelMutexListModel->save();
			$res = [
					'resultCode' => Constant::RESULT_CODE_SUCC,
					'msg' => Constant::RESULT_MSG_SUCC
			];
		}else{
			$res = [
					'msg' => '通道不存在',
			];
		}
		return $res;
	}
 
}