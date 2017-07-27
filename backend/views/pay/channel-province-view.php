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
				<li role="presentation" class="active"><a href="#payLimitDiv" aria-controls="payLimitDiv" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span></a></li>
				<li role="presentation"><a href="#priceLimitDiv" aria-controls="priceLimitDiv" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-xbt" aria-hidden="true"></span></a></li>
				<li role="presentation"><a href="#timeLimitDiv" aria-controls="timeLimitDiv" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span></a></li>
			</ul>
		</div><hr><hr>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane fade in active"" id="payLimitDiv">
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
		</div>
	</div>
<div>