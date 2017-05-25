<?php
namespace common\models\orm\extend;

use common\library\Utils;

class App extends \common\models\orm\base\App {

    public static function getIndexData($where, $start,$length){
        $data= self::find()->join('inner join', 'partner', 'app.partner = partner.id')
            ->where($where)->orderBy('id desc')
            ->offset($start)
            ->limit($length)
            ->all();
        return $data;
    }

    public static function getIndexCount($where){
        $count = self::find()->join('inner join', 'partner', 'app.partner = partner.id')
            ->where($where)->count();
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

    public static function fetchAllBelongSdkArr(){
        $data= self::find()->select(['app.id','app.name'])->join('inner join', 'partner', 'app.partner = partner.id')
            ->where('partner.belong = 1')
            ->all();
        return $data;
    }
    public static function fetchAllBelongSdkArrByPid($pid = null){
        $data= self::find()->select(['app.id','app.name'])->join('inner join', 'partner', 'app.partner = partner.id')
        ->where(array(
            ['and','partner.belong',1],
            ['and','partner.id',$pid]
        ))
        ->all();
        return $data;
    }

    	public static function findAllToArray(){
    		$datas = self::find()->all();
    		$appArr = [];
    		if($datas){
    			foreach($datas as $data){
    				$appArr[] =[
    						'id' => $data->id,
    						'name' => '【' . $data->id . '】' . $data->name,
    				];
    			}
    		}
    		return  $appArr;
    }
    
    public  static function findByPartner($partner){
    		$datas = self::find()->where("partner={$partner}")->all();
    		$appArr = [];
    		if($datas){
    			foreach($datas as $data){
    				$appArr[] =[
    						'id' => $data->id,
    						'name' => '【' . $data->id . '】' . $data->name,
    				];
    			}
    		}
    		return  $appArr;
    }
    
    
}