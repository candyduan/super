<style>
pre{background-color:#f0f0f0;color:#00a600;}
</style>
<ol class="breadcrumb">
<li class=""><a href="/pay/channel-view">通道管理</a></li>
<li class="active">日志</li>
<li class="channelName"></li>
</ol>
<?php echo backend\library\widgets\WidgetsUtils::getChannelQuickIn($chid);?>
<div class="main">
    <div class="logContents">
    </div>
    <div class="row">
    	<div class="col-xs-2"><button class="interval_ops btn btn-default btn-block">暂停</button></div>
    	<div class="col-xs-2"><a class="download_log_today btn btn-default btn-block" href="http://120.27.153.169:82/index.php/tools/log?chid=<?php echo $chid;?>">今日日志</a></div>
    	<div class="col-xs-2"><a class="download_log_all btn btn-default btn-block" href="http://120.27.153.169:8000/" target="_blank">全部日志</a></div>
    </div>
</div>
<script>
$(document).ready(function(){
	Utils.setChannelName();
	setResult();
	var timeId = setInterval('setResult()',3000); 

	$('.interval_ops').click(function(){
		var opsName	= $('.interval_ops').html();
		if(opsName == '暂停'){
			clearInterval(timeId);
			$('.interval_ops').html('继续');
		}else{
			timeId = setInterval('setResult()',3000); 
			$('.interval_ops').html('暂停');
		}
	});
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