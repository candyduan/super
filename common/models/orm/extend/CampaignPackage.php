<?php
namespace common\models\orm\extend;

use common\library\Utils;
use yii\db\Query;
use yii\data\Pagination;
use common\models\orm\extend\RegSwitch;
use common\models\orm\extend\Partner;

class CampaignPackage extends \common\models\orm\base\CampaignPackage {
   
    public static function getIndexData($where, $start,$length){
        $data= self::find()
        ->join('inner join', 'campaign', 'campaignPackage.campaign = campaign.id')
        ->join('inner join', 'partner', 'campaignPackage.partner = partner.id')
        ->where($where)->orderBy('id desc')
        ->offset($start)
        ->limit($length)
        ->all();
        return $data;
    }
    public static function getIndexCount($where){
        $count = self::find()->join('inner join', 'campaign', 'campaignPackage.campaign = campaign.id')
        ->where($where)->count();
        return $count;
    }
    
    /**
     * 获取渠道分成方式的名称
     */
    public static function getMTypeName($mtype){
        switch ($mtype) {
            case 1: return 'CPS分成';break;
            case 2: return 'CPA成果';break;
            default: return '';break;
        }
    }
    public static function findByPk($id){
    
        $model  = self::find()->where(['id' => $id])->one();
        return $model;
    }

    public static function getIdByCampaignMedaiSign($caid, $mediaSign){

        $data  = self::find()->select('id')->where(['campaign' => $caid, 'mediaSign' => $mediaSign])->one();

        return isset($data['id']) ? $data['id'] : '';
    }
    public static function getMrateById($cpid){
        $data = self::find()->select(['mrate'])->where(['id' => $cpid])->one();

        $a =1 ;
        return isset($data['mrate']) ? $data['mrate'] : '';

    }
	
    public static function findAllNeedPaginator($campaignId,$page=1,$perpage = 20){
    	$condition	= array();
    	if(is_numeric($campaignId) && $campaignId){
    		$condition['campaign'] =  $campaignId;
    	}
    	$data = self::find()->where($condition);
    	$totalCount = $data->count();
    	$pages      = ceil($totalCount/$perpage);
    	$pagination = new Pagination(['totalCount' => $totalCount,'pageSize' => $perpage,'page' => $page]);
    	$models = $data->offset($pagination->offset)->limit($pagination->limit)->all();
    	return [
    		'models'    => $models,
    		'pages'     => $pages,
    		'count'     => $totalCount,
    	];
    }
    
    public static function getItemArrByModel(CampaignPackage $campaignPackageModel){
    	$regSwitchModel	= RegSwitch::findByCampaignPackage($campaignPackageModel->id);
    	$item   = array(
    		'campaignPackageId' => $campaignPackageModel->id,
    		'media'  			=> "[{$campaignPackageModel->media}]".Partner::getNameById($campaignPackageModel->media),
    		'mediaSign'  		=> $campaignPackageModel->mediaSign,
     		'stime'    			=> $regSwitchModel['stime'],
    		'etime'    			=> $regSwitchModel['etime'],
    		'switchStatus'    	=> $regSwitchModel['status'],
    		'switchStatusName'  => $regSwitchModel['status'] ? '打开' : '关闭'
    	);
    	return $item;
    }
    
    public static function fetchAllPartnerBelongSdkArr(){
        $command = \Yii::$app->db->createCommand('select c.id,c.name,cp.mediaSign 
from campaignPackage as cp
inner join partner as c on (cp.media = c.id) 
inner join partner as p on (cp.partner = p.id)
where p.belong = 1 group by c.id');
        return $command->queryAll();
    }
    public static function fetchAllPartnerBelongSdkArrByPid($pid){
        if(!is_numeric($pid)){
            return array();
        }
        $command = \Yii::$app->db->createCommand("select c.id,c.name,cp.mediaSign
from campaignPackage as cp
inner join partner as c on (cp.media = c.id)
inner join partner as p on (cp.partner = p.id)
where p.belong = 1 and p.id = $pid
group by cp.mediaSign");
        return $command->queryAll();
    }
    
    public static function fetchAllPartnerBelongSdkArrByMedia($media){
        if(!is_numeric($media)){
            return array();
        }
        $command = \Yii::$app->db->createCommand("select c.id,c.name,cp.mediaSign
            from campaignPackage as cp
            inner join partner as c on (cp.media = c.id)
            inner join partner as p on (cp.partner = p.id)
            where p.belong = 1 and cp.media = $media
            group by cp.mediaSign");
        return $command->queryAll();
    }
    
    public static function fetchAllAppBelongSdkArrByMedia($media = null){
        $command = \Yii::$app->db->createCommand("select app.id,app.name
            from campaignPackage 
            inner join app on (app.id = campaignPackage.app)
            inner join partner on (partner.id = campaignPackage.partner)
            where partner.belong = 1 and campaignPackage.media = $media
            group by app.id");
        return $command->queryAll();
        
    }
    public static function fetchAllCampaignBelongSdkArrByMedia($media){
        $command = \Yii::$app->db->createCommand("select campaign.id,campaign.name
            from campaignPackage
            inner join campaign on (campaign.id = campaignPackage.campaign)
            inner join partner on (partner.id = campaignPackage.partner)
            where partner.belong = 1 and campaignPackage.media = $media
            group by campaign.id");
        return $command->queryAll();
    }
}