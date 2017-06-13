<style>
.channel-config-entrance{font-size:18px;cursor:pointer;}
</style>
<ol class="breadcrumb">
<li class="active">通道配置</li>
</ol>
<div class="main">
	<!-- 搜索栏 -->
	<div class="form-inline searchbar">	
		  <?php echo backend\library\widgets\WidgetsUtils::getSearchMerchant();?>
		  <?php echo backend\library\widgets\WidgetsUtils::getSearchPayChannel();?>
          <button type="submit" class="btn btn-default searchbar_smt" id="search"> 搜索 </button>
	</div>
	
    <!-- 数据栏 -->
    <div class="databar">
    	<table class="table table-bordered table-hover">
    	<thead><tr><td>通道商</td><td>通道</td><td>负责人</td><td>运营商</td><td>DEV类型</td><td>状态</td><td>操作</td><td>配、手</td></tr></thead>
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
	var url ='/pay/channel-result';
	//data
	var data = 'chid='+$('#channel').val()+'&mid='+$('#merchant').val()+'&page='+page;
	//succ
	var succ	= function(resultJson){
		if(parseInt(resultJson.resultCode) == 1){
			resultHtml = '';

            $.each(resultJson.list,function(key,val){
                var cfgMainBtnName;
                if(parseInt(val.mainStatus) == 1){
                	cfgMainBtnName = '配';
                }else{
                	cfgMainBtnName = '手';
                }
                resultHtml = resultHtml + '<tr><td>'+val.merchant+'</td><td>'+val.name+'</td><td>'+val.holder+'</td><td>'+val.provider+'</td><td>'+val.devType+'</td><td>'+val.status+'</td><td><a data-devtypeid="'+val.devTypeId+'" data-chid="'+val.chid+'" class="glyphicon glyphicon-cog channel-config-entrance"></a></td><td><button class="cfgMainStatus btn" data-chid='+val.chid+'>'+cfgMainBtnName+'</button></td></tr>';
            });
            $('#data_list').html(resultHtml);
            $('.cfgMainStatus').click(function(){
				if(confirm("确认要改变此状态吗？")){
					var chid = $(this).attr('data-chid');
					//url
					var mainStatusUrl = '/pay/cfg-main-status';
					//data
					var mainStatusData = 'chid='+chid;
					//succ
					var mainStatusSucc = function(mainStatusJson){
//	 					console.log(mainStatusJson);
						if(parseInt(mainStatusJson.resultCode) == 1){
							alert(mainStatusJson.msg);
							setResult($('.pager_number_selected').attr('page'));
						}else{
							alert(mainStatusJson.msg);
						}
					};
					Utils.ajax(mainStatusUrl,mainStatusData,mainStatusSucc);
				}
            });
            $('.channel-config-entrance').click(function(){
				var devType	= parseInt($(this).attr('data-devtypeid'));
				var chid	= $(this).attr('data-chid');
				var url;
				switch(devType){
				case 1:
					url	= '/pay/cfg-sd-view?chid='+chid;
					break;
				case 2:
					url	= '/pay/cfg-sd-view?chid='+chid;
					break;
				case 3:
					url = '/pay/cfg-sms-view?chid='+chid;
					break;
				case 4:
					url = '/pay/cfg-url-view?chid='+chid;
					break;
				default:
					alert("请设置DEV类型，或该通道目前暂不支持配置化！");
					return;
				}

				window.location.href=url;
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