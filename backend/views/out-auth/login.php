<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
use \backend\web\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
AppAsset::register($this);


?>
<!doctype html>
<html lang="zh-cn">
<head>
    <?php $this->head(); ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="shortcut icon" href="/imgs/favicon.ico" />
    <title>麦广互娱客户登录后台</title>
    <meta charset="utf-8" />
</head>
<body style="margin-top: 100px">

<div class="container">
    <div class="row">
        <div class="col-sm-4 col-md-4 col-lg-4"></div>
        <div class="col-sm-4 col-md-4 col-lg-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="inline">
                    <span class="glyphicon glyphicon-leaf"></span>
                        <span class="panel-title">客户登陆</span>
                    </div>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(['id' => 'out-login-form']); ?>
                    <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => '用户名']) ?>
                    <?= $form->field($model, 'password')->passwordInput(['placeholder' => '密码']) ?>
                    <?= $form->field($model, 'rememberMe')->checkbox() ?>
                    <div class="form-group">
                        <?= Html::submitButton(' 登陆', ['class' => 'btn btn-primary glyphicon glyphicon-hand-right', 'name' => 'login-button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-md-4 col-lg-4"></div>
    </div>
</div>



</div>
</body>
</html>