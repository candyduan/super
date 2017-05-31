<?php
namespace common\models\orm\extend;

use common\library\Utils;

class Admin extends \common\models\orm\base\Admin {

    public static function getAllAdmins()
    {
       $data = self::find()->select(['id','nick'])->where(['deleted' => 0])->all();
       $return_data = [];
       foreach($data as $value){
           $return_data[$value['id']] = $value['nick'];
       }
       return $return_data;
    }

    public static function getNickById($id){
        $data = self::find()->select(['nick'])->where(['id' => $id])->one();
        return isset($data['nick']) ? $data['nick'] : 'unknow';

    }

}