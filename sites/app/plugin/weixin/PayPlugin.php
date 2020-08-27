<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/5/5
 * Time: 下午2:22
 */

class App_Plugin_Weixin_PayPlugin {

    public static $error_map = array(
        40001   => "微信红包自动提现未开启",
        40002   => "微信支付商户信息配置不正确",
        40003   => "请求参数转换XML出错",
        40004   => "网络请求错误",
        40005   => "通信错误",
        40006   => "业务请求失败"
    );

    private $trade_type = array('JSAPI', 'NATIVE', 'APP');
    /*
     * 店铺id
     */
    private $sid;

    /*
     * 店铺信息，字段名参考表pre_shop
     */
    public $shop;

    /*
     * 微信配置信息，字段名参考表pre_weixin_cfg
     */
    public $wx_cfg;

    /*
     * 提现配置信息，字段名参考表pre_withdraw_cfg;
     */
    public $wd_cfg;

    /*
     * 红包发放接口url
     * 企业付款接口url
     */
    private $send_url       = "https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack";
    private $transfer_url   = "https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers";
    private $unified_url    = "https://api.mch.weixin.qq.com/pay/unifiedorder";

    public function __construct($sid) {
        $this->sid  = $sid;

        $shop_storage   = new App_Model_Shop_MysqlShopCoreStorage();
        $this->shop     = $shop_storage->getRowById($sid);

        $wxcfg_storage  = new App_Model_Auth_MysqlWeixinStorage();
        $this->wx_cfg   = $wxcfg_storage->findWeixinBySid($sid);

        $wdcfg_storage  = new App_Model_Shop_MysqlWithdrawCfgStorage();
        $this->wd_cfg   = $wdcfg_storage->findCfgBySid($sid);
    }

