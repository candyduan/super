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
    /*  public static function getDiffProvinces($prids){
          $data  = self::find();
          if(!empty($prids)){
            $data = $data->where(['! in', 'id' ,$prids]);
          }
          $data->all();
          return $data;
      }*/

}