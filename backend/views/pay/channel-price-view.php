<style>
.hour{width:60px;height:60px;border-radius:30px;margin-right:10px;margin-bottom:10px;line-height:60px;text-align:center;font-weight:bold;display:inline-block;}
.channelPriceBtn{cursor:pointer;}
</style>
<ol class="breadcrumb">
<li><a href="/pay/channel-view">通道管理</a></li>
<li class="active">价目</li>
<li class="channelName"></li>
</ol>
<?php echo backend\library\widgets\WidgetsUtils::getChannelQuickIn($chid);?>
<div class="main">

	<!-- 搜索栏 -->
	<div class="form-inline searchbar">	
		  	<div class="form-group">
    		  <select class="form-control" id="channel_price">
        		<option value="0">-- 请选择金额 --</option>
        		<option value="2000">-- 20元 --</option>
        		<option value="1500">-- 15元 --</option>
        		<option value="1000">-- 10元 --</option>
        		<option value="900">-- 09元 --</option>
        		<option value="800">-- 08元 --</option>
        		<option value="700">-- 07元 --</option>
        		<option value="600">-- 06元 --</option>
        		<option value="500">-- 05元 --</option>
        		<option value="400">-- 04元 --</option>
        		<option value="300">-- 03元 --</option>
        		<option value="200">-- 02元 --</option>
        		<option value="100">-- 01元 --</option>
        	 </select>
    	  </div>
          <div class="form-control"><a class="glyphicon glyphicon-plus addChannelPrice"></a></div>
	</div>
    <!-- 数据栏 -->
    <div class="databar">
    	<table class="table table-bordered table-hover">
    	<thead><tr><td>ID</td><td>价格</td><td>更新时间</td><td>管理</td></tr></thead>
    	<tbody id="data_list"></tbody>
    	</table>
    </div>
    
</div>
<script>
$(document).ready(function(){
	setResult();

	$('.addChannelPrice').click(function(){
		var url = '/pay/channel-price-save';
		var data='chid='+Utils.getQueryString('chid')+'&price='+$('#channel_price').val();
		var succ= function(resJson){
			if(parseInt(resJson.resultCode) == 1){
				Utils.tipBar('success','加入成功',resJson.msg);
				setResult();
			}else{
				Utils.tipBar('error','加入失败',resJson.msg);
			}
		};
		Utils.ajax(url,data,succ);
	});
});
function setResult(){
	var url ="/pay/channel-price-result";
	var data='chid='+Utils.getQueryString('chid');
	var succ= function(resJson){
			if(parseInt(resJson.resultCode) == 1){
				$('.channelName').html(resJson.channel.name);
                var resultHtml = '';
                $.each(resJson.list,function(key,val){
                    var opsBtnName;
                    if(parseInt(val.status) == 0){
						opsBtnName	= '😄';
                    }else{
                    	opsBtnName	= '😭';
                    }
                   resultHtml = resultHtml + '<tr><td>'+val.id+'</td><td>'+val.price/100+'元</td><td>'+val.updateTime+'</td><td><a class="channelPriceBtn glyphicon" data-cpid="'+val.id+'">'+opsBtnName+'</a></td></tr>';
                });
                $('#data_list').html(resultHtml);
                $('.channelPriceBtn').click(function(){
					var opsUrl	= '/pay/channel-price-ops';
					var opsData = 'chid='+Utils.getQueryString('chid')+'&cpid='+$(this).attr('data-cpid');
					var opsSucc	= function(opsJson){
						if(parseInt(opsJson.resultCode) == 1){
							Utils.tipBar('success','更新成功',opsJson.msg);
							setResult();
						}else{
							Utils.tipBar('error','更新失败',opsJson.msg);
						}
					};
					Utils.ajax(opsUrl,opsData,opsSucc);
                });
			}else{
				$('#data_list').html(resJson.msg);
			}
		};
		Utils.ajax(url,data,succ);
};
</script>