<?php
namespace common\models\orm\extend;
class RegChannelMutexList extends \common\models\orm\base\RegChannelMutexList{
	
	public static function findChannelMutexById($rcmid){
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
				'rcid' => $RegChannelMutexListModel->rcid,
				'name' => '['.$RegChannelMutexListModel->rcid.']'.$channelName,
		];
	}
    
}