<?php
namespace backend\library\widgets;
use common\models\orm\extend\Channel;
use common\library\Utils;
use common\models\orm\extend\ChannelCfgPaySign;
use common\library\Constant;

class PayCfgWidgets{
    public static function getCfgPayParamsWidget($payParamsModel){
        $mobileKey  = '';
        $imeiKey    = '';
        $imsiKey    = '';
        $iccidKey   = '';
        $ipKey      = '';
        $feeKey     = '';
        $feeUnitFen      = '';
        $feeUnitYuan     = '';
        $feeCodeKey      = '';
        $feePackages     = '';
        $customs         = '';
        $provinceMap     = '';
        $cpparamKey      = '';
        $cpparamPrefix   = '';
        $appNameKey     = '';
        $goodNameKey    = '';
        $provinceNameKey    = '';
        $provinceMapKey     = '';
        $linkIdKey          = '';
        $timestampKey       = '';
        $signKey            = '';        
        $signParameters     = '';
        
        if($payParamsModel){
            $mobileKey  = $payParamsModel->mobileKey;
            $imeiKey    = $payParamsModel->imeiKey;
            $imsiKey    = $payParamsModel->imsiKey;
            $iccidKey   = $payParamsModel->iccidKey;
            $ipKey      = $payParamsModel->ipKey;
            $feeKey     = $payParamsModel->feeKey;
            $feeCodeKey = $payParamsModel->feeCodeKey;
            $feePackages    = $payParamsModel->feePackages;
            $customs        = $payParamsModel->customs;
            $provinceMap    = $payParamsModel->provinceMap;
            if($payParamsModel->feeUnit == '1'){
                $feeUnitFen     =  'selected="selected"';
            }elseif ($payParamsModel->feeUnit == "2"){
                $feeUnitYuan     =  'selected="selected"';
            }
    
            $cpparamKey     = $payParamsModel->cpparamKey;
            $cpparamPrefix  = $payParamsModel->cpparamPrefix;
            $appNameKey     = $payParamsModel->appNameKey;
            $goodNameKey    = $payParamsModel->goodNameKey;
            $provinceNameKey    = $payParamsModel->provinceNameKey;
            $provinceMapKey     = $payParamsModel->provinceMapKey;
            $linkIdKey          = $payParamsModel->linkIdKey;
            $timestampKey       = $payParamsModel->timestampKey;
            $signKey            = $payParamsModel->signKey;
            
            $paySignModel   = ChannelCfgPaySign::findByChannelId($payParamsModel->channelId);
            if($paySignModel){
                $signParameters = $paySignModel->parameters;
            
                switch ($paySignModel->method){
                    case Constant::PAY_SIGN_METHOD_MD5NKEY:
                        $signMd5NKey            = 'selected="selected"';
                        $signMd5YKeyIncEmpty    = '';
                        $signMd5YKeyBarEmpty    = '';                       
                        break;
                    case Constant::PAY_SIGN_METHOD_MD5YKEY_INCLUDE_EMPTY_KEY:
                        $signMd5NKey            = '';
                        $signMd5YKeyIncEmpty    = 'selected="selected"';
                        $signMd5YKeyBarEmpty    = '';             
                        break;
                    case Constant::PAY_SIGN_METHOD_MD5YKEY_BARRING_EMPTY_KEY:
                        $signMd5NKey            = '';
                        $signMd5YKeyIncEmpty    = '';
                        $signMd5YKeyBarEmpty    = 'selected="selected"';
                        break;
                    default:
                        $signMd5NKey            = '';
                        $signMd5YKeyIncEmpty    = '';
                        $signMd5YKeyBarEmpty    = '';
                }
            
                switch ($paySignModel->resHandle){
                    case Constant::PAY_SIGN_RES_NORMAL:
                        $signResHandleNormal  = 'selected="selected"';
                        $signResHandleLower   = '';
                        $signResHandleUpper   = '';
                        break;
                    case Constant::PAY_SIGN_RES_LOWER:
                        $signResHandleNormal  = '';
                        $signResHandleLower   = 'selected="selected"';
                        $signResHandleUpper   = '';
                        break;
                    case Constant::PAY_SIGN_RES_UPPER:
                        $signResHandleNormal  = '';
                        $signResHandleLower   = '';
                        $signResHandleUpper   = 'selected="selected"';
                        break;
                    default:
                        $signResHandleNormal  = '';
                        $signResHandleLower   = '';
                        $signResHandleUpper   = '';
                }
            }
        }
        $widget = '
            <div class="pay_param" api="1">
<hr>
<span class="data_store_params"  fee_package=\''.$feePackages.'\' customs=\''.$customs.'\' province_map=\''.$provinceMap.'\'></span>
	<h1 class="header-1">支付请求参数设置</h1>
	<div class="pay_param_content">
    	<div class="form-horizontal">
              <div class="form-group">
                <label for="param_mobile_key" class="col-xs-2 control-label">手机号Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="param_mobile_key" placeholder="..." value="'.$mobileKey.'">
                </div>
              </div>
 
               <div class="form-group">
                <label for="param_imsi_key" class="col-xs-2 control-label">IMSI Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="param_imsi_key" placeholder="..." value="'.$imsiKey.'">
                </div>
              </div>
                      
              <div class="form-group">
                <label for="param_imei_key" class="col-xs-2 control-label">IMEI Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="param_imei_key" placeholder="..." value="'.$imeiKey.'">
                </div>
              </div>
    
               <div class="form-group">
                <label for="param_imsi_key" class="col-xs-2 control-label">ICCID Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="param_iccid_key" placeholder="..." value="'.$iccidKey.'">
                </div>
              </div>
    
               <div class="form-group">
                <label for="param_ip_key" class="col-xs-2 control-label">IP Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="param_ip_key" placeholder="..." value="'.$ipKey.'">
                </div>
              </div>
    
               <div class="form-group">
                <label for="param_appname_key" class="col-xs-2 control-label">应用名称Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="param_appname_key" placeholder="..." value="'.$appNameKey.'">
                </div>
              </div>
    
               <div class="form-group">
                <label for="param_goodname_key" class="col-xs-2 control-label">道具名称Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="param_goodname_key" placeholder="..." value="'.$goodNameKey.'">
                </div>
              </div>
    
               <div class="form-group">
                <label for="param_provincename_key" class="col-xs-2 control-label">省份名称Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="param_provincename_key" placeholder="..." value="'.$provinceNameKey.'">
                </div>
              </div>
    
    
               <div class="form-group">
                <label for="param_linkid_key" class="col-xs-2 control-label">流水号Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="param_linkid_key" placeholder="..." value="'.$linkIdKey.'">
                </div>
              </div>

               <div class="form-group">
                <label for="param_timestamp_key" class="col-xs-2 control-label">时间戳Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="param_timestamp_key" placeholder="..." value="'.$timestampKey.'">
                </div>
              </div>
                      
              <div class="form-group">
                <label for="param_cpparam_key" class="col-xs-2 control-label">透传参数Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="param_cpparam_key" placeholder="..." value="'.$cpparamKey.'">
                </div>
              </div>
    
              <div class="form-group">
                <label for="param_cpparam_prefix" class="col-xs-2 control-label">透传参数前缀</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="param_cpparam_prefix" placeholder="..." value="'.$cpparamPrefix.'">
                </div>
              </div>
    
               <div class="form-group">
                <label for="param_fee_key" class="col-xs-2 control-label">价格Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="param_fee_key" placeholder="..." value="'.$feeKey.'">
                </div>
              </div>
    
               <div class="form-group">
                <label for="param_fee_unit" class="col-xs-2 control-label">价格单位</label>
                <div class="col-xs-10">
                        <select id="param_fee_unit" class="form-control">
                          <option value ="1" '.$feeUnitFen.'>分</option>
                          <option value ="2" '.$feeUnitYuan.'>元</option>
                        </select>
    
                </div>
              </div>
    
    
               <div class="form-group">
                <label for="param_feecode_key" class="col-xs-2 control-label">价格编码Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="param_feecode_key" placeholder="..." value="'.$feeCodeKey.'">
                </div>
              </div>
    
              <div class="form-group">
                <label for="param_fee_packages" class="col-xs-2 control-label">价格编码</label>
                <div class="col-xs-10">
                	<button id="param_fee_packages" class="btn btn-block btn-default btn_param_fee_packages">点击添加</button>
                </div>
              </div>
    
              <div class="form-group">
                <label for="param_customs" class="col-xs-2 control-label">定制参数</label>
                <div class="col-xs-10">
                	<button id="param_customs" class="btn btn-block btn-default btn_param_customs">点击添加</button>
                </div>
              </div>
    
    
               <div class="form-group">
                <label for="param_provincemap_key" class="col-xs-2 control-label">省份映射Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="param_provincemap_key" placeholder="..." value="'.$provinceMapKey.'">
                </div>
              </div>
    
              <div class="form-group">
                <label for="param_province_map" class="col-xs-2 control-label">省份映射</label>
                <div class="col-xs-10">
                	<button id="param_province_map" class="btn btn-block btn-default btn_param_province_map">点击添加</button>
                </div>
              </div>

               <div class="form-group">
                <label for="param_sign_key" class="col-xs-2 control-label">签名Key</label>
                <div class="col-xs-8">
                  <input type="text" class="form-control" id="param_sign_key" placeholder="..." value="'.$signKey.'">
                </div>
                <div class="col-xs-2">
                  <button class="btn btn-block btn-default btn-signshow">计算方法</button>
                </div>
              </div>

               <div class="form-group sign_logic">
                <label for="param_sign_params" class="col-xs-2 control-label">签名参数</label>
                <div class="col-xs-8">
                  <input type="text" class="form-control" id="param_sign_params" placeholder="依次按顺序输入签名参数，逗号隔开，固定值前输入@" value="'.$signParameters.'">
                </div>
                <div class="col-xs-2">
                      <button class="btn btn-block btn-default btn-sign-params-sort" >排序</button>
                </div>
              </div>

               <div class="form-group sign_logic">
                <label for="param_sign_method" class="col-xs-2 control-label">签名算法</label>
                <div class="col-xs-10">
                        <select id="param_sign_method" class="form-control">
                          <option value ="1" '.$signMd5NKey.'>MD5---参数key不参与运算</option>
                          <option value ="2" '.$signMd5YKeyIncEmpty.'>MD5---参数key参与运算（包括空值Key）</option>
                          <option value ="3" '.$signMd5YKeyBarEmpty.'>MD5---参数key参与运算（不包括空值Key）</option>
                        </select>    
                </div>
              </div>

               <div class="form-group sign_logic">
                <label for="param_sign_reshandle" class="col-xs-2 control-label">签名结果</label>
                <div class="col-xs-10">
                        <select id="param_sign_reshandle" class="form-control">
                          <option value ="0" '.$signResHandleNormal.'>不处理</option>
                          <option value ="1" '.$signResHandleLower.'>转小写</option>
                          <option value ="2" '.$signResHandleUpper.'>转大写</option>
                        </select>    
                </div>
              </div>
                              
              <div class="form-group">
                <div class="col-xs-10 col-xs-offset-2">
                  <button id="param_save" class="btn btn-default">保存</button>
                </div>
              </div>
    
    
    
        </div>
    </div>
    
    
    <!-- modal -->
    <div class="modal fade custom_package_modal" tabindex="-1" role="dialog" modal_type="">
      <div class="modal-dialog custom_package_modal_dialog" role="document">
        <div class="modal-content custom_package_modal_content">
          <div class="modal-header custom_package_modal_header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title custom_package_modal_title">...</h4>
          </div>
          <div class="modal-body custom_package_modal_body">
                <div class="row row1 custom_package_kv">
                	<div class="col-xs-6"><input type="text" class="form-control custom_package_modal_key" placeholder="key" value=""></div>
                	<div class="col-xs-6"><input type="text" class="form-control custom_package_modal_value" placeholder="value" value=""></div>
                </div>
                <div class="row row2 custom_package_kv">
                	<div class="col-xs-6"><input type="text" class="form-control custom_package_modal_key" placeholder="key" value=""></div>
                	<div class="col-xs-6"><input type="text" class="form-control custom_package_modal_value" placeholder="value" value=""></div>
                </div>
                <div class="row row3 custom_package_kv">
                	<div class="col-xs-6"><input type="text" class="form-control custom_package_modal_key" placeholder="key" value=""></div>
                	<div class="col-xs-6"><input type="text" class="form-control custom_package_modal_value" placeholder="value" value=""></div>
                </div>
                <div class="row row4 custom_package_kv">
                	<div class="col-xs-6"><input type="text" class="form-control custom_package_modal_key" placeholder="key" value=""></div>
                	<div class="col-xs-6"><input type="text" class="form-control custom_package_modal_value" placeholder="value" value=""></div>
                </div>
                <div class="row row5 custom_package_kv">
                	<div class="col-xs-6"><input type="text" class="form-control custom_package_modal_key" placeholder="key" value=""></div>
                	<div class="col-xs-6"><input type="text" class="form-control custom_package_modal_value" placeholder="value" value=""></div>
                </div>
                <div class="row row6 custom_package_kv">
                	<div class="col-xs-6"><input type="text" class="form-control custom_package_modal_key" placeholder="key" value=""></div>
                	<div class="col-xs-6"><input type="text" class="form-control custom_package_modal_value" placeholder="value" value=""></div>
                </div>
                <div class="row row7 custom_package_kv">
                	<div class="col-xs-6"><input type="text" class="form-control custom_package_modal_key" placeholder="key" value=""></div>
                	<div class="col-xs-6"><input type="text" class="form-control custom_package_modal_value" placeholder="value" value=""></div>
                </div>
                <div class="row row8 custom_package_kv">
                	<div class="col-xs-6"><input type="text" class="form-control custom_package_modal_key" placeholder="key" value=""></div>
                	<div class="col-xs-6"><input type="text" class="form-control custom_package_modal_value" placeholder="value" value=""></div>
                </div>
                <div class="row row9 custom_package_kv">
                	<div class="col-xs-6"><input type="text" class="form-control custom_package_modal_key" placeholder="key" value=""></div>
                	<div class="col-xs-6"><input type="text" class="form-control custom_package_modal_value" placeholder="value" value=""></div>
                </div>
                <div class="row row10 custom_package_kv">
                	<div class="col-xs-6"><input type="text" class="form-control custom_package_modal_key" placeholder="key" value=""></div>
                	<div class="col-xs-6"><input type="text" class="form-control custom_package_modal_value" placeholder="value" value=""></div>
                </div>
          </div>
          <div class="modal-footer custom_package_modal_footer">
            <button type="button" class="btn btn-primary btn_custom_package_kv">保存</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
    
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
    
    
    <!-- modal -->
    <div class="modal fade province_map_modal" tabindex="-1" role="dialog" modal_type="">
      <div class="modal-dialog" role="document">
        <div class="modal-content province_map_modal_content">
          <div class="modal-header province_map_modal_header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title province_map_modal_title">...</h4>
          </div>
          <div class="modal-body province_map_modal_body">
                <div class="province_map_kv row">
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">内蒙古</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="1"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">贵州省</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="2"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">江苏省</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="3"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">安徽省</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="4"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">山东省</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="5"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">黑龙江</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="6"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">陕西省</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="7"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">广东省</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="8"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">广西省</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="9"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">河南省</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="10"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">宁夏</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="11"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">云南省</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="12"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">湖北省</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="13"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">西藏</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="14"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">河北省</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="15"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">福建省</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="16"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">甘肃省</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="17"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">浙江省</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="18"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">湖南省</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="19"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">山西省</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="20"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">江西省</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="21"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">四川省</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="22"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">新疆</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="23"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">吉林省</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="24"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">辽宁省</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="25"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">青海省</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="26"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">上海市</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="28"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">海南省</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="29"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">北京市</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="30"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">天津市</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="31"></div></div>
                        <div class="province_map_item col-xs-6"><label class="col-xs-4 control-label">重庆市</label><div class="col-xs-8"><input type="text" class="col-xs-12 form-control province_map_modal_value" placeholder="SP省份ID" value="" province_id="32"></div></div>
    
    
    
                </div>
          </div>
          <div class="modal-footer province_map_modal_footer">
            <button type="button" class="btn btn-primary btn_province_map_kv">保存</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
    
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
</div>
    
    
<script>
$(document).ready(function(){
        $(".btn-signshow").click(function(){
            if($(".sign_logic").css("display") == "none"){
                $(".sign_logic").css("display","block");
            }else{
                $(".sign_logic").css("display","none");
            }
        });
        $(".btn-sign-params-sort").click(function(){
            var signParamsStr = $("#param_sign_params").val();
            signParamsStr  = signParamsStr.replace(/，/g,",");
         	var signParamsArr = signParamsStr.split(",");
         	signParamsArr.sort();
         	signParamsStr = signParamsArr.join(",");
         	$("#param_sign_params").val(signParamsStr);
        });                      
        $(".btn_param_fee_packages").click(function(){
                $(".custom_package_modal_title").html("价格编码【key为价格，单位分】");
                $(".custom_package_modal").attr("modal_type","1");
                $(".custom_package_modal").modal("toggle");
    
                var packageStr  = $(".data_store_params").attr("fee_package");
    
                if(packageStr != ""){
                        var packageArr  = JSON.parse(packageStr);
                        $.each($(".custom_package_kv"),function(zkey,zval){
                                if(zkey < packageArr.length){
                                        $(zval).find(".custom_package_modal_key").val(packageArr[zkey].key);
                                        $(zval).find(".custom_package_modal_value").val(packageArr[zkey].value);
                                }else{
                                        $(zval).find(".custom_package_modal_key").val("");
                                        $(zval).find(".custom_package_modal_value").val("");
                                }
                        });
                }else{
                     $(".custom_package_modal_key").val("");
                     $(".custom_package_modal_value").val("");
                }
        });
    
        $(".btn_param_customs").click(function(){
                $(".custom_package_modal_title").html("定制参数");
                $(".custom_package_modal").attr("modal_type","2");
                $(".custom_package_modal").modal("toggle");
    
                var customsStr  = $(".data_store_params").attr("customs");
                if(customsStr != ""){
                        var packageArr  = JSON.parse(customsStr);
                        $.each($(".custom_package_kv"),function(zkey,zval){
                                if(zkey < packageArr.length){
                                        $(zval).find(".custom_package_modal_key").val(packageArr[zkey].key);
                                        $(zval).find(".custom_package_modal_value").val(packageArr[zkey].value);
                                }else{
                                        $(zval).find(".custom_package_modal_key").val("");
                                        $(zval).find(".custom_package_modal_value").val("");
                                }
                        });
                }else{
                     $(".custom_package_modal_key").val("");
                     $(".custom_package_modal_value").val("");
                }
    
        });
    
        $(".btn_param_province_map").click(function(){//zzzzzzzzzzzzzz
                $(".province_map_modal_title").html("省份映射");
                $(".province_map_modal").attr("modal_type","2");
                $(".province_map_modal").modal("toggle");
    
                var provinceMapStr  = $(".data_store_params").attr("province_map");
                if(provinceMapStr != ""){
                        var provinceMapArr  = JSON.parse(provinceMapStr);
                              console.log(provinceMapArr);
                        $.each($(".province_map_modal_value"),function(zkey,zval){
                              for(var provinceMapKey in provinceMapArr){
                                if($(this).attr("province_id") == provinceMapArr[provinceMapKey].key){
                                    $(this).val(provinceMapArr[provinceMapKey].value);
                                }
                              }
                        });
                }else{
                     $(".province_map_modal_key").val("");
                     $(".province_map_modal_value").val("");
                }
    
        });
    
    
        $(".btn_custom_package_kv").click(function(){
                var cpkv        = new Array();
                $.each($(".custom_package_kv"),function(key,val){
                        var inputKey    = $(val).find(".custom_package_modal_key").val();
                        var inputValue  = $(val).find(".custom_package_modal_value").val();
                        if(inputKey != "" && inputValue != ""){
                                var item        = {
                                                "key":inputKey,
                                                "value":inputValue,
                                                };
                                cpkv.push(item);
                        }
                });
                var cpkvStr = JSON.stringify(cpkv);
                if($(".custom_package_modal").attr("modal_type") == "1"){//价格编码
                        $(".data_store_params").attr("fee_package",cpkvStr);
                }else{//定制参数
                        $(".data_store_params").attr("customs",cpkvStr);
                }
    
                $(".custom_package_modal").modal("hide");
        });
    
        $(".btn_province_map_kv").click(function(){//zzzzzzzzzzzzz
                var pmkv        = new Array();
                $.each($(".province_map_modal_value"),function(key,val){
                        var inputMpid  = $(val).attr("province_id"); //my province id
                        var inputOpid  = $(val).val(); //other province id
                        if(inputMpid != "" && inputOpid != ""){
                                var item        = {
                                                "key":inputMpid,
                                                "value":inputOpid,
                                                };
                                pmkv.push(item);
                        }
                });
                var pmkvStr = JSON.stringify(pmkv);
                $(".data_store_params").attr("province_map",pmkvStr);
    
                $(".province_map_modal").modal("hide");
        });
    
    
        $("#param_save").click(function(){
                //url
                var url = "/pay/cfg-pay-params-save";
                //data
                var data =   "chid="+$(".data_store_common").attr("chid")
                        +"&useapi="+$(".data_store_common").attr("useapi")
                        +"&mobileKey="+$("#param_mobile_key").val()
                        +"&imeiKey="+$("#param_imei_key").val()
                        +"&iccidKey="+$("#param_iccid_key").val()
                        +"&imsiKey="+$("#param_imsi_key").val()
                        +"&ipKey="+$("#param_ip_key").val()
                        +"&feeKey="+$("#param_fee_key").val()
                        +"&feeUnit="+$("#param_fee_unit").val()
                        +"&feeCodeKey="+$("#param_feecode_key").val()
                        +"&feePackages="+$(".data_store_params").attr("fee_package")
                        +"&customs="+$(".data_store_params").attr("customs")
                        +"&provinceMap="+$(".data_store_params").attr("province_map")
                        +"&provinceMapKey="+$("#param_provincemap_key").val()
                        +"&cpparamKey="+$("#param_cpparam_key").val()
                        +"&cpparamPrefix="+$("#param_cpparam_prefix").val()
                        +"&appNameKey="+$("#param_appname_key").val()
                        +"&goodNameKey="+$("#param_goodname_key").val()
                        +"&linkIdKey="+$("#param_linkid_key").val()
                        +"&timestampKey="+$("#param_timestamp_key").val()                        
                        +"&provinceNameKey="+$("#param_provincename_key").val()
                        +"&signKey="+$("#param_sign_key").val()
                        +"&signMethod="+$("#param_sign_method").val()
                        +"&signParameters="+$("#param_sign_params").val()
                        +"&signResHandle="+$("#param_sign_reshandle").val();
    
                //succFunc
                var succFunc    = function(resJson){
                                if(parseInt(resJson.resultCode) == 1){//成功
                                        Utils.tipBar("success","保存成功",resJson.msg); 
                                }else{//失败
                                        Utils.tipBar("error","保存失败",resJson.msg);
                                }
                };
                Utils.ajax(url,data,succFunc);
        });
});
</script>
            ';
        return $widget;
    }
    
    
    public static function getCfgDataSyncWidget($channelCfgSyncModel){
        $succKey         = '';
        $succValue       = '';
        $cpparamKey      = '';
        $mobileKey       = '';
        $feeKey          = '';
        $feeUnitFen      = '';
        $feeUnitYuan     = '';
        $succReturn      = '';
        $feeFixed        = '';
        $cmdKey          = '';
        if($channelCfgSyncModel){
            $succKey    = $channelCfgSyncModel->succKey;
            $succValue  = $channelCfgSyncModel->succValue;
            $cpparamKey = $channelCfgSyncModel->cpparamKey;
            $mobileKey  = $channelCfgSyncModel->mobileKey;
            $feeKey     = $channelCfgSyncModel->feeKey;
    
            if($channelCfgSyncModel->feeUnit == "1"){//分
                $feeUnitFen     =  'selected="selected"';
            }elseif ($channelCfgSyncModel->feeUnit == "2"){//元
                $feeUnitYuan    = 'selected="selected"';
            }
    
            $succReturn = $channelCfgSyncModel->succReturn;
            $feeFixed   = $channelCfgSyncModel->feeFixed;
            $cmdKey     = $channelCfgSyncModel->cmdKey;
        }
        if($succReturn == ''){
            $succReturn = 'ok';
        }
    
        $widget = '
<div class="data_sync">
<hr>
	<h1 class="header-1">数据同步</h1>
	<div class="data_sync_content">
    	<div class="form-horizontal">
              <div class="form-group">
                <label for="sync_succ_key" class="col-xs-2 control-label">成功Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="sync_succ_key" placeholder="..." value="'.$succKey.'">
                </div>
              </div>
    
    
              <div class="form-group">
                <label for="sync_succ_value" class="col-xs-2 control-label">成功值</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="sync_succ_value" placeholder="..." value="'.$succValue.'">
                </div>
              </div>
    
              <div class="form-group">
                <label for="sync_cpparam_key" class="col-xs-2 control-label">透传参数Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="sync_cpparam_key" placeholder="..." value="'.$cpparamKey.'">
                </div>
              </div>
    
              <div class="form-group">
                <label for="sync_mobile_key" class="col-xs-2 control-label">手机号Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="sync_mobile_key" placeholder="..." value="'.$mobileKey.'">
                </div>
              </div>
    
              <div class="form-group">
                <label for="sync_fee_key" class="col-xs-2 control-label">价格Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="sync_fee_key" placeholder="..." value="'.$feeKey.'">
                </div>
              </div>
    
               <div class="form-group">
                <label for="sync_fee_unit" class="col-xs-2 control-label">价格单位</label>
                <div class="col-xs-10">
                  <select id="sync_fee_unit" class="form-control">
                          <option value ="1" '.$feeUnitFen.'>分</option>
                          <option value ="2" '.$feeUnitYuan.'>元</option>
                  </select>
    
                </div>
              </div>
    
    
              <div class="form-group">
                <label for="sync_feefixed_key" class="col-xs-2 control-label">固定价格</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="sync_feefixed_key" placeholder="如果同步URL没有传递价格，并且该通道价格是固定的，则填写，单位（分）" value="'.$feeFixed.'">
                </div>
              </div>

              <div class="form-group">
                <label for="sync_cmd_key" class="col-xs-2 control-label">指令区分价格Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="sync_cmd_key" placeholder="如果价格是根据指令来进行区分的，则这里填写同步参数中指令的key" value="'.$cmdKey.'">
                </div>
              </div>
                      
              <div class="form-group">
                <label for="sync_succ_return" class="col-xs-2 control-label">成功返回值</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="sync_succ_return" placeholder="ok" value="'.$succReturn.'">
                </div>
              </div>
    
              <div class="form-group">
                <div class="col-xs-10 col-xs-offset-2">
                  <button id="sync_save" class="btn btn-default">保存</button>
                </div>
              </div>
    
    
    
        </div>
    </div>
</div>
    
<script>
$(document).ready(function(){
	$("#sync_save").click(function(){
		//url
		var url = "/pay/cfg-sync-save";
		//data
		var data =  "chid="+$(".data_store_common").attr("chid")
            		+"&useapi="+$(".data_store_common").attr("useapi")
            		+"&succKey="+$("#sync_succ_key").val()
            		+"&succValue="+$("#sync_succ_value").val()
            		+"&cpparamKey="+$("#sync_cpparam_key").val()
                    +"&mobileKey="+$("#sync_mobile_key").val()
            		+"&feeKey="+$("#sync_fee_key").val()
            		+"&feeUnit="+$("#sync_fee_unit").val()
                    +"&cmdKey="+$("#sync_cmd_key").val()
                    +"&feeFixed="+$("#sync_feefixed_key").val()
            		+"&succReturn="+$("#sync_succ_return").val();
		//succFunc
		var succFunc	= function(resJson){
				if(parseInt(resJson.resultCode) == 1){//成功
					Utils.tipBar("success","保存成功",resJson.msg);
				}else{//失败
					Utils.tipBar("error","保存失败",resJson.msg);
				}
		};
		Utils.ajax(url,data,succFunc);
	});
});
</script>
            ';
        return $widget;
    }
    
    
    
