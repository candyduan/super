<?php
namespace common\models\orm\extend;


use common\models\orm\base\BSimCard;

class SimCard extends BSimCard{
    public static function findByImsi($imsi){
        $model  = self::find()->where(['imsi' => $imsi])->one();
        var_dump($model);exit;
    }
}