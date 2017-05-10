<?php
namespace common\models\orm\extend;
class AgencyStack extends \common\models\orm\base\AgencyStack{
    public static function findByPk($id){
        $condition  = array(
            'asid'  => $id,
        );
        $model  = self::find()
                    ->where($condition)
                    ->one()
                    ;
        return $model;
    }
}