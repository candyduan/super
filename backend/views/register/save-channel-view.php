<ol class="breadcrumb">
<li class="active"><i class="fa fa-dashboard"></i>通道管理</li>
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
			<input type="hidden" id="rcid">
			<div class="input-group" style="padding-top:10px;">
				<span class="input-group-addon" style="width:120px">负责人</span>
				<select class="form-control" id="holder">
				<?php foreach ($adminList as $key => $val){?>
					<option value="<?php echo $key?>" ><?php echo $val?></option>
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
 					<option value="0" selected>无版本限制</option>
					<?php foreach ($sdkVersionList as $val){?>
					<option value="<?php echo $val['versionCode']?>" ><?php echo $val['versionName']?></option>
					<?php }?>
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
				<input type="text" class="form-control"  placeholder="单位分"  aria-describedby="basic-addon1" id="inPrice" >
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
		<button type="submit" class="btn btn-primary searchbar_smt" id="btn_save"> 保存 </button>
		</div>
			 
</div>
</div>

<script> 
$(document).ready(function(){
	var rcid  = Utils.getQueryString('rcid');
	if(parseInt(rcid) > 0){
		var url = '/register/detail-channel-result';
		var data='rcid='+rcid;
		var succFunc	= function(resJson){
			if(parseInt(resJson.resultCode) == 1){
				$('#rcid').val(resJson.item.rcid);
				$('#name').val(resJson.item.name);
				$('#sign').val(resJson.item.sign);
				$('#merchant').val(resJson.item.merchant);
 				$('#useMobile').val(resJson.item.useMobile);
 				$("#useMobile").prop("checked",parseInt(resJson.item.useMobile));
				$('#useUnicom').val(resJson.item.useUnicom);
				$("#useUnicom").prop("checked",parseInt(resJson.item.useUnicom));
				$('#useTelecom').val(resJson.item.useTelecom);
				$("#useTelecom").prop("checked",parseInt(resJson.item.useTelecom));
				$('#sdkVersion').val(resJson.item.sdkVersion);
				$('#cutRate').val(resJson.item.cutRate);
				$('#inPrice').val(resJson.item.inPrice);
				$('#waitTime').val(resJson.item.waitTime);	
				$('#devType').val(resJson.item.devType);	
				$('#status').val(resJson.item.status);	
				$('#priorityRate').val(resJson.item.priorityRate);	
				$('#remark').val(resJson.item.remark);	
				$('#holder').val(resJson.item.holder);	
			}		
		};
		Utils.ajax(url,data,succFunc);
	}
	$('#btn_save').click(function(){
		if($('#name').val() == ''){
			$('#name').addClass('input-err');
			return;
		}
		if($('#sign').val() == ''){
			$('#sign').addClass('input-err');
			return;
		}
		if($('#inPrice').val() == ''){
			$('#inPrice').addClass('input-err');
			return;
		} 
		var  url = '/register/save-channel-result';
		var  rcid 			= $('#rcid').val();
		var  sign 			= $('#sign').val();
		var  merchant 		= $('#merchant').val();
		var  name 			= $('#name').val();
		var  useMobile	 	= $('#useMobile').val();
		var  useUnicom 		= $('#useUnicom').val();
		var  useTelecom 	= $('#useTelecom').val();
		var  sdkVersion 	= $('#sdkVersion').val();
		var  cutRate 		= $('#cutRate').val();
		var  inPrice 		= $('#inPrice').val();
		var  waitTime 		= $('#waitTime').val();
		var  devType 		= $('#devType').val();
		var  status 		= $('#status').val();
		var  priorityRate 	= $('#priorityRate').val();
		var  remark 		= $('#remark').val();
		var  holder 		= $('#holder').val();
		
		var data = 'rcid='+rcid+'&sign='+sign+'&merchant='+merchant+'&name='+name+'&useMobile='+useMobile+'&useUnicom='+useUnicom;
		data = data +'&useTelecom='+useTelecom+'&sdkVersion='+sdkVersion+'&cutRate='+cutRate+'&inPrice='+inPrice+'&waitTime='+waitTime;
		data = data +'&devType='+devType+'&status='+status+'&priorityRate='+priorityRate+'&remark='+remark+'&holder='+holder;
		var succFunc	= function(resJson){
				if(parseInt(resJson.resultCode) == 1){
					Utils.getNoFooterModal("成功",resJson.msg);
				}else{
					Utils.getErrModal("保存失败",resJson.msg);
				}
			};
		Utils.ajax(url,data,succFunc);
	});
});

</script>

