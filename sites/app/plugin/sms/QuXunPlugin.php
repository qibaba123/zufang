<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/11/19
 * Time: 下午4:25
 */
class App_Plugin_Sms_QuXunPlugin {

    const QUXUN_SEND_GATWAY = 'http://101.69.161.42:8080/sms/ylSend3.do';

    private $uid;
    private $pwd;

    public function __construct()
    {
        $cfg    = plum_parse_config('quxun');
        $this->uid  = $cfg['uid'];
        $this->pwd  = $cfg['pwd'];
    }

    public function sendSms($mobile, $msg) {
        if (is_string($mobile)) {
            $mobile = trim($mobile, ',').',';
        } else {
            $mobile = join(',', $mobile).',';
        }

        $msg        = mb_convert_encoding($msg, 'GB2312', 'UTF-8');

        $param      = array(
            'uid'   => $this->uid,
            'pwd'   => $this->pwd,
            'rev'   => $mobile,
            'msg'   => $msg,
            'sdt'   => '',
            'snd'   => 101,
        );
        
        $ret    = Libs_Http_Client::get(self::QUXUN_SEND_GATWAY, $param);
        if (strpos($ret, ';') !== false) {
            Libs_Log_Logger::outputLog($ret);
            return true;
        } else {
            App_Helper_Tool::sendMail("趣讯网络短信发送失败", $ret);
            return false;
        }
    }
}