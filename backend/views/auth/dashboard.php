<style>
.main{margin-top:15%;}
.func-module{cursor:pointer;height:150px;line-height:150px;border:3px solid #ffffbb;box-shadow: 5px 5px 5px #ffffbb;text-align:center;width:33%;display:inline-block;margin-top:10px;margin-bottom:10px;font-size:20px;}
body{
	background-image:url(/imgs/bg_dashboard.jpeg);
	background-size:cover;
}
</style>
<div class="main">
<div class="func-module func-paysdk">支付SDK</div>
<div class="func-module func-mop-sdk">融合SDK</div>
<div class="func-module func-register">主动上行</div>
<div class="func-module func-agency">注册中介</div>
<div class="func-module func-other">其它功能</div>
<div class="func-module func-other">其它功能</div>
</div>
<script>
$(document).ready(function(){
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