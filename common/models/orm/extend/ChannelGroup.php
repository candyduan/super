<?php
namespace common\models\orm\extend;
use yii\data\Pagination;

class ChannelGroup extends \common\models\orm\base\ChannelGroup{
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
    
    public static function  getItemArrByModel(ChannelGroup $model){
        $item   = $model->toArray();
        $uniqueName = $item['uniqueLimit'] == 0 ? '禁用' : '启用';
        $item['uniqueLimit']    = $uniqueName;
        
        $item['name']   = '['.$item['id'].']'.$item['name'];
        return $item;
    }
}
