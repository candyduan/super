<?php
namespace common\library;
use yii\helpers\ArrayHelper;
use yii;
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
    
    public static function asyncRequest($host,$url){
        if(stristr($url, '?')){
            $url = $url.'&inner=1';
        }else{
            $url = $url.'?inner=1';
        }
        $fp = fsockopen($host,80,$errno,$errstr,30);
        if(!$fp){
            Utils::log('async error no:'.$errno.' error msg:'.$errstr);
        }else{
//             stream_set_blocking($fp,0); //开启非阻塞模式
//             stream_set_timeout($fp, 3); //设置超时时间（s）
            $out = "GET $url HTTP/1.1\r\n";
            $out .= "Host: $host\r\n";
            $out .= "Connection: Close\r\n\r\n";
            fwrite($fp, $out);
            usleep(300000); //等待300ms
            fclose($fp);
        }
    }
    
    public static function getProviderName($provider){
        switch ($provider){
            case 1:
                return '移动';
            case 2:
                return '联通';
            case 3:
                return '电信';
            default:
                return '未知';
        }
    }
    public static function getFrontendParam($key,$default = ''){
        $request    = \Yii::$app->getRequest();
        $value      = $request->get($key);
        if(strlen($value) == 0){
            $value  = $request->post($key);
        }
        if(strlen($value) == 0){
            $value  = $default;
        }
        return $value;
    }
    
    public static function getBackendParam($key,$default = ''){
        $request    = \Yii::$app->getRequest();
        $value      = $request->get($key);
        if(strlen($value) == 0){
            $value  = $request->post($key);
        }
        if(strlen($value) == 0){
            $value  = $default;
        }
        return str_replace(' ', '', $value);
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
    
    public static function getNowTime(){
        return date('Y-m-d H:i:s');
    }
    
    /**
     * 是否是正确的日期
     * yyyy-mm-dd HH:MM:ss 或者 yyyy-mm-dd
     */
    public static function isDate($date){
        if (preg_match("/^\d\d\d\d-\d\d-\d\d\s\d\d\:\d\d:\d\d$/", $date) || preg_match("/^\d\d\d\d-\d\d-\d\d$/", $date)) {
            return true;
        }
        return false;
    }
    
    public static function getClientIp(){
        return (@$_SERVER["HTTP_X_REAL_IP"] != null) ? @$_SERVER["HTTP_X_REAL_IP"] : @$_SERVER["REMOTE_ADDR"];
    }
    
    public static function getValuesFromArray($result,$key,$defaultValue=null){
        $value = null;
        $key = trim($key);
        try {
            if($key === null){
                $value = null;
            }elseif($key === ''){
                $value = null;
            }elseif(substr($key, 0, 1) === '@'){
                $value = substr($key, 1);
            }else{
                $value = ArrayHelper::getValue($result,$key,$defaultValue);
            }
        } catch (\Exception $e) {
            Utils::log($e->getMessage());
        }
        return $value;
    }

    public static function formatNumToSize($number){
        $res = '';
        if (is_numeric($number)) {
            if ($number >= 1073741824) {
                $res = sprintf('%.2f', $number / 1073741824) . 'GB';
            }elseif ($number >= 1048576){
                $res = sprintf('%.2f', $number / 1048576) . 'MB';
            }elseif ($number >= 1024){
                $res = sprintf('%.2f', $number / 1024) . 'KB';
            }else{
                $res = sprintf('%.2f', $number) . 'B';
            }
        }
        return $res;
    }
    public static function isAlpha(){
        if(!strstr($_SERVER['HTTP_HOST'], 'backend')){
            return true;
        }
        return false;
    }

    public static function getBParam($key,$default = NULL){
        $request    = \Yii::$app->getRequest();
        $value      = $request->get($key);
        if(!isset($value)){
            $value  = $request->post($key);
        }
        if(!isset($value)){
            $value  = $default;
        }
        return $value;
    }
    
    /* 是否是ajax请求 */
    public static function isAjaxRequest(){
    	return \Yii::$app->request->isAjax ? true : false;
    }
    
    //下载报表
    public static function DownloadForm($header, $datas ,$filename){
    		$headerStr = implode("\t", $header);
    		$datasLineArr = [];
    		foreach($datas as $data){
    			$datasLineArr[] = implode("\t", $data);
    		}
    		$dataStr = $headerStr."\r\n".implode("\r\n", $datasLineArr);
    		header("Content-type:text/csv");
    		header("Content-Type: application/force-download");
    		header("Content-Disposition: attachment; filename={$filename}-".date('Y-m-d').".csv");
    		header('Expires:0');
    		header('Pragma:public');
    		return "\xFF\xFE".mb_convert_encoding($dataStr, 'UCS-2LE', 'UTF-8' );
    }
    
    
    public static function cacheSet($key, $val, $time=86400000){
        try {
            Yii::$app->cache->set(Constant::CACHE_PREFIX.$key, $val,$time);
            $res = true;
        } catch (\Exception $e) {
            $res = false;
        }
        return $res;
    }
    
    public static function cacheGet($key){
        try {
            $res = Yii::$app->cache->get(Constant::CACHE_PREFIX.$key);
        }catch(\Exception $e) {
            $res    = null;
        }
        return $res;
    }
    
    public static function isAlphaBackend(){
        if(!strstr($_SERVER['HTTP_HOST'], 'backend.maimob.net')){
            return true;
        }else{
            return false;
        }
    }
    
}