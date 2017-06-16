<!DOCTYPE html>
<html lang="en">

<head>
	<title>麦广互娱-支付SDK</title>
	<?php echo backend\library\widgets\WidgetsUtils::getHeader();?>
 </head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <?php echo backend\library\widgets\WidgetsUtils::getMainMenu('pay');?>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="">
                        <a class="sidebar-item" href="/pay/index"><i class="fa fa-fw fa-dashboard"></i>首页</a>
                    </li>               
                    <li class="">
                        <a href="javascript:;" data-toggle="collapse" data-target="#channel"><i class="fa fa-fw fa-dashboard"></i>通道中心<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="channel" class="collapse">
                        	<li><a class="sidebar-item" href="/pay/channel-cfg-useage">使用说明</a></li>
                            <li><a class="sidebar-item" href="/pay/channel-view">通道配置</a></li>
                        </ul>
                    </li>
                    <li class="">
                        <a href="javascript:;" data-toggle="collapse" data-target="#operate"><i class="fa fa-fw fa-dashboard"></i>运营工具<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="operate" class="collapse">
<!--                             <li><a class="sidebar-item" href="/pay/duty-view">轮回</a></li> -->
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


