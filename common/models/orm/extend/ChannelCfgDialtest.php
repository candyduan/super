<?php
namespace common\models\orm\extend;
class ChannelCfgDialtest extends \common\models\orm\base\ChannelCfgDialtest{
	public static function findByChannelId($id){
		$condition  = array(
				'channelId' => $id
		);
		$model  = self::find()
		->where($condition)
		->one()
		;
		return $model;
	}
}
