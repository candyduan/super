<?php
namespace common\models\orm\extend;
class TimeProvinceLimit extends \common\models\orm\base\TimeProvinceLimit{
    public static function findByChid($chid){
        $condition  = array(
            'channel'   => $chid,
        );
        $model  = self::find()
                    ->where($condition)
                    ->one()
                    ;
        return $model;
    }
    public static function findByChidProvince($chid,$province){
        $condition  = array(
            'channel'   => $chid,
            'province'  => $province,
        );
        $model  = self::find()
                        ->where($condition)
                        ->one()
                        ;
        return $model;
    }
}
