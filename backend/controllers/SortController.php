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
        $sortByProvider = SdkSort::getSortByProvider($provider);
        //根据省份运营商sort
        if($prid > 0){
            $sortByProviderPrid = SdkProvinceSort::getSortByPridProvider($prid,$provider);
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
            $data[] = [
                'sdid' => $sdid,
                'sdkname'=> 'name',
                'ratio' => rand(1,20),
                'item' => MyHtml::iElement('glyphicon glyphicon-align-justify ','','',$sdid)
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

    private function _getValidSort($sort, $nosort){
        $validSort = [];

            foreach ($sort as $key => $sdid) {
                if(in_array($sdid,$nosort)){
                    $validSort[] = $sdid;
                }
            }
            if(!empty($validSort)){
                $validSort = array_merge($validSort, array_diff($nosort,$validSort));
            }

        return  $validSort;
    }

}
