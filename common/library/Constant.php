<?php
namespace common\library;
class Constant{
    /*
     * 通道类型
     */
    const CHANNEL_SINGLE    = 1;
    const CHANNEL_DOUBLE    = 2;
    const CHANNEL_SMSP      = 3;
    const CHANNEL_URLP      = 4;
    const CHANNEL_MULTURL   = 5;
    const CHANNEL_MULTSMS   = 6;
    
    /*
     * 响应类型
     */
    const RESP_FMT_JSON     = 1;
    const RESP_FMT_XML      = 2;
    const RESP_FMT_TEXT     = 3;
    
    /*
     * 返回结果状态
     */
    const RESULT_CODE_EXCEPT    = 0;
    const RESULT_CODE_SUCC  = 1;
    const RESULT_CODE_SYSTEM_BUSY   = 5;
    
    /*
     * 任务类型
     */
    const TASK_SEND_MESSAGE = 1;
    const TASK_HTTP_REQUEST = 2;
    const TASK_BLOCK_MESSAGE= 3;
    
    
    /*
     * 域名
     */
    const DOMAIN_REGISTER   = 'frontend.super.com';
}