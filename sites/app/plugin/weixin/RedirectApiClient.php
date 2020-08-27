<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/5/6
 * Time: 下午7:27
 */
class App_Plugin_Weixin_RedirectApiClient {
    private static $apiEntry = 'https://open.weixin.qq.com/connect/oauth2/authorize';

    private static $apiToken = 'https://api.weixin.qq.com/sns/oauth2/access_token';
    private static $compToken= 'https://api.weixin.qq.com/sns/oauth2/component/access_token';

    private static $apiUserinfo = 'https://api.weixin.qq.com/sns/userinfo';

    private $appId;
    private $appSecret;

    const APP_ID_KEY        = "appid";
    const APP_SECRET_KEY    = "secret";
    const REDIRECT_URL_KEY  = "redirect_uri";
    const RESPONSE_TYPE_KEY = "response_type";
    const SCOPE_KEY         = "scope";
    const STATE_KEY         = "state";
    const COMPONENT_APPID_KEY   = "component_appid";
    const COMPONENT_TOKEN_KEY   = "component_access_token";
    /*
     * 默认的用户信息
     */
    private $userinfo   = array(
        'nickname'  => '',
        'sex'       => 0,
        'province'  => '',
        'city'      => '',
        'headimgurl'=> '',
    );

    public function __construct($appId, $appSecret = null) {
        if ('' == $appId ) throw new Exception('appId 和 appSecret 不能为空');

        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }

    public function redirect($url, $scope = 'snsapi_base', $custom = null, $component_appid = null) {
        $jump = self::$apiEntry . '?' . http_build_query($this->buildRequestParams($url, $scope, $custom, $component_appid)) . '#wechat_redirect';
        //Libs_Log_Logger::outputLog($jump,'test.log');
        header('Location: ' . $jump);
        exit;
    }

    public function replaceLocation($url, $scope = 'snsapi_base', $custom = null, $component_appid = null) {
        $jump = self::$apiEntry . '?' . http_build_query($this->buildRequestParams($url, $scope, $custom, $component_appid)) . '#wechat_redirect';

        header("Content-Type: text/html; charset=UTF-8");
        echo "<script>";
        echo "window.location.assign('$jump')";
        echo "</script>";
        exit();
    }

    private function buildRequestParams($url, $scope, $custom, $component_appid) {

        Libs_Log_Logger::outputLog("{$this->appId}",'redirect.log');
        $pairs = array();
        $pairs[self::APP_ID_KEY]        = $this->appId;
        $pairs[self::REDIRECT_URL_KEY]  = $url;
        $pairs[self::RESPONSE_TYPE_KEY] = "code";
        $pairs[self::SCOPE_KEY]         = $scope;
        if ($custom !== null) $pairs[self::STATE_KEY] = $custom;
        if ($component_appid !== null) $pairs[self::COMPONENT_APPID_KEY] = $component_appid;
        return $pairs;
    }

    /*
     * 微信自有授权方式获取用户基本信息
     */
    public function fetchWeixinUserinfo($code) {
        //第一步获取access token
        $params = array(
            self::APP_ID_KEY    => $this->appId,
            self::APP_SECRET_KEY    => $this->appSecret,
            'code'              => $code,
            'grant_type'        => 'authorization_code',
        );

        $ret    = Libs_Http_Client::get(self::$apiToken, $params);
        $ret    = json_decode($ret, true);
        if (isset($ret['access_token'])) {
            $userinfo           = $this->userinfo;
            $userinfo['openid'] = $ret['openid'];
            //获取用户基本信息
            if ($ret['scope'] == 'snsapi_userinfo') {
                $request = array(
                    'access_token'  => $ret['access_token'],
                    'openid'        => $ret['openid'],
                    'lang'          => 'zh_CN',
                );

                $userinfo   = Libs_Http_Client::get(self::$apiUserinfo, $request);
                $userinfo   = json_decode($userinfo, true);
            }
            if (isset($userinfo['openid'])) {
                return $userinfo;
            }
        }
        return false;
    }
    /*
     * 平台代授权获取用户基本信息
     */
    public function fetchWeixinOpenIDPlatform($code, $comp_appid) {
        //获取component access token
        $p_s    = new App_Model_Auth_RedisWeixinPlatformStorage();
        $token  = $p_s->getCompAccessToken();
        //第一步获取access token
        $params = array(
            self::APP_ID_KEY    => $this->appId,
            'code'              => $code,
            'grant_type'        => 'authorization_code',
            self::COMPONENT_APPID_KEY   => $comp_appid,
            self::COMPONENT_TOKEN_KEY   => $token,
        );

        $ret    = Libs_Http_Client::get(self::$compToken, $params);
        $ret    = json_decode($ret, true);
        if (isset($ret['access_token'])) {
            $userinfo           = $this->userinfo;
            $userinfo['openid'] = $ret['openid'];
            //获取用户基本信息
            if ($ret['scope'] == 'snsapi_userinfo') {
                $request = array(
                    'access_token'  => $ret['access_token'],
                    'openid'        => $ret['openid'],
                    'lang'          => 'zh_CN',
                );

                $userinfo   = Libs_Http_Client::get(self::$apiUserinfo, $request);
                $userinfo   = json_decode($userinfo, true);
            }
            if (isset($userinfo['openid'])) {
                return $userinfo;
            }
        }
        return false;
    }
}