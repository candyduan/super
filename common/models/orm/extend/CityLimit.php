<?php
namespace common\models\orm\extend;
class CityLimit extends \common\models\orm\base\CityLimit{
	public static function findByChannelAndProvince($cid,$pid){
		return self::find()->where(['channel'=>$cid,'province'=>$pid])->all();
	}
	
	public static function findByChannelAndProvinceAndCity($channel, $province, $city){
		return self::find()->where(['channel'=>$channel,'province'=>$province,'city'=>$city])->one();
	}
}
