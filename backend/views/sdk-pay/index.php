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
                    <input  type="text"   class="form-control date-picker" id="endDate" data-date-format="yyyy-mm-dd">
                     字段：
                    <input type="checkbox" id="checkSDK" name="checkSDK"/> SDK 
                    <input type="checkbox" id="checkProvince" name="checkProvince"/> 省份 
                    <input type="checkbox" id="checkProvider" name="checkProvider"/>运营商 
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


<!-- ------------------------------------------------------------------------javascript---------------------------------------------------------------------->
<!--<script src="/ace/assets/js/jquery-ui.custom.min.js"></script>-->
<script src="/ace/assets/js/bootstrap-datepicker.min.js"></script>
<script src="/js/sdk/util.js"></script>
<script src="/js/sdk/alert.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
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

   // $("#startDate").datetimepicker({format: 'yyyy-mm-dd'});
</script>