<?php 
use backend\library\widgets\PayCfgWidgets;

$channelModel   = $channelModel;
$mainModel      = $mainModel;
$payParamsModel = $payParamsModel;
$smsModel       = $smsModel;
$smsYApiModel   = $smsYApiModel;
$smsNApiModel   = $smsNApiModel;
$syncModel      = $syncModel;
$smtParamsModel = $smtParamsModel;
?>
<ol class="breadcrumb">
<li>通道配置</li>
<li class="active"><?php echo '['.$channelModel->id.']'.$channelModel->name;?></li>
</ol>

<div class="main">
<!-- 标题 -->
<?php echo PayCfgWidgets::getCfgCommonWidget($channelModel);?>
    <h1 class="header-1">全局设置</h1>
    <div class="main_content row">
    	<div class="col-xs-6">
    	<button class="btn btn-block btn-yapi btn-default">使用API</button>
    	</div>
    	<div class="col-xs-6">
    	<button class="btn btn-block btn-napi btn-default">固定指令</button>
    	</div>
    </div>
    
	<!-- 使用api -->
    <div class="sms_yapi" api="1">
    <hr>
    	<h1 class="header-1">支付请求通用设置</h1>
    	<div class="sms_yapi_content">
        	<div class="form-horizontal">    
        	</div>
        </div>
    </div>    
    
    	<!-- 固定指令 -->
    <div class="sms_yapi" api="1">
    <hr>
    	<h1 class="header-1">支付参数设置</h1>
    	<div class="sms_yapi_content">
        	<div class="form-horizontal">    
        	</div>
        </div>
    </div>
</div>