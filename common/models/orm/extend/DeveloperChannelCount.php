<?php
namespace common\models\orm\extend;
class DeveloperChannelCount extends \common\models\orm\base\DeveloperChannelCount{
	
	public  static function findAllByCountAsc(){		
		return self::find()->orderBy('count asc')->all();
	}
	
public static function findByPk($id){
		$condition = [
				'id' => $id,
		];
		$model = self::find()
			->where($condition)
			->one();
		return $model;
	} 
}
