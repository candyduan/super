<?php
namespace common\models\orm\extend;

use common\library\Utils;

class SdkPromotionResult extends \common\models\orm\base\SdkPromotionResult {

    public static function getIndexData($where, $start,$length){
        $data= self::find()->where($where)->orderBy('sprid desc')
            ->offset($start)
            ->limit($length)
            ->all();
        return $data;
    }

    public static function getIndexCount($where){
        $count = self::find()->where($where)->count();
        return $count;
    }

   public static function findByPk($sprid){

        $model  = self::find()->where(['sprid' => $sprid])->one();
        return $model;
    }

 /*   public static function getNameById($id){
        $data = self::find()->select(['name'])->where(['sprid' => $id])->one();
        return isset($data['name']) ? $data['name'] : '';

    }*/

}