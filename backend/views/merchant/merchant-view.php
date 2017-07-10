<?php use common\models\orm\extend\Merchant; ?>
<ol class="breadcrumb">
<li class="active">通道商列表</li>
</ol>
<!-- 搜索 -->
<div class="form-inline searchbar">
  <div class="form-group">
  	<input type="text" class="form-control searchbar_merchant" id="selectMerchantObj" placeholder="通道商" value=''>
  	<input type="hidden" id="merchantId" value="">
  
  </div>
  <button type="submit" class="btn btn-default searchbar_smt" id="search"> 搜索 </button>
  <button type="submit" class="btn btn-default addMerchant_btn" id="addMerchantBtn"> 添加 </button>
</div>

<div class="main">
    <!-- 数据栏 -->
    <div class="databar">
    	<table class="table table-bordered table-hover">
    	<thead><tr><td>ID</td><td>通道商名称</td><td>负责人</td><td>结算周期</td><td>税率（%）</td><td>管理</td></tr></thead>
    	<tbody id="data_list"></tbody>
    	</table>
    </div>
    
    
    <!-- 分页 -->
    <div class=""><nav><ul class="pager"></ul></nav></div>
</div>

<!-- 添加通道商窗口 -->
<div class="modal fade" id="saveMerchantDiv">
	<div class="modal-dialog">
		<div class="modal-content circular">
			<div class="modal-header" style="background-color:#f1f1f1;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">添加/编辑通道商</h4>
			</div>
			<div class="modal-body" style="padding-top:0px;">
				<p>
					<div>
						<div class="input-group">
							<span class="input-group-addon">通道商名称</span>
							<input type="text" class="form-control mutexName" placeholder="" aria-describedby="basic-addon1" id="merchantName" value="">
						</div>
						
						<div class="input-group">
							<span class="input-group-addon">公司地址</span>
							<input type="text" class="form-control mutexName" placeholder="" aria-describedby="basic-addon1" id="merchantAddr" value="">
						</div>
		
						<div class="input-group">
							<span class="input-group-addon">通道商负责人</span>
							<select class="form-control" id="merchantHolder">	
							</select>
						</div>
						
						<div class="input-group">
							<span class="input-group-addon">结算周期</span>
							<select class="form-control" id="payCircle">
								<option value="1" selected>周结</option>
								<option value="2">月结</option>
							</select>
						</div>
						
						<div class="input-group">
							<span class="input-group-addon">结算税率(%)</span>
							<input type="text" class="form-control mutexName" placeholder="" aria-describedby="basic-addon1" id="tax" value="">
						</div>
						
						<div class="input-group">
							<span class="input-group-addon">备注</span>
							<input type="text" class="form-control mutexName" placeholder="" aria-describedby="basic-addon1" id="memo" value="">
						</div>
						
						<input type='hidden' value='' id='mid'>
						<button type="submit" class="btn btn-primary searchbar_smt" id="saveMerchant"> 保存 </button>
					</div>
				</p>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
    setResult(1); 
    $('#search').click(function(){
        if($('#selectMerchantObj').val() == ''){
			$('#merchantId').val('');
        }
        setResult(1);
	});
});

var merchantJsonList =<?=json_encode(Merchant::findAllToArray())?>;
var objMap = {};
$("#selectMerchantObj").typeahead({
    source: function (query, process) {
        var names = [];
        $.each(merchantJsonList, function (index, ele) {
            objMap[ele.name] = ele.id;
            names.push(ele.name);
        });
        process(names);//调用处理函数，格式化
    },
    items: 8,//最多显示个数
    afterSelect: function (item) {
        $('#merchantId').val(objMap[item]);
    }
});

