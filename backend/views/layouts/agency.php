<!DOCTYPE html>
<html lang="en">

<head>
	<title>麦广互娱-注册中介</title>
	<?php echo backend\library\widgets\WidgetsUtils::getHeader();?>
 </head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <?php echo backend\library\widgets\WidgetsUtils::getMainMenu('agency');?>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="">
                        <a class="sidebar-item" href="/agency/index"><i class="fa fa-fw fa-dashboard"></i>首页</a>
                    </li>
                    
                    <li class="">
                        <a href="javascript:;" data-toggle="collapse" data-target="#agency"><i class="fa fa-fw fa-dashboard"></i>客户管理<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="agency" class="collapse">
                            <li><a class="sidebar-item" href="/agency/account-list-view">客户列表</a></li>
                            <li><a class="sidebar-item" href="/agency/account-set-view">新增客户</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#profit"><i class="fa fa-fw fa-dashboard"></i>数据中心<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="profit" class="collapse">
                            <li><a class="sidebar-item" href="/agency/profit-account-view">收益列表</a></li>
                        </ul>
                    </li>
                                                            
                     <li class="">
                        <a href="javascript:;" data-toggle="collapse" data-target="#opertools"><i class="fa fa-fw fa-dashboard"></i>运营工具<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="opertools" class="collapse">
                            <li><a class="sidebar-item" href="/agency/stack-view">注册栈查询</a></li>
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

