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
use common\library\BController;
use common\models\orm\extend\Campaign;
use common\models\orm\extend\App;
use common\models\orm\extend\SdkPackagePayDay;
use common\models\orm\extend\OutUser;
use common\models\orm\extend\CampaignPackage;
/**
 * Partner controller
 */
class PartnerDataController extends BController
{
    public $layout = "out";
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

    public function actionGain()
    {
        self::_setLayout();
        $pid = self::_getPartnerId();
        $apps = App::fetchAllBelongSdkArrByPid($pid);
        $campaigns = Campaign::fetchAllBelongSdkArrByPid($pid);
        $channels = CampaignPackage::fetchAllPartnerBelongSdkArrByPid($pid);
        return $this->render('gain', ['apps' =>$apps,'campaigns' => $campaigns,'channels' =>$channels]);
    }
    
    public function actionCpsGain(){
        self::_setLayout();
        $pid = self::_getPartnerId();
        $apps = App::fetchAllBelongSdkArrByMedia($pid);
        $campaigns = Campaign::fetchAllBelongSdkArrByMedia($pid);
        $channels = CampaignPackage::fetchAllPartnerBelongSdkArrByMedia();
        return $this->render('cps-gain', ['apps' =>$apps,'campaigns' => $campaigns,'channels' =>$channels]);
    }
    
