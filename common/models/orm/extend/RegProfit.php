<?php
namespace common\models\orm\extend;

use common\library\Utils;

class RegProfit extends \common\models\orm\base\RegProfit{
    public static function findProfitList($stime,$etime,$checkChannel,$checkMerchant, $channel, $merchant){
    	$groupBy	= '';
    	$params		= array();
    	if(!$stime || !$etime || $stime > $etime){
    		return array();
    	}
    	$params[":stime"]	= $stime;
    	$params[":etime"]	= $etime;
    	$whereStr	= '';
    	if($channel){
    		$whereStr	= 'and rc.rcid = :rcid';
    		$params[":rcid"]	= $channel;
    		$checkChannel		= 1;
    	}
    	if($merchant){
    		$whereStr	= 'and m.id = :merchant';
    		$params[":merchant"]	= $merchant;
    		$checkMerchant			= 1;
    	}
    	if($checkChannel){
    		$groupBy.= ',rp.rcid';
    	}
    	if($checkMerchant){
    		$groupBy.= ',m.id';
    	}
    	$connection  	= \Yii::$app->db;
    	$sql     		= "select rc.inRate as inRate ,m.name as merchantName ,rc.name as channelName,sum(rp.succ) as sumsucc, sum(rp.fail) as sumfail, rp.day ,rp.rcid from regProfit rp
    					left join  regChannel rc on rc.rcid = rp.rcid
    					left join merchant m on m.id = rc.merchant = m.id
    					where rp.day >= :stime and rp.day <=:etime {$whereStr} group by rp.day {$groupBy}";
    	$command 		= $connection->createCommand($sql,$params);
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