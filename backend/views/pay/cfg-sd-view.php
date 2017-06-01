<?php 
use backend\library\widgets\PayCfgWidgets;

$channelModel   = $channelModel;
$payParamsModel = $payParamsModel;
$mainModel         = $mainModel;
$sdModel           = $sdModel;
$sdNApiModel       = $sdNApiModel;
$sdYApiModel       = $sdYApiModel;
$syncModel         = $syncModel;

if($channelModel->devType == CHANNEL_DOUBLE){
    $sms2Display    = "display:block;";
}else{
    $sms2Display    = "display:none;";
}
$newSms1    = array();
$newSms2    = array();
if($sdNApiModel){
    $sms1   = json_decode($sdNApiModel->sms1,true);
    $sms2   = json_decode($sdNApiModel->sms2,true);
    if(!is_array($sms1)){
        $sms1   = [];
    }
    if(!is_array($sms2)){
        $sms2   = [];
    }
    foreach ($sms1 as $fee => $val){
        $item   = array(
            'fee'       => $fee,
            'spnumber'  => $val['spnumber'],
            'cmd'       => $val['cmd'],
            'sendtype'  => $val['sendtype'],
        );
        array_push($newSms1, $item);
    }
    foreach ($sms2 as $fee => $val){
        $item   = array(
            'fee'       => $fee,
            'spnumber'  => $val['spnumber'],
            'cmd'       => $val['cmd'],
            'sendtype'  => $val['sendtype'],
        );
        array_push($newSms2, $item);
    }
}

$sendInterval   = 0;
if($sdYApiModel){
    if(is_numeric($sdYApiModel->sendInterval)){
        $sendInterval =  $sdYApiModel->sendInterval;
    }
}

?>
<ol class="breadcrumb">
<li>通道配置</li>
<li class="active"><?php echo '['.$channelModel->id.']'.$channelModel->name;?></li>
</ol>
<div class="main">
<!-- 标题 -->
<?php echo PayCfgWidgets::getCfgCommonWidget($channelModel);?>
    <h1 class="header-1">全局设置</h1>
    <div class="main_content row">
    	<div class="col-xs-6">
    	<button class="btn btn-block btn-yapi btn-default">使用API</button>
    	</div>
    	<div class="col-xs-6">
    	<button class="btn btn-block btn-napi btn-default">固定指令</button>
    	</div>
    </div>
    
    <!-- api参数设置 -->
	<?php echo PayCfgWidgets::getCfgPayParamsWidget($payParamsModel);?>
	
	
	<!-- api通用设置 -->
