<style>
.main{margin-top:15%;}
.func-module{cursor:pointer;height:150px;line-height:150px;border:2px solid #ffffbb;text-align:center;display:inline-block;margin-top:10px;margin-bottom:10px;font-size:20px;}
body{
	background-image:url(/imgs/bg_dashboard.jpeg);
	background-size:cover;
}
</style>
<div class="main">
<div class="col-xs-3 func-module func-paysdk">支付SDK</div>
<div class="col-xs-3 func-module func-mop-sdk">融合SDK</div>
<div class="col-xs-3 func-module func-register">主动上行</div>
<div class="col-xs-3 func-module func-agency">注册中介</div>
<div class="col-xs-3 func-module func-system">系统管理</div>
<div class="col-xs-3 func-module func-other">其它功能</div>
</div>
<script>
$(document).ready(function(){
	$('.func-system').click(function(){
		window.location.href='/system/index';
	});
	$('.func-mop-sdk').click(function(){
		window.location.href='/site/index';
	});
	$('.func-register').click(function(){
		window.location.href="/register/index";
	});
	$('.func-agency').click(function(){
		window.location.href="/agency/index";
	});
	$('.func-paysdk').click(function(){
		window.location.href="http://master.maimob.cn/index.php/admin/";
	});
});
</script>