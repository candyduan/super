<ol class="breadcrumb">
<li class="active">活动包开关设置-活动列表</li>
</ol>
<div class="main">

<!-- 搜索栏 -->
<div class="form-inline searchbar">
  <div class="form-group"><input type="text"  data-provide="typeahead"  id="partnerText" class="form-control searchbar_merchant"  placeholder="Partner"></div>
  <input type="hidden" id="partner" value="">
  
  <select class="form-control" id="app" style="width: 160px">
	<option value="0" >选择应用</option>
  </select>
  <button type="submit" class="btn btn-default searchbar_smt" id="searchBtn"> 搜索 </button>
</div>

<!-- 数据栏 -->
<div class="databar">
	<table class="table table-bordered table-hover">
	<thead><tr><td>活动名</td><td>状态</td><td>SIGN</td><td>管理</td></tr></thead>
	<tbody id="data_list"></tbody>
	</table>
</div>


<!-- 分页 -->
<div class=""><nav><ul class="pager"></ul></nav></div>

</div>
 
<script>
$(document).ready(function(){
	setResult(1);    
	$('#searchBtn').click(function(){
		setResult(1);
    });
});

function setResult(page){
	var url = '/register/campaign-result';
	var app		= $("#app").val();
	var data 	= 'app='+app+'&page='+page;
	var succ    = function(resultJson){
		if(parseInt(resultJson.resultCode) == 1){
			var resultHtml = '';
			$.each(resultJson.list,function(key,val){
				resultHtml = resultHtml + '<tr><td>'+val.campaignName+'</td><td>'+val.statusName+'</td><td>'+val.campaignSign+'</td><td><a class="pointer" href="/register/campaign-package-view?campaignId='+val.campaignId+'" >活动包</a></td></tr>';
			});
			$('#data_list').html(resultHtml);

			Utils.setPagination(page,resultJson.pages);
			$(".pager_number").click(function(){
				setResult($(this).attr('page'));
			});
		}else{
			$('#data_list').html(resultJson.msg);
		}
	};
	Utils.ajax(url,data,succ);
}

function searchApp(){
    var url 		= '/register/get-app-by-partner-result';
  	var partner  	= $('#partner').val();
    var data 		= 'partner='+partner;
    var succ        = function(resultJson){
		if(parseInt(resultJson.resultCode) == 1){
			resultHtml	= '';
			$.each(resultJson.list,function(key,val){
				resultHtml = resultHtml + '<option value="'+val.id+'" >'+val.name+'</option>';
			});
			$('#app').html(resultHtml);
			}else{
            	$('#data_list').html(resultJson.msg);
            }
    };
    Utils.ajax(url,data,succ);
}

var jsonList	= <?php echo json_encode(\common\models\orm\extend\Partner::findAllToArray())?>;
Utils.myTypeHeder(jsonList,"partnerText","partner",searchApp);
</script>

