<div class="panel panel-warning">
    <!-- panel heading -->
        <ol class="breadcrumb">
        <li class="active"><i class="fa fa-dashboard"></i>计费排序</li>
        </ol>
    <!-- panel body -->
    <span>注:点击地图上不同省份修改sdk排序(请点击字体以外的区域)</span>
    <div class="panel-body main">
        <div class="row">
            <input type="hidden" id='hidden_provider' value="1"/>
            <input type="hidden" id='hidden_prid' value="0"/>
            <div class="col-sm-10 col-md-10 col-lg-10">
                <button id='btn_yidong' onclick="changebtn(this)" class="btn btn-success">
                    <span>移动</span>
                </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button id='btn_liantong' onclick="changebtn(this)" class="btn">
                    <span>联通</span>
                </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button id='btn_dianxin' onclick="changebtn(this)" class="btn">
                    <span>电信</span>
                </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2 text-right">
                <button class="btn" id="btn_show">
                    移动融合SDK排序
                </button>&nbsp;
            </div>
        </div><hr>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="demo">
                    <div id="map"></div>

                </div>
            </div>
        </div>
    </div>
    <!-- panel footer -->
    <div class="panel-footer">
    </div>
</div>

<div id="modalSort" class="modal fade" >
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <span id="sort_title"></span>
            </div>
            <div class="modal-body" >
                <ul id="bodySort"><ul>
            </div>
            <div class="modal-footer" >
                <button type="submit" class="btn btn-success" id="btn_submit_sort">提交</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>


