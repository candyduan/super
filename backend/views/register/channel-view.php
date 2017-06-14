<ol class="breadcrumb">
<li class="active">通道列表</li>
</ol>
<div class="main">

<!-- 搜索栏 -->
<div class="form-inline searchbar">
  <div class="form-group"><input type="text"  data-provide="typeahead"  id="merchantText" class="form-control searchbar_merchant"  placeholder="通道商"></div>
  <input type="hidden" id="merchant" value="">
  <div class="form-group"><input type="text" class="form-control searchbar_channel" id="channelText"  placeholder="通道"></div>
  <input type="hidden" id="channel" value="">
  <div class="form-group">

<select class="form-control" id="status">
<option value="-1" selected>代码状态</option>
<?php foreach ($channelStatusList as $key => $channelStatus){?>
<option value="<?php echo $key?>"><?php echo $channelStatus?></option>
<?php }?>
</select>

</div>
  
  <button type="submit" class="btn btn-default searchbar_smt" id="search"> 搜索 </button>
</div>

<!-- 数据栏 -->
<div class="databar">
	<table class="table table-bordered table-hover" >
	<thead><tr><td>通道商</td><td>通道</td><td>负责人</td><td>运营商</td><td>开发类型</td><td>时段</td><td>状态</td></tr></thead>
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
        var url = '/register/channel-result';
        //data
        var mid = $('#merchant').val();
        if(mid == ''){
        	mid  = Utils.getQueryString('mid');
        }
      	var merchantId  = mid;
     	var channelId	= $('#channel').val();
     	var status		= $("#status").val();
        var data = 'merchantId='+merchantId+'&channelId='+channelId+'&page='+page+'&status='+status;
        //succ
        var succ        = function(resultJson){
                if(parseInt(resultJson.resultCode) == 1){
                        var resultHtml = '';
                        $.each(resultJson.list,function(key,val){
                                resultHtml = resultHtml + '<tr><td>'+val.merchantName+'</td><td><a href="/register/save-channel-view?rcid='+val.rcid+'">'+val.channelName+'</a></td><td>'+val.holderName+'</td><td>'+val.provider+'</td><td>'+val.devType+'</td><td><a data-rcid="'+val.rcid+'" class="glyphicon glyphicon-time channel-switch"></a></td><td>'+val.status+'</td></tr>';
                        });
                        $('#data_list').html(resultHtml);
						$('.channel-switch').click(function(){
							var switchUrl = '/register/channel-switch-result';
							var switchData='rcid='+$(this).attr('data-rcid');
							var succFunc  = function(switchJson){
									if(parseInt(switchJson.resultCode) == 1){
										var switchHtml = '';
										$.each(switchJson.list,function(swkey,swval){
											var swhourStyle = '';
											if(parseInt(swval.swswitch) == 1){
												swhourStyle = 'swhour-open';
											}else{
												swhourStyle = 'swhour-close';
											}
											switchHtml = switchHtml+'<button data-hour="'+swval.swhour+'" data-status="'+swval.swswitch+'" class="hour'+swval.swhour+' swhour '+swhourStyle+'">'+swval.swhour+'</button>';											
										});
										Utils.getNoFooterModal('时段设置',switchHtml);
										$('.swhour').click(function(){
											var opsUrl = '/register/channel-switch-set';
											var status = $(this).attr('data-status');
											if(parseInt(status) == 1){
												status = 0;
											}else{
												status = 1;
											}
											var opsData='rcid='+switchJson.rcid+'&hour='+$(this).attr('data-hour')+'&status='+status;
											var opsSucc=function(opsJson){
													if(parseInt(opsJson.resultCode) == 1){//succ
														var swhour = '.'+opsJson.swhour;
														if(parseInt(opsJson.status) == 1){//open
															$(swhour).removeClass('swhour-close');
															$(swhour).addClass('swhour-open');
															$(swhour).attr('data-status',opsJson.status);
														}else{//close
															$(swhour).removeClass('swhour-open');
															$(swhour).addClass('swhour-close');
															$(swhour).attr('data-status',opsJson.status);
														}

													}else{//fail
														Utils.tipBar('error','失败',opsJson.msg);
													}
											};
											Utils.ajax(opsUrl,opsData,opsSucc);
										});
									}else{
										Utils.tipBar('error','失败',switchJson.msg);
									}
							};
							Utils.ajax(switchUrl,switchData,succFunc);
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

var jsonList	= <?php echo json_encode(\common\models\orm\extend\Merchant::getTypeHeaderMerchantList())?>;
Utils.myTypeHeder(jsonList,"merchantText","merchant",'');

var jsonList	= <?php echo json_encode(\common\models\orm\extend\RegChannel::getTypeHeaderChannelList())?>;
Utils.myTypeHeder(jsonList,"channelText","channel",'');
</script>

