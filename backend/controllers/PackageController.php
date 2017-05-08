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
/**
 * Campaign controller
 */
class PackageController extends Controller
{
    public function actionIndex()
    {
        $id = Yii::$app->request->get('cid','');
        return $this->render('index', ['id' => $id]);
    }

    public function actionAjaxIndex(){
        $request = Yii::$app->request;
        $start = intval($request->get('start', 0));
        $length = intval($request->get('length', 100));
        $id = $request->get('id','');//campaign 的id
        $condition = self::_getCondition($id);

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
                sprintf('%.2f',$value['cutRate']) . ' % @' . date('Y-m-d', $value['cutDay']),
                //MyHtml::aElement("javascript:void(0);", 'getSdks',$value['id'],'功能一'). MyHtml::br().
                //MyHtml::aElement("javascript:void(0);", 'getSdks',$value['id'],'功能二'). MyHtml::br().
                MyHtml::aElement('javascript:void(0);' ,'getSdks',$value['id'],'渠道关联配置')
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
                $package['cutrate'] = sprintf('%.2f', $package['cutRate']) . '%';  //cp优化比例
                $package['cutday'] = date('Y-m-d', $package['cutDay']); //cp优化开始
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
        $paymode =  Yii::$app->request->get('paymode');
        if (isset($cpid)) {
            $transaction =  CampaignPackage::getDb()->beginTransaction();
            try {
                $packageModel = CampaignPackage::findByPk($cpid);
                if($packageModel){
                    $packageModel->payMode = $paymode;
                    $resultState  = $packageModel->save() == true ? 1: 0;
                }
                $transaction->commit();
            } catch (ErrorException $e) {
                $resultState = 0;
                $transaction->rollBack();
                MyMail::sendMail($e->getMessage(), 'Error From modify package pay mode');
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
                $campaignSdkmodels = CampaignSdk::fetchAllByCaid($package->campaign);
                foreach($campaignSdkmodels as $key => $model){
                    $sdks[$key]['name'] = Sdk::getNameBySdid($model->sdid);
                    $sdks[$key]['sign'] = CampaignPackageSdk::getSignByCpidSdid($cpid,$model->sdid);
                    if($model->status == 1){
                        $sdks[$key]['status'] =  MyHtml::iElement('glyphicon-ok-sign glyphicon green', 'changeStatus',$model->sdid.',0', $model->sdid);
                    }else{
                        $sdks[$key]['status'] = MyHtml::iElement('glyphicon-remove glyphicon red', 'changeStatus', $model->sdid.',1', $model->sdid);
                    }
                }
            }
        }
        $data['data'] = $sdks;
        Utils::jsonOut($data);
        exit;
    }

    private function _getCondition($id){
        $condition[] = 'and';
//         $condition[] = [
//             '=',
//             'campaign.deleted',
//             0
//         ];

//         $condition[] = [
//             '=',
//             'campaign.belong',
//             1
//         ];

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
