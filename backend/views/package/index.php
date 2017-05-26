<link rel="stylesheet" href="/ace/assets/css/bootstrap-datepicker3.min.css" />
<div class="panel panel-warning">
    <!-- panel heading -->
        <ol class="breadcrumb">
        <li class="active"><i class="fa fa-dashboard"></i>活动包管理</li>
        </ol>
    <!-- panel body -->
    <div class="panel-body main">
        <div class="row">
        	<form action="" method="get" id="formSearch" class="form-inline">
                <div class="col-sm-10 col-md-10 col-lg-10">
                    <input type="text"  class="form-control modal fade" id='id' name ='id' value="<?php echo $id?>"  placeholder="活动id"/>
                    <span id ='partnerName' class="btn-primary"></span> > <span id = 'appName'  class="btn-primary"></span> > <span id = 'campaignName'  class="btn-primary"></span>
                </div>
            </form>
        </div><hr>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <table id="tbl" class="table table-striped table-bordered gclass_table text-center">
                    <thead>
                    <tr>
                        <td>ID</td>
                        <td>渠道</td>
                        <td>渠道标识</td>
                        <td>状态</td>
                        <td>级别</td>
                        <td>计费模式</td>
                        <td>CP分成</td>
                        <td>渠道方式</td>
                        <td>渠道分成</td>
                        <td>CP-R</td>
                        <td>CP-M</td>
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

<div id="modalPackage" class="modal fade" >
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <span>活动包详情:</span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form id="formCampaign" action="#" method="post" enctype="multipart/form-data">
                <div class="modal-body" >
                    <div class="input-group">
                        <span class="input-group-addon">应用名:</span>
                        <input type="text" id="package_campaign_app" readonly placeholder="应用" class="form-control"/>
                        <span class="input-group-addon">cp分成比例:</span>
                        <input type="text" id="package_rate" readonly placeholder="cp分成比例" class="form-control"/>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon">包名:</span>
                        <input type="text" id="package_name" readonly placeholder="包名" class="form-control"/>
                        <span class="input-group-addon">cp优化比例:</span>
                        <input type="text" id="package_cutrate"  placeholder="cp优化比例" class="form-control"/>
                        <span class="input-group-addon">%</span>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon">版本号:</span>
                        <input type="text"  id="package_version_code" readonly placeholder="版本号" class="form-control" />
                        <span class="input-group-addon">cp优化开始:</span>
                        <input type="text" id="package_cutday"  placeholder="cp优化开始"  class="form-control date-picker" data-date-format="yyyy-mm-dd"/>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon">版本名:</span>
                        <input type="text"  id="package_version_name" readonly placeholder="版本名" class="form-control" />
                        <span class="input-group-addon">渠道优化比例:</span>
                        <input type="text" id="package_mcutrate"  placeholder="填写1-100的整数" class="form-control"/>
                        <span class="input-group-addon">%</span>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon">推广分成方式:</span>
                        <input type="text" id="package_push_mode" readonly placeholder="推广分成方式" class="form-control"/>
                        <span class="input-group-addon">渠道优化开始:</span>
                        <input type="text" id="package_mcutday"  placeholder="渠道优化开始"  class="form-control date-picker" data-date-format="yyyy-mm-dd"/>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon">大小:</span>
                        <input type="text" id="package_size" readonly placeholder="包大小" class="form-control"/>
                        <span class="input-group-addon">推广分成比例:</span>
                        <input type="text" id="package_push_rate" readonly placeholder="推广分成比例" class="form-control"/>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon">渠道标识:</span>
                        <input type="text"  id="package_sign" readonly placeholder="渠道标识" class="form-control" />
                        <span class="input-group-addon">设置渠道:</span>
                        <input type="text" id="set_package_dist" readonly placeholder="设置渠道" class="form-control"/>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon">级别:</span>
                        <input type="text" id="package_level" readonly placeholder="级别" class="form-control"/>
                        <span class="input-group-addon">计费模式:</span>
                        <select   id="package_paymode"  placeholder="计费模式" class="form-control">
                            <option value='0'>Normal</option>
                            <option value='1'>Hard</option>
                        </select>
                    </div><br /><br />
                    <input type="hidden" id ='hidden_cpid' value="0">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btn_submit_package">提交</button>
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
                <span>渠道关联配置</span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="panel-body">
            	 <span class="input-group-addon" id="package_mediaSign" >渠道标识:</span>
            </div>
            <form id="formSdks" action="#" method="post" enctype="multipart/form-data">
                <div class="modal-body" >
                    <div class="panel ">
                        <div class="panel-body">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <table id="tblNameTable" class="table table-striped table-bordered gclass_table text-center">
                                    <thead>
                                    <tr>
                                        <td>SDK</td>
                                        <td>关联渠道号</td>
                                        <td>管理</td>
                                    </tr>
                                    </thead>
                                    <tbody id="bodySdks"></tbody>
                                    <input type="hidden" id="hidden_cpid" value="0"/>
                                </table>
                            </div>
                        </div>
<!--                         <div class="panel-footer"> -->
<!--                         </div> -->
                    </div>
                </div>
<!--                 <div class="modal-footer"> -->
<!--                     <button type="submit" class="btn btn-success" id="btn_submit_sign">提交</button> -->
<!--                     <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button> -->
<!--                 </div> -->
            </form>
        </div>
    </div>
</div>

