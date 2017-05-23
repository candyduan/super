<?php 
	use common\models\orm\extend\RegChannel;
	use common\models\orm\extend\RegChannelMutex;
?>
<ol class="breadcrumb">
<li class="active"><i class="fa fa-dashboard"></i>通道组管理</li>
</ol>
<div class="main">

<!-- 搜索栏 -->
<div class="form-inline searchbar">
  <div class="form-group">
  	<input type="text" class="form-control searchbar_channelMutex"  placeholder="通道组" value=''>
  	<input type='hidden' value='' id='searchMutexId'> 
  </div>
  <button type="submit" class="btn btn-default searchbar_smt" id="search"> 搜索 </button>
  <button type="submit" class="btn btn-default searchbar_smt danger"  id="addMutexBtn"> 添加 </button>
</div>

<!-- 数据栏 -->
<div class="databar">
	<table class="table table-bordered table-hover" id="data_list">
	</table>
</div>

<!-- 展示通道组的弹窗 -->
<div class="modal fade" id="dislayMutexListDiv">
	<div class="modal-dialog">
		<div class="modal-content circular">
			<div class="modal-header" style="background-color:#f1f1f1;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id='channelMutexTitle'></h4>
			</div>
			<div class="modal-body" style="padding-top:0px;">
				<p>
					<div class="" id='addChannelToMutexDiv'>
						<input type='text' name="" value="" id="selectChannelObj">
						<input type='hidden' name='' value='' id='selectMutexId'>
						<input type='hidden' name='' value='' id='selectChannelId'>
						<button type="button" class="btn btn-default btn-sms" aria-label="Left Align" id='addChannelToMutex'>
  							<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>
						</button>
					</div>
				</p>
				<p>
					<div class="databar">
						<table class="table table-bordered table-hover" id="channelMute_list">
						</table>
					</div>
				</p>
			</div>
		</div>
	</div>
</div>


<!-- 添加通道组弹窗 -->
<div class="modal fade" id="saveMutexDiv">
	<div class="modal-dialog">
		<div class="modal-content circular">
			<div class="modal-header" style="background-color:#f1f1f1;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">添加通道组</h4>
			</div>
			<div class="modal-body" style="padding-top:0px;">
				<p>
					<div>
						<div class="input-group">
							<span class="input-group-addon">通道组名称</span>
							<input type="text" class="form-control mutexName" placeholder="Username" aria-describedby="basic-addon1" id="mutexName" value="">
						</div>
						<div class="input-group">
							<span class="input-group-addon">通道组状态</span>
							<select class="form-control" id="mutexStatus">
								<option value="1" selected>可用</option>
								<option value="0">停用</option>
							</select>
						</div>
						<input type='hidden' value='' id='mutexId'>
						<button type="submit" class="btn btn-primary searchbar_smt" id="saveMutex"> 保存 </button>
					</div>
				</p>
			</div>
		</div>
	</div>
</div>

<!-- 停用/起用通道组确认窗 -->
<div class="modal fade" id="changeMutexDiv">
	<div class="modal-dialog">
		<div class="modal-content circular">
			<div class="modal-header" style="background-color:#f1f1f1;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">确认</h4>
			</div>
			<div class="modal-body" style="padding-top:0px;">
				<p>
					<div class="input-group">
						<span class="input-group-addon" id='changeMutexName'></span>
						<input type='hidden' id=changeMutexDivId value=''>
					</div>
					<div class="input-group">
						<button type="submit" class="btn btn-danger searchbar_smt text-center"  onclick="doChangeMutex()"> 确定 </button>
					</div>
				</p>
			</div>
		</div>
	</div>
</div>

<!-- 分页 -->
<div class=""><nav><ul class="pager"></ul></nav></div>

</div>

<script>
$(document).ready(function(){
        setResult(1); 
        $('#search').click(function(){
            if($('.searchbar_channelMutex').val() == ''){
           	 	$('#searchMutexId').val('');
            }
            setResult(1);
    });
});

