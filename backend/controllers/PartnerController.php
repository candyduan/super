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
use common\library\Utils;
use yii\filters\AccessControl;
/**
 * Partner controller
 */
class PartnerController extends Controller
{
    public $layout = "sdk";
    public function behaviors()
    {
        return [

            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['index','create','update','view'],
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // everything else is denied
                ],
            ],
        ];
    }

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
                MyHtml::aElement('javascript:void(0);' ,'showPartner', $value['id'],'[' .$value['id'].'] '.$value['name']),
                isset($utypes[$value['utype']]) ? $utypes[$value['utype']] : '',
                $value['belong'] == 1 ?  '融合SDK' : '支付SDK',
                Admin::getNickById($value['holder']),
                $value['payCircle'] == 1 ? '周结' : '月结',
                MyHtml::aElement("/app/index?id=". $value['id'], '','','查看产品')
            ];
        }

        $data = [
            'searchData' => [

            ],
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'tableData' => $tabledata,
        ];
        Utils::jsonOut($data);
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
            $partner['uType'] = isset($uTypes[$partner['utype']]) ? $uTypes[$partner['utype']] : '';
            $partner['holder'] = Admin::getNickById($partner['holder']);
            $partner['payCircle'] = $partner['payCircle'] == 1 ? '周结' : '月结';
            $partner['needSync'] = $partner['needSync'] == 0 ? '不同步每日业绩' : '同步每日业绩';
        }
        Utils::jsonOut($partner);
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
