<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/7/12
 * Time: 下午4:30
 */
class App_Plugin_Weixin_OpenPlugin extends App_Plugin_Weixin_ClientPlugin {

    public function __construct($sid){
        parent::__construct($sid);
    }
    /*
     * 获取微信开放平台账号
     */
    public function getOpenAppid($appid) {
        if (!$this->access_token) {
            return array('errcode' => -1, 'errmsg' => '系统错误,请重试。');
        }

        $data   = array('appid' => $appid);

        $send_url   = "https://api.weixin.qq.com/cgi-bin/open/get?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);
        $errcode    = intval($result['errcode']);
        Libs_Log_Logger::outputLog($result);
        $errmap     = array(
            0       => '获取成功',
            -1      => '系统错误,请重试',
            40013   => 'invalid appid，appid无效。',
            89002   => 'open not exists，该公众号/小程序未绑定微信开放平台帐号。',
        );
        return array('errcode' => $errcode, 'errmsg' => $errmap[$errcode], 'open_appid' => isset($result['open_appid']) ? $result['open_appid'] : null);
    }
    /*
     * 创建微信开放平台账号并绑定
     */
    public function createOpenAppid($appid) {
        if (!$this->access_token) {
            return array('errcode' => -1, 'errmsg' => '系统错误,请重试');
        }

        $data   = array('appid' => $appid);

        $send_url   = "https://api.weixin.qq.com/cgi-bin/open/create?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);
        $errcode    = intval($result['errcode']);
        Libs_Log_Logger::outputLog($result);
        $errmap     = array(
            0       => '创建成功',
            -1      => '系统错误,请重试',
            40013   => 'invalid appid，appid无效。',
            89000   => 'account has bound open，该公众号/小程序已经绑定了开放平台帐号。',
        );
        return array('errcode' => $errcode, 'errmsg' => $errmap[$errcode], 'open_appid' => isset($result['open_appid']) ? $result['open_appid'] : null);
    }
    /*
     * 绑定新的公众号或微信小程序到开放平台
     */
    public function bindOpenAppid($appid, $open_appid) {
        if (!$this->access_token) {
            return array('errcode' => -1, 'errmsg' => '系统错误,请重试');
        }

        $data   = array('appid' => $appid, 'open_appid' => $open_appid);

        Libs_Log_Logger::outputLog($data);
        $send_url   = "https://api.weixin.qq.com/cgi-bin/open/bind?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);
        $errcode    = intval($result['errcode']);
        Libs_Log_Logger::outputLog($result);
        $errmap     = array(
            0       => '绑定成功',
            -1      => '系统错误,请重试',
            40013   => 'invalid appid，appid或open_appid无效。',
            89000   => 'account has bound open，该公众号/小程序已经绑定了开放平台帐号。',
            89001   => 'not same contractor，Authorizer与开放平台帐号主体不相同。',
            89002   => '该开放平台帐号所绑定的公众号/小程序已达上限（100个）。',
            89003   => '该开放平台帐号并非通过api创建，不允许操作',
        );
        return array('errcode' => $errcode, 'errmsg' => $errmap[$errcode]);
    }

    public function unbindOpenAppid($appid, $open_appid) {
        if (!$this->access_token) {
            return array('errcode' => -1, 'errmsg' => '系统错误,请重试');
        }

        $data   = array('appid' => $appid, 'open_appid' => $open_appid);

        $send_url   = "https://api.weixin.qq.com/cgi-bin/open/unbind?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);
        $errcode    = intval($result['errcode']);
        Libs_Log_Logger::outputLog($result);
        $errmap     = array(
            0       => '解绑成功',
            -1      => '系统错误,请重试',
            40013   => 'invalid appid，appid或open_appid无效。',
            89001   => 'not same contractor，Authorizer与开放平台帐号主体不相同。',
            89003   => '该开放平台帐号并非通过api创建，不允许操作',
        );
        return array('errcode' => $errcode, 'errmsg' => $errmap[$errcode]);
    }
}