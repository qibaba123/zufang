<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/29
 * Time: 下午3:44
 */
class App_Plugin_Weixin_FxbPay {

    private $trade_type = array('JSAPI', 'NATIVE', 'APP');
    /*
     * curl出错时重试次数
     */
    private static $curl_retry_times   = 0;
    /*
     * 店铺id
     */
    private $sid;

    /*
     * 店铺信息，字段名参考表pre_shop
     */
    public $shop;

    public $fxb_pay_cfg;
    /*
     * 提现配置信息，字段名参考表pre_withdraw_cfg;
     */
    public $wd_cfg;

    private $unified_url    = "https://api.mch.weixin.qq.com/pay/unifiedorder";
    private $refund_url     = "https://api.mch.weixin.qq.com/secapi/pay/refund";
    private $transfer_url   = "https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers";
    private $redpack_url    = "https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack";

    public function __construct($sid) {
        $this->sid  = $sid;

        $shop_storage   = new App_Model_Shop_MysqlShopCoreStorage();
        $this->shop     = $shop_storage->getRowById($sid);

        $this->fxb_pay_cfg  = plum_parse_config('fxb_pay', 'weixin');

        $wdcfg_storage  = new App_Model_Shop_MysqlWithdrawCfgStorage();
        $this->wd_cfg   = $wdcfg_storage->findCfgBySid($sid);
    }

    /**
     * 微信JSAPI方式统一下单支付接口
     * @param string $openid 用户的openID
     * @param string $body 商品描述，必填
     * @param string $tid 商户系统内部的订单号
     * @param float  $amount 支付总金额，单位元
     * @param string $notify_url 通知回调地址
     * @param array $other 其他辅助数据，例如array('attach')
     * @return array|int
     */
    public function unifiedJsapiOrder($openid, $body, $tid, $amount, $notify_url, $other = array()) {
        $amount     = round($amount*100);//转化为分
        $body       = mb_strlen($body, 'UTF-8') > 40 ? mb_substr($body, 0, 40, 'UTF-8') : $body;
        $mch_id     = $this->fxb_pay_cfg['mch_id'];
        $wx_appid   = $this->fxb_pay_cfg['app_id'];

        $request_params = array(
            'appid'             => $wx_appid,//公众号ID
            'mch_id'            => $mch_id,//商户号
            'nonce_str'         => self::getNonceStr(24),
            'body'              => $body,
            'out_trade_no'      => $tid,//商户内部订单号
            'total_fee'         => $amount,//单位分
            'spbill_create_ip'  => plum_get_server('SERVER_ADDR'),
            'notify_url'        => $notify_url,
            'trade_type'        => 'JSAPI',
            'openid'            => $openid,
        );
        $request_params = array_merge($request_params, $other);
        Libs_Log_Logger::outputLog($request_params);
        $sign   = self::makeWxpaySign($request_params, $this->fxb_pay_cfg['mch_key']);
        $request_params['sign'] = $sign;
        if ($xml = $this->toXml($request_params)) {
            $ret = self::postXmlCurl($xml, $this->unified_url);

            $ret = $this->fromXml($ret);
            Libs_Log_Logger::outputLog($ret);
            if ($ret) {
                if ($ret['return_code'] == 'SUCCESS' && $ret['result_code'] == 'SUCCESS') {
                    return array(
                        'code'  => 0,
                        'appid'     => $ret['appid'],
                        'mch_id'    => $ret['mch_id'],
                        'trade_type'    => $ret['trade_type'],
                        'prepay_id'     => $ret['prepay_id'],
                        'app_key'       => $this->fxb_pay_cfg['mch_key'],
                    );
                }
            } else {
                return 40004;
            }
        } else {
            return 40003;
        }
    }
    /**
     * 微信NATIVE方式统一下单支付接口
     * @param string $pid  商品ID
     * @param string $body 商品描述，必填
     * @param string $tid 商户系统内部的订单号
     * @param float  $amount 支付总金额，单位元
     * @param string $notify_url 通知回调地址
     * @param array $other 其他辅助数据，例如array('attach')
     * @return array|int
     */
    public function unifiedNativeOrder($pid, $body, $tid, $amount, $notify_url, $other = array()) {
        $amount     = round($amount*100);//转化为分
        $body       = mb_strlen($body, 'UTF-8') > 40 ? mb_substr($body, 0, 40, 'UTF-8') : $body;
        $mch_id     = $this->fxb_pay_cfg['mch_id'];
        $wx_appid   = $this->fxb_pay_cfg['app_id'];

        $request_params = array(
            'appid'             => $wx_appid,//公众号ID
            'mch_id'            => $mch_id,//商户号
            'nonce_str'         => self::getNonceStr(24),
            'body'              => $body,
            'out_trade_no'      => $tid,//商户内部订单号
            'total_fee'         => $amount,//单位分
            'spbill_create_ip'  => $this->fxb_pay_cfg['spbill_ip'],
            'notify_url'        => $notify_url,
            'trade_type'        => 'NATIVE',
            'product_id'        => $pid,
        );
        $request_params = array_merge($request_params, $other);
        $sign   = self::makeWxpaySign($request_params, $this->fxb_pay_cfg['mch_key']);
        $request_params['sign'] = $sign;
        if ($xml = $this->toXml($request_params)) {
            $ret = self::postXmlCurl($xml, $this->unified_url);
            Libs_Log_Logger::outputLog($ret);
            $ret = $this->fromXml($ret);
            if ($ret) {
                if ($ret['return_code'] == 'SUCCESS' && $ret['result_code'] == 'SUCCESS') {
                    return array(
                        'code'  => 0,
                        'appid'     => $ret['appid'],
                        'mch_id'    => $ret['mch_id'],
                        'trade_type'    => $ret['trade_type'],
                        'prepay_id'     => $ret['prepay_id'],
                        'app_key'       => $this->fxb_pay_cfg['mch_key'],
                        'code_url'      => $ret['code_url'],
                    );
                }
            } else {
                return 40004;
            }
        } else {
            return 40003;
        }
    }

