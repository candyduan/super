<?php
namespace common\models\orm\extend;
use yii\data\Pagination;
use common\library\Constant;

class Channel extends \common\models\orm\base\Channel{
    public static function findByPk($id){
        $condition  = array(
            'id'    => $id,
        );
        $model  = self::find()
                        ->where($condition)
                        ->one()
                        ;
        return $model;
    }
    
    public static function findByMerchantNeedPaginator($merchant,$page = 1,$perpage = 20){
        $condition  = array(
            'merchant'  => $merchant,
        );
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
    
    public static function findAllNeedPaginator($page = 1,$perpage = 20){
        $data = self::find()->orderBy('id DESC');
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
    public static function getNameByStatus($status){
        switch ($status){
            case 0:
                $name   = '可用';
                break;
            case 1:
                $name   = '暂停';
                break;
            case 2:
                $name   = '删除';
                break;
            case 3:
                $name   = '测试';
                break;
            default:
                $name   = '';
        }
        return $name;
    }
    public static function getNameByProvider($provider){
        switch ($provider){
            case 1:
                $name   = '移动';
                break;
            case 2:
                $name   = '联通';
                break;
            case 3:
                $name   = '电信';
                break;
            case 4:
                $name   = '支付宝';
                break;
            case 5:
                $name   = '银联';
                break;
            case 6:
                $name   = '微信';
                break;
            case 7:
                $name   = '易联';
                break;
        }
        return $name;
    }
    
    public static function getNameByDevType($devType){
        switch ($devType){
            case Constant::CHANNEL_SINGLE:
                $name   = 'single';
                break;
            case Constant::CHANNEL_DOUBLE:
                $name   = 'double';
                break;
            case Constant::CHANNEL_SMSP:
                $name   = 'sms+';
                break;
            case Constant::CHANNEL_URLP:
                $name   = 'url+';
                break;
            case Constant::CHANNEL_MULTSMS:
                $name   = 'multiSMS';
                break;
            case Constant::CHANNEL_MULTURL:
                $name   = 'multiURL';
                break;
            default:
                $name   ='unknow';
        }
        return $name;
    }
    
    public static function getItemArrByModel(Channel $model){
        $item   = array(
            'chid'      => $model->id,
            'name'      => '['.$model->id.']'.$model->name,
            'sign'      => $model->sign,
            'merchant'  => '['.$model->merchant.']'.Merchant::getNameById($model->merchant),
            'holder'    => Admin::getNickById($model->holder),
            'status'    => self::getNameByStatus($model->status),
            'provider'  => self::getNameByProvider($model->provider),
            'devType'   => self::getNameByDevType($model->devType),
            'devTypeId' => $model->devType,
        	'mainStatus'	=> $model->id ? ChannelCfgMain::findByChannelId($model->id)->status : 0,
        );
        return $item;
    }
    
    public static function getTypeHeaderChannelList(){
        $res			= array();
        $channelList 	= self::find()->all();
        foreach ($channelList as $channel){
            $res[]	= array('id'=>$channel['id'],'name'=>"【".$channel['id']."】".$channel['name']);
        }
        return $res;
    }
    
}
