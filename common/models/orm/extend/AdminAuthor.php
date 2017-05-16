<?php
namespace common\models\orm\extend;
class AdminAuthor extends \common\models\orm\base\AdminAuthor{
    public static function findByAuidPower($auid,$power){
        $model  = self::find()
                    ->where(['like','power','%'.$power.'%'])
                    ->andWhere('=','auid',$auid)
                    ->one()
                    ;
        return $model;
    }
}