    /*
     * 退款
     * @param string $num_type  'sh'/'wx' $tid为商户单号,还是微信单号
     */
    public function refundPayOrder($tid, $rfid, $total_fee, $refund_fee, $num_type = 'sh') {
        $total_fee  = round($total_fee*100);//转化为分
        $refund_fee = round($refund_fee*100);//转化为分
        $mch_id     = $this->fxb_pay_cfg['mch_id'];
        $wx_appid   = $this->fxb_pay_cfg['app_id'];
        $dhtype     = $num_type == 'sh' ? "out_trade_no" : "transaction_id";
        
        $request_params = array(
            'appid'             => $wx_appid,//公众号ID
            'mch_id'            => $mch_id,//商户号
            'nonce_str'         => self::getNonceStr(24),
            $dhtype             => $tid,//商户内部订单号或微信单号
            'out_refund_no'     => $rfid,
            'total_fee'         => $total_fee,//单位分
            'refund_fee'        => $refund_fee,
            'op_user_id'        => $mch_id,
            'refund_account'    => 'REFUND_SOURCE_RECHARGE_FUNDS',//使用可用余额作为退款来源
        );

        $sign   = self::makeWxpaySign($request_params, $this->fxb_pay_cfg['mch_key']);
        $request_params['sign'] = $sign;
        if ($xml = $this->toXml($request_params)) {
            $useCert['ssl_cert']    = $this->fxb_pay_cfg['apiclient_cert'];
            $useCert['ssl_key']     = $this->fxb_pay_cfg['apiclient_key'];
            $ret = self::postXmlCurl($xml, $this->refund_url, $useCert);
            Libs_Log_Logger::outputLog($ret);
            $ret = $this->fromXml($ret);
            if ($ret) {
                if ($ret['return_code'] == 'SUCCESS' && $ret['result_code'] == 'SUCCESS') {
                    //退款成功,做相应处理
                    return array(
                        'appid'         => $ret['appid'],
                        'mch_id'        => $ret['mch_id'],
                        'tid'           => $ret['out_trade_no'],
                        'refund_id'     => $ret['out_refund_no'],
                        'refund_fee'    => $ret['refund_fee'],
                        'total_fee'     => $ret['total_fee'],
                    );
                }
            }
        }
        return false;
    }

