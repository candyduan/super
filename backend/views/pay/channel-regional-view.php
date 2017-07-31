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
		<button class="btn btn-danger" id="oneKeyBtn">
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
		    			<td><input type='checkbox' id='checkAll' >全选</td>
		    			<td>省份</td>
		    			<td>状态</td>
		    			<td>单省日限额(元)</td>
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
										    <li role="presentation" class="active"><a href="#payLimitDiv" aria-controls="payLimitDiv" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span></a></li>
										    <li role="presentation"><a href="#priceLimitDiv" aria-controls="priceLimitDiv" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-xbt" aria-hidden="true"></span></a></li>
										    <li role="presentation"><a href="#timeLimitDiv" aria-controls="timeLimitDiv" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span></a></li>
 	 									</ul>
                                </div><hr><hr>
                                <div class="tab-content">
								  <div role="tabpanel" class="tab-pane fade in active" id="payLimitDiv">
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
											    		<tr style="display:none" id="newPriceT">
												    		<td><input type="text" id="newPrice" value=""></td>
												    		<td>-</td>
												    		<td id="checkPrice">--</td>
											    		</tr>
												</thead>
										   	 	<tbody id="priceList"></tbody>
										    	</table>
									    </div>
								  </div>
								  <div role="tabpanel" class="tab-pane fade" id="timeLimitDiv">
								  	 <?php for($i=0;$i<=23;$i++){ ?>
										<div class="hour swhour-close" id="h<?php echo $i;?>" data-val="0"><?php echo $i;?></div>
    									<?php }?>
    										<div class="text-center">
								  			<button type="button" class="btn btn-primary" id='timeLimitTemCommit'>开放时间模板设置</button>
								  		</div>
								  </div>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>

