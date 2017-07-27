<?php
namespace common\models\orm\extend;
class ChannelProvincePrice extends \common\models\orm\base\ChannelProvincePrice{
    public static function findByChidProvincePrice($chid,$province,$price){
        $condition  = array(
            'channel'   => $chid,
            'province'  => $province,
            'price'     => $price,
        );
        $model  = self::find()
                        ->where($condition)
                        ->one()
                        ;
        return $model;
    }
    
    public static function findByChidPrice($chid,$price){
        $condition  = array(
            'channel'   => $chid,
            'price'     => $price,
        );
        $models  = self::find()
                        ->where($condition)
                        ->all()
                        ;
        return $models;
    }
    
    public  static function findByChannelProvincePrice($chid,$province,$price){
	    	$condition  = array(
	    			'channel'   => $chid,
	    			'province' => $province,
	    			'price'     => $price,
	    	);
	    	$model  = self::find()
	    	->where($condition)
	    	->one();
	    	;
	    	return $model;
    }
}
