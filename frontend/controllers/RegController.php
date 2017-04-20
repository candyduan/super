<?php
namespace frontend\controllers;

use yii\web\Controller;
use common\library\Utils;
use common\models\orm\extend\SimCard;

/**
 * reg controller
 */
class RegController extends Controller{
    /*
     * 请求注册
     */
    public function actionRg(){
        //通用参数
        $imsi   = Utils::getParam('imsi');
        $imei   = Utils::getParam('imei');
        $iccid  = Utils::getParam('iccid');
        $cmcc   = Utils::getParam('CMCC');
        $mcc    = Utils::getParam('MCC');
        $mnc    = Utils::getParam('MNC');
        $lac    = Utils::getParam('LAC');
        $cid    = Utils::getParam('CID');
        $networkType    = Utils::getParam('networkType',0);
        //该接口特有参数
        $regChannelId   = Utils::getParam('regChannelId',0);
        
        $simcardModel   = SimCard::findByImsi($imsi);
        
    }
    
    /*
     * 触发url类型验证码下发
     */
    public function actionUrlPlus(){
        
    }
    
    /*
     * 提交验证码
     */
    public function actionGcmf(){
        
    }
    
    /*
     * 日志上传
     */
    public function actionLp(){
        
    }
    
    /*
     * phr
     */
    public function actionPhr(){
        
    }
    
//     public function actionTest(){
//         $out    = array(
//             'a' => 1,
//             'b' => 2,
//         );
//         Utils::jsonOut($out);
//     }
}