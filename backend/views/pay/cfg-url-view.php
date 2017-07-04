<?php 
use backend\library\widgets\PayCfgWidgets;
use common\library\Constant;

$channelModel   = $channelModel;
$mainModel      = $mainModel;
$payParamsModel = $payParamsModel;
$urlModel       = $urlModel;
$urlYApiModel   = $urlYApiModel;
$submitModel    = $submitModel;
$sdkSubmitModel = $sdkSubmitModel;
$syncModel      = $syncModel;
$smtParamsModel = $smtParamsModel;
$outModel       = $outModel;
$channelCfgToSync = $channelCfgToSync;
?>
<ol class="breadcrumb">
<li><a href="/pay/channel-view">通道配置</a></li>
<li class="active">url+类型配置</li>
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
                          <option value ="1" <?php if($urlYApiModel){if($urlYApiModel->sendMethod == Constant::HTTP_GET){ echo 'selected="selected"';}}?>>GET</option>
                          <option value ="2" <?php if($urlYApiModel){if($urlYApiModel->sendMethod == Constant::HTTP_POST_KV){ echo 'selected="selected"';}}?>>POST</option>
                          <option value ="3" <?php if($urlYApiModel){if($urlYApiModel->sendMethod == Constant::HTTP_POST_JSON){ echo 'selected="selected"';}}?>>POST JSON</option>
                          <option value ="4" <?php if($urlYApiModel){if($urlYApiModel->sendMethod == Constant::HTTP_POST_XML){ echo 'selected="selected"';}}?>>POST XML</option>
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
                          <option value ="4" <?php if($urlYApiModel){if($urlYApiModel->respFmt == '4'){ echo 'selected="selected"';}}?>>TEXT-TO-ARRAY</option>
                          <option value ="5" <?php if($urlYApiModel){if($urlYApiModel->respFmt == '5'){ echo 'selected="selected"';}}?>>JSON-TO-ARRAY</option>
                          <option value ="6" <?php if($urlYApiModel){if($urlYApiModel->respFmt == '6'){ echo 'selected="selected"';}}?>>XML-TO-ARRAY</option>
                        </select>
                </div>
             </div>
             
             <div class="form-group" id="delimiter">
                <label for="url_yapi_delimiter" class="col-xs-2 control-label">分隔符</label>
                <div class="col-xs-10">
                        <input type='text' id='url_yapi_delimiter' class='form-control' value="<?php if($urlYApiModel){echo $urlYApiModel->delimiter;}?>"> 
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
                              <option value ="1" <?php if($submitModel){if($submitModel->sendMethod == Constant::HTTP_GET){ echo 'selected="selected"';}}?>>GET</option>
                              <option value ="2" <?php if($submitModel){if($submitModel->sendMethod == Constant::HTTP_POST_KV){ echo 'selected="selected"';}}?>>POST</option>
                              <option value ="3" <?php if($submitModel){if($submitModel->sendMethod == Constant::HTTP_POST_JSON){ echo 'selected="selected"';}}?>>POST JSON</option>
                              <option value ="4" <?php if($submitModel){if($submitModel->sendMethod == Constant::HTTP_POST_XML){ echo 'selected="selected"';}}?>>POST XML</option>
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
 
                   <div class="form-group url_verifycode_portFixed_div">
                    <label for="url_verifycode_portFixed" class="col-xs-2 control-label">固定端口</label>
                    <div class="col-xs-10">
                      <input type="text" class="form-control" id="url_verifycode_portFixed" placeholder="..." value="<?php if($sdkSubmitModel){echo $sdkSubmitModel->portFixed;}?>">
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
	<!-- 代码外放 -->
	<?php echo PayCfgWidgets::getCfgOutWidget($outModel);?>
    <!-- 单同步-->
    <?php echo PayCfgWidgets::getCfgSingleDataSyncWidget($channelCfgToSync)?>
</div>

<script>
$(document).ready(function(){
	if($('#url_yapi_respFmt').val() > 3){
		$('#delimiter').css('display','block');
	}else{
		$('#delimiter').css('display','none');
	}
	
	$('#url_yapi_respFmt').change(function(){
		var respFmt = $(this).val();
		if(respFmt > 3){
			$('#delimiter').css('display','block');
		}else{
			$('#delimiter').css('display','none');
		}
	})
	
	$('#url_yapi_save').click(function(){
		//url
		var url = '/pay/cfg-url-yapi-save';
		//data
		var data='chid='+$('.data_store_common').attr('chid')
				+'&url='+$('#url_yapi_url').val()
				+'&sendMethod='+$('#url_yapi_sendMethod').val()
				+'&respFmt='+$('#url_yapi_respFmt').val()
				+'&delimiter='+encodeURIComponent($('#url_yapi_delimiter').val())
				+'&succKey='+$('#url_yapi_succKey').val()
				+'&succValue='+$('#url_yapi_succValue').val()
				+'&orderIdKey='+$('#url_yapi_orderIdKey').val()
				+'&smtKey='+$('#url_yapi_smtKey').val();
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

	$('#url_verifycode_smtType').change(function(){
		var smtType	= $('#url_verifycode_smtType').val();
		if(parseInt(smtType) == 1){//server
			$('.smt_params').css('display','block');
			$('.url_verifycode_url_div').css('display','block');
			$('.url_verifycode_sendMethod_div').css('display','block');
			$('.url_verifycode_respFmt_div').css('display','block');
			$('.url_verifycode_succKey_div').css('display','block');
			$('.url_verifycode_succValue_div').css('display','block');
			$('.url_verifycode_portFixed_div').css('display','none');
		}else{//client
			$('.smt_params').css('display','none');
			$('.url_verifycode_url_div').css('display','none');
			$('.url_verifycode_sendMethod_div').css('display','none');
			$('.url_verifycode_respFmt_div').css('display','none');
			$('.url_verifycode_succKey_div').css('display','none');
			$('.url_verifycode_succValue_div').css('display','none');
			$('.url_verifycode_portFixed_div').css('display','block');
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
				     +'&url='+encodeURIComponent($('#url_verifycode_url').val())
				     +'&sendMethod='+$('#url_verifycode_sendMethod').val()
				     +'&respFmt='+$('#url_verifycode_respFmt').val()
				     +'&succKey='+$('#url_verifycode_succKey').val()
				     +'&succValue='+$('#url_verifycode_succValue').val()
				     +'&portFixed='+$('#url_verifycode_portFixed').val();
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