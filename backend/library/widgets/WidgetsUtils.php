<?php
namespace backend\library\widgets;
use common\models\orm\extend\AdminTheme;
use common\models\orm\extend\AgencyAccount;
use common\models\orm\extend\Channel;

class WidgetsUtils{
    public static function getMainMenu($layout = ''){
        $payLight       = '';
        $sdkLight       = '';
        $registerLight  = '';
        $agencyLight    = '';
        $systemLight    = '';
        switch ($layout){
            case 'pay':
                $payLight       = 'main-menu-light';
                break;
            case 'sdk':
                $sdkLight       = 'main-menu-light';
                break;
            case 'register':
                $registerLight  = 'main-menu-light';
                break;
            case 'agency':
                $agencyLight    = 'main-menu-light';
                break;
            case 'system':
                $systemLight    = 'main-menu-light';
                break;
            default:
                $light = '';
        }
        $str = '
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand main-menu '.$payLight.'" href="/pay/index">支付SDK</a>
                <a class="navbar-brand main-menu '.$sdkLight.'" href="/site/index">融合SDK</a>
                <a class="navbar-brand main-menu '.$registerLight.'" href="/register/index">主动上行</a>
                <a class="navbar-brand main-menu '.$agencyLight.'" href="/agency/index">注册中介</a>
                <a class="navbar-brand main-menu '.$systemLight.'" href="/system/index">系统管理</a>
            </div>
                    
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle user-ops" data-toggle="dropdown"><i class="fa fa-user"></i>'.\Yii::$app->user->identity->username.'<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="/auth/logout"><i class="fa fa-fw fa-power-off"></i>退出</a>
                        </li>
                    </ul>
                </li>
            </ul>
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
    
    public static function getSearchRegChannel(){
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
    
    public static function getSearchPayChannel(){
        $str = '
          <div class="form-group"><input type="text" class="form-control" id="channel-f"    placeholder="通道"></div>
          <input type="hidden" id="channel" value="">
            <script>
                $(document).ready(function(){
                	var jsonList	= '.json_encode(\common\models\orm\extend\Channel::getTypeHeaderChannelList()).'
                	Utils.myTypeHeder(jsonList,"channel-f","channel","");
                });
            </script>
            ';
        return $str;
    }
    
    public static function getSearchMerchant(){
        $str = '
          <div class="form-group"><input type="text" class="form-control" id="merchant-f"    placeholder="通道商"></div>
          <input type="hidden" id="merchant" value="">
            <script>
                $(document).ready(function(){
                	var jsonList	= '.json_encode(\common\models\orm\extend\Merchant::getTypeHeaderMerchantList()).'
                	Utils.myTypeHeder(jsonList,"merchant-f","merchant","");
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
                var selected = false;
            	$.each($(".sidebar-item"),function(key,val){
            		if($(val).attr("href") == url){
            			$(val).addClass("selected");
            			$(val).parent().parent().addClass("in");
                        selected = true;
                        $.cookie("prev", url, { expires: 7, path: "/" }); 
            		}
            	});
                 if(!selected){
                     $.each($(".sidebar-item"),function(key,val){
                		if($(val).attr("href") == $.cookie("prev")){
                			$(val).addClass("selected");
                			$(val).parent().parent().addClass("in");
                		}
                	 });
                 }
            });
            </script>            
            
            ';
        return $str;
    }
    
    public static function getHeader(){
        $color    = AdminTheme::getColorByAuid(\Yii::$app->user->identity->id);
        $bcolor   = '#'.@$color['bcolor'];        
        $fcolor   = '#'.@$color['fcolor'];
        $str ='
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="">
            <meta name="author" content="">
          
        	<link rel="stylesheet" href="/ace/assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
            <link href="/css/bootstrap.min.css" rel="stylesheet">
            <link href="/css/mii-admin.css?d=20170615" rel="stylesheet">
            <link href="/css/pnotify.custom.css" rel="stylesheet">
            <link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css">
            <style type="text/css">
            .navbar{background-color:'.$bcolor.';border:0px;}
            .nav{background-color:'.$bcolor.';margin-top:-1px;}
            .main-menu{color:'.$fcolor.' !important;}
            .user-ops{background-color:'.$bcolor.' !important;;color:'.$fcolor.' !important;;}
            .side-nav li a:hover,.side-nav li a:focus,.side-nav li a {outline: none;background-color:'.$bcolor.';color:'.$fcolor.' !important;}
            </style>
            <script src="/js/common/jquery.js"></script>
            <script src="/js/common/jquery.cookie.js"></script>
            <script src="/js/common/bootstrap.min.js"></script>
          	<script src="/js/common/bootstrap3-typeahead.min.js"></script>
            <script src="/js/common/pnotify.custom.js"></script>   
            <script src="/js/register/Utils.js?d=20170614"></script>
            <script src="/ace/assets/js/jquery.dataTables.min.js"></script>
	        <script src="/ace/assets/js/jquery.dataTables.bootstrap.min.js"></script>
            ';
        return $str;
    }
    
    
    public static function getAgencyAccount(){
        $str = '<select class="agency-account">';
        $str.= '<option value="0">全部</option>';
        $agencyAccountModels = AgencyAccount::findAlls();
        foreach ($agencyAccountModels as $agencyAccountModel){
            $str .= '<option value ="'.$agencyAccountModel->aaid.'">'.$agencyAccountModel->name.'</option>';
        }
        $str .='</select>';
        return $str;
    }
}