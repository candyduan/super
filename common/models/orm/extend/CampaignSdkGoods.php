<?php
namespace common\models\orm\extend;

use common\library\Utils;

class CampaignSdkGoods extends \common\models\orm\base\CampaignSdkGoods {


    public static function getGoodsByCsid($csid)
    {
        $data = self::find()->select(['goid','priceSign'])->where(['csid' => $csid])->all();
        $return_data = [];
        foreach($data as $value){
            $return_data[$value['goid']] = $value['priceSign'];
        }
        return $return_data;
    }

    public static function getStatusByCsidGoid($csid,$goid)
    {
        $data = self::find()->select(['status'])->where(['csid' => $csid,'goid'=> $goid])->one();
        return isset($data['status']) ? $data['status'] : '';
    }


    public static function deleteByCsidGoid($csid, $goid)
    {
        self::deleteAll(['csid' => $csid,'goid' => $goid]);
    }

    public static function findByCsidGoid($csid,$goid){

        $model  = self::find()->where(['csid' => $csid,'goid' => $goid])->one();
        return $model;
    }

}