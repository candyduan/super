<?php
namespace backend\controllers;
use common\library\BController;
use common\models\orm\extend\DeveloperChannelCount;
use common\library\Utils;
use common\library\Constant;

class PayController extends BController{
    public $layout = "pay";
    
    public function actionIndex(){
        return $this->render('index');
    }
    
    public function actionChannelView(){
        return $this->render('channel-view');
    }
    
    public function actionChannelResult(){
        
    }
    
    public function actionDutyView(){
    		return $this->render('duty-view');
    }
    
    public function actionDevelopersResult(){
    		$models = DeveloperChannelCount::findAllByCountAsc();
    		$datas = [];
    		if($models){
    			foreach ($models as $model){
    				$datas[] = [
    						'id' => $model->id,
    						'name' => $model->name,
    						'count' => $model->count,
    						'status' => $model->status,
    				];
    			}
    			$out['datas'] = $datas;
    			$out['resultCode']  = Constant::RESULT_CODE_SUCC;
    			$out['msg']         = Constant::RESULT_MSG_SUCC;
    		}else{
    			$out['resultCode']  = Constant::RESULT_CODE_SUCC;
    			$out['msg']         = Constant::RESULT_MSG_NONE;
    		}
    		Utils::jsonOut($out);
    }
    
    public function actionAddDeveloperChannelCount(){
    		$pwd = Utils::getBackendParam('pwd');
    		$id = Utils::getBackendParam('id');
    		$out['resultCode']  = Constant::RESULT_CODE_NONE;
    		$out['msg']         = Constant::RESULT_MSG_NONE;
    		if(md5($pwd) != 'e10adc3949ba59abbe56e057f20f883e'){
    			$out['msg']         = '密码有误';
    			Utils::jsonOut($out);
    			exit;
    		}
    		$model = DeveloperChannelCount::findByPk($id);
    		if($model){
    			$model->count = $model->count + 1;
    			try {
    				$model->save();
    				$out['resultCode']  = Constant::RESULT_CODE_SUCC;
    				$out['msg']         = Constant::RESULT_MSG_SUCC;
    			} catch (Exception $e) {
    				$out['resultCode']  = Constant::RESULT_CODE_NONE;
    				$out['msg']         = Constant::RESULT_MSG_NONE;
    			}
    		}
    		Utils::jsonOut($out);
    		
    }
    

    
}