    /*
     * 企业付款功能
     */
    public function payTransfer($openid, $amount, $realname) {
        $desc   = "{$this->wd_cfg['wc_wx_actname']}给{$realname}微信转账付款{$amount}元";
        $amount     = round($amount*100);//转化为分
        $mch_id     = $this->fxb_pay_cfg['mch_id'];
        $wx_appid   = $this->fxb_pay_cfg['app_id'];

        $request_params = array(
            'nonce_str'         => self::getNonceStr(24),
            'partner_trade_no'  => self::makeMchOrderid($mch_id),
            'mchid'             => $mch_id,//商户号
            'mch_appid'         => $wx_appid,//公众号
            'openid'            => $openid,//用户openID
            'amount'            => $amount,//单位分
            'check_name'        => 'OPTION_CHECK',
            're_user_name'      => $realname,
            'desc'              => $desc,//备注
            'spbill_create_ip'  => plum_get_server('SERVER_ADDR'),
        );
        $sign   = self::makeWxpaySign($request_params, $this->fxb_pay_cfg['mch_key']);
        $request_params['sign'] = $sign;
        if ($xml = $this->toXml($request_params)) {
            $useCert    = array(
                'ssl_cert'  => $this->fxb_pay_cfg['apiclient_cert'],
                'ssl_key'   => $this->fxb_pay_cfg['apiclient_key'],
            );
            $ret = self::postXmlCurl($xml, $this->transfer_url, $useCert);
            $ret = $this->fromXml($ret);
            if ($ret) {
                if ($ret['return_code'] == 'SUCCESS' && $ret['result_code'] == 'SUCCESS') {
                    return array(
                        'code'  => 0,
                        'mch_billno'    => $ret['partner_trade_no'],//商户订单号
                        'send_listid'   => $ret['payment_no'],//微信订单号
                    );
                } else {
                    App_Helper_Tool::sendMail("企业转账失败", json_encode($ret));
                    return array('code' => 40003, 'errmsg' => '企业转账失败');
                }
            }
        }
        return array('code' => 40004, 'errmsg' => '未知错误');
    }
    /*
     * 发送红包功能
     */
    public function sendRedpack($openid, $amount) {
        if (!isset($this->wd_cfg['wc_wx_open']) || !$this->wd_cfg['wc_wx_open']) {
            $act_name   = $this->shop['s_name'];
        } else {
            $act_name   = $this->wd_cfg['wc_wx_actname'];
        }

        $amount     = round($amount*100);//转化为分
        $mch_id     = $this->fxb_pay_cfg['mch_id'];
        $wx_appid   = $this->fxb_pay_cfg['app_id'];

        $request_params = array(
            'nonce_str'         => self::getNonceStr(24),
            'mch_billno'        => self::makeMchOrderid($mch_id),
            'mch_id'            => $mch_id,//商户号
            'wxappid'           => $wx_appid,//公众号
            'send_name'         => $this->shop['s_name'],//商户名称
            're_openid'         => $openid,//用户openID
            'total_amount'      => $amount,//单位分
            'total_num'         => 1,
            'wishing'           => $act_name,//红包祝福语
            'act_name'          => $act_name,//活动名称
            'remark'            => $act_name,//备注
            'client_ip'         => plum_get_server('SERVER_ADDR'),
        );
        $request_params = $this->_convert_param_length($request_params);
        $sign   = self::makeWxpaySign($request_params, $this->fxb_pay_cfg['mch_key']);
        $request_params['sign'] = $sign;
        if ($xml = $this->toXml($request_params)) {
            $useCert    = array(
                'ssl_cert'  => $this->fxb_pay_cfg['apiclient_cert'],
                'ssl_key'   => $this->fxb_pay_cfg['apiclient_key'],
            );
            $ret = self::postXmlCurl($xml, $this->redpack_url, $useCert);
            Libs_Log_Logger::outputLog($ret);
            $ret = $this->fromXml($ret);

            if ($ret) {
                if ($ret['return_code'] == 'SUCCESS' && $ret['result_code'] == 'SUCCESS') {
                    return array(
                        'code'  => 0,
                        'mch_billno'    => $ret['mch_billno'],
                        'send_listid'   => $ret['send_listid']
                    );
                } else {
                    App_Helper_Tool::sendMail("红包发送失败", json_encode($ret));
                    return array('code' => 40003, 'errmsg' => '红包发送失败');
                }
            }
        }
        return array('code' => 40004, 'errmsg' => '未知错误');
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

    /*
     * 生成签名
     * @param string $appkey 微信支付商户密钥
     * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
     */
    public static function makeWxpaySign(array $fields, $appkey) {
        //签名步骤一：按字典序排序参数
        ksort($fields);
        $string = self::toUrlParams($fields);
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=".$appkey;
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }

    /*
     * 格式化参数格式化成url参数
     */
    public static function toUrlParams(array $fields) {
        $buff = "";
        foreach ($fields as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }

    /*
     * 生成唯一性商户订单id
     */
    public static function makeMchOrderid($mchid) {
        $shf_str    = (string)mt_rand(10000, 99999).(string)mt_rand(10000, 99999);//十位数字的字符串
        $oid    = array(
            $mchid,
            date('Ymd', time()),
            str_shuffle($shf_str)
        );

        return join('', $oid);
    }

    /**
     * 输出xml字符
     * @throws WxPayException
     **/
    public static function toXml(array $values) {
        if(!is_array($values) || count($values) <= 0) {
            return false;
        }

        $xml = "<xml>";
        foreach ($values as $key=>$val) {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }

    /*
     * 将xml转为array
     * @param string $xml
     * @throws WxPayException
     */
    public static function fromXml($xml) {
        if(!$xml){
            return false;
        }
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $values;
    }

    /*
     * 以post方式提交xml到对应的接口url
     *
     * @param string $xml  需要post的xml数据
     * @param string $url  url
     * @param mixed $useCert 是否需要证书，默认不需要
     * @param int $second   url执行超时时间，默认30s
     * @throws WxPayException
     */
    private static function postXmlCurl($xml, $url, $useCert = false, $second = 30) {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);

        //如果有配置代理这里就设置代理
        /*
        if(WxPayConfig::CURL_PROXY_HOST != "0.0.0.0"
            && WxPayConfig::CURL_PROXY_PORT != 0){
            curl_setopt($ch,CURLOPT_PROXY, WxPayConfig::CURL_PROXY_HOST);
            curl_setopt($ch,CURLOPT_PROXYPORT, WxPayConfig::CURL_PROXY_PORT);
        }
        */
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        if($useCert !== false){
            //设置证书
            //使用证书：cert 与 key 分别属于两个.pem文件
            curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLCERT, $useCert['ssl_cert']);
            curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLKEY, $useCert['ssl_key']);
        }
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if($data){
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            Libs_Log_Logger::outputLog("curl出错，错误码:$error");
            //小于10次的重试
            if (self::$curl_retry_times < 10) {
                Libs_Log_Logger::outputLog("curl出错，重试次数:".self::$curl_retry_times);
                self::$curl_retry_times++;
                self::postXmlCurl($xml, $url, $useCert, $second);
            } else {
                return false;
            }
        }
    }

