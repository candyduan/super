<?php 
use backend\library\widgets\PayCfgWidgets;
use common\library\Constant;

$channelModel   = $channelModel;
$mainModel      = $mainModel;
$payParamsModel = $payParamsModel;
$smsModel       = $smsModel;
$smsYApiModel   = $smsYApiModel;
$smsNApiModel   = $smsNApiModel;
$submitModel    = $submitModel;
$syncModel      = $syncModel;
$smtParamsModel = $smtParamsModel;
$outModel       = $outModel;
$channelCfgToSync   = $channelCfgToSync;
if($smsYApiModel){
    $sendType1 = json_decode($smsYApiModel->sendType1,true);
}
if(!is_array($sendType1)){
    $sendType1   = [];
}

$newSms1    = array();
if($smsNApiModel){
    $sms1   = json_decode($smsNApiModel->sms1,true);
    if(!is_array($sms1)){
        $sms1   = [];
    }
    foreach ($sms1 as $fee => $val){
        $item   = array(
            'fee'       => $fee,
            'spnumber'  => $val['spnumber'],
            'cmd'       => $val['cmd'],
            'sendtype'  => $val['sendtype'],
            //'ext'       => $val['ext'],
        );
        array_push($newSms1, $item);
    }
    $needExt    = $smsNApiModel->needExt;
}
?>
<ol class="breadcrumb">
<li><a href="/pay/channel-view">通道配置</a></li>
<li class="active">sms+类型配置</li>
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
	<!-- 使用api -->
    <div class="sms_yapi" api="1">
    <hr>
    	<h1 class="header-1">支付设置</h1>
    	<div class="sms_yapi_content">
        	<div class="form-horizontal">    
       		<div class="form-group">
                <label for="sms_yapi_url" class="col-xs-2 control-label">支付URL</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="sms_yapi_url" placeholder="..." value="<?php if($smsYApiModel){echo $smsYApiModel->url;}?>">
                </div>
            </div>
            
            <div class="form-group">
                <label for="sms_yapi_sendMethod" class="col-xs-2 control-label">支付发送方式</label>
                <div class="col-xs-10">
                        <select id="sms_yapi_sendMethod" class="form-control">
                          <option value ="1" <?php if($smsYApiModel){if($smsYApiModel->sendMethod == Constant::HTTP_GET){ echo 'selected="selected"';}}?>>GET</option>
                          <option value ="2" <?php if($smsYApiModel){if($smsYApiModel->sendMethod == Constant::HTTP_POST_KV){ echo 'selected="selected"';}}?>>POST</option>
                          <option value ="3" <?php if($smsYApiModel){if($smsYApiModel->sendMethod == Constant::HTTP_POST_JSON){ echo 'selected="selected"';}}?>>POST JSON</option>
                          <option value ="4" <?php if($smsYApiModel){if($smsYApiModel->sendMethod == Constant::HTTP_POST_XML){ echo 'selected="selected"';}}?>>POST XML</option>
                        </select>
                </div>
             </div>

             <div class="form-group">
                <label for="sms_yapi_respFmt" class="col-xs-2 control-label">支付响应格式</label>
                <div class="col-xs-10">
                        <select id="sms_yapi_respFmt" class="form-control">
                          <option value ="1" <?php if($smsYApiModel){if($smsYApiModel->respFmt == '1'){ echo 'selected="selected"';}}?>>JSON</option>
                          <option value ="2" <?php if($smsYApiModel){if($smsYApiModel->respFmt == '2'){ echo 'selected="selected"';}}?>>XML</option>
                          <option value ="3" <?php if($smsYApiModel){if($smsYApiModel->respFmt == '3'){ echo 'selected="selected"';}}?>>TEXT</option>
                          <option value ="4" <?php if($smsYApiModel){if($smsYApiModel->respFmt == '4'){ echo 'selected="selected"';}}?>>TEXT-TO-ARRAY</option>
                          <option value ="5" <?php if($smsYApiModel){if($smsYApiModel->respFmt == '5'){ echo 'selected="selected"';}}?>>JSON-TO-ARRAY</option>
                          <option value ="6" <?php if($smsYApiModel){if($smsYApiModel->respFmt == '6'){ echo 'selected="selected"';}}?>>XML-TO-ARRAY</option>
                        </select>
                </div>
             </div>
              
             <div class="form-group" id="delimiter">
                <label for="sms_yapi_delimiter" class="col-xs-2 control-label">分隔符</label>
                <div class="col-xs-10">
                        <input type='text' id='sms_yapi_delimiter' class='form-control' value="<?php if($smsYApiModel){echo $smsYApiModel->delimiter;}?>"> 
                </div>
             </div>
                                
       		<div class="form-group">
                <label for="sms_yapi_spnumberKey1" class="col-xs-2 control-label">端口Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="sms_yapi_spnumberKey1" placeholder="..." value="<?php if($smsYApiModel){echo $smsYApiModel->spnumberKey1;}?>">
                </div>
            </div>
 
       		<div class="form-group">
                <label for="sms_yapi_cmdKey1" class="col-xs-2 control-label">指令Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="sms_yapi_cmdKey1" placeholder="..." value="<?php if($smsYApiModel){echo $smsYApiModel->cmdKey1;}?>">
                </div>
            </div>

       		<div class="form-group">
                <label class="col-xs-2 control-label">短信发送方式</label>
                <div class="col-xs-2 sms_yapi_sendType1">
                  <input type="text" class="col-xs-6 sms_yapi_sendType1Key" placeholder="key" value="<?php echo $sendType1[0]['key'];?>">
                  <input type="text" class="col-xs-3 sms_yapi_sendType1Value" placeholder="value" value="<?php echo $sendType1[0]['value'];?>">
                  <input type="text" class="col-xs-3 sms_yapi_sendType1Our" placeholder="发送方式" value="<?php echo $sendType1[0]['sendtype'];?>">
                </div>
                <div class="col-xs-2 sms_yapi_sendType1">
                  <input type="text" class="col-xs-6 sms_yapi_sendType1Key" placeholder="key" value="<?php echo $sendType1[1]['key'];?>">
                  <input type="text" class="col-xs-3 sms_yapi_sendType1Value" placeholder="value" value="<?php echo $sendType1[1]['value'];?>">
                  <input type="text" class="col-xs-3 sms_yapi_sendType1Our" placeholder="发送方式" value="<?php echo $sendType1[1]['sendtype'];?>">
                </div>
                
                <div class="col-xs-2 sms_yapi_sendType1">
                  <input type="text" class="col-xs-6 sms_yapi_sendType1Key" placeholder="key" value="<?php echo $sendType1[2]['key'];?>">
                  <input type="text" class="col-xs-3 sms_yapi_sendType1Value" placeholder="value" value="<?php echo $sendType1[2]['value'];?>">
                  <input type="text" class="col-xs-3 sms_yapi_sendType1Our" placeholder="发送方式" value="<?php echo $sendType1[2]['sendtype'];?>">
                </div>
                
                 <div class="col-xs-2 sms_yapi_sendType1">
                  <input type="text" class="col-xs-6 sms_yapi_sendType1Key" placeholder="key" value="<?php echo $sendType1[3]['key'];?>">
                  <input type="text" class="col-xs-3 sms_yapi_sendType1Value" placeholder="value" value="<?php echo $sendType1[3]['value'];?>">
                  <input type="text" class="col-xs-3 sms_yapi_sendType1Our" placeholder="发送方式" value="<?php echo $sendType1[3]['sendtype'];?>">
                </div>               
            </div>

       		<div class="form-group">
                <label for="sms_yapi_succKey" class="col-xs-2 control-label">成功Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="sms_yapi_succKey" placeholder="..." value="<?php if($smsYApiModel){echo $smsYApiModel->succKey;}?>">
                </div>
            </div>
 
            <div class="form-group">
                <label for="sms_yapi_succValue" class="col-xs-2 control-label">成功值</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="sms_yapi_succValue" placeholder="..." value="<?php if($smsYApiModel){echo $smsYApiModel->succValue;}?>">
                </div>
            </div>
            <div class="form-group">
                <label for="sms_yapi_orderIdKey" class="col-xs-2 control-label">订单号Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="sms_yapi_orderIdKey" placeholder="..." value="<?php if($smsYApiModel){echo $smsYApiModel->orderIdKey;}?>">
                </div>
            </div>   
            
             <div class="form-group">
                <div class="col-xs-10 col-xs-offset-2">
                  <button id="sms_yapi_save" class="btn btn-default">保存</button>
                </div>
              </div> 
                                                                                	
        	</div>
        </div>
    </div>    
    
    	<!-- 固定指令 -->
    <div class="sms_napi" api="0">
    <hr>
    	<h1 class="header-1">支付设置</h1>
    	<div class="sms_napi_content">
        	<div class="form-horizontal">  
        	
        	  <div class="form-group napi_needExt_div">
                <div class="col-xs-6">
                  <input type="text"  class="form-control napi_needExt" placeholder="扩展位数,0-不扩展,默认0" value="<?php echo $needExt;?>">
                </div>
              </div> 
              
                        
               <div class="form-group napi_cell">                
                        <div class="col-xs-2 napi_fee_div">
                          <input type="text"  class="form-control napi_fee" placeholder="价格（单位分）" value="<?php echo $newSms1[0]['fee'];?>">
                        </div>
                        <div class="col-xs-10">
                        	<div class="napi_spnumbercmdsendtype1">
                              	<div class="col-xs-4"><input type="text"  class="form-control napi_spnumber1" placeholder="端口" value="<?php echo $newSms1[0]['spnumber'];?>"></div>
                              	<div class="col-xs-4"><input type="text"  class="form-control napi_cmd1" placeholder="指令" value="<?php echo $newSms1[0]['cmd'];?>"></div>
                              	<div class="col-xs-4"><input type="text"  class="form-control napi_sendtype1" placeholder="发送方式" value="<?php echo $newSms1[0]['sendtype'];?>"></div>
                            </div>
                        </div>  
              </div><hr>

              <div class="form-group napi_cell">                
                        <div class="col-xs-2 napi_fee_div">
                          <input type="text" class="form-control napi_fee" placeholder="价格（单位分）" value="<?php echo $newSms1[1]['fee'];?>">
                        </div>
                        <div class="col-xs-10">
                        	<div class="napi_spnumbercmdsendtype1">
                              	<div class="col-xs-4"><input type="text" class="form-control napi_spnumber1" placeholder="端口" value="<?php echo $newSms1[1]['spnumber'];?>"></div>
                              	<div class="col-xs-4"><input type="text" class="form-control napi_cmd1" placeholder="指令" value="<?php echo $newSms1[1]['cmd'];?>"></div>
                              	<div class="col-xs-4"><input type="text" class="form-control napi_sendtype1" placeholder="发送方式" value="<?php echo $newSms1[1]['sendtype'];?>"></div>
                            </div>
                        </div>  
              </div><hr>

              <div class="form-group napi_cell">                
                        <div class="col-xs-2 napi_fee_div">
                          <input type="text"  class="form-control napi_fee" placeholder="价格（单位分）" value="<?php echo $newSms1[2]['fee'];?>">
                        </div>
                        <div class="col-xs-10">
                        	<div class="napi_spnumbercmdsendtype1">
                              	<div class="col-xs-4"><input type="text"  class="form-control napi_spnumber1" placeholder="端口" value="<?php echo $newSms1[2]['spnumber'];?>"></div>
                              	<div class="col-xs-4"><input type="text"  class="form-control napi_cmd1" placeholder="指令" value="<?php echo $newSms1[2]['cmd'];?>"></div>
                              	<div class="col-xs-4"><input type="text"  class="form-control napi_sendtype1" placeholder="发送方式" value="<?php echo $newSms1[2]['sendtype'];?>"></div>
                            </div>
                        </div>  
              </div><hr>                                                                                                                             

              <div class="form-group napi_cell">                
                        <div class="col-xs-2 napi_fee_div">
                          <input type="text"  class="form-control napi_fee" placeholder="价格（单位分）" value="<?php echo $newSms1[3]['fee'];?>">
                        </div>
                        <div class="col-xs-10">
                        	<div class="napi_spnumbercmdsendtype1">
                              	<div class="col-xs-4"><input type="text"  class="form-control napi_spnumber1" placeholder="端口" value="<?php echo $newSms1[3]['spnumber'];?>"></div>
                              	<div class="col-xs-4"><input type="text"  class="form-control napi_cmd1" placeholder="指令" value="<?php echo $newSms1[3]['cmd'];?>"></div>
                              	<div class="col-xs-4"><input type="text"  class="form-control napi_sendtype1" placeholder="发送方式" value="<?php echo $newSms1[3]['sendtype'];?>"></div>
                            </div>
                        </div>  
              </div><hr>
 
              <div class="form-group napi_cell">                
                        <div class="col-xs-2 napi_fee_div">
                          <input type="text"  class="form-control napi_fee" placeholder="价格（单位分）" value="<?php echo $newSms1[4]['fee'];?>">
                        </div>
                        <div class="col-xs-10">
                        	<div class="napi_spnumbercmdsendtype1">
                              	<div class="col-xs-4"><input type="text"  class="form-control napi_spnumber1" placeholder="端口" value="<?php echo $newSms1[4]['spnumber'];?>"></div>
                              	<div class="col-xs-4"><input type="text"  class="form-control napi_cmd1" placeholder="指令" value="<?php echo $newSms1[4]['cmd'];?>"></div>
                              	<div class="col-xs-4"><input type="text"  class="form-control napi_sendtype1" placeholder="发送方式" value="<?php echo $newSms1[4]['sendtype'];?>"></div>
                            </div>
                        </div>  
              </div><hr>
                                                                  
              <div class="form-group">
                <div class="col-xs-10 col-xs-offset-2">
                  <button id="sms_napi_save" class="btn btn-default">保存</button>
                </div>
              </div> 
                            
        	</div>
        </div>
    </div>
    
    
    
   <div class="sms_submit">
    	<hr>
    	<h1 class="header-1">验证码设置</h1>
    	<div class="sms_verifycode_content">
        	<div class="form-horizontal">
            	  <div class="form-group">
                    <label for="sms_verifycode_smtKeywords" class="col-xs-2 control-label">提取验证码关键词</label>
                    <div class="col-xs-10">
                      <input type="text" class="form-control" id="sms_verifycode_smtKeywords" placeholder="..." value="<?php if($smsModel){echo $smsModel->smtKeywords;}?>">
                    </div>
                  </div>
                  
                   <div class="form-group">
                    <label for="sms_verifycode_smtType" class="col-xs-2 control-label">提交验证码方式</label>
                    <div class="col-xs-10">
                            <select id="sms_verifycode_smtType" class="form-control">
                              <option value ="1" <?php if($smsModel){if($smsModel->smtType == '1'){ echo 'selected="selected"';}}?>>server提交</option>
                              <option value ="2" <?php if($smsModel){if($smsModel->smtType == '2'){ echo 'selected="selected"';}}?>>client提交</option>
                            </select>
                    </div>
                  </div>
                  
                  
                  <div class="form-group sms_verifycode_url_div">
                    <label for="sms_verifycode_url" class="col-xs-2 control-label">提交验证码Url</label>
                    <div class="col-xs-10">
                      <input type="text" class="form-control" id="sms_verifycode_url" placeholder="..." value="<?php if($submitModel){echo $submitModel->url;}?>">
                    </div>
                  </div>
                  
                  <div class="form-group sms_verifycode_sendMethod_div">
                    <label for="sms_verifycode_sendMethod" class="col-xs-2 control-label">提交验证码发送方式</label>
                    <div class="col-xs-10">
                            <select id="sms_verifycode_sendMethod" class="form-control">
                              <option value ="1" <?php if($submitModel){if($submitModel->sendMethod == Constant::HTTP_GET){ echo 'selected="selected"';}}?>>GET</option>
                              <option value ="2" <?php if($submitModel){if($submitModel->sendMethod == Constant::HTTP_POST_KV){ echo 'selected="selected"';}}?>>POST</option>
                              <option value ="3" <?php if($submitModel){if($submitModel->sendMethod == Constant::HTTP_POST_JSON){ echo 'selected="selected"';}}?>>POST JSON</option>
                              <option value ="4" <?php if($submitModel){if($submitModel->sendMethod == Constant::HTTP_POST_XML){ echo 'selected="selected"';}}?>>POST XML</option>
                            </select>
                    </div>
                  </div>
                  
                   <div class="form-group sms_verifycode_respFmt_div">
                    <label for="sms_verifycode_respFmt" class="col-xs-2 control-label">提交验证码响应格式</label>
                    <div class="col-xs-10">
                            <select id="sms_verifycode_respFmt" class="form-control">
                              <option value ="1" <?php if($submitModel){if($submitModel->respFmt == '1'){ echo 'selected="selected"';}}?>>JSON</option>
                              <option value ="2" <?php if($submitModel){if($submitModel->respFmt == '2'){ echo 'selected="selected"';}}?>>XML</option>
                              <option value ="3" <?php if($submitModel){if($submitModel->respFmt == '3'){ echo 'selected="selected"';}}?>>TEXT</option>
                            </select>
                    </div>
                  </div>
              
              
                  <div class="form-group sms_verifycode_succKey_div">
                    <label for="sms_verifycode_succKey" class="col-xs-2 control-label">提交成功Key</label>
                    <div class="col-xs-10">
                      <input type="text" class="form-control" id="sms_verifycode_succKey" placeholder="..." value="<?php if($submitModel){echo $submitModel->succKey;}?>">
                    </div>
                  </div>
    
                  <div class="form-group sms_verifycode_succValue_div">
                    <label for="sms_verifycode_succValue" class="col-xs-2 control-label">提交成功值</label>
                    <div class="col-xs-10">
                      <input type="text" class="form-control" id="sms_verifycode_succValue" placeholder="..." value="<?php if($submitModel){echo $submitModel->succValue;}?>">
                    </div>
                  </div>
              
                  <div class="form-group">
                    <div class="col-xs-10 col-xs-offset-2">
                      <button id="sms_verifycode_save" class="btn btn-default">保存</button>
                    </div>
                  </div> 
              
        	</div>
        </div>
    </div>
    <!-- 验证码请求参数设置 -->
	<?php echo PayCfgWidgets::getCfgSmtParamsWidget($smtParamsModel);?>
    <!-- 数据同步 -->
	<?php echo PayCfgWidgets::getCfgDataSyncWidget($syncModel);?>
	<!-- 代码外放 -->
	<?php echo PayCfgWidgets::getCfgOutWidget($outModel);?>
    <!-- 单同步-->
    <?php echo PayCfgWidgets::getCfgSingleDataSyncWidget($channelCfgToSync)?>
