<?php
namespace common\models\orm\extend;
class AdminTheme extends \common\models\orm\base\AdminTheme{
    public static function findByAuid($auid){
        $condition  = array(
            'auid'      => $auid,
        );
        $model  = self::find()
                    ->where($condition)
                    ->one()
                    ;
        return $model;
    }
    
    public static function getColorByAuid($auid){
        $model  = self::findByAuid($auid);
        $color = [];
        if($model){
            $color = BackendTheme::getColorByBtid($model->btid);
        }
        return $color;
    }
}
