<?php
namespace backend\controllers;

use Yii;
use yii\base\ErrorException;
use yii\helpers\Html;
use yii\web\Controller;
use backend\web\util\MyHtml;
use common\models\orm\extend\App;
use common\models\orm\extend\Admin;
use common\models\orm\extend\Partner;
use common\library\Utils;
/**
 * App controller
 */
class AppController extends Controller
{
    public function actionIndex()
    {
        $id = Yii::$app->request->get('id',0);
        return $this->render('index', ['id' => $id]);
    }

    public function actionAjaxIndex(){
        $request = Yii::$app->request;
        $start = intval($request->get('start', 0));
        $length = intval($request->get('length', 100));
        $name = trim($request->get('name',''));
      //  $id = intval($request->get('id',0));
        $condition = self::_getCondition($name);

        $data = App::getIndexData($condition, $start,$length);
        $count = App::getIndexCount($condition);
        $tabledata = [];
        foreach($data as $value){
            $tabledata[] = [
                MyHtml::aElement('javascript:void(0);' ,'showApp', $value['id'],'[' .$value['id'].'] '.$value['name']),
                $value['packageName'],
                $value['versionName'],
                Utils::formatNumToSize($value['size']),
                MyHtml::aElement("javascript:void(0);". $value['id'], '','','活动管理')
            ];
        }

       // $partnerName = ($id > 0) ?  Partner::getNameById($id) : '';
        $data = [
            'searchData' => [
                //'partnerName' => $partnerName
            ],
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'tableData' => $tabledata,
        ];
        Utils::jsonOut($data);
        exit;
    }

    private function _getCondition($name){
        $condition[] = 'and';
        $condition[] = [
            '=',
            'app.deleted',
            0
        ];

        $condition[] = [
            '=',
            'partner.belong',
            1
        ];


        if($name!== ''){
            $condition[] = [
                'like',
                'partner.name',
                $name
            ];
        }

      /*  if($id !== 0){
            $condition[] = [
                '=',
                'app.id',
                $id
            ];
        }*/

        return $condition;
    }
}
