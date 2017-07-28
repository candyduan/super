<style>
.hour{width:60px;height:60px;border-radius:30px;margin-right:10px;margin-bottom:10px;line-height:60px;text-align:center;font-weight:bold;display:inline-block;}
</style>
<ol class="breadcrumb">
<li><a href="/pay/channel-view">通道管理</a></li>
<li class="active">省份</li>
<li class="channelName"></li>
</ol>
 <div class="panel ">
	<!-- panel heading -->
	<!-- panel body -->
	<div class="panel-body">
		<div class="col-sm-12 col-md-12 col-lg-12">
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#provinceLimitDiv" aria-controls="provinceLimitDiv" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span></a></li>
				<li role="presentation" ><a href="#payLimitDiv" aria-controls="payLimitDiv" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span></a></li>
				<li role="presentation"><a href="#priceLimitDiv" aria-controls="priceLimitDiv" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-xbt" aria-hidden="true"></span></a></li>
				<li role="presentation"><a href="#timeLimitDiv" aria-controls="timeLimitDiv" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span></a></li>
			</ul>
		</div><hr><hr>
		<div class="tab-content">
			
			<!-- 省份地域设置 -->
			<div role="tabpanel" class="tab-pane fade in active"" id="provinceLimitDiv">
				<div class="modal-body" style="height:200px">
	            		<div>
		                <div class="">
		                    <span> 省份屏蔽: </span>
		                    <button type="submit" class="btn" id="btn_comfirm_open" data-val=''> 全省开通</button>
		                    <button type="submit" class="btn" id="btn_comfirm_some" data-val=''> 按城市屏蔽</button>
		                    <button type="submit" class="btn" id="btn_comfirm_ban" data-val=''> 全省屏蔽</button>
		                    <input type='hidden' id='allProvinceStatus' value=''>
		                    <button type="button" class="btn btn-default" id='provinceCommit'>地域设置</button>
		                </div>
	                	 </div>
	                 <div class="city_div" style='display: none'>
	                    <span> 城市列表: </span>
		              </div>
		              <div class="city_div" style='display: none'>
		             	 <div class="tab-content inline" id='cityLimitInfo'>
	                    <?php foreach($citys as $city){ ?>
	                    <button type="submit" class="btn btn-success city_btn" id='city<?=$city['id']?>' data-deleted='1'  data-val='<?=$city['id']?>'><?=$city['name']?></button>
	                    <?php }?>
	                    </div>
		              
		              </div>
	                
            		</div>
			</div>
			<!-- 限额 -->
			<div role="tabpanel" class="tab-pane fade" id="payLimitDiv">
				<div class="input-group">
  					<span class="input-group-addon" id="basic-addon1">日限额</span>
  					<input type="text" class="form-control" placeholder="日支付限额：元" aria-describedby="basic-addon1" id="dayLimit" value=''>
  					<input type="text" class="form-control" placeholder="日请求限额：元" aria-describedby="basic-addon1" id='dayRequestLimit' value=''>
				</div>
				<div class="input-group">
  					<span class="input-group-addon" id="basic-addon2">月限额</span>
  					<input type="text" class="form-control" placeholder="月支付限额：元" aria-describedby="basic-addon2" id='monthLimit' value=''>
  					<input type="text" class="form-control" placeholder="月请求限额：元" aria-describedby="basic-addon2" id='monthRequestLimit' value=''>
				</div>
				<div class="input-group">
  					<span class="input-group-addon" id="basic-addon3">用户日限额</span>
  					<input type="text" class="form-control" placeholder="用户日支付限额：元" aria-describedby="basic-addon3" id='playerDayLimit' value=''>
  					<input type="text" class="form-control" placeholder="用户日请求限额：元" aria-describedby="basic-addon3" id='playerDayRequestLimit' value=''>
				</div>
				<div class="input-group">
  					<span class="input-group-addon" id="basic-addon4">用户月限额</span>
  					<input type="text" class="form-control" placeholder="用户月支付限额：元" aria-describedby="basic-addon4" id='playerMonthLimit' value=''>
  					<input type="text" class="form-control" placeholder="用户月请求限额：元" aria-describedby="basic-addon4" id='playerMonthRequestLimit' value=''>
				</div>
				<div class="input-group">
  					<span class="input-group-addon" id="basic-addon5">冻结时间</span>
					<input size="20" type="text" value="" readonly class="form_datetime" id='unfreezeTime'>
				</div>
				<div class="text-center">
					<button type="button" class="btn btn-primary" id='priceLimitCommit'>限额设置</button>
				</div>
			</div>
			<!-- 价格点 -->
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
					<button type="button" class="btn btn-primary" id='timeLimitTemCommit'>开放时间设置</button>
				</div>
			</div>
			
		</div>
	</div>
