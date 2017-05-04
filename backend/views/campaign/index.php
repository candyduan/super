<div class="panel panel-warning">
    <!-- panel heading -->
    <div class="page-header">
        <h1>
            <i class="ace-icon fa fa-angle-double-right"></i>
            活动管理
        </h1>
    </div>
    <!-- panel body -->
    <div class="panel-body">
        <div class="row">
            <form action="" method="get" id="formSearch" class="form-inline">
                <div class="col-sm-10 col-md-10 col-lg-10">
                    <input type="text"  class="form-control" id='id' name ='id' value="<?php echo $id?>"  placeholder="应用id"/>
                    <button class="btn btn-primary" type="submit" id="btn_search">
                        <span class="glyphicon glyphicon-search"></span>
                        <span>搜索</span>
                    </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                        <td>活动名</td>
                        <td>状态</td>
                        <td>级别</td>
                        <td>AG-R</td>
                        <td>AG-优</td>
                        <td>CP-R</td>
                        <td>CP-优</td>
                        <td>M分成</td>
                        <td>sign</td>
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

<div id="modalCampaign" class="modal fade" >
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <span>活动详情:</span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form id="formCampaign" action="#" method="post" enctype="multipart/form-data">
                <div class="modal-body" >
                    <div class="input-group">
                        <span class="input-group-addon">内容商:</span>
                        <input type="text" id="campaign_partner" readonly placeholder="内容商" class="form-control"/>
                        <span class="input-group-addon">cp分成比例:</span>
                        <input type="text" id="campaign_rate" readonly placeholder="cp分成比例" class="form-control"/>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon">应用:</span>
                        <input type="text" id="campaign_app" readonly placeholder="应用" class="form-control"/>
                        <span class="input-group-addon">cp优化比例:</span>
                        <input type="text" id="campaign_cutrate" readonly placeholder="cp优化比例" class="form-control"/>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon">状态:</span>
                        <input type="text"  id="campaign_status" readonly placeholder="状态" class="form-control"/>
                        <span class="input-group-addon">cp优化开始:</span>
                        <input type="text" id="campaign_cutday" readonly placeholder="cp优化开始" class="form-control"/>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon">活动名:</span>
                        <input type="text"  id="campaign_name" readonly placeholder="活动名" class="form-control" />
                        <span class="input-group-addon">渠道分成比例:</span>
                        <input type="text" id="campaign_mrate" placeholder="渠道分成比例" readonly class="form-control" />
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon">活动类型:</span>
                        <input type="text"  id="campaign_type" readonly placeholder="活动类型" class="form-control"/>
                        <span class="input-group-addon">级别:</span>
                        <input type="text" id="campaign_grade" readonly placeholder="级别" class="form-control"/>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon">时间范围:</span>
                        <input type="text"  id="campaign_startdate" readonly placeholder="开始时间" class="form-control"/>
                        <span class="input-group-addon"> ~</span>
                        <input type="text"  id="campaign_enddate" readonly placeholder="结束时间" class="form-control"/>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon">计费模式:</span>
                        <select   id="campaign_paymode"  placeholder="计费模式" class="form-control">
                            <option value='0'>Normal</option>
                            <option value='1'>Hard</option>
                            </select>
                        <span class="input-group-addon"> 同步地址:</span>
                        <input type="text"  id="campaign_syncurl" readonly placeholder="同步地址" class="form-control"/>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon">备注:</span>
                        <textarea type="text" cols="20" rows="10"  readonly id="campaign_memo" placeholder="备注" class="form-control"></textarea>
                    </div><br /><br />
                    <input type="hidden" id ='hidden_caid' value="0">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btn_submit_campaign">提交</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modalSdks" class="modal fade" >
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <span id="campaign_title"></span>
                <button  id='btn_add_sdk'  class="btn btn-md">新增关联SDK</button >
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form id="formSdks" action="#" method="post" enctype="multipart/form-data">
                <div class="modal-body" >
                    <div class="panel ">
                        <div class="panel-body">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <table id="tblNameTable" class="table table-striped table-bordered gclass_table text-center">
                                    <thead>
                                    <tr>
                                        <td>名称</td>
                                        <td>APPID</td>
                                        <td>管理</td>
                                    </tr>
                                    </thead>
                                    <tbody id="bodySdks"></tbody>
                                    <input type="hidden" id="hidden_caid" value="0"/>
                                </table>
                            </div>
                        </div>
                        <div class="panel-footer">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modalGoods" class="modal fade" >
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <span id="campaign_title_2"></span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form id="formGoods" action="#" method="post" enctype="multipart/form-data">
                <div class="modal-body" >
                    <div class="panel ">
                        <div class="panel-body">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <table id="tblGoods" class="table table-striped table-bordered gclass_table text-center">
                                    <thead>
                                    <tr>
                                        <td>SDK</td>
                                        <td colspan="2">APPID</td>
                                        <td>管理</td>
                                    </tr>
                                    <tr id="headGoods">
                                        <td><select id='sdk_select'>

                                            </select></td>
                                        <td colspan="2"><input type="text" class="form-control" id="sdk_appid"></input></td>
                                        <td><i id="sdk_icon" class="glyphicon-ok-sign glyphicon grey"><i></td>
                                    </tr>
                                    <tr>
                                        <td>名称</td>
                                        <td>价格</td>
                                        <td>计费点</td>
                                        <td>管理</td>
                                    </tr>
                                    </thead>
                                    <tbody id="bodyGoods"></tbody>
                                    <input type="hidden" id="hidden_sdid" value="0"/>
                                </table>
                            </div>
                        </div>
                        <div class="panel-footer">
                        </div>
                    </div>
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
                "url":'/campaign/ajax-index?' + $.param($('#formSearch').serializeArray()),
                "dataSrc": function(json) {
                    return json.tableData;
                }
            }
        });
    }

    function showCampaign(caid){
        var post_url = '/campaign/get-campaign';
        var post_data = {
            'caid' : caid
        };
        var method = 'get';
        var success_function = function(result){
            $('#campaign_app').val(result.appname);
            $('#campaign_name').val(result.name);
            $('#campaign_partner').val(result.partnername);
            $('#campaign_mrate').val(result.mrate);
            $('#campaign_status').val(result.status);
            $('#campaign_paymode').val(result.payMode);
            $('#campaign_memo').val(result.memo);
            $('#campaign_rate').val(result.rate);
            $('#campaign_type').val(result.type);
            $('#campaign_grade').val(result.grade);
            $('#campaign_cutday').val(result.cutday);
            $('#campaign_startdate').val(result.startdate);
            $('#campaign_enddate').val(result.enddate);
            $('#campaign_cutrate').val(result.cutrate);
            $('#campaign_syncurl').val(result.syncAddr);
            $('#hidden_caid').val(caid);
            $('#btn_submit_campaign').prop('disabled',false);
            $('#modalCampaign').modal('show');
        };
        callAjaxWithFunction(post_url, post_data, success_function, method);
    }

    $('#btn_submit_campaign').on('click',function(event){
        $('#btn_submit_campaign').prop('disabled',true);
        event.preventDefault();
        var data = {
            'caid' : $('#hidden_caid').val(),
            'paymode' : $('#campaign_paymode').val()
        }
        var method = 'get';
        var url = '/campaign/modify-paymode';
        var success_function = function(result){
            if(parseInt(result) > 0){
                alert(MESSAGE_MODIFY_SUCCESS);
            }else{
                alert(MESSAGE_ADD_ERROR);
            }
            $('#modalCampaign').modal('hide');
        }

        callAjaxWithFunction(url,data,success_function,method);
    });

    function getSdks(caid){
        var post_url = '/campaign/get-sdks';
        var post_data = {
            'caid' : caid,
        };
        var method = 'get';
        var success_function = function(result){
            var content_str = '';
            for(var i in result) {
                var content_arr = [];
                content_arr.push("<tr><td>"+result[i].name+"</td>");
                content_arr.push("<td>"+result[i].appid+"</td>");
                content_arr.push("<td>"+result[i].status+"</td>");
                content_str  += content_arr.join(' ');
            }
            $('#campaign_title').empty().text('活动名称：'+result[0].campaignname);
            $('#hidden_caid').val(caid);
            $('#bodySdks').empty().append(content_str);
            $('#modalSdks').modal('show');
        };
        callAjaxWithFunction(post_url, post_data, success_function, method);
    }

    function changeStatus(sdid,status){
        var post_url = '/campaign/modify-status';
        var caid = $('#hidden_caid').val();
        var post_data = {
            'sdid' : sdid,
            'caid' : caid,
            'status' : status
        };
        var method = 'get';
        var success_function = function(result){
            getSdks(caid);
        };
        callAjaxWithFunction(post_url, post_data, success_function, method);
    }

    function showDetail(sdid){
        var post_url = '/campaign/get-detail';
        var post_data = {
            'caid' : $('#hidden_caid').val(),
            'sdid'  : sdid
        };
        var method = 'get';
        var success_function = function(result){
            var content_str = '';
            for(var i in result) {
                var content_arr = [];
                content_arr.push("<tr><td>"+result[i].name+"</td>");
                content_arr.push("<td>"+result[i].appid+"</td>");
                content_arr.push("<td>"+result[i].status+"</td>");
                content_str  += content_arr.join(' ');
            }
            $('#campaign_title').empty().text('活动名称：'+result[0].campaignname);
            $('#hidden_caid').val(caid);
            $('#bodySdks').empty().append(content_str);
            $('#modalSdks').modal('show');
        };
        callAjaxWithFunction(post_url, post_data, success_function, method);
    }

    $('#btn_add_sdk').on('click',function(event){
        event.preventDefault();
        var post_url = '/campaign/get-all-sdks';
        var post_data = {
            'caid' : $('#hidden_caid').val()
        };
        var method = 'get';
        var success_function = function(result){
            if(result.sdks !== ''){
                $('#sdk_select').empty().append(result.sdks);
            }
            if(result.goods !==''){
                $('#bodyGoods').empty().append(result.goods);
            }
            feeKeyUp();
            $('#modalGoods').modal('show');
        };
        callAjaxWithFunction(post_url, post_data, success_function, method);
    })
/*
    $('#sdk_icon').on('click',function(){
        if($(this).hasClass('green')) {
            var sdk = $('#sdk_select').val();
            var appid = $('#sdk_appid').val();
            var post_url = '/campaign/get-all-sdks';
            var post_data = {
                'caid' : $('#hidden_caid').val()
            };
            var method = 'get';
            var success_function = function(result){

             }
    });*/

    $('#sdk_appid').on('keyup',function(){
        if($(this).val() !== ''){
            $('#sdk_icon').removeClass('grey').addClass('green');
        }else{
            $('#sdk_icon').removeClass('green').addClass('grey');
        }
    })

    function feeKeyUp() {
        $('input[name="fee"]').on('keyup', function () {
            if($(this).val() !== ''){
                $(this).parent().next().children('i').removeClass('grey').addClass('green');
            }else{
                alert('grey');
            }
        })
    }


</script>