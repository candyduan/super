
<div class="panel panel-warning">
    <!-- panel heading -->
    <ol class="breadcrumb">
        <li class="active">客户账户管理</li>
    </ol>
    <!-- panel body -->
    <div class="panel-body main">
        <div class="row">
            <form action="" method="get" id="formSearch" class="form-inline">
                <div class="col-sm-10 col-md-10 col-lg-10">
                    <input type="text" class="form-control" id="searchStr" name="searchStr" placeholder="内容商用户名邮箱:模糊"/>
                    <select class="form-control" id="utype" name="utype">
                        <option value="-1">全部</option>
                        <option value="0">未确定</option>
                        <option value="1">内容供应</option>
                        <option value="2">内容推广</option>
                        <option value="3">综合</option>
                    </select>
                    <button class="btn btn-primary" type="submit" id="btn_search">
                        <span class="glyphicon glyphicon-search"></span>
                        <span>搜索</span>
                    </button>
                    <button class="btn btn-success" id="btn_add">
                        <span class="glyphicon glyphicon-plus"></span>
                        <span>新增客户账户</span>
                    </button>&nbsp;
                </div>
            </form>
        </div><hr>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <table id="tbl" class="table table-striped table-bordered gclass_table text-center">
                    <thead>
                    <tr>
                        <td>用户名</td>
                        <td>邮箱</td>
                        <td>关联内容商</td>
                        <td>合作模式</td>
                        <td>负责人</td>
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

<div id="modalOutUser" class="modal fade" >
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <span>新增客户账户:</span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
            <form id="formOutUser" action="#" method="post" enctype="multipart/form-data">
                <div class="modal-body" >
                    <div class="input-group">
                        <span class="input-group-addon"> 用户名  <span class="red">*</span> :</span>
                        <input placeholder ='必填' type="text" name="username" id="username" class="form-control" width="1000px"/>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon"> 密码  <span class="red">*</span>:</span>
                        <input  placeholder ='新增账户时必填' type="text" name="password" id="password" class="form-control"/>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon"> 邮箱 <span class="red">*</span>:</span>
                        <input   placeholder ='必填' type="text" name="email" id="email" class="form-control"/>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon"> 关联内容商 <span class="red">*</span>:</span>
                        <input   placeholder ='查询' type="text" name="search" id="search" class="form-control"/>
                        <select   placeholder ='必填' type="text" name="partner" id="partner" class="form-control"></select>
                    </div><br /><br />
                    <input type="hidden" value="" name="ouid" id="ouid"/>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btn_submit_outuser">提交</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
                </div>
            </form>
            </div>
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

    $('#btn_search').on('click', function(event){
        event.preventDefault();
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
                'aTargets': [0, 1, 2,3,4,5]
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
                "url":'/out-user/ajax-index?' + $.param($('#formSearch').serializeArray()),
                "dataSrc": function(json) {
                    return json.tableData;
                }
            }
        });
    }

    $('#btn_add').on('click', function(event){
        event.preventDefault();
        var data = {};
        var url = '/out-user/get-all-partners';
        var successFunc = function (result){
            $('#ouid').val('');
            $('#formOutUser').trigger("reset");
            $('#username').prop('disabled',false);
            if(result !== []){
                var option = '';
                $.each(result,function(k,v){
                    option += "<option value='"+k+"'>"+v+"</option>"
                });
                $('#partner').empty().append(option);
            }
            $('#modalOutUser').modal('show');
        };
        var method = 'get';
        callAjaxWithFunction(url,data,successFunc,method);
    });

    $('#search').on('keyup',function(event){

        var name = $('#search').val();
        event.preventDefault();
        var data = {
            'name' : name
        };
        var url = '/out-user/get-partner';
        var successFunc = function (result){
            var option = '';
            $.each(result, function (k, v) {
                option += "<option value='"+k+"'>" + v + "</option>"
            });

            if(option == ''){
                option = "<option value='0'>未搜到相关内容商</option>"
            }
            $('#partner').empty().append(option);
            $('#modalOutUser').modal('show');
        };
        var method = 'get';
        callAjaxWithFunction(url,data,successFunc,method);

    });

    $('#formOutUser').on('submit', (function(event){
        event.preventDefault();
        var ouid = $('#ouid').val();
        var type = (ouid == '') ? 'add' : 'modify';
        var error_num = validInput(type);
        if(error_num == 0) {
            $('#btn_submit_outuser').attr('disabled', true);
            var post_url = '/out-user/'+type+'-user';
            var post_data = new FormData(this);
            var msg_success = (ouid == '') ? MESSAGE_ADD_SUCCESS : MESSAGE_MODIFY_SUCCESS;
            var msg_error = (ouid == '') ? MESSAGE_ADD_ERROR : MESSAGE_MODIFY_ERROR;
            var method = 'post';
            var successFunc = function (result) {
                if (parseInt(result) == 1) {
                    alert(msg_success);
                    $('#modalOutUser').modal('hide');
                    _initDataTable();
                } else if (parseInt(result) == 0) {
                    alert( msg_error);
                } else if (parseInt(result) == -1) {
                    alert('失败！用户名或者邮箱已经存在');
                }
                $('#btn_submit_outuser').attr('disabled', false);
            };
            callAjaxWithFormAndFunction(post_url, post_data, method, successFunc);
        }
    }));

    function modifyOutUser(ouid){
        var post_url = '/out-user/get-user';
        var post_data = {
            'ouid' : ouid
        };
        var method = 'get';
        var success_function = function(result){
            $('#username').val(result.user.username).prop('disabled', true);
            $('#password').val('');
            $('#email').val(result.user.email);
            if(result.partners != []){
                var option = '';
                $.each(result.partners,function(k,v){
                    option += "<option value='"+k+"'>"+v+"</option>"
                });
                $('#partner').empty().append(option);
            }
            $('#partner').val(result.user.partner);
            $('#ouid').val(ouid);
            $('#btn_submit_outuser').attr('disabled', false);
            $('#modalOutUser').modal('show');
        };
        callAjaxWithFunction(post_url, post_data, success_function, method);
    }

    function deleteOutUser(ouid){
        if(confirm('确认删除该用户?')) {
            var post_url = '/out-user/delete-out-user';
            var post_data = {
                'ouid' : ouid
            };
            var method = 'get';
            var success_function = function(result) {
                if(parseInt(result) > 0){
                    alert(MESSAGE_DELETE_SUCCESS);
                    _initDataTable();
                }else{
                    alert(MESSAGE_DELETE_ERROR);
                }
            };
            callAjaxWithFunction(post_url, post_data, success_function, method);
        }
    }

    function validInput(type)
    {
        var error_num = 0;
        var username = $('#username').val();
        var password  =  $('#password').val();
        var email  =  $('#email').val();
        var partner = $('#partner').val();
        if (username == '' && type == 'add') {
            error_num = error_num + 1;
            alert('请填写用户名')
        } else if (password == '' && type=='add') {
            error_num = error_num + 1;
            alert('请填写密码');
        }  else if (email == '') {
            error_num = error_num + 1;
            alert('请填写邮箱');
        } else if (partner == 0) {
            error_num = error_num + 1;
            alert('请选择内容商');
        }
        return error_num;
    }

</script>