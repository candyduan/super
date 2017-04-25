
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

<div id="modalPorvince" class="modal fade" >
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <span>SDK地域管理</span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form id="formProvince" action="#" method="post" enctype="multipart/form-data">
                <div class="modal-body" >
                    <div class="panel ">
                        <!-- panel heading -->
                        <div class="page-header">
                            <h1>
                                <button class="btn btn-primary small" id="btn_setprovince">一键操作</button>
                            </h1>
                        </div>
                        <!-- panel body -->
                        <div class="panel-body">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <nav class="nav-tabs" role="navigation">
                                    <div>
                                        <ul class="nav nav-tabs" id="tab_type">
                                            <li id="tab_type_1" class="active"><a href="#">移动</a></li>
                                            <li id="tab_type_2"><a href="#">联通</a></li>
                                            <li id="tab_type_3"><a href="#">电信</a></li>
                                            <input type="hidden" id='hidden_tab_type' value = '1'/>
                                        </ul>
                                    </div>
                                </nav><br/>
                                <table id="tblPprovince" class="table table-striped table-bordered gclass_table text-center">
                                    <thead>
                                    <tr>
                                        <td><input type="checkbox" id="all_toids" name="all_toids"/> 全选</td>
                                        <td>省份</td>
                                        <td>状态</td>
                                        <td>时间限制</td>
                                    </tr>
                                    </thead>
                                    <tbody id="bodyProvince"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modalComfirmProvince" class="modal fade" >
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <span><i class="glyphicon glyphicon-globe"></i></span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="inline">
                    <span> 省份屏蔽: </span>
                    <button type="submit" class="btn" id="btn_comfirm_province"> 全省开通</button>
                    <button type="submit" class="btn" id="btn_comfirm_province"> 全省屏蔽</button>
                </div>
                <div class="inline" style="padding-left: 120px">
                    <button type="submit" class="btn btn-danger" id="btn_comfirm_province">更新地域设置</button>
                </div>
            </div>
            <div  style="height:500px">
            </div>
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
    <!-- --------新增和修改sdk---begin----- -->
    $('#btn_add').on('click', function(event){
        event.preventDefault();
        $('#formSdk').trigger("reset"); //window.formSdk.reset();
        $('#sdk_sdid').val('');
        $('#sdk_name').prop('disabled',false);
        $('#sdk_partner').prop('disabled',false);
        $('#btn_submit_sdk').prop('disabled', false);
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
            $('#sdk_partner').val(result.partner).prop('disabled', true);
            $('#sdk_name').val(result.name).prop('disabled',true);
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
    <!-- --------地域设置---begin-------- -->
    function setProvince(sdid, provider){
        $('#modalPorvince').modal('show');
      /*  var post_url = '/sdk/get-sdk-provinces';
        var post_data = {
            'sdid' : sdid,
            'provider' : provider
        };
        var method = 'get';
        var success_function = function(result){
            $('#sdk_partner').val(result.partner).prop('disabled', true);
            $('#sdk_name').val(result.name).prop('disabled',true);
            $('#sdk_proportion').val(result.proportion);
            $('#sdk_optimization').val(result.optimization);
            $('#sdk_syn').val(result.syn);
            $('#sdk_remark').val(result.remark);
            $('#sdk_sdid').val(result.sdid);
            $('#btn_submit_sdk').attr('disabled', false);
            $('#modalProvince').modal('show');
        };
        callAjaxWithFunction(post_url, post_data, success_function, method);*/
    }

    $('#tab_type li').on('click', function(){
        var tab_type = parseInt($(this).attr('id').substr(-1));
        tab_type = isNaN(tab_type) ? 1 : tab_type;
        $('#hidden_tab_type').val(tab_type);
        $('#tab_type li').removeClass('active');
        $('#tab_type_' + tab_type).addClass('active');
        setProvince(sdid, tab_type);
    });

    $('#btn_setprovince').on('click', function(event){
        event.preventDefault();
        $('#modalComfirmProvince').modal('show');
    });

    <!-- --------地域设置----end------- -->
/* ------------------------------------------------------------------------javascript-------------------------------------*/
    $('#all_toids').on('click', function(){
        batchMute(this, 'toid');
    });

    $('input[name="toid"]').on('click', function(){
        closeBatch(this, 'all_toids');
    });

</script>