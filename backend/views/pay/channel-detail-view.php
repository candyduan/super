<style>
.col-xs-2,.col-xs-1,.col-xs-6,.col-xs-12{padding-left:0px;}
</style>
<ol class="breadcrumb">
<li><a href="/pay/channel-view">通道管理</a></li>
<li class="active">详情</li>
<li class="channelName"></li>
</ol>
<?php 
if($chid > 0){
    echo backend\library\widgets\WidgetsUtils::getChannelQuickIn($chid);
}else{
    
}

?>
<h1 class="header-1">开发中，千万别着急。。。</h1>
<div class="main" style="display: none;">
    <div class="col-xs-6">
        <label class="col-xs-2" for="merchant">通道商：</label>
        <div class="col-xs-10" id="merchant">ddddddddd</div>
    </div>
    <div class="col-xs-6">
        <label class="col-xs-2">通道状态：</label>
        <div class="col-xs-10">ddddddddd</div>
    </div>
    <div class="col-xs-6">
        <label class="col-xs-2">通道名称：</label>
        <div class="col-xs-10">ddddddddd</div>
    </div>
    
     <div class="col-xs-6">
        <label class="col-xs-2">固定价格：</label>
        <div class="col-xs-10">ddddddddd</div>
    </div>   
     <div class="col-xs-6">
        <label class="col-xs-2">通道标识：</label>
        <div class="col-xs-10">ddddddddd</div>
    </div>      
     <div class="col-xs-6">
        <label class="col-xs-2">SP拿价：</label>
        <div class="col-xs-10">ddddddddd</div>
    </div>   
     <div class="col-xs-6">
        <label class="col-xs-2">黑白名单：</label>
        <div class="col-xs-10">ddddddddd</div>
    </div>      
     <div class="col-xs-6">
        <label class="col-xs-2">日限额：</label>
        <div class="col-xs-10">ddddddddd</div>
    </div>  
     <div class="col-xs-6">
        <label class="col-xs-2">运营商：</label>
        <div class="col-xs-10">ddddddddd</div>
    </div>      
     <div class="col-xs-6">
        <label class="col-xs-2">月限额：</label>
        <div class="col-xs-10">ddddddddd</div>
    </div> 
    
    <div class="col-xs-6">
        <label class="col-xs-2">需要手机号：</label>
        <div class="col-xs-10">ddddddddd</div>
    </div>      
     <div class="col-xs-6">
        <label class="col-xs-2">用户日限额：</label>
        <div class="col-xs-10">ddddddddd</div>
    </div> 
    
    <div class="col-xs-6">
        <label class="col-xs-2">固定优先级：</label>
        <div class="col-xs-10">ddddddddd</div>
    </div>      
     <div class="col-xs-6">
        <label class="col-xs-2">用户月限额：</label>
        <div class="col-xs-10">ddddddddd</div>
    </div>   
      
    <div class="col-xs-6">
        <label class="col-xs-2">优先级：</label>
        <div class="col-xs-10">ddddddddd</div>
    </div>      
     <div class="col-xs-6">
        <label class="col-xs-2">解冻时间：</label>
        <div class="col-xs-10">ddddddddd</div>
    </div> 

    <div class="col-xs-6">
        <label class="col-xs-2">风控数量：</label>
        <div class="col-xs-10">ddddddddd</div>
    </div>      
     <div class="col-xs-6">
        <label class="col-xs-2">冷却时间：</label>
        <div class="col-xs-10">ddddddddd</div>
    </div> 

    <div class="col-xs-6">
        <label class="col-xs-2">优化比例：</label>
        <div class="col-xs-10">ddddddddd</div>
    </div>      
     <div class="col-xs-6">
        <label class="col-xs-2">开发类型：</label>
        <div class="col-xs-10">ddddddddd</div>
    </div> 

    <div class="col-xs-6">
        <label class="col-xs-2">最低SDK版本：</label>
        <div class="col-xs-10">ddddddddd</div>
    </div>      
     <div class="col-xs-6">
        <label class="col-xs-2">可用于审核：</label>
        <div class="col-xs-10">ddddddddd</div>
    </div>     

    <div class="col-xs-6">
        <label class="col-xs-2">SDK版本限制：</label>
        <div class="col-xs-10">ddddddddd</div>
    </div>      
     <div class="col-xs-6">
        <label class="col-xs-2">级别：</label>
        <div class="col-xs-10">ddddddddd</div>
    </div>  

    <div class="col-xs-6">
        <label class="col-xs-2">SP同步地址：</label>
        <div class="col-xs-10">ddddddddd</div>
    </div>      
     <div class="col-xs-6">
        <label class="col-xs-2">同步返回值：</label>
        <div class="col-xs-10">ddddddddd</div>
    </div>  
    
    <div class="col-xs-12">
     <label class="col-xs-1">备注：</label>
     <div class="col-xs-11">ddddddddd</div>
    </div>

	<div class="clearfix"></div><hr>
    <div class="col-xs-12">
    <button class="btn btn-default">保存</button>
    </div>
</div>
<script>
$(document).ready(function(){
	var chid = Utils.getQueryString('chid');
	if(parseInt(chid) > 0){//change
		var url = '/pay/channel-detail-view';
		var data='chid='+chid;
		var succ=function(resJson){

		};
	}else{//new

	}
});
</script>