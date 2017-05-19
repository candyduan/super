<?php
namespace common\models\orm\extend;
use common\library\Utils;
class RegChannelVerifyRule extends \common\models\orm\base\RegChannelVerifyRule{
    const TYPE_CAPTCHA  = 1;
    const TYPE_SUCC     = 2;    
    public static function findByRcid($rcid){
        if(!is_numeric($rcid)){
            return [];
        }
        $condition  = array(
            'rcid'      => $rcid,
            'status'    => 1,
            );
        $models = self::find()
                    ->where($condition)
                    ->orderBy('type ASC')
                    ->all()
                    ;
        return $models;
    }
    public static function findByRcidAndType($rcid,$type){
    	if(!is_numeric($rcid) || !is_numeric($type) ){
    		return [];
    	}
    	$condition  = array(
    		'rcid'      => $rcid,
    		'type'      => $type,
    	);
    	$model = self::find()->where($condition)->one();
    	return $model;
    }
    public static function findAllByRcid($rcid){
    	$res 	= array();
    	if(!is_numeric($rcid)){
    		return [];
    	}
    	$condition  = array(
    		'rcid'      => $rcid,
    	);
    	$channelVerifyRuleList = self::find()->select(['rcid','type','port','keys1','keys2','keys3','status'])->where($condition)->all();
    	foreach ($channelVerifyRuleList as $channelVerifyRule){
    		$res[] = $channelVerifyRule->toArray();
    	}
    	return $res;
    }
    public static function saveChannelVerifyRule($rcid,$type0,$portType0,$keys1Type0,$keys2Type0,$keys3Type0,$statusType0,$type1,$portType1,$keys1Type1,$keys2Type1,$keys3Type1,$statusType1){
    	$resFlag = true;
    	if($rcid && $type0){
    		$channelVerifyRule	= self::findByRcidAndType($rcid, 0);
    		if (!$channelVerifyRule){
    			$channelVerifyRule = new RegChannelVerifyRule();
    			$channelVerifyRule->rcid		= $rcid;
    			$channelVerifyRule->type		= 0;
    			$channelVerifyRule->recordTime 	= Utils::getNowTime();
     		}
     		$channelVerifyRule->port	= $portType0;
    		$channelVerifyRule->keys1	= $keys1Type0;
    		$channelVerifyRule->keys2	= $keys2Type0;
    		$channelVerifyRule->keys3	= $keys3Type0;
    		$channelVerifyRule->status	= $statusType0;
    		$res = $channelVerifyRule->save();
    		if(!$res){
    			$resFlag = false;
    		}
    	}
    	if($rcid && $type1){
    		$channelVerifyRule	= self::findByRcidAndType($rcid, 1);
    		if (!$channelVerifyRule){
    			$channelVerifyRule = new RegChannelVerifyRule();
    			$channelVerifyRule->rcid		= $rcid;
    			$channelVerifyRule->type		= 1;
    			$channelVerifyRule->recordTime 	= Utils::getNowTime();
    		}
    		$channelVerifyRule->port	= $portType1;
    		$channelVerifyRule->keys1	= $keys1Type1;
    		$channelVerifyRule->keys2	= $keys2Type1;
    		$channelVerifyRule->keys3	= $keys3Type1;
    		$channelVerifyRule->status	= $statusType1;
    		$res = $channelVerifyRule->save();
    		if(!$res){
    			$resFlag = false;
    		}
    	}
    	return $resFlag;
    }
}