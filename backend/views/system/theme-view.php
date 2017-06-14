<ol class="breadcrumb">
<li class="active">更换主题</li>
</ol>
<style>
.theme-item{height:200px;width:200px;display:inline-block;margin-right:20px;}
h1{font-size:20px;}
</style>
<div class="main">
<h1>请选择你喜欢的主题</h1>
    <div class="databar">
    
    </div>
</div>

<script>
$(document).ready(function(){
	setResult();    
});
function setResult(){
	var url = '/system/theme-result';
	var data='';
	var succ	= function(json){
		var content = '';
		if(parseInt(json.resultCode) == 1){
			$.each(json.list,function(key,val){
				content = content +'<div class="theme-item" data-btid="'+val.btid+'" style="background-color:#'+val.bcolor+'"></div>';
			});
		}else{
			content = json.msg;
		}
		$('.databar').html(content);
		$('.theme-item').click(function(){
			var setUrl	= '/system/theme-set';
			var setData = 'btid='+$(this).attr('data-btid');
			var setSucc = function(setJson){
					if(parseInt(setJson.resultCode) == 1){
						window.location.reload();
					}else{
						Utils.tipBar('error','失败',setJson.msg);
					}
				};
			Utils.ajax(setUrl,setData,setSucc);
		});
	};
	Utils.ajax(url,data,succ);
};
</script>
