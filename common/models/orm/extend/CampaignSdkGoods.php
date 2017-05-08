<?php
namespace common\models\orm\extend;

use common\library\Utils;

class CampaignSdkGoods extends \common\models\orm\base\CampaignSdkGoods {

  /*  public static function getGoodsByCaid($caid)
    {
        $data = self::find()->select(['id','name','fee'])->where(['deleted' => 0,'campaign' => $caid])->all();
        return $data;
    }*/

}