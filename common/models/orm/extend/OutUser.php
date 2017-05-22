<?php
namespace common\models\orm\extend;
class OutUser extends \common\models\orm\base\OutUser{
    public static function getIndexData($where, $start,$length){
        $data= self::find()
            ->where($where)
            ->offset($start)
            ->limit($length)
            ->all();
        return $data;
    }

    public static function getIndexCount($where){
        $count = self::find()
            ->where($where)->count();
        return $count;
    }

    public static function usernameEmailNotExist($name,$ouid){
        $model  = self::find()->where(['or', ['username' => $name],['email'=> $name]])->andwhere(['!=','ouid',$ouid])->one();
        return (empty($model)) ? true : false;

    }

    public static function findByPk($ouid){
        $model  = self::find()->where(['ouid' => $ouid])->one();
        return $model;
    }
}
