<?php
namespace common\models\orm\extend;
class Merchant extends \common\models\orm\base\Merchant{
    public static function getNameById($id){
        if(!is_numeric($id)){
            return '';
        }
        $model  = self::findByPk($id);
        if($model){
            $name   = $model->name;
        }else{
            $name   = '';
        }
        return $name;
    }
    
    public static function findByPk($id){
        $condition  = ['id' => $id];
        $model  = self::find()->where()->one();
        return $model;
    }
    
}