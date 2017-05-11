<?php
namespace common\models\orm\extend;
use function Faker\time;

class AgencyStack extends \common\models\orm\base\AgencyStack{
    const STATUS_DEL    = 0;
    const STATUS_SDK    = 1;
    const STATUS_APK    = 2;
    const STATUS_SUCC   = 3;
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
    public static function findNewByAaid($aaid){
        if(!is_numeric($aaid)){
            return null;
        }
        $condition  = array(
            'aaid'      => $aaid,
            'status'    => 1,
        );
        $min    = date('Y-m-d H:i:s',time() - 60);
        $model  = self::find()
                        ->where($condition)
                        ->andWhere(['>','recordTime',$min])
                        ->orderBy('asid DESC')
                        ->one()
                        ;
        return $model;
    }
}