</div>

<script>
$(document).ready(function(){
	if($('#sms_yapi_respFmt').val() > 3){
		$('#delimiter').css('display','block');
	}else{
		$('#delimiter').css('display','none');
	}
	
	$('#sms_yapi_respFmt').change(function(){
		var respFmt = $(this).val();
		if(respFmt > 3){
			$('#delimiter').css('display','block');
		}else{
			$('#delimiter').css('display','none');
		}
	})
	
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

	$('#sms_yapi_save').click(function(){
		//url
		var url = '/pay/cfg-sms-yapi-save';
		//data
		var sendTypeArr1 = new Array();
		$.each($('.sms_yapi_sendType1'),function(key,val){
			var zkey = $(val).find(".sms_yapi_sendType1Key").val();
			var zval = $(val).find(".sms_yapi_sendType1Value").val();
			var zsendtype = $(val).find(".sms_yapi_sendType1Our").val();
			if(zkey != '' && zval != '' && zsendtype != ''){
				var sendType1item = {
						'key':zkey,
						'value':zval,
						'sendtype':zsendtype,
						};
				sendTypeArr1.push(sendType1item);
			}			
		});
		var sendType1 = '';
		if(sendTypeArr1.length > 0){
			sendType1 = JSON.stringify(sendTypeArr1);
		}
		var data='chid='+$('.data_store_common').attr('chid')
				+'&useapi='+$('.data_store_common').attr('useapi')
				+'&spnumberKey1='+$('#sms_yapi_spnumberKey1').val()
				+'&cmdKey1='+$('#sms_yapi_cmdKey1').val()
				+'&sendType1='+sendType1
				+'&succKey='+$('#sms_yapi_succKey').val()
				+'&succValue='+$('#sms_yapi_succValue').val()
				+'&orderIdKey='+$('#sms_yapi_orderIdKey').val()
				+'&url='+$('#sms_yapi_url').val()
				+'&sendMethod='+$('#sms_yapi_sendMethod').val()
				+'&respFmt='+$('#sms_yapi_respFmt').val()
				+'&delimiter='+encodeURIComponent($('#sms_yapi_delimiter').val());
		

	     //succFunc
	     var succFunc	= function(resJson){
				if(parseInt(resJson.resultCode) == 1){//成功
					Utils.tipBar('success','保存成功',resJson.msg);
				}else{//失败
					Utils.tipBar('error','保存失败',resJson.msg);
				}
		  };
		  Utils.ajax(url,data,succFunc);
	});
	$('#sms_napi_save').click(function(){
		//url
		var url = '/pay/cfg-sms-napi-save';
		//data

		var sms1Arr1	= new Array();
		$.each($('.napi_cell'),function(ckey,cval){
			var fee	= parseInt($(cval).find(".napi_fee").val());
			if(fee > 0){
				var item1  = {
						'fee':fee,
						'spnumber':	$(cval).find(".napi_spnumber1").val(),
						'cmd':$(cval).find(".napi_cmd1").val(),
						'sendtype':$(cval).find(".napi_sendtype1").val(),
						//'ext':$(cval).find(".napi_ext1").val(),
						};
				sms1Arr1.push(item1);
			}
		});
		var sms1	= '';
		if(sms1Arr1.length > 0){
			sms1	= JSON.stringify(sms1Arr1);
		}
		
		var data	= 'chid='+$('.data_store_common').attr('chid')
				     +'&useapi='+$('.data_store_common').attr('useapi')
				     +'&needExt='+$('.napi_needExt').val()
				     +'&sms1='+sms1;
	     //succFunc
	     var succFunc	= function(resJson){
				if(parseInt(resJson.resultCode) == 1){//成功
					Utils.tipBar('success','保存成功',resJson.msg);
				}else{//失败
					Utils.tipBar('error','保存失败',resJson.msg);
				}
		  };
		  Utils.ajax(url,data,succFunc);
	});


	$('#sms_verifycode_smtType').change(function(){
		var smtType	= $('#sms_verifycode_smtType').val();
		if(parseInt(smtType) == 1){//server
			$('.smt_params').css('display','block');
			$('.sms_verifycode_url_div').css('display','block');
			$('.sms_verifycode_sendMethod_div').css('display','block');
			$('.sms_verifycode_respFmt_div').css('display','block');
			$('.sms_verifycode_succKey_div').css('display','block');
			$('.sms_verifycode_succValue_div').css('display','block');
		}else{//client
			$('.smt_params').css('display','none');
			$('.sms_verifycode_url_div').css('display','none');
			$('.sms_verifycode_sendMethod_div').css('display','none');
			$('.sms_verifycode_respFmt_div').css('display','none');
			$('.sms_verifycode_succKey_div').css('display','none');
			$('.sms_verifycode_succValue_div').css('display','none');
		}
	});
	$('#sms_verifycode_smtType').trigger('change');
	$('#sms_verifycode_save').click(function(){
		//url
		var url = '/pay/cfg-sms-submit-save';
		//data
		var data	= 'chid='+$('.data_store_common').attr('chid')
					 +'&smtKeywords='+$('#sms_verifycode_smtKeywords').val()
				     +'&smtType='+$('#sms_verifycode_smtType').val()
				     +'&url='+encodeURIComponent($('#sms_verifycode_url').val())
				     +'&sendMethod='+$('#sms_verifycode_sendMethod').val()
				     +'&respFmt='+$('#sms_verifycode_respFmt').val()
				     +'&succKey='+$('#sms_verifycode_succKey').val()
				     +'&succValue='+$('#sms_verifycode_succValue').val();
	     //succFunc
	     var succFunc	= function(resJson){
				if(parseInt(resJson.resultCode) == 1){//成功
					Utils.tipBar('success','保存成功',resJson.msg);
				}else{//失败
					Utils.tipBar('error','保存失败',resJson.msg);
				}
		  };
		  Utils.ajax(url,data,succFunc);
	});
});
</script>