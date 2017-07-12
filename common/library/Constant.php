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
    const RESULT_CODE_NONE    = 0;
    const RESULT_CODE_SUCC  = 1;
    const RESULT_CODE_SYSTEM_BUSY   = 5;
    const RESULT_CODE_AUTH_FAIL     = 6;
    const RESULT_CODE_PARAMS_ERR    = 255;
    
    
    /*
     * 返回结果消息
     */
    const RESULT_MSG_NONE     = '未找到对应的数据';
    const RESULT_MSG_NOMORE   = '没有更多了';
    const RESULT_MSG_SUCC     = 'success';
    const RESULT_MSG_SYSTEM_BUSY    = '系统异常，请稍后重试！';
    const RESULT_MSG_AUTH_FAIL     = '鉴权失败';
    const RESULT_MSG_PARAMS_ERR     = '参数异常';
    /*
     * 任务类型
     */
    const TASK_SEND_MESSAGE = 1;
    const TASK_HTTP_REQUEST = 2;
    const TASK_BLOCK_MESSAGE= 3;
    
    
    /*
     * 域名
     */
    const DOMAIN_REGISTER   = 'paytest1.maimob.net';
    //const DOMAIN_REGISTER_SYNC   = 'http://data.maimob.cn';//真服
    const DOMAIN_REGISTER_SYNC   = 'http://supertest.maimob.net:8082';//测服
    
    
    /*
     * 验证码提交方式
     */
    const SUBMIT_SERVER     = 1;
    const SUBMIT_CLIENT     = 2;

    /*
     * 融合SDK
     */
    const BELONG_SDK     = 1;

    /*
     * 内容商
     */
    const PARTNER_ONLY    = 1;
    const PARTNER_CP      = 2;
    const PARTNER_BOTH    = 3;
    
    /*
     * http 请求方式
     */
    const HTTP_GET       = 1;
    const HTTP_POST_KV   = 2;
    const HTTP_POST_JSON = 3;
    const HTTP_POST_XML  = 4;  
    
    
    /*
     * 支付签名方式
     */
    const PAY_SIGN_METHOD_MD5NKEY                     = 1;
    const PAY_SIGN_METHOD_MD5YKEY_INCLUDE_EMPTY_KEY   = 2;
    const PAY_SIGN_METHOD_MD5YKEY_BARRING_EMPTY_KEY   = 3;
    /*
     * 签名结果处理
     */
    const PAY_SIGN_RES_NORMAL   = 0;
    const PAY_SIGN_RES_LOWER    = 1;
    const PAY_SIGN_RES_UPPER    = 2;
    
    
    const CACHE_PREFIX  = 'pre_';
}