<!-- ------------------------------------------------------------------------javascript---------------------------------------------------------------------->
<!--<script src="/ace/assets/js/jquery-2.1.4.min.js"></script>-->
<script type="text/javascript" src="/js/sdk/util.js"></script>
<script type="text/javascript" src="/js/sdk/alert.js"></script>
<script type="text/javascript" src="/js/common/chinamapPath.js"></script>
<script type="text/javascript" src="/js/common/raphael.js"></script>
<!--<script type="text/javascript" src="/js/common/jquery.dragsort-0.5.2.min.js"></script>-->
<script type="text/javascript" src="/ace/assets/js/jquery-ui.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        getSdkCountAndDrawMap(1); //首页进来默认是移动
      /*  $('#bodySort').dragsort({  itemSelector: "tr", dragSelector: "tr", dragBetween: false, dragEnd: saveOrder, placeHolderTemplate: "<tr></tr>" });
        function saveOrder() {

        }*/
    });

    function drawMap(result){

        var textAttr = {
            "fill": "#000",
            "font-size": "12px",
            "cursor": "pointer"
        };

        R = Raphael("map", 600, 500);
        //调用绘制地图方法
        paintMap(R);

        for (var state in china) {
            china[state]['path'].color = Raphael.getColor(0.9);
            (function (st, state) {

                //获取当前图形的中心坐标
                var xx = st.getBBox().x + (st.getBBox().width / 2);
                var yy = st.getBBox().y + (st.getBBox().height / 2);

                //!***修改部分地图文字偏移坐标
                switch (china[state]['name']) {
                    case "江苏":
                        xx += 5;
                        yy -= 10;
                        break;
                    case "河北":
                        xx -= 10;
                        yy += 20;
                        break;
                    case "天津":
                        xx += 20;
                        yy += 10;
                        break;
                    case "北京":
                        xx += 20;
                        break;
                    case "上海":
                        xx += 20;
                        break;
                    case "广东":
                        yy -= 10;
                        break;
                    case "澳门":
                        yy += 10;
                        break;
                    case "香港":
                        xx += 20;
                        yy += 5;
                        break;
                    case "甘肃":
                        xx -= 40;
                        yy -= 30;
                        break;
                    case "陕西":
                        xx += 5;
                        yy += 10;
                        break;
                    case "内蒙古":
                        xx -= 15;
                        yy += 65;
                        break;
                    case "海南":
                        yy += 20;
                        break;
                    default:
                }
                var count = 0;//某几个省份是不存在在表中的 chinamapjs中将其设置为0
                var prid = china[state]['prid'];
                var name = china[state]['name'];
                if(prid > 0){
                    count = ( result[prid] == undefined ) ? 0 : result[prid];
                }

                var color = getColorBySdkCount(result,count);
                //写入文字
                china[state]['text'] = R.text(xx, yy, china[state]['name']+ count).attr(textAttr);
                //填充背景色
                st.attr({fill: color});

                xOffset = 70;
                yOffset = 240;

                st.click(function(e){
                    if(count != 0) { // 1. count为0的情况:1 确实该省份下sdk数量为0 2该省份不存在省份表中 sdk 数量也为0
                        var provider = $('#hidden_provider').val();
                        showSortModal(provider, prid, name);
                    }
                });


            })(china[state]['path'], state);
        }
    }

    function  getSdkCountAndDrawMap(provider){
        var data = {
            'provider' : provider,
        };

        var url = '/sort/get-sdk-count';
        var method = 'get';
        var success_function = function(result){
            $('#hidden_provider').val(provider);
            $('#map').empty();
            drawMap(result);
        };
        callAjaxWithFunction(url,data,success_function,method);
    }

    function getColorBySdkCount(result, count){
        var color = 'pink';
        var resultWithNoZero = [];
        for(var i in result){
            if(i != 0){
                resultWithNoZero.push(i);
            }
        }

        var max = Math.max.apply(Math,  resultWithNoZero);
        var min = Math.min.apply(Math,  resultWithNoZero);
        var middle = parseInt((max+min)/2);
        if(count > 0){
            if(count == max){
                var color = '#006400'; //最深
            }else if(count == min){
                var color = '#76EEC6';// 很浅
            } else if( count  >= middle && count < max){ //深
                var color = '#008B00';
            } else if( count  <  middle && count > min){ //浅
                var color = '#00CD66';
            }
        }
        return color;
    }

    function changebtn(that){//0 蓝色 => 无限制 1 绿色 => 白名单 2 红色 =》黑名单 //获取按钮点击以后下一个的状态
        var provider;
        var id = $(that).prop('id');
        if(id == 'btn_yidong' ){
            $(that).addClass('btn-success');
            $('#btn_liantong').removeClass('btn-danger');
            $('#btn_dianxin').removeClass('btn-primary');
            $('#btn_show').text('移动融合SDK排序');
            provider = 1;
        } else if(id == 'btn_liantong'){
            $(that).addClass('btn-danger');
            $('#btn_yidong').removeClass('btn-success');
            $('#btn_dianxin').removeClass('btn-primary');
            $('#btn_show').text('联通融合SDK排序');
            provider = 2;
        } else if(id == 'btn_dianxin'){
            $(that).addClass('btn-primary');
            $('#btn_yidong').removeClass('btn-success');
            $('#btn_liantong').removeClass('btn-danger');
            $('#btn_show').text('电信融合SDK排序');
            provider = 3;
        }
        getSdkCountAndDrawMap(provider)
    }

    function showSortModal(provider, prid, province_name){
        var provider_name = getProviderName(parseInt(provider));
        $('#sort_title').text(province_name+provider_name+'融合SDK排序(拖动某一个行来排序)');
        var data = {
            'provider' : provider,
            'prid'     : prid
        }
        var url = '/sort/get-sdk-sort';
        var method = 'get';
        var success_function = function(result){
            var content_str = '';
            for(var i in result) {
                var content_arr = [];
                content_arr.push("<li id='"+result[i].sdid+"'>  sdk名称:  "+result[i].sdkname+" 昨日转化率:");
                content_arr.push(result[i].ratio+"<span></li>");
                //content_arr.push(result[i].item+"</span></li>");
                content_str  += content_arr.join(' ');
            }
            $('#hidden_prid').val(prid);
            $('#bodySort').empty().append(content_str);
            $('#btn_submit_sort').attr('disabled', false);
          //  drag();
            dragable();
           // submit();
            $('#modalSort').modal('show');
        };

        callAjaxWithFunction(url,data,success_function,method);

    }

    function getProviderName(provider){
        var provider_name = '';
        switch (provider){
            case 1:
                provider_name = '移动'; break;
            case 2:
                provider_name = '联通'; break;
            case 3:
                provider_name = '电信'; break;
        }
        return provider_name
    }

/*    function drag(){
        $('#bodySort').dragsort({  itemSelector: "tr", dragSelector: "tr", dragBetween: true, dragEnd: saveOrder, placeHolderTemplate: "<tr></tr>" });
        function saveOrder() {

        }
    }*/

    function dragable(){
        $( "ul" ).sortable({
            connectWith: "ul"
        });

        $( "#bodySort" ).disableSelection();
    }

    $('#btn_show').on('click',function(){
        var provider = $('#hidden_provider').val();
        showSortModal(provider, 0, '')
    })

    $('#btn_submit_sort').on('click', function (event) {
        event.preventDefault();
        var sdids = [];
        $('#bodySort li').each(function () {
            sdids.push($(this).prop('id'));
        });
        var data = {
          'sdids': sdids,
          'prid' : $('#hidden_prid').val(),
          'provider' : $('#hidden_provider').val()
        }
        var url = '/sort/add-sort';
        var method='post';
        var success_function = function(result){
           if(parseInt(result) > 0){
               alert(MESSAGE_MODIFY_SUCCESS);
               $('#modalSort').modal('hide');
           }else{
               alert(MESSAGE_MODIFY_ERROR);
           }
        }

        callAjaxWithFunction(url, data, success_function, method);
    });


</script>