<?php
namespace common\models\orm\extend;
use common\library\Utils;
use yii\data\Pagination;
class AgencyAccount extends \common\models\orm\base\AgencyAccount{
    public static function findByPk($id){
        $condition  = array(
            'aaid'  => $id,
        );
        $model  = self::find()
                    ->where($condition)
                    ->one()
                    ;
        return $model;
    }
    public static function isValid($account,$passwd){
        $model  = self::findByAccount($account);
        $flag   = false;
        if($model){
            if($model->passwd == $passwd && $model->status == 1){
                $flag   = true;
            }
        }
        return $flag;
    }
    
    public static function findByAccount($account){
        if(!Utils::isValid($account)){
            return null;
        }
        $condition  = array(
            'account'   => $account,
        );
        $model  = self::find()
                        ->where($condition)
                        ->one();
        return $model;
    }
    
    
    public static function findAllNeedPaginator($page=1,$perpage = 20){
        $data = self::find();
    
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
    
    
    public static function getItemArrByModels($models){
        $list = [['aaid' => 0,'name' => '全部']];
        foreach ($models as $model){
            $item   = array(
                'aaid'  => $model->aaid,
                'name'  => $model->name,
            );
            $list[] = $item;
        }
        return $list;
    }
    
    public static function findAlls(){
        $models = self::find()->all();
        return $models;
    }
}