<?php
namespace mafengwo;
require_once dirname(__FILE__) . '/MSDK_Php_SdkBase.php';

require_once dirname(__FILE__) . '/MSDK_Php_AccessToken.php';

require_once dirname(__FILE__) . '/MSDK_Php_MfwEncrypt.php';

require_once dirname(__FILE__) . '/MSDK_Php_Const.php';



class MSDK_Php_Openapi extends  MSDK_Php_SdkBase {

    /*
     * 请求的url
     */
    protected $_url = 'https://openapi.mafengwo.cn/deals/rest';

    /*
     * 上次响应码
     */
    private $_errno;

    /*
     * 上次响应信息
     */
    private $_error;

    /*
     * 上次响应数据
     */
    private $_data;

    /*
     * 请求方式
     */

    protected $_reqType = 'POST';

    public static $instance = null;

    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /*
     * 构造函数,初始化相关数据
     *
     */
    public function __construct(){
    }

    /*
     * 发送请求命令需要传入action(对应请求的接口)
     *
     * @param $action API接口的动作名称
     *        $data 业务请求数据不用加密，程序处理加密
     *
     */
    public function send($action, $data, $accessToken = ''){
        //对象属性初始化
        $this->_reset();
        //构建请求参数
        $req = $this->_buildReq($action, $data, $accessToken);
        //发送HTTP请求

        $res = $this->_sendReq($req);
        return $this->parseRes($res);

    }


    /*
     * 构建请求参数 $nonce 随机串 可随机生成
     * @params
     */
    private function _buildReq($action, $data, $accessToken = ''){
        $req = [];  //初始化请求数组
        $req['partnerId'] = MSDK_Php_Const::CONFIG_PARTNERID;
        $req['nonce'] = $this->_getNonce();
        $req['action'] = $action;
        $req['timestamp'] = time();
        $req['data'] = MSDK_Php_MfwEncrypt::sEncryptData($data, MSDK_Php_Const::CONFIG_ASEKEY);//加密请求数据
        $req['access_token'] = !empty($accessToken)?
            $accessToken:MSDK_Php_AccessToken::getOwn()->getAccessToken(); //获取accessToken
        $req['sign'] = $this->_getSign($req); //获取签名
        return $req;
    }


    /*
     * 重置上次请求结果
     */
    private function _reset(){
        $this->_errno = 0;
        $this->_error = '';
        $this->_data = null;
    }

    /*
   * 生成随机串
   * @param int $iMaxLength
   */
    protected function _getNonce($iMaxLength = 16){
        $sRandom = '';
        $sPol = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
        for ($i = 0; $i < $iMaxLength; $i++) {
            $sRandom .= $sPol[mt_rand(0, 61)];
        }
        return $sRandom;
    }

    /*
     * 解析解码的马蜂窝返回结果,外部也可使用
     */
    public function parseRes($res){
        if(!empty($res)){
            $res = MSDK_Php_MfwEncrypt::aDecryptData($res, MSDK_Php_Const::CONFIG_ASEKEY);
            return $this->_handle($res);
        }
        return false;
    }

    private function _handle($data){
        if(is_array($data) && !empty($data)){
            if(isset($data['errno']) && $data['errno'] === 1000){
                $this->_errno = $data['errno'];
                $this->_error = isset($data['message'])?$data['message']:'';
                $this->_data  = isset($data['data'])?$data['data']:"";
                return true;
            }else{
                $this->_errno = isset($data['errno'])?$data['errno']:"";
                $this->_error = isset($data['message'])?$data['message']:'';
                $this->_data  = isset($data['data'])?$data['data']:"";
                return false;
            }
        }
	$this->_errno = -1;
	$this->_error = "请检查Const.php商家自主配置参数！";
        return false;
    }

    public function getError(){
        return $this->_error;
    }

    public function getErrno(){
        return $this->_errno;
    }
    public function getData(){
        return $this->_data;
    }

}
