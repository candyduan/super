<ol class="breadcrumb">
<li class="active"><i class="fa fa-dashboard"></i>通道管理</li>
</ol>
<div class="main">

<!-- 搜索栏 -->
<div class="form-inline searchbar">
  <div class="form-group"><input type="text" class="form-control searchbar_merchant"  placeholder="通道商"></div>
  <div class="form-group"><input type="text" class="form-control searchbar_channel"  placeholder="通道"></div>
  <button type="submit" class="btn btn-default searchbar_smt" id="search"> 搜索 </button>
</div>

<!-- 数据栏 -->
<div class="">
	<table class="table table-bordered" id="data_list">
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
        var url = '/register/channel-result';
        //data
      	var merchantId  = $('.searchbar_merchant').val();
     	var channelId	= $('.searchbar_channel').val();
        var data = 'merchantId='+merchantId+'&channelId='+channelId+'&page='+page;
        //succ
        var succ        = function(resultJson){
                if(parseInt(resultJson.errcode) == 1){
                        var resultHtml = '<tr><td>用户ID</td><td>用户昵称</td><td>抽成金币</td><td>原因</td></tr>';
                        $.each(resultJson.list,function(key,val){
                                resultHtml = resultHtml + '<tr><td>'+val.urid+'</td><td>'+val.name+'</td><td>'+val.point+'</td><td>'+val.cause+'</td></tr>';
                        });
                        $('#result-list').html(resultHtml);

                if(resultJson.pages > 1){
                    Utils.setPagination(page,resultJson.pages);
                    $(".pager_number").click(function(){
                        setResult($(this).attr('page'));
                    });
                }
                
                }else{
                        $('#result-list').html(resultJson.msg);
                }
        };
        //ajax
        Utils.ajax(url,data,succ);

}
</script>

