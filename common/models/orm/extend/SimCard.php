<?php
namespace common\models\orm\extend;

use common\library\Utils;

class SimCard extends \common\models\orm\base\SimCard{
    public static function findByImsi($imsi){
        if(!Utils::isValid($imsi)){
            return NULL;
        }
        $model  = self::find()->where(['imsi' => $imsi])->one();
        return $model;
    }
    
    public static function getMobileByImsi($imsi){
        $mobile = '';
        $model  = self::findByImsi($imsi);
        if($model){
            $mobile = $model->mobile;
        }
        return $mobile;
    }
}