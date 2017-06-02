<?php 
use backend\library\widgets\PayCfgWidgets;

$channelModel   = $channelModel;
$mainModel      = $mainModel;
$payParamsModel = $payParamsModel;
$urlModel       = $urlModel;
$urlYApiModel   = $urlYApiModel;
$submitModel    = $submitModel;
$syncModel      = $syncModel;
$smtParamsModel = $smtParamsModel;
?>
<ol class="breadcrumb">
<li>通道配置</li>
<li class="active"><?php echo '['.$channelModel->id.']'.$channelModel->name;?></li>
</ol>

<div class="main">
<!-- 标题 -->
<?php echo PayCfgWidgets::getCfgCommonWidget($channelModel);?>
     <!-- api参数设置 -->
	<?php echo PayCfgWidgets::getCfgPayParamsWidget($payParamsModel);?>   
	<!-- 使用api -->
    <div class="url_yapi" api="1">
    <hr>
    	<h1 class="header-1">支付设置</h1>
    	<div class="url_yapi_content">
        	<div class="form-horizontal">    
<p>0:文本短信发送。1:base64decode后，二进制短信发送。2:base64decode后，文本短信发送。3:base64encode后，返给客户端，客户端base64decode后，再以二进制短信发送</p><br>

       		<div class="form-group">
                <label for="url_yapi_url" class="col-xs-2 control-label">支付URL</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="url_yapi_url" placeholder="..." value="<?php if($urlYApiModel){echo $urlYApiModel->url;}?>">
                </div>
            </div>
            
            <div class="form-group">
                <label for="url_yapi_sendMethod" class="col-xs-2 control-label">支付发送方式</label>
                <div class="col-xs-10">
                        <select id="url_yapi_sendMethod" class="form-control">
                          <option value ="1" <?php if($urlYApiModel){if($urlYApiModel->sendMethod == '1'){ echo 'selected="selected"';}}?>>GET</option>
                          <option value ="2" <?php if($urlYApiModel){if($urlYApiModel->sendMethod == '2'){ echo 'selected="selected"';}}?>>POST</option>
                        </select>
                </div>
             </div>

             <div class="form-group">
                <label for="url_yapi_respFmt" class="col-xs-2 control-label">支付响应格式</label>
                <div class="col-xs-10">
                        <select id="url_yapi_respFmt" class="form-control">
                          <option value ="1" <?php if($urlYApiModel){if($urlYApiModel->respFmt == '1'){ echo 'selected="selected"';}}?>>JSON</option>
                          <option value ="2" <?php if($urlYApiModel){if($urlYApiModel->respFmt == '2'){ echo 'selected="selected"';}}?>>XML</option>
                          <option value ="3" <?php if($urlYApiModel){if($urlYApiModel->respFmt == '3'){ echo 'selected="selected"';}}?>>TEXT</option>
                        </select>
                </div>
             </div>

       		<div class="form-group">
                <label for="url_yapi_succKey" class="col-xs-2 control-label">成功Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="url_yapi_succKey" placeholder="..." value="<?php if($urlYApiModel){echo $urlYApiModel->succKey;}?>">
                </div>
            </div>
 
            <div class="form-group">
                <label for="url_yapi_succValue" class="col-xs-2 control-label">成功值</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="url_yapi_succValue" placeholder="..." value="<?php if($urlYApiModel){echo $urlYApiModel->succValue;}?>">
                </div>
            </div>
            <div class="form-group">
                <label for="url_yapi_orderIdKey" class="col-xs-2 control-label">订单号Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="url_yapi_orderIdKey" placeholder="..." value="<?php if($urlYApiModel){echo $urlYApiModel->orderIdKey;}?>">
                </div>
            </div>   
            <div class="form-group">
                <label for="url_yapi_smtKey" class="col-xs-2 control-label">提交验证码Key(若有)</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="url_yapi_smtKey" placeholder="..." value="<?php if($urlYApiModel){echo $urlYApiModel->smtKey;}?>">
                </div>
            </div>  
            
             <div class="form-group">
                <div class="col-xs-10 col-xs-offset-2">
                  <button id="url_yapi_save" class="btn btn-default">保存</button>
                </div>
              </div> 
                                                                                	
        	</div>
        </div>
    </div>        
    
   <div class="url_submit">
    	<hr>
    	<h1 class="header-1">验证码设置</h1>
    	<div class="url_verifycode_content">
        	<div class="form-horizontal">
            	  <div class="form-group">
                    <label for="url_verifycode_smtKeywords" class="col-xs-2 control-label">提取验证码关键词</label>
                    <div class="col-xs-10">
                      <input type="text" class="form-control" id="url_verifycode_smtKeywords" placeholder="..." value="<?php if($urlModel){echo $urlModel->smtKeywords;}?>">
                    </div>
                  </div>
                  
                   <div class="form-group">
                    <label for="url_verifycode_smtType" class="col-xs-2 control-label">提交验证码方式</label>
                    <div class="col-xs-10">
                            <select id="url_verifycode_smtType" class="form-control">
                              <option value ="1" <?php if($urlModel){if($urlModel->smtType == '1'){ echo 'selected="selected"';}}?>>server提交</option>
                              <option value ="2" <?php if($urlModel){if($urlModel->smtType == '2'){ echo 'selected="selected"';}}?>>client提交</option>
                            </select>
                    </div>
                  </div>
                  
                  
                  <div class="form-group url_verifycode_url_div">
                    <label for="url_verifycode_url" class="col-xs-2 control-label">提交验证码Url</label>
                    <div class="col-xs-10">
                      <input type="text" class="form-control" id="url_verifycode_url" placeholder="..." value="<?php if($submitModel){echo $submitModel->url;}?>">
                    </div>
                  </div>
                  
                  <div class="form-group url_verifycode_sendMethod_div">
                    <label for="url_verifycode_sendMethod" class="col-xs-2 control-label">提交验证码发送方式</label>
                    <div class="col-xs-10">
                            <select id="url_verifycode_sendMethod" class="form-control">
                              <option value ="1" <?php if($submitModel){if($submitModel->sendMethod == '1'){ echo 'selected="selected"';}}?>>GET</option>
                              <option value ="2" <?php if($submitModel){if($submitModel->sendMethod == '2'){ echo 'selected="selected"';}}?>>POST</option>
                            </select>
                    </div>
                  </div>
                  
                   <div class="form-group url_verifycode_respFmt_div">
                    <label for="url_verifycode_respFmt" class="col-xs-2 control-label">提交验证码响应格式</label>
                    <div class="col-xs-10">
                            <select id="url_verifycode_respFmt" class="form-control">
                              <option value ="1" <?php if($submitModel){if($submitModel->respFmt == '1'){ echo 'selected="selected"';}}?>>JSON</option>
                              <option value ="2" <?php if($submitModel){if($submitModel->respFmt == '2'){ echo 'selected="selected"';}}?>>XML</option>
                              <option value ="3" <?php if($submitModel){if($submitModel->respFmt == '3'){ echo 'selected="selected"';}}?>>TEXT</option>
                            </select>
                    </div>
                  </div>
              
              
                  <div class="form-group url_verifycode_succKey_div">
                    <label for="url_verifycode_succKey" class="col-xs-2 control-label">提交成功Key</label>
                    <div class="col-xs-10">
                      <input type="text" class="form-control" id="url_verifycode_succKey" placeholder="..." value="<?php if($submitModel){echo $submitModel->succKey;}?>">
                    </div>
                  </div>
    
                  <div class="form-group url_verifycode_succValue_div">
                    <label for="url_verifycode_succValue" class="col-xs-2 control-label">提交成功值</label>
                    <div class="col-xs-10">
                      <input type="text" class="form-control" id="url_verifycode_succValue" placeholder="..." value="<?php if($submitModel){echo $submitModel->succValue;}?>">
                    </div>
                  </div>
              
                  <div class="form-group">
                    <div class="col-xs-10 col-xs-offset-2">
                      <button id="url_verifycode_save" class="btn btn-default">保存</button>
                    </div>
                  </div> 
              
        	</div>
        </div>
    </div>
    <!-- 验证码请求参数设置 -->
	<?php echo PayCfgWidgets::getCfgSmtParamsWidget($smtParamsModel);?>
    <!-- 数据同步 -->
	<?php echo PayCfgWidgets::getCfgDataSyncWidget($syncModel);?>
