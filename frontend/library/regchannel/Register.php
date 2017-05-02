<?php
namespace frontend\library\regchannel;
use common\library\Utils as commonUtils;
use common\models\orm\extend\Province;

class Register{
    public function getDataByRegParamsProperty(){
        //api data
        $data   = array();
        
        //是否需要手机号
        if(commonUtils::isValid($this->_channelCfgRegParamsModel->mobileKey)){
            $data[$this->_channelCfgRegParamsModel->mobileKey]   = $this->_simCardModel->mobile;
        }
        
        //是否需要imsi
        if(commonUtils::isValid($this->_channelCfgRegParamsModel->imsiKey)){
            $data[$this->_channelCfgRegParamsModel->imsiKey] = $this->_simCardModel->imsi;
        }
        
        //是否需要imei
        if(commonUtils::isValid($this->_channelCfgRegParamsModel->imeiKey)){
            $data[$this->_channelCfgRegParamsModel->imeiKey] = $this->_simCardModel->imei;
        }
        
        //是否需要iccid
        if(commonUtils::isValid($this->_channelCfgRegParamsModel->iccidKey)){
            $data[$this->_channelCfgRegParamsModel->iccidKey] = $this->_simCardModel->iccid;
        }
        
        //是否需要ip
        if(commonUtils::isValid($this->_channelCfgRegParamsModel->ipKey)){
            $data[$this->_channelCfgRegParamsModel->ipKey]   = commonUtils::getClientIp();
        }
        
        //是否需要provinceName
        if(commonUtils::isValid($this->_channelCfgRegParamsModel->provinceNameKey)){
            $provinceName       = Province::getNameById($this->_simCardModel->province);
            $provinceName       = str_replace('省', '', $provinceName);
            $provinceName       = str_replace('市', '', $provinceName);
            $data[$this->_channelCfgRegParamsModel->provinceNameKey]   = $provinceName;
        }
        
        //是否有透传参数
        if(commonUtils::isValid($this->_channelCfgRegParamsModel->cpparamKey)){
            $data[$this->_channelCfgRegParamsModel->cpparamKey]     = $this->_regOrderModel->spSign;
        }
        //特殊定制参数
        $customs   = json_decode($this->_channelCfgRegParamsModel->customs,true);
        if(is_array($customs) && count($customs) > 0){
            foreach ($customs as $custom){
                $data[$custom['key']] = $custom['value'];
            }
        }
        //是否有省份映射
        if(commonUtils::isValid($this->_channelCfgRegParamsModel->provinceMapKey)){
            $opid   = 0;
            $provinceMaps    = json_decode($this->_channelCfgRegParamsModel->provinceMap,true);
            if(is_array($provinceMaps) && count($provinceMaps) > 0){
                foreach ($provinceMaps as $provinceMap){
                    if($provinceMap['key'] == $this->_simCardModel->province){
                        $opid   = $provinceMap['value'];
                    }
                }
            }
            $data[$this->_channelCfgRegParamsModel->provinceMapKey] = $opid;
        }
        //是否需要流水号
        if(commonUtils::isValid($this->_channelCfgRegParamsModel->linkIdKey)){
            $linkId = time().$this->_simCardModel->id;
            $data[$this->_channelCfgRegParamsModel->linkIdKey] = $linkId;
        }
        return $data;
    }
}