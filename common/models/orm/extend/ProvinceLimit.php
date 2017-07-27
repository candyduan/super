<?php
namespace common\models\orm\extend;
class ProvinceLimit extends \common\models\orm\base\ProvinceLimit{
	
	public static  function findByChannelAndProvince($cid,$pid){
		return $provinceLimitModel = ProvinceLimit::find()->where(['channel'=>$cid,'province'=> $pid])->one();
	}
}
