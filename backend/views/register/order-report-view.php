<ol class="breadcrumb">
<li class="active"><i class="fa fa-dashboard"></i>注册日志查询</li>
</ol>
<div class="main">
	<!-- 搜索栏 -->
	<div class="form-inline searchbar">	
		  <?php echo backend\library\widgets\WidgetsUtils::getSearchTime();?>
		  <?php echo backend\library\widgets\WidgetsUtils::getSearchChannel();?>
          <div class="form-group"><input type="text" class="form-control mobile-imsi"   placeholder="手机号/imsi"></div>
          <button type="submit" class="btn btn-default searchbar_smt" id="search"> 搜索 </button>
	</div>
	
    <!-- 数据栏 -->
    <div class="databar">
    	<table class="table table-bordered table-hover" id="data_list">
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
	var url ='/register/order-report-result';
	//data
	var data = 'stime='+$('.search-stime').val()+'&etime='+$('.search-etime').val()+'&rcid='+$('#channel').val()+'&mobile-imsi='+$('.mobile-imsi').val();
	//succ
	var succ	= function(resultJson){
		if(parseInt(resultJson.resultCode) == 1){
			resultHtml = '<tr><td>订单ID</td><td>IMSI</td><td>手机号</td><td>通道</td><td>通道类型</td><td>日志类型</td><td>recv</td><td>send</td><td>时间</td></tr>';

            $.each(resultJson.list,function(key,val){
                resultHtml = resultHtml + '<tr><td>'+val.roid+'</td><td>'+val.imsi+'</td><td>'+val.mobile+'</td><td>'+val.channel+'</td><td>'+val.devType+'</td><td>'+val.type+'</td><td>'+val.recv+'</td><td>'+val.send+'</td><td>'+val.time+'</td></tr>';
            });
            $('#data_list').html(resultHtml);
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


