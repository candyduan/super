<link rel="stylesheet" href="/ace/assets/css/bootstrap-datepicker3.min.css" />
<div class="panel panel-warning">
    <!-- panel heading -->
       <ol class="breadcrumb">
        <li class="active">融合SDK计费转化表</li>
        </ol>
    <!-- panel body -->
    <div class="panel-body main">
        <div class="row">
        	<form action="" method="get" id="formSearch" class="form-inline">
                <div class="col-sm-10 col-md-10 col-lg-10">
                    <input type="text"  class="form-control " id='sdk' name ='SDK'  placeholder="SDK"/>
                    <input  type="text"   class="form-control date-picker" id="startDate" name="startDate" data-date-format="yyyy-mm-dd">
                    ~
                    <input  type="text"   class="form-control date-picker" id="endDate" name="endDate" data-date-format="yyyy-mm-dd">
                     字段：
                    <input type="checkbox" id="checkSDK" name="checkSDK"/> SDK 
                    <input type="checkbox" id="checkProvince" name="checkProvince"/> 省份 
                    <input type="checkbox" id="checkProvider" name="checkProvider"/>运营商 
                    
                    <i class="glyphicon pointer green glyphicon-glass" onclick="setDateType(this)" title="时段" value="3" id="inputDateType"></i> 
                    <i class="glyphicon pointer green glyphicon-phone" onclick="setProvider(this)" title="运营商" value="0" id="inputProvider"></i> 
                    <i class="glyphicon pointer green glyphicon-globe" onclick="setProvince()" title="省份"></i> 
                    <i class="glyphicon pointer grey glyphicon-time" onclick="setTime()" title="小时时段"></i> 
                    <i class="glyphicon pointer blue glyphicon-search" onclick="searchData()" title="查询"></i> 
                    <i class="glyphicon pointer green glyphicon-cloud-download" onclick="downloadData()" title="下载"></i> 
                </div>  
            </form>
        </div><hr>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <table id="tbl" class="table table-striped table-bordered gclass_table text-center">
                    <thead>
                    <tr>
                        <td id="cloumn_date">日期</td>
                        <td id="cloumn_sdk">SDK</td>
                        <td id="cloumn_provider">运营商</td>
                        <td id="cloumn_province">省份</td>
                        <td>请求金额</td>
                        <td>信息费</td>
                        <td>转化率</td>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- panel footer -->
    <div class="panel-footer">
    </div>
</div>

<div id="modalSdkTime" class="modal fade">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <span>SDK时间设置:</span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="div_sdktime" style="height:500px">
            </div>
            <input type="hidden" id='hidden_setime_array' value = "" />
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn_set_all">全选</button>
                <button type="submit" class="btn btn-success" id="btn_submit_sdktime">提交</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>

<div id="modalProvince" class="modal fade">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <span>省份设置:</span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="div_province" style="height:500px">
            </div>
            <input type="hidden" id='hidden_province_array' value = "" />
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="btn_submit_province">提交</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>

