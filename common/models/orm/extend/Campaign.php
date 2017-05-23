<?php
namespace common\models\orm\extend;

use common\library\Utils;
use yii\db\Query;

class Campaign extends \common\models\orm\base\Campaign {

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
                    //'campaign.status' =>1,
                     'partner.belong' => 1]);
         if(!empty($partner)){
             $query->where(['like', 'partner.name',$partner]);
         }

        $command = $query->orderBy('campaign.id desc')->createCommand();
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

    public static function getIndexData($where, $start,$length){
        $data= self::find()
            ->join('inner join', 'app', 'campaign.app = app.id')
            ->where($where)->orderBy('id desc')
            ->offset($start)
            ->limit($length)
            ->all();
        return $data;
    }

    public static function getIndexCount($where){
        $count = self::find()->join('inner join', 'app', 'campaign.app = app.id')
            ->where($where)->count();
        return $count;
    }

    public static function findByPk($id){

        $model  = self::find()->where(['id' => $id])->one();
        return $model;
    }


    public static function getNameById($id){
        $data = self::find()->select(['name'])->where(['id' => $id])->one();
        return isset($data['name']) ? $data['name'] : '';

    }

    public static function getIdByName($name){
        $data = self::find()->select(['id'])->where(['name' => $name])->one();
        return isset($data['id']) ? $data['id'] : '';

    }

    public static function findAllByPartnerAndApp($partner='',$app=''){
    		$condition = [];
    		if(is_numeric($partner) && $partner){
    			$condition['partner'] = $partner;
    		}
    		if(is_numeric($app) && $app){
    			$condition['app'] = $app;
    		}
    		$datas = self::find()->where($condition)->all();
    		$campaignArr = [];
    		if($datas){
    			foreach($datas as $data){
    				$campaignArr[] =[
    						'id' => $data->id,
    						'name' => '【' . $data->id . '】' . $data->name,
    				];
    			}
    		}
    		return  $campaignArr;
    }

}