<div>
<script>
$(".form_datetime").datetimepicker({
	format: 'yyyy-mm-dd hh:ii:ss',
	todayBtn:1,
	todayHighlight:1,
});
var cityOpenArray = [];
var cityDelArray = [];

$(document).ready(function(){
	setResult();
})
function setResult(){
	var url = '/pay/channel-province-result';
	var data = 'chid='+Utils.getQueryString('chid')+'&pid='+Utils.getQueryString('pid');
	var succ = function(resJson){
		console.log(resJson);
		if(parseInt(resJson.resultCode) == 1){
			var provinceLimit = resJson.provinceLimit;
			var cityLimitList = resJson.cityLimitList;
			var channelProvincePriceList = resJson.channelProvincePriceList;
			var timeProvinceLimit = resJson.timeProvinceLimit;
			//provinceLimit
			if(provinceLimit.opened == 1){
				$('#btn_comfirm_open').addClass('btn-success');
				$('#allProvinceStatus').val('1')
			}else if(provinceLimit.opened == 0){
				$('#btn_comfirm_ban').addClass('btn-danger');
				$('#allProvinceStatus').val('0')
			}else if(provinceLimit.opened == 2){
				$('#btn_comfirm_some').addClass('btn-info');
				$('#allProvinceStatus').val('2')
				$('.city_div').show();
				if(cityLimitList){
					$.each(cityLimitList,function(k,v){
						if(v.deleted == 0){
							$('#city'+v.id).removeClass('btn-success').addClass('btn-danger').attr('data-deleted','0');
							
						}else{
							$('#city'+v.id).removeClass('btn-danger').addClass('btn-success').attr('data-deleted','1');
							//cityOpenArray.push(v.id);
						}
					})
				}
			}
			$('#dayLimit').val(provinceLimit.dayLimit);
			$('#monthLimit').val(provinceLimit.monthLimit);
			$('#playerDayLimit').val(provinceLimit.playerDayLimit);
			$('#playerMonthLimit').val(provinceLimit.playerMonthLimit);
			$('#dayRequestLimit').val(provinceLimit.dayRequestLimit);
			$('#monthRequestLimit').val(provinceLimit.monthRequestLimit);
			$('#playerDayRequestLimit').val(provinceLimit.playerDayRequestLimit);
			$('#playerMonthRequestLimit').val(provinceLimit.playerMonthRequestLimit);
			$('#unfreezeTime').val(provinceLimit.unfreezeTime);
			//channelProvincePriceList
			var priceListHtml = '';
			if(channelProvincePriceList){
				$.each(channelProvincePriceList,function(k,v){
					priceListHtml += '<tr>';
					priceListHtml += '<td>'+v.price+'</td>';
					priceListHtml += '<td>'+v.updateTime+'</td>';
					priceListHtml += '<td>'+(v.status == 1 ? '<span class="glyphicon glyphicon-ok priceStatusChange"  tel="'+v.price+'" status="'+v.status+'"  aria-hidden="true"></span>' : '<span class="glyphicon glyphicon-remove priceStatusChange" tel="'+v.price+'" status="'+v.status+'" aria-hidden="true"></span>')+'</td>';
					priceListHtml += '</tr>';
				})
				$('#priceList').append(priceListHtml);
			}
			//timeProvinceLimit
			if(timeProvinceLimit){
				$.each(timeProvinceLimit,function(k,v){
					$('#'+k).attr('data-val',v);
					if(v == 1){
						$('#'+k).removeClass('swhour-close').addClass('swhour-open');
					}else{
						$('#'+k).removeClass('swhour-open').addClass('swhour-close');
					}
				})
			}
		}else{
			//TD
		}
		//价格点上下线
		$('.priceStatusChange').click(function(){
		var obj = $(this);
		var status = $(this).attr('status');
		var price = $(this).attr('tel');
		var url = '/pay/channel-province-price-status-change';
		var data = 'price='+price+'&chid='+Utils.getQueryString('chid')+'&pid='+Utils.getQueryString('pid');
		var succ = function(resJson){
			if(parseInt(resJson.resultCode) == 1){
				if(status == 1){
					obj.removeClass('glyphicon-ok').addClass('glyphicon-remove').attr('status','0');
				}else{
					obj.removeClass('glyphicon-remove').addClass('glyphicon-ok').attr('status','1');
				}
				Utils.tipBar('success','价格点设置成功',resJson.msg);
			}else{
				Utils.tipBar('error','价格点设置失败',resJson.msg);
			}
		}
		Utils.ajax(url,data,succ);
	})	
	}
	Utils.ajax(url,data,succ); 
}