<div class="pay_yapi" api="1">
<hr>
	<h1 class="header-1">支付请求通用设置</h1>
	<div class="pay_yapi_content">
    	<div class="form-horizontal">
    	
              <div class="form-group">
                <label for="yapi_url" class="col-xs-2 control-label">Url</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="yapi_url" placeholder="请输入需要请求的API Url" value="<?php if($sdYApiModel){echo $sdYApiModel->url;}?>">
                </div>
              </div>
                  	
              <div class="form-group">
                <label for="yapi_send_method" class="col-xs-2 control-label">发送方式</label>
                <div class="col-xs-10">
                        <select id="yapi_send_method" class="form-control">
                          <option value ="1" <?php if($sdYApiModel){if($sdYApiModel->sendMethod == '1'){ echo 'selected="selected"';}}?>>GET</option>
                          <option value ="2" <?php if($sdYApiModel){if($sdYApiModel->sendMethod == '2'){ echo 'selected="selected"';}}?>>POST</option>
                        </select>
                </div>
              </div>

              <div class="form-group">
                <label for="yapi_resp_fmt" class="col-xs-2 control-label">响应格式</label>
                <div class="col-xs-10">
                        <select id="yapi_resp_fmt" class="form-control">
                          <option value ="1" <?php if($sdYApiModel){if($sdYApiModel->respFmt == '1'){ echo 'selected="selected"';}}?>>JSON</option>
                          <option value ="2" <?php if($sdYApiModel){if($sdYApiModel->respFmt == '2'){ echo 'selected="selected"';}}?>>XML</option>
                          <option value ="3" <?php if($sdYApiModel){if($sdYApiModel->respFmt == '3'){ echo 'selected="selected"';}}?>>TEXT</option>
                        </select>
                </div>
              </div>
                            
              <div class="form-group">
                <label for="yapi_spnumber_key1" class="col-xs-2 control-label">短信一端口Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="yapi_spnumber_key1" placeholder="..." value="<?php if($sdYApiModel){echo $sdYApiModel->spnumberKey1;}?>">
                </div>
              </div>
              
              
              <div class="form-group">
                <label for="yapi_cmd_key1" class="col-xs-2 control-label">短信一指令Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="yapi_cmd_key1" placeholder="..." value="<?php if($sdYApiModel){echo $sdYApiModel->cmdKey1;}?>">
                </div>
              </div>
              
              <div class="form-group">
                <label for="yapi_send_type1" class="col-xs-2 control-label">短信一发送方式</label>
                <div class="col-xs-10">
                        <select id="yapi_send_type1" class="form-control">
                          <option value ="0" <?php if($sdYApiModel){if($sdYApiModel->sendType1 == '0'){ echo 'selected="selected"';}}?>>文本短信发送</option>
                          <option value ="1" <?php if($sdYApiModel){if($sdYApiModel->sendType1 == '1'){ echo 'selected="selected"';}}?>>base64decode后，二进制短信发送</option>
                          <option value ="2" <?php if($sdYApiModel){if($sdYApiModel->sendType1 == '2'){ echo 'selected="selected"';}}?>>base64decode后，文本短信发送</option>
                          <option value ="3" <?php if($sdYApiModel){if($sdYApiModel->sendType1 == '3'){ echo 'selected="selected"';}}?>>base64encode后，返给客户端，客户端base64decode后，再以二进制短信发送</option>                          
                        </select>
                        
                </div>
              </div>
              

              <div class="form-group" style="<?php echo $sms2Display;?>">
                <label for="yapi_spnumber_key2" class="col-xs-2 control-label">短信二端口Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="yapi_spnumber_key2" placeholder="..." value="<?php if($sdYApiModel){echo $sdYApiModel->spnumberKey2;}?>">
                </div>
              </div>
              
              <div class="form-group" style="<?php echo $sms2Display;?>">
                <label for="yapi_cmd_key2" class="col-xs-2 control-label">短信二指令Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="yapi_cmd_key2" placeholder="..." value="<?php if($sdYApiModel){echo $sdYApiModel->cmdKey2;}?>">
                </div>
              </div>
              
              <div class="form-group" style="<?php echo $sms2Display;?>">
                <label for="yapi_send_type2" class="col-xs-2 control-label">短信二发送方式</label>
                <div class="col-xs-10">
                        <select id="yapi_send_type2" class="form-control">
                          <option value ="0" <?php if($sdYApiModel){if($sdYApiModel->sendType2 == '0'){ echo 'selected="selected"';}}?>>文本短信发送</option>
                          <option value ="1" <?php if($sdYApiModel){if($sdYApiModel->sendType2 == '1'){ echo 'selected="selected"';}}?>>base64decode后，二进制短信发送</option>
                          <option value ="2" <?php if($sdYApiModel){if($sdYApiModel->sendType2 == '2'){ echo 'selected="selected"';}}?>>base64decode后，文本短信发送</option>
                          <option value ="3" <?php if($sdYApiModel){if($sdYApiModel->sendType2 == '3'){ echo 'selected="selected"';}}?>>base64encode后，返给客户端，客户端base64decode后，再以二进制短信发送</option>                          
                        </select>
                </div>
              </div>                            

              <div class="form-group" style="<?php echo $sms2Display;?>">
                <label for="yapi_send_interval" class="col-xs-2 control-label">发送间隔(秒)</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="yapi_send_interval" placeholder="..." value="<?php echo $sendInterval;?>">
                </div>
              </div> 

              <div class="form-group">
                <label for="yapi_succ_key" class="col-xs-2 control-label">返回成功Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="yapi_succ_key" placeholder="..." value="<?php if($sdYApiModel){echo $sdYApiModel->succKey;}?>">
                </div>
              </div> 

              <div class="form-group">
                <label for="yapi_succ_value" class="col-xs-2 control-label">返回成功值</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="yapi_succ_value" placeholder="..." value="<?php if($sdYApiModel){echo $sdYApiModel->succValue;}?>">
                </div>
              </div> 
                            

              <div class="form-group">
                <label for="yapi_orderid_key" class="col-xs-2 control-label">返回订单号Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="yapi_orderid_key" placeholder="..." value="<?php if($sdYApiModel){echo $sdYApiModel->orderIdKey;}?>">
                </div>
              </div> 
              

              <div class="form-group">
                <div class="col-xs-10 col-xs-offset-2">
                  <button id="yapi_save" class="btn btn-default">保存</button>
                </div>
              </div> 
                                                                                                                                                            
        </div>
    </div>
