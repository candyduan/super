
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
                    </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button class="btn btn-danger" id="btn_add">
                        <span class="glyphicon glyphicon-plus"></span>
                        <span>SDK</span>
                    </button>&nbsp;
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
<div id="modalSdk" class="modal fade" >
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <span>SDK详情:</span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form id="formSdk" action="#" method="post" enctype="multipart/form-data">
                <div class="modal-body" >
                    <div class="input-group">
                        <span class="input-group-addon">sdk商:</span>
                        <input type="text" name="sdk_partner" id="sdk_partner" class="form-control" width="1000px"/>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon">sdk名称:</span>
                        <input type="text" name="sdk_name" id="sdk_name" class="form-control"/>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon">分成比例:</span>
                        <input type="text" name="sdk_proportion" id="sdk_proportion" class="form-control" placeholder ='请填写0-100的整数'"/>
                        <span class="input-group-addon">%</span>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon">优化比例:</span>
                        <input type="text" name="sdk_optimization" id="sdk_optimization" class="form-control" placeholder ='请填写0-100的整数'/>
                        <span class="input-group-addon">%</span>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon">同步地址:</span>
                        <input type="text" name="sdk_syn" id="sdk_syn" class="form-control"/>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon">备注:</span>
                        <textarea type="text" cols="20" rows="10" name="sdk_remark" id="sdk_remark" class="form-control"></textarea>
                    </div><br /><br />
                    <input type="hidden" id="sdk_sdid" name="sdk_sdid" value=""/>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btn_submit_sdk">提交</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ------------------------------------------------------------------------javascript---------------------------------------------------------------------->
<script src="/web/ace/assets/js/jquery-2.1.4.min.js"></script>
<script src="/web/js/util.js"></script>
<script src="/web/js/alert.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        _initDataTable();
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
                "url":'/sdk/ajax-index?' + $.param($('#formSearch').serializeArray()),
                "dataSrc": function(json) {
                    return json.tableData;
                }
            }
        });
    }

    $('#btn_add').on('click', function(event){
        event.preventDefault();
        window.formSdk.reset();
        $('#sdk_sdid').val('');
        $('#btn_submit_sdk').attr('disabled', false);
        $('#modalSdk').modal('show');
    });

    $('#formSdk').on('submit', (function(event){
        event.preventDefault();

        var sdid = $('#sdk_sdid').val();
        var type = (sdid == '') ? 'add' : 'modify';
            $('#btn_submit_sdk').attr('disabled', true);
            var post_url = '/sdk/'+ type +'-sdk';
            var post_data = new FormData(this);
            var msg_success = (sdid == '') ? MESSAGE_ADD_SUCCESS : MESSAGE_MODIFY_SUCCESS;
            var msg_error = (sdid == '') ? MESSAGE_ADD_ERROR : MESSAGE_MODIFY_ERROR;
            var method = 'post';
            var successFunc = function (result) {
               if(parseInt(result) == 1){
                   alert(msg_success);
               }else if(parseInt(result) == 0){
                   alert(msg_error);
               } else if(parseInt(result) == -1){
                   alert(NAME_EXIST_ERROR);
               }
               $('#modalSdk').modal('hide');
               _initDataTable();
        };
        callAjaxWithFormAndFunction(post_url, post_data, method, successFunc);
    }));

    function modifySdk(sdid){
        var post_url = '/sdk/get-sdk';
        var post_data = {
            'sdid' : sdid
        };
        var method = 'get';
        var success_function = function(result){
            $('#sdk_icid').val(result.sdid);
            $('#btn_submit_sdk').attr('disabled', false);
            $('#modalSdk').modal('show');
        };
        callAjaxWithFunction(post_url, post_data, success_function, method);
    }

</script>