</div>

<script>
$(document).ready(function(){
	$('#url_yapi_save').click(function(){
		//url
		var url = '/pay/cfg-url-yapi-save';
		//data
		var data='chid='+$('.data_store_common').attr('chid')
				+'&url='+$('#url_yapi_url').val()
				+'&sendMethod='+$('#url_yapi_sendMethod').val()
				+'&respFmt='+$('#url_yapi_respFmt').val()
				+'&succKey='+$('#url_yapi_succKey').val()
				+'&succValue='+$('#url_yapi_succValue').val()
				+'&orderIdKey='+$('#url_yapi_orderIdKey').val()
				+'&smtKey='+$('#url_yapi_smtKey').val();
	     //succFunc
	     var succFunc	= function(resJson){
				if(parseInt(resJson.resultCode) == 1){//成功
					$('.url_yapi_content').addClass('input_ok');
				}else{//失败
					$('.url_yapi_content').addClass('input_err');
				}
		  };
		  Utils.ajax(url,data,succFunc);
	});

	$('#url_verifycode_smtType').change(function(){
		var smtType	= $('#url_verifycode_smtType').val();
		if(parseInt(smtType) == 1){//server
			$('.smt_params').css('display','block');
			$('.url_verifycode_url_div').css('display','block');
			$('.url_verifycode_sendMethod_div').css('display','block');
			$('.url_verifycode_respFmt_div').css('display','block');
			$('.url_verifycode_succKey_div').css('display','block');
			$('.url_verifycode_succValue_div').css('display','block');
		}else{//client
			$('.smt_params').css('display','none');
			$('.url_verifycode_url_div').css('display','none');
			$('.url_verifycode_sendMethod_div').css('display','none');
			$('.url_verifycode_respFmt_div').css('display','none');
			$('.url_verifycode_succKey_div').css('display','none');
			$('.url_verifycode_succValue_div').css('display','none');
		}
	});
	$('#url_verifycode_smtType').trigger('change');
	$('#url_verifycode_save').click(function(){
		//url
		var url = '/pay/cfg-url-submit-save';
		//data
		var data	= 'chid='+$('.data_store_common').attr('chid')
					 +'&smtKeywords='+$('#url_verifycode_smtKeywords').val()
				     +'&smtType='+$('#url_verifycode_smtType').val()
				     +'&url='+$('#url_verifycode_url').val()
				     +'&sendMethod='+$('#url_verifycode_sendMethod').val()
				     +'&respFmt='+$('#url_verifycode_respFmt').val()
				     +'&succKey='+$('#url_verifycode_succKey').val()
				     +'&succValue='+$('#url_verifycode_succValue').val();
	     //succFunc
	     var succFunc	= function(resJson){
				if(parseInt(resJson.resultCode) == 1){//成功
					$('.url_verifycode_content').addClass('input_ok');
				}else{//失败
					$('.url_verifycode_content').addClass('input_err');
				}
		  };
		  Utils.ajax(url,data,succFunc);
	});
});
</script>