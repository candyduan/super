<style>
.col-xs-2{text-align:left !important;}
</style>
<ol class="breadcrumb">
<li class="active"><i class="fa fa-dashboard"></i>新增中介商</li>
</ol>
<div class="main">
<div class="form-horizontal">
  <div class="form-group">
    <label for="account" class="col-xs-2 control-label">账号</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="account" placeholder="请输入账号">
    </div>
  </div>
  
   <div class="form-group">
    <label for="passwd" class="col-xs-2 control-label">密码</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="passwd" placeholder="请输入密码">
    </div>
  </div>
  
   <div class="form-group">
    <label for="name" class="col-xs-2 control-label">名称</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="name" placeholder="请输入名称">
    </div>
  </div>

   <div class="form-group">
    <label for="verifyPort" class="col-xs-2 control-label">验证码下发端口</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="verifyPort" placeholder="请输入验证码下发端口">
    </div>
  </div>
 
   <div class="form-group">
    <label for="verifyKeywords" class="col-xs-2 control-label">验证码匹配关键词</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="verifyKeywords" placeholder="请输入验证码匹配关键词">
    </div>
  </div>
  
         
  <div class="form-group">
    <label for="blockPort" class="col-xs-2 control-label">屏蔽下发端口</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="blockPort" placeholder="请输入屏蔽下发端口">
    </div>
  </div>
 
  <div class="form-group">
    <label for="blockKeywords" class="col-xs-2 control-label">屏蔽下发关键词</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="blockKeywords" placeholder="请输入屏蔽下发关键词">
    </div>
  </div>

  <div class="form-group">
    <label for="smtKeywords" class="col-xs-2 control-label">匹配验证码关键词</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="smtKeywords" placeholder="请输入匹配验证码关键词">
    </div>
  </div>
      
  <div class="form-group">
    <div class="col-xs-offset-2 col-xs-10">
      <button type="submit" class="btn btn-default btn-save">保存</button>
    </div>
  </div>
</div>
</div>
<script>
$(document).ready(function(){
	var aaid  = Utils.getQueryString('aaid');
	if(parseInt(aaid) > 0){
		var url = '/agency/account-detail-result';
		var data='aaid='+aaid;
		var succFunc	= function(resJson){
			if(parseInt(resJson.resultCode) == 1){
				$('#account').val(resJson.item.account);
				$('#passwd').val(resJson.item.passwd);
				$('#name').val(resJson.item.name);
				$('#verifyPort').val(resJson.item.verifyPort);
				$('#verifyKeywords').val(resJson.item.verifyKeywords);
				$('#blockPort').val(resJson.item.blockPort);
				$('#blockKeywords').val(resJson.item.blockKeywords);
				$('#smtKeywords').val(resJson.item.smtKeywords);	
			}		
		};
		Utils.ajax(url,data,succFunc);
	}
	$('.btn-save').click(function(){
		if($('#account').val() == ''){
			$('#account').addClass('input-err');
			return;
		}
		if($('#passwd').val() == ''){
			$('#passwd').addClass('input-err');
			return;
		}
		if($('#name').val() == ''){
			$('#name').addClass('input-err');
			return;
		}
		if($('#verifyPort').val() == ''){
			$('#verifyPort').addClass('input-err');
			return;
		}
		if($('#verifyKeywords').val() == ''){
			$('#verifyKeywords').addClass('input-err');
			return;
		}
		if($('#blockPort').val() == ''){
			$('#blockPort').addClass('input-err');
			return;
		}
		if($('#blockKeywords').val() == ''){
			$('#blockKeywords').addClass('input-err');
			return;
		}
		if($('#smtKeywords').val() == ''){
			$('#smtKeywords').addClass('input-err');
			return;
		}
		
		//url
		var url = '/agency/account-set-save';
		//data
		var data = 'aaid='+Utils.getQueryString('aaid')
			 	 + '&account='+$('#account').val()
				 + '&passwd='+$('#passwd').val()
				 + '&name='+$('#name').val()
				 + '&verifyPort='+$('#verifyPort').val()
				 + '&verifyKeywords='+$('#verifyKeywords').val()
				 + '&blockPort='+$('#blockPort').val()
				 + '&blockKeywords='+$('#blockKeywords').val()
				 + '&smtKeywords='+$('#smtKeywords').val()
				 ;	
		//succFunc
		var succFunc	= function(resJson){
				if(parseInt(resJson.resultCode) == 1){
					window.location.href="/agency/account-detail-view?aaid="+resJson.aaid;
				}else{
					Utils.getErrModal("保存失败",resJson.msg);
				}
			};
		Utils.ajax(url,data,succFunc);
	});
});
</script>