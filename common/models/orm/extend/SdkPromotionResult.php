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

   public static function findByPk($id){

        $model  = self::find()->where(['id' => $id])->one();
        return $model;
    }

    public static function getNameById($id){
        $data = self::find()->select(['name'])->where(['id' => $id])->one();
        return isset($data['name']) ? $data['name'] : '';

    }

}