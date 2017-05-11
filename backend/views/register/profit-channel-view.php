<script language="javascript" type="text/javascript" src="/js/common/DatePicker/WdatePicker.js"></script>
<ol class="breadcrumb">
<li class="active"><i class="fa fa-dashboard"></i>通道收益</li>
</ol>
<div class="main">

<!-- 搜索栏 -->
<div class="form-inline searchbar">
  <div class="form-group" style="padding-right: 10px"><input type="text" class="form-control stime"  value="<?php echo date("Y-m-01");?>" onClick="WdatePicker()" placeholder="开始时间"></div>
  <div class="form-group" style="padding-right: 10px"><input type="text" class="form-control etime"  value="<?php echo date("Y-m-d",time());?>"onClick="WdatePicker()" placeholder="结束时间"></div>
  <div class="form-group" style="padding-right: 40px"> 
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
     	var checkChannel	= $('#checkChannel').val();
        var data = 'stime='+stime+'&etime='+etime+'&checkChannel='+checkChannel;
        //succ
        var succ        = function(resultJson){
                if(parseInt(resultJson.resultCode) == 1){
                	checkChannelTitle = '';
                    if(checkChannel!=0){
						checkChannelTitle = '<td>通道</td>';
                    }
                    var resultHtml = '<tr><td>日期</td>'+checkChannelTitle+'<td>成功次数</td><td>失败次数</td></tr>';
                    $.each(resultJson.data,function(key,val){
                    	resultHtml = resultHtml + '<tr><td>'+val.day+'</td>';
                    	if(checkChannel!=0){
                        	resultHtml = resultHtml + '<td>'+val.rcid+'</td>';
                        }
                       	resultHtml = resultHtml + '<td>'+val.sumsucc+'</td><td>'+val.sumfail+'</td></tr>';
                    });
                	$('#data_list').html(resultHtml);
                }else{
                	$('#data_list').html(resultJson.msg);
        	}
        };
        //ajax
        Utils.ajax(url,data,succ);
}
</script>

