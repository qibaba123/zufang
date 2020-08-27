<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/6/1
 * Time: 下午4:45
 */

include_once "crypt/wxBizMsgCrypt.php";

class App_Plugin_Weixin_MsgCrypt {
    /*
     * 消息加密
     */
    public static function encrypt($text, $type = 'weixin') {
        $from       = $type == 'weixin' ? 'weixin' : 'applet';
        //获取公众号第三方平台信息配置
        $plat_cfg   = plum_parse_config('platform', $from);

        $crypt      = new WXBizMsgCrypt($plat_cfg['verify_token'], $plat_cfg['crypt_key'], $plat_cfg['app_id']);
        $encrypt_msg= '';
        $timestamp  = time();
        $nonce      = self::getNonceStr(24);
        $err_code   = $crypt->encryptMsg($text, $timestamp, $nonce, $encrypt_msg);

        if ($err_code == 0) {
            //加密成功
            return $encrypt_msg;
        }
        return false;
    }

    /*
     * 消息解密
     */
    public static function decrypt($xml, $timestamp, $nonce, $signature, $type = 'weixin') {
        if ($type == 'weixin') {
            //获取公众号第三方平台信息配置
            $plat_cfg   = plum_parse_config('platform', $type);
        } else {
            //获取公众号第三方平台信息配置
            $platform   = plum_parse_config('platform', 'wxxcx');
            $plat_cfg   = $platform[$type];
        }

        $crypt      = new WXBizMsgCrypt($plat_cfg['verify_token'], $plat_cfg['crypt_key'], $plat_cfg['app_id']);
        $msg        = '';
        $err_code   = $crypt->decryptMsg($signature, $timestamp, $nonce, $xml, $msg);

        if ($err_code == 0) {
            return $msg;
        }
        Libs_Log_Logger::outputLog($err_code);
        return false;
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
}