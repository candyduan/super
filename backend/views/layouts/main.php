<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
?>
<!doctype html>
<html lang="zh-cn">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title><?=Html::encode(Yii::$app->params['title']);?></title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="stylesheet" href="/ace/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/ace/assets/font-awesome/4.5.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/ace/assets/css/fonts.googleapis.com.css" />
    <link rel="stylesheet" href="/ace/assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
    <link rel="stylesheet" href="/ace/assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
    <link rel="stylesheet" href="/ace/assets/css/ace-skins.min.css" />
    <link rel="stylesheet" href="/ace/assets/css/ace-rtl.min.css" />
    <link rel="stylesheet" href="/ace/assets/css/ace-ie.min.css" />
    <script src="/ace/assets/js/ace-extra.min.js"></script>
    <script src="/ace/assets/js/html5shiv.min.js"></script>
    <script src="/ace/assets/js/respond.min.js"></script>
    <link rel="shortcut icon" href="/imgs/favicon.ico" />
    <script src="/ace/assets/js/jquery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="/css/site.css"></link>
</head>
<body>
<?php $this->beginBody(); ?>
<body>
<body class="no-skin">
<div id="navbar" class="navbar navbar-default          ace-save-state">
    <div class="navbar-container ace-save-state" id="navbar-container">
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
            <span class="sr-only">Toggle sidebar</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <div class="navbar-header pull-left">
            <a href="index.html" class="navbar-brand">
                <small>
                    <i class="fa fa-leaf"></i>
                    融合SDK后台
                </small>
            </a>
        </div>
        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <li class="light-blue dropdown-modal">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <img class="nav-user-photo" src="/ace/assets/images/avatars/avatar2.png" alt="Jason's Photo" />
                        <span class="user-info">
									<small>Welcome,</small>
                         <?php echo Yii::$app->user->identity->username;?>
								</span>
                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>
                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="/site/logout">
                                <i class="ace-icon fa fa-power-off"></i>
                                退出
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div><!-- /.navbar-container -->
</div>
<body class="main-container ace-save-state" id="main-container">
<script type="text/javascript">
    try{ace.settings.loadState('main-container')}catch(e){}
</script>
<div id="sidebar" class="sidebar responsive  ace-save-state">
    <script type="text/javascript">
        try{ace.settings.loadState('sidebar')}catch(e){}
    </script>
    <ul class="nav nav-list">
        <li class="" id="">
            <a href="#" class="dropdown-toggle">
                <i class="glyphicon glyphicon-wrench"></i>
                <span class="menu-text"> SDK管理 </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
                <li class="">
                    <a href="/sdk/index">
                        <i class="menu-icon fa fa-caret-right"></i>
                        SDK管理
                    </a>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        <li class="">
            <a href="#" class="dropdown-toggle">
                <i class="glyphicon glyphicon-signal"></i>
                <span class="menu-text"> SDK计费排序 </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
                <li class="">
                    <a href="/sort/index">
                        <i class="menu-icon fa fa-caret-right"></i>
                        SDK计费排序
                    </a>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        <li class="">
            <a href="#" class="dropdown-toggle">
                <i class="glyphicon glyphicon-envelope"></i>
                <span class="menu-text"> SDK内容中心 </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
                <li class="">
                    <a href="/partner/index">
                        <i class="menu-icon fa fa-caret-right"></i>
                        内容商列表
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="">
                    <a href="/app/index">
                        <i class="menu-icon fa fa-caret-right"></i>
                        应用列表
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="">
                    <a href="/campaign/index">
                        <i class="menu-icon fa fa-caret-right"></i>
                        活动列表
                    </a>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        <li class="">
            <a href="#" class="dropdown-toggle">
                <i class="glyphicon glyphicon-refresh"></i>
                <span class="menu-text"> SDK计费转化 </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
           <!--     <li class="">
                    <a href="5">
                        <i class="menu-icon fa fa-caret-right"></i>
                        data 1
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="">
                    <a href="6">
                        <i class="menu-icon fa fa-caret-right"></i>
                        data 2
                    </a>
                    <b class="arrow"></b>
                </li>-->
            </ul>
        </li>
        <li class="">
            <a href="#" class="dropdown-toggle">
                <i class="glyphicon glyphicon-usd"></i>
                <span class="menu-text"> SDK渠道收益 </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
               <!-- <li class="">
                    <a href="7">
                        <i class="menu-icon fa fa-caret-right"></i>
                        data 1
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="">
                    <a href="8">
                        <i class="menu-icon fa fa-caret-right"></i>
                        data 2
                    </a>
                    <b class="arrow"></b>
                </li>-->
            </ul>
        </li>
        <li class="">
            <a href="#" class="dropdown-toggle">
                <i class="glyphicon glyphicon-pencil"></i>
                <span class="menu-text"> SDK计费分析 </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
             <!--   <li class="">
                    <a href="9">
                        <i class="menu-icon fa fa-caret-right"></i>
                        data 1
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="">
                    <a href="0">
                        <i class="menu-icon fa fa-caret-right"></i>
                        data 2
                    </a>
                    <b class="arrow"></b>
                </li>-->
            </ul>
        </li>
        <li class="">
            <a href="#" class="dropdown-toggle">
                <i class="glyphicon glyphicon-paperclip"></i>
                <span class="menu-text"> SDK成果录入 </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
            <!--    <li class="">
                    <a href="11">
                        <i class="menu-icon fa fa-caret-right"></i>
                        data 1
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="">
                    <a href="12">
                        <i class="menu-icon fa fa-caret-right"></i>
                        data 2
                    </a>
                    <b class="arrow"></b>
                </li>-->
            </ul>
        </li>
        <li class="">
            <a href="#" class="dropdown-toggle">
                <i class="glyphicon glyphicon-plus"></i>
                <span class="menu-text"> SDK数据录入 </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
             <!--   <li class="">
                    <a href="13">
                        <i class="menu-icon fa fa-caret-right"></i>
                        data 1
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="">
                    <a href="14">
                        <i class="menu-icon fa fa-caret-right"></i>
                        data 2
                    </a>
                    <b class="arrow"></b>
                </li>-->
            </ul>
        </li>
    </ul><!-- /.nav-list -->
    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>
