<style>
.channel-config-entrance{font-size:18px;cursor:pointer;}
.chgDevType{cursor:pointer;}
</style>
<ol class="breadcrumb">
<li class="active">通道配置</li>
</ol>
<div class="main">
	<!-- 搜索栏 -->
	<div class="form-inline searchbar">	
		  <?php echo backend\library\widgets\WidgetsUtils::getSearchMerchant();?>
		  <?php echo backend\library\widgets\WidgetsUtils::getSearchPayChannel();?>
		  
		  <div class="form-group">
    		  <select class="form-control" id="channel_status">
        		<option value="-1">-- 通道状态 --</option>
        		<option value="0">-- 可用 --</option>
        		<option value="1">-- 暂停 --</option>
        		<option value="2">-- 删除 --</option>
        		<option value="3">-- 测试 --</option>
        	 </select>
    	  </div>
    	  
          <button type="submit" class="btn btn-default searchbar_smt" id="search"> 搜索 </button>
	</div>
	
    <!-- 数据栏 -->
    <div class="databar">
    	<table class="table table-bordered table-hover">
    	<thead><tr><td>通道商</td><td>通道</td><td>标识</td><td>负责人</td><td>运营商</td><td>DEV类型</td><td>状态</td><td>操作</td><td>日志</td><td>方式</td></tr></thead>
    	<tbody id="data_list"></tbody>
    	</table>
    </div>
    
    <!-- 分页 -->
	<div class=""><nav><ul class="pager"></ul></nav></div>
	
	
	<div class="modal-chgDevType modal fade" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">更改通道开发类型</h4>
	      </div>
	      <div class="modal-body">
	        <p>
	        	<select class='confrimDevType form-control' style="width:120px;margin-left:30%;">
					<option value='1'>Single</option>
					<option value='2'>Double</option>
					<option value='3'>SMS+</option>
					<option value='4'>Url+</option>
				</select>
	        </p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary btnChgDevType">保存</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


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
    var mid = $('#merchant').val();
    if(mid == ''){
    	mid  = Utils.getQueryString('mid');
    }
  	var merchantId  = mid;
	var data = 'chid='+$('#channel').val()+'&mid='+merchantId+'&page='+page+'&channelStatus='+$('#channel_status').val();
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
                var statusClass = '';
                switch(val.status){
                	case '可用':
                		statusClass = 'channel_used';
                    	break;
                	case '暂停':
                		statusClass = 'channel_suspend';
                    	break;
                	case '删除':
                		statusClass = 'channel_delete';
                    	break;
                }
                resultHtml = resultHtml + '<tr><td>'+val.merchant+'</td><td>'+val.name+'</td><td>'+val.sign+'</td><td>'+val.holder+'</td><td>'+val.provider+'</td><td><a class="chgDevType" data-chid="'+val.chid+'">'+val.devType+'</a></td><td class="'+statusClass+'">'+val.status+'</td><td><a data-devtypeid="'+val.devTypeId+'" data-chid="'+val.chid+'" class="glyphicon glyphicon-cog channel-config-entrance"></a></td><td><a class="glyphicon glyphicon-cog glyphicon-eye-open" href="/pay/channel-log-view?chid='+val.chid+'"></a></td><td><button class="cfgMainStatus btn" data-chid='+val.chid+'>'+cfgMainBtnName+'</button></td></tr>';
            });
            $('#data_list').html(resultHtml);

            $('.chgDevType').click(function(){
				var chid = $(this).attr('data-chid');
				$('.modal-chgDevType').modal('show');
				$('.btnChgDevType').unbind('click');
				$('.btnChgDevType').click(function(){
						$('.modal-chgDevType').modal('hide');
		        		//url
						var devTypeUrl = '/pay/channel-dev-type';
						//data
						var devTypeData = 'chid='+chid+'&devType='+$('.confrimDevType').val();
						//succ
						var devTypeSucc = function(devTypeJson){
							if(parseInt(devTypeJson.resultCode) == 1){
								Utils.tipBar('success','成功',devTypeJson.msg);
		 						setResult($('.pager_number_selected').attr('page'));
							}else{
								Utils.tipBar('error','失败',devTypeJson.msg);
							}
						};
						Utils.ajax(devTypeUrl,devTypeData,devTypeSucc);					
					});				
            });
            
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
							Utils.tipBar('success','设置成功',mainStatusJson.msg);
							setResult($('.pager_number_selected').attr('page'));
						}else{
							Utils.tipBar('error','设置失败',mainStatusJson.msg);
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
					Utils.tipBar('error','提示','请设置DEV类型，或该通道目前暂不支持配置化！');
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