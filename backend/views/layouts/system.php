<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>麦广互娱-系统管理</title>
	<link rel="stylesheet" href="/ace/assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
    <!-- Bootstrap Core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/css/mii-admin.css?d=201705231" rel="stylesheet">

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
  	<script src="/js/common/bootstrap3-typeahead.min.js"></script>
    <script src="/js/register/Utils.js?d=20170516"></script>
    <script src="/ace/assets/js/jquery.dataTables.min.js"></script>
	<script src="/ace/assets/js/jquery.dataTables.bootstrap.min.js"></script>
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
                <?php echo backend\library\widgets\WidgetsUtils::getMainMenu('system');?>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>  <?php echo Yii::$app->user->identity->username;?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="/auth/logout"><i class="fa fa-fw fa-power-off"></i>退出</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="">
                        <a class="sidebar-item" href="/system/index"><i class="fa fa-fw fa-dashboard"></i>首页</a>
                    </li>
                    
                    <li class="">
                        <a href="javascript:;" data-toggle="collapse" data-target="#user-center"><i class="fa fa-fw fa-dashboard"></i>个人中心<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="user-center" class="collapse">
                            <li><a class="sidebar-item" href="/modify-password/index">修改密码</a></li>
                        </ul>
                    </li>
                                        
                     <li class="">
                        <a href="javascript:;" data-toggle="collapse" data-target="#bkadminuser"><i class="fa fa-fw fa-dashboard"></i>用户管理<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="bkadminuser" class="collapse">
                            <li><a class="sidebar-item" href="/admin-user/index">内部账户管理</a></li>
                            <li><a class="sidebar-item" href="/out-user/index">客户账户列表</a></li>
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
<?php echo backend\library\widgets\WidgetsUtils::getFooter();?>
</body>

</html>
