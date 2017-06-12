<style>
img{border:5px solid #984b4b;display:block;margin-top:5px;margin-bottom:5px;width:100%;}
</style>
<ol class="breadcrumb">
<li class="active">通道配置使用说明</li>
</ol>
<div class="main">
<h1 class="header-1">基本概念</h1>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingDevType">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseDevType" aria-expanded="true" aria-controls="collapseDevType">
         1.类型区分
        </a>
      </h4>
    </div>
    <div id="collapseDevType" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingDevType">
      <div class="panel-body">
      <p>首先看文档中是否有说要提交验证码，如果有那么不是sms+就是url+；反之，不是single就是double。single和double比较容易区分，single就是发一条短信，double就是发两条条短信。sms+和url+如何区分呢？有一个非常简单的判断，就是验证码如何触发下发的，如果需要SDK发送短信进行触发，那么就是sms+，反之就是url+。根据以上概念就可以区分出通道的开发类型了。</p>
      </div>
    </div>
  </div>  

</div>
  
  
<h1 class="header-1">使用说明</h1>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingSd">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSd" aria-expanded="true" aria-controls="collapseSd">
          1.single与double类型
        </a>
      </h4>
    </div>
    <div id="collapseSd" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSd">
      <div class="panel-body">
          <h2 class="header-2">1.1确定是否使用API</h2>
          <p>是否使用API是根据SP方下单的方式来决定的。如果需要调用SP方的接口则点击“使用API”，如果是固定指令则点击“固定指令”,如下图所示:
          <img src="/imgs/cfg-useapi.png" />
          <br>
          </p>
          <h2 class="header-2">1.2使用API</h2>
          <p>
          如果是使用API，则有两个栏目需要进行填写。一个是“支付请求参数设置”，另一个是“支付设置”。如下图所示：
          <br>
          <img src="/imgs/cfg-pay-params-settings.png" />
          <br>
          <img src="/imgs/cfg-pay-settings.png" />          
          根据SP的文档按需填写即可。
          </p>
          <h2 class="header-2">1.3不使用API</h2>
          <p>
          如果是固定指令，则填写比较简单，如下图所示：
          <br>
          <img src="/imgs/cfg-pay-noapi.png" />
          其中，蓝色的框需要注意，如果固定指令需要扩展，则框内填写需要扩展的位数，不需要扩展则填写0，默认0不扩展。
          </p>
          <h2 class="header-2">1.4数据同步</h2>
          数据同步，是用户支付成功后，SP告诉我方的状态。如下图所示：
          <br>
          <img src="/imgs/cfg-data-sync.png" />
      </div>
    </div>
  </div>  



  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingSms">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSms" aria-expanded="true" aria-controls="collapseSms">
          2.sms+类型
        </a>
      </h4>
    </div>
    <div id="collapseSms" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSms">
      <div class="panel-body">
          <h2 class="header-2">2.1确定是否使用API</h2>
          <p>同1.1</p>
          <h2 class="header-2">2.2使用API</h2>
          <p>同1.2</p>
          <h2 class="header-2">2.3不使用API</h2>
          <p>同1.3</p>
          <h2 class="header-2">2.4验证码</h2>
          提交验证码设置，如下图所示：
          <br>
          <img src="/imgs/cfg-submit-settings.png" />
          <img src="/imgs/cfg-submit-params-settings.png" />
          <h2 class="header-2">2.5数据同步</h2>
          <p>同1.4</p>
      </div>
    </div>
  </div>  
  


  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingUrl">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseUrl" aria-expanded="true" aria-controls="collapseUrl">
          3.url+类型
        </a>
      </h4>
    </div>
    <div id="collapseUrl" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingUrl">
      <div class="panel-body">
          <h2 class="header-2">3.1使用API</h2>
          <p>同1.2</p>
          <h2 class="header-2">3.2验证码</h2>
          <p>同2.4</p>
          <h2 class="header-2">3.3数据同步</h2>
          <p>同1.4</p>
      </div>
    </div>
  </div>

</div>








</div>