    /*
     * 发送红包功能
     */
    public function sendRedpack($openid, $amount) {
        if (!isset($this->wd_cfg['wc_wx_open']) || !$this->wd_cfg['wc_wx_open']) {
            return 40001;
        }

        if (!$this->wx_cfg['wc_mchid'] || !$this->wx_cfg['wc_mchkey'] || !$this->wx_cfg['wc_sslcert'] || !$this->wx_cfg['wc_sslkey']) {
            return 40002;
        }

        $amount     = intval($amount*100);//转化为分
        $mch_id     = $this->wx_cfg['wc_mchid'];
        $wx_appid   = $this->wx_cfg['wc_app_id'];

        $request_params = array(
            'nonce_str'         => self::getNonceStr(24),
            'mch_billno'        => self::makeMchOrderid($mch_id),
            'mch_id'            => $mch_id,//商户号
            'wxappid'           => $wx_appid,//公众号
            'send_name'         => $this->shop['s_name'],//商户名称
            're_openid'         => $openid,//用户openID
            'total_amount'      => $amount,//单位分
            'total_num'         => 1,
            'wishing'           => $this->wd_cfg['wc_wx_actname'],//红包祝福语
            'act_name'          => $this->wd_cfg['wc_wx_actname'],//活动名称
            'remark'            => $this->wd_cfg['wc_wx_actname'],//备注
            'client_ip'         => plum_get_server('SERVER_ADDR'),
        );
        $sign   = self::makeWxpaySign($request_params, $this->wx_cfg['wc_mchkey']);
        $request_params['sign'] = $sign;
        if ($xml = $this->toXml($request_params)) {
            $useCert    = array(
                'ssl_cert'  => PLUM_DIR_ROOT.$this->wx_cfg['wc_sslcert'],
                'ssl_key'   => PLUM_DIR_ROOT.$this->wx_cfg['wc_sslkey']
            );
            $ret = self::postXmlCurl($xml, $this->send_url, $useCert);
            $ret = $this->fromXml($ret);

            if ($ret) {
                if ($ret['return_code'] == 'SUCCESS' && $ret['result_code'] == 'SUCCESS') {
                    return array(
                        'code'  => 0,
                        'mch_billno'    => $ret['mch_billno'],
                        'send_listid'   => $ret['send_listid']
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
     * 企业付款功能
     */
    public function payTransfer($openid, $amount, $realname) {
        if (!$this->wx_cfg['wc_mchid'] || !$this->wx_cfg['wc_mchkey'] || !$this->wx_cfg['wc_sslcert'] || !$this->wx_cfg['wc_sslkey']) {
            return 40002;
        }
        $desc   = "{$this->wd_cfg['wc_wx_actname']}给{$realname}微信转账付款{$amount}元";
        $amount     = intval($amount*100);//转化为分
        $mch_id     = $this->wx_cfg['wc_mchid'];
        $wx_appid   = $this->wx_cfg['wc_app_id'];

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
        $sign   = self::makeWxpaySign($request_params, $this->wx_cfg['wc_mchkey']);
        $request_params['sign'] = $sign;
        if ($xml = $this->toXml($request_params)) {
            $useCert    = array(
                'ssl_cert'  => PLUM_DIR_ROOT.$this->wx_cfg['wc_sslcert'],
                'ssl_key'   => PLUM_DIR_ROOT.$this->wx_cfg['wc_sslkey']
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
                }
            } else {
                return 40004;
            }
        } else {
            return 40003;
        }
    }

    private function get_server_ip(){
        exec('/sbin/ifconfig eth1 | sed -n \'s/^ *.*addr:\\([0-9.]\\{7,\\}\\) .*$/\\1/p\'',$arr);
        $ret = $arr[0];
        return $ret;
    }

    /**
     * 微信统一下单支付接口
     * @param string $openid 用户的openID
     * @param string $body 商品描述，必填
     * @param string $tid 商户系统内部的订单号
     * @param float  $amount 支付总金额，单位元
     * @param string $notify_url 通知回调地址
     * @param string $trade 交易方式，目前仅支持JSAPI
     * @param array $other 其他辅助数据，例如array('attach')
     * @return array|int
     */
    public function unifiedOrderPay($openid, $body, $tid, $amount, $notify_url, $trade = 'JSAPI', $other = array()) {
        $amount     = intval($amount*100);//转化为分
        $mch_id     = $this->wx_cfg['wc_mchid'];
        $wx_appid   = $this->wx_cfg['wc_app_id'];
        $trade      = in_array($trade, $this->trade_type) ? $trade : current($this->trade_type);

        $request_params = array(
            'appid'             => $wx_appid,//公众号ID
            'mch_id'            => $mch_id,//商户号
            'nonce_str'         => self::getNonceStr(24),
            'body'              => $body,
            'out_trade_no'      => $tid,//商户内部订单号
            'total_fee'         => $amount,//单位分
            'spbill_create_ip'  => plum_get_server('SERVER_ADDR'),
            'notify_url'        => $notify_url,
            'trade_type'        => $trade,
            'openid'            => $openid,
        );
        Libs_Log_Logger::outputLog($request_params);
        $request_params = array_merge($request_params, $other);
        $sign   = self::makeWxpaySign($request_params, $this->wx_cfg['wc_mchkey']);
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
                        'app_key'       => $this->wx_cfg['wc_mchkey'],
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
            if($k != "sign" && $v !== "" && !is_array($v)){
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
            trigger_error("curl出错，错误码:$error", E_USER_ERROR);
            return false;
        }
    }

    /*
     * 校验回调支付通知
     */
    public function notifyVerify($code) {
        if (!$this->wx_cfg['wc_mchid'] || !$this->wx_cfg['wc_mchkey'] || !$this->wx_cfg['wc_app_id'] || !$this->wx_cfg['wc_app_secret']) {
            return false;
        }
        $sign           = $code['sign'];
        unset($code['sign']);
        $check_sign     = $this->makeWxpaySign($code, $this->wx_cfg['wc_mchkey']);
        //校验签名
        if ($sign == $check_sign) {
            //验证公众号ID及商户ID
            if ($code['appid'] == $this->wx_cfg['wc_app_id'] && $code['mch_id'] == $this->wx_cfg['wc_mchid']) {
                return true;
            }
        }

        return false;
    }

    /*
     * 校验回调支付通知
     */
    public function fxbNotifyVerify($code) {
        $fxb_wxcfg  = plum_parse_config('fxb_pay', 'weixin');
        $sign           = $code['sign'];
        unset($code['sign']);
        $check_sign     = $this->makeWxpaySign($code, $fxb_wxcfg['mch_key']);
        //校验签名
        if ($sign == $check_sign) {
            //验证公众号ID及商户ID
            if ($code['appid'] == $fxb_wxcfg['app_id'] && $code['mch_id'] == $fxb_wxcfg['mch_id']) {
                return true;
            }
        }

        return false;
    }
}