<style>
.channelGroupName{cursor:pointer;color:#66b3ff;}
</style>
<ol class="breadcrumb">
<li class="active">通道组管理</li>
<li class=""><a href="/pay/cgroup-set-view">添加</a></li>
</ol>
<div class="main">
    <!-- 数据栏 -->
    <div class="databar">
    	<table class="table table-bordered table-hover">
    	<thead><tr><td>通道组</td><td>组属唯一</td><td>CD(秒)</td><td>日成功限量</td><td>日请求限量</td><td>月成功限量</td><td>月请求限量</td><td>管理</td></tr></thead>
    	<tbody id="data_list"></tbody>
    	</table>
    </div>
    
    
    <!-- 分页 -->
    <div class=""><nav><ul class="pager"></ul></nav></div>
</div>


<script>
$(document).ready(function(){
        setResult(1);
});

function setResult(page){
        //url
        var url = '/pay/cgroup-result';
        //data
        var data = 'page='+page;
        //succ
        var succ        = function(resultJson){
                if(parseInt(resultJson.resultCode) == 1){                		
                        var resultHtml = '';
                        $.each(resultJson.list,function(key,val){
                           resultHtml = resultHtml + '<tr><td class="channelGroupName" data-cgid="'+val.id+'">'+val.name+'</td><td>'+val.uniqueLimit+'</td><td>'+val.cdTime+'</td><td>'+val.dayLimit+'</td><td>'+val.dayRequestLimit+'</td><td>'+val.monthLimit+'</td><td>'+val.monthRequestLimit+'</td><td><a class="glyphicon glyphicon-list-alt" href="/pay/cgroup-channel-list-view?gid='+val.id+'"></a></td></tr>';
                        });
                        $('#data_list').html(resultHtml);
                    	$('.channelGroupName').click(function(){                        	
							window.location.href="/pay/cgroup-set-view?id="+$(this).attr('data-cgid');					
                        });
                        if(resultJson.pages > 1){
                            Utils.setPagination(page,resultJson.pages);
                            $(".pager_number").click(function(){
                                setResult($(this).attr('page'));
                            });
                        }                                
                }else{
                        $('#data_list').html(resultJson.msg);
                }
        };
        //ajax
        Utils.ajax(url,data,succ);

}
</script>
