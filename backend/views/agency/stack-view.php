<ol class="breadcrumb">
<li class="active"><i class="fa fa-dashboard"></i>注册栈查询</li>
</ol>
<div class="main">
	<!-- 搜索栏 -->
	<div class="form-inline searchbar">	
		  <?php echo backend\library\widgets\WidgetsUtils::getSearchTime();?>
		  <div class="form-group"><input type="text" class="form-control mobile"   placeholder="手机号"></div>
    	  <?php echo backend\library\widgets\WidgetsUtils::getAgencyAccount();?>
          <button type="submit" class="btn btn-default searchbar_smt" id="search"> 搜索 </button>
	</div>
	
    <!-- 数据栏 -->
    <div class="databar">
    	<table class="table table-bordered table-hover" >
    	<thead><tr><td>ID</td><td>IMSI</td><td>手机号</td><td>验证码</td><td>注册商</td><td>注册时间</td><td>状态</td></tr></thead>
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
	var url ='/agency/stack-result';
	//data
	var data = 'stime='+$('.search-stime').val()+'&etime='+$('.search-etime').val()+'&aaid='+$('.agency-account').val()+'&mobile='+$('.mobile').val()+'&page='+page;
	//succ
	var succ	= function(resultJson){
		if(parseInt(resultJson.resultCode) == 1){
			resultHtml = '';

            $.each(resultJson.list,function(key,val){
                resultHtml = resultHtml + '<tr><td>'+val.asid+'</td><td>'+val.imsi+'</td><td>'+val.mobile+'</td><td>'+val.verifyCode+'</td><td>'+val.account+'</td><td>'+val.time+'</td><td>'+val.status+'</td></tr>';
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