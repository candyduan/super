<?php
namespace frontend\controllers;

use yii\web\Controller;
use common\library\Utils;
use common\library\Constant;
use frontend\library\regchannel\Utils as ChannelUtils;
use common\models\orm\extend\AgencyStack;
use common\models\orm\extend\AgencyAccount;

/**
 * reg controller
 */
class AgencyController extends Controller{
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
        $asid       = Utils::getFrontendParam('asid');
        $content   = Utils::getFrontendParam('content');
        if(!is_numeric($asid) || !Utils::isValid($content)){
            $out['resultCode']  = Constant::RESULT_CODE_PARAMS_ERR;
            $out['msg']         = Constant::RESULT_MSG_PARAMS_ERR;
            Utils::jsonOut($out);
            return;
        }
        $stackModel = AgencyStack::findByPk($asid);
        if($stackModel){
            $accountModel   = AgencyAccount::findByPk($stackModel->aaid);
            if($accountModel){
                $verifyCode = ChannelUtils::getVerifyCodeFromMessage($content,$accountModel->smtKeywords);
                if(Utils::isValid($verifyCode)){
                    $stackModel->verifyCode = $verifyCode;
                    try{
                        $stackModel->save();
                        $out['resultCode']  = Constant::RESULT_CODE_SUCC;
                        $out['msg']         = Constant::RESULT_MSG_SUCC;
                    }catch (\Exception $e){
                        $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
                        $out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
                    }
                    
                }else{
                    Utils::log('验证码匹配错误');
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
}