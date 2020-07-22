<?php
namespace mafengwo;
require_once dirname(__FILE__) . '/MSDK_Php_Const.php';

class MSDK_Php_MfwEncrypt{
    /**
     * 业务数据加密方法
     * 加密模式：AES128/CBC/PKCS7Padding
     * @param $aData 需要加密的数据数组
     * @param $sKey  合作商户的Key
     * @return string 加密后的数据（base64编码）
     */
    public static function sEncryptData($aData, $sKey)
    {
        if (empty($aData) || empty($sKey)) {
            return '';
        }
        $sData = json_encode($aData);
        $iPadLength = MSDK_Php_Const::PKCS7_BLOCK_SIZE - (strlen($sData) % MSDK_Php_Const::PKCS7_BLOCK_SIZE);
        $cPadChar = chr($iPadLength);
        $sData .= str_repeat($cPadChar, $iPadLength);
        $sIv = substr($sKey, 0, 16);
//        $sEncrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $sKey, $sData, MCRYPT_MODE_CBC, $sIv);
        $sEncrypt = openssl_encrypt($sData,'aes-256-cbc', $sKey,OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING,$sIv);
        /*
         * mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_CBC, $iv);
         * mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_CBC, $iv);
         * openssl_encrypt($str, 'aes-256-cbc', $key, OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING, $iv);
         * openssl_decrypt($str, 'aes-256-cbc', $key, OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING, $iv);
         * */
        $sEncrypt = base64_encode($sEncrypt);

        return $sEncrypt;
    }

    /**
     * 业务数据解密方法
     * @param $sEncrypt base64编码的加密数据字符串
     * @param $sKey  合作商户的Key
     * @return array
     */
    public static function aDecryptData($sEncrypt, $sKey)
    {
        $aData = array();

        if (empty($sEncrypt) || empty($sKey)) {
            return $aData;
        }

        $sIv = substr($sKey, 0, 16);
        $sEncrypt = base64_decode($sEncrypt);
//        $sEncrypt = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $sKey, $sEncrypt, MCRYPT_MODE_CBC, $sIv);
        $sEncrypt = openssl_decrypt($sEncrypt,'aes-256-cbc',$sKey, OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING, $sIv);
        $iEncryptLength = strlen($sEncrypt);

        $iPadLength = ord($sEncrypt[$iEncryptLength - 1]);
        $sEncrypt = substr($sEncrypt, 0, $iEncryptLength - $iPadLength);

        $aData = json_decode($sEncrypt, true);
        return $aData;
    }

}
