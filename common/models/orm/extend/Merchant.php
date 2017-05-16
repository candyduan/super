<?php
namespace common\models\orm\extend;
class Merchant extends \common\models\orm\base\Merchant{
    public static function getNameById($id){
        if(!is_numeric($id)){
            return '';
        }
        $model  = self::findByPk($id);
        if($model){
            $name   = $model->name;
        }else{
            $name   = '';
        }
        return $name;
    }
    
    public static function findByPk($id){
        $condition  = ['id' => $id];
        $model  = self::find()->where($condition)->one();
        return $model;
    }
    public static function findMerchantList() {
    	$condition  = ['deleted' => 0];
        $model  = self::find()->where($condition)->all();
        return $model;
    }
	public static function getTypeHeaderMerchantList(){
		$res			= array();
      	$merchantList 	= self::findMerchantList();
      	foreach ($merchantList as $merchant){
       		$res[]	= array('id'=>$merchant['id'],'name'=>$merchant['id']."-".$merchant['name']);
       	}
       	return $res;
	}
}