var merchantJsonList =<?=json_encode(RegChannelMutex::findAllToArray())?>;
var objMap = {};
$(".searchbar_channelMutex").typeahead({
    source: function (query, process) {
        var names = [];
        $.each(merchantJsonList, function (index, ele) {
            objMap[ele.name] = ele.id;
            names.push(ele.name);
        });
        process(names);//调用处理函数，格式化
    },
    items: 8,//最多显示个数
    afterSelect: function (item) {
        $('#searchMutexId').val(objMap[item]);
    }
});

var channelJsonList =<?=json_encode(RegChannel::findAllToArray())?>;
var objMap = {};
$("#selectChannelObj").typeahead({
    source: function (query, process) {
        var names = [];
        $.each(channelJsonList, function (index, ele) {
            objMap[ele.name] = ele.rcid;
            names.push(ele.name);
        });
        process(names);//调用处理函数，格式化
    },
    items: 8,//最多显示个数
    afterSelect: function (item) {
        $('#selectChannelId').val(objMap[item]);
    }
});


function setResult(page){
        //url
        var url = '/register/mutex-result';
        //data
      	var channelMutexId  = $('#searchMutexId').val();
        var data = 'channelMutexId='+channelMutexId+'&page='+page;
        //succ
        var succ        = function(resultJson){
                if(parseInt(resultJson.resultCode) == 1){
                        var resultHtml = '<tr><td>通道组ID</td><td>通道组名称</td><td>通道组状态</td><td>通道组管理</td>/tr>';
                        $.each(resultJson.list,function(key,val){
                                resultHtml = resultHtml + '<tr><td>'+val.rcmid+'</td><td>'+val.name+'</td><td>'+val.status+'</td><td><button type="button" class="btn btn-default" aria-label="Left Align" onclick="setMutexListResult('+val.rcmid+',\''+val.name+'\')"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></button><button type="button" class="btn btn-default edit-Mutex" aria-label="Left Align" data_rcmid="'+val.rcmid+'" >修改</button>';
	                               	 resultHtml += val.status == '可用' ? '<button type="button" class="btn btn-danger" aria-label="Left Align" onclick="stopMutex('+val.rcmid+',\''+val.name+'\')"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></button>' : 
	                               		'<button type="button" class="btn btn-success" aria-label="Left Align" onclick="startMutex('+val.rcmid+',\''+val.name+'\')"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>';
	                              resultHtml +=  '</td></tr>';
                        });
                        $('#data_list').html(resultHtml);

                    Utils.setPagination(page,resultJson.pages);
                    $(".pager_number").click(function(){
                        setResult($(this).attr('page'));
                    });

                $('.edit-Mutex').click(function(){
					var rcmid = $(this).attr('data_rcmid');
					var url = '/register/mutex-detail';
					var data = 'rcmid='+rcmid;
					var succ  = function(resultJson){
		                if(parseInt(resultJson.resultCode) == 1){
		                		$('#mutexName').val(resultJson.item.realName);
		                		resultJson.item.status == '可用' ? $('#mutexStatus ').val(1) : $('#mutexStatus ').val(0);
		                		$('#mutexId').val(rcmid);
		                		$('#saveMutexDiv').modal('show');
			            }else{
							
					    }
		            	}
					Utils.ajax(url,data,succ);
                })

                }else{
                        $('#data_list').html(resultJson.msg);
                }
        };
        //ajax
        Utils.ajax(url,data,succ);
        
}

$('#addMutexBtn').click(function(){
	$('#mutexName').val('');
	$('#mutexStatus').val('1');
	$('#mutexId').val('');
	$('#saveMutexDiv').modal('show');
})

$('#saveMutex').click(function(){
	var  url = '/register/save-mutex';
	var rcmid = $('#mutexId').val();
	var  mutexName = $('#mutexName').val();
	var mutexStatus = $('#mutexStatus').val();
	var data = 'rcmid='+rcmid+'&mutexName='+mutexName+'&mutexStatus='+mutexStatus;
	if(mutexName == ''){
		return;
	}
	alert('-'+rcmid+'-'+mutexName+'-'+mutexStatus+'-');
	var succ = function(resultJson){
         if(parseInt(resultJson.resultCode) == 1){
        	 	$('#saveMutexDiv').modal('toggle');
         }else{
        	 	$('#saveMutexDiv').modal('toggle');
            $('#data_list').html(resultJson.msg);
         }
	 };
	 Utils.ajax(url,data,succ);
});
	