    /*
     * 校验回调支付通知
     */
    public function notifyVerify($code,$applet=false) {
        $sign           = $code['sign'];
        unset($code['sign']);
        $check_sign     = $this->makeWxpaySign($code, $this->fxb_pay_cfg['mch_key']);
        //校验签名
        if ($sign == $check_sign) {
            //验证公众号ID及商户ID
            if($applet){   // 如果是微信小程序支付
                $appcfg     = plum_parse_config('xcx_login','weixin');  // 获取小程序APPid
                $paycfg     = plum_parse_config('fxb_pay','weixin');    // 获取支付相关配置
                if ($code['appid'] == $appcfg['app_id'] && $code['mch_id'] == $paycfg['mch_id']) {
                    return true;
                }
            }else{
                if ($code['appid'] == $this->fxb_pay_cfg['app_id'] && $code['mch_id'] == $this->fxb_pay_cfg['mch_id']) {
                    return true;
                }
            }

        }

        return false;
    }

    /*
     * 转换参数字符长度
     */
    private function _convert_param_length(array $params) {
        $sn_len     = strlen($params['send_name']);
        $ws_len     = strlen($params['wishing']);
        $an_len     = strlen($params['act_name']);
        $rk_len     = strlen($params['remark']);

        while ($sn_len > 32) {
            $mbsn_len   = mb_strlen($params['send_name'], 'UTF-8');
            $params['send_name']  = mb_substr($params['send_name'], 0, $mbsn_len-1, 'UTF-8');
            $sn_len = strlen($params['send_name']);
        }

        while ($ws_len > 128) {
            $mbws_len   = mb_strlen($params['wishing']);
            $params['wishing']  = mb_substr($params['wishing'], 0, $mbws_len-1, 'UTF-8');
            $ws_len = strlen($params['wishing']);
        }

        while ($an_len > 32) {
            $mban_len   = mb_strlen($params['act_name']);
            $params['act_name']  = mb_substr($params['act_name'], 0, $mban_len-1, 'UTF-8');
            $an_len = strlen($params['act_name']);
        }

        while ($rk_len > 256) {
            $mbrk_len   = mb_strlen($params['remark']);
            $params['remark']  = mb_substr($params['remark'], 0, $mbrk_len-1, 'UTF-8');
            $rk_len = strlen($params['remark']);
        }

        return $params;
    }
}