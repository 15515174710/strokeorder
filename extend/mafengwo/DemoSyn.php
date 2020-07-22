<?php
namespace mafengwo;

require_once dirname(__FILE__) . '/MSDK_Php_OrderSyn.php';

/*
 * ===============================php接收请求数据======================================
 */
$postData = $_POST; //马蜂窝请求数据（表单数据包括：partnerId, data等）,不同系统获取数据方式不同

/*
 *  实例化接收数据类
 */


$obj = new MSDK_Php_OrderSyn();


if($obj->checkAuth($postData)){  //认证方法开发商可自行开发,该方法只进行了签名认证

    /*
     * 马蜂窝的请求数据（data字段），或者直接：
     *           $data = MSDK_Php_MfwEncrypt::aDecryptData($data, $config['aes_key']);
     * 获取马蜂窝请求的data字段
     */
    $data = $obj->getData();

    //解析失败直接返回失败
    if(empty($data)){
        echo $obj->getReturn(false, '数据解密失败'); //失败的返回方法
        exit;
    }


    /*
    * ==========================合作商家内部逻辑处理=================================
    */
    switch ($data['status']){   //订单状态同步动作  actionDesc 为推送动作描述

        case MSDK_Php_Const::ORDER_STATUS_CREATE:            //创建订单
            $actionDesc = MSDK_Php_Const::$ORDER_STATUS_MAP[MSDK_Php_Const::ORDER_STATUS_CREATE];
            break;

        case MSDK_Php_Const::ORDER_STATUS_PAID:              //支付成功(待出单)
            $actionDesc = MSDK_Php_Const::$ORDER_STATUS_MAP[MSDK_Php_Const::ORDER_STATUS_CREATE];
            break;

        case MSDK_Php_Const::ORDER_STATUS_ISSUE:             //供应商已出单
            $actionDesc = MSDK_Php_Const::$ORDER_STATUS_MAP[MSDK_Php_Const::ORDER_STATUS_ISSUE];
            break;

        case MSDK_Php_Const::ORDER_STATUS_COMPLETE:          //订单已完成
            $actionDesc = MSDK_Php_Const::$ORDER_STATUS_MAP[MSDK_Php_Const::ORDER_STATUS_COMPLETE];
            break;

        case MSDK_Php_Const::ORDER_STATUS_CLOSE:             //订单已关闭
            $actionDesc = MSDK_Php_Const::$ORDER_STATUS_MAP[MSDK_Php_Const::ORDER_STATUS_CLOSE];
            break;

        case MSDK_Php_Const::ORDER_STATUS_REFUND_APPLY:      //已申请退款
            $actionDesc = MSDK_Php_Const::$ORDER_STATUS_MAP[MSDK_Php_Const::ORDER_STATUS_REFUND_APPLY];
            break;

        case MSDK_Php_Const::ORDER_STATUS_REFUND_CONFIRM:    //已确认退款
            $actionDesc = MSDK_Php_Const::$ORDER_STATUS_MAP[MSDK_Php_Const::ORDER_STATUS_REFUND_CONFIRM];
            break;

        case MSDK_Php_Const::ORDER_STATUS_REFUND_COMPLETE:   //已完成退款
            $actionDesc = MSDK_Php_Const::$ORDER_STATUS_MAP[MSDK_Php_Const::ORDER_STATUS_REFUND_COMPLETE];
            break;

        case MSDK_Php_Const::ORDER_STATUS_REFUND_REFUSED:    //已拒绝退款
            $actionDesc = MSDK_Php_Const::$ORDER_STATUS_MAP[MSDK_Php_Const::ORDER_STATUS_REFUND_REFUSED];
            break;

        case MSDK_Php_Const::ORDER_STATUS_TRAVEL_USER:       //用户填写出行人信息
            $actionDesc = MSDK_Php_Const::$ORDER_STATUS_MAP[MSDK_Php_Const::ORDER_STATUS_TRAVEL_USER];
            break;

        case MSDK_Php_Const::ORDER_STATUS_TRAVEL_AUDIT:      //商家seller后台更新
            $actionDesc = MSDK_Php_Const::$ORDER_STATUS_MAP[MSDK_Php_Const::ORDER_STATUS_TRAVEL_AUDIT];
            break;

        default:
	    echo $obj->getReturn(false, $obj->getError()); //失败的返回方法
	    exit;    
	    break;
    }
    /*
     * ==========================返回给马蜂窝=================================
     */

    echo $obj->getReturn(true); //成功的返回方法
    exit;

}else{
    echo $obj->getReturn(false, $obj->getError()); //失败的返回方法
    exit;
}
