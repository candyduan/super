<?php
namespace common\models\orm\extend;
class RegChannelSwitch extends \common\models\orm\base\RegChannelSwitch{
	public static function findbyRcid($rcid){
	    $condition = array(
	        'rcid' => $rcid,
	    );
	    $model = self::find()
	               ->where($condition)
	               ->one()
	               ;
	    return $model;
	}
	public static function getHourList(RegChannelSwitch $model = NULL){
	    if($model){
	        $list  = array(
	            ['swhour' => '00','swswitch' => $model->hour00],
	            ['swhour' => '01','swswitch' => $model->hour01],
	            ['swhour' => '02','swswitch' => $model->hour02],
	            ['swhour' => '03','swswitch' => $model->hour03],
	            ['swhour' => '04','swswitch' => $model->hour04],
	            ['swhour' => '05','swswitch' => $model->hour05],
	            ['swhour' => '06','swswitch' => $model->hour06],
	            ['swhour' => '07','swswitch' => $model->hour07],
	            ['swhour' => '08','swswitch' => $model->hour08],
	            ['swhour' => '09','swswitch' => $model->hour09],
	            ['swhour' => '10','swswitch' => $model->hour10],
	            ['swhour' => '11','swswitch' => $model->hour11],
	            ['swhour' => '12','swswitch' => $model->hour12],
	            ['swhour' => '13','swswitch' => $model->hour13],
	            ['swhour' => '14','swswitch' => $model->hour14],
	            ['swhour' => '15','swswitch' => $model->hour15],
	            ['swhour' => '16','swswitch' => $model->hour16],
	            ['swhour' => '17','swswitch' => $model->hour17],
	            ['swhour' => '18','swswitch' => $model->hour18],
	            ['swhour' => '19','swswitch' => $model->hour19],
	            ['swhour' => '20','swswitch' => $model->hour20],
	            ['swhour' => '21','swswitch' => $model->hour21],
	            ['swhour' => '22','swswitch' => $model->hour22],
	            ['swhour' => '23','swswitch' => $model->hour23],
	        );
	    }else{
	        $list  = array(
	            ['swhour' => '00','swswitch' => 1],
	            ['swhour' => '01','swswitch' => 1],
	            ['swhour' => '02','swswitch' => 1],
	            ['swhour' => '03','swswitch' => 1],
	            ['swhour' => '04','swswitch' => 1],
	            ['swhour' => '05','swswitch' => 1],
	            ['swhour' => '06','swswitch' => 1],
	            ['swhour' => '07','swswitch' => 1],
	            ['swhour' => '08','swswitch' => 1],
	            ['swhour' => '09','swswitch' => 1],
	            ['swhour' => '10','swswitch' => 1],
	            ['swhour' => '11','swswitch' => 1],
	            ['swhour' => '12','swswitch' => 1],
	            ['swhour' => '13','swswitch' => 1],
	            ['swhour' => '14','swswitch' => 1],
	            ['swhour' => '15','swswitch' => 1],
	            ['swhour' => '16','swswitch' => 1],
	            ['swhour' => '17','swswitch' => 1],
	            ['swhour' => '18','swswitch' => 1],
	            ['swhour' => '19','swswitch' => 1],
	            ['swhour' => '20','swswitch' => 1],
	            ['swhour' => '21','swswitch' => 1],
	            ['swhour' => '22','swswitch' => 1],
	            ['swhour' => '23','swswitch' => 1],	          	            
	        );
	    }
	    return $list;
	}
}
