<?php

require_once dirname(__FILE__) . '/lib/class.geetestlib.php';
class App_Plugin_Captcha_Geetest_GT extends GeetestLib {

    const API_SERVER = "http://messageapi.geetest.com/";

    public function __construct($captcha_id = null, $private_key = null) {
        //获取api key，否则从配置文件中获取
        if (!$captcha_id || !$private_key) {
            //plum_parse_config('yunpian', 'app')['api_key'] php >= 5.4 可用
            $geetest_cfg    = plum_parse_config('geetest', 'app');
            $captcha_id     = plum_check_array_key('captcha_id', $geetest_cfg, null);
            $private_key    = plum_check_array_key('private_key', $geetest_cfg, null);
        }
        if (!$captcha_id || !$private_key) {
            trigger_error("极验配置错误", E_USER_ERROR);
            return null;
        }
        parent::__construct($captcha_id, $private_key);
        return $this;
    }

    public function sendMsgRequest($action,$data){
        $url = self::API_SERVER . $action;
        $result = $this->post_request($url,$data);
        $res = json_decode($result,true);
        return $res['res'];
    }
}