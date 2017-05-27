<ol class="breadcrumb">
<li class="active"><i class="fa fa-dashboard"></i>客户详情</li>
</ol>
<div class="main">
    <table class="table table-striped table-bordered table-hover">
    <tr><td>ID</td><td id="aaid"></td></tr>
    <tr><td>账号</td><td id="account"></td></tr>
    <tr><td>密码</td><td id="passwd"></td></tr>
    <tr><td>名称</td><td id="name"></td></tr>
    <tr><td>验证码下发端口</td><td id="verifyPort"></td></tr>
    <tr><td>验证码匹配关键词</td><td id="verifyKeywords"></td></tr>
    <tr><td>屏蔽下发端口</td><td id="blockPort"></td></tr>
    <tr><td>屏蔽下发关键词</td><td id="blockKeywords"></td></tr>
    <tr><td>匹配验证码关键词</td><td id="smtKeywords"></td></tr>
    <tr><td>创建时间</td><td id="recordTime"></td></tr>
    <tr><td>更新时间</td><td id="updateTime"></td></tr>
    <tr><td>状态</td><td id="status"></td></tr>
    </table>
</div>

<script>
$(document).ready(function(){
	var aaid  = Utils.getQueryString('aaid');
	var url = '/agency/account-detail-result';
	var data='aaid='+aaid;
	var succFunc	= function(resJson){
		$('#aaid').html(resJson.item.aaid);
		$('#account').html(resJson.item.account);
		$('#passwd').html(resJson.item.passwd);
		$('#name').html(resJson.item.name);
		$('#verifyPort').html(resJson.item.verifyPort);
		$('#verifyKeywords').html(resJson.item.verifyKeywords);
		$('#blockPort').html(resJson.item.blockPort);
		$('#blockKeywords').html(resJson.item.blockKeywords);
		$('#smtKeywords').html(resJson.item.smtKeywords);
		$('#recordTime').html(resJson.item.recordTime);
		$('#updateTime').html(resJson.item.updateTime);
		if(parseInt(resJson.item.status) == 1){
			var status = '正常';
		}else{
			var status = '禁用';
		}
		$('#status').html(status);	
	};
	Utils.ajax(url,data,succFunc);
});
</script>