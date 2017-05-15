<?php
namespace common\models\orm\extend;

use common\library\Utils;
use yii\db\Query;

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

    
}