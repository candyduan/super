<ol class="breadcrumb">
<li class="active"><i class="fa fa-dashboard"></i>通道组管理</li>
</ol>
<div class="main">

<!-- 搜索栏 -->
<div class="form-inline searchbar">
  <div class="form-group"><input type="text" class="form-control searchbar_channelMutex"  placeholder="通道组"></div>
  <button type="submit" class="btn btn-default searchbar_smt" id="search"> 搜索 </button>
  <button type="submit" class="btn btn-default searchbar_smt danger" id="addChannelMutex" data-toggle="modal" data-target="#addMutexDiv"> 添加 </button>
</div>

<!-- 数据栏 -->
<div class="databar">
	<table class="table table-bordered table-hover" id="data_list">
	</table>
</div>

<!-- 添加通道组弹窗 -->
<div class="modal fade" id="addMutexDiv">
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
						<button type="submit" class="btn btn-primary searchbar_smt" onclick="doAddChannelMutex()"> 添加 </button>
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
            setResult(1);
    });
});

function setResult(page){
        //url
        var url = '/register/mutex-result';
        //data
      	var channelMutexId  = $('.searchbar_channelMutex').val();
        var data = 'channelMutexId='+channelMutexId+'&page='+page;
        //succ
        var succ        = function(resultJson){
                if(parseInt(resultJson.resultCode) == 1){
                        var resultHtml = '<tr><td>通道组ID</td><td>通道组名称</td><td>通道组状态</td><td>通道组管理</td>/tr>';
                        $.each(resultJson.list,function(key,val){
                                resultHtml = resultHtml + '<tr>'+
	                                '<td>'+val.rcmid+'</td>'+
	                                '<td>'+val.name+'</td>'+
	                                '<td>'+val.status+'</td>'+
	                                '<td>'+
	                               		'<button type="button" class="btn btn-default" aria-label="Left Align" onclick="setMutexListResult('+val.rcmid+',\''+val.name+'\')"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></button>'+
	                               		'<button type="button" class="btn btn-default" aria-label="Left Align" onclick="delMutex('+val.rcmid+',\''+val.name+'\')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>'+
	                                '</td>'+
	                                	'</tr>';
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

// //添加通道组
// function addChannelMutex(){
//     $('#addMutexDiv').toggle();
// }


function doAddChannelMutex(){
	var  url = '/register/add-mutex';
	var  mutexName = $('.mutexName').val();
	var mutexStatus = $('#mutexStatus').val();
	var data = 'mutexName='+mutexName+'&mutexStatus='+mutexStatus;
	if(mutexName != ''){
		var succ        = function(resultJson){
	         if(parseInt(resultJson.resultCode) == 1){
	        	 	$('#addMutexDiv').modal('toggle');
	         }else{
	        	 	$('#addMutexDiv').modal('toggle');
	            $('#data_list').html(resultJson.msg);
	         }
	 };
	 Utils.ajax(url,data,succ);
	}else{
		alert('通道组不能为空');
		
	}
}

//展示通道组的的列表
function setMutexListResult(mutexId,MutexName){
	var url = '/register/mutexlist-result';
	var data = 'rcmid='+mutexId;
	var succ        = function(resultJson){
         if(parseInt(resultJson.resultCode) == 1){
                 var resultHtml = '<table class="table table-bordered table-hover" id="channelMutex_list"><tr><td>通道</td><td>编辑</td></tr>';
                 $.each(resultJson.list,function(key,val){
                         resultHtml = resultHtml + '<tr><td>'+val.name+'</td><td><i  onclick="setMutexListResult('+val.rcmid+')"  title="">添加</i>--------<i  onclick="setMutexListResult('+val.rcmid+')"  title="">删除</i></td></tr>';
                 });
                 resultHtml = resultHtml + '</table>';
                 Utils.getNoFooterModal(MutexName,resultHtml);
     
         }else{
                 $('#data_list').html(resultJson.msg);
         }
 };
 //ajax
 Utils.ajax(url,data,succ);
}
</script>
