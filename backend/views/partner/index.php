<div class="panel panel-warning">
    <!-- panel heading -->
       <ol class="breadcrumb">
        <li class="active">内容商管理</li>
        </ol>
    <!-- panel body -->
    <div class="panel-body main">
        <div class="row">
            <form action="" method="get" id="formSearch" class="form-inline">
                <div class="col-sm-10 col-md-10 col-lg-10">
                    <input type="text" class="form-control" id="name" name="name" placeholder="内容商名称:模糊搜索"/>
                    <select class="form-control" id="utype" name="utype">
                        <option value="-1">全部</option>
                        <option value="0">未确定</option>
                        <option value="1">内容供应</option>
                        <option value="2">内容推广</option>
                        <option value="3">综合</option>
                    </select>
                    <select class="form-control" id="holder" name="holder">
                        <option value="0">选择负责人</option>
                        <?php foreach($holders as $key => $value){
                            echo "<option value='$key'> $value</option>";
                        }?>
                    </select>
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
                        <td>内容商</td>
                        <td>合作模式</td>
                        <td>业务归属</td>
                        <td>负责人</td>
                        <td>结算周期</td>
                        <td>查看产品</td>
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

<div id="modalPartner" class="modal fade" >
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <span>内容商信息:</span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form id="formPartner" action="#" method="post" enctype="multipart/form-data">
                <div class="modal-body" >
                    <div class="input-group">
                        <span class="input-group-addon">客户类型:</span>
                        <input type="text" name="partner_paytype" id="partner_paytype" readonly placeholder="客户类型" class="form-control"/>
                        <span class="input-group-addon">开户银行:</span>
                        <input type="text" name="partner_bank" id="partner_bank" readonly placeholder="开户银行" class="form-control"/>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon">负责人:</span>
                        <input type="text" name="partner_holder" id="partner_holder" readonly placeholder="负责人" class="form-control"/>
                        <span class="input-group-addon">分行地址:</span>
                        <input type="text" name="partner_subbank" id="partner_subbank" readonly placeholder="分行地址" class="form-control"/>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon">客户邮箱:</span>
                        <input type="text" name="partner_email" id="partner_email" readonly placeholder="客户邮箱" class="form-control"/>
                        <span class="input-group-addon">银行账号:</span>
                        <input type="text" name="partner_account" id="partner_account" readonly placeholder="银行账号" class="form-control"/>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon">初始密码:</span>
                        <input type="text" name="partner_pwd" id="partner_pwd" readonly placeholder="初始密码" class="form-control" />
                        <span class="input-group-addon">开户名:</span>
                        <input type="text" name="partner_accountname" id="partner_accountname" placeholder="开户名" readonly class="form-control" />
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon">客户名称:</span>
                        <input type="text" name="partner_name" id="partner_name" readonly placeholder="客户名称" class="form-control"/>
                        <span class="input-group-addon">结算周期:</span>
                        <input type="text" name="partner_paycircle" id="partner_paycircle" readonly placeholder="结算周期" class="form-control" />
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon">合作模式:</span>
                        <input type="text" name="partner_utype" id="partner_utype" readonly placeholder="合作模式" class="form-control"/>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon">批量同步:</span>
                        <input type="text" name="partner_needsync" id="partner_needsync" readonly placeholder="批量同步" class="form-control"/>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon">同步地址:</span>
                        <input type="text" name="partner_synurl" id="partner_syncurl" readonly placeholder="同步地址" class="form-control"/>
                    </div><br /><br />
                    <div class="input-group">
                        <span class="input-group-addon">备注:</span>
                        <textarea type="text" cols="20" rows="10" name="partner_memo" readonly id="partner_memo" placeholder="备注" class="form-control"></textarea>
                    </div><br /><br />
                </div>
                <div class="modal-footer">
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
            "bAutoWidth": false,
            "scrollX": true,
            //"order": [[ 5, "desc" ]],
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0, 1, 2, 3, 4,5]
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
                "url":'/partner/ajax-index?' + $.param($('#formSearch').serializeArray()),
                "dataSrc": function(json) {
                    return json.tableData;
                }
            }
        });
    }

    function showPartner(id){
        var post_url = '/partner/get-partner';
        var post_data = {
            'id' : id
        };
        var method = 'get';
        var success_function = function(result){
            $('#partner_paytype').val(result.payType);
            $('#partner_utype').val(result.utype);
            $('#partner_bank').val(result.bank);
            $('#partner_subbank').val(result.subBank);
            $('#partner_holder').val(result.holder);
            $('#partner_email').val(result.email);
            $('#partner_accountname').val(result.accountName);
            $('#partner_account').val(result.account);
            $('#partner_name').val(result.name);
            $('#partner_paycircle').val(result.payCircle);
            $('#partner_utype').val(result.uType);
            $('#partner_needsync').val(result.needSync);
            $('#partner_syncurl').val(result.syncUrl);
            $('#partner_memo').val(result.memo);
            $('#modalPartner').modal('show');
        };
        callAjaxWithFunction(post_url, post_data, success_function, method);
    }

</script>