</div>
<div class="main-content">
    <div class="main-content-inner">
        <!--   <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                  <ul class="breadcrumb">
                      <li>
                          <i class="ace-icon fa fa-home home-icon"></i>
                          <a href="#">Home</a>
                      </li>
                      <li>
                          <a href="#">Other Pages</a>
                      </li>
                      <li class="active">Blank Page</li>
                  </ul>
              </div>-->
        <div class="page-content">
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <?php echo $content; ?>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->
<div class="footer">
    <div class="footer-inner">
        <div class="footer-content">
				<span class="bigger-120">
                    <span class="blue bolder"></span>
							上海麦广网络科技有限公司 &copy; 2014-2017
                </span>
        </div>
    </div>
    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
        <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
    </a>
</div>
<!--<script src="/ace/assets/js/jquery-2.1.4.min.js"></script>-->
<!--<script src="/ace/assets/js/jquery-1.11.3.min.js"></script>-->
<script src="/ace/assets/js/jquery.dataTables.min.js"></script>
<script src="/ace/assets/js/jquery.dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
    if('ontouchstart' in document.documentElement) document.write("<script src='web/ace/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>
<script src="/ace/assets/js/bootstrap.min.js"></script>
<script src="/ace/assets/js/ace-elements.min.js"></script>
<script src="/ace/assets/js/ace.min.js"></script>
<script src="/js/common/jquery.cookie.js"></script>
<!-- inline scripts related to this page -->
<script type="text/javascript">
    $(document).ready(function(){
            var cookie_href =  $.cookie('url');
            if (typeof cookie_href != 'undefined') {
                $('ul.submenu li a').each(function(){
                    if (cookie_href == $(this).prop('href')) {
                        $(this).parent().addClass('active');
                        $(this).parent().parent().parent().addClass('active open');
                    }else{
                        $(this).parent().removeClass('active');
                   /*     $(this).siblings().each(function(that){
                            if($(that).href == cookie_href){
                               return;
                            }
                            $(this).parent().parent().parent().removeClass('active').remove('open');
                        });*/

                        //$(this).parent().parent().parent().removeClass('active').removeClass('open');
                    }
                });
            }
        }
    );
    $('ul.submenu li').find('a').on('click', function(){
        var href = $(this).prop('href');
        $.cookie('url', href, {expires : 1, path : '/'});
    });


</script>
</body>

</html>