$('#btn_comfirm_open').click(function(){
	$(this).addClass('btn-success');
	$('#btn_comfirm_some').removeClass('btn-info');
	$('#btn_comfirm_ban').removeClass('btn-danger');
	$('#allProvinceStatus').val('1');
	$('.city_div').css('display','none');
})
$('#btn_comfirm_some').click(function(){
	$(this).addClass('btn-info');
	$('#btn_comfirm_open').removeClass('btn-success');
	$('#btn_comfirm_ban').removeClass('btn-danger');
	$('#allProvinceStatus').val('2');
	$('.city_div').css('display','block');
})
$('#btn_comfirm_ban').click(function(){
	$(this).addClass('btn-danger');
	$('#btn_comfirm_open').removeClass('btn-success');
	$('#btn_comfirm_some').removeClass('btn-info');
	$('#allProvinceStatus').val('0');
	$('.city_div').css('display','none');
})

$('.city_btn').click(function(){
	if($(this).attr('data-deleted') == 1){
		$(this).removeClass('btn-success').addClass('btn-danger').attr('data-deleted','0');
	}else{
		$(this).removeClass('btn-danger').addClass('btn-success').attr('data-deleted','1');
	}
})

$('#provinceCommit').click(function(){
	if(confirm('是否确定更新地域')){
		var opened;
		var cityOpen = [];
		var cityBan = [];
		opened = $('#allProvinceStatus').val() ;
		if(opened == 2){
			$('.city_btn').each(function(){
				var city_deleted = $(this).attr('data-deleted');
					if(city_deleted == 1){
						cityOpen.push($(this).attr('data-val'));
					}else{
						cityBan.push($(this).attr('data-val'));	
					}
			})
			if(cityBan.length == 0){
				alert('至少选择一个屏蔽的城市');
				return ;
			}
		}
		var url = '/pay/channel-province-save';
		var data = 'chid='+Utils.getQueryString('chid')+'&pid='+Utils.getQueryString('pid')+'&opened='+opened+'&cityOpen='+cityOpen.toString()+'&cityBan='+cityBan.toString();
		var succ = function(resJson){
			if(parseInt(resJson.resultCode) == 1){
				Utils.tipBar('success','地域更新成功',resJson.msg);
			}else{
				Utils.tipBar('error','地域更新失败',resJson.msg);
			}
		}
	Utils.ajax(url,data,succ); 
	}
})

$('#priceLimitCommit').click(function(){
	var url = '/pay/channel-province-price-limit-save';
	var dayLimit = $('#dayLimit').val();
	var monthLimit = $('#monthLimit').val();
	var playerDayLimit = $('#playerDayLimit').val();
	var playerMonthLimit = $('#playerMonthLimit').val();
	var dayRequestLimit = $('#dayRequestLimit').val();
	var monthRequestLimit = $('#monthRequestLimit').val();
	var playerDayRequestLimit = $('#playerDayRequestLimit').val();
	var playerMonthRequestLimit = $('#playerMonthRequestLimit').val();
	var unfreezeTime = $('#unfreezeTime').val();
	unfreezeTime = Date.parse(new Date(unfreezeTime)) / 1000;
	var data = 'chid='+Utils.getQueryString('chid')
						+'&pid='+Utils.getQueryString('pid')
						+'&dayLimit='+dayLimit
						+'&monthLimit='+monthLimit
						+'&playerDayLimit='+playerDayLimit
						+'&playerMonthLimit='+playerMonthLimit
						+'&dayRequestLimit='+dayRequestLimit
						+'&monthRequestLimit='+monthRequestLimit
						+'&playerDayRequestLimit='+playerDayRequestLimit
						+'&playerMonthRequestLimit='+playerMonthRequestLimit
						+'&unfreezeTime='+unfreezeTime;
	var succ = function(resJson){
		if(parseInt(resJson.resultCode) == 1){
			Utils.tipBar('success','限额设置成功',resJson.msg);
		}else{
			Utils.tipBar('error','限额设置失败',resJson.msg);
		}
	}
	Utils.ajax(url,data,succ); 
})

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
				var url = '/pay/channel-province-price-add';
				var newPriceHtml = '';
				var time = getCurrentTime();
				var data = 'newPrice='+newPrice+'&chid='+Utils.getQueryString('chid')+'&pid='+Utils.getQueryString('pid');
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
						var url = '/pay/channel-province-price-status-change';
						var data = 'price='+price+'&chid='+Utils.getQueryString('chid')+'&pid='+Utils.getQueryString('pid');
						var succ = function(resJson){
							if(parseInt(resJson.resultCode) == 1){
								if(status == 1){
									obj.removeClass('glyphicon-ok').addClass('glyphicon-remove').attr('status','0');
								}else{
									obj.removeClass('glyphicon-remove').addClass('glyphicon-ok').attr('status','1');
								}
								Utils.tipBar('success','价格点设置成功',resJson.msg);
							}else{
								Utils.tipBar('error','价格点设置失败',resJson.msg);
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
		var url = '/pay/channel-province-time-limit-save';
		var data= 'chid='+Utils.getQueryString('chid')
				+'&pid='+Utils.getQueryString('pid')
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








</script>