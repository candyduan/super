<ol class="breadcrumb">
<li class="active">JSON解析</li>
</ol>
<div class="main">
<textarea class="col-xs-12 json_string" rows="10" placeholder="请将json字符串输入在此">
</textarea>
<div class="clearfix"></div>
<br>
<button class="btn btn-default btn-trans">解析</button>
<div class="clearfix"></div>
<br>
<div class="json_result">

</div>
</div>

<script>
$(document).ready(function(){
$('.btn-trans').click(function(){
	var json = JSON.parse($('.json_string').val());
	var result = JSON.stringify(json, null, 2);

	$('.json_result').html('<pre>'+result+'</pre>');
});
	
});
</script>