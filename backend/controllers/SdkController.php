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
use common\models\orm\extend\SdkTimeLimit;
use common\models\orm\extend\Campaign;
use common\models\orm\extend\SdkCampaignLimit;
use backend\library\sdk\SdkUtils;
/**
 * Sdk controller
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
            $where = ['signal' => 'like', 'column' =>'name', 'value' =>$name];
        }
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
            list($blue,$green,$red,$purple) = self::_getStatusColor($value['status']);
            //0-无效，1-暂停，2-测试，3-运行
            $tabledata[] = [
                MyHtml::aElement('javascript:void(0);' ,'modifySdk', $value['sdid'],'[' .$value['sdid'].'] '.$value['name']),
                MyHtml::aElement('javascript:void(0);' ,'setNameTable', $value['sdid'].','.$value['limit'], $limit),
                MyHtml::iElement('glyphicon glyphicon-globe ','setProvince',$value['sdid'] . ',1'), //默认是移动 所以传了1
                MyHtml::iElement('glyphicon glyphicon-time ','setTime',$value['sdid']),
                MyHtml::iElements('setStatus', 'this,'.$value['sdid'], $blue,$green,$red,$purple)
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

    public function actionGetNameTable() {
        $type = Yii::$app->request->get('type');
        $sdid = Yii::$app->request->get('sdid');
        $partnername = Yii::$app->request->get('partnername');
        $allcampaigns = Campaign::getSdkCampaigns($partnername);
        $limitcaids = SdkCampaignLimit::getlimitCaids($sdid,$type);
        $limitdata = [] ; $unlimitdata = []; $cp_arr = []; //需要转换成str 用来比对
        foreach($allcampaigns as $caid => $value) {
            $partner = $value['partner'];
            $campaign = $value['campaign'];
            //在这个黑名单或者白名单里的放在前面 并且是绿色的 点击了就变成红并且去删除
            if($type == 0){
                 $unlimitdata[] = [
                     'partner' => $partner,
                     'campaign' => $campaign,
                     'status' => MyHtml::iElement('glyphicon-ok-sign glyphicon red', '', '')
                 ];
            }else {
                if (in_array($caid, $limitcaids)) {
                    $cp_arr [] = $caid; //!! 把在黑名单或者白名单里caid 放到数组里 方便比对
                    $limitdata[] = [
                        'partner' => $partner,
                        'campaign' => $campaign,
                        'status' => MyHtml::iElement('glyphicon-ok-sign glyphicon green', 'modifyNameTable', 'this', $caid ),
                    ];
                } else {    //不在这个黑名单或者白名单里的放在后面 并且是红色的 点击了就变成绿色并且去增加 记得要去 更新sdk里的limite
                    $unlimitdata[] = [
                        'partner' => $partner,
                        'campaign' => $campaign,
                        'status' => MyHtml::iElement('glyphicon-ok-sign glyphicon red', 'modifyNameTable', 'this',$caid),
                    ];
                }
            }
        }
        $data = [ array_merge($limitdata, $unlimitdata) , implode(',',$cp_arr)];
        echo json_encode($data);
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
                $resultState = 0;
                $transaction->rollBack();
                MyMail::sendMail($e->getMessage(), 'Error From modify Sdk');
            }
        }

        echo json_encode($resultState);
        exit;
    }

    public function actionModifyStatus(){
        $status = intval(Yii::$app->request->get('status'));
        $sdid = Yii::$app->request->get('sdid');
        $resultState = 0;
        if(isset($status) && isset($sdid)){
            $transaction =  Sdk::getDb()->beginTransaction();
            try {
                $sdkmodel = Sdk::findByPk($sdid);
                if($sdkmodel){
                    $sdkmodel->status = $status;
                    //$sdkmodel->updateTime = time();
                    $resultState = $sdkmodel->save() == true  ? 1 :0;
                }
                $transaction->commit();
                SdkUtils::refreshFusionSdkCache();
            } catch (ErrorException $e) {
                $resultState = 0;
                $transaction->rollBack();
                MyMail::sendMail($e->getMessage(), 'Error From modify Sdk status');
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
                SdkUtils::refreshFusionSdkCache();
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
                    SdkUtils::refreshFusionSdkCache();
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

    public function actionModifyPrivinceTimeLimit() {
        $resultState = 0;
        $time = Yii::$app->request->get('time');
        $sdid = Yii::$app->request->get('sdid');
        $provider = Yii::$app->request->get('provider');
        $prid = Yii::$app->request->get('prid');
        if (!empty($sdid) && isset($provider) && isset($prid)) {
            try {
                $transaction = SdkProvinceTimeLimit::getDb()->beginTransaction();
                if (!empty($time)) {
                    SdkProvinceTimeLimit::deleteByPridSdidProvider($prid, $sdid, $provider);
                    $duration = self::_getLimitDuration($time);
                    foreach($duration as $dur){
                     $model = new SdkProvinceTimeLimit();
                    $model->sdid= $sdid;
                    $model->prid=$prid;
                    $model->provider =$provider;
                    $model->stime = $dur[0];
                    $model->etime = $dur[1];
                //    $model->updateTime = time();
                //    $model->recordTime =time();
                    $model->status = 1;
                    $result = $model->save();
                    $resultState += ($result == true) ? 1 : 0;
                    }
                }else{
                    SdkProvinceTimeLimit::deleteByPridSdidProvider($prid, $sdid, $provider);
                    $resultState = 1;
                }
                $transaction->commit();
                SdkUtils::refreshFusionSdkCache();
            } catch (ErrorException $e) {
                $resultState = 0;
                $transaction->rollBack();
                MyMail::sendMail($e->getMessage(), 'Error From modify province limit');
            }
        }

        echo json_encode($resultState);
        exit;
    }

    public function actionModifySdkTimeLimit() {
        $resultState = 0;
        $time = Yii::$app->request->get('time');
        $sdid = Yii::$app->request->get('sdid');
        if (!empty($sdid)) {
            try {
                $transaction = SdkTimeLimit::getDb()->beginTransaction();
                if (!empty($time)) {
                    SdkTimeLimit::deleteBySdid($sdid);
                    $duration = self::_getLimitDuration($time);
                    foreach($duration as $dur){
                        $model = new SdkTimeLimit();
                        $model->sdid= $sdid;
                        $model->stime = $dur[0];
                        $model->etime = $dur[1];
                     //   $model->updateTime = time();
                     //   $model->recordTime =time();
                        $model->status = 1;
                        $result = $model->save();
                        $resultState += ($result == true) ? 1 : 0;
                    }
                }else{
                    SdkTimeLimit::deleteBySdid($sdid);
                    $resultState = 1;
                }
                $transaction->commit();
                SdkUtils::refreshFusionSdkCache();
            } catch (ErrorException $e) {
                $resultState = 0;
                $transaction->rollBack();
                MyMail::sendMail($e->getMessage(), 'Error From modify sdk time limit');
            }
        }

        echo json_encode($resultState);
        exit;
    }

    public function actionGetProvinceTimeLimit(){ //获取没有被屏蔽的省份下的时间点
        $provider = Yii::$app->request->get('provider');
        $sdid = Yii::$app->request->get('sdid');
        $prid = Yii::$app->request->get('prid');
        $data = [];
        if(!empty($provider) && $sdid && $prid){
            $stimeetime = SdkProvinceTimeLimit::getTimtLimitsBySdidProviderPrid($sdid,$provider,$prid);
            if(!empty($stimeetime)){ //有限制
                $data = self::_getUnlimitTime($stimeetime);
          /*      for($i = 0 ;$i < 24 ;$i++){
                    $unlimit = true;
                    foreach ($stimeetime as $value) {
                        if ($value['stime'] < $value['etime']) {
                            if ($i < intval($value['stime']) || $i >= intval($value['etime'])) {
                            } else {
                                $unlimit = false;
                                break;

                            }
                        }else{
                            if ($i < intval($value['stime']) && $i >= intval($value['etime'])) {
                            } else {
                                $unlimit = false;
                                break;
                            }
                        }
                    }
                    if($unlimit){
                        $data[] = $i;
                    }
                }*/
            }else{
                $data = range(0,23);
            }
        }
        $data = array_unique($data);
        echo json_encode($data);
        exit;
    }

    public function actionGetSdkTimeLimit(){ //获取没有被屏蔽的省份下的时间点
        $sdid = Yii::$app->request->get('sdid');
        $data = [];
        if(!empty($sdid)){
            $stimeetime = SdkTimeLimit::getTimtLimitsBySdid($sdid);
            if(!empty($stimeetime)){ //有限制
                $data = self::_getUnlimitTime($stimeetime);
            }else{
                $data = range(0,23);
            }
        }
        $data = array_unique($data);
        echo json_encode($data);
        exit;
    }

    public function actionModifyNameTable() {
        $resultState = 0;
        $caids = Yii::$app->request->post('caid');//要再名单里新增的caid
        $sdid = Yii::$app->request->post('sdid');
        $type = intval(Yii::$app->request->post('type'));
        if (!empty($sdid)  && isset($type)) {
            try {
                $transaction = SdkCampaignLimit::getDb()->beginTransaction();
                $resultState += SdkCampaignLimit::deleteBySdid($sdid);
                if (!empty($caids) && $type > 0) {
                    foreach($caids as $caid){
                        $model = new SdkCampaignLimit();
                        $model->sdid = $sdid;
                        $model->caid= $caid;
                        $model->type = $type;
                        $model->status = 1;
                        $result = $model->save();
                        $resultState += ($result == true) ? 1 : 0;
                    }
                }
                $sdkmodel = Sdk::findByPk($sdid);
                $sdkmodel->limit = $type;
                $resultState += $sdkmodel->save() == true ? 1 :0;
                $transaction->commit();
                SdkUtils::refreshFusionSdkCache();
            } catch (ErrorException $e) {
                $resultState = 0;
                $transaction->rollBack();
                MyMail::sendMail($e->getMessage(), 'Error From modify campaign limit');
            }
        }

        echo json_encode($resultState);
        exit;
    }

    private function _getUnlimitTime($stimeetime){ //获取没有被屏蔽的时间点
        for($i = 0 ;$i < 24 ;$i++){
            $unlimit = true;
            foreach ($stimeetime as $value) {
                if ($value['stime'] < $value['etime']) {
                    if ($i < intval($value['stime']) || $i >= intval($value['etime'])) {
                    } else {
                        $unlimit = false;
                        break;

                    }
                }else{
                    if ($i < intval($value['stime']) && $i >= intval($value['etime'])) {
                    } else {
                        $unlimit = false;
                        break;
                    }
                }
            }
            if($unlimit){
                $data[] = $i;
            }
        }

        return $data;
    }

    private function _getLimitDuration($time){//获得屏蔽时间区间
        $duration = [];
        $duration1 = [];
        foreach($time as $key => $value){
            if(empty($duration1)){
                $duration1[] = $value;
            }else{
                if($value - 1 == $duration1[count($duration1)-1]){ //如果是下一个数就推进小数组
                    $duration1[] = $value;
                }else{ //如果不是下一个数就把 (1)小数组推进大数组 (2)清空小数组 把这个数推进去
                    $duration[] = $duration1;
                    $duration1 = [];
                    $duration1[] = $value;
                }
            }
        }
        $duration[] = $duration1; // 把最后的小数组推进去

         //23 和 0都存在的情况 合并两个小数组
      //  if(in_array(0, $time) && in_array(23, $time)){
            $arr1 = [] ;$arr2= [];
            foreach($duration as $k => $v){
                if(in_array(0,$v)){ //拿到含0的数组
                    $arr1 = $v;
                    $duration[$k] = [];
                } else if(in_array(23,$v)){ //拿到含23的数组
                    $arr2 = $v;
                    $duration[$k] = [];
                } else{
                    $duration[$k] = [min($v), max($v)+1]; //获得区间 注意最后都要+1
                }
            }
            if(!empty($arr1) && !empty($arr2)){  // 如果说含0和含23的数组都存在  组成新数组 获得区间
                $duration[] = [min($arr2), max($arr1) + 1];
            }else{ //否则 麻烦再把小数组arr1 arr2 给人家再推回去
                $duration[] = empty($arr1) ? [] : [min($arr1), max($arr1)+1];
                $duration[] = empty($arr2) ? [] : [min($arr2), max($arr2)+1];
            }
            return array_filter($duration);
       // }
    }

    private function _addProvinceLimit($sdid,$prid,$provider, $status){
        $model = new SdkProvinceLimit();
        $model->sdid= $sdid;
        $model->prid=$prid;
        $model->provider =$provider;
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
                    $data['partner'] = SdkPartner::getNameByPk($data['spid']);
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
            $sdkmodel->sign = trim($post['sdk_sign']);
         //   $sdkmodel->updateTime = time();
          //  $sdkmodel->recordTime = time();
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
              //  $sdkmodel->updateTime = time();
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
            case 0: $arr[2] = 'red'; break; //无效
            case 1: $arr[0] = 'blue'; break; //暂停
            case 2: $arr[3] = 'purple'; break; //测试
            case 3: $arr[1] = 'green'; break; //运行
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
      //  $partnerModel->updateTime = time();
       // $partnerModel->recordTime = time();
        $partnerModel->status = 1;
        $resultState = $partnerModel->save();
        return $resultState == true ? $partnerModel->spid : 0;
    }

}
