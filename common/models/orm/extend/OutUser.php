<?php
namespace common\models\orm\extend;
use yii\web\IdentityInterface;
class OutUser extends \common\models\orm\base\OutUser  implements IdentityInterface {

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

    public static function findByUsernameOrEmail($name){
        $model  = self::find()->where(['or', ['username' => $name],['email'=> $name]])->andwhere(['status'=>1])->one();
        return $model;
    }

    public static function findIdentity($id){
        return self::getPrimaryKey();
    }

    public static function findIdentityByAccessToken($token, $type = null){

    }

    public function getId(){
        return $this->getPrimaryKey();
    }

    public function getAuthKey(){

    }

    public function validateAuthKey($authKey){

    }
}
