<script language="javascript" type="text/javascript" src="/js/common/DatePicker/WdatePicker.js"></script>
<ol class="breadcrumb">
<li class="active"><i class="fa fa-dashboard"></i>通道收益</li>
</ol>
<div class="main">

<!-- 搜索栏 -->
<div class="form-inline searchbar">
  <div class="form-group"><input type="text"  data-provide="typeahead"  id="merchantText" class="form-control searchbar_merchant"  placeholder="通道商"></div>
  <input type="hidden" id="merchant" value="">
  <div class="form-group"><input type="text" class="form-control searchbar_channel" id="channelText"  placeholder="通道"></div>
  <input type="hidden" id="channel" value="">
  <div class="form-group" style="padding-right: 10px"><input type="text" class="form-control stime"  value="<?php echo date("Y-m-01");?>" onClick="WdatePicker()" placeholder="开始时间"></div>
  <div class="form-group" style="padding-right: 10px"><input type="text" class="form-control etime"  value="<?php echo date("Y-m-d",time());?>"onClick="WdatePicker()" placeholder="结束时间"></div>
  <div class="form-group" style="padding-right: 40px"> 
  通道商 <input onclick="this.value=(this.value==0)?1:0" name="checkMerchant" type="checkbox" id="checkMerchant" value="0" >&nbsp;&nbsp;
  通道 <input onclick="this.value=(this.value==0)?1:0" name="checkChannel" type="checkbox" id="checkChannel" value="0" >
  </div>
   <button type="submit" class="btn btn-default searchbar_smt" id="search"> 搜索 </button>
 </div>

<!-- 数据栏 -->
<div class="databar">
	<table class="table table-bordered table-hover" id="data_list">
	</table>
</div>


<script>
$(document).ready(function(){
	setResult();    
	$('#search').click(function(){
		setResult();
    });
});
function setResult(){
        //url
        var url = '/register/profit-channel-result';
        //data
      	var stime			= $('.stime').val();
     	var etime			= $('.etime').val();
    	var channel			= $('#channel').val();
     	var merchant		= $('#merchant').val();
     	var checkChannel	= $('#checkChannel').val();
     	var checkMerchant	= $('#checkMerchant').val();
        var data = 'stime='+stime+'&etime='+etime+'&checkChannel='+checkChannel+'&checkMerchant='+checkMerchant+'&channel='+channel+'&merchant='+merchant;
        //succ
        var succ        = function(resultJson){
        	if(parseInt(resultJson.resultCode) == 1){
            	checkTitle = '';
                if(checkMerchant!=0 || merchant){
 					checkTitle+= '<td>通道商</td>';
                }
                if(checkChannel!=0 || channel){
					checkTitle+= '<td>通道</td>';
                }
                var resultHtml = '<tr><td>日期</td>'+checkTitle+'<td>请求次数</td><td>成功次数</td><td>收入(元)</td><td>转化率</td></tr>';
	                $.each(resultJson.data,function(key,val){
	                	resultHtml = resultHtml + '<tr><td>'+val.day+'</td>';
	                    if(checkMerchant!=0 || merchant){
	                    	resultHtml = resultHtml + '<td>'+val.merchantName+'</td>';
	                    }
	                    if(checkChannel!=0 || channel){
	                        resultHtml = resultHtml + '<td>'+val.channelName+'</td>';
	                    }
	                    var sumcount	= parseFloat(val.sumfail) + parseFloat(val.sumsucc);
	                    var	rate		= parseFloat(val.sumsucc)/sumcount*100;
	                    var inPrice		= parseFloat(val.sumsucc) * parseFloat(val.inRate) /100;
	                    resultHtml 		= resultHtml + '<td>'+sumcount+'</td><td>'+val.sumsucc+'</td><td>'+inPrice.toFixed(2)+'</td><td>'+rate.toFixed(2)+'%</td></tr>';
	                });
                	$('#data_list').html(resultHtml);
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

