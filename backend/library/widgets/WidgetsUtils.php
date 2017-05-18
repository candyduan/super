<?php
namespace backend\library\widgets;
class WidgetsUtils{
    public static function getMainMenu(){
        $str = '
                <a class="navbar-brand" style="font-size:18px;" href="http://master.maimob.cn/index.php/admin/" target="_blank">支付SDK</a>
                <a class="navbar-brand" style="font-size:18px;" href="/site/index">融合SDK</a>
                <a class="navbar-brand" style="font-size:18px;" href="/register/index">主动上行</a>
                <a class="navbar-brand" style="font-size:18px;" href="/agency/index">注册中介</a>
            ';
        return $str;
    }
}