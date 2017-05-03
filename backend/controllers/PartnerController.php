<?php
namespace backend\controllers;

use Yii;
use yii\base\ErrorException;
use yii\helpers\Html;
use yii\web\Controller;
use backend\web\util\MyHtml;
use backend\web\util\MyMail;
use common\models\orm\extend\Sdk;
use common\models\orm\extend\Admin;
use common\models\orm\extend\Partner;
use common\models\orm\extend\SdkPartner;
use common\models\orm\extend\SdkProvinceLimit;
use common\models\orm\extend\Province;
use common\models\orm\extend\SdkProvinceTimeLimit;
use common\models\orm\extend\SdkTimeLimit;
use common\models\orm\extend\Campaign;
use common\models\orm\extend\SdkCampaignLimit;
/**
 * Partner controller
 */
class PartnerController extends Controller
{
    public function actionIndex()
    {
        $holders = Admin::getAllAdmins();

        return $this->render('index',['holders' =>$holders ]);
    }

    public function actionAjaxIndex(){
        $request = Yii::$app->request;
        $start = intval($request->get('start', 0));
        $length = intval($request->get('length', 100));
        $name = trim($request->get('name',''));
        $utype = intval($request->get('utype', 0));
        $holder = intval($request->get('holder',0));
        $condition = self::_getCondition($name, $utype, $holder);

        $data = Partner::getIndexData($condition, $start,$length);
        $count = Partner::getIndexCount($condition);
        $tabledata = [];
        foreach($data as $value){
            $utypes = [
                0 => '合作模式',
                1 => '内容供应',
                2 => '内容推广',
                3 => '综合'

            ];
            $tabledata[] = [
                MyHtml::aElement('javascript:void(0);' ,'showPartner', $value['id'],'[' .++$start.'] '.$value['name']),
                isset($utypes[$value['utype']]) ? $utypes[$value['utype']] : '',
                $value['belong'] == 1 ?  '支付SDK' : '融合SDK',
                Admin::getNickById($value['holder']),
                $value['payCircle'] == 1 ? '周结' : '月结'
            ];
        }

        $data = [
            'searchData' => [

            ],
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'tableData' => $tabledata,
        ];
        echo json_encode($data);
        exit;
    }

    public function actionGetPartner() {
        $id = Yii::$app->request->get('id');
        $partner = Partner::findByPk($id)->toArray();
        $uTypes = [
            0 => '未确定',
            1 => '内容供应',
            2 => '内容推广',
            3 => '综合',
        ];
        if(!empty($partner)){
            $partner['payType'] = $partner['payType'] == 1 ? '公司' : '个人';
            $partner['holder'] = Admin::getNickById($partner['holder']);
            $partner['payCircle'] = $partner['payCircle'] == 1 ? '周结' : '月结';
            $partner['needSync'] = $partner['needSync'] == 0 ? '不同步每日业绩' : '同步每日业绩';
        }
        echo json_encode($partner);
        exit;
    }

    private function _getCondition($name, $utype, $holder ){
        $condition[] = 'and';
        $condition[] = [
            '=',
            'deleted',
            0
        ];
        $condition[] = [
            '=',
            'belong',
            1
        ];
        if($name!== ''){
            $condition[] = [
                'like',
                'name',
                $name
            ];
        }
        if($utype !== 0){
            $condition[] = [
                '=',
                'utype',
                $utype
            ];
        }
        if($holder !== 0){
            $condition[] = [
                '=',
                'holder',
                $holder
            ];
        }

        return $condition;
    }
}