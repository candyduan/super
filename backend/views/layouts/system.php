<!DOCTYPE html>
<html lang="en">

<head>
    <title>麦广互娱-系统管理</title>
    <?php echo backend\library\widgets\WidgetsUtils::getHeader();?>
 </head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <?php echo backend\library\widgets\WidgetsUtils::getMainMenu('system');?>
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
                            <li><a class="sidebar-item" href="/out-user/index">客户账户管理</a></li>
                        </ul>
                    </li>                                       
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">
            <div class="container-fluid"><?= $content ?> </div><!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php echo backend\library\widgets\WidgetsUtils::getFooter();?>
</body>

</html>
