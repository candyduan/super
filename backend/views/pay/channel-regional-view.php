<style>
.hour{width:60px;height:60px;border-radius:30px;margin-right:10px;margin-bottom:10px;line-height:60px;text-align:center;font-weight:bold;display:inline-block;}
</style>
<ol class="breadcrumb">
<li><a href="/pay/channel-view">通道管理</a></li>
<li class="active">省份</li>
<li class="channelName"></li>
</ol>
<?php echo backend\library\widgets\WidgetsUtils::getChannelQuickIn($chid);?>

<div class="row">
	<div class="col-sm-10 col-md-10 col-lg-10" text-align='center'>
		<button class="btn btn-primary" type="submit" id="templateBtn">
		<span>模板设置</span>
		</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="btn btn-danger" id="keyBtn">
		<span>一键操作</span>
		</button>&nbsp;
	 </div>
</div>
<hr>

<div class="main">
	<!-- 数据栏 -->
    <div class="databar">
	    	<table class="table table-bordered table-hover" text-align='center'>
		    	<thead>
		    		<tr>
		    			<td>全选</td>
		    			<td>省份</td>
		    			<td>状态</td>
		    			<td>单省日限额</td>
		    			<td>价格点</td>
		    			<td>时间限制</td>
		    			<td>解冻时间</td>
		    		</tr>
			</thead>
	   	 	<tbody id="data_list"></tbody>
	    	</table>
    </div>
</div>

<div id="channelProvinceTemplate" class="modal fade" >
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
                <span>通道省份模板设置 </span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
                <div class="modal-body" >
                    <div class="panel ">
                        <!-- panel heading -->
                        <!-- panel body -->
                        <div class="panel-body">
                            	<div class="col-sm-12 col-md-12 col-lg-12">
                                       <ul class="nav nav-tabs" role="tablist">
										    <li role="presentation" class="active"><a href="#provinceLimitDiv" aria-controls="provinceLimitDiv" role="tab" data-toggle="tab">Home</a></li>
										    <li role="presentation"><a href="#payLimitDiv" aria-controls="payLimitDiv" role="tab" data-toggle="tab">Profile</a></li>
										    <li role="presentation"><a href="#priceLimitDiv" aria-controls="priceLimitDiv" role="tab" data-toggle="tab">Messages</a></li>
										    <li role="presentation"><a href="#timeLimitDiv" aria-controls="timeLimitDiv" role="tab" data-toggle="tab">Settings</a></li>
 	 									</ul>
                                </div><hr><hr>
                                <div class="tab-content">
								  <div role="tabpanel" class="tab-pane fade in active" id="provinceLimitDiv">
								  		
								  </div>
								  <div role="tabpanel" class="tab-pane fade" id="payLimitDiv">
								   		<div class="input-group">
  											<span class="input-group-addon" id="basic-addon1">日限额</span>
  											<input type="text" class="form-control" placeholder="日支付限额：元" aria-describedby="basic-addon1" id="dayLimitTemp" value=''>
  											<input type="text" class="form-control" placeholder="日请求限额：元" aria-describedby="basic-addon1" id='dayRequestLimitTemp' value=''>
										</div>
										<div class="input-group">
  											<span class="input-group-addon" id="basic-addon2">月限额</span>
  											<input type="text" class="form-control" placeholder="月支付限额：元" aria-describedby="basic-addon2" id='monthLimitTemp' value=''>
  											<input type="text" class="form-control" placeholder="月请求限额：元" aria-describedby="basic-addon2" id='monthRequestLimitTemp' value=''>
										</div>
										<div class="input-group">
  											<span class="input-group-addon" id="basic-addon3">用户日限额</span>
  											<input type="text" class="form-control" placeholder="用户日支付限额：元" aria-describedby="basic-addon3" id='playerDayLimitTemp' value=''>
  											<input type="text" class="form-control" placeholder="用户日请求限额：元" aria-describedby="basic-addon3" id='playerDayRequestLimitTemp' value=''>
										</div>
										<div class="input-group">
  											<span class="input-group-addon" id="basic-addon4">用户月限额</span>
  											<input type="text" class="form-control" placeholder="用户月支付限额：元" aria-describedby="basic-addon4" id='playerMonthLimitTemp' value=''>
  											<input type="text" class="form-control" placeholder="用户月请求限额：元" aria-describedby="basic-addon4" id='playerMonthRequestLimitTemp' value=''>
										</div>
										<div class="input-group">
  											<span class="input-group-addon" id="basic-addon5">冻结时间</span>
							                <input size="20" type="text" value="" readonly class="form_datetime" id='freezeTimeTemp'>
								  		</div>
								  		<div class="text-center">
								  			<button type="button" class="btn btn-primary" id='priceLimitTemCommit'>限额模板设置</button>
								  		</div>
								  	</div>
								  <div role="tabpanel" class="tab-pane fade" id="priceLimitDiv">
								  		<div class="databar">
										    	<table class="table table-bordered table-hover" text-align='center'>
											    	<thead>
											    		<tr>
											    			<td>价格(分)</td>
											    			<td>更新时间</td>
											    			<td>管理
												    			<button type="button" class="btn btn-sm" aria-label="Left Align" id='addNewPrice'>
	  															<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
															</button>
											    			</td>
											    		</tr>
												</thead>
										   	 	<tbody id="priceList"></tbody>
										    	</table>
									    </div>
								  </div>
								  <div role="tabpanel" class="tab-pane fade" id="timeLimitDiv">..4.</div>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>

