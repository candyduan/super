<?php
namespace backend\web\util;
use Yii;
use yii\base\ErrorException;

class MyCache
{
    public static function setCache($key, $val, $time=86400000){
        $res = false;
        try {
            Yii::$app->cache->set($key, $val,$time);
            $res = true;
        } catch (ErrorException $e) {}
        return $res;
    }

    public static function fetchCache($key, $toArray=false){
        $res = array();
        try {
            $res = Yii::$app->cache->get($key);
            if ($toArray) {
                $res = json_decode($res, TRUE);
            }
        } catch (ErrorException $e) {}
        return $res;
    }
}