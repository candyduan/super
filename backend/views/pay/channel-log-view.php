<style>
pre{background-color:#f0f0f0;color:#00a600;}
</style>
<ol class="breadcrumb">
<li class=""><a href="/pay/channel-view">通道配置</a></li>
<li class="active">通道日志查询</li>
</ol>
<div class="main">
    <div class="logContents">
    </div>
</div>
<script>
$(document).ready(function(){
	setResult();
	setInterval('setResult()',3000); 
});
function setResult(){
	//url
	var url = 'http://120.27.153.169:82/index.php/tools/readChannelLog';
	//data
	var data = 'chid='+Utils.getQueryString('chid');
	//succ
	var succ = function(resJson){
		$('.logContents').html('<pre>'+resJson.text+'</pre>');
	};
	Utils.jsonp(url,data,succ);
};
</script>