<!-- 一键操作窗口 -->
<div id="oneKeyDiv" class="modal fade" >
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <span><i class="glyphicon glyphicon-globe"></i></span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" style="height:200px">
            		<div>
	                <div class="inline">
	                    <span> 省份屏蔽: </span>
	                    <button type="submit" class="btn" id="btn_comfirm_open" data-val=''> 全省开通</button>
	                    <button type="submit" class="btn" id="btn_comfirm_ban" data-val=''> 全省屏蔽</button>
	                    <input type='hidden' id='allProvinceStatus' value=''>
	                </div>
                </div>
                <div >
              	  <div class="inline">
                    <span> 模板启用: </span>
                    <input id='templateOn' type="checkbox" name='templateOn' data-val="" >
                   </div>
                </div>
                <div class="text-center">
					<button type="button" class="btn btn-primary" id='oneKeyCommit'>一键地域设置</button>
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
		var chid = Utils.getQueryString('chid');
		var succ = function(resJson){
			console.log(resJson);
			if(parseInt(resJson.resultCode) == 1){
				//$('.channelName').html(resJson.channel.name);
				var resultHtml = '';
					$.each(resJson.list,function(key,val){
						resultHtml +='<tr>';
						resultHtml +='<td><input type="checkbox" name="province" data-val="'+val.pid+'"></td>';
						resultHtml +='<td><a href="/pay/channel-province-view?chid='+val.chid+'&pid='+val.pid+'">'+val.name+'</a></td>';
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
				var priceHtml = '';
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
				$('#h0').attr('data-val',template.time.h0);
				$('#h1').attr('data-val',template.time.h1);
				$('#h2').attr('data-val',template.time.h2);
				$('#h3').attr('data-val',template.time.h3);
				$('#h4').attr('data-val',template.time.h4);
				$('#h5').attr('data-val',template.time.h5);
				$('#h6').attr('data-val',template.time.h6);
				$('#h7').attr('data-val',template.time.h7);
				$('#h8').attr('data-val',template.time.h8);
				$('#h9').attr('data-val',template.time.h9);
				$('#h10').attr('data-val',template.time.h10);
				$('#h11').attr('data-val',template.time.h11);
				$('#h12').attr('data-val',template.time.h12);
				$('#h13').attr('data-val',template.time.h13);
				$('#h14').attr('data-val',template.time.h14);
				$('#h15').attr('data-val',template.time.h15);
				$('#h16').attr('data-val',template.time.h16);
				$('#h17').attr('data-val',template.time.h17);
				$('#h18').attr('data-val',template.time.h18);
				$('#h19').attr('data-val',template.time.h19);
				$('#h20').attr('data-val',template.time.h20);
				$('#h21').attr('data-val',template.time.h21);
				$('#h22').attr('data-val',template.time.h22);
				$('#h23').attr('data-val',template.time.h23);
				$.each(template.time,function(k,v){
					if(v == 1){
						$('#'+k).removeClass('swhour-close').addClass('swhour-open');
					}else{
						$('#'+k).removeClass('swhour-open').addClass('swhour-close');
					}
				})
				
				$('#priceList').html(priceHtml);
					
			}
			$('#channelProvinceTemplate').modal('show');
			
			$('.priceStatusChange').click(function(){
				var obj = $(this);
				var status = $(this).attr('status');
				var price = $(this).attr('tel');
				var time = getCurrentTime();
				var url = '/pay/channel-province-template-price-status-change';
				var data = 'price='+price+'&chid='+Utils.getQueryString('chid')+'&time='+time;
				var succ = function(resJson){
					if(parseInt(resJson.resultCode) == 1){
						if(status == 1){
							obj.removeClass('glyphicon-ok').addClass('glyphicon-remove').attr('status','0');
						}else{
							obj.removeClass('glyphicon-remove').addClass('glyphicon-ok').attr('status','1');
						}
						Utils.tipBar('success','地域更新成功',resJson.msg);
					}else{
						Utils.tipBar('error','地域更新失败',resJson.msg);
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
				Utils.tipBar('success','保存成功',resJson.msg);
			}else{
				Utils.tipBar('error','保存失败',resJson.msg);
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
							newPriceHtml += '<tr><td>'+newPrice+'</td><td>'+time+'</td><td><span class="glyphicon glyphicon-remove priceStatusChange" tel="'+newPrice+'" status="'+0+'" aria-hidden="true"></span></td></tr>';
							$('#priceList').append(newPriceHtml);
							Utils.tipBar('success','价格点设置成功',resJson.msg);	
						}else{
							$('#newPrice').val('');
							$('#checkPrice').html('--')
							$('#newPriceT').toggle();
							Utils.tipBar('error','价格点设置失败',resJson.msg);
						}

						$('.priceStatusChange').click(function(){
							var obj = $(this);
							var status = $(this).attr('status');
							var price = $(this).attr('tel');
							var time = getCurrentTime();
							var url = '/pay/channel-province-template-price-status-change';
							var data = 'price='+price+'&chid='+Utils.getQueryString('chid')+'&time='+time;
							var succ = function(resJson){
								if(parseInt(resJson.resultCode) == 1){
									if(status == 1){
										obj.removeClass('glyphicon-ok').addClass('glyphicon-remove').attr('status','0');
									}else{
										obj.removeClass('glyphicon-remove').addClass('glyphicon-ok').attr('status','1');
									}
									Utils.tipBar('success','保存成功',resJson.msg);
								}else{
									Utils.tipBar('error','保存失败',resJson.msg);
								}
							}
							Utils.ajax(url,data,succ);
						})	
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

	$('.hour').click(function(){
		if($(this).attr('data-val') == 1){
			$(this).attr('data-val','0').removeClass('swhour-open').addClass('swhour-close');
		}else{
			$(this).attr('data-val','1').removeClass('swhour-close').addClass('swhour-open');
		}
	})

	$('#timeLimitTemCommit').click(function(){
		var url = '/pay/channel-province-template-time-limit-save';
		var data= 'chid='+Utils.getQueryString('chid')
				+'&h0='+$('#h0').attr('data-val')
				+'&h1='+$('#h1').attr('data-val')
				+'&h2='+$('#h2').attr('data-val')
				+'&h3='+$('#h3').attr('data-val')
				+'&h4='+$('#h4').attr('data-val')
				+'&h5='+$('#h5').attr('data-val')
				+'&h6='+$('#h6').attr('data-val')
				+'&h7='+$('#h7').attr('data-val')
				+'&h8='+$('#h8').attr('data-val')
				+'&h9='+$('#h9').attr('data-val')
				+'&h10='+$('#h10').attr('data-val')
				+'&h11='+$('#h11').attr('data-val')
				+'&h12='+$('#h12').attr('data-val')
				+'&h13='+$('#h13').attr('data-val')
				+'&h14='+$('#h14').attr('data-val')
				+'&h15='+$('#h15').attr('data-val')
				+'&h16='+$('#h16').attr('data-val')
				+'&h17='+$('#h17').attr('data-val')
				+'&h18='+$('#h18').attr('data-val')
				+'&h19='+$('#h19').attr('data-val')
				+'&h20='+$('#h20').attr('data-val')
				+'&h21='+$('#h21').attr('data-val')
				+'&h22='+$('#h22').attr('data-val')
				+'&h23='+$('#h23').attr('data-val');
		var succ = function(resJson){
			if(parseInt(resJson.resultCode) == 1){
				Utils.tipBar('success','保存成功',resJson.msg);
			}else{
				Utils.tipBar('error','保存失败',resJson.msg);
			}
		};
		Utils.ajax(url,data,succ); 
	})
	
	$(".form_datetime").datetimepicker({
		format: 'yyyy-mm-dd hh:ii:ss',
		todayBtn:1,
		todayHighlight:1,
	});

	//一键启用模板和地域设置
	
	$('#checkAll').click(function(){
		var isChecked = this.checked;
		$('[name=province]:checkbox').prop('checked',isChecked);
	})
	
	$('#oneKeyBtn').click(function(){
		$('#btn_comfirm_open').removeClass('btn-success');
		$('#btn_comfirm_ban').removeClass('btn-danger');
		$('#allProvinceStatus').val('');
		$('#templateOn').prop('checked',false).attr('data-val','0');
		$('#oneKeyDiv').modal('show');
	})
	
	$('#btn_comfirm_open').click(function(){
		$(this).addClass('btn-success');
		$('#btn_comfirm_ban').removeClass('btn-danger');
		$('#allProvinceStatus').val('1');
	});

	$('#btn_comfirm_ban').click(function(){
		$(this).addClass('btn-danger');
		$('#btn_comfirm_open').removeClass('btn-success');
		$('#allProvinceStatus').val('0');
	});

	$('#oneKeyCommit').click(function(){
		var province = '';
		$('[name=province]:checked').each(function(){
			province += $(this).attr('data-val')+',';	
		})
		if(province == ''){
			Utils.getNoFooterModal('Alert','请选择省份');
			return false;
		}
		var allProvinceStatus = $('#allProvinceStatus').val();
		if(allProvinceStatus == ''){
			Utils.getNoFooterModal('Alert','请选择全省开通或全省屏蔽');
			return false;
		}
		var templateOn = $('#templateOn').prop('checked') ? 1 : 0;
		var url = '/pay/channel-province-one-key-sync';
		var data = 'chid='+Utils.getQueryString('chid')+'&province='+province+'&allProvinceStatus='+allProvinceStatus+'&templateOn='+templateOn;
		var succ = function(resJson){
			if(parseInt(resJson.resultCode) == 1){
				Utils.tipBar('success','一键同步完成',resJson.msg);
			}else{
				Utils.tipBar('error','一键同步失败',resJson.msg);
			}
		}
		Utils.ajax(url,data,succ);
	})

	
</script>