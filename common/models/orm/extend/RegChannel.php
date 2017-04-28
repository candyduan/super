<?php
namespace common\models\orm\extend;
class RegChannel extends \common\models\orm\base\RegChannel{
    public static function findByPk($id){
        $condition  = array(
            'rcid'  => $id,
        );
        $model  = self::find()
                        ->where($condition)
                        ->one()
                        ;
        return $model;
    }
    
}