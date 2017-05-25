<!DOCTYPE html>
<html lang="en">

<head>
    <title>麦广互娱-融合SDK</title>
    <?php echo backend\library\widgets\WidgetsUtils::getHeader();?>
 </head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <?php echo backend\library\widgets\WidgetsUtils::getMainMenu('sdk');?>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="">
                        <a class="sidebar-item" href="/site/index"><i class="fa fa-fw fa-dashboard"></i>首页</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#sdkadmin"><i class="fa fa-fw fa-dashboard"></i>融合SDK管理<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="sdkadmin" class="collapse">
                            <li><a class="sidebar-item" href="/sdk/index">融合SDK管理</a></li>
                        </ul>
                    </li>
                   <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#sdksort"><i class="fa fa-fw fa-dashboard"></i>SDK计费排序<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="sdksort" class="collapse">
                            <li><a class="sidebar-item" href="/sort/index">SDK计费排序</a></li>
                        </ul>
                    </li>                    

                   <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#sdkcontent"><i class="fa fa-fw fa-dashboard"></i>SDK内容中心<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="sdkcontent" class="collapse">
                            <li><a class="sidebar-item" href="/partner/index">内容商列表</a></li>
                            <li><a class="sidebar-item" href="/app/index">应用列表</a></li>
                            <li><a class="sidebar-item" href="/campaign/index">活动列表</a></li>
                        </ul>
                    </li> 
                    
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#datacontent"><i class="fa fa-fw fa-dashboard"></i>数据中心<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="datacontent" class="collapse">
                            <li><a class="sidebar-item" href="/sdk-pay/index">融合SDK计费转化表</a></li>
                            <li><a class="sidebar-item" href="/package-pay/index">融合SDK渠道收益</a></li>
                            <li><a class="sidebar-item" href="/package-pay/analysis">融合SDK渠道计费分析</a></li>
<!--                             <li><a class="sidebar-item" href="/partner-data/gain">游戏收入</a></li> -->
<!--                             <li><a class="sidebar-item" href="/partner-data/cps-gain">cps收入</a></li> -->
                        </ul>
                    </li> 
 
                   <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#sdkimport"><i class="fa fa-fw fa-dashboard"></i>SDK成果录入<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="sdkimport" class="collapse">
                            <li><a class="sidebar-item" href="/sdk-promotion-result/index">SDK成果录入</a></li>
                        </ul>
                    </li>
<!--                     <li> -->
<!--                         <a href="javascript:;" data-toggle="collapse" data-target="#sdkadminuser"><i class="fa fa-fw fa-dashboard"></i>用户管理<i class="fa fa-fw fa-caret-down"></i></a> -->
<!--                         <ul id="sdkadminuser" class="collapse"> -->
<!--                             <li><a class="sidebar-item" href="/admin-user/index">用户管理</a></li> -->
<!--                             <li><a class="sidebar-item" href="/modify-password/index">修改密码</a></li> -->
<!--                         </ul> -->
<!--                     </li> -->

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

