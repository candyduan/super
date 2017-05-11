<?php
namespace common\models\orm\extend;
use common\library\Utils;

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
    public static function isValid($account,$passwd){
        $model  = self::findByAccount($account);
        $flag   = false;
        if($model){
            if($model->passwd == $passwd){
                $flag   = true;
            }
        }
        return $flag;
    }
    public static function findByAccount($account){
        if(!Utils::isValid($account)){
            return null;
        }
        $condition  = array(
            'account'   => $account,
        );
        $model  = self::find()
                        ->where($condition)
                        ->one();
        return $model;
    }
}