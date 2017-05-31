<style>
	.canvas {
	  align-items: center;
	  background: #eeeeee;
	  border-radius: 50%;
	  box-shadow: 0 5px 20px rgba(0,0,0,0.2);
	  display: flex;
	  height: 5em;
	  justify-content: center;
	  margin: 1em 1em 2em 1em;
	  width: 5em;
	}
	.spinner3 {
	  animation: spinnerThree 1s linear infinite;
	  background: #4DB6AC;
	  border-radius: 100%;
	  width: 3em;
	  height: 3em;
	  text-align:center;
	  line-height:3em;
	  cursor:pointer;
	}
	
	@keyframes spinnerThree {
	  0%, 35% {
	    background: #4DB6AC;
	    transform: scale(0.8);
	  }
	  20%, 50% {
	    background: #80CBC4;
	    transform: scale(1.3);
	  }
	}
	
	.spinner5 {
  animation: spinnerFive 1s linear infinite;
  border: solid 1.5em #FF8800;
  border-right: solid 1.5em transparent;
  border-left: solid 1.5em transparent;
  border-radius: 100%;
  width: 0;
  height: 0;
  cursor:pointer;
}

@keyframes spinnerFive {
  0% {
    transform: rotate(0deg);
  }
  50% {
    transform: rotate(60deg)
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>

<ol class="breadcrumb">
<li class="active"><i class="fa fa-dashboard"></i>通道值班表</li>
</ol>

<div class="main">
    <!-- 数据栏 -->
    <div class="databar">
    	<table class="table table-bordered table-hover" id="data_list">
    		
    	</table>
    </div>
    
    
    <!-- 分页 -->
    <div class=""><nav><ul class="pager"></ul></nav></div>
</div>

<div class="modal fade" id="comfirm">
	<div class="modal-dialog">
		<div class="modal-content circular">
			<div class="modal-header" style="background-color:#f1f1f1;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">确认</h4>
			</div>
			<div class="modal-body" style="padding-top:0px;">
				<p>
					<div class="input-group">
						<span class="input-group-addon" id=''>密码</span>
						<input type='password' id="password" value=''>
						<input type="hidden" id='id' value=''>
					</div>
					<div class="input-group">
						<button type="submit" class="btn btn-danger searchbar_smt text-center" id="submit"> 确定 </button>
					</div>
				</p>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		setResult();
			
	});
	
	function setResult(){
		var data;
		var url = '/pay/developers-result';
		var succ = function(resultJson){
			 if(parseInt(resultJson.resultCode) == 1){
					var resultHtml = '<tr><td>姓名</td><td>接入数量</td><td class="abc">操作</td></tr>';
					$.each(resultJson.datas,function(key,val){
						if(key == 0){
							resultHtml += '<tr><td>'+val.name+'</td><td>'+val.count+'</td><td><div  class="canvas canvas3" ret="'+val.id+'"><div class="spinner3">🐯</div></div></td></tr>';
						}else{
							resultHtml += '<tr><td class="av">'+val.name+'</td><td>'+val.count+'</td><td><div  class="canvas canvas5" ret="'+val.id+'"><div class="spinner5"></div></div></td></tr>';
						}
					})
					$('#data_list').html(resultHtml);

					$('.canvas').click(function(){
						$('#id').val($(this).attr('ret'));
						$('#password').val('');
						$('#comfirm').modal('show');
					});
			}else{
				Utils.getNoFooterModal('Alert', resultJson.msg);
			}	
		}
		Utils.ajax(url,data,succ);
	}

	$('#submit').click(function(){
		var pwd = $('#password').val();
		var id =$('#id').val();
		if(pwd == ''){
			Utils.getNoFooterModal('alert', '密码不可为空');
			return;
		}
		var data = 'id='+id+'&pwd='+pwd;
		var url = '/pay/add-developer-channel-count';
		var succ = function(resultJson){
			 if(parseInt(resultJson.resultCode) == 1){	
				 $('#comfirm').modal('toggle');
				 setResult();
			 }else{
				 Utils.getNoFooterModal('Alert', resultJson.msg);
			 }
		}
		Utils.ajax(url,data,succ,false);
	})


</script>