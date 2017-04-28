
<div class="panel panel-warning">
    <!-- panel heading -->
    <div class="page-header">
        <h1>
            <i class="ace-icon fa fa-angle-double-right"></i>
            融合SDK计费排序
        </h1>
    </div>
    <!-- panel body -->
    <div class="panel-body">
        <div class="row">
            <form action="" method="get" id="formSearch" class="form-inline">
                <div class="col-sm-10 col-md-10 col-lg-10">
                    <button id='btn_yidong' class="btn btn-primary">
                        <span>移动</span>
                    </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button id='btn_liantong' class="btn">
                        <span>联通</span>
                    </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button id='btn_电信' class="btn">
                        <span>电信</span>
                    </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2 text-right">
                    <button class="btn">
                        <span>移动融合SDK排序</span>
                    </button>&nbsp;
                </div>
            </form>
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

<!-- ------------------------------------------------------------------------javascript---------------------------------------------------------------------->
<script type="text/javascript" src="/ace/assets/js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="/js/sdk/util.js"></script>
<script type="text/javascript" src="/js/sdk/alert.js"></script>
<script type="text/javascript" src="/js/common/chinamapPath.js"></script>
<script type="text/javascript" src="/js/common/raphael.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var R = Raphael("map", 600, 500);
        //调用绘制地图方法
        paintMap(R);

        var textAttr = {
            "fill": "#000",
            "font-size": "12px",
            "cursor": "pointer"
        };

        for (var state in china) {
            china[state]['path'].color = Raphael.getColor(0.9);

            (function (st, state) {

                //获取当前图形的中心坐标
                var xx = st.getBBox().x + (st.getBBox().width / 2);
                var yy = st.getBBox().y + (st.getBBox().height / 2);

                //***修改部分地图文字偏移坐标
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
                        xx += 10;
                        yy += 10;
                        break;
                    case "上海":
                        xx += 10;
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
                    default:
                }
                //写入文字
                china[state]['text'] = R.text(xx, yy, china[state]['name']).attr(textAttr);

                st[0].onmouseover = function () {
                    st.animate({fill: st.color, stroke: "#eee"}, 500);
                    china[state]['text'].toFront();
                    R.safari();
                };

                st[0].onclick = function () {
                    alert(china[state]['id']);
                };


            })(china[state]['path'], state);
        }
    });

</script>