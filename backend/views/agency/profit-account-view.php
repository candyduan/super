<ol class="breadcrumb">
<li class="active"><i class="fa fa-dashboard"></i>收益列表</li>
</ol>
<div class="main">
	<!-- 搜索栏 -->
	<div class="form-inline searchbar">	
		  <?php echo backend\library\widgets\WidgetsUtils::getSearchTime();?>
    	  <?php echo backend\library\widgets\WidgetsUtils::getAgencyAccount();?>
          <button type="submit" class="btn btn-default searchbar_smt" id="search"> 搜索 </button>
	</div>
	
    <!-- 数据栏 -->
    <div class="databar">
    	<table class="table table-bordered table-hover" >
    	<thead><tr><td>日期</td><td>客户</td><td>成功</td><td>失败</td><td>转化率</td></tr></thead>
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
	var url ='/agency/profit-account-result';
	//data
	var data = 'stime='+$('.search-stime').val()+'&etime='+$('.search-etime').val()+'&aaid='+$('.agency-account').val()+'&page='+page;
	//succ
	var succ	= function(resultJson){
		if(parseInt(resultJson.resultCode) == 1){
			resultHtml = '';
            $.each(resultJson.list,function(key,val){
                resultHtml = resultHtml + '<tr><td>'+val.day+'</td><td>'+val.account+'</td><td>'+val.succ+'</td><td>'+val.fail+'</td><td>'+val.rate+'</td></tr>';
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
