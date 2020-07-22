<?php
namespace mafengwo;
require_once dirname(__FILE__) . '/MSDK_Php_MfwEncrypt.php';

require_once dirname(__FILE__) . '/MSDK_Php_Const.php';

require_once dirname(__FILE__) . '/MSDK_Php_SdkBase.php';



class MSDK_Php_OrderSyn extends MSDK_Php_SdkBase{

    /*
     * 返回码
     */
    private $_errno;

    /*
     * 返回错误信息
     */
    private $_error;

    /*
     * 返回数据
     */
    private $_data;


    public function __construct(){
    }


    /*
     *  订单同步请求首先进行认证
     */
    public function checkAuth($resData){
        if(empty($resData['partnerId']) || empty($resData['action']) || empty($resData['timestamp'])
            || empty($resData['nonce']) || empty($resData['sign']) || empty($resData['data'])){
            $this->_handle('请求字段缺失或为空');
            return false;
        }else if($resData['partnerId'] != MSDK_Php_Const::CONFIG_PARTNERID){
            $this->_handle('合作商家ID不匹配');
            return false;
        }
        return $this->_checkSign($resData);
    }


    /*
     * 校验签名
     */
    public function _checkSign($data){
        $sign = $this->_getSign($data);
        if($sign !== $data['sign']){
            $this->_handle('签名不匹配');
            return false;
        }
        $this->_handle('', $data['data']);
        return true;
    }

    /*
     *  错误处理
     */
    private function _handle($error, $data =[]){
        $this->_errno = null;
        $this->_error = $error;
        $this->_data  = MSDK_Php_MfwEncrypt::aDecryptData($data, MSDK_Php_Const::CONFIG_ASEKEY);
    }

    public function getError(){
        return $this->_error;
    }

    public function getData(){
        return $this->_data;
    }

    public function getErrno(){
        return $this->_errno;
    }

    /*
     *  结果返回
     *  $params:
     *      bool     $isSuccess   是否成功：true 成功  false  失败
     *      string   $msg         错误信息
     */

    public function getReturn($isSuccess, $msg = ''){
        if($isSuccess){
            $ret = [
                'code'    => MSDK_Php_Const::SUCCESS,
            ];
            return MSDK_Php_MfwEncrypt::sEncryptData($ret, MSDK_Php_Const::CONFIG_ASEKEY);
        }else{
            $ret = [
                'code'    => MSDK_Php_Const::FAILED,
                'message' => $msg,
            ];
            return MSDK_Php_MfwEncrypt::sEncryptData($ret, MSDK_Php_Const::CONFIG_ASEKEY);
        }
    }

}
