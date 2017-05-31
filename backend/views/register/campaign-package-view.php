<script language="javascript" type="text/javascript" src="/js/common/DatePicker/WdatePicker.js"></script>
<ol class="breadcrumb">
<li class="active"><i class="fa fa-dashboard"></i>活动包开关设置-活动包列表</li>
</ol>
<div class="main">

<div class="col-sm-10 col-md-10 col-lg-10" style="padding-bottom:10px;display:none" id="barDiv">
	<span id ='partnerName' class="btn-primary"></span> > <span id = 'appName'  class="btn-primary"></span> > <span id = 'campaignName'  class="btn-primary"></span>
</div>

<!-- 数据栏 -->
<div class="databar">
	<table class="table table-bordered table-hover" >
	<thead><tr><td>ID</td><td>渠道</td><td>渠道标识</td><td>主动上行</td><td>起止时间</td><td>操作</td></tr></thead>
	<tbody id="data_list"></tbody>
	</table>
</div>


<!-- 分页 -->
<div class=""><nav><ul class="pager"></ul></nav></div>

</div>

<div class="modal fade" id="saveSwitchDiv">
	<div class="modal-dialog">
		<div class="modal-content circular"  style="width:500px">
			<div class="modal-header" style="background-color:#f1f1f1;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">更新开关设置</h4>
			</div>
			<div class="modal-body" style="padding-top:0px;">
				<p>
					<div>
						<div class="input-group" style="padding-bottom:10px;">
							<span class="input-group-addon">开始时间</span>
							<input type="text" class="form-control" id="stime" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" placeholder="开始时间">
						</div>
						
						<div class="input-group" style="padding-bottom:10px;">
							<span class="input-group-addon">结束时间</span>
							<input type="text" class="form-control" id="etime" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" placeholder="结束时间">
						</div>
						
						<div class="input-group" style="padding-bottom:10px;">
							<span class="input-group-addon">开关</span>
							<select class="form-control" id="status">
								<option value="1" selected>打开</option>
								<option value="0">关闭</option>
							</select>
						</div>
						<input type='hidden' value='' id='campaignPackageId'>
						<button type="submit" class="btn btn-primary searchbar_smt" id="saveSwitchBtn"> 保存 </button>
					</div>
				</p>
			</div>
		</div>
	</div>
</div>
 
<script>
$(document).ready(function(){
	setResult(1);    
	$('#searchBtn').click(function(){
		setResult(1);
    });
	barShow();
});

function setResult(page){
	var url = '/register/campaign-package-result';
	var campaignId	= Utils.getQueryString('campaignId');
	var data 		= 'campaignId='+campaignId+'&page='+page;
	var succ    = function(resultJson){
		if(parseInt(resultJson.resultCode) == 1){
			var resultHtml = '';
			$.each(resultJson.list,function(key,val){
				resultHtml = resultHtml + '<tr><td>'+val.campaignPackageId+'</td><td>'+val.media+'</td><td>'+val.mediaSign+'</td><td id="statusName'+val.campaignPackageId+'">'+val.switchStatusName+'</td><td id="time'+val.campaignPackageId+'" >'+val.stime+' ~ '+val.etime+'</td><td><a class="btn btn-default btn-ops" style="padding: 1px 12px;" data-cpid="'+val.campaignPackageId+'">修改</a></td></tr>';
			});
			$('#data_list').html(resultHtml);

			Utils.setPagination(page,resultJson.pages);
			$(".pager_number").click(function(){
				setResult($(this).attr('page'));
			});
			$('.btn-ops').click(function(){
			    var cpid = $(this).attr('data-cpid');
			    $("#campaignPackageId").val(cpid);
			    $("#saveSwitchDiv").modal('show');
			    var subUrl 	= "/register/switch-result";
                var subData = "campaignPackageId="+cpid;
                var subSucc	= function(resultJson){
                	if(parseInt(resultJson.resultCode) == 1){
						$("#stime").val(resultJson.item.stime);
						$("#etime").val(resultJson.item.etime);
						$("#status").val(resultJson.item.status);
                    }else{
                    	$("#stime").val('2017-05-20');
						$("#etime").val('2018-05-20');
						$("#status").val(0);
                    }
                };
                Utils.ajax(subUrl,subData,subSucc);
			});
		}else{
			$('#data_list').html(resultJson.msg);
		}
	};
	Utils.ajax(url,data,succ);
} 

$('#saveSwitchBtn').click(function(){
	var url 	= '/register/save-switch-result';
	var stime	= $("#stime").val();
	var etime	= $("#etime").val();
	var status	= $("#status").val();
	var campaignPackageId	= $("#campaignPackageId").val();
	var data 	= 'stime='+stime+'&etime='+etime+'&status='+status+'&campaignPackageId='+campaignPackageId;
	var succ    = function(resultJson){
 		if(parseInt(resultJson.resultCode) == 1){
 			$("#saveSwitchDiv").modal('hide');
 			var statusName = status == 1 ? '打开' : '关闭';
 			$("#statusName"+campaignPackageId).html(statusName);
 			$("#time"+campaignPackageId).html(stime+" ~ "+etime);
			Utils.getNoFooterModal("成功",resultJson.msg);
		}else{
			Utils.getErrModal("保存失败",resJson.msg);
		}
	};
	Utils.ajax(url,data,succ);
});

$('#saveSwitchBtn').click(function(){
	var url 	= '/register/save-switch-result';
	var stime	= $("#stime").val();
	var etime	= $("#etime").val();
	var status	= $("#status").val();
	var campaignPackageId	= $("#campaignPackageId").val();
	var data 	= 'stime='+stime+'&etime='+etime+'&status='+status+'&campaignPackageId='+campaignPackageId;
	var succ    = function(resultJson){
 		if(parseInt(resultJson.resultCode) == 1){
 			$("#saveSwitchDiv").modal('hide');
 			var statusName = status == 1 ? '打开' : '关闭';
 			$("#statusName"+campaignPackageId).html(statusName);
 			$("#time"+campaignPackageId).html(stime+" ~ "+etime);
			Utils.getNoFooterModal("成功",resultJson.msg);
		}else{
			Utils.getErrModal("保存失败",resJson.msg);
		}
	};
	Utils.ajax(url,data,succ);
});
function barShow(){
	var url 		= '/register/campaign-package-bar-result';
	var campaignId	= Utils.getQueryString('campaignId');
	var data 	= 'campaignId='+campaignId;
	var succ    = function(resultJson){
 		if(parseInt(resultJson.resultCode) == 1){
 	 		$("#barDiv").show();
 			$("#partnerName").html(resultJson.item.pname);
 			$("#appName").html(resultJson.item.aname);
 			$("#campaignName").html(resultJson.item.cname);
 		}
	};
	Utils.ajax(url,data,succ);
}
</script>

