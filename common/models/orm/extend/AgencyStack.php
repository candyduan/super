<?php
namespace common\models\orm\extend;

use common\library\Utils;
use yii\data\Pagination;

class AgencyStack extends \common\models\orm\base\AgencyStack{
    const STATUS_DEL    = 0;
    const STATUS_SDK    = 1;
    const STATUS_APK    = 2;
    const STATUS_SUCC   = 3;
    public static function findByPk($id){
        $condition  = array(
            'asid'  => $id,
        );
        $model  = self::find()
                    ->where($condition)
                    ->one()
                    ;
        return $model;
    }
    public static function findNewByAaid($aaid){
        if(!is_numeric($aaid)){
            return null;
        }
        $condition  = array(
            'aaid'      => $aaid,
            'status'    => 1,
        );
        $min    = date('Y-m-d H:i:s',time() - 60);
        $model  = self::find()
                        ->where($condition)
                        ->andWhere(['>','recordTime',$min])
                        ->orderBy('asid DESC')
                        ->one()
                        ;
        return $model;
    }
    
    
    public static function findByAaidMobileStimeEtimeNeedPaginator($aaid,$mobile,$stime,$etime,$page = 1,$perpage = 20){
        $data = self::find();
        if(Utils::isValid($stime) && Utils::isValid($etime)){
            $min    = $stime.' 00:00:00';
            $max    = $etime.' 23:59:59';
            $data->andWhere(['>=','agencyStack.recordTime',$min]);
            $data->andWhere(['<=','agencyStack.recordTime',$max]);
        }
        if(is_numeric($aaid) && $aaid > 0){
            $data->andWhere(['=','agencyStack.aaid',$aaid]);
        }
        
        if(Utils::isValid($mobile)){
            $data->innerJoin('simCard','agencyStack.imsi = simCard.imsi');
            $data->andWhere(['=','simCard.mobile',$mobile]);
        }
//                 $sql = $data->createCommand()->getRawSql();
//                 echo $sql;exit;
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
                $name   = '删除';
               break;
            case 1:
                $name   = '已告知SDK';
                break;
            case 2:
                $name   = '已告知第三方';
                break;
            case 3:
                $name   = '注册成功';
                break;
            default:
                $name   = '未知';
        }
        return $name;
    }
    public static function getItemArrByModel(AgencyStack $model){
        $agencyAccountModel = AgencyAccount::findByPk($model->aaid);
        if($agencyAccountModel){
            $account = $agencyAccountModel->name;
        }else{
            $account = '未知';
        }
        $simCardModel   = SimCard::findByImsi($model->imsi);
        if($simCardModel){
            $mobile = $simCardModel->mobile;
        }else{
            $mobile = '';
        }
        
        $item   = array(
           'asid'       => $model->asid,
           'account'    => $account,
           'imsi'       => $model->imsi,
           'mobile'     => $mobile,
           'verifyCode' => $model->verifyCode,
           'time'       => $model->recordTime,
           'status'     => self::getNameByStatus($model->status),
        );
        return $item;
    }
}