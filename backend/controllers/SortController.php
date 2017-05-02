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

    public function actionGetSdkSort() { //根据sdk 和 运营商拿到省份 1 移动 2 联通 3 电信
        $provider = Yii::$app->request->get('provider');
        $prid = Yii::$app->request->get('prid');
        $data = $sortByProviderPrid = [];
        //根据运营商sort
        $sortByProvider = [1,2];
        //根据省份运营商sort
        if($prid > 0){
            $sortByProviderPrid = [2,1];
        }
        //自然sort
        $nosort = [1,2];

        if(!empty($sortByProviderPrid)){
            $sort = $sortByProviderPrid;
        }else if($sortByProvider){
            $sort = $sortByProvider;
        }else{
            $sort = $nosort;
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

}