    public static function getCfgCommonWidget($channelModel){
        $devTypeName    = Channel::getNameByDevType($channelModel->devType);
        $widget = '
        <span class="data_store_common" chid="'.$channelModel->id.'" dev_type="'.$channelModel->devType.'" useapi="1">['.$channelModel->id.']'.$channelModel->name.'---开发类型:'.Channel::getNameByDevType($channelModel->devType).'</span>
        <hr><p class="cfg-tip">说明：<br>1--->0:文本短信发送。1:base64decode后，二进制短信发送。2:base64decode后，文本短信发送。3:base64encode后，返给客户端，客户端base64decode后，再以二进制短信发送</p>
            ';
        return $widget;
    }
    
    
    public static function getCfgSmtParamsWidget($smtParamsModel){
        $orderIdKey = '';
        $verifyCodeKey  = '';
        $mobileKey  = '';
        $cpparamKey = '';
        $imsiKey    = '';
        $imeiKey    = '';
        $iccidKey   = '';
        $ipKey      = '';
        if($smtParamsModel){
            $orderIdKey     = $smtParamsModel->orderIdKey;
            $verifyCodeKey  = $smtParamsModel->verifyCodeKey;
            $mobileKey      = $smtParamsModel->mobileKey;
            $cpparamKey     = $smtParamsModel->cpparamKey;
            $imsiKey        = $smtParamsModel->imsiKey;
            $imeiKey        = $smtParamsModel->imeiKey;
            $iccidKey       = $smtParamsModel->iccidKey;
            $ipKey          = $smtParamsModel->ipKey;
        }
    
        $widget = '
            <div class="smt_params">
<hr>
	<h2 class="header-1">验证码请求参数设置</h2>
		<div class="smt_params_content">
    		<div class="form-horizontal">
    
    		  <div class="form-group">
                <label for="smt_params_orderidkey" class="col-xs-2 control-label">订单Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="smt_params_orderidkey" placeholder="..." value="'.$orderIdKey.'">
                </div>
              </div>
    
    
              <div class="form-group">
                <label for="smt_params_verifycodekey" class="col-xs-2 control-label">验证码Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="smt_params_verifycodekey" placeholder="..." value="'.$verifyCodeKey.'">
                </div>
              </div>
    
              <div class="form-group">
                <label for="smt_params_mobile_key" class="col-xs-2 control-label">手机号Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="smt_params_mobile_key" placeholder="..." value="'.$mobileKey.'">
                </div>
              </div>

              <div class="form-group">
                <label for="smt_params_cpparam_key" class="col-xs-2 control-label">透传参数Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="smt_params_cpparam_key" placeholder="..." value="'.$cpparamKey.'">
                </div>
              </div>

              <div class="form-group">
                <label for="smt_params_imsiKey" class="col-xs-2 control-label">IMSI Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="smt_params_imsiKey" placeholder="..." value="'.$imsiKey.'">
                </div>
              </div>
 
              <div class="form-group">
                <label for="smt_params_imeiKey" class="col-xs-2 control-label">IMEI Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="smt_params_imeiKey" placeholder="..." value="'.$imeiKey.'">
                </div>
              </div>                      
 
              <div class="form-group">
                <label for="smt_params_iccidKey" class="col-xs-2 control-label">ICCID Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="smt_params_iccidKey" placeholder="..." value="'.$iccidKey.'">
                </div>
              </div>  

              <div class="form-group">
                <label for="smt_params_ipKey" class="col-xs-2 control-label">IP Key</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="smt_params_ipKey" placeholder="..." value="'.$ipKey.'">
                </div>
              </div> 
                      
              <div class="form-group">
                <div class="col-xs-10 col-xs-offset-2">
                  <button id="smt_params_save" class="btn btn-default">保存</button>
                </div>
              </div>
    
    		</div>
		</div>
    
</div>
<script>
$(document).ready(function(){
	$("#smt_params_save").click(function(){
		//url
		var url = "/pay/cfg-smt-params-save";
		//data
		var data	= "chid="+$(".data_store_common").attr("chid")
				     +"&orderIdKey="+$("#smt_params_orderidkey").val()
                     +"&mobileKey="+$("#smt_params_mobile_key").val()
                     +"&cpparamKey="+$("#smt_params_cpparam_key").val()
                     +"&imeiKey="+$("#smt_params_imeiKey").val()
                     +"&imsiKey="+$("#smt_params_imsiKey").val()
                     +"&iccidKey="+$("#smt_params_iccidKey").val()
                     +"&ipKey="+$("#smt_params_ipKey").val()
				     +"&verifyCodeKey="+$("#smt_params_verifycodekey").val();                                            
	     //succFunc
	     var succFunc	= function(resJson){
				if(parseInt(resJson.resultCode) == 1){//成功
					Utils.tipBar("success","保存成功",resJson.msg); 
				}else{//失败
					Utils.tipBar("error","保存失败",resJson.msg);
				}
		  };
		  Utils.ajax(url,data,succFunc);
	});
});
</script>
            ';
        return $widget;
    }
    
    
    