<script>
	$(document).ready(function(){
		setResult();
	})
	function setResult(){
		var url = '/pay/channel-regional-limit-result';
		var data = 'chid='+Utils.getQueryString('chid');
		var succ = function(resJson){
			console.log(resJson);
			if(parseInt(resJson.resultCode) == 1){
				//$('.channelName').html(resJson.channel.name);
				var resultHtml = '';
					$.each(resJson.list,function(key,val){
						resultHtml +='<tr>';
						resultHtml +='<td>'+2222+'</td>';
						resultHtml +='<td>'+val.name+'</td>';
						resultHtml +='<td>'+val.status+'</td>';
						resultHtml +='<td>'+val.dayLimit+'</td>';
						resultHtml +='<td>'+val.priceStatus+'</td>';
						resultHtml +='<td>'+val.timeProvinceLimit+'</td>';
						resultHtml +='<td>'+val.unfreezeTime+'</td>';
						resultHtml +='</tr>';
					})
				$('#data_list').append(resultHtml);
			}
		}
		Utils.ajax(url,data,succ); 
	}

	$('#templateBtn').click(function(){
		var url = '/pay/channel-province-template-view';
		var data = 'chid='+Utils.getQueryString('chid');
		var succ = function(resJson){
			if(parseInt(resJson.resultCode) == 1){
				var template = resJson.data;
				var price = template.price;
				var priceHtml = '<tr style="display:none" id="newPriceT"><td><input type="text" id="newPrice" value=""></td><td>-</td><td id="checkPrice">--</td></tr>';
				$('#dayLimitTemp').val(template.dayLimit);
				$('#dayRequestLimitTemp').val(template.dayRequestLimit);
				$('#monthLimitTemp').val(template.monthLimit);
				$('#monthRequestLimitTemp').val(template.monthRequestLimit);
				$('#playerDayLimitTemp').val(template.playerDayLimit);
				$('#playerDayRequestLimitTemp').val(template.playerDayRequestLimit);
				$('#playerMonthLimitTemp').val(template.playerMonthLimit);
				$('#playerMonthRequestLimitTemp').val(template.playerMonthRequestLimit);
				$('#freezeTimeTemp').val(template.unFreezeTime);
				$.each(price,function(i,v){
					priceHtml += '<tr>';
					priceHtml += '<td>'+v.price+'</td>';
					priceHtml += '<td>'+v.time+'</td>';
					priceHtml += '<td>'+(v.status == 1 ? '<span class="glyphicon glyphicon-ok priceStatusChange"  tel="'+v.price+'" status="'+v.status+'"  aria-hidden="true"></span>' : '<span class="glyphicon glyphicon-remove priceStatusChange" tel="'+v.price+'" status="'+v.status+'" aria-hidden="true"></span>')+'</td>';
					priceHtml += '</tr>';
				})
				$('#priceList').html(priceHtml);
					
			}
			$('#channelProvinceTemplate').modal('show');
			
			$('.priceStatusChange').click(function(){
// 				alert($(this).attr('status'));
// 				if($(this).attr('status')==1){
// 					$(this).removeClass('glyphicon-ok').addClass('glyphicon-remove').attr('status','0');
					
// 				}else{
// 					$(this).removeClass('glyphicon-remove').addClass('glyphicon-ok').attr('status','1');
// 				}


				var price = $(this).attr('tel');
				var time = getCurrentTime();
				var url = '/pay/channel-province-template-price-status-change';
				var data = 'price='+price+'&chid='+Utils.getQueryString('chid')+'&time='+time;
				var succ = function(resJson){
					if(parseInt(resJson.resultCode) == 1){
						
					}
				}
				Utils.ajax(url,data,succ);
			})
			
		}		
		Utils.ajax(url,data,succ);
	})
	
	$('#priceLimitTemCommit').click(function(){
		var url = '/pay/channel-province-template-price-limit-save';
		var dayLimitTemp = $('#dayLimitTemp').val();
		var monthLimitTemp = $('#monthLimitTemp').val();
		var playerDayLimitTemp = $('#playerDayLimitTemp').val();
		var playerMonthLimitTemp = $('#playerMonthLimitTemp').val();
		var dayRequestLimitTemp = $('#dayRequestLimitTemp').val();
		var monthRequestLimitTemp = $('#monthRequestLimitTemp').val();
		var playerDayRequestLimitTemp = $('#playerDayRequestLimitTemp').val();
		var playerMonthRequestLimitTemp = $('#playerMonthRequestLimitTemp').val();
		var freezeTimeTemp = $('#freezeTimeTemp').val();
		freezeTimeTemp = Date.parse(new Date(freezeTimeTemp)) / 1000;
		var data = 'chid='+Utils.getQueryString('chid')
							+'&dayLimitTemp='+dayLimitTemp
							+'&monthLimitTemp='+monthLimitTemp
							+'&playerDayLimitTemp='+playerDayLimitTemp
							+'&playerMonthLimitTemp='+playerMonthLimitTemp
							+'&dayRequestLimitTemp='+dayRequestLimitTemp
							+'&monthRequestLimitTemp='+monthRequestLimitTemp
							+'&playerDayRequestLimitTemp='+playerDayRequestLimitTemp
							+'&playerMonthRequestLimitTemp='+playerMonthRequestLimitTemp
							+'&freezeTimeTemp='+freezeTimeTemp;
		var succ = function(resJson){
			if(parseInt(resJson.resultCode) == 1){
				Utils.getNoFooterModal('success','保存成功');
			}else{
				Utils.getErrModal('error',resJson.msg);
			}
		}
		Utils.ajax(url,data,succ); 
	});

	$('#addNewPrice').click(function(){
		$('#newPrice').val('');
		$('#checkPrice').html('--')
		$('#newPriceT').toggle();

		$("#newPrice").bind('input',function(){
			var newPrice = $(this).val();
			var regCode=/^(\d)*$/;
			var rs = ""; 
			if(!regCode.test(newPrice)){
				 for (var i = 0; i < newPrice.length; i++) { 
					 if(regCode.test(newPrice.substr(i, 1)))
				        rs = rs+newPrice.substr(i, 1);
				    } 
				 newPrice = rs;
				$(this).val(newPrice);
				return false;
			}
			if(newPrice == ''){
				$('#checkPrice').html('--');
			}else{
				$('#checkPrice').html('<span class="glyphicon glyphicon-ok btn-success" id="newPriceCommitBtn"  aria-hidden="true"></span>');
			}
			
			$('#newPriceCommitBtn').click(function(){
				if(confirm('Are you sure?')){
					var newPrice = $('#newPrice').val();
					var time = getCurrentTime();
					var url = '/pay/channel-province-template-newprice-add';
					var newPriceHtml = '';
					var data = 'newPrice='+newPrice+'&chid='+Utils.getQueryString('chid')+'&time=' + time;
					var succ = function(resJson){
						if(parseInt(resJson.resultCode) == 1){
							$('#newPrice').val('');
							$('#checkPrice').html('--');
							$('#newPriceT').toggle();
							newPriceHtml += '<tr><td>'+newPrice+'</td><td>'+time+'</td><td><span class="glyphicon glyphicon-remove priceStatusChange" tel="'+newPrice+'" aria-hidden="true"></span></td></tr>';
							$('#priceList').append(newPriceHtml);	
						}else{
							$('#newPrice').val('');
							$('#checkPrice').html('--')
							$('#newPriceT').toggle();
							Utils.getErrModal('error',resJson.msg);
						}
					}	
					Utils.ajax(url,data,succ); 
				}
			})
		})
	})
	

	
	
	
	function getCurrentTime(){
		var time = new Date();
		var year=time.getFullYear();
		var month=time.getMonth()+1;
		var date=time.getDate();
		var hour=time.getHours();
		var minute=time.getMinutes();
		var second=time.getSeconds();
		return year+"-"+month+"-"+date+" "+hour+":"+minute+":"+second;
	};
	
	$(".form_datetime").datetimepicker({
		format: 'yyyy-mm-dd hh:ii:ss',
		todayBtn:1,
		todayHighlight:1,
	});
</script>