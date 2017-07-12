<ol class="breadcrumb">
<li><a href="/pay/cgroup-view">通道组管理</a></li>
<li class="active channelGroupName"></li>
</ol>
<div class="main">
	<!-- 搜索栏 -->
	<div class="form-inline searchbar">	
		  <?php echo backend\library\widgets\WidgetsUtils::getSearchPayChannel();?>
          <div class="form-control"><a class="glyphicon glyphicon-plus add2ChannelGroup"></a></div>
	</div>
    <!-- 数据栏 -->
    <div class="databar">
    	<table class="table table-bordered table-hover">
    	<thead><tr><td>通道</td><td>管理</td></tr></thead>
    	<tbody id="data_list"></tbody>
    	</table>
    </div>
    
    
    <!-- 分页 -->
    <div class=""><nav><ul class="pager"></ul></nav></div>
</div>


<script>
$(document).ready(function(){
        setResult();
        $('.add2ChannelGroup').click(function(){			
			var url = '/pay/cgroup-join';
			var data='chid='+$('#channel').val()+'&gid='+Utils.getQueryString('gid');
			var succ= function(resultJson){
				if(parseInt(resultJson.resultCode) == 1){
					Utils.tipBar('success','加入成功',resultJson.msg);
					setResult();
				}else{
					Utils.tipBar('error','加入失败',resultJson.msg);
				}
			};
			Utils.ajax(url,data,succ);
        });
});

function setResult(){
        //url
        var url = '/pay/cgroup-channel-list-result';
        //data
        var data = 'gid='+Utils.getQueryString('gid');
        //succ
        var succ        = function(resultJson){
            	$('.channelGroupName').html(resultJson.item.name);
                if(parseInt(resultJson.resultCode) == 1){                		
                        var resultHtml = '';
                        $.each(resultJson.list,function(key,val){
                           resultHtml = resultHtml + '<tr><td>'+val.name+'</td><td><a class="glyphicon glyphicon-remove channel_moveout" data-chid="'+val.chid+'"></a></td></tr>';
                        });
                        $('#data_list').html(resultHtml);
                    	$('.channel_moveout').click(function(){                        	
							var moveUrl	= '/pay/cgroup-move';
							var moveData='chid='+$(this).attr('data-chid');
							var moveSucc = function(moveJson){
								if(parseInt(moveJson.resultCode) == 1){
									Utils.tipBar('success','删除成功',moveJson.msg);
									setResult();
								}else{
									Utils.tipBar('error','删除失败',moveJson.msg);
								}
							};
							Utils.ajax(moveUrl,moveData,moveSucc);
                        });                              
                }else{
                        $('#data_list').html(resultJson.msg);
                }
        };
        //ajax
        Utils.ajax(url,data,succ);

}
</script>