</div>

<!-- 不使用api -->
<div class="pay_napi" api="0">
<hr>
	<h1 class="header-1">支付参数设置</h1>
	<div class="pay_napi_content">
    	<div class="form-horizontal">                        
              <div class="form-group napi_cell">                
                        <div class="col-xs-2 napi_fee_div">
                          <input type="text"  class="form-control napi_fee" placeholder="价格（单位分）" value="<?php if(isset($newSms1[0]['fee'])){echo $newSms1[0]['fee'];}?>">
                        </div>
                        <div class="col-xs-10">
                        	<div class="napi_spnumbercmdsendtype1">
                              	<div class="col-xs-6"><input type="text"  class="form-control napi_spnumber1" placeholder="端口" value="<?php if(isset($newSms1[0]['spnumber'])){ echo $newSms1[0]['spnumber'];}?>"></div>
                              	<div class="col-xs-6"><input type="text"  class="form-control napi_cmd1" placeholder="指令" value="<?php if(isset($newSms1[0]['cmd'])){echo $newSms1[0]['cmd'];}?>"></div>
                              	<div class="col-xs-4" style="display:none;"><input type="text"  class="form-control napi_sendtype1" placeholder="..." value="0"></div>
                            </div>
                            <div class="napi_spnumbercmdsendtype2" style="<?php echo $sms2Display;?>">
                              	<div class="col-xs-6"><input type="text"  class="form-control napi_spnumber2" placeholder="端口" value="<?php if(isset($newSms2[0]['spnumber'])){echo $newSms2[0]['spnumber'];}?>"></div>
                              	<div class="col-xs-6"><input type="text"  class="form-control napi_cmd2" placeholder="指令" value="<?php if(isset($newSms2[0]['cmd'])){echo $newSms2[0]['cmd'];}?>"></div>
                              	<div class="col-xs-4" style="display:none;"><input type="text"  class="form-control napi_sendtype2" placeholder="..." value="0"></div>
                            </div>
                        </div>  
              </div><hr>

              <div class="form-group napi_cell">                
                        <div class="col-xs-2 napi_fee_div">
                          <input type="text" class="form-control napi_fee" placeholder="价格（单位分）" value="<?php if(isset($newSms1[1]['fee'])){echo $newSms1[1]['fee'];}?>">
                        </div>
                        <div class="col-xs-10">
                        	<div class="napi_spnumbercmdsendtype1">
                              	<div class="col-xs-6"><input type="text" class="form-control napi_spnumber1" placeholder="端口" value="<?php if(isset($newSms1[1]['spnumber'])){ echo $newSms1[1]['spnumber'];}?>"></div>
                              	<div class="col-xs-6"><input type="text" class="form-control napi_cmd1" placeholder="指令" value="<?php if(isset($newSms1[1]['cmd'])){echo $newSms1[1]['cmd'];}?>"></div>
                              	<div class="col-xs-4" style="display:none;"><input type="text" class="form-control napi_sendtype1" placeholder="..." value="0"></div>
                            </div>
                            <div class="napi_spnumbercmdsendtype2" style="<?php echo $sms2Display;?>">
                              	<div class="col-xs-6"><input type="text"  class="form-control napi_spnumber2" placeholder="端口" value="<?php if(isset($newSms2[1]['spnumber'])){echo $newSms2[1]['spnumber'];}?>"></div>
                              	<div class="col-xs-6"><input type="text"  class="form-control napi_cmd2" placeholder="指令" value="<?php if(isset($newSms2[1]['cmd'])){echo $newSms2[1]['cmd'];}?>"></div>
                              	<div class="col-xs-4" style="display:none;"><input type="text" class="form-control napi_sendtype2" placeholder="..." value="0"></div>
                            </div>
                        </div>  
              </div><hr>

              <div class="form-group napi_cell">                
                        <div class="col-xs-2 napi_fee_div">
                          <input type="text"  class="form-control napi_fee" placeholder="价格（单位分）" value="<?php if(isset($newSms1[2]['fee'])){echo $newSms1[2]['fee'];}?>">
                        </div>
                        <div class="col-xs-10">
                        	<div class="napi_spnumbercmdsendtype1">
                              	<div class="col-xs-6"><input type="text"  class="form-control napi_spnumber1" placeholder="端口" value="<?php if(isset($newSms1[2]['spnumber'])){echo $newSms1[2]['spnumber'];}?>"></div>
                              	<div class="col-xs-6"><input type="text"  class="form-control napi_cmd1" placeholder="指令" value="<?php if(isset($newSms1[2]['cmd'])){echo $newSms1[2]['cmd'];}?>"></div>
                              	<div class="col-xs-4" style="display:none;"><input type="text"  class="form-control napi_sendtype1" placeholder="..." value="0"></div>
                            </div>
                            <div class="napi_spnumbercmdsendtype2" style="<?php echo $sms2Display;?>">
                              	<div class="col-xs-6"><input type="text"  class="form-control napi_spnumber2" placeholder="端口" value="<?php if(isset($newSms2[2]['spnumber'])){echo $newSms2[2]['spnumber'];}?>"></div>
                              	<div class="col-xs-6"><input type="text"  class="form-control napi_cmd2" placeholder="指令" value="<?php if(isset($newSms2[2]['cmd'])){echo $newSms2[2]['cmd'];}?>"></div>
                              	<div class="col-xs-4" style="display:none;"><input type="text" class="form-control napi_sendtype2" placeholder="..." value="0"></div>
                            </div>
                        </div>  
              </div><hr>                                                                                                                             

              <div class="form-group napi_cell">                
                        <div class="col-xs-2 napi_fee_div">
                          <input type="text"  class="form-control napi_fee" placeholder="价格（单位分）" value="<?php if(isset($newSms1[3]['fee'])){echo $newSms1[3]['fee'];}?>">
                        </div>
                        <div class="col-xs-10">
                        	<div class="napi_spnumbercmdsendtype1">
                              	<div class="col-xs-6"><input type="text"  class="form-control napi_spnumber1" placeholder="端口" value="<?php if(isset($newSms1[3]['spnumber'])){echo $newSms1[3]['spnumber'];}?>"></div>
                              	<div class="col-xs-6"><input type="text"  class="form-control napi_cmd1" placeholder="指令" value="<?php if(isset($newSms1[3]['cmd'])){echo $newSms1[3]['cmd'];}?>"></div>
                              	<div class="col-xs-4" style="display:none;"><input type="text"  class="form-control napi_sendtype1" placeholder="..." value="0"></div>
                            </div>
                            <div class="napi_spnumbercmdsendtype2" style="<?php echo $sms2Display;?>">
                              	<div class="col-xs-6"><input type="text"  class="form-control napi_spnumber2" placeholder="端口" value="<?php if(isset($newSms2[3]['spnumber'])){echo $newSms2[3]['spnumber'];}?>"></div>
                              	<div class="col-xs-6"><input type="text"  class="form-control napi_cmd2" placeholder="指令" value="<?php if(isset($newSms2[3]['cmd'])){echo $newSms2[3]['cmd'];}?>"></div>
                              	<div class="col-xs-4" style="display:none;"><input type="text"  class="form-control napi_sendtype2" placeholder="..." value="0"></div>
                            </div>
                        </div>  
              </div><hr>
 
              <div class="form-group napi_cell">                
                        <div class="col-xs-2 napi_fee_div">
                          <input type="text"  class="form-control napi_fee" placeholder="价格（单位分）" value="<?php if(isset($newSms1[4]['fee'])){echo $newSms1[4]['fee'];}?>">
                        </div>
                        <div class="col-xs-10">
                        	<div class="napi_spnumbercmdsendtype1">
                              	<div class="col-xs-6"><input type="text"  class="form-control napi_spnumber1" placeholder="端口" value="<?php if(isset($newSms1[4]['spnumber'])){echo $newSms1[4]['spnumber'];}?>"></div>
                              	<div class="col-xs-6"><input type="text"  class="form-control napi_cmd1" placeholder="指令" value="<?php if(isset($newSms1[4]['cmd'])){echo $newSms1[4]['cmd'];}?>"></div>
                              	<div class="col-xs-4" style="display:none;"><input type="text"  class="form-control napi_sendtype1" placeholder="..." value="0"></div>
                            </div>
                            <div class="napi_spnumbercmdsendtype2" style="<?php echo $sms2Display;?>">
                              	<div class="col-xs-6"><input type="text"  class="form-control napi_spnumber2" placeholder="端口" value="<?php if(isset($newSms2[4]['spnumber'])){echo $newSms2[4]['spnumber'];}?>"></div>
                              	<div class="col-xs-6"><input type="text"  class="form-control napi_cmd2" placeholder="指令" value="<?php if(isset($newSms2[4]['cmd'])){echo $newSms2[4]['cmd'];}?>"></div>
                              	<div class="col-xs-4" style="display:none;"><input type="text"  class="form-control napi_sendtype2" placeholder="..." value="0"></div>
                            </div>
                        </div>  
              </div><hr>
                                                                                                               

                
              <div class="form-group">
                <div class="col-xs-10 col-xs-offset-2">
                  <button id="napi_save" class="btn btn-default">保存</button>
                </div>
              </div> 
                                                                                                                                                         
        </div>
    </div>
