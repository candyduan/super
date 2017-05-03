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

    public static function findByPk($sdid){

        $model  = self::find()->where(['id' => $sdid])->one();
        return $model;
    }

}