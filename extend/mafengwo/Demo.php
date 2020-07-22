<?php
namespace mafengwo;

require_once dirname(__FILE__) . '/MSDK_Php_Openapi.php';


/*
 * ---------------------------------实例化对象----------------------------------
 */

/*
 * 调用接口的动作
 *
 */
$action = 'sales.order.list.get';



/*
 * 业务请求数据,非加密数据 type: array
 *
 */
$data = [];
$data['page_no'] = 1;
$data['page_size'] = 20;


/*
 * 实例化请求
 *
 */


/*
 * ============单独获取accesstoken的demo================
 */

$objAccessToken = new MSDK_Php_AccessToken();

$accessToken = $objAccessToken->getAccessToken();

//display('', '', 0, 'accessToken:'.$accessToken);
/*
 * =============单独获取accesstoken======================
 */

$obj = new MSDK_Php_Openapi();
/*
 * 请求接口
 */
if(false == $obj->send($action, $data)){
    $msg = '接口调用失败';
    display($msg, $obj->getError(), $obj->getErrno());
}else{
    $msg = '接口调用成功';
    display($msg, $obj->getError(), $obj->getErrno(), $obj->getData());
}


/*
 * 输出函数
 *
 */
function display($msg, $error, $errno = 0, $data = null){
    echo sprintf('%s[%s] %s, errno[%s] error[%s], data[%s]' . PHP_EOL, str_repeat('=', 80) . PHP_EOL,
        date('Y-m-d H:i:s',time()), $msg, $errno, $error, var_export($data, true));
}