</div>


<!-- 数据同步 -->
<?php echo PayCfgWidgets::getCfgDataSyncWidget($syncModel);?>

	
</div>

<script type="text/javascript">
$(document).ready(function(){
	$('.btn-yapi').click(function(){
		$('.data_store_common').attr('useapi',1);
		$("div[api='0']").css('display','none');
		$("div[api='1']").css('display','block');
	});

	$('.btn-napi').click(function(){
		$('.data_store_common').attr('useapi',0);
		$("div[api='1']").css('display','none');
		$("div[api='0']").css('display','block');
	});


	$('#yapi_save').click(function(){
		//url
		var url = '/pay/cfg-sd-yapi-save';
		//data
		var data = 'chid='+$('.data_store_common').attr('chid')
		+'&useapi='+$('.data_store_common').attr('useapi')
		+'&spnumberKey1='+$('#yapi_spnumber_key1').val()
		+'&cmdKey1='+$('#yapi_cmd_key1').val()
		+'&sendType1='+$('#yapi_send_type1').val()
		+'&spnumberKey2='+$('#yapi_spnumber_key2').val()
		+'&cmdKey2='+$('#yapi_cmd_key2').val()
		+'&sendType2='+$('#yapi_send_type2').val()
		+'&sendInterval='+$('#yapi_send_interval').val()
		+'&succKey='+$('#yapi_succ_key').val()
		+'&succValue='+$('#yapi_succ_value').val()
		+'&orderIdKey='+$('#yapi_orderid_key').val()
		+'&url='+$('#yapi_url').val()
		+'&sendMethod='+$('#yapi_send_method').val()
		+'&respFmt='+$('#yapi_resp_fmt').val();
		//succFunc
		var succFunc	= function(resJson){
				if(parseInt(resJson.resultCode) == 1){//成功
					$('.pay_yapi_content').addClass('input_ok');
				}else{//失败
					$('.pay_yapi_content').addClass('input_err');
				}
		};
		Utils.ajax(url,data,succFunc);
	});	

	$('#napi_save').click(function(){		
		var devType	= parseInt($('.data_store_common').attr('dev_type'));
		
		var list1	= new Array();
		var list2	= new Array();
		$.each($('.napi_cell'),function(ckey,cval){
			var fee	= parseInt($(cval).find(".napi_fee").val());
			if(fee > 0){
				var item1  = {
						'fee':fee,
						'spnumber':	$(cval).find(".napi_spnumber1").val(),
						'cmd':$(cval).find(".napi_cmd1").val(),
						'sendtype':$(cval).find(".napi_sendtype1").val(),
						};
				list1.push(item1);
				if(devType == 2){
					var item2	= {
							'fee':fee,
							'spnumber':	$(cval).find(".napi_spnumber2").val(),
							'cmd':$(cval).find(".napi_cmd2").val(),
							'sendtype':$(cval).find(".napi_sendtype2").val(),
							};
					list2.push(item2);
				}
			}
		});
		//console.log(list);  JSON.stringify(cpkv)
		var sms1	= '';
		var sms2	= '';
		if(list1.length > 0){
			sms1	= JSON.stringify(list1);
		}
		
		if(list2.length > 0){
			sms2	= JSON.stringify(list2);
		}
		
		//url
		var url = '/pay/cfg-sd-napi-save';
		//data
		var data =  'chid='+$('.data_store_common').attr('chid')
            		+'&useapi='+$('.data_store_common').attr('useapi')
            		+'&sms1='+sms1
            		+'&sms2='+sms2;
		//succFunc
		var succFunc	= function(resJson){
				if(parseInt(resJson.resultCode) == 1){//成功
					$('.pay_napi_content').addClass('input_ok');
				}else{//失败
					$('.pay_napi_content').addClass('input_err');
				}
		};
		Utils.ajax(url,data,succFunc);
	});	
});
</script>