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
        
        $sdk = Utils::getBackendParam('SDK','');
        $stime = Utils::getBackendParam('startDate','');
        $etime = Utils::getBackendParam('endDate','');
        
        $dateType = Utils::getBackendParam('dateType',3);
        $provider = Utils::getBackendParam('provider',0);
        $province = Utils::getBackendParam('province','');
        $time = Utils::getBackendParam('time','');
        
        $checkSDK = Utils::getBackendParam('checkSDK');
        $checkSDK = $checkSDK?true:false;
        $checkProvince = Utils::getBackendParam('checkProvince');
        $checkProvince = $checkProvince?true:false;
        $checkProvider = Utils::getBackendParam('checkProvider');
        $checkProvider = $checkProvider?true:false;

        $condition = self::_getCondition($checkSDK,$checkProvince,$checkProvider,$sdk,$stime,$etime,$dateType,$provider,$province,$time);
        
        if( 3 == $dateType ||  4 == $dateType){//时段和月份全搜算总数
            $start = null;
            $length = null;
        }
        $data = SdkPayDay::getIndexData($condition['select'],$condition['where'],$condition['group'], $start,$length);
        $count = SdkPayDay::getIndexCount($condition['where'],$condition['group']);
        $providerName = [
            0 => '-',
            1 => '移动',
            2 => '联通',
            3 => '电信',
        ];
        
        $totalItem = array(
            'Total',
            '-',
            '-',
            '-'
        );
        $totalAllPay = 0;
        $totalSuccPay = 0;
        $tabledata = [];
        foreach($data as $value){
            $item = array();
            if( 3 == $dateType){//时段不显示时间
                array_push($item, '-');
            }else if(4 == $dateType){
                array_push($item, date('Y-m',strtotime($value['date'])));
            }else{
                array_push($item, date('Y-m-d',strtotime($value['date'])));
            }
            if($checkSDK){
                array_push($item, $value['sdk']);
            }else{
                array_push($item, '-');
            }
            if($checkProvider){
                array_push($item, $providerName[$value['provider']]);
            }else{
                array_push($item, '-');
            }
            if($checkProvince){
                array_push($item, $value['provinceName']);
            }else{
                array_push($item, '-');
            }
            $allPay = number_format($value['allPay']/100,2);
            $successPay = number_format($value['successPay']/100,2);
            array_push($item, $allPay);
            array_push($item, $successPay);
            array_push($item, number_format($value['successPay']/$value['allPay'] *100,2).'%');
            $tabledata[] = $item;
            $totalAllPay += $value['allPay'];
            $totalSuccPay += $value['successPay'];
        }
        array_push($totalItem, number_format($totalAllPay/100,2));
        array_push($totalItem, number_format($totalSuccPay/100,2));
        if(0 == $totalAllPay){
            array_push($totalItem, '-');
        }else{
            array_push($totalItem, number_format($totalSuccPay/$totalAllPay *100,2).'%');                
        }    
        array_unshift($tabledata, $totalItem);

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
    private function _getCondition($checkSDK,$checkProvince,$checkProvider,$sdk,$stime,$etime,$dateType,$provider,$province,$time){
        $select = [
            'sdkPayDay.date as date',
            'sdk.name as sdk',
            'sdkPayDay.provider as provider',
            'province.name as provinceName',
            'sum(sdkPayDay.allPay) as allPay',
            'sum(sdkPayDay.successPay) as successPay',
            'sdkPayDay.ratio'
            ];
        
        $where[] = 'and';
        $where[] = [
            '=',
            'sdkPayDay.status',
            1
        ];
        if(Utils::isValid($sdk)){
            $where[] = [
                'like',
                'sdk.name',
                $sdk
            ];
        }
        
        if($provider > 0){
            $where[] = [
                '=',
                'sdkPayDay.provider',
                $provider
            ];
        }
        if(Utils::isValid($province)){
            $where[] = [
                'in',
                'sdkPayDay.prid',
                explode(',', $province)
            ];
        }
        switch ($dateType){
            case 1:// 天
            case 2://小时
            case 3://时段
                if(Utils::isDate($stime)){
                    $where[] = [
                        '>=',
                        'sdkPayDay.date',
                        $stime.' 00:00:00'
                    ];
                }
                if(Utils::isDate($etime)){
                    $where[] = [
                        '<=',
                        'sdkPayDay.date',
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
                    'sdkPayDay.date',
                    $sdate.' 00:00:00'
                ];
                $where[] = [
                    '<=',
                    'sdkPayDay.date',
                    $edate.' 23:59:59'
                ];
                break;
        }
//         if(Utils::isValid($time)){// TODO
//             $where[] = [
//                 'not in',
//                 'HOUR(sdkPayDay.recordTime)',
//                 explode(',', $time)
//             ];
//         }
        
        
        $group = [];
        if(1 == $dateType){//按天统计
            $group[] = 'sdkPayDay.date';
        }
        if($checkSDK){
            $group[] = 'sdkPayDay.sdid';
        }
        if($checkProvider){
            $group[] = 'sdkPayDay.provider';
        }
        if($checkProvince){
            $group[] = 'sdkPayDay.prid';
        }
        
        $condition['select'] = $select;
        $condition['where'] = $where;
        $condition['group'] = $group;
        return $condition;
    }
}
