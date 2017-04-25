<?php
namespace frontend\controllers;

use yii\web\Controller;
use common\library\Utils;
use common\models\orm\extend\SimCard;
use common\models\orm\extend\RegChannel;
use common\library\Constant;

/**
 * reg controller
 */
class RegisterController extends Controller{
    /*
     * 请求注册
     */
    public function actionRr(){
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
        $rcid   = Utils::getParam('rcid',0);
        
        $simCardModel       = SimCard::findByImsi($imsi);
        $regChannelModel    = RegChannel::findByPk($rcid);
        if($simCardModel && $regChannelModel){
            try {
                $regOrderModel      = \frontend\library\regchannel\Utils::createOrder($rcid, $imsi);
                $out['resultCode']  = Constant::RESULT_CODE_SUCC;
                $out['msg']         = 'success';
                $out['roid']        = $regOrderModel->roid;
                $out['tks']         = \frontend\library\regchannel\Utils::gotoRegister($regChannelModel, $regOrderModel, $simCardModel);
            }catch (\Exception $e){
                $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
                $out['msg']         = '系统繁忙';
            }
        }else{
            $out['resultCode']  = Constant::RESULT_CODE_EXCEPT;
            $out['msg']         = '请求异常';
        }
        Utils::jsonOut($out);
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
    
    public function actionTest(){
        $out    = array(
            'a' => 1,
            'b' => 2,
        );
        Utils::jsonOut($out);
    }
}