<ol class="breadcrumb">
<li class="active"><i class="fa fa-dashboard"></i>添加通道</li>
</ol>
<div class="main">
<div class="databar" style="width:98%;padding-left:20px">
 		<div style='display:inline-block;width:49%;'>
			<div class="input-group" style="padding-top:10px;">
				<span class="input-group-addon" style="width:120px">通道商</span>
				<select class="form-control" id="merchant" <?php echo $merchantId ? 'disabled' : '';?>>
				<?php foreach ($merchantList as $merchant){?>
					<option value="<?php echo $merchant['id']?>" <?php echo $merchantId == $merchant['id'] ? 'selected' : '';?>><?php echo $merchant['name']?></option>
				<?php }?>
				</select>
			</div>
						
			<div class="input-group" style="padding-top:10px;">
				<span class="input-group-addon" style="width:120px">代码名称</span>
				<input type="text" class="form-control"  aria-describedby="basic-addon1" id="name">
			</div>
						
			<div class="input-group" style="padding-top:10px;">
				<span class="input-group-addon" style="width:120px">代码标识</span>
				<input type="text" class="form-control"  aria-describedby="basic-addon1" id="sign">
			</div>
						
			<div class="input-group" style="padding-top:10px;">
				<span class="input-group-addon" style="width:120px">运营商 </span>
				&nbsp;&nbsp;
				<input onclick="this.value=(this.value==0)?1:0" type="checkbox" id="useMobile" value="0" >移动
				<input onclick="this.value=(this.value==0)?1:0" type="checkbox" id="useUnicom" value="0" >联通
				<input onclick="this.value=(this.value==0)?1:0" type="checkbox" id="useTelecom" value="0" >电信
			</div>
						
			<div class="input-group" style="padding-top:10px;">
				<span class="input-group-addon" style="width:120px">最低SDK版本</span>
				<select class="form-control" id="sdkVersion">
					<option value="3120" selected>V3120</option>
				</select>
			</div>
						
			<div class="input-group" style="padding-top:10px;">
				<span class="input-group-addon" style="width:120px">优化比例</span>
				<input type="text" class="form-control"  aria-describedby="basic-addon1" placeholder="百分比值" id="cutRate" >
			</div>
						
		</div>
					
		<div style='display:inline-block;padding-left:10px;width:49%;vertical-align:top'>
						
			<div class="input-group" style="padding-top:10px;">
				<span class="input-group-addon" style="width:120px">拿价</span>
				<input type="text" class="form-control"  placeholder="单位分"  aria-describedby="basic-addon1" id="inRate" >
			</div>
						
			<div class="input-group" style="padding-top:10px;">
				<span class="input-group-addon" style="width:120px">触发时间</span>
				<input type="text" class="form-control"  aria-describedby="basic-addon1" placeholder="单位/秒" id="waitTime" >
			</div>
						
			<div class="input-group" style="padding-top:10px;">
				<span class="input-group-addon" style="width:120px">开发类型</span>
					<select class="form-control" id="devType">
					<?php foreach ($channelDevTypeList as $key => $channelDevType){?>
						<option value="<?php echo $key?>"><?php echo $channelDevType?></option>
					<?php }?>
					</select>
			</div>
						
			<div class="input-group" style="padding-top:10px;">
				<span class="input-group-addon" style="width:120px">代码状态</span>
				<select class="form-control" id="status">
					<?php foreach ($channelStatusList as $key => $channelStatus){?>
						<option value="<?php echo $key?>"><?php echo $channelStatus?></option>
					<?php }?>
 				</select>
			</div>
						
			<div class="input-group" style="padding-top:10px;">
				<span class="input-group-addon" style="width:120px">冲突优先级</span>
				<input type="text" class="form-control mutexName"   id="priorityRate" placeholder="百分比值">
			</div>
		</div>
		<div style='margin-top: 10px'>
			<span  style='vertical-align: top'>备注：</span>
			<textarea rows="4"  id="remark" style="width:500px;margin-left:auto;margin-right:auto;border-radius:5px;"  ></textarea>
		</div>
		<div style='margin-top: 10px'>
		<button type="submit" class="btn btn-primary searchbar_smt" id="btn_add"> 添加 </button>
		</div>
			 
</div>
</div>

<script> 
$('#btn_add').on('click', function(event){
	 doAddChannel();
});
function doAddChannel(){
	var  url = '/register/add-channel-result';
	var  sign 			= $('#sign').val();
	var  merchant 		= $('#merchant').val();
	var  name 			= $('#name').val();
	var  useMobile	 	= $('#useMobile').val();
	var  useUnicom 		= $('#useUnicom').val();
	var  useTelecom 	= $('#useTelecom').val();
	var  sdkVersion 	= $('#sdkVersion').val();
	var  cutRate 		= $('#cutRate').val();
	var  inRate 		= $('#inRate').val();
	var  waitTime 		= $('#waitTime').val();
	var  devType 		= $('#devType').val();
	var  status 		= $('#status').val();
	var  priorityRate 	= $('#priorityRate').val();
	var  remark 		= $('#remark').val();
	
	var data = 'sign='+sign+'&merchant='+merchant+'&name='+name+'&useMobile='+useMobile+'&useUnicom='+useUnicom+'&useTelecom='+useTelecom+'&sdkVersion='+sdkVersion;
	data = data +'&cutRate='+cutRate+'&inRate='+inRate+'&waitTime='+waitTime+'&devType='+devType+'&status='+status+'&priorityRate='+priorityRate+'&remark='+remark;
	if(name != '' && merchant != ''){
		var succ 	= function(resultJson){
			alert(resultJson.msg);
			return;
		};
		Utils.ajax(url,data,succ);
	}else{
		alert('通道名称不能为空');
	}
}
</script>

