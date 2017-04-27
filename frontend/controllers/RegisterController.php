<?php
namespace frontend\controllers;

use yii\web\Controller;
use common\library\Utils;
use common\models\orm\extend\SimCard;
use common\models\orm\extend\RegChannel;
use common\library\Constant;
use common\models\orm\extend\RegOrder;

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
        
        if(!is_numeric($rcid)){
            $out['resultCode']  = Constant::RESULT_CODE_PARAMS_ERR;
            $out['msg']         = Constant::RESULT_MSG_PARAMS_ERR;
            Utils::jsonOut($out);
            return;
        }
        $simCardModel       = SimCard::findByImsi($imsi);
        $regChannelModel    = RegChannel::findByPk($rcid);
        if($simCardModel && $regChannelModel){
            try {
                $regOrderModel      = \frontend\library\regchannel\Utils::createOrder($rcid, $imsi);
                $res                = \frontend\library\regchannel\Utils::gotoRegister($regChannelModel, $regOrderModel, $simCardModel);
                if(is_array($res)){
                    $out['resultCode']  = Constant::RESULT_CODE_SUCC;
                    $out['msg']         = Constant::RESULT_MSG_SUCC;
                    $out['roid']        = $regOrderModel->roid;
                    $out['tks']         = $res;
                }else{
                    $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
                    $out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
                }
            }catch (\Exception $e){
                $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
                $out['msg']         = '系统繁忙';
            }
        }else{
            $out['resultCode']  = Constant::RESULT_CODE_NONE;
            $out['msg']         = Constant::RESULT_MSG_NONE;
        }
        Utils::jsonOut($out);
    }
    
    /*
     * 触发url类型验证码下发
     */
    public function actionUrlPlus(){
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
        $roid   = Utils::getParam('roid',0);
        
        if(!is_numeric($roid)){
            $out['resultCode']  = Constant::RESULT_CODE_PARAMS_ERR;
            $out['msg']         = Constant::RESULT_MSG_PARAMS_ERR;
            Utils::jsonOut($out);
            return;
        }
        $regOrderModel  = RegOrder::findByPk($roid);
        $regChannelModel= RegChannel::findByPk($regOrderModel->rcid);
        if($regOrderModel && $regChannelModel){
            $res = \frontend\library\regchannel\Utils::gotoTrigger($regChannelModel,$regOrderModel);
            if($res){
                $out['resultCode']  = Constant::RESULT_CODE_SUCC;
                $out['msg']         = 'success';
            }else{
                $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
                $out['msg']         = '请求失败，请稍后重试！';
            }
        }else{
            $out['resultCode']  = Constant::RESULT_CODE_NONE;
            $out['msg']         = Constant::RESULT_MSG_NONE;
        }
        Utils::jsonOut($out);
    }
    
    /*
     * 提交验证码
     */
    public function actionGcmf(){
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
        $roid    = Utils::getParam('roid');
        $port      = Utils::getParam('cp');
        $message = Utils::getParam('content');
        
        if(!is_numeric($roid) || !is_numeric($port) || !Utils::isValid($message)){
            $out['resultCode']  = Constant::RESULT_CODE_PARAMS_ERR;
            $out['msg']         = Constant::RESULT_MSG_PARAMS_ERR;
            Utils::jsonOut($out);
            return;
        }
        
        $regOrderModel  = RegOrder::findByPk($roid);
        if($regOrderModel){
            $regChannelModel= RegChannel::findByPk($regOrderModel->rcid);
            if($regChannelModel){
                $res    = \frontend\library\regchannel\Utils::gotoSubmit($regChannelModel, $regOrderModel, $port, $message);
                if(is_array($res)){
                    $out['resultCode']  = Constant::RESULT_CODE_SUCC;
                    $out['msg']         = Constant::RESULT_MSG_SUCC;
                    $out['tks']         = $res;
                }else{
                    $out['resultCode']  = Constant::RESULT_CODE_NONE;
                    $out['msg']         = Constant::RESULT_MSG_NONE;
                }
            }else{
                $out['resultCode']  = Constant::RESULT_CODE_NONE;
                $out['msg']         = Constant::RESULT_MSG_NONE;
            }
        }else{
            $out['resultCode']  = Constant::RESULT_CODE_NONE;
            $out['msg']         = Constant::RESULT_MSG_NONE;
        }
        Utils::jsonOut($out);
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
}