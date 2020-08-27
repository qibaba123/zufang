<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2018/10/11
 * Time: 下午2:51
 * @link https://smartprogram.baidu.com/docs/develop/third/pro/
 */
class App_Plugin_Baidu_ThirdPlatform {

    private $tp_token;

    public function __construct($type = 'baidu'){
        $p_s    = new App_Model_Auth_RedisWeixinPlatformStorage($type);

        $this->tp_token = $p_s->getCompAccessToken();
    }
    /*
     * 获取预授权码
     */
    public function getPreAuthCode() {
        $req_url    = "https://openapi.baidu.com/rest/2.0/smartapp/tp/createpreauthcode";
        $params     = array(
            'access_token'     => $this->tp_token,
        );
        $result = Libs_Http_Client::get($req_url, $params);
        return $this->_format_response_output($result);
    }
    /*
     * 使用授权码获取小程序的访问token
     */
    public function getAccessToken($code) {
        $req_url    = "https://openapi.baidu.com/rest/2.0/oauth/token";
        $params     = array(
            'access_token'     => $this->tp_token,
            'code'      => $code,
            'grant_type'        => 'app_to_tp_authorization_code',
        );
        $result = Libs_Http_Client::get($req_url, $params);

        return $this->_format_response_output($result);
    }
    /*
     * 刷新小程序的访问token
     */
    public function refreshAccessToken($refresh_token) {
        $req_url    = "https://openapi.baidu.com/rest/2.0/oauth/token";
        $params     = array(
            'access_token'      => $this->tp_token,
            'refresh_token'     => $refresh_token,
            'grant_type'        => 'app_to_tp_refresh_token',
        );
        $result = Libs_Http_Client::get($req_url, $params);

        return $this->_format_response_output($result);
    }
    /*
     * 通过小程序的访问token获取小程序的信息
     */
    public function getAppInfo($access_token) {
        $req_url    = "https://openapi.baidu.com/rest/2.0/smartapp/app/info";
        $params     = array(
            'access_token'      => $access_token,
        );
        $result = Libs_Http_Client::get($req_url, $params);
        return $this->_format_response_output($result);
    }

    /*
     * 对输出结果进行格式化处理
     * @link https://smartprogram.baidu.com/docs/develop/third/error/
     */
    private function _format_response_output($response) {
        $res = json_decode($response, true);
        $code   = array();

        if (isset($res['error'])) {//errno == 0
            $code['errcode']    = $res['error'];
            $code['errmsg']     = $res['error_description'];
        } else {
            $code['errcode']    = 0;
            $code['errmsg']     = '获取成功';
            $code['data']       = isset($res['data']) ? $res['data'] : $res;
        }

        return $code;
    }
}