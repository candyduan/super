<?php
namespace common\models\orm\extend;

use common\library\Utils;


class Province extends \common\models\orm\base\Province{
    public static function getNameById($id){
        $model = self::findByPk($id);
        $name   = '未知';
        if($model){
            $name = $model->name;
        }
        return $name;
    }
    public static function findByPk($id){
        $condition  = array(
            'id'    => $id,
        );
        $model  = self::find()
                        ->where($condition)
                        ->one()
                        ;
        return $model;
    }

    public static function getProvinceById($prid){
        $model  = self::find()->select(['name'])->where(['id' => $prid])->one();
        return isset($model['name']) ? $model['name'] :'';
    }

    public static function getAllProvinces(){
        $data  = self::find()->all();
        $return_data = [];
        foreach($data as $value){
            $return_data[$value['id']] = $value['name'];
        }
        return $return_data;
    }
    public static function getAllProvinceId(){
        $provinces  = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,28,29,30,31,32];
        return $provinces;
    }
    /*  public static function getDiffProvinces($prids){
          $data  = self::find();
          if(!empty($prids)){
            $data = $data->where(['! in', 'id' ,$prids]);
          }
          $data->all();
          return $data;
      }*/

}