<?php
namespace common\models\orm\extend;

use common\library\Utils;

class Goods extends \common\models\orm\base\Goods {

    public static function getGoodsByCaid($caid)
    {
        $data = self::find()->select(['id','name','fee'])->where(['deleted' => 0,'campaign' => $caid])->all();
        return $data;
    }

}