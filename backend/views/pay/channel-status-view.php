<style>
.col-xs-3{padding-left:0px;margin-top:5px;margin-bottom:5px;}
.channelStatusSelected{background-color:#ff5151 !important;color:#000000;}
</style>
<ol class="breadcrumb">
<li><a href="/pay/channel-view">通道管理</a></li>
<li class="active">状态</li>
<li class="channelName"></li>
</ol>
<?php echo backend\library\widgets\WidgetsUtils::getChannelQuickIn($chid);?>
<div class="main">
     <div class="col-xs-3"><button class="btn btn-default btn-block channelStatusBtn" data-status="0">可用</button></div>
     <div class="clearfix"></div>
     <div class="col-xs-3"><button class="btn btn-default btn-block channelStatusBtn" data-status="1">暂停</button></div>
     <div class="clearfix"></div>
     <div class="col-xs-3"><button class="btn btn-default btn-block channelStatusBtn" data-status="2">删除</button></div>
     <div class="clearfix"></div>
     <div class="col-xs-3"><button class="btn btn-default btn-block channelStatusBtn" data-status="3">测试</button></div>
     <div class="clearfix"></div>
     <div class="col-xs-3"><input type="text" class="form-control channelStatusCfm" placeholder="请输入ok确认你的行为" ></input></div>
     <div class="clearfix"></div><hr>
     <div class="col-xs-3"><button class="btn btn-default btn-block channelStatusSubmit">提交</button></div>
</div>
<script>
$(document).ready(function(){
	setResult();
	$('.channelStatusBtn').click(function(){
		$('.channelStatusBtn').removeClass('channelStatusSelected');
		$(this).addClass('channelStatusSelected');
	});

	$('.channelStatusSubmit').click(function(){
		var channelStatus	= $('.channelStatusSelected').attr('data-status');
		if(channelStatus != '0' && channelStatus != '1' && channelStatus != '2' && channelStatus != '3'){
			Utils.tipBar('error','警告','请选择通道状态！');
			return;
		}
		var channelStatusCfm	= $('.channelStatusCfm').val();
		if(channelStatusCfm != 'ok'){
			Utils.tipBar('error','警告','请输入ok确认你的行为！');
			return;
		}
		var url = '/pay/channel-status-set';
		var data= 'chid='+Utils.getQueryString('chid') +'&status='+channelStatus;
		var succ=function(resJson){
			if(parseInt(resJson.resultCode) == 1){
				Utils.tipBar('success','设置成功',resJson.msg);
			}else{
				Utils.tipBar('error','设置失败',resJson.msg);
			}
		};
		Utils.ajax(url,data,succ);
	});
});
function setResult(){
	var url = '/pay/channel-status-result';
	var data='chid='+Utils.getQueryString('chid');
	var succ=function(resJson){
			$('.channelName').html(resJson.channel.name);
			$.each($('.channelStatusBtn'),function(key,val){
				if($(val).html() == resJson.channel.status){
					$(val).addClass('channelStatusSelected');
				}
			});
		};
	Utils.ajax(url,data,succ);
};
</script>