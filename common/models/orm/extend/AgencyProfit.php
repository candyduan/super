<?php
namespace common\models\orm\extend;
use common\library\Utils;
use yii\data\Pagination;

class AgencyProfit extends \common\models\orm\base\AgencyProfit{
    public static function findByAaidStimeEtimeNeedPaginator($aaid = 0,$stime,$etime,$page = 1,$perpage = 20){
        $data = self::find();
        if(Utils::isValid($stime) && Utils::isValid($etime)){
            $data->andWhere(['>=','day',$stime]);
            $data->andWhere(['<=','day',$etime]);
        }
        if(is_numeric($aaid) && $aaid > 0){
            $data->andWhere(['=','aaid',$aaid]);
        }
//                         $sql = $data->createCommand()->getRawSql();
//                         echo $sql;exit;
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
    
    
    public static function getItemArrByModel(AgencyProfit $model){
        $agencyAccountModel = AgencyAccount::findByPk($model->aaid);
        if($agencyAccountModel){
            $account    = $agencyAccountModel->name;
        }else{
            $account    = '未知';
        }
        $item   = array(
            'day'       => $model->day,
            'account'   => $account,
            'succ'      => $model->succ,
            'fail'      => $model->fail,
            'rate'      => round($model->succ/($model->succ + $model->fail)*100,2).'%',
        );
        return $item;
    }
}