    public static function getCfgOutWidget($outModel){
        $spSignPrefix   = '';
        $url            = '';
        if($outModel){
            $spSignPrefix    = $outModel->spSignPrefix;
            $url             = $outModel->url;
        }
        
        $widget = '
<div class="channel_out">
<hr>
	<h1 class="header-1">代码外放</h1>
	<div class="channel_out_content">
    	<div class="form-horizontal">
    	
              <div class="form-group">
                <label for="channel_out_spSignPrefix" class="col-xs-2 control-label">透传前缀</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="channel_out_spSignPrefix" placeholder="..." value="'.$spSignPrefix.'">
                </div>
              </div>
        
              <div class="form-group">
                <label for="channel_out_url" class="col-xs-2 control-label">外放链接</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="channel_out_url" placeholder="..." value="'.$url.'">
                </div>
              </div>
        
              <div class="form-group">
                <div class="col-xs-10 col-xs-offset-2">
                  <button id="out_save" class="btn btn-default">保存</button>
                </div>
              </div>
                      
        </div>
    </div>
</div>
        
<script>
$(document).ready(function(){
	$("#out_save").click(function(){
		//url
		var url = "/pay/cfg-out-save";
		//data
		var data =  "chid="+$(".data_store_common").attr("chid")
            		+"&spSignPrefix="+$("#channel_out_spSignPrefix").val()
            		+"&url="+$("#channel_out_url").val();
		//succFunc
		var succFunc	= function(resJson){
				if(parseInt(resJson.resultCode) == 1){//成功
					Utils.tipBar("success","保存成功",resJson.msg);
				}else{//失败
					Utils.tipBar("error","保存失败",resJson.msg);
				}
		};
		Utils.ajax(url,data,succFunc);
	});
});
</script>
            ';
        return $widget;
    }

