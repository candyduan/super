<?php
namespace common\models\orm\extend;

use common\library\Utils;

class Partner extends \common\models\orm\base\Partner {

    public static function getIndexData($where, $start,$length){
        $data= self::find()->where($where)->orderBy('id desc')->offset($start)->limit($length)->all();
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

    public static function fetchAllArr(){
        $data= self::find()->select(['partner.id','partner.name'])
        ->where('')
        ->all();
        return $data;
    }
}