<link rel="stylesheet" href="/ace/assets/css/bootstrap-datepicker3.min.css" />
<div class="panel panel-warning">
    <!-- panel heading -->
       <ol class="breadcrumb">
        <li class="active"><i class="fa fa-dashboard"></i>融合SDK渠道收益表</li>
        </ol>
    <!-- panel body -->
    <div class="panel-body">
        <div class="row">
        	<form action="" method="get" id="formSearch" class="form-inline">
                <div class="col-sm-10 col-md-10 col-lg-10">
                    <input type="text"  class="form-control " id='partner' name ='partner'  placeholder="Partner"/>
                    <select class="form-control" id="app" name="app">
                        <option value="0">选择应用</option>
                        <?php foreach($apps as $value){
                            $id = $value['id'];
                            $name = $value['name'];
                            echo "<option value='$id'> $name</option>";
                        }?>
                    </select>
                    <select class="form-control" id="channel" name="channel">
                        <option value="0">选择渠道</option>
                        <?php foreach($channels as $value){
                            $id = $value['id'];
                            $name = $value['name'];
                            echo "<option value='$id'> $name</option>";
                        }?>
                    </select>
                    <input  type="text"   class="form-control date-picker" id="startDate" name="startDate" data-date-format="yyyy-mm-dd">
                    ~
                    <input  type="text"   class="form-control date-picker" id="endDate" name="endDate" data-date-format="yyyy-mm-dd">
                     字段：
                    <input type="checkbox" id="checkCP" name="checkCP"/> CP 
                    <input type="checkbox" id="checkAPP" name="checkAPP"/> APP 
                    <input type="checkbox" id="checkCmp" name="checkCmp"/>Cmp 
                    <input type="checkbox" id="checkM" name="checkM"/>M 
                    
                    <i class="glyphicon pointer green glyphicon-glass" onclick="setDateType(this)" title="时段" value="3" id="inputDateType"></i> 
                    <i class="glyphicon pointer blue glyphicon-search" onclick="searchData()" title="查询"></i> 
                    <i class="glyphicon pointer green glyphicon-cloud-download" onclick="downloadData()" title="下载"></i> 
                </div>  
                </div>
            </form>
        </div><hr>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <table id="tbl" class="table table-striped table-bordered gclass_table text-center">
                    <thead>
                    <tr>
                        <td id="cloumn_date">日期</td>
                        <td id="cloumn_cp">CP</td>
                        <td id="cloumn_app">应用</td>
                        <td id="cloumn_campaign">活动包</td>
                        <td id="cloumn_package">渠道</td>
                        <td>激活数</td>
                        <td>活跃数</td>
                        <td>支付用户</td>
                        <td>信息费</td>
                        <td>CP费</td>
                        <td>ARPU</td>
                        <td>付ARPU</td>
                        <td>付费率</td>
                        <td>收入</td>
                        <td>CP成本</td>
                        <td>M成本</td>
                        <td>毛利</td>
                        <td>毛利率</td>
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

<!-- ------------------------------------------------------------------------javascript---------------------------------------------------------------------->
<!--<script src="/ace/assets/js/jquery-ui.custom.min.js"></script>-->
<script src="/ace/assets/js/bootstrap-datepicker.min.js"></script>
<script src="/js/sdk/util.js"></script>
<script src="/js/sdk/alert.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var now = getCurdate();
        $("#startDate").val(now);
        $("#endDate").val(now);
        _initDataTable();
    });

    $('.date-picker').datepicker({
        autoclose: true,
        todayHighlight: true
    })

    function _initDataTable() {
        var param = '&dateType='+ $("#inputDateType").attr("value");

        $("#tbl").dataTable().fnDestroy();
        
        $('#tbl').DataTable({
            "pagingType": "simple_numbers",
            "searching": false,
            "bAutoWidth": false,
         //   "scrollX": true,
            //"order": [[ 5, "desc" ]],
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17],
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
                "url":'/package-pay/ajax-index?' + $.param($('#formSearch').serializeArray()) + param,
                "dataSrc": function(json) {
                    return json.tableData;
                }
            }
        });
    }

    function setDateType(that){
    	if($(that).hasClass('glyphicon-glass')){
            $(that).removeClass('glyphicon-glass').addClass('glyphicon-music');
            $(that).attr('title',"月份");
            $(that).attr('value',"4");
        }else if($(that).hasClass('glyphicon-music')){
            $(that).removeClass('glyphicon-music').addClass('glyphicon-certificate');
            $(that).attr('title',"天");
            $(that).attr('value',"1");
        }else if($(that).hasClass('glyphicon-certificate')){
            $(that).removeClass('glyphicon-certificate').addClass('glyphicon-glass');
            $(that).attr('title',"时段");
            $(that).attr('value',"3");
        }
    }
    
    function searchData(){
    	_initDataTable();
    }
    function downloadData(){
    	alert('TODO');
    }
    
    function getCurdate(){
    	var now=new Date();
        var y=now.getFullYear();
        var m=now.getMonth()+1;
        var d=now.getDate();
        var m=m<10?"0"+m:m;
       	var d=d<10?"0"+d:d;
        return y+"-"+m+"-"+d;
    }
</script>