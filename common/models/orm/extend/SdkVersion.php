<?php
namespace common\models\orm\extend;

class SdkVersion extends \common\models\orm\base\SdkVersion{
	public static function getSdkVersionList(){
       $data 		= self::find()->select(['id','versionCode','versionName'])->where(['status' => 1])->all();
       $return_data = array();
       foreach($data as $value){
           $return_data[$value['id']] = $value;
       }
       return $return_data;
    }
}