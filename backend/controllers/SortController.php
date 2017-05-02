<?php
namespace backend\controllers;

use Yii;
use common\library\Utils;
use yii\base\ErrorException;
use yii\helpers\Html;
use yii\web\Controller;
use backend\web\util\MyHtml;
use backend\web\util\MyMail;
use common\models\orm\extend\Sdk;
use common\models\orm\extend\SdkPartner;
use common\models\orm\extend\SdkProvinceLimit;
use common\models\orm\extend\Province;
use common\models\orm\extend\SdkProvinceSort;
use common\models\orm\extend\SdkSort;
use common\models\orm\extend\SdkPayDay;
use common\models\orm\extend\SdkProvinceTimeLimit;
use common\models\orm\extend\SdkTimeLimit;
use common\models\orm\extend\Campaign;
use common\models\orm\extend\SdkCampaignLimit;
/**
 * Sort controller
 */
class SortController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGetSdkCount(){
        $provider = Utils::getBackendParam('provider');
        $data = [];
        if(!empty($provider)){
            $data = Province::getAllProvinces();
            $sdkcount = Sdk::getSdkCount();
            foreach($data as $prid => $name){
                $limitCount = SdkProvinceLimit::getLimitCountByProviderandPrid($provider,$prid);
                $data[$prid] = $sdkcount - $limitCount;
            }
        }

        Utils::jsonOut($data);
        exit;
    }

    public function actionGetSdkSort() { //参与排序的sdk ：状态为1，2，3  且没有在某个省份屏蔽下
        $provider = Yii::$app->request->get('provider');
        $prid = Yii::$app->request->get('prid');
        $data = $sortByProviderPrid = [];

        //自然sort 满足状态123
        $nosort = Sdk::getValidSdids();
        //如果有省份 要去除被屏蔽的
        if($prid > 0 ){
            $limitSdids = SdkProvinceLimit::getLimitSdidsByPridProvider($prid,$provider);
            $nosort = self::_getValidSdids($nosort, $limitSdids);//去掉屏蔽的
        }
        //根据运营商sort
        $sortByProvider = json_decode(SdkSort::getSortByProvider($provider));
        //根据省份运营商sort
        if($prid > 0){
            $sortByProviderPrid = json_decode(SdkProvinceSort::getSortByPridProvider($prid,$provider));
        }

        //把原先排序里不valid的sdid 去除 然后再吧 不在noSort里的sdid 加到排序后面去
        if(!empty($sortByProviderPrid)){
            $sort =  self::_getValidSort($sortByProviderPrid,$nosort);
        }else if(!empty($sortByProvider)){
            $sort =  self::_getValidSort($sortByProvider,$nosort);
        }else{
            $sort =  $nosort;
        }

        foreach($sort as $sdid){
            $sdk = sdk::findByPk($sdid);
            $data[] = [
                'sdid' => $sdid,
                'sdkname'=> isset($sdk->name)?  $sdk->name : '',
                'ratio' => self::_getRatio($prid,$provider),
              //  'item' => MyHtml::iElement('glyphicon glyphicon-align-justify ','','',$sdid)
            ];
        }

        Utils::jsonOut($data);
        exit;
    }

    private function _getValidSdids($sort, $limitSdids){
        $validSdids = [];
        if(!empty($limitSdids)) {

            foreach ($sort as $key => $sdid) {
               if(!in_array($sdid,$limitSdids)){
                   $validSdids[] = $sdid;
               }
            }
        }else{
            $validSdids = $sort;
        }
        return  $validSdids;
    }

    private function _getValidSort($oldsort, $nosort){
        $validSort = [];
            if(!empty($oldsort)) {
                foreach ($oldsort as $key => $sdid) {
                    if (in_array($sdid, $nosort)) {
                        $validOldSort[] = $sdid;
                    }
                }
                if (!empty($validOldSort)) {
                    $validSort = array_merge($validOldSort, array_diff($nosort, $validOldSort));
                }
            }else{
                $validSort = $nosort;
            }

        return  $validSort;
    }

    private function _getRatio($prid,$provider){
        $ratio = 0;
        $date = date('Y-m-d', strtotime("-1 day"));
        $yes_all_success = SdkPayDay::getTodayByPridProvider($prid, $provider, $date);
        if(!empty($yes_all_success['sumallpay']) && !empty($yes_all_success['sumsuccesspay']) ){
            $ratio = number_format($yes_all_success['sumallpay'] / $yes_all_success['sumallsuccess'], 2);
        }
        return $ratio;
    }

    public function actionAddSort(){
        $provider = intval(Yii::$app->request->post('provider'));
        $prid = Yii::$app->request->post('prid');
        $sdids =  Yii::$app->request->post('sdids');
        $resultState = 0;
        if(isset($sdids) && isset($prid) && isset($provider)){
            $transaction =  SdkSort::getDb()->beginTransaction();
            try {
                if(!empty($sdids)){
                    SdkProvinceSort::deleteByProvider($provider); //无论有没有prid 重新排序 都要把sdkprovincesort 里对应记录删掉
                    if($prid > 0){
                       $sdkProvinceModel = new SdkProvinceSort();
                       $sdkProvinceModel->provider = $provider;
                       $sdkProvinceModel->prid = $prid;
                       $sdkProvinceModel->sort = json_encode($sdids);
                       $sdkProvinceModel->status = 1;
                       $result = $sdkProvinceModel->save();
                       $resultState = $result == true ? 1: 0;
                    }else{
                         SdkSort::deleteByProvider($provider);
                        $sdkModel = new SdkSort();
                        $sdkModel->provider = $provider;
                        $sdkModel->sort = json_encode($sdids);
                        $sdkModel->status = 1;
                        $result = $sdkModel->save();
                        $resultState = $result == true ? 1: 0;
                    }
                }
                $transaction->commit();
            } catch (ErrorException $e) {
                $resultState = 0;
                $transaction->rollBack();
                MyMail::sendMail($e->getMessage(), 'Error From add sdk sort');
            }
        }
        echo json_encode($resultState);
        exit;
    }

}
