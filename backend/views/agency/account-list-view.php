<style>
.btn{maring-left:10px;margin-right:10px;margin-top:0px;}
</style>
<ol class="breadcrumb">
<li class="active"><i class="fa fa-dashboard"></i>客户列表</li>
</ol>
<div class="main">
    <!-- 数据栏 -->
    <div class="databar">
    	<table class="table table-bordered table-hover">
    	<thead><tr><td>ID</td><td>名称</td><td>账号</td><td>验证码下发端口</td><td>验证码下发关键词</td><td>屏蔽下发端口</td><td>屏蔽下发关键词</td><td>匹配验证码关键词</td><td>状态</td><td>操作</td></tr></thead>
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
        var url = '/agency/account-list-result';
        //data
        var data = 'page='+page;
        //succ
        var succ        = function(resultJson){
                if(parseInt(resultJson.resultCode) == 1){
                		
                        var resultHtml = '';
                        $.each(resultJson.list,function(key,val){
                        	var status,btnOps;
                            if(parseInt(val.status) == 1){
                                status = '启用';
                                btnOps = '禁用';
                            }else{
								status = '禁用';
								btnOps = '启用';
                            }
                                resultHtml = resultHtml + '<tr><td>'+val.aaid+'</td><td>'+val.name+'</td><td>'+val.account+'</td><td>'+val.verifyPort+'</td><td>'+val.verifyKeywords+'</td><td>'+val.blockPort+'</td><td>'+val.blockKeywords+'</td><td>'+val.smtKeywords+'</td><td>'+status+'</td><td><a class="btn btn-default btn-view" href="/agency/account-detail-view?aaid='+val.aaid+'" target="_blank">查看</a><a class="btn btn-default btn-change" href="/agency/account-set-view?aaid='+val.aaid+'" target="_blank">修改</a><a class="btn btn-default btn-ops" data-aaid="'+val.aaid+'">'+btnOps+'</a></td></tr>';
                        });
                        $('#data_list').html(resultHtml);

                        $('.btn-ops').click(function(){
                            var r   = confirm("您确定要进行【"+$('.btn-ops').html()+"】操作吗？");
                            if(!r){
                                return;
                            }
                            var subUrl 	= "/agency/account-del";
                            var subData = "aaid="+$(this).attr('data-aaid');
                            var subSucc	= function(subResultJson){
                            	setResult(page);
                            };
                            Utils.ajax(subUrl,subData,subSucc);
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

