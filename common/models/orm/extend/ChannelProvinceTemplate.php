<?php
namespace common\models\orm\extend;
class ChannelProvinceTemplate extends \common\models\orm\base\ChannelProvinceTemplate{
	public static function findByChannel($cid) {
		return $channelProvinceTemplate = ChannelProvinceTemplate::find()->where(['channelId'=>$cid])->one();
	}
}
