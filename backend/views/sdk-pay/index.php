<link rel="stylesheet" href="/ace/assets/css/bootstrap-datepicker3.min.css" />
<div class="panel panel-warning">
    <!-- panel heading -->
    <div class="page-header">
        <h1>
            <i class="ace-icon fa fa-angle-double-right"></i>
            融合SDK计费转化表
        </h1>
    </div>
    <!-- panel body -->
    <div class="panel-body">
        <div class="row">
        	<form action="" method="get" id="formSearch" class="form-inline">
                <div class="col-sm-10 col-md-10 col-lg-10">
                    <input type="text"  class="form-control " id='sdk' name ='SDK'  placeholder="SDK"/>
                    <input  type="text"   class="form-control date-picker" id="startDate" data-date-format="yyyy-mm-dd">
                    ~
                    <input  type="text"   class="form-control date-picker" id="endDate" data-date-format="yyyy-mm-dd">
                     字段：
                    <input type="checkbox" id="checkSDK" name="checkSDK" checked="true"/> SDK 
                    <input type="checkbox" id="checkProvince" name="checkProvince" checked="true"/> 省份 
                    <input type="checkbox" id="checkProvider" name="checkProvider" checked="true"/>运营商 
                    
                    <i class="glyphicon pointer green glyphicon-certificate" onclick="showDateType()" title="时间显示方式"></i> 
                    <i class="glyphicon pointer green glyphicon-phone" onclick="showProvider()" title="运营商"></i> 
                    <i class="glyphicon pointer green glyphicon-globe" onclick="showProvince()" title="省份"></i> 
                    <i class="glyphicon pointer grey glyphicon-time" onclick="showTime()" title="小时时段"></i> 
                    <i class="glyphicon pointer blue glyphicon-search" onclick="searchData()" title="查询"></i> 
                    <i class="glyphicon pointer green glyphicon-cloud-download" onclick="downloadData()" title="下载"></i> 
                </div>  
                </div>
            </form>
        </div><hr>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <table id="tbl" class="table table-striped table-bordered gclass_table text-center">
                    <thead>
                    <tr>
                        <td>日期</td>
                        <td>SDK</td>
                        <td>运营商</td>
                        <td>省份</td>
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
            <input type="hidden" id='hidden_setime_array' value = "[]" />
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="btn_submit_sdktime">提交</button>
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
        $("#tbl").dataTable().fnDestroy();
        $('#tbl').DataTable({
            "pagingType": "simple_numbers",
            "searching": false,
            "scrollX": true,
            //"order": [[ 5, "desc" ]],
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0, 1, 2, 3, 4,5,6,7,8,9]
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
                "url":'/sdk-pay/ajax-index?' + $.param($('#formSearch').serializeArray()),
                "dataSrc": function(json) {
                    return json.tableData;
                }
            }
        });
    }

    $('#btn_submit_sdktime').on('click', function(event){
        event.preventDefault();
        var timelimit = [];
        $('#div_sdktime').children(".btn-circle.btn-danger").each(function(){
            timelimit.push($(this).text());
        });
        $('#hidden_setime_array').val(timelimit.join(','));
        $('#modalSdkTime').modal('hide');
    });
    
    function showDateType(){
        alert(1);
    }
    function showProvider(){
        alert(2);
    }
    function showProvince(){
    }
    function showTime(){
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
    }
    function downloadData(){
    }

    function timebtnClick(that){
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