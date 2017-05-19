<?php
namespace backend\library\widgets;
class WidgetsUtils{
    public static function getMainMenu(){
        $str = '
                <a class="navbar-brand" style="font-size:18px;" href="http://master.maimob.cn/index.php/admin/" target="_blank">支付SDK</a>
                <a class="navbar-brand" style="font-size:18px;" href="/site/index">融合SDK</a>
                <a class="navbar-brand" style="font-size:18px;" href="/register/index">主动上行</a>
                <a class="navbar-brand" style="font-size:18px;" href="/agency/index">注册中介</a>
            ';
        return $str;
    }
    
    
    public static function getSearchTime(){
        $str = '
          <script type="text/javascript" src="/js/common/DatePicker/WdatePicker.js"></script>
          <div class="form-group"><input type="text" class="form-control search-time search-stime"  value="" placeholder="开始时间"></div>
          <div class="form-group"><input type="text" class="form-control search-time search-etime"  value="" placeholder="结束时间"></div>
          <script>
            $(document).ready(function(){
                	var day = Utils.getToday();
                	$(".search-time").val(day);
                	$(".search-time").click(function(){
                		WdatePicker();
                	});
            });  
          </script>  
            ';
        return $str;
    }
    
    public static function getSearchChannel(){
        $str = '
          <div class="form-group"><input type="text" class="form-control" id="channel-f"    placeholder="通道"></div>
          <input type="hidden" id="channel" value="">            
            <script>
                $(document).ready(function(){
                	var jsonList	= '.json_encode(\common\models\orm\extend\RegChannel::getTypeHeaderChannelList()).'
                	Utils.myTypeHeder(jsonList,"channel-f","channel","");
                });
            </script>
            ';
        return $str;
    }
    
    
    public static function getFooter(){
        $str = '
<div style="position:absolute;z-index:999;left:0px;top:0px; width:100%;text-align:center !important;display:none;" id="loading" class=""><img src="/imgs/loading.gif" style="margin-top:10%;"></div>
<div id="dialog" class="modal fade"></div>
<script>
$(document).ready(function(){
	var url = window.location.href;
	var domain = document.domain;
    url = url.split("?");
    url = url[0];
	url = url.replace("http://","").replace(domain,"").replace(":8082","");
	$.each($(".sidebar-item"),function(key,val){
		if($(val).attr("href") == url){
			$(val).addClass("selected");
			$(val).parent().parent().addClass("in");
		}
	});
});
</script>            
            
            ';
        return $str;
    }
}