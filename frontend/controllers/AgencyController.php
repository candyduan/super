<?php
namespace frontend\controllers;

use yii\web\Controller;
use common\library\Utils;
use common\library\Constant;
use frontend\library\regchannel\Utils as ChannelUtils;
use common\models\orm\extend\AgencyStack;
use common\models\orm\extend\AgencyAccount;
use common\models\orm\extend\SimCard;

/**
 * reg controller
 */
class AgencyController extends Controller{
    /*
     * 注册中介提交验证码 
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
    
    
    /*
     * 注册中介日志上报 
     */
    public function actionLp(){
        $data   = Utils::getFrontendParam('data');
        //日志后期会专门处理
        Utils::log('agency'.$data);
        $out['resultCode']  = Constant::RESULT_CODE_SUCC;
        $out['msg']         = Constant::RESULT_MSG_SUCC;
        Utils::jsonOut($out);
    }
    
    /*
     * 第三方获取手机号
     */
    public function actionGetMobile(){
        $account    = Utils::getFrontendParam('account');
        $passwd     = Utils::getFrontendParam('passwd');
        
        $valid      = AgencyAccount::isValid($account,$passwd);
        if($valid){
            $accountModel   = AgencyAccount::findByAccount($account);
            $stackModel = AgencyStack::findNewByAaid($accountModel->aaid);
            if($stackModel){
                try{
                    $stackModel->status = AgencyStack::STATUS_APK;
                    $stackModel->save();
                    $out['resultCode']  = Constant::RESULT_CODE_SUCC;
                    $out['msg']         = Constant::RESULT_MSG_SUCC;
                    $list   = [];
                    $simCardModel = SimCard::findByImsi($stackModel->imsi);
                    $item   = array(
                        'asid'      => $stackModel->asid,
                        'mobile'    => $simCardModel->mobile,
                        'repeat'    => 5,
                        'timeout'   => 60,
                    );
                }catch (\Exception $e){
                    $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
                    $out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
                }
            }else{
                $out['resultCode']  = Constant::RESULT_CODE_NONE;
                $out['resultCode']  = Constant::RESULT_MSG_NONE;
            }
        }else{
            $out['resultCode']  = Constant::RESULT_CODE_AUTH_FAIL;
            $out['msg']         = Constant::RESULT_MSG_AUTH_FAIL;
        }
        Utils::jsonOut($out);
    }
    
    /*
     * 第三方获取验证码
     */
    
    public function actionGetVerifyCode(){
        $account    = Utils::getFrontendParam('account');
        $passwd     = Utils::getFrontendParam('passwd');
        $asid       = Utils::getFrontendParam('asid',0);
        
        
        if(!Utils::isValid($account) || !Utils::isValid($passwd) || !is_numeric($asid)){
            $out['resultCode']  = Constant::RESULT_CODE_PARAMS_ERR;
            $out['msg']         = Constant::RESULT_MSG_PARAMS_ERR;
            Utils::jsonOut($out);
            return;
        }
        $valid  = AgencyAccount::isValid($account, $passwd);
        if($valid){
            $stackModel = AgencyStack::findByPk($asid);
            if($stackModel){
                $verifyCode = $stackModel->verifyCode;
                if(Utils::isValid($verifyCode)){
                    $out['resultCode']  = Constant::RESULT_CODE_SUCC;
                    $out['msg']         = Constant::RESULT_MSG_SUCC;
                    $out['verifyCode']  = $verifyCode;                    
                }else{
                    $out['resultCode']  = Constant::RESULT_CODE_NONE;
                    $out['msg']         = '验证码暂未回传，请稍后';
                }
            }else{
                $out['resultCode']  = Constant::RESULT_CODE_NONE;
                $out['resultCode']  = Constant::RESULT_MSG_NONE;
            }
        }else{
            $out['resultCode']  = Constant::RESULT_CODE_AUTH_FAIL;
            $out['msg']         = Constant::RESULT_MSG_AUTH_FAIL;
        }
        Utils::jsonOut($out);
    }
    
    /*
     * 第三方告知注册结果
     */
    public function actionSetStatus(){
        $account    = Utils::getFrontendParam('account');
        $passwd     = Utils::getFrontendParam('passwd');
        $asid       = Utils::getFrontendParam('asid',0);
        $status     = Utils::getFrontendParam('status',0);
        
        if(!Utils::isValid($account) || !Utils::isValid($passwd) || !is_numeric($asid) || !is_numeric($status)){
            $out['resultCode']  = Constant::RESULT_CODE_PARAMS_ERR;
            $out['msg']         = Constant::RESULT_MSG_PARAMS_ERR;
            Utils::jsonOut($out);
            return;
        }
        
        $valid  = AgencyAccount::isValid($account, $passwd);
        if($valid){
            $stackModel = AgencyStack::findByPk($asid);
            if($stackModel){
                if($status){
                    try{
                        $stackModel->status = AgencyStack::STATUS_SUCC;
                        $stackModel->save();
                        
                        $out['resultCode']  = Constant::RESULT_CODE_SUCC;
                        $out['msg']         = Constant::RESULT_MSG_SUCC;
                    }catch (\Exception $e){
                        $out['resultCode']  = Constant::RESULT_CODE_SYSTEM_BUSY;
                        $out['msg']         = Constant::RESULT_MSG_SYSTEM_BUSY;
                    }
                }else{
                    $out['resultCode']  = Constant::RESULT_CODE_SUCC;
                    $out['msg']         = Constant::RESULT_MSG_SUCC; 
                }
            }else{
                $out['resultCode']  = Constant::RESULT_CODE_NONE;
                $out['resultCode']  = Constant::RESULT_MSG_NONE;
            }
        }else{
            $out['resultCode']  = Constant::RESULT_CODE_AUTH_FAIL;
            $out['msg']         = Constant::RESULT_MSG_AUTH_FAIL;
        }
        
        Utils::jsonOut($out);
    }
    
}
