<?php
namespace console\controllers;

use yii\console\Controller;
use common\models\orm\extend\RegProfit;
use yii\base\Object;
use common\library\Utils as commonUtils;
class RegProfitController extends Controller{
	
	public function actionIndex(){
		echo "Usage: \n";
		echo "reg-profit/day-data: 不带参数统计昨天的数据，举例：统计最近10天的数据，可表示为 reg-profit/day-data 10 \n";
 	}

	public function actionDayData($maxDay=1){
		if(is_numeric($maxDay) && $maxDay<1){
			return '';
		}
		$today = time()-86400;
		for($i = 0;$i < $maxDay ;$i++){
			$dayDate = date('Y-m-d', $today - $i * 86400);			
			self::getOneDayData($dayDate);			
		}
		if($maxDay > 1){
			echo date('Y-m-d', $today - $maxDay * 86400) . " 至 " . date('Y-m-d', $today)." 的数据统计完毕 \n";
		}else{
			echo date('Y-m-d', $today) . " 的数据统计完毕 \n ";				
		}
	}

	private function getOneDayData($dayDate = ''){
		if(!$dayDate){
			return false;
		}		
		$btime 			= $dayDate .' 00:00:00';
		$etime			= $dayDate .' 23:59:59';
		$connection  	= \Yii::$app->db;
		$sql = "select rcid ,sum(if(status = 3,1,0)) as sucnum, sum(if(status <> 3,1,0)) as failnum from regOrder
				where recordTime >= '{$btime}' and recordTime <= '{$etime}' group by rcid";
 		$command 		= $connection->createCommand($sql);
    	$dayDataList    = $command->queryAll();
		
		foreach ($dayDataList AS $key => $data){
			$regProfit	= RegProfit::findByDayRcid($dayDate, $data['rcid']);
			if($regProfit){
				$regProfit->succ		= $data['sucnum'];
				$regProfit->fail		= $data['failnum'];
				$regProfit->updateTime	= commonUtils::getNowTime();
				$regProfit->save();
			}else{
				$regProfit = new RegProfit();
				$regProfit->rcid		= $data['rcid'];
				$regProfit->day			= $dayDate;
				$regProfit->succ		= $data['sucnum'];
				$regProfit->fail		= $data['failnum'];
				$regProfit->recordTime	= commonUtils::getNowTime();
				$regProfit->insert();
			}			
  		}
 		return true;
	}
	
    
}