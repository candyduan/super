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
use common\models\orm\extend\SdkPayTransaction;
use common\models\orm\extend\SdkPackagePayDay;
use common\models\orm\extend\PlayerCount;
use common\models\orm\extend\PayAction;
use common\library\Constant;
use common\models\orm\extend\Province;
use common\models\orm\extend\SdkPlayer;
use yii\db\Query;
/**
 * SdkPay controller
 */
class PackagePayController extends BController
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
        $apps = App::fetchAllBelongSdkArr();
        $channels = CampaignPackage::fetchAllPartnerBelongSdkArr();
        return $this->render('index', ['apps' =>$apps,'channels' =>$channels]);
    }
    
    public function actionAjaxIndex(){
        $start = Utils::getBackendParam('start',0);
        $length = Utils::getBackendParam('length',100);
        
        $partner = Utils::getBackendParam('partner','');
        $app = Utils::getBackendParam('app','');
        $channel = Utils::getBackendParam('channel','');
        
        $stime = Utils::getBackendParam('startDate','');
        $etime = Utils::getBackendParam('endDate','');
        
        $dateType = Utils::getBackendParam('dateType',3);
        
        $checkCP = Utils::getBackendParam('checkCP');
        $checkCP = $checkCP?true:false;
        $checkAPP = Utils::getBackendParam('checkAPP');
        $checkAPP = $checkAPP?true:false;
        $checkCmp = Utils::getBackendParam('checkCmp');
        $checkCmp = $checkCmp?true:false;
        $checkM = Utils::getBackendParam('checkM');
        $checkM = $checkM?true:false;

        if( 3 == $dateType ||  4 == $dateType){//时段和月份全搜算总数
            $start = null;
            $length = null;
        }
        
        $condition = self::_getCondition($checkCP,$checkAPP,$checkCmp,$checkM,$partner,$app,$channel,$stime,$etime,$dateType);
        $data = SdkPackagePayDay::getIndexData($condition['select'],$condition['where'],$condition['group'], $start,$length);
        $count = SdkPackagePayDay::getIndexCount($condition['where'],$condition['group']);
        
        $tabledata = [];
        foreach($data as $value){
            $item = array();
            if( 3 == $dateType){//时段不显示时间
                array_push($item, '-');
            }else if(4 == $dateType){//月份显示月
                array_push($item, date('Y-m',strtotime($value['date'])));
            }else{
                array_push($item, date('Y-m-d',strtotime($value['date'])));
            }
            if($checkCP){
                array_push($item, '【'.$value['pid'].'】'.$value['partner']);
            }else{
                array_push($item, '-');
            }
            if($checkAPP){
                array_push($item, '【'.$value['aid'].'】'.$value['app']);
            }else{
                array_push($item, '-');
            }
            if($checkCmp){
                array_push($item, '【'.$value['cid'].'】'.$value['cmp']);
            }else{
                array_push($item, '-');
            }
            if($checkM){
                array_push($item, '【'.$value['chid'].'】'.$value['m']);
            }else{
                array_push($item, '-');
            }
            
            $usersData = self::_getUsersByDate($dateType,$stime,$etime,$checkCP,$checkAPP,$checkCmp,$checkM,$value['date'],$value['pid'],$value['aid'],$value['cid'],$value['mediaSign']);
            $newUser = Utils::getValuesFromArray($usersData, 'newUsers',0);
            $actUser = Utils::getValuesFromArray($usersData, 'actUsers',0);
            $users = Utils::getValuesFromArray($usersData, 'payUsers',0);
            array_push($item, $newUser);
            array_push($item, $actUser);
            array_push($item, $users);
            
            array_push($item, number_format($value['successPay'],0));
            array_push($item, number_format($value['cp'],0));
            if($newUser <= 0){
                array_push($item, '-');
            }else{
                array_push($item, number_format($value['successPay']/$newUser,2));
            }
            
            if($users <= 0){
                array_push($item, '-');
            }else{
                array_push($item, number_format($value['successPay']/$users,2));
            }
            
            if($actUser <= 0){
                array_push($item, '-');
            }else{
                array_push($item, number_format($users/$actUser*100,2).'%');
            }
            array_push($item, number_format($value['income'],2));
            array_push($item, number_format($value['payCp'],2));
            array_push($item, number_format($value['payM'],2));
            array_push($item, number_format($value['profit'],2));
            if(0 == $value['successPay']){
                array_push($item, '-');
            }else{
                array_push($item, number_format($value['profit']/$value['successPay']*100,2).'%');
            }
            
            $tabledata[] = $item;
        }

        $data = [
            'searchData' => [

            ],
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'tableData' => $tabledata,
        ];
        if(Utils::isAjaxRequest()){
            Utils::jsonOut($data);
            exit;
        }else{
            return $tabledata;
        }
    }
    private function _getCondition($checkCP,$checkAPP,$checkCmp,$checkM,$partner,$app,$channel,$stime,$etime,$dateType){
        $select = [
            'campaignPackage.id as cpid',
            'campaignPackage.mediaSign as mediaSign',
            'sdkPackagePayDay.date as date',
            'partner.id as pid',
            'partner.name as partner',
            'app.id as aid',
            'app.name as app',
            'campaign.id as cid',
            'campaign.name as cmp',
            'channel.id as chid',
            'channel.name as m',
//             'sum(sdkPackagePayDay.newUsers) as newUsers',
//             'sum(sdkPackagePayDay.actUsers) as actUsers',
//             'sum(sdkPackagePayDay.users) as users',
            'sum(sdkPackagePayDay.successPay) as successPay',
            'sum(sdkPackagePayDay.cp) as cp',
            'sum(sdkPackagePayDay.income) as income',
            'sum(sdkPackagePayDay.payCp) as payCp',
            'sum(sdkPackagePayDay.payM) as payM',
            'sum(sdkPackagePayDay.profit) as profit',
            ];
        
        $where[] = 'and';
        $where[] = [
            '=',
            'sdkPackagePayDay.status',
            1
        ];
        if(Utils::isValid($partner)){
            $where[] = [
                'like',
                'partner.name',
                $partner
            ];
        }
        if($app > 0){
            $where[] = [
                '=',
                'app.id',
                $app
            ];
        }
        if($channel > 0){
            $where[] = [
                '=',
                'campaignPackage.media',
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
        if($checkCP){
            $group[] = 'campaignPackage.partner';
        }
        if($checkAPP){
            $group[] = 'campaignPackage.app';
        }
        if($checkCmp){
            $group[] = 'campaignPackage.id';
        }
        if($checkM){
            $group[] = 'campaignPackage.media';
        }
        $condition['select'] = $select;
        $condition['where'] = $where;
        $condition['group'] = $group;
        return $condition;
    }

    private function _getUsersByDate($dateType,$stime,$etime,$checkCP,$checkAPP,$checkCmp,$checkM,$date,$pid,$aid,$cid,$mediaSign){
        $res = array();
        
        $select = [
            'count( distinct sdkPlayer.imsi) as users'  
        ];
        $where = [];
        $where[] = 'and';
        $where[] = [
            '=',
            'sdkPlayer.status',
            1
        ];
        
        if( 3 == $dateType){//时段
            $where[] = [
                '>=',
                'sdkPlayer.date',
                $stime.' 00:00:00'
            ];
            $where[] = [
                '<=',
                'sdkPlayer.date',
                $etime.' 00:00:00'
            ];
        }else if(4 == $dateType){//月份
            $sdate = date('Y-m-01',strtotime($date));
            $edate = date("Y-m-d",strtotime("$sdate 1 month -1 day"));
            $where[] = [
                '>=',
                'sdkPlayer.date',
                $sdate.' 00:00:00'
            ];
            $where[] = [
                '<=',
                'sdkPlayer.date',
                $edate.' 00:00:00'
            ];
        }else{//天
            $where[] = [
                '=',
                'sdkPlayer.date',
                $date.' 00:00:00'
            ];
        }
        
        if($checkCP){
            $where[] = [
            '=',
            'campaignPackage.partner',
            $pid
            ];
        }
        if($checkAPP){
            $where[] = [
                '=',
                'campaignPackage.app',
                $aid
            ];
        }
        if($checkCmp){
            $where[] = [
                '=',
                'campaignPackage.campaign',
                $cid
            ];
        }
        if($checkM){
            $where[] = [
                '=',
                'campaignPackage.mediaSign',
                $mediaSign
            ];
        }
        //活跃用户
        $actUsers = SdkPlayer::getCountByCondition($select,$where);
        $res['actUsers'] = $actUsers['users'];
        
        //激活用户
        $where[] = [
            '=',
            'sdkPlayer.isNew',
            1
        ];
        $newUsers = SdkPlayer::getCountByCondition($select,$where);
        $res['newUsers'] = $newUsers['users'];
        
        //支付用户
        $select = [
            'count(distinct sdkPayTransaction.scid) as users'
        ];
        
        $where = [];
        $where[] = 'and';
        
        if( 3 == $dateType){//时段
            $where[] = [
                '>=',
                'sdkPayTransaction.recordTime',
                $stime.' 00:00:00'
            ];
            $where[] = [
                '<=',
                'sdkPayTransaction.recordTime',
                $etime.' 23:59:59'
            ];
        }else if(4 == $dateType){//月份
            $sdate = date('Y-m-01',strtotime($date));
            $edate = date("Y-m-d",strtotime("$sdate 1 month -1 day"));
            $where[] = [
                '>=',
                'sdkPayTransaction.recordTime',
                $sdate.' 00:00:00'
            ];
            $where[] = [
                '<=',
                'sdkPayTransaction.recordTime',
                $edate.' 23:59:59'
            ];
        }else{//天
            $where[] = [
                '>=',
                'sdkPayTransaction.recordTime',
                date('Y-m-01',strtotime($date)).' 00:00:00'
            ];
            $where[] = [
                '<=',
                'sdkPayTransaction.recordTime',
                date('Y-m-01',strtotime($date)).' 23:59:59'
            ];
        }
        
        if($checkCP){
            $where[] = [
                '=',
                'campaignPackage.partner',
                $pid
            ];
        }
        if($checkAPP){
            $where[] = [
                '=',
                'campaignPackage.app',
                $aid
            ];
        }
        if($checkCmp){
            $where[] = [
                '=',
                'campaignPackage.campaign',
                $cid
            ];
        }
        if($checkM){
            $where[] = [
                '=',
                'campaignPackage.mediaSign',
                $mediaSign
            ];
        }
        
        $payUsers = SdkPayTransaction::getCountByCondition($select,$where);
        $res['payUsers'] = $payUsers['users'];
        return $res;
    }
     public function actionAnalysis(){
     	return $this->render('analysis-view');
     }

     /**
      * 根据内容商查询应用
      */
     public function actionGetAppWithPartner() {
     	$partner = Utils::getBackendParam('partner');
     	if(is_numeric($partner) && $partner){
     		$list = App::findByPartner($partner);
     	}else{
     		$list = App::findAllToArray();
     	}
     	if($list){
     		$out['list'] = $list;
     		$out['resultCode']  = Constant::RESULT_CODE_SUCC;
     		$out['msg']         = Constant::RESULT_MSG_SUCC;
     	}else{
     		$out['resultCode']  = Constant::RESULT_CODE_NONE;
     		$out['msg']         =  Constant::RESULT_MSG_NONE;
     	}
     	Utils::jsonOut($out);
     }
  
     /**
      * 按条件查询活动
      */
     public function actionGetCampaignWithPartnerAndApp() {
     	$partner = Utils::getBackendParam('partner');
     	$app = Utils::getBackendParam('app');
     	$list = Campaign::findAllByPartnerAndApp($partner,$app);
     	if($list){
     		$out['list'] = $list;
     		$out['resultCode']  = Constant::RESULT_CODE_SUCC;
     		$out['msg']         = Constant::RESULT_MSG_SUCC;
     	}else{
     		$out['resultCode']  = Constant::RESULT_CODE_NONE;
     		$out['msg']         =  Constant::RESULT_MSG_NONE;
     	}
     	Utils::jsonOut($out);
     }
     
     /**
      * 获取渠道
      */
     public function actionGetAppCampaignMediaSdk(){
     	$app = App::findAllToArray();
     	$campaign = Campaign::findAllByPartnerAndApp();
     	$media = Partner::findAllMedia();
     	$sdk	 =  Sdk::findAllSdk();
     	if($media && $sdk && $app && $campaign){
     		$out['app'] = $app;
     		$out['campaign'] = $campaign;
     		$out['media'] = $media;
     		$out['sdk'] = $sdk;
     		$out['resultCode']  = Constant::RESULT_CODE_SUCC;
     		$out['msg']         = Constant::RESULT_MSG_SUCC;
     	}else{
     		$out['resultCode']  = Constant::RESULT_CODE_NONE;
     		$out['msg']         =  Constant::RESULT_MSG_NONE;
     	}
     	Utils::jsonOut($out);
     }
     
     public function actionAnalysisAjaxIndex(){
     	$start = Utils::getBackendParam('start',0);
     	$length = Utils::getBackendParam('length',100);
     	
     	$partner = Utils::getBackendParam('partner');
     	$app = Utils::getBackendParam('app');
     	$campaign = Utils::getBackendParam('campaign');
     	$media = Utils::getBackendParam('media');
     	$sdk = Utils::getBackendParam('sdk');
     	
     	$stime = Utils::getBackendParam('startDate','');
     	$etime = Utils::getBackendParam('endDate','');
     	
     	$checkCp = Utils::getBackendParam('checkPartner') ? true : false;
     	$checkApp = Utils::getBackendParam('checkApp') ? true : false;
     	$checkCmp = Utils::getBackendParam('checkCampaginPackage') ? true : false;
     	$checkM = Utils::getBackendParam('checkMedia') ? true : false;
     	$checkSdk = Utils::getBackendParam('checkSdk') ? true : false;
     	$checkProvince = Utils::getBackendParam('checkProvince') ? true : false;
     	$checkProvider = Utils::getBackendParam('checkProvider') ? true : false;
     	
     	$dateType = Utils::getBackendParam('dateType',3);
     	$provider = Utils::getBackendParam('provider',0);
     	$province = Utils::getBackendParam('province','');
     	
     	$condition = self::_getAnalysisCondition($checkCp,$checkApp,$checkCmp,$checkM,$checkSdk,$checkProvince,$checkProvider,$partner,$app,$campaign,$media,$sdk,$stime,$etime,$dateType,$provider,$province);
     	$data = SdkPackagePayDay::getAnalysisData($condition['select'],$condition['where'],$condition['group'], $start,$length);
     	$count = SdkPackagePayDay::getIndexCount($condition['where'],$condition['group']);
     	$tabledata = [];
     	foreach($data as $value){
     		$item = array();
     		if( 3 == $dateType){//时段不显示时间
     			array_push($item, '-');
     		}else if(4 == $dateType){//月份显示月
     			array_push($item, date('Y-m',strtotime($value['date'])));
     		}else{
     			array_push($item, date('Y-m-d',strtotime($value['date'])));
     		}
     		if($checkCp){
     			array_push($item, '【'.$value['partner'].'】' . Partner::getNameById($value['partner']));
     		}else{
     			array_push($item, '-');
     		}
     		if($checkApp){
     			array_push($item, '【'.$value['app'].'】' .  App::getNameById($value['app']));
     		}else{
     			array_push($item, '-');
     		}
     		if($checkCmp){
     			array_push($item, '【'.$value['campaign'].'】' .  Campaign::getNameById($value['campaign']));
     		}else{
     			array_push($item, '-');
     		}
     		if($checkM){
     			array_push($item, '【'.$value['media'].'】' . Partner::getNameById($value['media']));
     		}else{
     			array_push($item, '-');
     		}
     		//渠道标识mediaSign
     		array_push($item, $value['mediaSign']);
     		if($checkSdk){
     			array_push($item, Sdk::getNameById($value['sdk']));
     		}else{
     			array_push($item, '-');
     		}
     		if($checkProvince){
     			array_push($item, Province::getNameById($value['province']));
     		}else{
     			array_push($item, '-');
     		}
     		if($checkProvider){
     			array_push($item, $value['provider'] == 1 ? '移动' : ($value['provider'] == 2 ? '联通' : '电信')) ;
     		}else{
     			array_push($item, '-');
     		}
     		
     	
     		array_push($item, $value['allPay']);
     		array_push($item, number_format($value['successPay'],0));
     		array_push($item, number_format($value['income'],0));
     		if(0 == $value['allPay']){
     			array_push($item, '-');
     		}else{
     			array_push($item, number_format($value['successPay']/$value['allPay']*100,0).'%');
     		}
     		$tabledata[] = $item;
     	}
     	
     	$data = [
     			'searchData' => [
     			],
     			'recordsTotal' => $count,
     			'recordsFiltered' => $count,
     			'tableData' => $tabledata,
     	];
     	if(Utils::isAjaxRequest()){
     		Utils::jsonOut($data);
     	}else{
     		return $tabledata;
     	}
     }
     
     private function _getAnalysisCondition($checkCP,$checkAPP,$checkCmp,$checkM,$checkSdk,$checkProvince,$checkProvider,$partner,$app,$campaign,$media,$sdk,$stime,$etime,$dateType,$provider,$province){
     	$select = [
     			'campaignPackage.partner as partner',
     			'campaignPackage.app as app',
     			'campaignPackage.campaign as campaign',
     			'campaignPackage.media as media',
     			'campaignPackage.mediaSign as mediaSign',
     			'sdkPackagePayDay.sdid as sdk',
     			'sdkPackagePayDay.prid as province',
     			'sdkPackagePayDay.provider as provider',
     			'sdkPackagePayDay.date as date',
     			'sum(sdkPackagePayDay.allPay) as allPay',
     			'sum(sdkPackagePayDay.successPay) as successPay',
     			'sum(sdkPackagePayDay.income) as income',
     	];
     	
     	$where[] = 'and';
     	$where[] = [
     			'=',
     			'sdkPackagePayDay.status',
     			1
     	];
     	if(Utils::isValid($partner)){
     		$where[] = [
     				'=',
     				'campaignPackage.partner',
     				$partner
     		];
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
     	if($media > 0){
     		$where[] = [
     				'=',
     				'campaignPackage.media',
     				$media
     		];
     	}
     	if($sdk > 0){
     		$where[] = [
     				'=',
     				'sdkPackagePayDay.sdid',
     				$sdk
     		];
     	}
     	if($provider > 0){
     		$where[] = [
     				'=',
     				'sdkPackagePayDay.provider',
     				$provider
     		];
     	}
     	if(Utils::isValid($province)){
     		$where[] = [
     				'in',
     				'sdkPackagePayDay.prid',
     				explode(',', $province)
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
     	if($checkCP){
     		$group[] = 'campaignPackage.partner';
     	}
     	if($checkAPP){
     		$group[] = 'campaignPackage.app';
     	}
     	if($checkCmp){
     		$group[] = 'campaignPackage.id';
     	}
     	if($checkM){
     		$group[] = 'campaignPackage.media';
     	}
     	if($checkProvince){
     		$group[] = 'sdkPackagePayDay.prid';
     	}
     	if($checkProvider){
     		$group[] = 'sdkPackagePayDay.provider';
     	}
     	$condition['select'] = $select;
     	$condition['where'] = $where;
     	$condition['group'] = $group;
     	return $condition;
     }
     
     /**
      * 渠道计费分析报表下载
      */
     public function actionAnalysisDownload(){
     	$headerArr = ['日期', '内容商' ,'应用', '活动', '渠道', '渠道标识', 'SDK', '省份', '运营商', '请求总金额', '信息费', '收入', '转化率'];
     	$datas = self::actionAnalysisAjaxIndex();
     	echo Utils::DownloadForm($headerArr, $datas, '融合SDK渠道计费分析表');
     }
     /**
      */
     public function actionIndexDownload(){
         $headerArr = ['日期', '内容商' ,'应用', '活动包', '渠道', '激活数', '活跃数', '支付用户', '信息费', 'CP费', 'ARPU', '付ARPU','付费率','收入','CP成本','M成本','毛利','毛利率'];
         $datas = self::actionAjaxIndex();
         echo Utils::DownloadForm($headerArr, $datas, '融合SDK渠道计费收益表');
     }

}