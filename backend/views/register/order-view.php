<?php
use backend\library\widgets\WidgetsUtils;
?>
<ol class="breadcrumb">
<li class="active"><i class="fa fa-dashboard"></i>注册订单查询</li>
</ol>
<div class="main">
	<!-- 搜索栏 -->
	<div class="form-inline searchbar">	
		  <?php echo WidgetsUtils::getSearchTime();?>
		  <?php echo WidgetsUtils::getSearchRegChannel();?>
          <div class="form-group"><input type="text" class="form-control mobile-imsi"   placeholder="手机号/imsi"></div>
          <button type="submit" class="btn btn-default searchbar_smt" id="search"> 搜索 </button>
	</div>
	
    <!-- 数据栏 -->
    <div class="databar">
    	<table class="table table-bordered table-hover">
    	<thead><tr><td>ID</td><td>IMSI</td><td>手机号</td><td>通道</td><td>透传</td><td>注册时间</td><td>状态</td><td>操作</td></tr></thead>
    	<tbody id="data_list"></tbody>
    	</table>
    </div>
    
    <!-- 分页 -->
	<div class=""><nav><ul class="pager"></ul></nav></div>
</div>

<script>
$(document).ready(function(){
	setResult(1);    
	$('#search').click(function(){
		setResult(1);
    });
});
function setResult(page){
	//url
	var url ='/register/order-result';
	//data
	var data = 'stime='+$('.search-stime').val()+'&etime='+$('.search-etime').val()+'&rcid='+$('#channel').val()+'&mobile-imsi='+$('.mobile-imsi').val();
	//succ
	var succ	= function(resultJson){
		if(parseInt(resultJson.resultCode) == 1){
			resultHtml = '';

            $.each(resultJson.list,function(key,val){
                resultHtml = resultHtml + '<tr><td>'+val.roid+'</td><td>'+val.imsi+'</td><td>'+val.mobile+'</td><td>'+val.channelName+'</td><td>'+val.spSign+'</td><td>'+val.recordTime+'</td><td>'+val.status+'</td><td><button data-roid="'+val.roid+'" class="btn btn-default btn-del">删除</button></td></tr>';
            });
            $('#data_list').html(resultHtml);
            $('.btn-del').click(function(){
                var r   = confirm("您确定要删除该订单吗？");
                if(!r){
                    return;
                }
                var delurl = '/register/order-del';
                var deldata='roid='+$(this).attr('data-roid');
                var delsucc= function(delJson){
					if(parseInt(delJson.resultCode) == 1){
						setResult(page);
					}else{
						alert(delJson.msg);
					}
                };
                Utils.ajax(delurl,deldata,delsucc);
            });
            Utils.setPagination(page,resultJson.pages);
            $(".pager_number").click(function(){
                setResult($(this).attr('page'));
            });
        
		}else{
			$('#data_list').html(resultJson.msg);
		}		
	};

	Utils.ajax(url,data,succ);
}
</script>


