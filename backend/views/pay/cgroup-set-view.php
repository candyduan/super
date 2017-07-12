<ol class="breadcrumb">
<li class=""><a href="/pay/cgroup-view">通道组管理</a></li>
<li class="active">添加/编辑通道组</li>
</ol>
<div class="main">

<div class="form-horizontal">
  <div class="form-group">
    <label for="name" class="col-xs-2 control-label">通道组名称</label>
    <div class="col-xs-10">
      <input type="text" class="form-control" id="name" placeholder="请输入通道组名称">
    </div>
  </div>

 
  <div class="form-group">
    <label for="uniqueLimit" class="col-xs-2 control-label">组属唯一</label>
    <div class="col-xs-10">
<!--       <input type="text" class="form-control" id="uniqueLimit" placeholder="请输入通道组名称"> -->
		<select class="form-control" id="uniqueLimit">
		<option class="uniqueLimitOption" value ="1">启用</option>
		<option class="uniqueLimitOption" value ="0">禁用</option>
		</select>
    </div>
  </div>
   
 
   <div class="form-group">
    <label for="cdTime" class="col-xs-2 control-label">冷却时间(秒)</label>
    <div class="col-xs-10">
      <input type="text" class="form-control" id="cdTime" value="0">
    </div>
  </div>
 
   <div class="form-group">
    <label for="dayLimit" class="col-xs-2 control-label">日限量</label>
    <div class="col-xs-10">
      <input type="text" class="form-control" id="dayLimit" value="0">
    </div>
  </div>
 
   <div class="form-group">
    <label for="dayRequestLimit" class="col-xs-2 control-label">日请求量</label>
    <div class="col-xs-10">
      <input type="text" class="form-control" id="dayRequestLimit" value="0">
    </div>
  </div>
 
   <div class="form-group">
    <label for="monthLimit" class="col-xs-2 control-label">月限量</label>
    <div class="col-xs-10">
      <input type="text" class="form-control" id="monthLimit" value="0">
    </div>
  </div>
 
   <div class="form-group">
    <label for="monthRequestLimit" class="col-xs-2 control-label">月请求量</label>
    <div class="col-xs-10">
      <input type="text" class="form-control" id="monthRequestLimit" value="0">
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
	var id  = Utils.getQueryString('id');
	var url = '/pay/cgroup-detail-result';
	var data='id='+id;
	var succFunc	= function(resJson){
		if(parseInt(resJson.resultCode) == 1){
			$('#name').val(resJson.item.name);
			$.each($('.uniqueLimitOption'),function(key,val){
				if($(this).val() == resJson.item.uniqueLimit){
					$(this).attr('selected','selected');
				}
			});
			$('#cdTime').val(resJson.item.cdTime);
			$('#dayLimit').val(resJson.item.dayLimit);
			$('#dayRequestLimit').val(resJson.item.dayRequestLimit);
			$('#monthLimit').val(resJson.item.monthLimit);
			$('#monthRequestLimit').val(resJson.item.monthRequestLimit);			
		}
	};
	Utils.ajax(url,data,succFunc);



	$('.btn-save').click(function(){
		var url = '/pay/cgroup-set-save';
		var data='id='+id+'&name='+$('#name').val()+'&uniqueLimit='+$('#uniqueLimit').val()+'&cdTime='+$('#cdTime').val()+'&dayLimit='+$('#dayLimit').val()+'&dayRequestLimit='+$('#dayRequestLimit').val()+'&monthLimit='+$('#monthLimit').val()+'&monthRequestLimit='+$('#monthRequestLimit').val();
		var succFunc	= function(resJson){
			if(parseInt(resJson.resultCode) == 1){	
				Utils.tipBar("success","保存成功",resJson.msg);	
			}else{
				Utils.tipBar("error","保存失败",resJson.msg);
			}
		};
		Utils.ajax(url,data,succFunc);
	});
});
</script>