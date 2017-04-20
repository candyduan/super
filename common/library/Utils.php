<?php
namespace common\library;
class Utils{
    public static function jsonOut($out){
        \Yii::$app->getResponse()->format = \Yii\web\Response::FORMAT_JSON;
        \Yii::$app->getResponse()->data = self::arrFormat($out);
        \Yii::$app->getResponse()->send();
    }
    
    protected static function arrFormat($arr){
        if(is_array($arr)){
            foreach ($arr as $k=>$v){
                $arr[$k] = self::arrFormat($arr[$k]);
            }
        }else{
            $arr = (string) $arr;
        }
        return $arr;
    }
    
    public static function zsCurl($url =  NULL){
        if(empty($url)){
            return false;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
    
    public static function getParam($key,$default = ''){
        $request    = \Yii::$app->getRequest();
        $value      = $request->get($key);
        if(!self::isValid($value)){
            $value  = $request->post($key);
        }
        if(!self::isValid($value)){
            $value  = $default;
        }
        return $value;
    }
    
    /*
     * 判断字符串是否有效
     * @param string
     * @return true is valid,false is not valid
     */
    public static function isValid($str){
        if(empty($str)){
            $flag  = false;
        }else{
            $flag  = true;
        }
        return $flag;
    }
    
}