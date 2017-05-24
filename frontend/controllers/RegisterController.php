<?php
namespace frontend\controllers;

use yii\web\Controller;
use common\library\Utils;
use common\models\orm\extend\SimCard;
use common\models\orm\extend\RegChannel;
use common\library\Constant;
use common\models\orm\extend\RegOrder;
use common\library\FController;

/**
 * reg controller
 */
class RegisterController extends FController{
    /*
     * 请求注册
     */
    public function actionRr(){
        //通用参数
        $imsi   = Utils::getFrontendParam('imsi');
        $imei   = Utils::getFrontendParam('imei');
        $iccid  = Utils::getFrontendParam('iccid');
        $cmcc   = Utils::getFrontendParam('CMCC');
        $mcc    = Utils::getFrontendParam('MCC');
        $mnc    = Utils::getFrontendParam('MNC');
        $lac    = Utils::getFrontendParam('LAC');
        $cid    = Utils::getFrontendParam('CID');
        $networkType    = Utils::getFrontendParam('networkType',0);
        //该接口特有参数
        $rcid   = Utils::getFrontendParam('rcid',0);
        
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
                $out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
                $out['msg']         = $e->getMessage();
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
        $imsi   = Utils::getFrontendParam('imsi');
        $imei   = Utils::getFrontendParam('imei');
        $iccid  = Utils::getFrontendParam('iccid');
        $cmcc   = Utils::getFrontendParam('CMCC');
        $mcc    = Utils::getFrontendParam('MCC');
        $mnc    = Utils::getFrontendParam('MNC');
        $lac    = Utils::getFrontendParam('LAC');
        $cid    = Utils::getFrontendParam('CID');
        $networkType    = Utils::getFrontendParam('networkType',0);
        //该接口特有参数
        $roid   = Utils::getFrontendParam('roid',0);
        
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
                $out['msg']         = Constant::RESULT_MSG_SUCC;
            }else{
                $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
                $out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
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
        $imsi   = Utils::getFrontendParam('imsi');
        $imei   = Utils::getFrontendParam('imei');
        $iccid  = Utils::getFrontendParam('iccid');
        $cmcc   = Utils::getFrontendParam('CMCC');
        $mcc    = Utils::getFrontendParam('MCC');
        $mnc    = Utils::getFrontendParam('MNC');
        $lac    = Utils::getFrontendParam('LAC');
        $cid    = Utils::getFrontendParam('CID');
        $networkType    = Utils::getFrontendParam('networkType',0);
        //该接口特有参数
        $roid    = Utils::getFrontendParam('roid');
        $port    = Utils::getFrontendParam('cp');
        $message = Utils::getFrontendParam('content');
        
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
        $data   = Utils::getFrontendParam('data');        
        //日志后期会专门处理
        Utils::log('lp'.$data);
        $out['resultCode']  = Constant::RESULT_CODE_SUCC;
        $out['msg']         = Constant::RESULT_MSG_SUCC;
        Utils::jsonOut($out);
    }
    
    /*
     * phr
     */
    public function actionPhr(){
        $roid   = Utils::getFrontendParam('roid');
        $url    = Utils::getFrontendParam('url');
        $content= Utils::getFrontendParam('content');
        
        
        //由于目前暂未了解phr整个流程，暂时仅记录下来
        Utils::log('phr:'.$url.'_'.$content);
        
        $out['resultCode']  = Constant::RESULT_CODE_SUCC;
        $out['msg']         = Constant::RESULT_MSG_SUCC;
        Utils::jsonOut($out);
    }
    
    
    
    
    /*
     * 数据同步
     */
    public function actionSync(){
        $sign     = Utils::getFrontendParam('sign');
        $data   = \frontend\library\regchannel\Utils::getSyncData();
        if(!Utils::isValid($sign)){
            $out['resultCode']  = Constant::RESULT_CODE_PARAMS_ERR;
            $out['msg']         = Constant::RESULT_MSG_PARAMS_ERR;
            Utils::jsonOut($out);
            return;
        }
        $regChannelModel    = RegChannel::findBySign($sign);
        if($regChannelModel){
            $res = \frontend\library\regchannel\Utils::gotoSync($regChannelModel, $data);
            echo $res;
        }else{
            $out['resultCode']  = Constant::RESULT_CODE_NONE;
            $out['msg']         = Constant::RESULT_MSG_NONE;
            Utils::jsonOut($out);
        }
        
    }
}