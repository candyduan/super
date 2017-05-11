<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>麦广互娱注册管理后台</title>

    <!-- Bootstrap Core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/css/mii-admin.css" rel="stylesheet">
    <link href="/css/register.css" rel="stylesheet"> 

    <!-- Custom Fonts -->
    <link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="/js/common/jquery.js"></script>
    <script src="/js/common/bootstrap.min.js"></script>
    <script src="/js/register/Utils.js"></script>
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/register/index">麦广互娱注册管理后台</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>周松<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="/site/logout"><i class="fa fa-fw fa-power-off"></i>退出</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="/register/index"><i class="fa fa-fw fa-dashboard"></i>首页</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#regchannel"><i class="fa fa-fw fa-dashboard"></i>通道中心<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="regchannel" class="collapse">
                            <li><a href="/register/merchant-view">通道商列表</a></li>
                            <li><a href="/register/channel-view">通道管理</a></li>
                            <li><a href="/register/mutex-view">通道组管理</a></li>
                        </ul>
                    </li>
                    
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#profit"><i class="fa fa-fw fa-dashboard"></i>数据中心<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="profit" class="collapse">
                            <li><a href="/register/profit-channel-view">通道收益</a></li>
                        </ul>
                    </li>
                    
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#agency"><i class="fa fa-fw fa-dashboard"></i>注册中介<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="agency" class="collapse">
                            <li><a href="/agency/account-list-view">中介列表</a></li>
                            <li><a href="/agency/account-set-view">新增中介</a></li>
                        </ul>
                    </li>
                                        
                                        
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">
            <?= $content ?>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<div style="position:absolute;z-index:999;left:0px;top:0px; width:100%;display:none;" id="loading" class=""><img src="/imgs/loading.gif" style="width:100%;"></div>

<div id="dialog" class="modal fade"></div>
</body>

</html>

