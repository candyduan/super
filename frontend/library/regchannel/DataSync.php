<?php
namespace frontend\library\regchannel;
use common\models\orm\extend\RegChannel;
use common\models\orm\extend\RegChannelCfgSync;

class DataSync{
    protected $_regChannelModel             = null;
    protected $_regChannelCfgSync           = null;
    protected $_data                        = [];
    
    public function __construct(RegChannel $regChannelModel,array $data){
        $this->_regChannelModel     = $regChannelModel;
        $this->_regChannelCfgSync   = RegChannelCfgSync::findByRcid($regChannelModel->rcid);
        $this->_data                = $data;
    }
    public function sync(){
        //TODO
    }
    
}