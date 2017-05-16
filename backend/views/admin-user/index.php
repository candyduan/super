
<div class="panel panel-warning">
    <!-- panel heading -->
    <div class="page-header">
        <h1>
            <i class="ace-icon fa fa-angle-double-right"></i>
            后台用户管理
        </h1>
    </div>
    <!-- panel body -->
    <div class="panel-body">
        <div class="row">
            <form action="" method="get" id="formSearch" class="form-inline">
                <div class="col-sm-10 col-md-10 col-lg-10">&nbsp;&nbsp;
                    <button class="btn btn-primary" id="btn_add">
                        <span class="glyphicon glyphicon-plus"></span>
                        <span>新增后台用户</span>
                    </button>
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
                        <td>用户名</td>
                        <td>权限</td>
                        <td>管理</td>
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
<div id="modalAdminUser" class="modal fade" >
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <span>新增后台用户:</span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form id="formAdminUser" action="#" method="post" enctype="multipart/form-data">
                <div class="modal-body" >
                    <div class="input-group">
                        <span class="input-group-addon"> 用户名  <span class="red">*</span> :</span>
                        <input placeholder ='必填' type="text" name="username" id="username" class="form-control" width="1000px"/>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon"> 密码  <span class="red">*</span>:</span>
                        <input  placeholder ='必填' type="text" name="password" id="password" class="form-control"/>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon"> 邮箱</span>
                        <input  type="text" name="email" id="email" class="form-control"/>
                    </div><br /><br />

                        <span class="input-group-addon"> 权限  <span class="red">*</span>:</span>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="sdk" >SDK管理
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="sort">SDK计费排序
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"  name="app-partner-campaign">SDK内容中心
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"  name="sdk-promotion-result"> SDK成果录入
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"  name="modify-password"> 密码修改
                            </label>
                        </div>
                    </div><br /><br />
                <input type="hidden" value="" name="auid" id="auid"/>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btn_submit_adminuser">提交</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ------------------------------------------------------------------------javascript---------------------------------------------------------------------->
<script src="/ace/assets/js/jquery-2.1.4.min.js"></script>
<script src="/js/sdk/util.js"></script>
<script src="/js/sdk/alert.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        _initDataTable();
    });

    function _initDataTable() {
        $("#tbl").dataTable().fnDestroy();
        $('#tbl').DataTable({
            "pagingType": "simple_numbers",
            "searching": false,
            "bAutoWidth": false,
            "scrollX": true,
            //"order": [[ 5, "desc" ]],
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0, 1, 2]
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
                "url":'/admin-user/ajax-index?' + $.param($('#formSearch').serializeArray()),
                "dataSrc": function(json) {
                    return json.tableData;
                }
            }
        });
    }

    $('#btn_add').on('click', function(event){
        event.preventDefault();
        $('#auid').val('');
        $('#formAdminUser').trigger("reset"); //window.formSdk.reset();
        $('#modalAdminUser').modal('show');
    });

    $('#formAdminUser').on('submit', (function(event){
        event.preventDefault();
        var error_num = validInput();
        if(error_num == 0) {
            var auid = $('#auid').val();
            var type = (auid == '') ? 'add' : 'modify';
            $('#btn_submit_adminuser').attr('disabled', true);
            var post_url = '/admin-user/'+type+'-user';
            var post_data = new FormData(this);
            var msg_success = (sdid == '') ? MESSAGE_ADD_SUCCESS : MESSAGE_MODIFY_SUCCESS;
            var msg_error = (sdid == '') ? MESSAGE_ADD_ERROR : MESSAGE_MODIFY_ERROR;
            var method = 'post';
            var successFunc = function (result) {
                if (parseInt(result) == 1) {
                    alert(msg_success);
                    $('#modalAdminUser').modal('hide');
                    _initDataTable();
                } else if (parseInt(result) == 0) {
                    alert( msg_error);
                } else if (parseInt(result) == -1) {
                    alert('新增失败！用户名已经存在');
                }
                $('#btn_submit_adminuser').attr('disabled', false);
            };
            callAjaxWithFormAndFunction(post_url, post_data, method, successFunc);
        }
    }));

    function modifySdk(sdid){
        var post_url = '/sdk/get-sdk';
        var post_data = {
            'sdid' : sdid
        };
        var method = 'get';
        var success_function = function(result){
            $('#sdk_partner').val(result.partner).prop('disabled', true);
            $('#sdk_name').val(result.name).prop('disabled',true);
            $('#sdk_sign').val(result.sign).prop('disabled',true);
            $('#sdk_proportion').val(result.proportion);
            $('#sdk_optimization').val(result.optimization);
            $('#sdk_syn').val(result.syn);
            $('#sdk_remark').val(result.remark);
            $('#sdk_sdid').val(result.sdid);
            $('#btn_submit_sdk').attr('disabled', false);
            $('#modalSdk').modal('show');
        };
        callAjaxWithFunction(post_url, post_data, success_function, method);
    }

    function validInput()
    {
        var error_num = 0;
        var username = $('#username').val();
        var password  =  $('#password').val();
        if (username == '') {
            error_num = error_num + 1;
            alert('请填写用户名')
        } else if (password == '') {
            error_num = error_num + 1;
            alert('请填写密码');
        }
        return error_num;
    }

</script>