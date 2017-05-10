<?php
namespace common\models\orm\extend;
class RegOrder extends \common\models\orm\base\RegOrder{
    public static function findByPk($id){
        if(!is_numeric($id)){
            return null;
        }
        $condition  = array(
            'roid'  => $id,
        );
        $model  = self::find()
                        ->where($condition)
                        ->one()
                        ;
        return $model;
    }
}