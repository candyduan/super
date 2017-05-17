<?php
namespace common\models\orm\extend;
use yii\base\Object;
use yii\data\Pagination;
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
    
    public  static function findAllNeedPaginator($page,$perpage = '20'){
    		$data = self::find();
    		$totalCount = $data->count();
    		$pages = ceil($totalCount/$perpage);
    		$pagination = new Pagination(['totalCount' => $totalCount, 'pageSize' => $perpage, 'page' => $page ]);
    		$models = $data->offset($pagination->offset)->limit($pagination->limit)->all();
    		return [
    				'models' => $models,
    				'pages' => $pages,
    				'count' => $totalCount,
    		];
    }
    
    public static function getItemArrByModel(Merchant $merchantModel){
    		return [
    				'id' => $merchantModel->id,
    				'name' =>$merchantModel->name,
    				'addr' => $merchantModel->addr,
    				'holder' => Admin::getNickById($merchantModel->holder),
    				'holderId' => $merchantModel->holder,
    				'payCircle' => $merchantModel->payCircle == 1 ? '周' : '月' ,
    				'tax' => $merchantModel->tax,
    				'memo' => $merchantModel->memo,
    		];
    }
    
    public static function findByName($name) {
    		$model = self::find()->where('name = :name', [':name' => $name])->one();
    		return $model;
    }
    
    public static function findByIdAndName($mid, $name) {
    		$model = self::find()->where('id != :id and name = :name', ['id' => $mid, 'name' => $name])->one();
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