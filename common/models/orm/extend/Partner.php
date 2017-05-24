<?php
namespace common\models\orm\extend;

use common\library\Utils;

class Partner extends \common\models\orm\base\Partner {

    public static function getIndexData($where, $start,$length){
        $data= self::find()->where($where)->orderBy('id desc')->offset($start)->limit($length)->all();
        return $data;
    }

    public static function getIndexCount($where){
        $count = self::find()->where($where)->count();
        return $count;
    }

    public static function findByPk($id){

        $model  = self::find()->where(['id' => $id])->one();
        return $model;
    }

    public static function getNameById($id){
        $data = self::find()->select(['name'])->where(['id' => $id])->one();
        return isset($data['name']) ? $data['name'] : '';

    }

    public static function fetchAllArr(){
        $data= self::find()->select(['partner.id','partner.name'])
        ->where('')
        ->all();
        return $data;
    }

    public static function getAllPartnersByBelong($belong,$name){
        $condition[] = 'and';
        $condition[] = ['=', 'belong', $belong];
        $condition[] = ['=', 'deleted', 0];
        if($name !== ''){
            $condition[] = [
                'like',
                'name',
                $name
            ];
        }
        $data = self::find()->select(['id','name'])
            ->where($condition)
            ->all();
        $return_data = [];
        foreach($data as $value){
            $return_data[$value['id']] = $value['name'];
        }
        return $return_data;
    }
    
    public static function findAllToArray(){
	    	$datas = self::find()->all();
	    	$partnerArr = [];
	    	if($datas){
	    		foreach($datas as $data){
	    			$partnerArr[] =[
	    					'id' => $data->id,
	    					'name' => '【' . $data->id . '】' . $data->name,
	    			];
	    		}
	    	}
	    	return  $partnerArr;
    }

    public static function findAllMedia(){
    		$datas = self::find()->where('utype in (2,3)')->all();
    		$mediaArr = [];
    		if($datas){
    			foreach($datas as $data){
    				$mediaArr[] =[
    						'id' => $data->id,
    						'name' => '【' . $data->id . '】' . $data->name,
    				];
    			}
    		}
    		return  $mediaArr;
    }
}