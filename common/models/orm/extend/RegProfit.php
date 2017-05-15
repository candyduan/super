<?php
namespace common\models\orm\extend;

use common\library\Utils;

class RegProfit extends \common\models\orm\base\RegProfit{
    public static function findByTime($stime,$etime,$checkChannel){
    	$groupBy	= '';
    	if(!$stime || !$etime || $stime > $etime){
    		return array();
    	}
    	if($checkChannel){
    		$groupBy = ',rcid';
    	}
    	
    	$connection  	= \Yii::$app->db;
    	$sql     		= "select sum(succ) as sumsucc, sum(fail) as sumfail, day ,rcid from regProfit
    					where day >= :stime and day <=:etime group by day {$groupBy}";
    	$command 		= $connection->createCommand($sql,array(':stime'=>$stime,':etime'=>$etime));
    	$data     		= $command->queryAll();
     	return $data;
    }
    public static function findByDayRcid($day,$rcid){
    	if(!is_numeric($rcid)){
    		return array();
    	}
    	if(!is_numeric($day)){
    		return array();
    	}
    	$condition  = array(
			'day'  => $day,
			'rcid' => $rcid,
    	);
    	return self::find()->where($condition)->one();
    }
}