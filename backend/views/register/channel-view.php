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
        var url = '/register/channel-result';
        //data
        var mid  = Utils.getQueryString('mid');
        if(mid != ''){
			$('.searchbar_merchant').val(mid);
        }
      	var merchantId  = $('.searchbar_merchant').val();
     	var channelId	= $('.searchbar_channel').val();
        var data = 'merchantId='+merchantId+'&channelId='+channelId+'&page='+page;
        //succ
        var succ        = function(resultJson){
                if(parseInt(resultJson.resultCode) == 1){
                        var resultHtml = '<tr><td>通道商</td><td>通道</td><td>负责人</td><td>运营商</td><td>开发类型</td><td>状态</td></tr>';
                        $.each(resultJson.list,function(key,val){
                                resultHtml = resultHtml + '<tr><td>'+val.merchantName+'</td><td>'+val.channelName+'</td><td>'+val.holderName+'</td><td>'+val.provider+'</td><td>'+val.devType+'</td><td>'+val.status+'</td></tr>';
                        });
                        $('#data_list').html(resultHtml);

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

