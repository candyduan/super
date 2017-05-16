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
use common\library\province\ProvinceUtils;
use common\models\orm\extend\SdkPayDay;
/**
 * SdkPay controller
 */
class SdkPayController extends BController
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
    
    public function actionGetProvince(){
        $res = ProvinceUtils::getProvinceOrderByChart();
        $sublist = array(
            array(
                'id' => 0,
                'name' => '不限定'
            )
        );
        array_unshift($res, $sublist);
        Utils::jsonOut($res);
        exit;
    }

    public function actionAjaxIndex(){
        $start = Utils::getBackendParam('start',0);
        $length = Utils::getBackendParam('length',100);
        
        $sdk = Utils::getBackendParam('sdk','');
        $stime = Utils::getBackendParam('startDate','');
        $etime = Utils::getBackendParam('endDate','');
        
        $dateType = Utils::getBackendParam('dateType',3);
        $provider = Utils::getBackendParam('provider',0);
        $province = json_decode(Utils::getBackendParam('province','[]'),true);
        $time = json_decode(Utils::getBackendParam('time','[]'),true);
        
        $checkSDK = Utils::getBackendParam('checkSDK',true);
        $checkProvince = Utils::getBackendParam('checkProvince',true);
        $checkProvider = Utils::getBackendParam('checkProvider',true);
        
        $condition = self::_getCondition($sdk,$stime,$etime,$dateType,$provider,$province,$time);
        
        $data = SdkPayDay::getIndexData($condition, $start,$length);
        $count = SdkPayDay::getIndexCount($condition);
        $providerName = [
            0 => '-',
            1 => '移动',
            2 => '联通',
            3 => '电信',
        ];
        $tabledata = [];
        foreach($data as $value){
            $item = array(date('Y-m-d',strtotime($value['date'])));
            if($checkSDK){
                array_push($item, $value['sdk']);
            }
            if($checkProvider){
                array_push($item, $providerName[$value['provider']]);
            }
            if($checkProvince){
                array_push($item, $value['provinceName']);
            }
            array_push($item, $value['provinceName']);
            $tabledata[] = $item;
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

    private function _getCondition($sdk,$stime,$etime,$dateType,$provider,$province,$time){
        $condition[] = 'and';
        $condition[] = [
            '=',
            'sdkPayDay.status',
            1
        ];
        if($sdk > 0){
            $condition[] = [
                '=',
                'sdkPayDay.sdid',
                $sdk
            ];
        }
        
        if(Utils::isDate($stime)){
            $condition[] = [
                '>=',
                'sdkPayDay.date',
                $stime.' 00:00:00'
            ];
        }
        if(Utils::isDate($etime)){
            $condition[] = [
                '<=',
                'sdkPayDay.date',
                $etime.' 23:59:59'
            ];
        }
        // TODO dateType

        if($provider > 0){
            $condition[] = [
                '=',
                'sdkPayDay.provider',
                $provider
            ];
        }
        if(count($province) > 0){
            $condition[] = [
                'in',
                'sdkPayDay.prid',
                $province
            ];
        }
        if(count($time) > 0){// TODO
        }
        return $condition;
    }
}
