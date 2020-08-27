<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/4/26
 * Time: 下午6:30
 */
class App_Plugin_Sms_UcpaasPlugin {

    const UCPAAS_SEND_GATWAY    = 'https://api.ucpaas.com/';
    const UCPAAS_SOFT_VERSION   = '2014-06-30';

    public $verify_code_error   = array(
        0       => '发送成功',
        40001   => '手机号格式不正确',
        40002   => '验证码为空',
        40003   => '验证码发送失败',
        40004   => '验证码已失效'
    );

    public function __construct() {

    }
    /*
     * 发送验证码类短信
     */
    public function sendCodeSms($mobile, $code) {
        $uccfg  = plum_parse_config('ucpaas', 'sms');
        $rq     = $this->_request_params_tool('Messages', 'templateSMS');
        $params = array(
            'templateSMS'   => array('appId' => $uccfg['app_id'], 'param' => strval($code), 'templateId' => strval($uccfg['template_id']), 'to' => strval($mobile))
        );

        $ret    = Libs_Http_Client::post($rq['url'], json_encode($params), null, $rq['header']);
        $ret    = json_decode($ret, true);
        if (is_array($ret) && isset($ret['resp'])) {
            if ($ret['resp']['respCode'] == '000000') {
                return array(
                    'code'  => 0,
                    'text'  => str_replace('{1}', $code, $uccfg['template_txt']),
                );
            }
        }
        return false;
    }

    /**
     * web端发送并验证
     * @param string $mobile
     * @param int $code
     * @param int $timestamp
     * @param string $type
     * @param string $token
     * @param bool $send
     * @return array|int
     */
    public function webSendVerify($mobile, $code, $timestamp = null, $type = 'register', $token = null, $send = true) {
        $code = trim($code);
        if (!plum_is_mobile($mobile)) {
            return 40001;
        }

        $ucpaas_cfg    = plum_parse_config('ucpaas', 'sms');
        if (!$token) {
            $token      = plum_check_array_key('auth_token', $ucpaas_cfg, null);
        }

        $valid_time     = plum_check_array_key('valid_time', $ucpaas_cfg, 10*60);
        //token或验证码为空时，返回错误
        if (!$token || !$code) {
            trigger_error('验证码自动验证验证token为空', E_USER_ERROR);
            return 40002;
        }
        //发送验证码，否则为校验验证码
        if ($send) {
            $sendRet = $this->sendCodeSms($mobile, $code);
            if (!$sendRet){
                return 40003;
            }
            $timestamp  = time();
        } else {
            if (!$timestamp || intval($timestamp)+intval($valid_time) < time()) {
                return 40004;
            }
        }

        $nonce      = $code;

        $tmpArr = array($token, $mobile, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr     = implode('', $tmpArr);
        $signature  = md5($tmpStr);
        return array(
            'status'    => 0,
            'mobile'    => $mobile,
            'timestamp' => $timestamp,
            'signature' => $signature,
            'text'      => $sendRet['text']
        );
    }
    /*
     * 发送通知类短信
     */
    public function sendNoticeSms($mobile, $type, array $params) {
        $uccfg  = plum_parse_config('ucpaas', 'sms');
        $notice = $uccfg['notice_tpl'][$type];
        if (!$notice) {
            return false;
        }
        //去除参数中的英文,
        foreach ($params as &$item) {
            $item   = str_replace(',', '', $item);
        }

        $rq     = $this->_request_params_tool('Messages', 'templateSMS');
        $pm     = array(
            'templateSMS'   => array('appId' => $uccfg['app_id'], 'param' => join(',', $params), 'templateId' => strval($notice['tid']), 'to' => strval($mobile))
        );

        $ret    = Libs_Http_Client::post($rq['url'], json_encode($pm), null, $rq['header']);
        $ret    = json_decode($ret, true);
        if (is_array($ret) && isset($ret['resp'])) {
            if ($ret['resp']['respCode'] == '000000') {
                $text   = $notice['txt'];
                for ($i=1; $i<=count($params); $i++) {
                    $text   = str_replace("{$i}", $params[($i-1)], $text);
                }

                return array(
                    'code'  => 0,
                    'text'  => $text,
                );
            }
        }
        return false;
    }

    private function _request_params_tool($func, $oper) {
        $uccfg  = plum_parse_config('ucpaas', 'sms');

        $curr_time  = date('YmdHis', time());

        $signature  = strtoupper(md5($uccfg['account_sid'].$uccfg['auth_token'].$curr_time));

        $rq_uri     = self::UCPAAS_SEND_GATWAY.self::UCPAAS_SOFT_VERSION."/Accounts/{$uccfg['account_sid']}/{$func}/{$oper}?sig={$signature}";

        $authorization  = base64_encode($uccfg['account_sid'].":".$curr_time);

        $header     = array(
            'Accept:application/json', 'Content-Type:application/json;charset=utf-8', "Authorization:{$authorization}",
        );

        return array('url' => $rq_uri, 'header' => $header);
    }
}