<!-- ------------------------------------------------------------------------javascript---------------------------------------------------------------------->
<!--<script src="/ace/assets/js/jquery-ui.custom.min.js"></script>-->
<script src="/ace/assets/js/bootstrap-datepicker.min.js"></script>
<script src="/js/sdk/util.js"></script>
<script src="/js/sdk/alert.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var now = getCurdate();
        $("#startDate").val(now);
        $("#endDate").val(now);
        _initDataTable();
    });

    $('.date-picker').datepicker({
        autoclose: true,
        todayHighlight: true
    })

    function _initDataTable() {
        var param = '&dateType='+ $("#inputDateType").attr("value");
        param += '&provider=' + $("#inputProvider").attr("value");
        param += '&province=' + $('#hidden_province_array').val().split(',');
        param += '&time=' + $('#hidden_setime_array').val().split(',');

// 		var targetsCount  = 4;// TODO 动态变化列数
// 		if($("#checkSDK").prop('checked')){
// 			targetsCount += 1;
// 		}
// 		if($("#checkProvince").prop('checked')){
// 			targetsCount += 1;
// 		}
// 		if($("#checkProvider").prop('checked')){
// 			targetsCount += 1;
// 		}

//         var aTargets = [];
//         for(var i = 0; i < targetsCount;i++){
//         	aTargets.push(i);
//         }
        $("#tbl").dataTable().fnDestroy();
//         refreshColumn();
        
        $('#tbl').DataTable({
            "pagingType": "simple_numbers",
            "searching": false,
            "bAutoWidth": false,
            "scrollX": true,
            //"order": [[ 5, "desc" ]],
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0,1,2,3,4,5,6],
            }],
            "displayLength": 100, //默认每页多少条数据
            "processing": true,
            "language": {
                "processing": "数据加载中，请稍候......",
                "search": "在结果中查找:",
                "lengthMenu": " _MENU_ 每页",
                "zeroRecords": "对不起,没有符合条件的数据",
                "info": "第 _PAGE_ / _PAGES_ 页",
                "infoEmpty": "对不起,没有符合条件的数据", //???
                "paginate" : {
                    "first" : "首页",
                    "previous" : "上一页",
                    "next" : "下一页",
                    "last" : "尾页"
                }
            },
            "serverSide": true,
            "ajax": {
                "url":'/sdk-pay/ajax-index?' + $.param($('#formSearch').serializeArray()) + param,
                "dataSrc": function(json) {
                    return json.tableData;
                }
            }
        });
    }

    $('#btn_set_all').on('click', function(event){
        event.preventDefault();
        var set = $('#div_sdktime').children(".btn-circle").eq(0).hasClass('btn-success');
        $('#div_sdktime').children(".btn-circle").each(function(){
        	if(set){
                $(this).removeClass('btn-success').addClass('btn-danger');
            }else{
                $(this).removeClass('btn-danger').addClass('btn-success');
            }
        });
    });

    
    $('#btn_submit_sdktime').on('click', function(event){
        event.preventDefault();
        var timelimit = [];
        $('#div_sdktime').children(".btn-circle.btn-danger").each(function(){
            timelimit.push($(this).text());
        });
        $('#hidden_setime_array').val(timelimit.join(','));
        $('#modalSdkTime').modal('hide');
    });

    
    function saveProvince(){
    	$('#btn_submit_province').on('click', function(event){
            event.preventDefault();
            var provincelimit = [];
            $('#div_province td').children(".btn-success").each(function(){
            	provincelimit.push($(this).attr('value'));
            });
            $('#hidden_province_array').val(provincelimit.join(','));
            $('#modalProvince').modal('hide');
        });
    }

    function refreshColumn(){
        if($("#checkSDK").prop('checked')){
        	$("#cloumn_sdk").show();
        }else{
        	$("#cloumn_sdk").hide();
        }
        if($("#checkProvince").prop('checked')){
        	$("#cloumn_province").show();
        }else{
        	$("#cloumn_province").hide();
        }
        if($("#checkProvider").prop('checked')){
        	$("#cloumn_provider").show();
        }else{
        	$("#cloumn_provider").hide();
        }
    }
    
    function setDateType(that){
    	if($(that).hasClass('glyphicon-glass')){
            $(that).removeClass('glyphicon-glass').addClass('glyphicon-music');
            $(that).attr('title',"月份");
            $(that).attr('value',"4");
        }else if($(that).hasClass('glyphicon-music')){
            $(that).removeClass('glyphicon-music').addClass('glyphicon-certificate');
            $(that).attr('title',"天");
            $(that).attr('value',"1");
        }else if($(that).hasClass('glyphicon-certificate')){
            $(that).removeClass('glyphicon-certificate').addClass('glyphicon-time');
            $(that).attr('title',"小时");
            $(that).attr('value',"2");
        }else if($(that).hasClass('glyphicon-time')){
            $(that).removeClass('glyphicon-time').addClass('glyphicon-glass');
            $(that).attr('title',"时段");
            $(that).attr('value',"3");
        }
    }
    function setProvider(that){
    	if($(that).hasClass('glyphicon-phone')){
            $(that).removeClass('glyphicon-phone').addClass('glyphicon-signal');
            $(that).attr('title',"移动");
            $(that).attr('value',"1");
        }else if($(that).hasClass('glyphicon-signal')){
            $(that).removeClass('glyphicon-signal').addClass('glyphicon-magnet');
            $(that).attr('title',"联通");
            $(that).attr('value',"2");
        }else if($(that).hasClass('glyphicon-magnet')){
            $(that).removeClass('glyphicon-magnet').addClass('glyphicon-superscript');
            $(that).attr('title',"电信");
            $(that).attr('value',"3");
        }else if($(that).hasClass('glyphicon-superscript')){
            $(that).removeClass('glyphicon-superscript').addClass('glyphicon-phone');
            $(that).attr('title',"运营商");
            $(that).attr('value',"0");
        }
    }
    function setProvince(){
    	var province = $('#hidden_province_array').val().split(',');

        var post_url = '/sdk-pay/get-province';
        var post_data = {
        };
        var method = 'get';
        var success_function = function(result){
            var content_str = '';
            for(var key in result) {
                var content_arr = [];
                content_arr.push("<tr><td>"+key+"</td>");
                var subList= result[key];
                for(var i in subList){
                	if (province.indexOf("" + subList[i].id) == -1){ 
                        content_arr.push('<td><button  onclick = "provincebtnClick(this)" class="btn-danger" value="'+subList[i].id+'">'+subList[i].name+'</button ></td>');
                    }else{
                        content_arr.push('<td><button  onclick = "provincebtnClick(this)" class="btn-success" value="'+subList[i].id+'">'+subList[i].name+'</button ></td>');
                    }
                }
                content_str  += content_arr.join(' ');//要改
            }
            $('#div_province').empty().append(content_str);
            $('#btn_submit_province').attr('disabled', false);
            $('#modalProvince').modal('show');
            saveProvince();
        };
        callAjaxWithFunction(post_url, post_data, success_function, method);
    }
    function setTime(){
    	var circle_buttons = [];
    	var times = $('#hidden_setime_array').val().split(',');
        for(var i = 0 ; i < 24 ; i++) {
            if (times.indexOf("" + i) == -1){ 
                circle_buttons.push('<button  onclick = "timebtnClick(this)" class="btn-circle btn-lg btn-success">'+i+'</button >');
            }else{
                circle_buttons.push('<button  onclick = "timebtnClick(this)" class="btn-circle btn-lg btn-danger">'+i+'</button >');
            }
        }
        $('#btn_submit_sdktime').attr('disabled', false);
        $('#div_sdktime').empty().append(circle_buttons.join(' '));
        $('#modalSdkTime').modal('show');
    }
    
    function searchData(){
    	_initDataTable();
    }
    function downloadData(){
    	var param = '&dateType='+ $("#inputDateType").attr("value");
        param += '&provider=' + $("#inputProvider").attr("value");
        param += '&province=' + $('#hidden_province_array').val().split(',');
        param += '&time=' + $('#hidden_setime_array').val().split(',');
    	var url = '/sdk-pay/index-download';
    	var data = $.param($('#formSearch').serializeArray()) + param;
    	window.open(url+'?'+data);
    }
    
    function timebtnClick(that){
        if($(that).hasClass('btn-success')){
            $(that).removeClass('btn-success').addClass('btn-danger');
        }else{
            $(that).removeClass('btn-danger').addClass('btn-success');
        }
    }
    function provincebtnClick(that){
        if($(that).hasClass('btn-success')){
            $(that).removeClass('btn-success').addClass('btn-danger');
        }else{
            $(that).removeClass('btn-danger').addClass('btn-success');
        }
    }
    function getCurdate(){
    	var now=new Date();
        var y=now.getFullYear();
        var m=now.getMonth()+1;
        var d=now.getDate();
        var m=m<10?"0"+m:m;
       	var d=d<10?"0"+d:d;
        return y+"-"+m+"-"+d;
    }
</script>