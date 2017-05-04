<?php
namespace backend\controllers;

use Yii;
use yii\base\ErrorException;
use yii\helpers\Html;
use yii\web\Controller;
use backend\web\util\MyHtml;
use common\models\orm\extend\App;
use common\models\orm\extend\Campaign;
use common\models\orm\extend\Admin;
use common\models\orm\extend\Partner;
use common\library\Utils;
use backend\web\util\MyMail;
/**
 * Campaign controller
 */
class CampaignController extends Controller
{
    public function actionIndex()
    {
        $id = Yii::$app->request->get('id','');
        return $this->render('index', ['id' => $id]);
    }

    public function actionAjaxIndex(){
        $request = Yii::$app->request;
        $start = intval($request->get('start', 0));
        $length = intval($request->get('length', 100));
        //$name = trim($request->get('name',''));
        $id = $request->get('id','');//app 的id
        $condition = self::_getCondition($id);

        $data = Campaign::getIndexData($condition, $start,$length);
        $count = Campaign::getIndexCount($condition);
        $status = [
            0 => '审核中',
            1 => '进行中',
            2 => '已结束',
            3 => '测试中'
        ];
        $grade = [
            0 => '普通',
            1 => 'A级',
        ];
        $tabledata = [];
        foreach($data as $value){
            $tabledata[] = [
                MyHtml::aElement('javascript:void(0);' ,'showCampaign', $value['id'],'[' .$value['id'].'] '.$value['name']),
                isset($status[$value['status']]) ? $status[$value['status']] :'',
                isset($grade[$value['grade']]) ? $grade[$value['grade']] :'',
                sprintf('%.2f',$value['agentRate']) . ' %',
                sprintf('%.2f',$value['agentCutRate']) . ' % @'. date('Y-m-d',$value['agentCutDay']),
                sprintf('%.2f',$value['rate']) . '%',
                sprintf('%.2f',$value['cutRate']) . ' % @' . date('Y-m-d', $value['cutDay']),
                sprintf('%.2f',$value['mrate']) . ' %',
                $value['sign'],
                MyHtml::aElement("javascript:void(0);", 'modifyGoods',$value['id'],'关联SDK参数配置'). MyHtml::br().
                MyHtml::aElement("/campaign-package-list/index?cid=".$value['id'], '', '','活动包管理')

            ];
        }

        $data = [
            'searchData' => [

            ],
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'tableData' => $tabledata,
        ];
        Utils::jsonOut($data);
        exit;
    }

    public function actionModifyPaymode() {
        $resultState = 0;
        $caid = Yii::$app->request->get('caid');
        $paymode =  Yii::$app->request->get('paymode');
        if (isset($caid)) {
            $transaction =  Campaign::getDb()->beginTransaction();
            try {
                $campaignModel = Campaign::findByPk($caid);
                if($campaignModel){
                    $campaignModel->payMode = $paymode;
                    $resultState  = $campaignModel->save() == true ? 1: 0;
                }
                $transaction->commit();
            } catch (ErrorException $e) {
                $resultState = 0;
                $transaction->rollBack();
                MyMail::sendMail($e->getMessage(), 'Error From modify campaign pay mode');
            }
        }

        echo json_encode($resultState);
        exit;
    }

    public function actionGetCampaign() {
        $id = Yii::$app->request->get('caid');
        $campaign = [];
        if(isset($id)) {
            $campaign = Campaign::findByPk($id)->toArray();
            $status = [
                0 => '审核中',
                1 => '进行中',
                2 => '已结束',
                3 => '测试中'
            ];
            $type = [
                0 => '网盟活动',
                1 => 'SDK活动',
                2 => '支付活动'
            ];
            if (!empty($campaign)) {
                $app = App::findByPk($campaign['app'])->toArray();
                $partner = Partner::findByPk($campaign['partner'])->toArray();
                $campaign['appname'] = isset($app['name']) ? $app['name'] : '';
                $campaign['partnername'] = isset($partner['name']) ? $partner['name'] : '';
                $campaign['status'] = isset($status[$campaign['status']]) ? $status[$campaign['status']] : '';
                $campaign['type'] = isset($type[$campaign['type']]) ? $type[$campaign['type']] : '';
                $campaign['startdate'] = date('Y-m-d', $campaign['beginDate']);
                $campaign['enddate'] = date('Y-m-d', $campaign['endDate']);
                $campaign['grade'] = $campaign['grade'] == 0 ? '普通' : 'A级';
                $campaign['rate'] = sprintf('%.2f', $campaign['rate']) . '%'; //cp分成比例
                $campaign['cutrate'] = sprintf('%.2f', $campaign['cutRate']) . '%';  //cp优化比例
                $campaign['cutday'] = date('Y-m-d', $campaign['cutDay']); //cp优化开始
                $campaign['mrate'] = sprintf('%.2f', $campaign['mrate']) . '%'; //渠道分成比例
            }
        }
        Utils::jsonOut($campaign);
        exit;
    }

    private function _getCondition($id){
        $condition[] = 'and';
        $condition[] = [
            '=',
            'campaign.deleted',
            0
        ];

        $condition[] = [
            '=',
            'campaign.belong',
            1
        ];

        if($id!== ''){
            $condition[] = [
                '=',
                'app.id',
                $id
            ];
        }

        return $condition;
    }
}
