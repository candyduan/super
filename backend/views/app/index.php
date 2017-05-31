<div class="panel panel-warning">
    <!-- panel heading -->
        <ol class="breadcrumb">
        <li class="active">应用管理</li>
        </ol>
    <!-- panel body -->
    <div class="panel-body main">
        <div class="row">
            <form action="" method="get" id="formSearch" class="form-inline">
                <div class="col-sm-10 col-md-10 col-lg-10">
                    <input type="text" class="form-control" id="name" name="name" placeholder="内容商名称:模糊搜索"/>
                    <input type="text"  class="form-control" id='id' name ='id' value="<?php echo $id?>"  placeholder="内容商id"/>
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
                        <td>应用名</td>
                        <td>包名</td>
                        <td>版本号</td>
                        <td>大小</td>
                        <td>管理活动</td>
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
                "url":'/app/ajax-index?' + $.param($('#formSearch').serializeArray()),
                "dataSrc": function(json) {
                    return json.tableData;
                }
            }
        });
    }

</script>