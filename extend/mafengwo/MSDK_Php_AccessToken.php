<?php
namespace mafengwo;
require_once dirname(__FILE__) . '/MSDK_Php_Const.php';

require_once dirname(__FILE__) . '/MSDK_Php_SdkBase.php';



class MSDK_Php_AccessToken extends MSDK_Php_SdkBase {

    protected $_reqType = 'GET';


    /*
     * 请求的url
     */
    protected $_url = 'https://openapi.mafengwo.cn/oauth2/token';

    /*
      * 构造函数,初始化相关数据
      *
      */

    public function __construct()
    {
    }

    public function getAccessToken(){

        $this->_url = $this->_url.sprintf('?grant_type=%s&client_id=%s&client_secret=%s',
                MSDK_Php_Const::GRANT_TYPE, MSDK_Php_Const::CONFIG_PARTNERID,
                MSDK_Php_Const::CONFIG_CLIENT_SECRET);//构造GET请求url
        $res = $this->_sendReq();//GET请求accessToken

        $resArr = @json_decode($res,true);

        return $this->_parseRes($resArr);

    }

    public static function getOwn(){
        return new self();
    }

    private function _parseRes($arr){
        if(isset($arr['expires_in']) && $arr['expires_in'] > 0){
            return $arr['access_token'];
        }
        $error = isset($arr['error'])?$arr['error']:"";
        trigger_error('get access_token failed ! errorinfo:'.$error, E_USER_ERROR);
    }
}
