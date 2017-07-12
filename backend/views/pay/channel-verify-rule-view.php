<?php 
$channelModel      = $channelModel;
$verifyRuleModels  = $verifyRuleModels;
$succRuleModels    = $succRuleModels;

?>
<ol class="breadcrumb">
<li><a href="/pay/channel-view">通道管理</a></li>
<li class="active">短信屏蔽规则</li>
<li class="channelName"><?php echo $channelModel->name;?></li>
</ol>

<div class="main">
<h1 class="header-1">验证码规则</h1>
<h1 class="header-2">1. 每一条需拦截的验证码短信，只允许设置一条拦截规则<br>2. 当后台管理中未配置规则时，默认使用代码中配置的规则</h1>
    <div class="verify">
    <?php
    $verifyArr = ['0','1'];
    foreach ($verifyArr as $verifyItem){
    ?>
    	<div class="verify_<?= $verifyItem?> form-horizontal" style="border:1px solid #000;padding:5px;margin-top:3px;margin-bottom:3px;">
    	          <div class="form-group">
                    <label for="verify_port_01" class="col-xs-2 control-label">端口号：</label>
                    <div class="col-xs-10">
                      <input type="text" class="form-control input_required" id="verify_01_port" placeholder="唯一端口号，必填" value="<?php echo $verifyRuleModels[$verifyItem]->port;?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="verify_<?= $verifyItem?>_keys2" class="col-xs-2 control-label">关键词：</label>
                    <div class="col-xs-10" style="padding-left:0px;padding-right:0px;">
                      <div class="col-xs-4"><input type="text" class="form-control input_required" id="verify_<?= $verifyItem?>_keys2" placeholder="SDK唯一关键词，必填" value="<?php echo $verifyRuleModels[$verifyItem]->keys2;?>"></div>
                      <div class="col-xs-4"><input type="text" class="form-control" id="verify_<?= $verifyItem?>_keys1" placeholder="以逗号间隔，不超过100个字符" value="<?php echo $verifyRuleModels[$verifyItem]->keys1;?>"></div>
                      <div class="col-xs-4"><input type="text" class="form-control" id="verify_<?= $verifyItem?>_keys3" placeholder="以逗号间隔，不超过100个字符" value="<?php echo $verifyRuleModels[$verifyItem]->keys3;?>"></div>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="verify_01_memo" class="col-xs-2 control-label">备&nbsp;&nbsp;&nbsp;&nbsp;注：</label>
                    <div class="col-xs-10">
                      <textarea class="form-control" id="verify_<?= $verifyItem?>_memo" placeholder="备注，不超过500个字符"><?php echo $verifyRuleModels[$verifyItem]->memo;?></textarea>
                    </div>
                  </div>
                  
                  
                  <div class="form-group">
                    <div class="col-xs-10 col-xs-offset-2">
                      <button id="yapi_save" class="btn btn-default">保存</button>
                    </div>
                  </div> 
    	</div>
    <?php }?>	
    </div>
    
    <hr>
    
    <h1 class="header-1">成功下发规则</h1>
	<h1 class="header-2">1. 每一条需屏蔽的下发短信，都需要单独设置一条屏蔽规则<br>2. 当后台管理中未配置规则时，默认使用代码中配置的规则</h1>
    <div class="succ">
    <?php
    $succArr = ['0','1'];
    foreach ($succArr as $succItem){
    ?>
        <div class="succ_<?= $succItem?> form-horizontal" style="border:1px solid #000;padding:5px;margin-top:3px;margin-bottom:3px;">
                  <div class="form-group">
                    <label for="succ_port_01" class="col-xs-2 control-label">端口号：</label>
                    <div class="col-xs-10">
                      <input type="text" class="form-control input_required" id="succ_01_port" placeholder="唯一端口号，必填" value="<?php echo $succRuleModels[$succItem]->port;?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="succ_<?= $succItem?>_keys2" class="col-xs-2 control-label">关键词：</label>
                    <div class="col-xs-10">
                      <input type="text" class="form-control input_required" id="succ_<?= $succItem?>_keys2" placeholder="必填，多个关键词以逗号隔间，不超过100个字符" value="<?php echo $succRuleModels[$succItem]->keys2;?>">
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="succ_01_memo" class="col-xs-2 control-label">备&nbsp;&nbsp;&nbsp;&nbsp;注：</label>
                    <div class="col-xs-10">
                      <textarea class="form-control" id="succ_<?= $succItem?>_memo" placeholder="备注，不超过500个字符"><?php echo $succRuleModels[$succItem]->memo;?></textarea>
                    </div>
                  </div>
                  
                  
                  <div class="form-group">
                    <div class="col-xs-10 col-xs-offset-2">
                      <button id="yapi_save" class="btn btn-default">保存</button>
                    </div>
                  </div> 
        </div>
    <?php }?>   
    </div>
</div>