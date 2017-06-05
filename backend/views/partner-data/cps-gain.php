<link rel="stylesheet" href="/ace/assets/css/bootstrap-datepicker3.min.css" />
<div class="panel panel-warning">
    <!-- panel heading -->
       <ol class="breadcrumb">
        <li class="active">CPS收入</li>
        </ol>
    <!-- panel body -->
    <div class="panel-body">
        <div class="row">
        	<form action="" method="get" id="formSearch" class="form-inline">
        	<input type="hidden" name="partner" id ="partner" value="<?php echo $id?>">
                <div class="col-sm-10 col-md-10 col-lg-10">
                    <select class="form-control" id="app" name="app">
                        <option value="0">应用名：可模糊</option>
                        <?php foreach($apps as $value){
                            $id = $value['id'];
                            $name = $value['name'];
                            echo "<option value='$id'> $name</option>";
                        }?>
                    </select>
                    <select class="form-control" id="channel" name="campaign">
                        <option value="0">活动名：可模糊</option>
                        <?php foreach($campaigns as $value){
                            $id = $value['id'];
                            $name = $value['name'];
                            echo "<option value='$id'> $name</option>";
                        }?>
                    </select>
                    <select class="form-control" id="channel" name="channel">
                        <option value="">渠道标识：可模糊</option>
                        <?php foreach($channels as $value){
                            $id = $value['id'];
                            $mediaSign = $value['mediaSign'];
                            echo "<option value='$mediaSign'> $mediaSign</option>";
                        }?>
                    </select>
                    <input  type="text"   class="form-control date-picker" id="startDate" name="startDate" data-date-format="yyyy-mm-dd">
                    ~
                    <input  type="text"   class="form-control date-picker" id="endDate" name="endDate" data-date-format="yyyy-mm-dd">
                     显示字段：
                    <input type="checkbox" id="checkAPP" name="checkAPP"/> 产品 
                    <input type="checkbox" id="checkCampaign" name="checkCampaign"/>活动 
                    <input type="checkbox" id="checkM" name="checkM"/>渠道 
                    
                    <i class="glyphicon pointer green glyphicon-glass" onclick="setDateType(this)" title="时段" value="3" id="inputDateType"></i> 
                    &nbsp;
                    <i class="btn btn-primary" onclick="searchData()">搜索</i> 
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
                        <td id="cloumn_app">应用名</td>
                        <td id="cloumn_campaign">活动</td>
                        <td id="cloumn_package">渠道</td>
                        <td>新增用户</td>
                        <td>成功金额</td>
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
                'aTargets': [0,1,2,3,4,5],
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
                "url":'/partner-data/ajax-cps-gain?' + $.param($('#formSearch').serializeArray()) + param,
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