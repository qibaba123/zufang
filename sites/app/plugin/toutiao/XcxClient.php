<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2018/9/12
 * Time: 下午6:09
 */


class App_Plugin_Toutiao_XcxClient {

    const GATEWAY_URL   = "https://developer.toutiao.com";


    public function __construct() {

    }

    /*
     * 通过encryptedData 、iv解析用户信息
     */
    public function getUserInfo($encryptedData,$iv,$rawData,$signature){
        //先校验签名数据是否合法

    }

    /*
    * 生成签名
    * @param string $secretKey
    * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
    */
    public static function makeSign($rawData, $secretKey) {
        //签名
        $signature = sha1("${rawData}${secretKey}");
        return $signature;
    }

    /**
     * 获取用户的openid 和 session_key
     * @param $appid 小程序的appid
     * @param $appSecret  小程序的appsecret
     * @param $code  用户换取openID的code
     * @return mixed|string 返回openid 和session_key
     */
     public static function getToutiaoOpenid($appid,$appSecret,$code){
        // 获取session_key和openid的地址
        $session_url = "https://developer.toutiao.com/api/apps/jscode2session?appid={$appid}&secret={$appSecret}&code={$code}";
        $result = file_get_contents($session_url);
        // 将获取的数据转换
        $result = json_decode($result,true);
        if ($result['openid']) {
            return $result;
        }
        //记录错误
        Libs_Log_Logger::outputLog($result);
        return false;
    }



}