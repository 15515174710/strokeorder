<?php
namespace mafengwo;
class MSDK_Php_Const{

    /*
     * ======================商家配置==========================
     */
    /*  client_id 12141
        partner_id 12141
        client_secret 301dac91ff103894d65b9d82806f39bf
        ase_key RzHNNevXvXBUsx7MbzHLeYE74DXxyEQN
     */
    const CONFIG_PARTNERID               = 12141;  //合作商家ID(需要商家自行填写)

    const CONFIG_ASEKEY                  = 'RzHNNevXvXBUsx7MbzHLeYE74DXxyEQN';//合作商家秘钥(需要商家自行填写)

    const CONFIG_CLIENT_SECRET           = '301dac91ff103894d65b9d82806f39bf'; //合作商家client_secret(需要商家自行填写)

    /*
     * =======================固定常量=========================
     */
    const GRANT_TYPE                     = 'client_credentials'; //授权类型，固定值

    const MSDK_VERSION                    = '1.0'; //MSDK版本

    const HTTP_RETYR                     = 3;     //接口请求重试次数

    const HTTP_TIMEOUT                   = 5;     //接口请求超时时间

    const PKCS7_BLOCK_SIZE               = 32;    //PKCS7Padding 加密解密填充块长度

    /*
     * ======================订单推送行为=======================
     */

    const ORDER_STATUS_CREATE             = 1;    //创建订单

    const ORDER_STATUS_PAID               = 2;    //支付成功(待出单)

    const ORDER_STATUS_ISSUE              = 3;    //供应商已出单

    const ORDER_STATUS_COMPLETE           = 4;    //订单已完成

    const ORDER_STATUS_CLOSE              = 5;    //订单已关闭

    const ORDER_STATUS_REFUND_APPLY       = 11;    //已申请退款

    const ORDER_STATUS_REFUND_CONFIRM     = 12;    //已确认退款

    const ORDER_STATUS_REFUND_COMPLETE    = 13;    //已完成退款

    const ORDER_STATUS_REFUND_REFUSED     = 14;    //已拒绝退款

    const ORDER_STATUS_TRAVEL_USER        = 20;    //用户填写出行人信息

    const ORDER_STATUS_TRAVEL_AUDIT       = 21;    //商家seller后台更新


    /*
     * ========================返回错误码============================
     */
    const SUCCESS                         = 1000;  //已收到（成功）

    const FAILED                          = 2000;  //失败，会重试


    public static $ORDER_STATUS_MAP = [
        self::ORDER_STATUS_CREATE          => '创建订单',
        self::ORDER_STATUS_PAID            => '支付成功(待出单)',
        self::ORDER_STATUS_ISSUE           => '供应商已出单',
        self::ORDER_STATUS_COMPLETE        => '订单已完成',
        self::ORDER_STATUS_CLOSE           => '订单已关闭',
        self::ORDER_STATUS_REFUND_APPLY    => '已申请退款',
        self::ORDER_STATUS_REFUND_CONFIRM  => '已完成退款',
        self::ORDER_STATUS_REFUND_COMPLETE => '已完成退款',
        self::ORDER_STATUS_REFUND_REFUSED  => '已拒绝退款',
        self::ORDER_STATUS_TRAVEL_USER     => '用户填写出行人信息',
        self::ORDER_STATUS_TRAVEL_AUDIT    => '商家seller后台更新',
    ];

}
