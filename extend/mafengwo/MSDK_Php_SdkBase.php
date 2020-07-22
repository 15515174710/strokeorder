<?php
namespace mafengwo;
class MSDK_Php_SdkBase{
    /*
     * 请求的url
     */
    protected $_url = 'https://openapi.mafengwo.cn/oauth2/token'; //默认是开放平台接口地址,具体请求由子类重写

    /*
     * 请求方式
     */

    protected $_reqType = 'POST';
    public function __construct()
    {
    }

    /**
     * 发送请求,支持GET,POST方式
     */

    protected function _sendReq($data = array()){
        $output = '';
        $retry = 0;
        //如果需要可将合作商家ID写入useragent,方便定位流量或者日志
        $userAgent = sprintf('Openapi-MSDK-PHP-%s', MSDK_Php_Const::MSDK_VERSION);
        do{
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $this->_url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, MSDK_Php_Const::HTTP_TIMEOUT);
            curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            if($this->_reqType == "POST"){
                $header[] = "Content-type: multipart/form-data";  //表单形式POST请求
                curl_setopt($curl, CURLOPT_HTTPHEADER,$header);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }else{
                curl_setopt($curl, CURLOPT_HEADER, false);
            }
            $output = curl_exec($curl);
            $info = curl_getinfo($curl);
            curl_close($curl);
            if(isset($info['http_code']) && 200 == $info['http_code']){
                return $output;
            }
            $retry++;
        }while($retry <= MSDK_Php_Const::HTTP_RETYR);
        return $output;
    }


    /*
     * 获取签名算法
     * @params
     * $req = [
     *
     *       "partnerId" => 合作商家ID,
     *       "action"    => API接口的动作名称,
     *       "timestamp" => 时间戳，
     *       "key"       => 密钥，
     *       "nonce"     => 随机串，
     *       "data"      => 加密的业务请求数据
     * ];
     */
    protected function _getSign($req){
        $arr = [];
        $arr['partnerId'] = $req['partnerId'];
        $arr['action'] = $req['action'];
        $arr['timestamp'] = $req['timestamp'];
        $arr['key'] = MSDK_Php_Const::CONFIG_ASEKEY;
        $arr['nonce'] = $req['nonce'];
        $arr['data'] = $req['data'];
        $strSign = '';
        foreach ($arr as $key => $value){
            $strSign .= $value;
        }
        $sign = strtolower(md5($strSign));
        return $sign;

    }



}
