<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/5/28
 * Time: 下午12:32
 */
class App_Plugin_Weixin_PublicClient
{


    public $sid;
    /*
     * 小程序配置,参考pre_applet_cfg
     */
    public $xcx_cfg;


    public function __construct($sid=null)
    {
        $this->sid = $sid;
    }

    /**
     * 验证用户填写的APPID和APPsecret是否正确
     */
    public function authAppidAppSecretCorrect($appid,$appsecret){
        $url    = 'https://api.weixin.qq.com/cgi-bin/token';
        $params = array(
            'grant_type'    => 'client_credential',
            'appid'         => $appid,
            'secret'        => $appsecret,
        );
        $result = Libs_Http_Client::get($url, $params);
        $result = json_decode($result, true);

        if (isset($result['access_token'])) {
            return $result;
        } else {
            Libs_Log_Logger::outputLog($result);
            return false;
        }
    }
}
