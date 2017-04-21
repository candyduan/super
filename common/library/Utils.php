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
    
    
    
    public static function parseRequestContentToArray($postContent){
        $res = array();
        if (preg_match("/(\d).*/", $postContent, $mt)) {
            $headerLength 	= intval($mt[1]);
            $bodyStr 		= substr($postContent, $headerLength+1);
            self::log(base64_decode($bodyStr));
            $kvArr			= explode('&', base64_decode($bodyStr));
            if ($kvArr) {
                foreach ($kvArr as $kvStr) {
                    if (preg_match('/(.*)=(.*)/', $kvStr, $kvMT)) {
                        $res[$kvMT[1]] = urldecode($kvMT[2]);
                    }
                }
            }
        }
        return $res;
    }
    
    public static function postParamsValid($postContent){
        $msa 			= isset($postContent['msa']) ? $postContent['msa'] : '';
        $mediaSign 		= isset($postContent['cha']) ? $postContent['cha'] : '';
        $versionCode 	= isset($postContent['ver']) ? $postContent['ver'] : '';
        $tp				= isset($postContent['tp']) ? $postContent['tp'] : '';
        $sign 			= isset($postContent['sign']) ? $postContent['sign'] : '';
        return base64_encode(md5($msa . $mediaSign . $versionCode . $tp . MAI_SEC_KEY)) == $sign ? true : false;
    }
    
    public static function log($contents){
        $file   = '/tmp/super.log';
        $handle = fopen($file, 'a+');
        fwrite($handle, $contents."\n");
        fclose($handle);
    }
    
}