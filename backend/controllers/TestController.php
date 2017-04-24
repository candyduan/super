<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;

/**
 * Test controller
 */
class TestController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAjaxIndex(){
        $tableData[] = [
            1,
            2,
            3,
            4,
            5,
        ];
        $data = [
            'searchData' => [

            ],
            'recordsTotal' => 1,
            'recordsFiltered' => 1,
            'tableData' => $tableData,
        ];
       echo json_encode($data);
       exit;
    }

}
