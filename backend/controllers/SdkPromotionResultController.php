<?php
namespace backend\controllers;

use common\models\orm\extend\CampaignPackage;
use common\models\orm\extend\Campaign;
use common\models\orm\extend\SdkPromotionResult;
use Yii;
use yii\base\ErrorException;
use yii\helpers\Html;
use yii\web\Controller;
use backend\web\util\MyHtml;
use common\models\orm\extend\App;
use common\models\orm\extend\Admin;
use common\models\orm\extend\Partner;
use common\library\Utils;
use yii\filters\AccessControl;
use backend\web\util\MyMail;
use common\library\BController;
/**
 * SdkPromotionResultController
 */
class SdkPromotionResultController extends BController
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
        return $this->render('index');
    }

    public function actionAjaxIndex(){
        $request = Yii::$app->request;
        $start = intval($request->get('start', 0));
        $length = intval($request->get('length', 100));
        $condition = self::_getCondition();
        $data = SdkPromotionResult::getIndexData($condition, $start,$length);
        $count = SdkPromotionResult::getIndexCount($condition);
        $tabledata = [];
        foreach($data as $value){
            $campaignPackage = CampaignPackage::findByPk($value['cpid']);
            if($campaignPackage) {
                $partner = Partner::getNameById($campaignPackage['partner']);
                //$media = Partner::getNameById($campaignPackage['media']);
                $app = App::getNameById($campaignPackage['app']);
                $campaign = Campaign::getNameById($campaignPackage['campaign']);
                //$name = $partner.'_'.$media;
                $status = MyHtml::iElement('glyphicon-ok-sign glyphicon green','','');
                if($value['status'] == 0){
                    $status = MyHtml::aElement('javascript:void(0);','modifyStatus',$value['sprid'],'确认提交') . MyHtml::br();
                    $status .= MyHtml::aElement('javascript:void(0);','deleteRecord',$value['sprid'],'删除预览');
                }
                $tabledata[] = [
                    $value['date'],
                    $partner,
                    $app,
                    $campaign,
                    $campaignPackage['mediaSign'],
                    $value['price'] / 100,
                    $value['count'],
                    $value['amount'],
                    $status
                ];
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

    public function actionUploadCsv() {//0 - 日期 1-活动 2-渠道标识 3-成果数
        $resultState = 0;
        ini_set("auto_detect_line_endings", true);
        //setlocale(LC_ALL, 'zh_CN');
        $handle = fopen($_FILES['result_file']['tmp_name'],'r');
        if($handle) {
            while (!feof($handle)) {
                $data = fgetcsv($handle,0,';');//
                if(!isset($data[1])){//分隔符为逗号的状态
                    $data =  explode(',',$data[0]);
                }

                if(self::_characet($data[0]) !== '日期'  && is_numeric($data[3])){
                    //获取cpid--------
                    $cpid = '';
                    if(is_numeric($data[1])) {
                        $caid = $data[1];
                    }else {
                        $caid = Campaign::getIdByName(self::_characet($data[1]));
                    }
                    if($caid !== '') {
                        $cpid = CampaignPackage::getIdByCampaignMedaiSign($caid, $data[2]);
                    }
                    //----------------
                    if($cpid !== '') {
                        $date =  $date = date('Y-m-d', strtotime($data[0]));
                        $count = $data[3];
                        $mrate = CampaignPackage::getMrateById($cpid);
                        $price = '';
                        if(is_numeric($count) && is_numeric($mrate)){
                            $price = $mrate * intval($count) * 100;
                        }

                        if(is_numeric($price)){
                            $model = new SdkPromotionResult();
                            $model->cpid = $cpid;
                            $model->date = $date;
                            $model->count = $count;
                            $model->price = $price;
                            $model->status = 0;
                            $resultState += $model->save() == true ? 1 : 0;
                        }
                    }
                }else{
                    continue;
                }
            }
        }

        echo json_encode($resultState);
        exit;
    }

    public function actionModifyStatus(){
        $sprid = Utils::getBParam('sprid');
        $resultState = 0;
        if(isset($sprid)){
            $transaction =  SdkPromotionResult::getDb()->beginTransaction();
            try {
                $model = SdkPromotionResult::findByPk($sprid);
                if($model){
                    $model->status = 1;
                    $resultState = $model->save() == true  ? 1 :0;
                }
                $transaction->commit();
            } catch (ErrorException $e) {
                $resultState = 0;
                $transaction->rollBack();
                MyMail::sendMail($e->getMessage(), 'Error From modify Sdkpromition status');
            }
        }
        echo json_encode($resultState);
        exit;
    }

    public function actionDeleteRecord(){
        $sprid = Utils::getBParam('sprid');
        $resultState = 0;
        if(isset($sprid)){
            $transaction =  SdkPromotionResult::getDb()->beginTransaction();
            try {
                $resultState = SdkPromotionResult::findByPk($sprid)->delete() == true ? 1: 0 ;
                $transaction->commit();
            } catch (ErrorException $e) {
                $resultState = 0;
                $transaction->rollBack();
                MyMail::sendMail($e->getMessage(), 'Error From delete Sdkpromition status');
            }
        }
        echo json_encode($resultState);
        exit;
    }

    private function _getCondition(){
        $condition[] = 'and';
        $condition[] = [
            'in',
            'status',
            [0,1]
        ];

        return $condition;
    }

    private  function _characet($data){
        if( !empty($data) ){
            $fileType = mb_detect_encoding($data , array('UTF-8','GBK','LATIN1','BIG5')) ;
            if( $fileType != 'UTF-8'){
                $data = mb_convert_encoding($data ,'utf-8' , $fileType);
            }
        }
        return $data;
    }
}
