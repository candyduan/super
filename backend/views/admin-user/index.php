
<div class="panel panel-warning">
    <!-- panel heading -->
            <ol class="breadcrumb">
        <li class="active">内部账户管理</li>
        </ol>
    <!-- panel body -->
    <div class="panel-body main">
        <div class="row">
            <form action="" method="get" id="formSearch" class="form-inline">
                <div class="col-sm-10 col-md-10 col-lg-10">&nbsp;&nbsp;
                    <button class="btn btn-primary" id="btn_add">
                        <span class="glyphicon glyphicon-plus"></span>
                        <span>新增内部账户</span>
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
                <span>新增内部账户:</span>
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
                        <span class="input-group-addon"> 邮箱 <span class="red">*</span>:</span>
                        <input   placeholder ='必填' type="text" name="email" id="email" class="form-control"/>
                    </div><br /><br />
                    <span class="input-group-addon"> 权限:</span>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="sdk" id="sdk" >融合sdk后台
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="register" id="register">主动上行后台
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"  name="agency" id="agency"> 注册中介后台
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"  name="pay" id="pay"> 支付SDK后台
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"  name="admin-user" id="admin-user"> 系统管理(用户管理)
                        </label>
                    </div>
                    <br /><br />
                    <input type="hidden" value="" name="auid" id="auid"/>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btn_submit_adminuser">提交</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ------------------------------------------------------------------------javascript---------------------------------------------------------------------->
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
        $('#username').prop('disabled',false);
        $('#password').prop('disabled',false);
        $('#formAdminUser').trigger("reset");
        $('#modalAdminUser').modal('show');
    });

    $('#formAdminUser').on('submit', (function(event){
        event.preventDefault();
        var auid = $('#auid').val();
        var error_num = auid == '' ? validInput() : 0;
        if(error_num == 0) {
            var type = (auid == '') ? 'add' : 'modify';
            $('#btn_submit_adminuser').attr('disabled', true);
            var post_url = '/admin-user/'+type+'-user';
            var post_data = new FormData(this);
            var msg_success = (auid == '') ? MESSAGE_ADD_SUCCESS : MESSAGE_MODIFY_SUCCESS;
            var msg_error = (auid == '') ? MESSAGE_ADD_ERROR : MESSAGE_MODIFY_ERROR;
            var method = 'post';
            var successFunc = function (result) {
                if (parseInt(result) == 1) {
                    Utils.tipBar('success','成功',msg_success);
                    $('#modalAdminUser').modal('hide');
                    _initDataTable();
                } else if (parseInt(result) == 0) {
                    Utils.tipBar('error','失败',msg_error);  
                } else if (parseInt(result) == -1) {
                    Utils.tipBar('error','失败','新增失败！用户名或者邮箱已经存在');  
                }
                $('#btn_submit_adminuser').attr('disabled', false);
            };
            callAjaxWithFormAndFunction(post_url, post_data, method, successFunc);
        }
    }));

    function modifyPowers(auid){
        var post_url = '/admin-user/get-user-powers';
        var post_data = {
            'auid' : auid
        };
        var method = 'get';
        var success_function = function(result){
            $('#username').val(result.user.username).prop('disabled', true);
            $('#password').val('').prop('disabled',true);
            $('#email').val(result.user.email);
            if(result.powers !== []){
                $("input[type='checkbox']").prop('checked',false);
                for(var i in result.powers) {
                    $('#'+result.powers[i]).prop('checked',true);
                }
            }
            $('#auid').val(auid);
            $('#btn_submit_adminuser').attr('disabled', false);
            $('#modalAdminUser').modal('show');
        };
        callAjaxWithFunction(post_url, post_data, success_function, method);
    }

    function deleteAdminUser(auid){
        if(confirm('确认删除该用户?')) {
            var post_url = '/admin-user/delete-admin-user';
            var post_data = {
                'auid' : auid
            };
            var method = 'get';
            var success_function = function(result) {
                if(parseInt(result) > 0){
                    Utils.tipBar('success','成功',MESSAGE_DELETE_SUCCESS);    
                    _initDataTable();
                }else{
                    Utils.tipBar('error','失败',MESSAGE_DELETE_ERROR);    
                }
            };
            callAjaxWithFunction(post_url, post_data, success_function, method);
        }
    }

    function validInput()
    {
        var error_num = 0;
        var username = $('#username').val();
        var password  =  $('#password').val();
        var email  =  $('#email').val();
        if (username == '') {
            error_num = error_num + 1;
            Utils.tipBar('error','失败','请填写用户名');    
        } else if (password == '') {
            error_num = error_num + 1;
            Utils.tipBar('error','失败','请填写密码');    
        } else if (email == '') {
            error_num = error_num + 1;
            Utils.tipBar('error','失败','请填写邮箱');            
        }
        return error_num;
    }

</script>