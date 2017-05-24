<?php
namespace common\models\orm\extend;

use common\library\Utils;

class Sdk extends \common\models\orm\base\Sdk{
	
	public static function getNameById($id){
		$data = self::find()->select(['name'])->where(['sdid' => $id])->one();
		return isset($data['name']) ? $data['name'] : '';
	
	}
	
    public static function findByName($name){
        if(!Utils::isValid($name)){
            return NULL;
        }
        $model  = self::find()->where(['like','name', $name])->all();
        return $model;
    }

    public static function sdkNameNotExist($name){
        if(!Utils::isValid($name)){
            return NULL;
        }
        $model  = self::find()->where(['name' => $name])->one();
        return (empty($model)) ? true : false;

    }

    public static function findByPk($sdid){

        $model  = self::find()->where(['sdid' => $sdid])->one();
        return $model;
    }

    public static function countByName($name){
        if(!Utils::isValid($name)){
            return NULL;
        }
        $model  = self::find()->where(['like','name', $name])->count();
        return $model;
    }

    public static function getIndexData($where, $start,$length){
        $find = self::find();
        if(!empty($where)) {
            $find->where([$where['signal'], $where['column'], $where['value']]);
        }
        $models= $find->offset($start)->limit($length)->all();
        return $models;
    }

    public static function getIndexCount($where){
        $find = self::find();
        if(!empty($where)) {
            $find->where([$where['signal'], $where['column'], $where['value']]);
        }
        $models= $find->count();
        return $models;
    }

    public static function getSdkCount(){
        $count = self::find()->where(['in', 'status', [1,2,3]])->count();
        return $count;
    }

    public static function getValidSdids(){
        $data = self::find()->select(['sdid'])->where(['in', 'status', [1,2,3]])->all();
        $return_data = [];
        foreach($data as $value){
           $return_data  [] = $value['sdid'];
        }
        return $return_data;
    }


    public static function getValidSdks(){
        $data = self::find()->select(['sdid','name'])->where(['in', 'status', [1,2,3]])->all();
        $return_data = [];
        foreach($data as $value){
            $return_data[] = [
                'sdid' => $value['sdid'],
                'name' => $value['name']
            ];
        }
        return $return_data;
    }

    public static function getNameBySdid($sdid){
        $data = self::find()->select(['name'])->where(['sdid' => $sdid])->one();
        return isset($data['name']) ? $data['name'] :'';
    }

    public static function findAllSdk(){
	    	$datas = self::find()->all();
	    	$sdkArr = [];
	    	if($datas){
	    		foreach($datas as $data){
	    			$sdkArr[] =[
	    					'id' => $data->sdid,
	    					'name' => '【' . $data->sdid . '】' . $data->name,
	    			];
	    		}
	    	}
	    	return  $sdkArr;
    }
}