<!-- ------------------------------------------------------------------------javascript---------------------------------------------------------------------->
<script src="/ace/assets/js/bootstrap-datepicker.min.js"></script>
<script src="/js/common/bootstrap3-typeahead.min.js"></script>
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
            "bAutoWidth": false,
            "scrollX": true,
            //"order": [[ 5, "desc" ]],
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0, 1, 2, 3, 4,5,6,7,8,9,10,11]
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
                "url":'/package/ajax-index?' + $.param($('#formSearch').serializeArray()),
                "dataSrc": function(json) {
                    $('#partnerName').empty().text(json.partnerName);
                    $('#appName').empty().text(json.appName);
                    $('#campaignName').empty().text(json.campaignName);
                    return json.tableData;
                }
            }
        });
    }

    function showPackage(cpid){
        var post_url = '/package/get-package';
        var post_data = {
            'cpid' : cpid
        };
        var method = 'get';
        var success_function = function(result){
            $('#package_campaign_app').val(result.appname);
            $('#package_name').val(result.packagename);
            $('#package_version_code').val(result.versioncode);
            $('#package_version_name').val(result.versionname);
            $('#package_size').val(result.size);
            $('#package_rate').val(result.rate);
            $('#package_cutrate').val(result.cutrate);
            $('#package_cutday').val(result.cutday);
            $('#package_mcutrate').val(result.mcutrate);
            $('#package_mcutday').val(result.mcutday);
            $('#package_push_mode').val(result.mtype);
            $('#package_push_rate').val(result.mrate);
            $('#package_sign').val(result.sign);
            $('#set_package_dist').val(result.distname);
            $('#package_level').val(result.grade);
            $('#package_paymode').val(result.paymode);
            $('#hidden_cpid').val(cpid);
            $('#btn_submit_package').prop('disabled',false);
            $('#modalPackage').modal('show');
        };
        callAjaxWithFunction(post_url, post_data, success_function, method);
    }

    $('#btn_submit_package').on('click',function(event){
        event.preventDefault();
        var error_num = validInput();
        if(error_num == 0) {
            $('#btn_submit_package').prop('disabled',true);
            var data = {
                'cpid': $('#hidden_cpid').val(),
                'paymode': $('#package_paymode').val(),
                'cutrate': $('#package_cutrate').val(),
                'cutday': $('#package_cutday').val(),
                'mcutrate': $('#package_mcutrate').val(),
                'mcutday': $('#package_mcutday').val(),

            }
            var method = 'get';
            var url = '/package/modify-paymode';
            var success_function = function (result) {
                if (parseInt(result) > 0) {
                    alert(MESSAGE_MODIFY_SUCCESS);
                } else {
                    alert(MESSAGE_ADD_ERROR);
                }
                _initDataTable();
                $('#modalPackage').modal('hide');
            }
            callAjaxWithFunction(url, data, success_function, method);
        }
    });

    function getSdks(cpid){
        var post_url = '/package/get-sdks';
        var post_data = {
            'cpid' : cpid,
        };
        var method = 'get';
        var success_function = function(result){
            var content_str = '';
            var data = result.data;
            for(var i in data) {
                var content_arr = [];
                content_arr.push("<tr><td>"+data[i].name+"</td>");
                content_arr.push("<td>" + data[i].sign+ "</td>");
                content_arr.push("<td>"+data[i].status+"</td>");
                content_str  += content_arr.join(' ');
            }
            $('#package_mediaSign').empty().text('渠道标识：'+result.mediaSign);
            $('#hidden_cpid').val(cpid);
            $('#bodySdks').empty().append(content_str);
            $('#modalSdks').modal('show');
        };
        callAjaxWithFunction(post_url, post_data, success_function, method);
    }

    function changeStatus(sdid,status){
    	var post_url = '/package/modify-status';
        var cpid = $('#hidden_cpid').val();
        var post_data = {
            'sdid' : sdid,
            'cpid' : cpid,
            'status' : status
        };
        var method = 'get';
        var success_function = function(result){
            getSdks(cpid);
            alert(MESSAGE_MODIFY_SUCCESS);
        };
        callAjaxWithFunction(post_url, post_data, success_function, method);
    }
    function changeSaveBtn(sdid){
        var newSign = $.trim($('#input_sdk_sign_' + sdid).val());
        var sign = $.trim($('#input_sdk_sign_' + sdid).prop('title'));
        if(newSign != sign){
        	$('#btn_sdk_sign_' + sdid).removeClass('grey').addClass('green');
        }else{
        	$('#btn_sdk_sign_' + sdid).removeClass('green').addClass('grey');
        }
    }
    function changeSign(cpid,sdid){
    	if($('#btn_sdk_sign_' + sdid).hasClass('grey')){
        	return;
    	}
   	 	var sign = $('#input_sdk_sign_' + sdid).val();
    	var post_url = '/package/modify-sign';
        var cpid = $('#hidden_cpid').val();
        var post_data = {
            'sdid' : sdid,
            'cpid' : cpid,
            'sign' : sign
        };
        var method = 'get';
        var success_function = function(result){
            getSdks(cpid);
            alert(MESSAGE_MODIFY_SUCCESS);
        };
        callAjaxWithFunction(post_url, post_data, success_function, method);
    }

    function validInput(){
   var  error_num = 0;
        /*         var  cutrate = $('#package_cutrate').val();
        var  cutday = $('#package_cutday').val();
        var  mcutrate = $('#package_mcutrate').val();
        var  mcutday = $('#package_mcutday').val();
        if(!isPositiveInt(cutrate) || !isPositiveInt(mcutrate) || cutrate > 100 || cutrate < 0  || mcutrate > 100 || mcutrate < 0){
            alert(MESSAGE_PERCENT_ERROR);
            error_num += 1;
        } *//*else if(cutday == '' || mcutday == ''){
         alert(MESSAGE_DATE_ERROR);
         error_num += 1;
         }*/

        return error_num;
    }
</script>