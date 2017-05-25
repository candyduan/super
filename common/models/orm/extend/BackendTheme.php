<?php
namespace common\models\orm\extend;
class BackendTheme extends \common\models\orm\base\BackendTheme{
    public static function getColorByBtid($btid){
        $color = [];
        $model  = self::findByPk($btid);
        if($model){
            $color = [
                'fcolor'    => $model->fcolor,
                'bcolor'    => $model->bcolor,
            ];
        }
        return $color;
    }
    
    public static function findByPk($id){
        $model  = self::find()
                    ->where(['btid' => $id])
                    ->one()
                    ;
        return $model;
    }
    
    public static function findByStatus($status=1){
        $models  = self::find()
                        ->where(['status' => $status])
                        ->all()
                        ;
        return $models;
    }
}
