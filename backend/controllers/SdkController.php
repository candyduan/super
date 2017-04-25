<?php
namespace backend\controllers;

use Yii;
use yii\base\ErrorException;
use yii\helpers\Html;
use yii\web\Controller;
use backend\web\util\MyHtml;
use backend\web\util\MyMail;
use common\models\orm\extend\Sdk;
use common\models\orm\extend\SdkPartner;

/**
 * Test controller
 */
class SdkController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAjaxIndex(){
        $request = Yii::$app->request;
        $start = intval($request->get('start', 0));
        $length = intval($request->get('length', 100));
        $name = $request->get('name');
        $where = [];
        if($name !== '') {
            $where[] = ['signal' => 'like', 'column' =>'name', 'value' =>$name];
        }
       // $sdks = Sdk::findByName($name);
       // $total = Sdk::countByName($name,$start,$length);
        $sdks = Sdk::getIndexData($where, $start,$length);
        $count = Sdk::getIndexCount($where);
        $tabledata = [];
        foreach($sdks as $value){
            $limits = [
                0 => '无限制',
                1 => '白名单',
                2 =>  '黑名单'
            ];
            $limit = isset($limits[$value['limit']]) ? $limits[$value['limit']] : '';
            list($blue,$green,$black,$purple) = self::_getStatusColor($value['status']);
            $tabledata[] = [
                MyHtml::aElement('javascript:void(0);' ,'modifySdk', $value['sdid'],'[' .++$start.'] '.$value['name']),
                MyHtml::aElement('javascript:void(0);' ,'setLimit', $value['sdid'], $limit),
                MyHtml::iElement('glyphicon glyphicon-globe','setProvince',$value['sdid']),
                MyHtml::iElement('glyphicon glyphicon-time','setTime',$value['sdid']),
                MyHtml::iElements('setStatus',$value['sdid'], $blue,$green,$black,$purple)
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


    public function actionAddSdk() {
        $resultState = 0;
        $name = Yii::$app->request->post('sdk_name');
        if ($name && Sdk::sdkNameNotExist($name)) {
            $transaction =  Sdk::getDb()->beginTransaction();
            try {
                $resultState = $this->_addSdk() == true ? 1 : 0;
                $transaction->commit();
            } catch (ErrorException $e) {
                $resultState = false;
                $transaction->rollBack();
                MyMail::sendMail($e->getMessage(), 'Error From add Sdk');
            }
        }else{
            $resultState = -1;
        }

        echo json_encode($resultState);
        exit;
    }

    public function actionModifySdk() {
        $resultState = 0;
        $name = Yii::$app->request->post('sdk_sdid');
        if ($name) {
            $transaction =  Sdk::getDb()->beginTransaction();
            try {
                $resultState = $this->_modifySdk() == true ? 1 : 0;
                $transaction->commit();
            } catch (ErrorException $e) {
                $resultState = false;
                $transaction->rollBack();
                MyMail::sendMail($e->getMessage(), 'Error From modify Sdk');
            }
        }

        echo json_encode($resultState);
        exit;
    }

    public function actionGetSdk() {
        $data = [];
        $sdid = intval(Yii::$app->request->get('sdid'));
        if ($sdid > 0) {
            $sdid = intval(Yii::$app->request->get('sdid'));
                $data = Sdk::findByPk($sdid)->toArray();
                if(isset($data['spid'])){
                    $data['partner'] = SdkPartner::getNameByPk($sdid);
                }
        }
        echo json_encode($data);
        exit;
    }

    private function _addSdk(){
        $resultState = false;
        $post = Yii::$app->request->post();
        $spid = self::_getSpid();//有就返回spid  没有就新增一条返回spid
        if(!empty($spid)) {
            $sdkmodel = new Sdk();
            $sdkmodel->spid = $spid;
            $sdkmodel->name = trim($post['sdk_name']);
            $sdkmodel->updateTime = time();
            $sdkmodel->recordTime = time();
            $sdkmodel->proportion = intval($post['sdk_proportion']);
            $sdkmodel->optimization = intval($post['sdk_optimization']);
            $sdkmodel->remark = trim($post['sdk_remark']);
            $sdkmodel->syn = trim($post['sdk_syn']);
            $sdkmodel->status = 3;
            $sdkmodel->limit = 0;
            $resultState = $sdkmodel->save();
        }

        return $resultState;
    }

    private function _modifySdk(){
        $resultState = false;
        $post = Yii::$app->request->post();
        $sdid = isset($post['sdk_sdid']) ? $post['sdk_sdid'] : 0;
        if(!empty($sdid)) {
            $sdkmodel = Sdk::findByPk($sdid);
            if($sdkmodel) {
                $sdkmodel->updateTime = time();
                $sdkmodel->proportion = intval($post['sdk_proportion']);
                $sdkmodel->optimization = intval($post['sdk_optimization']);
                $sdkmodel->remark = trim($post['sdk_remark']);
                $sdkmodel->syn = trim($post['sdk_syn']);
                $resultState = $sdkmodel->save();
            }
        }

        return $resultState;
    }

    private function _getStatusColor($status){
        $arr = ['grey','grey','grey','grey'];
        switch ($status){
            case 0: $arr[2] = 'black'; break; //无效
            case 1: $arr[1] = 'green'; break; //运行
            case 2: $arr[3] = 'purple'; break; //测试
            case 3: $arr[0] = 'blue'; break; //暂停
        }
        return $arr;
    }

    private function _getSpid(){
        $spid = 0;
        $request = Yii::$app->request;
        $partner = $request->post('sdk_partner','');
        if(!empty($partner)){
            $partnerModel = SdkPartner::findByName(trim($partner));
            if(!empty($partnerModel)){
                $spid = $partnerModel->spid;
            }else{
                $spid = self::_addPartner($partner);
            }
        }

        return $spid;
    }

    private function _addPartner($partner){
        $partnerModel = New SdkPartner();
        $partnerModel->name = trim($partner);
        $partnerModel->updateTime = time();
        $partnerModel->recordTime = time();
        $partnerModel->status = 1;
        $resultState = $partnerModel->save();
        return $resultState == true ? $partnerModel->spid : 0;
    }

}
