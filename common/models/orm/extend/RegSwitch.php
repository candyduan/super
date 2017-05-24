<?php
namespace common\models\orm\extend;

use common\models\orm\base\RegChannelSwitch;
use common\models\orm\extend\Campaign;
use yii\data\Pagination;
use common\library\Utils;
class RegSwitch extends \common\models\orm\base\RegSwitch{
	public static function findByPk($rsid){
        return self::find()->where(['rsid' => $rsid])->one();
    }
    
    public static function findByCampaignPackage($cpid){
    	return self::find()->where(['campaignPackageId' => $cpid])->one();
    }
	
}