    public function actionAjaxGain(){
        $start = Utils::getBackendParam('start',0);
        $length = Utils::getBackendParam('length',100);
    
        $app = Utils::getBackendParam('app','');
        $campaign = Utils::getBackendParam('campaign','');
        $channel = Utils::getBackendParam('channel','');
    
        $stime = Utils::getBackendParam('startDate','');
        $etime = Utils::getBackendParam('endDate','');
    
        $dateType = Utils::getBackendParam('dateType',3);
    
        $checkAPP = Utils::getBackendParam('checkAPP');
        $checkAPP = $checkAPP?true:false;
        $checkCampaign = Utils::getBackendParam('checkCampaign');
        $checkCampaign = $checkCampaign?true:false;
        $checkM = Utils::getBackendParam('checkM');
        $checkM = $checkM?true:false;
        
        $count = 0;
        $tabledata = [];
        $partner = self::_getPartnerId();
        if($partner > 0){
            if( 3 == $dateType ||  4 == $dateType){//时段和月份全搜算总数
                $start = null;
                $length = null;
            }
            
            $condition = self::_getCondition($checkAPP,$checkCampaign,$checkM,$partner,$app,$campaign,$channel,$stime,$etime,$dateType);
            $data = SdkPackagePayDay::getIndexData($condition['select'],$condition['where'],$condition['group'], $start,$length);
            $count = SdkPackagePayDay::getIndexCount($condition['where'],$condition['group']);
            
            foreach($data as $value){
                $item = array();
                if( 3 == $dateType){//时段不显示时间
                    array_push($item, '-');
                }else if(4 == $dateType){//月份显示月
                    array_push($item, date('Y-m',strtotime($value['date'])));
                }else{
                    array_push($item, date('Y-m-d',strtotime($value['date'])));
                }
                if($checkAPP){
                    array_push($item, $value['app']);
                }else{
                    array_push($item, '-');
                }
                if($checkCampaign){
                    array_push($item, $value['c']);
                }else{
                    array_push($item, '-');
                }
                if($checkM){
                    array_push($item, $value['mediaSign']);
                }else{
                    array_push($item, '-');
                }
            
                array_push($item, $value['newUsers']);
                array_push($item, number_format($value['successPay'],0));
            
                $tabledata[] = $item;
            }
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
    public function actionAjaxCpsGain(){
        $start = Utils::getBackendParam('start',0);
        $length = Utils::getBackendParam('length',100);
    
        $app = Utils::getBackendParam('app','');
        $campaign = Utils::getBackendParam('campaign','');
        $channel = Utils::getBackendParam('channel','');
    
        $stime = Utils::getBackendParam('startDate','');
        $etime = Utils::getBackendParam('endDate','');
    
        $dateType = Utils::getBackendParam('dateType',3);
    
        $checkAPP = Utils::getBackendParam('checkAPP');
        $checkAPP = $checkAPP?true:false;
        $checkCampaign = Utils::getBackendParam('checkCampaign');
        $checkCampaign = $checkCampaign?true:false;
        $checkM = Utils::getBackendParam('checkM');
        $checkM = $checkM?true:false;
    
        $count = 0;
        $tabledata = [];
        $partner = self::_getPartnerId();
        if($partner > 0){
            if( 3 == $dateType ||  4 == $dateType){//时段和月份全搜算总数
                $start = null;
                $length = null;
            }
    
            $condition = self::_getCondition($checkAPP,$checkCampaign,$checkM,$partner,$app,$campaign,$channel,$stime,$etime,$dateType,true);
            $data = SdkPackagePayDay::getIndexData($condition['select'],$condition['where'],$condition['group'], $start,$length);
            $count = SdkPackagePayDay::getIndexCount($condition['where'],$condition['group']);
    
            foreach($data as $value){
                $item = array();
                if( 3 == $dateType){//时段不显示时间
                    array_push($item, '-');
                }else if(4 == $dateType){//月份显示月
                    array_push($item, date('Y-m',strtotime($value['date'])));
                }else{
                    array_push($item, date('Y-m-d',strtotime($value['date'])));
                }
                if($checkAPP){
                    array_push($item, $value['app']);
                }else{
                    array_push($item, '-');
                }
                if($checkCampaign){
                    array_push($item, $value['c']);
                }else{
                    array_push($item, '-');
                }
                if($checkM){
                    array_push($item, $value['mediaSign']);
                }else{
                    array_push($item, '-');
                }
    
                array_push($item, $value['newUsers']);
                array_push($item, $value['successPay']);
    
                $tabledata[] = $item;
            }
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
    
    private function _getCondition($checkAPP,$checkCampaign,$checkM,$partner,$app,$campaign,$channel,$stime,$etime,$dateType,$isChannel = FALSE){
        $select = [
            'sdkPackagePayDay.date as date',
            'app.name as app',
            'campaign.name as c',
            'channel.name as m',
            'campaignPackage.mediaSign as mediaSign',
            'sum(sdkPackagePayDay.newUsers) as newUsers',
            'sum(sdkPackagePayDay.successPay) as successPay',
        ];
    
        $where[] = 'and';
        $where[] = [
            '=',
            'sdkPackagePayDay.status',
            1
        ];

        if($isChannel){
            if($partner > 0){
                $where[] = [
                    '=',
                    'campaignPackage.media',
                    $partner
                ];
            }
        }else{
            if($partner > 0){
                $where[] = [
                    '=',
                    'campaignPackage.partner',
                    $partner
                ];
            }
        }
        
        if($app > 0){
            $where[] = [
                '=',
                'campaignPackage.app',
                $app
            ];
        }
        if($campaign > 0){
            $where[] = [
                '=',
                'campaignPackage.campaign',
                $campaign
            ];
        }
        if(Utils::isValid($channel)){
            $where[] = [
                '=',
                'campaignPackage.mediaSign',
                $channel
            ];
        }
    
        switch ($dateType){
            case 1:// 天
            case 3://时段
                if(Utils::isDate($stime)){
                    $where[] = [
                        '>=',
                        'sdkPackagePayDay.date',
                        $stime.' 00:00:00'
                    ];
                }
                if(Utils::isDate($etime)){
                    $where[] = [
                        '<=',
                        'sdkPackagePayDay.date',
                        $etime.' 23:59:59'
                    ];
                }
                break;
            case 4://月份
                $sdate = date('Y-m-01',strtotime($stime));
                $edate = date('Y-m-01',strtotime($etime));
                $edate = date("Y-m-d",strtotime("$edate 1 month -1 day"));
    
                $where[] = [
                    '>=',
                    'sdkPackagePayDay.date',
                    $sdate.' 00:00:00'
                ];
                $where[] = [
                    '<=',
                    'sdkPackagePayDay.date',
                    $edate.' 23:59:59'
                ];
                break;
        }
    
        $group = [];
        if(1 == $dateType){//按天统计
            $group[] = 'sdkPackagePayDay.date';
        }
        if($checkAPP){
            $group[] = 'campaignPackage.app';
        }
        if($checkCampaign){
            $group[] = 'campaignPackage.campaign';
        }
        if($checkM){
            $group[] = 'campaignPackage.media';
        }
        $condition['select'] = $select;
        $condition['where'] = $where;
        $condition['group'] = $group;
        return $condition;
    }
    
    private function _setLayout(){
        $layout = yii::$app->params['partnerDataLayout'];
        if(!empty($layout))
            $this->layout = $layout;
    }
    private function _getPartnerId(){
        $partner = Utils::getBackendParam('partner');
        
        $session = \Yii::$app->getSession();
        $ouid = $session->get('__outuserid');
        if(Utils::isValid($ouid)){
            $outUserModel = OutUser::findByOuid($ouid);
            if($outUserModel){
                $partner = $outUserModel->partner;
            }
        }
        return $partner;
    }
}