    public static function getCfgSingleDataSyncWidget($channelCfgToSync) {
        $channel        = 0;
        $syncPort       = '';
        $syncCommand    = '';
        if($channelCfgToSync) {
            $channel    = $channelCfgToSync->channelId;
            $channelModel= Channel::findByPk($channel);
            $channelName = $channelModel ? "【{$channel}】{$channelModel->name}" : 0;
            $syncPort   = $channelCfgToSync->port;
            $syncCommand= $channelCfgToSync->command;
        }
        $widget = '
        <div class="channel_out">
<hr>
	<h1 class="header-1">单同步</h1>
	<div class="sync_single_content">
    	<div class="form-horizontal">
    	
              <div class="form-group">
                <label for="sync_port" class="col-xs-2 control-label">同步端口号</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="sync_port" placeholder="..." value="'.$syncPort.'">
                </div>
              </div>
              
              <div class="form-group">
                <label for="sync_command" class="col-xs-2 control-label">同步指令(非固定即填前缀)</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="sync_command" placeholder="..." value="'.$syncCommand.'">
                </div>
              </div>
        
              <div class="form-group">
                <div class="col-xs-10 col-xs-offset-2">
                  <button id="sync_single_save" class="btn btn-default">保存</button>
                </div>
              </div>
                      
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        var jsonList	= '.json_encode(\common\models\orm\extend\Channel::getTypeHeaderChannelList()).';
        Utils.myTypeHeder(jsonList,"channel-f","channel","");
        $("#sync_single_save").click(function(){
            var url = "/pay/cfg-sync-single";
            var data =  "chid="+$(".data_store_common").attr("chid")
                        +"&syncPort="+$("#sync_port").val()
                        +"&syncCommand="+$("#sync_command").val();
            var succFunc	= function(resJson){
                    if(parseInt(resJson.resultCode) == 1){//成功
                        Utils.tipBar("success","保存成功",resJson.msg); 
                    }else{//失败
                        Utils.tipBar("error","保存失败",resJson.msg);
                    }
            };
            Utils.ajax(url,data,succFunc);
        });
    });
</script>
        ';
        return $widget;
    }
}