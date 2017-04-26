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
use common\models\orm\extend\SdkProvinceLimit;
use common\models\orm\extend\Province;
use common\models\orm\extend\SdkProvinceTimeLimit;
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
                MyHtml::iElement('glyphicon glyphicon-globe','setProvince',$value['sdid'] . ',1'),
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

    public function actionGetProvinceLimit() { //根据sdk 和 运营商拿到省份 1 移动 2 联通 3 电信
        $provider = Yii::$app->request->get('provider');
        $sdid = Yii::$app->request->get('sdid');
        $allprovinces = Province::getAllProvinces();
        $limitprids = SdkProvinceLimit::getlimitPrids($sdid, $provider);

        $limitdata = [] ; $unlimitdata = [];
        foreach($allprovinces as $prid => $name) {
            $checkbox = '<input type="checkbox" name="prid" value="' . $prid . '" onclick="closeBatch(this, \'all_prids\');"/>';
            $province = isset($allprovinces[$prid]) ? $allprovinces[$prid] : '';
            //处理时间开始
            $timelimit = MyHtml::aElement('javascript:void(0);', 'setProTime', $prid, '------');
            $timelimit_arr = SdkProvinceTimeLimit::getTimtLimitsBySdidProviderPrid($sdid, $provider, $prid);
            if (!empty($timelimit_arr)) {
                $timelimit_arr2 = [];
                foreach ($timelimit_arr as $v) {
                    $timelimit_arr2[] = $v['stime'] . ':00' . '---' . $v['etime'] . ':00';
                }
                $timelimit = MyHtml::aElement('javascript:void(0);', 'setProTime', $prid, implode('<br/>', $timelimit_arr2));
            }
            //开通的放在前面
            if (!in_array($prid, $limitprids)) {
                $unlimitdata[] = [
                    'checkbox' => $checkbox,
                    'province' => $province,//开通的 要去 停止
                    'status' => MyHtml::doubleiElements('setDoubleStatus', '' ,$prid . ', 0 ', '',' grey ', ' green '),
                    'timelimit' => $timelimit
                ];
            } else { //屏蔽的放后面
                $limitdata[] = [
                    'checkbox' =>$checkbox,
                    'province' =>  $province,//停止的要去开通
                    'status' => MyHtml::doubleiElements('', 'setDoubleStatus', '', $prid . ',1 ',' blue ', ' grey '),
                    'timelimit' => $timelimit
                ];
            }
        }
             echo json_encode(array_merge($unlimitdata, $limitdata));
        exit;
    }

      /*  if($sdid && $provider)
        {
            //屏蔽的 存在表里并且status = 0

            $data = [];
            foreach ($provincelimit as $key => $value) {
                //处理时间限制数据
                $timelimits = [];
                $timelimit = MyHtml::aElement('javascript:void(0);', 'setProTime', $value['splid'],'------');
               // $provincetimelimit = SdkProvinceTimeLimit::getTimtLimitsBySplid($value['splid']);
                if(!empty($provincetimelimit)){
                    foreach($provincetimelimit as $v){
                        $timelimits[] = $v['stime'] .':00' . '---' .$v['etime'] .':00';
                    }
                    $timelimit = MyHtml::aElement('javascript:void(0);', 'setProTime', $value['splid'], implode('<br/>' ,$timelimits));
                }
                //处理按钮颜色
                list($blue,$green) = self::_getDoubleStatus($value['status']);
                $data[$key]['checkbox'] =  '<input type="checkbox" name="splid" value="' . $value['splid'] . '" onclick="closeBatch(this, \'all_splids\');"/>';
                $data[$key]['province'] =   Province::getProvinceById($value['prid']);
                $data[$key]['status'] =   MyHtml::doubleElements('setDoubleStatus',$value['splid'], $blue,$green);
                $data[$key]['timelimit'] =   $timelimit;
            }

            //没有屏蔽的 不存在表里 或者 states = 1
        }*/

    public function actionModifySdk() {
        $resultState = 0;
        $name = Yii::$app->request->post('sdk_sdid');
        if ($name) {
            $transaction =  Sdk::getDb()->beginTransaction();
            try {
                $resultState = $this->_modifySdk() == true ? 1 : 0;
                $transaction->commit();
            } catch (ErrorException $e) {
                $resultState = 0;
                $transaction->rollBack();
                MyMail::sendMail($e->getMessage(), 'Error From modify Sdk');
            }
        }

        echo json_encode($resultState);
        exit;
    }

    public function actionModifyProvinceLimit() {
        $resultState = 0;
        $prid = Yii::$app->request->get('prid');
        $sdid = Yii::$app->request->get('sdid');
        $provider = Yii::$app->request->get('provider');
        $status = Yii::$app->request->get('status');
        if (isset($prid) && isset($sdid) && isset($provider)) {
            $transaction =  SdkProvinceLimit::getDb()->beginTransaction();
            try {
                SdkProvinceLimit::deleteByPridSdidProvider($prid,$sdid,$provider);
                $resultState = $this->_addProvinceLimit($sdid,$prid,$provider, $status);
                $transaction->commit();
            } catch (ErrorException $e) {
                $resultState = 0;
                $transaction->rollBack();
                MyMail::sendMail($e->getMessage(), 'Error From modify province limit');
            }
        }

        echo json_encode($resultState);
        exit;
    }

    public function actionBatchModifyProvinceLimit() {
        $resultState = 0;
        $prids = Yii::$app->request->get('prids');
        $sdid = Yii::$app->request->get('sdid');
        $provider = Yii::$app->request->get('provider');
        $status = Yii::$app->request->get('status');
        if (isset($prids) && isset($sdid) && isset($provider)) {
            foreach($prids as $prid) {
                $transaction = SdkProvinceLimit::getDb()->beginTransaction();
                try {
                    SdkProvinceLimit::deleteByPridSdidProvider($prid, $sdid, $provider);
                    $resultState += $this->_addProvinceLimit($sdid, $prid, $provider, $status);
                    $transaction->commit();
                } catch (ErrorException $e) {
                    $resultState = 0;
                    $transaction->rollBack();
                    MyMail::sendMail($e->getMessage(), 'Error From modify province limit');
                }
            }
        }

        echo json_encode($resultState);
        exit;
    }

    public function actionGetProvinceTimeLimit(){
        $provider = Yii::$app->request->get('provider');
        $sdid = Yii::$app->request->get('sdid');
        $prid = Yii::$app->request->get('prid');
        $data = [];
        if(!empty($provider) && $sdid && $prid){
            $stimeetime = SdkProvinceTimeLimit::getTimtLimitsBySdidProviderPrid($sdid,$provider,$prid);
            if(!empty($stimeetime)){ //有限制
                for($i = 0 ;$i < 24 ;$i++){
                    $unlimit = true;
                    foreach ($stimeetime as $value) {
                        if ($i < intval($value['stime']) || $i >= intval($value['etime'])){
                        }else{
                            $unlimit = false;
                            break;
                        }
                    }
                    if($unlimit){
                        $data[] = $i;
                    }
                }
            }else{
                $data = range(0,23);
            }
        }
        echo json_encode($data);
        exit;
    }

    private function _addProvinceLimit($sdid,$prid,$provider, $status){
        $model = new SdkProvinceLimit();
        $model->sdid= $sdid;
        $model->prid=$prid;
        $model->provider =$provider;
        $model->updateTime = time();
        $model->recordTime =time();
        $model->status = $status;
        $result = $model->save();
        $resultState = ($result == true) ? 1 : 0;
        return $resultState;
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

    private function _getStatusColor($status){ //4种按钮颜色判断
        $arr = ['grey','grey','grey','grey'];
        switch ($status){
            case 0: $arr[2] = 'black'; break; //无效
            case 1: $arr[1] = 'green'; break; //运行
            case 2: $arr[3] = 'purple'; break; //测试
            case 3: $arr[0] = 'blue'; break; //暂停
        }
        return $arr;
    }

    private function _getDoubleStatus($status){ //2种按钮颜色判断
        $arr = ['grey','grey'];
        switch ($status){
            case 0: $arr[0] = 'blue'; break; //停止
            case 1: $arr[1] = 'green'; break; //开通
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
