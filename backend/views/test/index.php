
<div class="panel panel-warning">
    <!-- panel heading -->
    <div class="page-header">
        <h1>
            <i class="ace-icon fa fa-angle-double-right"></i>
            融合SDK管理
        </h1>
    </div>
    <!-- panel body -->
    <div class="panel-body">
        <div class="row">
            <form action="" method="get" id="formSearch" class="form-inline">
                <div class="col-sm-10 col-md-10 col-lg-10">
                    SDK名称: <input type="text" class="form-control" id="name" name="name" placeholder="模糊搜索"/>
                    <button class="btn btn-primary" type="submit" id="btn_search">
                        <span class="glyphicon glyphicon-search"></span>
                        <span>搜索</span>
                    </button>&nbsp;&nbsp;&nbsp;&nbsp;
                    <button class="btn btn-danger" type="submit" id="btn_search">
                        <span class="glyphicon glyphicon-plus"></span>
                        <span>+SDK</span>
                    </button>&nbsp;&nbsp;
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2 text-right">
                </div>
            </form>
        </div><hr>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <table id="tbl" class="table table-striped table-bordered gclass_table text-center">
                    <thead>
                    <tr>
                        <td>SDK</td>
                        <td>名单</td>
                        <td>地域</td>
                        <td>时段</td>
                        <td>状态</td>
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

<!--<div id="modal" class="modal fade" >
    <div class="modal-dialog gclass_modal_md" >
        <div class="modal-content">
            <div class="modal-header">
                <span>拒绝原因</span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form id="formRejectConvert" action="#" method="post" enctype="multipart/form-data" class="form-inline">
                <div class="modal-body" >
                    <div class="input-group">
                        <span class="input-group-addon">1：</span>
                        <textarea class="form-control gclass_textarea_full" name="reject_cause" id="reject_cause"></textarea>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon">2：</span>
                        <select id="reject_return" name="reject_return" class="form-control">
                            <option value="0">3</option>
                            <option value="1">4</option>
                        </select>
                    </div><br />
                    <input type="hidden" id="reject_bcaid" name="reject_bcaid"/>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btn_submit_reject">提交</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
                </div>
            </form>
        </div>
    </div>
</div>-->
<!-- ------------------------------------------------------------------------javascript---------------------------------------------------------------------->
<script type="text/javascript">
    $(document).ready(function(){
        _initDataTable();
       // alert(1);
    });

    $('#btn_search').on('click', function(event){
        event.preventDefault();
        _initDataTable();
    });
    function _initDataTable() {
        $("#tbl").dataTable().fnDestroy();
        $('#tbl').DataTable({
            "pagingType": "simple_numbers",
            "searching": false,
            "scrollX": true,
            //"order": [[ 5, "desc" ]],
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0, 1, 2, 3, 4]
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
                "url":'/test/ajax-index?' + $.param($('#formSearch').serializeArray()),
                "dataSrc": function(json) {
                    return json.tableData;
                }
            }
        });
    }

</script>