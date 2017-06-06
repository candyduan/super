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
use common\library\BController;
/**
 * Campaign controller
 */
class PackageController extends BController
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
        $id = Yii::$app->request->get('caid','');
        return $this->render('index', ['id' => $id]);
    }

    public function actionAjaxIndex(){
        $request = Yii::$app->request;
        $start = intval($request->get('start', 0));
        $length = intval($request->get('length', 100));
        $caid = $request->get('id','');//campaign 的id
        $condition = self::_getCondition($caid);

        $data = CampaignPackage::getIndexData($condition, $start,$length);
        $count = CampaignPackage::getIndexCount($condition);
        $status = [
            0 => '未启用',
            1 => '使用中',
        ];
        $grade = [
            0 => '普通',
            1 => 'A级',
        ];
        $payMode = [
            0 => 'Normal',
            1 => 'Hard',
        ];
        $tabledata = [];
        foreach($data as $value){
            $tabledata[] = [
                MyHtml::aElement('javascript:void(0);' ,'showPackage', $value['id'],$value['id']),
                isset($value['media']) ? '['.$value['media'].']'.Partner::getNameById($value['media']):'',
                isset($value['mediaSign']) ? $value['mediaSign'] :'',
                isset($grade[$value['grade']]) ? $grade[$value['grade']] :'',
                isset($status[$value['opened']]) ? $grade[$value['opened']] :'',
                isset($payMode[$value['payMode']]) ? $payMode[$value['payMode']] :'',
                sprintf('%.2f',$value['rate']) . ' %',
                isset($value['mtype']) ? CampaignPackage::getMTypeName($value['mtype']) :'',
                sprintf('%.2f',$value['mrate']) . ' %',
                sprintf('%.2f',$value['cutRate']) . ' % @' .( $value['cutDay'] == 0 ? '' : date('Y-m-d', $value['cutDay'])),
                sprintf('%.2f',$value['mcutRate']) . ' % @' . ( $value['mcutDay'] == 0 ? '' : date('Y-m-d', $value['mcutDay'])),
                MyHtml::aElement('javascript:void(0);' ,'getSdks',$value['id'],'渠道关联配置')
            ];
        }

        $partnerName = '';
        $appName = '';
        $campaignName = '';
        $campaignModel = Campaign::findByPk($caid);
        if($campaignModel){
            $campaignName = '['.$campaignModel->id.']'.$campaignModel->name;
            $appModel = App::findByPk($campaignModel->app);
            if($appModel){
                $appName = '['.$appModel->id.']'.$appModel->name;
            }
            $partnerModel = Partner::findByPk($campaignModel->partner);
            if($partnerModel){
                $partnerName = '['.$partnerModel->id.']'.$partnerModel->name;
            }
        }
        
        $data = [
            'searchData' => [

            ],
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'tableData' => $tabledata,
            'partnerName' => $partnerName,
            'appName'    => $appName,
            'campaignName' => $campaignName,
        ];
        Utils::jsonOut($data);
        exit;
    }

    public function actionGetPackage() {
        $id = Yii::$app->request->get('cpid');
        $package = [];
        if(isset($id)) {
            $package = CampaignPackage::findByPk($id)->toArray();
            if (!empty($package)) {
                $app = App::findByPk($package['app'])->toArray();
                $partner = Partner::findByPk($package['partner'])->toArray();
                $package['appname'] = isset($app['name']) ? $app['name'] : '';
                $package['packagename'] = isset($package['apk']) ? App::getNameById($package['apk']) : '';
                $package['versioncode'] = isset($package['versionCode']) ? $package['versionCode'] : '';
                $package['versionname'] = isset($package['versionName']) ? $package['versionName'] : '';
                $package['size'] = sprintf('%.2f', $package['size']) . 'MB';
                $package['rate'] = sprintf('%.2f', $package['rate']) . '%'; //cp分成比例
                $package['cutrate'] =  $package['cutRate']; //cp优化比例
                $package['mcutrate'] = $package['mcutRate'];  //cp优化比例
                $package['cutday'] = $package['cutDay'] == 0 ? '' : date('Y-m-d', $package['cutDay']); //cp优化开始
                $package['mcutday'] = $package['mcutDay'] == 0 ? '' : date('Y-m-d', $package['mcutDay']);
                $package['mtype'] = isset($package['mtype']) ? CampaignPackage::getMTypeName($package['mtype']) :'';
                $package['mrate'] = sprintf('%.2f', $package['mrate']) . '%';
                $package['sign'] = isset($package['mediaSign']) ? $package['mediaSign'] : '';
                $package['distname'] = isset($package['media']) ? Partner::getNameById($package['media']) : '';
                $package['grade'] = $package['grade'] == 0 ? '普通' : 'A级';
                $package['paymode'] = isset($package['payMode']) ? $package['payMode'] :'';
            }
        }
        Utils::jsonOut($package);
        exit;
    }

    public function actionModifyPaymode() {
        $resultState = 0;
        $cpid = Yii::$app->request->get('cpid');
        $paymode =  intval(Utils::getBParam('paymode'));
        $cutRate = intval(Utils::getBParam('cutrate'));
        $cutDay = trim(Utils::getBParam('cutday'));
        $mcutRate = intval(Utils::getBParam('mcutrate'));
        $mcutDay = trim(Utils::getBParam('mcutday'));
        if (isset($cpid)) {
            $transaction =  CampaignPackage::getDb()->beginTransaction();
            try {
                $packageModel = CampaignPackage::findByPk($cpid);
                if($packageModel){
                    $packageModel->payMode = $paymode;
                    $packageModel->cutRate = $cutRate;
                    $packageModel->cutDay = $cutDay == '' ? 0 : strtotime($cutDay);
                    $packageModel->mcutRate = $mcutRate;;
                    $packageModel->mcutDay = $mcutDay == '' ? 0 : strtotime($mcutDay);
                    $resultState  = $packageModel->save() == true ? 1: 0;
                }
                $transaction->commit();
            } catch (ErrorException $e) {
                $resultState = 0;
                $transaction->rollBack();
                MyMail::sendMail($e->getMessage(), 'Error From modify package pay mode and rate');
            }
        }
    
        echo json_encode($resultState);
        exit;
    }

    public function actionGetSdks() {//活动包下的SDK
        $cpid = Yii::$app->request->get('cpid');
        $data = [];
        $sdks = [];
        if(isset($cpid)) {
            $package = CampaignPackage::findByPk($cpid);
            if (!empty($package)) {
                $data['mediaSign'] = $package->mediaSign;
                $result = CampaignSdk::fetchAllByCaid($package->campaign);
                foreach($result as $key => $value){
                    $sdid = $value['sdid'];
                    $sdks[$key]['sdid'] = $sdid;
                    $sdks[$key]['name'] = Sdk::getNameBySdid($sdid);
                    $sdks[$key]['status'] = MyHtml::iElement('glyphicon-edit glyphicon grey ', 'changeSign',$cpid.','.$sdid, '编辑','btn_sdk_sign_'.$sdid) .' ';

                    $packageSdkModel = CampaignPackageSdk::findByCpidSdid($cpid,$sdid);
                    $status = 1;
                    $sign = '';
                    if($packageSdkModel){
                        $sign = $packageSdkModel->distSign;
                        $status = $packageSdkModel->status;
                    }
                    $sdks[$key]['sign'] = MyHtml::inputElement($sign, 'input_sdk_sign_'.$sdid, 'changeSaveBtn',$sdid);
                    if(1 == $status){
                        $sdks[$key]['status'] .=  MyHtml::iElement('glyphicon-ok glyphicon green ', 'changeStatus',$sdid.',0', $sdid);
                    }else{
                        $sdks[$key]['status'] .= MyHtml::iElement('glyphicon-remove glyphicon red', 'changeStatus', $sdid.',1', $sdid);
                    }
                }
            }
        }
        $data['data'] = $sdks;
        Utils::jsonOut($data);
        exit;
    }
    
    public function actionModifyStatus() {
        $resultState = 0;
        $cpid = Yii::$app->request->get('cpid');
        $sdid = Yii::$app->request->get('sdid');
        $status =  Yii::$app->request->get('status');
        if (isset($cpid)) {
            $transaction =  CampaignSdk::getDb()->beginTransaction();
            try {
                $campaignSdkModel= CampaignPackageSdk::findByCpidSdid($cpid,$sdid);
                if($campaignSdkModel){
                    $campaignSdkModel->status = $status;
                    $resultState  = $campaignSdkModel->save() == true ? 1: 0;
                }
                $transaction->commit();
            } catch (ErrorException $e) {
                $resultState = 0;
                $transaction->rollBack();
                MyMail::sendMail($e->getMessage(), 'Error From modify package sdk status');
            }
        }
    
        echo json_encode($resultState);
        exit;
    }
    
    public function actionModifySign() {
        $resultState = 0;
        $cpid = Yii::$app->request->get('cpid');
        $sdid = Yii::$app->request->get('sdid');
        $sign =  Yii::$app->request->get('sign');
        if (isset($cpid)) {
            $transaction =  CampaignPackageSdk::getDb()->beginTransaction();
            try {
                $campaignSdkModel= CampaignPackageSdk::findByCpidSdid($cpid,$sdid);
                if($campaignSdkModel){
                    $campaignSdkModel->distSign = $sign;
                    $resultState  = $campaignSdkModel->save() == true ? 1: 0;
                }else{
                    $campaignSdkModel = new CampaignPackageSdk();
                    $campaignSdkModel->cpid = $cpid;
                    $campaignSdkModel->sdid = $sdid;
                    $campaignSdkModel->distSign = $sign;
                    $campaignSdkModel->status = 1;
                    $resultState = $campaignSdkModel->insert() == true ?1:0;
                }
                $transaction->commit();
            } catch (ErrorException $e) {
                $resultState = 0;
                $transaction->rollBack();
                MyMail::sendMail($e->getMessage(), 'Error From modify package sdk status');
            }
        }
    
        echo json_encode($resultState);
        exit;
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
