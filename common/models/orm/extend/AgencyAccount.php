<?php
namespace common\models\orm\extend;
class AgencyAccount extends \common\models\orm\base\AgencyAccount{
    public static function findByPk($id){
        $condition  = array(
            'aaid'  => $id,
        );
        $model  = self::find()
                    ->where($condition)
                    ->one()
                    ;
        return $model;
    }
}