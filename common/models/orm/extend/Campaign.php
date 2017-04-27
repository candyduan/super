<?php
namespace common\models\orm\extend;

use common\library\Utils;
use yii\db\Query;

class Campaign extends \common\models\orm\base\Campaign {
  /*  public static function getProvinceById($prid){
        $model  = self::find()->select(['name'])->where(['id' => $prid])->one();
        return isset($model['name']) ? $model['name'] :'';
    }*/

    public static function getSdkCampaigns($partner = ''){


        $query = new Query();
        $query	->select([
                'campaign.id as caid',
                'campaign.name as campaignname',
                'partner.name as partnername']
        )
            ->from('campaign')
            ->join('inner join', 'partner',
                'campaign.partner = partner.id')
            ->where(['campaign.belong' => 1,
                    'campaign.status' =>1,
                     'partner.belong' => 1]);
         if(!empty($partner)){
             $query->where(['like', 'partner.name',$partner]);
         }

        $command = $query->createCommand();
        $data = $command->queryAll();
        $return_data = [];
        foreach($data as $value){
            $return_data[$value['caid']] =[
                'partner' => $value['partnername'],
                'campaign' =>  $value['campaignname'],
            ];
        }

        return $return_data;
    }

}