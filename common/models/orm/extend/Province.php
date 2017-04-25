<?php
namespace common\models\orm\extend;
class Province extends \common\models\orm\base\Province{
    public static function getNameById($id){
        $model = self::findByPk($id);
        $name   = '未知';
        if($model){
            $name = $model->name;
        }
        return $name;
    }
    public static function findByPk($id){
        $condition  = array(
            'id'    => $id,
        );
        $model  = self::find()
                        ->where($condition)
                        ->one()
                        ;
        return $model;
    }
    
}