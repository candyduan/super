<!DOCTYPE html>
<html lang="en">

<head>
    <title>麦广互娱-主动上行</title>
    <?php echo backend\library\widgets\WidgetsUtils::getHeader();?>
 </head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <?php echo backend\library\widgets\WidgetsUtils::getMainMenu('register');?>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="">
                        <a class="sidebar-item" href="/register/index"><i class="fa fa-fw fa-dashboard"></i>首页</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#regchannel"><i class="fa fa-fw fa-dashboard"></i>通道中心<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="regchannel" class="collapse">
                            <li><a class="sidebar-item" href="/register/merchant-view">通道商列表</a></li>
                            <li><a class="sidebar-item" href="/register/channel-view">通道列表</a></li>
                            <li><a class="sidebar-item" href="/register/save-channel-view">添加/编辑通道</a></li>
                            <li><a class="sidebar-item" href="/register/mutex-view">通道组管理</a></li>
                        </ul>
                    </li>
                    
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#profit"><i class="fa fa-fw fa-dashboard"></i>数据中心<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="profit" class="collapse">
                            <li><a class="sidebar-item" href="/register/profit-channel-view">通道收益</a></li>
                        </ul>
                    </li>                                    

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#opertools"><i class="fa fa-fw fa-dashboard"></i>运营工具<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="opertools" class="collapse">
                            <li><a class="sidebar-item" href="/register/order-view">注册订单查询</a></li>
                            <li><a class="sidebar-item" href="/register/order-report-view">注册日志查询</a></li>
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

