function Utils(){}
Utils.ajax      = function(url,data,succ,async){
    if(typeof(async) == 'undefined'){
            async   = true;
    }
	$.ajax({
	    url: url,
	    timeout:120000,
	    type: 'post',
	    data:data,
	    dataType: 'json',
	    async:async,
	    beforeSend:function(){$('#loading').css('display','block');},
	    complete:function(){$('#loading').css('display','none');},
	    success: succ,
	});
};

Utils.getQueryString    = function(name){
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if(r!=null)return  r[2]; return '';
};

Utils.setPagination             = function(currentPage,totalPages){
    currentPage     = parseInt(currentPage);
    totalPages      = parseInt(totalPages);
    var startPage  = currentPage - 7;
    if(startPage < 1){
            startPage       = 1;
    }
    var maxPageCount        = startPage + 15;
    if(maxPageCount > totalPages){
            maxPageCount    = totalPages;
    }
    var pagerHtml  = '';
    if(currentPage > 1){
            pagerHtml = pagerHtml + '<li><button class="btn pager_number" page=' + (currentPage - 1) + '>上一页</button></li>';
    }
    for(var i=startPage;i<=maxPageCount;i++){
            var disabled;
            var selected;
            if(i == currentPage){
                    disabled        = 'disabled="disabled"';
                    selected        = 'pager_number_selected';
            }else{
                    disabled        = '';
                    selected        = '';
            }
            pagerHtml = pagerHtml + '<li><button class="btn pager_number '+ selected +'"'+ disabled + 'page='+ i +' >'+ i +'</button></li>';
    }
    if(currentPage < maxPageCount){
            pagerHtml = pagerHtml + '<li><button class="btn pager_number" page=' + (currentPage + 1) + '>下一页</button></li>';
    }
    $('.pager').html(pagerHtml);
};

Utils.getErrModal       = function(title,body){
    var html        = '<div class="modal-dialog">' +
    '    <div class="modal-content circular">' +
    '      <div class="modal-header" style="margin-left:10px;padding-left:10px;">' +
    '        <h4 class="modal-title">' + title + '</h4>' +
    '      </div>' +
    '      <div class="modal-body" style="margin-left:10px;padding-left:10px;">' +
    '        <p>'+ body +'</p>' +
    '      </div>' +
    '      <div class="modal-footer"> ' +
    '        <button type="button" style="border-radius:0px;" class="btn btn-default" data-dismiss="modal">关闭</button>' +
    '      </div>' +
    '    </div>' +
    '  </div>';
    $('#dialog').html(html);
    $('#dialog').modal('toggle');
};

Utils.getNoFooterModal  = function(title,body){
    var html        = '<div class="modal-dialog">' +
    '    <div class="modal-content circular">' +
    '      <div class="modal-header" style="background-color:#f1f1f1;">' +
    '        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
    '        <h4 class="modal-title">' + title + '</h4>' +
    '      </div>' +
    '      <div class="modal-body" style="padding-top:0px;">' +
    '        <p>'+ body +'</p>' +
    '      </div>' +
    '    </div>' +
    '  </div>';
    $('#dialog').html(html);
    $('#dialog').modal('toggle');
};

Utils.setConditionSdayEday      = function(){
    $('.form_date').datetimepicker({
            format : 'yyyy-mm-dd',
            todayBtn : 'linked',
            todayHighlight : 1,
            language : 'zh-CN',
            autoclose : 1,
            minView : 2
    });
    $("#sday").datetimepicker("setDate",new Date(new Date().getTime() - 6 * 24 * 60 * 60 * 1000));
    $("#eday").datetimepicker("setDate",new Date(new Date().getTime()));
};

Utils.drawSingleChart   = function(xData,yData){
    var chart = echarts.init(document.getElementById('chart'));
    var option = {
        tooltip: {},
        xAxis: {
            data: xData
        },
        yAxis: {},
        series: [{
            type: 'line',
            data: yData
        }]
    };
// 使用刚指定的配置项和数据显示图表。
chart.setOption(option);
};

Utils.drawMultiChart    = function(xData,yDatas){
    var series      = new Array();
    var legend      = new Array();

    $.each(yDatas,function(key,val){
            legend.push(val.name);
            var item        = {
                            name:val.name,
                            type:'line',
                            data:val.data,
            };
            series.push(item);
    });
    var chart = echarts.init(document.getElementById('chart'));
    var option = {
        tooltip: {},
        legend: {
            data:legend,
        },
        xAxis: {
            data: xData
        },
        yAxis: {},
        series:series,
    };
// 使用刚指定的配置项和数据显示图表。
chart.setOption(option);
};


Utils.drawPieChart      = function(data){
    var chart = echarts.init(document.getElementById('chart'));
    var option = {
                     tooltip: {},
                      series : [
                                {
                                    type: 'pie',
                                    radius: '55%',
                                    //roseType: 'angle',
                                    data:data
                                }
                            ]
                    };
// 使用刚指定的配置项和数据显示图表。
chart.setOption(option);
};


Utils.drawMapChart      = function(data){
    var chart = echarts.init(document.getElementById('chart'));
    var option = {
                        tooltip : {
                            trigger: 'item'
                        },
                        legend: {
                            orient: 'vertical',
                            left: 'left',
                            data:[]
                        },
                        visualMap: {
                            min: 0,
                            max: 2500,
                            left: 'left',
                            top: 'bottom',
                            text:['高','低'],           // 文本，默认为数值文本
                            calculable : true
                        },
                        toolbox: {
                            show: true,
                            orient : 'vertical',
                            left: 'right',
                            top: 'center',
                            feature : {
                                mark : {show: true},
                                dataView : {show: true, readOnly: false},
                                //restore : {show: true},
                                saveAsImage : {show: true}
                            }
                        },
                            series : [
                                        {
                                            name: '',
                                            type: 'map',
                                            mapType: 'china',
                                            roam: false,
                                            label: {
                                                normal: {
                                                    show: true
                                                },
                                                emphasis: {
                                                    show: true
                                                }
                                            },
                                            data:data
                                        }
                             ]
            };
    chart.setOption(option);
};
