<div class="panel panel-warning">
    <!-- panel heading -->
    <div class="page-header">
        <h1>
            <i class="ace-icon fa fa-angle-double-right"></i>
            融合SDK成果录入
        </h1>
    </div>
    <!-- panel body -->
    <div class="panel-body">
        <div class="row">
                <div class="col-sm-10 col-md-10 col-lg-10">
                    <button class="btn btn-primary" id="btn_add_result">
                        <span class="glyphicon glyphicon-circle-arrow-up"></span>
                        <span>上传文件</span>
                    </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2 text-right">
                </div>
        </div><hr>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <table id="tbl" class="table table-striped table-bordered gclass_table text-center">
                    <thead>
                    <tr>
                        <td>日期</td>
                        <td>内容商</td>
                        <td>应用</td>
                        <td>活动包</td>
                        <td>渠道标识</td>
                        <td>单价</td>
                        <td>成果数</td>
                        <td>M成本</td>
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

<div id="modalResult" class="modal fade" >
    <div class="modal-dialog" >
        <div class="modal-content">
            <form id="formResult" action="#" method="post" enctype="multipart/form-data">
                <div class="modal-body" >
                    <div class="input-group">
                        <span class="input-group-addon">文件:</span>
                        <input type="file" name="result_file" id="result_file"  class="form-control"/>
                    </div><br /><br />
                    请上传csv文件,csv格式如下图:<br/><br/>
                    <1>csv文件第一行必须如图填写<br/>
                    <2>日期活动渠道标识成果数均不能为空,日期请填写日期格式<br/>
                    <3>活动可以填写活动ID或者活动名称,建议填写活动ID<br/>
                    <img src="/imgs/resultcsv.png" alt="csv格式图片"/><br/><br/>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btn_submit_result">预览</button>
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
                'aTargets': [0, 1, 2, 3, 4,5,6,7,8]
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
                "url":'/sdk-promotion-result/ajax-index?' + $.param($('#formSearch').serializeArray()),
                "dataSrc": function(json) {
                    return json.tableData;
                }
            }
        });
    }

    $('#btn_add_result').on('click',function(){
        $('#formResult').trigger("reset");
        $('#modalResult').modal('show');
    });

    $('#formResult').on('submit', (function(event){
        event.preventDefault();

      //  $('#btn_submit_result').attr('disabled', true);
        var post_url = '/sdk-promotion-result/upload-csv';
        var post_data = new FormData(this);
        var method = 'post';
        var successFunc = function (result) {
            if(parseInt(result) == 1){
                _initDataTable();
                $('#modalResult').modal('hide');
            }else if(parseInt(result) == 0){
                alert('预览失败');
            }
        };
        callAjaxWithFormAndFunction(post_url, post_data, method, successFunc);
    }));

    function modifyStatus(sprid){
        if(confirm('确认提交?')) {
            var post_url = '/sdk-promotion-result/modify-status';
            var post_data = {
                'sprid': sprid,
            };
            var method = 'get';
            var success_function = function (result) {
                if(parseInt(result)) {
                    alert('提交成功');
                    _initDataTable();
                }else{
                    alert('提交失败');
                }
            };
            callAjaxWithFunction(post_url, post_data, success_function, method);
        }
    }

    function deleteRecord(sprid){
        if(confirm('确认删除')) {
            var post_url = '/sdk-promotion-result/delete-record';
            var post_data = {
                'sprid': sprid,
            };
            var method = 'get';
            var success_function = function (result) {
                if(parseInt(result)) {
                    alert('删除预览成功');
                    _initDataTable();
                }else{
                    alert('删除预览失败');
                }
            };
            callAjaxWithFunction(post_url, post_data, success_function, method);
        }
    }

</script>