//停用一个通道组
function stopMutex(mutexId,MutexName){
	var body = '确认要停用通道组：'+MutexName;
	$('#changeMutexName').val(mutexId);
	$('#changeMutexName').html(body);
	$('#changeMutexDiv').modal('show');
}

//启用一个通道组
function startMutex(mutexId,MutexName){
	var body = '确认要启用通道组：'+MutexName;
	$('#changeMutexName').val(mutexId);
	$('#changeMutexName').html(body);
	$('#changeMutexDiv').modal('show');
}

function doChangeMutex(){
	var rcmid = $('#changeMutexName').val();
	var url = '/register/change-mutex-status';
	var data = 'rcmid='+rcmid;
	var succ = function (resultJson){
		if(parseInt(resultJson.resultCode) == 1){
			$('#changeMutexDiv').modal('hide');
            setResult($(".pager_number").attr('page'));
    		}else{
    			$('#changeMutexDiv').modal('hide');
            $('#data_list').html(resultJson.msg);
    		}
	};
	Utils.ajax(url,data,succ);
}

//展示通道组的的列表
function setMutexListResult(mutexId,MutexName){
	$('#selectChannelObj').val('');
	$('#selectChannelId').val('');
	var url = '/register/mutexlist-result';
	var data = 'rcmid='+mutexId;
	var succ        = function(resultJson){
         if(parseInt(resultJson.resultCode) == 1){
                 var resultHtml = '<tr><td>通道</td><td>状态</td><td>编辑</td>';
                 if(resultJson.list){
	                 $.each(resultJson.list,function(key,val){
	                         resultHtml += '<tr><td>'+val.name+'</td><td>'+val.status+'</td><td>';
	                         resultHtml += val.status == '可用' ? '<button onclick="changeMutexListStatus('+val.rcmlid+')"  type="button" class="btn btn-danger" aria-label="Left Align"><span class="glyphicon glyphicon-minus " aria-hidden="true"></span></button>' : 
	                             '<button onclick="changeMutexListStatus('+val.rcmlid+')" type="button" class="btn btn-success" aria-label="Left Align"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>';
	                      
	                        resultHtml += '</td></tr>';
	                 });
                 }
                 $('#channelMutexTitle').html(MutexName);
                 $('#channelMute_list').html(resultHtml);
                 $('#selectMutexId').val(mutexId);
                 $('#dislayMutexListDiv').modal('show');
     
         }else{
                 $('#channleMutex_list').html(resultJson.msg);
         }
 };
 //ajax
 Utils.ajax(url,data,succ);
}
//添加通道到通道组
$('#addChannelToMutex').click(function(){
	var rcid = $('#selectChannelId').val();
	var rcmid =$('#selectMutexId').val();
	var url = '/register/add-channel-to-mutex';
	var data = 'rcid='+rcid+'&rcmid='+rcmid;
	var succ = function(resultJson){
		if(parseInt(resultJson.resultCode) == 1){
			var succMsg = '<div class="alert alert-success">'+resultJson.msg+'</div>';
			Utils.getNoFooterModal('success', succMsg);
		}else{
			var errMsg = '<div class="alert alert-danger">'+resultJson.msg+'</div>';
			//alert(errMsg);
			Utils.getNoFooterModal('error', errMsg);
		}
	}
	Utils.ajax(url,data,succ);
})

//改变通道组的状态
function changeMutexListStatus(rcmlid){
	var url = '/register/change-mutex-list-status';
	var data = 'rcmlid='+rcmlid;
	var succ = function(resultJson){
		if(parseInt(resultJson.resultCode) == 1){
			setMutexListResult(resultJson.item.rcmid,resultJson.item.name);
		}else{
			var errMsg = '<div class="alert alert-danger">'+resultJson.msg+'</div>';
			Utils.getNoFooterModal('error', errMsg);
		}
	}
	Utils.ajax(url,data,succ);
}
</script>
