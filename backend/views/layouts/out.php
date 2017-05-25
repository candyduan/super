<!DOCTYPE html>
<html lang="en">

<head>
	<title>麦广互娱-客户后台</title>
	<?php echo backend\library\widgets\WidgetsUtils::getHeader();?>
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
            <a class="navbar-brand" style="font-size:18px;" href="/out-auth/index">客户后台</a>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>  <?php echo Yii::$app->user->identity->username;?><b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="/out-auth/logout"><i class="fa fa-fw fa-power-off"></i>退出</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
                <li class="">
                    <a class="sidebar-item" href="/out-auth/index"><i class="fa fa-fw fa-dashboard"></i>首页</a>
                </li>

                <li class="">
                    <a href="javascript:;" data-toggle="collapse" data-target="#my-benefit"><i class="fa fa-fw fa-dashboard"></i>我的收入<i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="my-benefit" class="collapse">
                        <li><a class="sidebar-item" href="/partner-data/gain">游戏收入</a></li>
                        <li><a class="sidebar-item" href="/partner-data/cps-gain">cps收入</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper">
        <div class="container-fluid"><?= $content ?></div><!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<?php echo backend\library\widgets\WidgetsUtils::getFooter();?>
</body>

</html>