function setResult(page){
    //url
    var url = '/merchant/merchant-result';
    //data
  	var merchantId  = $('#merchantId').val();
    var data = 'merchantId='+merchantId+'&page='+page;
    //succ
    var succ        = function(resultJson){
            if(parseInt(resultJson.resultCode) == 1){
                    var resultHtml = '';
                    $.each(resultJson.list,function(key,val){
                        var from = Utils.getQueryString('from');
                        var viewSee;
                        if(from == 1){
                        	viewSee = '/pay/channel-view?mid='+val.id;
                        }else{
                        	viewSee = '/register/channel-view?mid='+val.id;
                        }
                        resultHtml = resultHtml + '<tr><td>'+val.id+'</td><td>'+val.name+'</td><td>'+val.holder+'</td><td>按'+val.payCircle+'结算</td><td>'+val.tax+'</td><td><a class="btn btn-default " href="'+viewSee+'"> 查看 </a><button type="submit" class="btn btn-default editMerchant_btn" mid="'+val.id+'"> 编辑 </button></td>';
                    });
                    $('#data_list').html(resultHtml);
	                Utils.setPagination(page,resultJson.pages);
	                $(".pager_number").click(function(){
	                    setResult($(this).attr('page'));
	                });
	            

			$('.editMerchant_btn').click(function(){
				
				var mid = $(this).attr('mid');
				var data = 'mid='+mid;
				var url = '/merchant/get-merchant-info';
				var payCircle;
				var succ =function(resultJson){
					if(resultJson.resultCode == 1){
						var item = resultJson.item;
						var holders = resultJson.holders;
						 var op = '';
					        $.each(resultJson.holders,function(key,val){
								op += '<option value="'+key+'">'+val+'</option>';
						    })
						    $('#merchantHolder').html(op);
						    
						$('#merchantName').val(item.name);
						$('#merchantAddr').val(item.addr);
						$('#merchantHolder').val(item.holderId);
						payCircle = item.payCircle == '周' ? 1 : 2;
						$('#payCircle').val(payCircle);
						$('#tax').val(item.tax);
						$('#memo').val(item.memo);
						$('#mid').val(mid);
						$('#saveMerchantDiv').modal('show');
					}else{
						Utils.getErrModal('err',resultJson.msg);
					}							
				}
				Utils.ajax(url,data,succ);
			});
            
            }else{
                    $('#data_list').html(resultJson.msg);
            }
    };
    //ajax
    Utils.ajax(url,data,succ);
}

$('#addMerchantBtn').click(function(){
	$('#merchantName').val('');
	$('#merchantAddr').val('');
	$('#merchantHolder').val('');
	$('#payCircle').val('1');
	$('#tax').val('');
	$('#memo').val('');
	$('#mid').val('');
	var url = '/merchant/holder-result';
	var data = '';
	var succ = function(resultJson){
	        if(parseInt(resultJson.resultCode) == 1){
		        var op = '';
		        $.each(resultJson.holders,function(key,val){
					op += '<option value="'+key+'">'+val+'</option>';
			    })
			    $('#merchantHolder').html(op);
			    $('#saveMerchantDiv').modal('show');
	        }else{
	        	Utils.getErrModal('err', resultJson.msg); 
	        }
		}
        Utils.ajax(url,data,succ);
})

$('#saveMerchant').click(function(){
	var merchantName = $('#merchantName').val();
	var merchantAddr = $('#merchantAddr').val();
	var merchantHolder = $('#merchantHolder').val();
	var payCircle = $('#payCircle').val();
	var tax = parseFloat($('#tax').val());
	var memo = $('#memo').val();
	var mid = $('#mid').val();
	if(merchantName == ''){
		return;
	}
	
	var url = '/merchant/merchant-set-save';
	var data = 'name='+merchantName+'&addr='+merchantAddr+'&holder='+merchantHolder+'&payCircle='+payCircle+'&tax='+tax+'&memo='+memo+'&mid='+mid; 
	var succ = function(resultJson){
		if(resultJson.resultCode == 1){
			$('#saveMerchantDiv').modal('hide');
			Utils.getNoFooterModal('succ',resultJson.msg);
		}else{
			Utils.getErrModal('err',resultJson.msg);
		} 
	}
	//ajax
    Utils.ajax(url,data,succ);
})


</script>
