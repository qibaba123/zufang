<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 16/8/2
 * Time: 下午4:06
 */
class App_Plugin_Baidu_Pay {
    private $sid;
    private $paycfg;
    private $rsaPriKeyStr;
    private $rsaPubKeyStr;
    public function __construct($sid) {
        $this->sid  = $sid;
        //获取店铺数据
        $shop_storage   = new App_Model_Shop_MysqlShopCoreStorage();
        $this->shop     = $shop_storage->getRowById($sid);

        // 获取小程序百度支付相关配置
        $appletPay_Model = new App_Model_Baidu_MysqlBaiduPayCfgStorage($this->sid);
        $this->paycfg = $appletPay_Model->findRowPay();

        $this->rsaPriKeyStr = PLUM_DIR_ROOT.$this->paycfg['abp_private_rsa_key'];  //私钥文件
        $this->rsaPubKeyStr = PLUM_DIR_ROOT.$this->paycfg['abp_public_rsa_key'];   //公钥文件
    }

    /**
     * 产生随机字符串，不长于32位
     * @param int $length
     * @return string 产生的随机字符串
     */
    public static function getNonceStr($length = 32) {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {
            $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);
        }
        return $str;
    }

    /**
     * @desc 私钥生成签名字符串
     * @param array $assocArr
     * @param $rsaPriKeyStr
     * @return bool|string
     * @throws Exception
     */
    public static function genSignWithRsa($rsaPriKeyStr,array $assocArr)
    {
        $sign = '';
        if (empty($rsaPriKeyStr) || empty($assocArr)) {
            return $sign;

        }
        if (!function_exists('openssl_pkey_get_private') || !function_exists('openssl_sign')) {
            throw new Exception("openssl扩展不存在");
        }
        $priKeyStr = file_get_contents($rsaPriKeyStr);
        $priKey = openssl_pkey_get_private($priKeyStr);
        if (isset($assocArr['sign'])) {
            unset($assocArr['sign']);
        }
        ksort($assocArr); //按字母升序排序
        $parts = array();
        foreach ($assocArr as $k => $v) {
            $parts[] = $k . '=' . $v;
        }
        $str = implode('&', $parts);
        openssl_sign($str, $sign, $priKey);
        openssl_free_key($priKey);
        return base64_encode($sign);
    }

    /**
     * @desc 公钥校验签名
     * @param array $assocArr
     * @param $rsaPubKeyStr
     * @return bool
     * @throws Exception
     */
    public static function checkSignWithRsa(array $assocArr, $rsaPubKeyStr)
    {
        $rsaPubKeyStr = self::convertRSAKeyStr2Pem($rsaPubKeyStr);
        if (!isset($assocArr['rsaSign']) || empty($assocArr) || empty($rsaPubKeyStr)) {
            return false;
        }
        if (!function_exists('openssl_pkey_get_public') || !function_exists('openssl_verify')) {
            throw new Exception("openssl扩展不存在");
        }

        $sign = $assocArr['rsaSign'];
        unset($assocArr['rsaSign']);
        if (empty($assocArr)) {
            return false;
        }
        ksort($assocArr); //按字母升序排序
        $parts = array();

        $assocArr['returnData'] = json_encode(json_decode($assocArr['returnData'],true));
        foreach ($assocArr as $k => $v) {
            $parts[] = $k . '=' . $v;
        }
        $str = implode('&', $parts);
        $sign = base64_decode($sign);
        $pubKey = openssl_pkey_get_public($rsaPubKeyStr);
        $result = (bool)openssl_verify($str, $sign, $pubKey);
        openssl_free_key($pubKey);

        return $result;
    }

    /**
     * @desc 密钥由字符串（不换行）转为PEM格式
     * @param $rsaKeyStr
     * @param int $keyType 0:公钥，1:私钥
     * @return string
     * @throws SF_Exception_InternalException
     */
    public static function convertRSAKeyStr2Pem($rsaKeyStr, $keyType = 0)
    {
        $rsaKeyPem = '';

        $beginPublicKey   = '-----BEGIN PUBLIC KEY-----';
        $endPublicKey     = '-----END PUBLIC KEY-----';
        $beginPrivateKey  = '-----BEGIN PRIVATE KEY-----';
        $endPrivateKey    = '-----END PRIVATE KEY-----';

        $keyPrefix = $keyType ? $beginPrivateKey : $beginPublicKey;
        $keySuffix = $keyType ? $endPrivateKey : $endPublicKey;

        $rsaKeyPem .= $keyPrefix. "\n";
        $rsaKeyPem .= wordwrap($rsaKeyStr, 64, "\n", true) . "\n";
        $rsaKeyPem .= $keySuffix;

        if(!function_exists('openssl_pkey_get_public') || !function_exists('openssl_pkey_get_private')){
            return false;
        }

        if($keyType == 0 && false == openssl_pkey_get_public($rsaKeyPem)){
            return false;
        }

        if($keyType == 1 && false == openssl_pkey_get_private($rsaKeyPem)){
            return false;
        }

        return $rsaKeyPem;
    }

    /**
     * 小程序订单支付
     */
    public function appletOrderPayRecharge($amount, $tid, $dealTitle, $attach=array()){

        $amount     = round($amount*100);//转化为分

        // 获取小程序配置及支付相关配置
        $appletPay_Model = new App_Model_Baidu_MysqlBaiduPayCfgStorage($this->sid);
        $paycfg = $appletPay_Model->findRowPay();
        if(!$paycfg){
            return false ;    // 未配置百度支付
        }
        $tid = self::makeMchOrderid($this->sid);
        $tid       = mb_strlen($tid, 'UTF-8') > 15 ? mb_substr($tid, 0, 14, 'UTF-8') : $tid;
        $request_params = array(
            'dealId'       => $paycfg['abp_dealid'],
            'appKey'       => $paycfg['abp_appkey'],
            'tpOrderId'    => $tid,
            'totalAmount'  => $amount,
        );
        $sign   = self::genSignWithRsa($this->rsaPriKeyStr,$request_params);
        $request_params['rsaSign'] = $sign;
        $request_params['dealTitle'] = $dealTitle;

        $bizinfo = array(
            'tpData' => array(
                "appKey"     => $paycfg['abp_appkey'],
                "dealId"     => $paycfg['abp_dealid'],
                "tpOrderId"  => $tid,
                "rsaSign"    => $sign,
                "totalAmount"=> $amount,
                'dealTitle'  => $dealTitle,
                "returnData" => $attach
            ),
        );
        $request_params['bizInfo'] = $bizinfo;
        Libs_Log_Logger::outputLog($request_params,'test.log');
        if($sign && isset($sign)){
            return $request_params;
        }else{
            return false;
        }
    }


    /*
     * 生成唯一性商户订单id
     */
    public static function makeMchOrderid($mchid) {
        $shf_str    = (string)mt_rand(10000, 99999).(string)mt_rand(10000, 99999);//十位数字的字符串
        $oid    = array(
            $mchid,
            str_shuffle($shf_str)
        );

        return join('', $oid);
    }




}