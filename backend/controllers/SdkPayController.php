<?php
namespace backend\controllers;

use Yii;
use yii\base\ErrorException;
use yii\helpers\Html;
use yii\web\Controller;
use backend\web\util\MyHtml;
use common\models\orm\extend\App;
use common\models\orm\extend\Campaign;
use common\models\orm\extend\Admin;
use common\models\orm\extend\Partner;
use common\models\orm\extend\Sdk;
use common\models\orm\extend\Goods;
use common\models\orm\extend\CampaignSdk;
use common\library\Utils;
use backend\web\util\MyMail;
use common\models\orm\extend\CampaignPackage;
use common\models\orm\extend\CampaignPackageSdk;
use yii\filters\AccessControl;
/**
 * SdkPay controller
 */
class SdkPayController extends Controller
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
        return $this->render('index', []);
    }

    public function actionAjaxIndex(){
        $request = Yii::$app->request;
        $start = intval($request->get('start', 0));
        $length = intval($request->get('length', 100));
//         $caid = $request->get('id','');//campaign 的id
//         $condition = self::_getCondition($caid);

//         $data = CampaignPackage::getIndexData($condition, $start,$length);
//         $count = CampaignPackage::getIndexCount($condition);
//         $status = [
//             0 => '未启用',
//             1 => '使用中',
//         ];
//         $grade = [
//             0 => '普通',
//             1 => 'A级',
//         ];
//         $payMode = [
//             0 => 'Normal',
//             1 => 'Hard',
//         ];
//         $tabledata = [];
//         foreach($data as $value){
//             $tabledata[] = [
//                 MyHtml::aElement('javascript:void(0);' ,'showPackage', $value['id'],$value['id']),
//                 isset($value['media']) ? '['.$value['media'].']'.Partner::getNameById($value['media']):'',
//                 isset($value['mediaSign']) ? $value['mediaSign'] :'',
//                 isset($grade[$value['grade']]) ? $grade[$value['grade']] :'',
//                 isset($status[$value['opened']]) ? $grade[$value['opened']] :'',
//                 isset($payMode[$value['payMode']]) ? $payMode[$value['payMode']] :'',
//                 sprintf('%.2f',$value['rate']) . ' %',
//                 isset($value['mtype']) ? CampaignPackage::getMTypeName($value['mtype']) :'',
//                 sprintf('%.2f',$value['mrate']) . ' %',
//                 sprintf('%.2f',$value['cutRate']) . ' % @' . date('Y-m-d', $value['cutDay']),
//                 //MyHtml::aElement("javascript:void(0);", 'getSdks',$value['id'],'功能一'). MyHtml::br().
//                 //MyHtml::aElement("javascript:void(0);", 'getSdks',$value['id'],'功能二'). MyHtml::br().
//                 MyHtml::aElement('javascript:void(0);' ,'getSdks',$value['id'],'渠道关联配置')
//             ];
//         }

//         $partnerName = '';
//         $appName = '';
//         $campaignName = '';
//         $campaignModel = Campaign::findByPk($caid);
//         if($campaignModel){
//             $campaignName = '['.$campaignModel->id.']'.$campaignModel->name;
//             $appModel = App::findByPk($campaignModel->app);
//             if($appModel){
//                 $appName = '['.$appModel->id.']'.$appModel->name;
//             }
//             $partnerModel = Partner::findByPk($campaignModel->partner);
//             if($partnerModel){
//                 $partnerName = '['.$partnerModel->id.']'.$partnerModel->name;
//             }
//         }
        
//         $data = [
//             'searchData' => [

//             ],
//             'recordsTotal' => $count,
//             'recordsFiltered' => $count,
//             'tableData' => $tabledata,
//             'partnerName' => $partnerName,
//             'appName'    => $appName,
//             'campaignName' => $campaignName,
//         ];
//         Utils::jsonOut($data);
//         exit;
    }

    private function _getCondition($id){
        $condition[] = 'and';
//         $condition[] = [
//             '=',
//             'campaign.deleted',
//             0
//         ];

        $condition[] = [
            '=',
            'campaign.belong',
            1
        ];

        if($id!== ''){
            $condition[] = [
                '=',
                'campaign.id',
                $id
            ];
        }

        return $condition;
    }
}
