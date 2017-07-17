<style>
.hour{width:60px;height:60px;border-radius:30px;margin-right:10px;margin-bottom:10px;line-height:60px;text-align:center;font-weight:bold;display:inline-block;}
</style>
<ol class="breadcrumb">
<li><a href="/pay/channel-view">通道管理</a></li>
<li class="active">时段</li>
<li class="channelName"></li>
</ol>

<div class="main">
	<div>
    <?php for($i=0;$i<=23;$i++){ ?>
    <div class="hour" id="h<?php echo $i;?>" data-val=""><?php echo $i;?></div>
    <?php }?>
    </div>
    <button class="btn btn-default timeLimitSave">提交</button>
</div>
<script>
$(document).ready(function(){
	setResult();
});
function setResult(){
	var url = '/pay/channel-time-limit-result';
	var data='chid='+Utils.getQueryString('chid');
	var succ= function(resJson){
		$('.channelName').html(resJson.channel.name);
		$('#h0').attr('data-val',resJson.timeLimit.h0);
		$('#h1').attr('data-val',resJson.timeLimit.h1);
		$('#h2').attr('data-val',resJson.timeLimit.h2);
		$('#h3').attr('data-val',resJson.timeLimit.h3);
		$('#h4').attr('data-val',resJson.timeLimit.h4);
		$('#h5').attr('data-val',resJson.timeLimit.h5);
		$('#h6').attr('data-val',resJson.timeLimit.h6);
		$('#h7').attr('data-val',resJson.timeLimit.h7);
		$('#h8').attr('data-val',resJson.timeLimit.h8);
		$('#h9').attr('data-val',resJson.timeLimit.h9);
		$('#h10').attr('data-val',resJson.timeLimit.h10);
		$('#h11').attr('data-val',resJson.timeLimit.h11);
		$('#h12').attr('data-val',resJson.timeLimit.h12);
		$('#h13').attr('data-val',resJson.timeLimit.h13);
		$('#h14').attr('data-val',resJson.timeLimit.h14);
		$('#h15').attr('data-val',resJson.timeLimit.h15);
		$('#h16').attr('data-val',resJson.timeLimit.h16);
		$('#h17').attr('data-val',resJson.timeLimit.h17);
		$('#h18').attr('data-val',resJson.timeLimit.h18);
		$('#h19').attr('data-val',resJson.timeLimit.h19);
		$('#h20').attr('data-val',resJson.timeLimit.h20);
		$('#h21').attr('data-val',resJson.timeLimit.h21);
		$('#h22').attr('data-val',resJson.timeLimit.h22);
		$('#h23').attr('data-val',resJson.timeLimit.h23);

		$.each($('.hour'),function(hkey,hval){
			if(parseInt($(this).attr('data-val')) == 0){
				$(this).addClass('swhour-open');
			}else{
				$(this).addClass('swhour-close');
			}
		});
		$('.hour').click(function(){
			if(parseInt($(this).attr('data-val')) == 0){
				$(this).attr('data-val',1);
				$(this).removeClass('swhour-open');
				$(this).addClass('swhour-close');
			}else{
				$(this).attr('data-val',0);
				$(this).removeClass('swhour-close');
				$(this).addClass('swhour-open');
			}
		});
	};
	Utils.ajax(url,data,succ);

	$('.timeLimitSave').click(function(){
		var url = '/pay/channel-time-limit-save';
		var data= 'chid='+Utils.getQueryString('chid')
				+'&h0='+$('#h0').attr('data-val')
				+'&h1='+$('#h1').attr('data-val')
				+'&h2='+$('#h2').attr('data-val')
				+'&h3='+$('#h3').attr('data-val')
				+'&h4='+$('#h4').attr('data-val')
				+'&h5='+$('#h5').attr('data-val')
				+'&h6='+$('#h6').attr('data-val')
				+'&h7='+$('#h7').attr('data-val')
				+'&h8='+$('#h8').attr('data-val')
				+'&h9='+$('#h9').attr('data-val')
				+'&h10='+$('#h10').attr('data-val')
				+'&h11='+$('#h11').attr('data-val')
				+'&h12='+$('#h12').attr('data-val')
				+'&h13='+$('#h13').attr('data-val')
				+'&h14='+$('#h14').attr('data-val')
				+'&h15='+$('#h15').attr('data-val')
				+'&h16='+$('#h16').attr('data-val')
				+'&h17='+$('#h17').attr('data-val')
				+'&h18='+$('#h18').attr('data-val')
				+'&h19='+$('#h19').attr('data-val')
				+'&h20='+$('#h20').attr('data-val')
				+'&h21='+$('#h21').attr('data-val')
				+'&h22='+$('#h22').attr('data-val')
				+'&h23='+$('#h23').attr('data-val');
		var succ= function(resJson){
			if(parseInt(resJson.resultCode) == 1){//succ
				Utils.tipBar('success','设置成功',resJson.msg);
			}else{//fail
				Utils.tipBar('error','设置失败',resJson.msg);
			}
		};
		Utils.ajax(url,data,succ);
	});
};
</script>