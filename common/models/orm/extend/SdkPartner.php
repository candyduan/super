<?php
namespace common\models\orm\extend;

use common\library\Utils;

class SdkPartner extends \common\models\orm\base\SdkPartner {
    public static function findByName($partner){
        if(!Utils::isValid($partner)){
            return NULL;
        }
        $model  = self::find()->where(['name' => $partner])->one();
        return $model;
    }

    public static function findByPk($spid){

        $model  = self::find()->where(['spid' => $spid])->one();
        return $model;
    }

    public static function getNameByPk($sdid){

        $model = self::find()->select('name')->where(['spid' => $sdid])->one();
        return  isset($model['name']) ? $model['name'] : '';
    }
}