<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/8/2
 * Time: 下午4:06
 */
class App_Plugin_Weixin_NewPay {

    public static $error_map = array(
        40001   => "微信红包自动提现未开启",
        40002   => "微信支付商户信息配置不正确",
        40003   => "请求参数转换XML出错",
        40004   => "网络请求错误",
        40005   => "通信错误",
        40006   => "业务请求失败"
    );
    /*
     * 微信红包发放状态
     */
    public static $redpack_receive_status   = array(
        "SENDING"   => 0,//发放中
        "SENT"      => 1,//已发放待领取
        "FAILED"    => 2,//发放失败
        "RECEIVED"  => 3,//已领取
        "REFUND"    => 4,//已退款
    );

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

    /*
     * 微信支付配置,字段名参考表pre_weixin_pay
     */
    public $wx_pay;

    /*
     * 提现配置信息，字段名参考表pre_withdraw_cfg;
     */
    public $wd_cfg;
    /*
     * 数据状态是否准备好
     */
    private $has_ready = true;

    /*
     * 红包发放接口url
     * 企业付款接口url
     */
    private $send_url       = "https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack";
    private $transfer_url   = "https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers";
    private $bank_url       = "https://api.mch.weixin.qq.com/mmpaysptrans/pay_bank";
    private $getkey_url     = "https://fraud.mch.weixin.qq.com/risk/getpublickey";
    private $gethbinfo_url  = "https://api.mch.weixin.qq.com/mmpaymkttransfers/gethbinfo";
    private $group_url      = "https://api.mch.weixin.qq.com/mmpaymkttransfers/sendgroupredpack";
    private $unified_url    = "https://api.mch.weixin.qq.com/pay/unifiedorder";
    private $refund_url     = "https://api.mch.weixin.qq.com/secapi/pay/refund";
    private $queryorder_url     = "https://api.mch.weixin.qq.com/pay/orderquery";

    public function __construct($sid) {
        $this->sid  = $sid;
        //获取店铺数据
        $shop_storage   = new App_Model_Shop_MysqlShopCoreStorage();
        $this->shop     = $shop_storage->getRowById($sid);
        //获取微信支付配置
        $wxpay_storage  = new App_Model_Auth_MysqlWeixinPayStorage($this->sid);
        $this->wx_pay   = $wxpay_storage->findRowPay();
        //提现配置
        $wdcfg_storage  = new App_Model_Shop_MysqlWithdrawCfgStorage();
        $this->wd_cfg   = $wdcfg_storage->findCfgBySid($sid);

        if (!$this->shop || !$this->wx_pay) {
            $this->has_ready = false;
        }
    }

    /*
     * 发送红包功能
     */
    public function sendRedpack($openid, $amount , $actName = '' ,$actShopName = '') {
        if (!isset($this->wd_cfg['wc_wx_open']) || !$this->wd_cfg['wc_wx_open']) {
            $act_name   = $this->shop['s_name'];
        } else {
            $act_name   = $this->wd_cfg['wc_wx_actname'];
        }

        if($actName){
            $act_name = $actName;
        }
        
        if (!$this->has_ready) {
            return array('code' => 40002, 'errmsg' => '支付方式中,微信支付商户信息未配置');
        }

        if (!$this->wx_pay['wp_sslcert'] || !$this->wx_pay['wp_sslkey']) {
            return array('code' => 40003, 'errmsg' => '支付方式中,微信支付商户证书未上传');
        }

        $amount     = round($amount*100);//转化为分
        $mch_id     = $this->wx_pay['wp_mchid'];//商户ID
        $mch_key    = $this->wx_pay['wp_mchkey'];//商户key
        $wx_appid   = $this->wx_pay['wp_appid'];//公众号ID

        $request_params = array(
            'nonce_str'         => self::getNonceStr(24),
            'mch_billno'        => self::makeMchOrderid($mch_id),
            'mch_id'            => $mch_id,//商户号
            'wxappid'           => $wx_appid,//公众号
            'send_name'         => $actShopName ? $actShopName : $this->shop['s_name'],//商户名称
            're_openid'         => $openid,//用户openID
            'total_amount'      => $amount,//单位分
            'total_num'         => 1,
            'wishing'           => $act_name,//红包祝福语
            'act_name'          => $act_name,//活动名称
            'remark'            => $act_name,//备注
            'client_ip'         => plum_get_server('SERVER_ADDR'),
            'scene_id'          => 'PRODUCT_1',
        );
        $request_params = $this->_convert_param_length($request_params);
        $sign   = self::makeWxpaySign($request_params, $mch_key);
        $request_params['sign'] = $sign;
        Libs_Log_Logger::outputLog($request_params);
        if ($xml = $this->toXml($request_params)) {
            $useCert    = array(
                'ssl_cert'  => PLUM_DIR_ROOT.$this->wx_pay['wp_sslcert'],
                'ssl_key'   => PLUM_DIR_ROOT.$this->wx_pay['wp_sslkey']
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
                } else {
                    Libs_Log_Logger::outputLog($ret);
                    return array('code' => 40003, 'errmsg' => $ret['return_msg']);
                }
            }
        }
        return array('code' => 40004, 'errmsg' => '未知错误');
    }

    /*
     * 企业付款到零钱功能
     */
    public function payTransfer($openid, $amount, $realname) {
        if (!$this->has_ready) {
            return array('code' => 40002, 'errmsg' => '支付方式中,微信支付商户信息未配置');
        }
        if (!$this->wx_pay['wp_sslcert'] || !$this->wx_pay['wp_sslkey']) {
            return array('code' => 40003, 'errmsg' => '支付方式中,微信支付商户证书未上传');
        }
        $desc   = "{$this->wd_cfg['wc_wx_actname']}给{$realname}微信转账付款{$amount}元";
        $amount     = round($amount*100);//转化为分
        $mch_id     = $this->wx_pay['wp_mchid'];//商户ID
        $mch_key    = $this->wx_pay['wp_mchkey'];//商户key
        $wx_appid   = $this->wx_pay['wp_appid'];//公众号ID

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
        $sign   = self::makeWxpaySign($request_params, $mch_key);
        $request_params['sign'] = $sign;
        if ($xml = $this->toXml($request_params)) {
            $useCert    = array(
                'ssl_cert'  => PLUM_DIR_ROOT.$this->wx_pay['wp_sslcert'],
                'ssl_key'   => PLUM_DIR_ROOT.$this->wx_pay['wp_sslkey'],
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
                    Libs_Log_Logger::outputLog($ret);
                    return array('code' => 40003, 'errmsg' => $ret['return_msg']);
                }
            }
        }
        return array('code' => 40004, 'errmsg' => '未知错误');
    }
    /*
     * 企业付款到银行卡功能
     */
    public function payBank() {

    }

    /*
     * 发送活动红包功能
     * @param string $openid
     * @param float $amount 单位元
     * @param string $act_name
     * @param string $wishing
     * @param string $remark
     * @return array
     */
    public function sendActRedpack($openid, $amount, $act_name, $wishing, $remark = "") {
        if (!$this->has_ready) {
            return array('code' => 40002, 'errmsg' => '支付方式中,微信支付商户信息未配置');
        }

        if (!$this->wx_pay['wp_sslcert'] || !$this->wx_pay['wp_sslkey']) {
            return array('code' => 40003, 'errmsg' => '支付方式中,微信支付商户证书未上传');
        }

        $amount     = round($amount*100);//转化为分
        $mch_id     = $this->wx_pay['wp_mchid'];//商户ID
        $mch_key    = $this->wx_pay['wp_mchkey'];//商户key
        $wx_appid   = $this->wx_pay['wp_appid'];//公众号ID

        $request_params = array(
            'nonce_str'         => self::getNonceStr(24),
            'mch_billno'        => self::makeMchOrderid($mch_id),
            'mch_id'            => $mch_id,//商户号
            'wxappid'           => $wx_appid,//公众号
            'send_name'         => $this->shop['s_name'],//商户名称
            're_openid'         => $openid,//用户openID
            'total_amount'      => $amount,//单位分
            'total_num'         => 1,
            'wishing'           => $wishing,//红包祝福语
            'act_name'          => $act_name,//活动名称
            'remark'            => $remark,//备注
            'client_ip'         => plum_get_server('SERVER_ADDR'),
        );
        //红包金额大于200或者小于1元时，请求参数scene_id必传
        if($amount < 100 || $amount > 20000){
            $request_params['scene_id'] = 'PRODUCT_1';
        }
        $request_params = $this->_convert_param_length($request_params);
        $sign   = self::makeWxpaySign($request_params, $mch_key);
        $request_params['sign'] = $sign;
        Libs_Log_Logger::outputLog($request_params);
        if ($xml = $this->toXml($request_params)) {
            $useCert    = array(
                'ssl_cert'  => PLUM_DIR_ROOT.$this->wx_pay['wp_sslcert'],
                'ssl_key'   => PLUM_DIR_ROOT.$this->wx_pay['wp_sslkey']
            );
            $ret = self::postXmlCurl($xml, $this->send_url, $useCert);
            $ret = $this->fromXml($ret);
            if ($ret) {
                if ($ret['return_code'] == 'SUCCESS' && $ret['result_code'] == 'SUCCESS') {
                    return array(
                        'code'  => 0,
                        'mch_billno'    => $ret['mch_billno'],//商户订单号
                        'send_listid'   => $ret['send_listid'],//微信订单号
                    );
                } else {
                    Libs_Log_Logger::outputLog($ret);
                    return array('code' => 40003, 'errmsg' => $ret['return_msg']);
                }
            }
        }
        return array('code' => 40004, 'errmsg' => '未知错误');
    }

    /*
     * 发放裂变红包
     * @param string $openid 种子用户
     * @param float $amount 红包总金额
     * @param int $num 红包总人数
     * @param string $act_name 活动名
     * @param string $wishing 祝福语
     * @param string $remark 备注
     * @return array
     */
    public function sendGroupRedpack($openid, $amount, $num, $act_name, $wishing, $remark = "") {
        if (!$this->has_ready) {
            return array('code' => 40002, 'errmsg' => '支付方式中,微信支付商户信息未配置');
        }

        if (!$this->wx_pay['wp_sslcert'] || !$this->wx_pay['wp_sslkey']) {
            return array('code' => 40003, 'errmsg' => '支付方式中,微信支付商户证书未上传');
        }

        $amount     = round($amount*100);//转化为分
        $mch_id     = $this->wx_pay['wp_mchid'];//商户ID
        $mch_key    = $this->wx_pay['wp_mchkey'];//商户key
        $wx_appid   = $this->wx_pay['wp_appid'];//公众号ID

        $request_params = array(
            'nonce_str'         => self::getNonceStr(24),
            'mch_billno'        => self::makeMchOrderid($mch_id),//商户订单号
            'mch_id'            => $mch_id,//商户号
            'wxappid'           => $wx_appid,//公众号
            'send_name'         => $this->shop['s_name'],//商户名称
            're_openid'         => $openid,//用户openID,首个用户
            'total_amount'      => $amount,//单位分,红包发放总金额
            'total_num'         => $num,//红包发放总人数
            'amt_type'          => 'ALL_RAND',//随机发放
            'wishing'           => $wishing,//红包祝福语
            'act_name'          => $act_name,//活动名称
            'remark'            => $remark,//备注
            'client_ip'         => plum_get_server('SERVER_ADDR'),
        );
        $request_params = $this->_convert_param_length($request_params);
        $sign   = self::makeWxpaySign($request_params, $mch_key);
        $request_params['sign'] = $sign;
        if ($xml = $this->toXml($request_params)) {
            $useCert    = array(
                'ssl_cert'  => PLUM_DIR_ROOT.$this->wx_pay['wp_sslcert'],
                'ssl_key'   => PLUM_DIR_ROOT.$this->wx_pay['wp_sslkey']
            );
            $ret = self::postXmlCurl($xml, $this->group_url, $useCert);
            $ret = $this->fromXml($ret);
            if ($ret) {
                if ($ret['return_code'] == 'SUCCESS' && $ret['result_code'] == 'SUCCESS') {
                    return array(
                        'code'  => 0,
                        'mch_billno'    => $ret['mch_billno'],//商户订单号
                        'send_listid'   => $ret['send_listid'],//微信订单号
                    );
                } else {
                    Libs_Log_Logger::outputLog($ret);
                    return array('code' => 40003, 'errmsg' => $ret['return_msg']);
                }
            }
        }
        return array('code' => 40004, 'errmsg' => '未知错误');
    }
    /*
     * 获取红包信息
     * 商户订单号
     */
    public function getActRedpack($billno) {
        if (!$this->has_ready) {
            return array('code' => 40002, 'errmsg' => '支付方式中,微信支付商户信息未配置');
        }

        if (!$this->wx_pay['wp_sslcert'] || !$this->wx_pay['wp_sslkey']) {
            return array('code' => 40003, 'errmsg' => '支付方式中,微信支付商户证书未上传');
        }

        $mch_id     = $this->wx_pay['wp_mchid'];//商户ID
        $mch_key    = $this->wx_pay['wp_mchkey'];//商户key
        $wx_appid   = $this->wx_pay['wp_appid'];//公众号ID

        $request_params = array(
            'nonce_str'         => self::getNonceStr(24),
            'mch_billno'        => $billno,
            'mch_id'            => $mch_id,//商户号
            'appid'             => $wx_appid,//公众号
            'bill_type'         => "MCHT",
        );
        $sign   = self::makeWxpaySign($request_params, $mch_key);
        $request_params['sign'] = $sign;
        if ($xml = $this->toXml($request_params)) {
            $useCert    = array(
                'ssl_cert'  => PLUM_DIR_ROOT.$this->wx_pay['wp_sslcert'],
                'ssl_key'   => PLUM_DIR_ROOT.$this->wx_pay['wp_sslkey']
            );
            $ret = self::postXmlCurl($xml, $this->gethbinfo_url, $useCert);
            $ret = $this->fromXml($ret);
            if ($ret) {
                Libs_Log_Logger::outputLog($ret);
                if ($ret['return_code'] == 'SUCCESS' && $ret['result_code'] == 'SUCCESS') {
                    return array(
                        'code'  => 0,
                        'mch_billno'    => $ret['mch_billno'],//商户订单号
                        'detail_id'     => $ret['detail_id'],//红包订单号
                        'send_status'   => self::$redpack_receive_status[$ret['status']],
                        'reason'        => $ret['reason'],
                    );
                } else {
                    Libs_Log_Logger::outputLog($ret);
                    return array('code' => 40003, 'errmsg' => $ret['return_msg']);
                }
            }
        }
        return array('code' => 40004, 'errmsg' => '未知错误');
    }
    /*
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
        if (!$this->has_ready) {
            Libs_Log_Logger::outputLog("微信支付未配置");
            return false;
        }
        $amount     = round($amount*100);//转化为分
        $body       = mb_strlen($body, 'UTF-8') > 40 ? mb_substr($body, 0, 40, 'UTF-8') : $body;
        $mch_id     = $this->wx_pay['wp_mchid'];//商户ID
        $mch_key    = $this->wx_pay['wp_mchkey'];//商户key
        $wx_appid   = $this->wx_pay['wp_appid'];//公众号ID

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
        $sign   = self::makeWxpaySign($request_params, $mch_key);
        $request_params['sign'] = $sign;
        Libs_Log_Logger::outputLog($request_params);
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
                        'app_key'       => $mch_key,
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
        if (!$this->has_ready) {
            Libs_Log_Logger::outputLog("微信支付未配置");
            return false;
        }
        $amount     = round($amount*100);//转化为分
        $body       = mb_strlen($body, 'UTF-8') > 40 ? mb_substr($body, 0, 40, 'UTF-8') : $body;
        $mch_id     = $this->wx_pay['wp_mchid'];//商户ID
        $mch_key    = $this->wx_pay['wp_mchkey'];//商户key
        $wx_appid   = $this->wx_pay['wp_appid'];//公众号ID

        $request_params = array(
            'appid'             => $wx_appid,//公众号ID
            'mch_id'            => $mch_id,//商户号
            'nonce_str'         => self::getNonceStr(24),
            'body'              => $body,
            'out_trade_no'      => $tid,//商户内部订单号
            'total_fee'         => $amount,//单位分
            'spbill_create_ip'  => plum_get_server('SERVER_ADDR'),
            'notify_url'        => $notify_url,
            'trade_type'        => 'NATIVE',
            'product_id'        => $pid,
        );
        $request_params = array_merge($request_params, $other);
        $sign   = self::makeWxpaySign($request_params, $mch_key);
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
                        'app_key'       => $mch_key,
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

        $mch_id     = $this->wx_pay['wp_mchid'];//商户ID
        $mch_key    = $this->wx_pay['wp_mchkey'];//商户key
        $wx_appid   = $this->wx_pay['wp_appid'];//公众号ID
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
            'refund_account'    => 'REFUND_SOURCE_RECHARGE_FUNDS',
        );

        $sign   = self::makeWxpaySign($request_params, $mch_key);
        $request_params['sign'] = $sign;

        if ($xml = $this->toXml($request_params)) {
            $useCert    = array(
                'ssl_cert'  => PLUM_DIR_ROOT.$this->wx_pay['wp_sslcert'],
                'ssl_key'   => PLUM_DIR_ROOT.$this->wx_pay['wp_sslkey']
            );
            $ret = self::postXmlCurl($xml, $this->refund_url, $useCert);
            $ret = $this->fromXml($ret);
            Libs_Log_Logger::outputLog($ret);
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
    public function notifyVerify($code) {
        if (!$this->has_ready) {
            Libs_Log_Logger::outputLog("微信支付未配置");
            return false;
        }
        $mch_id     = $this->wx_pay['wp_mchid'];//商户ID
        $mch_key    = $this->wx_pay['wp_mchkey'];//商户key
        $wx_appid   = $this->wx_pay['wp_appid'];//公众号ID

        $sign           = $code['sign'];
        unset($code['sign']);
        $check_sign     = $this->makeWxpaySign($code, $mch_key);
        //校验签名
        if ($sign == $check_sign) {
            //验证公众号ID及商户ID
            if ($code['appid'] == $wx_appid && $code['mch_id'] == $mch_id) {
                return true;
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


    /**
     * 小程序支付（商家版）
     */
    public function appletPayRecharge($amount, $openid, $tid, $notify_url, $body, $other=array()){

        $amount     = round($amount*100);//转化为分
        $body       = mb_strlen($body, 'UTF-8') > 40 ? mb_substr($body, 0, 40, 'UTF-8') : $body;
        $appcfg     = plum_parse_config('xcx_login','weixin');  // 获取小程序APPid
        $paycfg     = plum_parse_config('fxb_pay','weixin');    // 获取支付相关配置

        $request_params = array(
            'appid'             => $appcfg['app_id'], //小程序ID
            'mch_id'            => $paycfg['mch_id'], //商户号
            'nonce_str'         => self::getNonceStr(24),
            'body'              => $body,
            'out_trade_no'      => $tid,//商户内部订单号
            'total_fee'         => $amount,//单位分
            'spbill_create_ip'  => plum_get_server('SERVER_ADDR'),
            'notify_url'        => $notify_url,
            'trade_type'        => 'JSAPI',
            'openid'            => $openid,
            'attach'            => $other['attach']
        );
        $request_params = array_merge($request_params, $other);
        $sign   = self::makeWxpaySign($request_params, $paycfg['mch_key']);
        $request_params['sign'] = $sign;
        Libs_Log_Logger::outputLog($request_params);
        if ($xml = $this->toXml($request_params)) {
            $ret = self::postXmlCurl($xml, $this->unified_url);
            Libs_Log_Logger::outputLog($ret);
            $ret = $this->fromXml($ret);
            if ($ret) {
                if ($ret['return_code'] == 'SUCCESS' && $ret['result_code'] == 'SUCCESS') {
                    return array(
                        'code'          => 0,
                        'appid'         => $ret['appid'],
                        'mch_id'        => $ret['mch_id'],
                        'trade_type'    => $ret['trade_type'],
                        'prepay_id'     => $ret['prepay_id'],
                        'app_key'       => $paycfg['mch_key'],
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
     * 小程序订单支付（买家版）
     */
    public function appletReserveOrderPayRecharge($amount, $openid, $tid, $notify_url, $body, $other=array()){

        $amount     = round($amount*100);//转化为分
        $body       = mb_strlen($body, 'UTF-8') > 40 ? mb_substr($body, 0, 40, 'UTF-8') : $body;

        // 获取小程序配置及支付相关配置
//        $applet_storage = new App_Model_Applet_MysqlCfgStorage($this->sid);
//        $appcfg = $applet_storage->findShopCfg();
        $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
        $appcfg = $appletPay_Model->findRowPay();
        if(!$appcfg){
            return 40005 ;    // 未配置微信支付
        }
        $request_params = array(
            'appid'             => $appcfg['ap_appid'], //小程序ID
            'mch_id'            => $appcfg['ap_mchid'], //商户号
            'nonce_str'         => self::getNonceStr(24),
            'body'              => $body,
            'out_trade_no'      => $tid,//商户内部订单号
            'total_fee'         => $amount,//单位分
            'spbill_create_ip'  => plum_get_server('SERVER_ADDR'),
            'notify_url'        => $notify_url,
            'trade_type'        => 'JSAPI',
            'openid'            => $openid,
            'attach'            => $other['attach']
        );
        if($this->sid == 4546){
            Libs_Log_Logger::outputLog('3333','test.log');
        }
        $request_params = array_merge($request_params, $other);
        $sign   = self::makeWxpaySign($request_params, $appcfg['ap_mchkey']);
        $request_params['sign'] = $sign;
        if ($xml = $this->toXml($request_params)) {
            $ret = self::postXmlCurl($xml, $this->unified_url);
            $ret = $this->fromXml($ret);
            if($this->sid == 10871){
                Libs_Log_Logger::outputLog($appcfg,'test.log');
                Libs_Log_Logger::outputLog($request_params,'test.log');
                Libs_Log_Logger::outputLog($ret,'test.log');
            }
            if ($ret) {
                if ($ret['return_code'] == 'SUCCESS' && $ret['result_code'] == 'SUCCESS') {
                    return array(
                        'code'          => 0,
                        'appid'         => $ret['appid'],
                        'mch_id'        => $ret['mch_id'],
                        'trade_type'    => $ret['trade_type'],
                        'prepay_id'     => $ret['prepay_id'],
                        'app_key'       => $appcfg['ap_mchkey'],
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
     * 小程序订单支付（买家版）
     */
    public function appletOrderPayRecharge($amount, $openid, $tid, $notify_url, $body, $other=array()){

        $amount     = round($amount*100);//转化为分
        $body       = mb_strlen($body, 'UTF-8') > 40 ? mb_substr($body, 0, 40, 'UTF-8') : $body;

        // 获取小程序配置及支付相关配置
//        $applet_storage = new App_Model_Applet_MysqlCfgStorage($this->sid);
//        $appcfg = $applet_storage->findShopCfg();
        $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
        $appcfg = $appletPay_Model->findRowPay();
        if(!$appcfg){
            return 40005 ;    // 未配置微信支付
        }
        $request_params = array(
            'appid'             => $appcfg['ap_appid'], //小程序ID
            'mch_id'            => $appcfg['ap_mchid'], //商户号
            'nonce_str'         => self::getNonceStr(24),
            'body'              => $body,
            'out_trade_no'      => $tid,//商户内部订单号
            'total_fee'         => $amount,//单位分
            'spbill_create_ip'  => plum_get_server('SERVER_ADDR'),
            'notify_url'        => $notify_url,
            'trade_type'        => 'JSAPI',
            'openid'            => $openid,
            'attach'            => $other['attach']
        );
        if($this->sid == 4546){
            Libs_Log_Logger::outputLog('3333','test.log');
        }
        $request_params = array_merge($request_params, $other);
        $sign   = self::makeWxpaySign($request_params, $appcfg['ap_mchkey']);
        $request_params['sign'] = $sign;
        if ($xml = $this->toXml($request_params)) {
            $ret = self::postXmlCurl($xml, $this->unified_url);
            $ret = $this->fromXml($ret);
            if($this->sid == 10871){
                Libs_Log_Logger::outputLog($appcfg,'test.log');
                Libs_Log_Logger::outputLog($request_params,'test.log');
                Libs_Log_Logger::outputLog($ret,'test.log');
            }
            if ($ret) {
                if ($ret['return_code'] == 'SUCCESS' && $ret['result_code'] == 'SUCCESS') {
                    return array(
                        'code'          => 0,
                        'appid'         => $ret['appid'],
                        'mch_id'        => $ret['mch_id'],
                        'trade_type'    => $ret['trade_type'],
                        'prepay_id'     => $ret['prepay_id'],
                        'app_key'       => $appcfg['ap_mchkey'],
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
     * 分身小程序订单支付（买家版）
     */
    public function appletChildOrderPayRecharge($appid, $amount, $openid, $tid, $notify_url, $body, $other=array()){

        $amount     = round($amount*100);//转化为分
        $body       = mb_strlen($body, 'UTF-8') > 40 ? mb_substr($body, 0, 40, 'UTF-8') : $body;

        // 获取小程序配置及支付相关配置
        //获取分身小程序信息
        $child_cfg = new App_Model_Applet_MysqlChildStorage();
        $child = $child_cfg->fetchUpdateWxcfgByAid($appid);
        if(!$child['ac_mchid'] || !$child['ac_mchkey']){
            return 40005 ;    // 未配置微信支付
        }
        $request_params = array(
            'appid'             => $child['ac_appid'], //小程序ID
            'mch_id'            => $child['ac_mchid'], //商户号
            'nonce_str'         => self::getNonceStr(24),
            'body'              => $body,
            'out_trade_no'      => $tid,//商户内部订单号
            'total_fee'         => $amount,//单位分
            'spbill_create_ip'  => plum_get_server('SERVER_ADDR'),
            'notify_url'        => $notify_url,
            'trade_type'        => 'JSAPI',
            'openid'            => $openid,
            'attach'            => $other['attach']
        );
        $request_params = array_merge($request_params, $other);
        $sign   = self::makeWxpaySign($request_params, $child['ac_mchkey']);
        $request_params['sign'] = $sign;
        Libs_Log_Logger::outputLog('分身支付');
        Libs_Log_Logger::outputLog($request_params);
        if ($xml = $this->toXml($request_params)) {
            $ret = self::postXmlCurl($xml, $this->unified_url);
            $ret = $this->fromXml($ret);
            Libs_Log_Logger::outputLog($ret);
            if ($ret) {
                if ($ret['return_code'] == 'SUCCESS' && $ret['result_code'] == 'SUCCESS') {
                    return array(
                        'code'          => 0,
                        'appid'         => $ret['appid'],
                        'mch_id'        => $ret['mch_id'],
                        'trade_type'    => $ret['trade_type'],
                        'prepay_id'     => $ret['prepay_id'],
                        'app_key'       => $child['ac_mchkey'],
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
     * 小程序校验回调支付通知（买家版订单支付）
     */
    public function notifyVerifyApplet($code, $appid) {
        // 获取小程序配置及支付相关配置
//        $applet_storage = new App_Model_Applet_MysqlCfgStorage($this->sid);
//        $appcfg = $applet_storage->findShopCfg();
        if($appid){
            $child_cfg = new App_Model_Applet_MysqlChildStorage();
            $child = $child_cfg->fetchUpdateWxcfgByAid($appid);
        }
        if($child && $child['ac_s_id']==$this->sid){
            $appcfg['ap_appid']  = $child['ac_appid'];
            $appcfg['ap_mchkey'] = $child['ac_mchkey'];
            $appcfg['ap_mchid']  = $child['ac_mchid'];
        }else{
            $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
            $appcfg = $appletPay_Model->findRowPay();
            if($appcfg && $appcfg['ap_sub_pay']==1){
                // 服务商支付配置
                $agentPay_Model = new App_Model_Agent_MysqlAgentPayStorage(0);
                $agent_pay_cfg = $agentPay_Model->getAgentPayBySid($this->sid);
                $appcfg['ap_appid']  = $agent_pay_cfg['ap_appid'];
                $appcfg['ap_mchkey'] = $agent_pay_cfg['ap_mchkey'];
                $appcfg['ap_mchid']  = $agent_pay_cfg['ap_mchid'];
            }
        }

        if (!$this->shop || !$appcfg) {
            Libs_Log_Logger::outputLog("微信支付未配置");
            return false;
        }
        $sign           = $code['sign'];
        unset($code['sign']);
        $check_sign     = $this->makeWxpaySign($code, $appcfg['ap_mchkey']);
        //校验签名
        if ($sign == $check_sign) {
            //验证小程序ID及商户ID
            if ($code['appid'] == $appcfg['ap_appid'] && $code['mch_id'] == $appcfg['ap_mchid']) {
                return true;
            }
        }

        return false;
    }

    /**
     * 小程序支付退款
     */
    /*
     * 退款
     * @param string $num_type  'sh'/'wx' $tid为商户单号,还是微信单号
     * @param int $source 默认2 从余额退款  1表示从待结算退款
     */
    public function appletRefundPayOrder($tid, $rfid, $total_fee, $refund_fee, $num_type = 'sh', $source = 2) {
        $total_fee  = round($total_fee*100);//转化为分
        $refund_fee = round($refund_fee*100);//转化为分

//        $mch_id     = $this->wx_pay['wp_mchid'];//商户ID
//        $mch_key    = $this->wx_pay['wp_mchkey'];//商户key
//        $wx_appid   = $this->wx_pay['wp_appid'];//公众号ID
        $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
        $appcfg = $appletPay_Model->findRowPay();
        $dhtype     = $num_type == 'sh' ? "out_trade_no" : "transaction_id";

        $request_params = array(
            'appid'             => $appcfg['ap_appid'],//公众号ID
            'mch_id'            => $appcfg['ap_mchid'],//商户号
            'nonce_str'         => self::getNonceStr(24),
            $dhtype             => $tid,//商户内部订单号或微信单号
            'out_refund_no'     => $rfid,
            'total_fee'         => $total_fee,//单位分
            'refund_fee'        => $refund_fee,
            'op_user_id'        => $appcfg['ap_mchid'],
            'refund_account'    => $source==1?'REFUND_SOURCE_UNSETTLED_FUNDS':'REFUND_SOURCE_RECHARGE_FUNDS',
            //'refund_account'    => 'REFUND_SOURCE_UNSETTLED_FUNDS',
        );

        Libs_Log_Logger::outputLog($request_params);

        $sign   = self::makeWxpaySign($request_params, $appcfg['ap_mchkey']);
        $request_params['sign'] = $sign;

        if ($xml = $this->toXml($request_params)) {
            $useCert    = array(
                'ssl_cert'  => PLUM_DIR_ROOT.$appcfg['ap_sslcert'],
                'ssl_key'   => PLUM_DIR_ROOT.$appcfg['ap_sslkey']
            );
            $ret = self::postXmlCurl($xml, $this->refund_url, $useCert);
            $ret = $this->fromXml($ret);
            Libs_Log_Logger::outputLog($ret);
            if ($ret) {
                if ($ret['return_code'] == 'SUCCESS' && $ret['result_code'] == 'SUCCESS') {
                    //退款成功,做相应处理
                    return array(
                        'code'          => $ret['result_code'],
                        'appid'         => $ret['appid'],
                        'mch_id'        => $ret['mch_id'],
                        'tid'           => $ret['out_trade_no'],
                        'refund_id'     => $ret['out_refund_no'],
                        'refund_fee'    => $ret['refund_fee'],
                        'total_fee'     => $ret['total_fee'],
                    );
                }else if ($ret['return_code'] == 'SUCCESS' && $ret['result_code'] == 'FAIL'){   // 提交成功但业务结果处理失败
                    return array(
                        'code'   => 'FAIL',
                        'errmsg' => $ret['err_code_des'],
                    );
                }else{
                    return array(
                        'code'   => 'FAIL',
                        'errmsg' => $ret['return_msg'],
                    );
                }
            }
        }
        return false;
    }

    /*
     * 小程序发送红包功能(微信限制暂不能使用2017.1.3)
     * @param float $amount 单位元
     */
    public function appletSendRedpack($openid, $amount) {
        $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
        $appcfg = $appletPay_Model->findRowPay();
        if (!isset($this->wd_cfg['wc_wx_open']) || !$this->wd_cfg['wc_wx_open']) {
            $act_name   = $this->shop['s_name'];
        } else {
            $act_name   = $this->wd_cfg['wc_wx_actname'];
        }

        if (!$appcfg) {
            return array('code' => 40002, 'errmsg' => '支付方式中,微信支付商户信息未配置');
        }

        if (!$appcfg['ap_sslcert'] || !$appcfg['ap_sslkey']) {
            return array('code' => 40003, 'errmsg' => '支付方式中,微信支付商户证书未上传');
        }
        $amount     = round($amount*100);//转化为分
        $mch_id     = $appcfg['ap_mchid'];//商户ID
        $mch_key    = $appcfg['ap_mchkey'];//商户key
        $wx_appid   = $appcfg['ap_appid'];//公众号ID

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
        $sign   = self::makeWxpaySign($request_params, $mch_key);
        $request_params['sign'] = $sign;
        Libs_Log_Logger::outputLog($request_params);
        if ($xml = $this->toXml($request_params)) {
            $useCert    = array(
                'ssl_cert'  => PLUM_DIR_ROOT.$appcfg['ap_sslcert'],
                'ssl_key'   => PLUM_DIR_ROOT.$appcfg['ap_sslkey']
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
                } else {
                    Libs_Log_Logger::outputLog($ret);
                    return array('code' => 40003, 'errmsg' => $ret['return_msg'].':'.$ret['err_code_des']);
                }
            }
        }
        return array('code' => 40004, 'errmsg' => '未知错误');
    }

    /*
     * 企业付款功能(小程序专用)
     * @param float $amount 单位元
     */
    public function appletPayTransfer($openid, $amount, $realname) {
        $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
        $appcfg = $appletPay_Model->findRowPay();
        if (!$appcfg) {
            return array('code' => 40002, 'errmsg' => '支付方式中,微信支付商户信息未配置');
        }
        if (!$appcfg['ap_sslcert'] || !$appcfg['ap_sslkey']) {
            return array('code' => 40003, 'errmsg' => '支付方式中,微信支付商户证书未上传');
        }
        $desc   = "{$this->shop['s_name']}给{$realname}微信转账付款{$amount}元";
        $amount     = round($amount*100);//转化为分
        $mch_id     = $appcfg['ap_mchid'];//商户ID
        $mch_key    = $appcfg['ap_mchkey'];//商户key
        $wx_appid   = $appcfg['ap_appid'];//公众号ID

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
            'spbill_create_ip'  => plum_get_server('SERVER_ADDR')?plum_get_server('SERVER_ADDR'):'115.28.177.35',
        );
        Libs_Log_Logger::outputLog($request_params);
        $sign   = self::makeWxpaySign($request_params, $mch_key);
        $request_params['sign'] = $sign;
        if ($xml = $this->toXml($request_params)) {
            $useCert    = array(
                'ssl_cert'  => PLUM_DIR_ROOT.$appcfg['ap_sslcert'],
                'ssl_key'   => PLUM_DIR_ROOT.$appcfg['ap_sslkey'],
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
                    Libs_Log_Logger::outputLog($ret);
                    return array('code' => 40003, 'errmsg' => $ret['return_msg'].':'.$ret['err_code_des']);
                }
            }
        }
        return array('code' => 40004, 'errmsg' => '未知错误');
    }

    /*
     * 微信小程序企业付款到银行卡
     * @param $bank_card
     * @param $realname
     * @param $bank_code
     * @param $amount
     * @return array
     */
    public function appletPayBank($bank_card, $realname, $bank_code, $amount) {
        $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
        $appcfg = $appletPay_Model->findRowPay();
        if (!$appcfg) {
            return array('code' => 40002, 'errmsg' => '支付方式中,微信支付商户信息未配置');
        }
        if (!$appcfg['ap_sslcert'] || !$appcfg['ap_sslkey']) {
            return array('code' => 40003, 'errmsg' => '支付方式中,微信支付商户证书未上传');
        }
        if (!$appcfg['ap_pubpem']) {
            return array('code' => 40009, 'errmsg' => '支付方式中,微信支付RSA公钥未生成');
        }

        $desc   = "{$this->shop['s_name']}给{$realname}微信转账付款{$amount}元";
        $amount     = round($amount*100);//转化为分
        $mch_id     = $appcfg['ap_mchid'];//商户ID
        $mch_key    = $appcfg['ap_mchkey'];//商户key
        $wx_appid   = $appcfg['ap_appid'];//公众号ID


        $request_params = array(
            'nonce_str'         => self::getNonceStr(24),
            'partner_trade_no'  => self::makeMchOrderid($mch_id),
            'mch_id'            => $mch_id,//商户号
            'enc_bank_no'       => $this->_rsa_encrypt_data($bank_card, $appcfg['ap_pubpem']),//收款方银行卡号
            'enc_true_name'     => $this->_rsa_encrypt_data($realname, $appcfg['ap_pubpem']),//收款方用户名
            'bank_code'         => $bank_code,//收款方开户行
            'amount'            => $amount,//单位分
            'desc'              => $desc,//备注
        );
        $sign   = self::makeWxpaySign($request_params, $mch_key);
        $request_params['sign'] = $sign;
        if ($xml = $this->toXml($request_params)) {
            $useCert    = array(
                'ssl_cert'  => PLUM_DIR_ROOT.$appcfg['ap_sslcert'],
                'ssl_key'   => PLUM_DIR_ROOT.$appcfg['ap_sslkey'],
            );
            $ret = self::postXmlCurl($xml, $this->bank_url, $useCert);
            $ret = $this->fromXml($ret);
            if ($ret) {
                if ($ret['return_code'] == 'SUCCESS' && $ret['result_code'] == 'SUCCESS') {
                    return array(
                        'code'  => 0,
                        'mch_billno'    => $ret['partner_trade_no'],//商户订单号
                        'send_listid'   => $ret['payment_no'],//微信订单号
                    );
                } else {
                    Libs_Log_Logger::outputLog($ret);
                    return array('code' => 40003, 'errmsg' => $ret['return_msg'].':'.$ret['err_code_des']);
                }
            }
        }
        return array('code' => 40004, 'errmsg' => '未知错误');
    }

    /**
     * 使用RSA加密算法获取base64转换后的密文
     * @param $data
     * @param $pem_file
     * @return bool|string
     */
    private function _rsa_encrypt_data($data, $pem_file) {
        $content    = file_get_contents(PLUM_APP_FILE.'/'.$pem_file);
        $key_id = openssl_pkey_get_public($content);
        if (openssl_public_encrypt($data, $crypted, $key_id, OPENSSL_PKCS1_OAEP_PADDING)) {
            return base64_encode($crypted);
        }
        return false;
    }

    /*
     * 获取商户RSA公钥
     * @return array
     */
    public function appletPublicKey() {
        $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
        $appcfg = $appletPay_Model->findRowPay();
        if (!$appcfg) {
            return array('code' => 40002, 'errmsg' => '支付方式中,微信支付商户信息未配置');
        }
        if (!$appcfg['ap_sslcert'] || !$appcfg['ap_sslkey']) {
            return array('code' => 40003, 'errmsg' => '支付方式中,微信支付商户证书未上传');
        }
        $mch_id     = $appcfg['ap_mchid'];//商户ID
        $mch_key    = $appcfg['ap_mchkey'];//商户key

        $request_params = array(
            'nonce_str'         => self::getNonceStr(24),
            'mch_id'            => $mch_id,//商户号
            'sign_type'         => 'MD5',
        );
        $sign   = self::makeWxpaySign($request_params, $mch_key);
        $request_params['sign'] = $sign;

        if ($xml = $this->toXml($request_params)) {
            $useCert    = array(
                'ssl_cert'  => PLUM_DIR_ROOT.$appcfg['ap_sslcert'],
                'ssl_key'   => PLUM_DIR_ROOT.$appcfg['ap_sslkey'],
            );
            $ret = self::postXmlCurl($xml, $this->getkey_url, $useCert);
            $ret = $this->fromXml($ret);
            if ($ret) {
                if ($ret['return_code'] == 'SUCCESS' && $ret['result_code'] == 'SUCCESS') {
                    //保存文件
                    if (plum_setmod_dir(PLUM_APP_FILE)) {
                        $name       = plum_random(24).'.pem';
                        $filename   = PLUM_APP_FILE.'/'.$name;
                        file_put_contents($filename, $ret['pub_key']);

                        shell_exec("openssl rsa -RSAPublicKey_in -in {$filename} -out {$filename}");

                        return array(
                            'code'  => 0,
                            'filename'    => $name,
                        );
                    }
                } else {
                    Libs_Log_Logger::outputLog($ret);
                    return array('code' => 40003, 'errmsg' => $ret['return_msg']);
                }
            }
        }
        return array('code' => 40004, 'errmsg' => '未知错误');
    }

    /*
     * 小程序查询付款到银行卡状态
     * @param $trade_no
     * @return array|bool|mixed
     * @link https://pay.weixin.qq.com/wiki/doc/api/tools/mch_pay.php?chapter=24_3
     */
    public function appletQueryBank($trade_no) {
        $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
        $appcfg = $appletPay_Model->findRowPay();
        if (!$appcfg) {
            return array('code' => 40002, 'errmsg' => '支付方式中,微信支付商户信息未配置');
        }
        if (!$appcfg['ap_sslcert'] || !$appcfg['ap_sslkey']) {
            return array('code' => 40003, 'errmsg' => '支付方式中,微信支付商户证书未上传');
        }
        $mch_id     = $appcfg['ap_mchid'];//商户ID
        $mch_key    = $appcfg['ap_mchkey'];//商户key

        $request_params = array(
            'nonce_str'         => self::getNonceStr(24),
            'mch_id'            => $mch_id,//商户号
            'partner_trade_no'  => $trade_no,
        );
        $sign   = self::makeWxpaySign($request_params, $mch_key);
        $request_params['sign'] = $sign;

        if ($xml = $this->toXml($request_params)) {
            $useCert    = array(
                'ssl_cert'  => PLUM_DIR_ROOT.$appcfg['ap_sslcert'],
                'ssl_key'   => PLUM_DIR_ROOT.$appcfg['ap_sslkey'],
            );
            $ret = self::postXmlCurl($xml, $this->getkey_url, $useCert);
            $ret = $this->fromXml($ret);
            if ($ret) {
                if ($ret['return_code'] == 'SUCCESS' && $ret['result_code'] == 'SUCCESS') {
                    $ret['code']    = 0;
                    return $ret;
                } else {
                    Libs_Log_Logger::outputLog($ret);
                    return array('code' => 40003, 'errmsg' => $ret['return_msg']);
                }
            }
        }
        return array('code' => 40004, 'errmsg' => '未知错误');
    }

    /*
    * 查询付款功能(小程序专用)
    *
    */
    public function appletQueryOrder($tid) {
        $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
        $appcfg = $appletPay_Model->findRowPay();
        if (!$appcfg) {
            return array('code' => 40002, 'errmsg' => '支付方式中,微信支付商户信息未配置');
        }
        $mch_id     = $appcfg['ap_mchid'];//商户ID
        $mch_key    = $appcfg['ap_mchkey'];//商户key
        $wx_appid   = $appcfg['ap_appid'];//公众号ID

        $request_params = array(
            'appid'             => $wx_appid,
            'mch_id'            => $mch_id,
            'out_trade_no'      => $tid,
            'nonce_str'         => self::getNonceStr(24),
        );
        $sign   = self::makeWxpaySign($request_params, $mch_key);
        $request_params['sign'] = $sign;
        if ($xml = $this->toXml($request_params)) {
            $ret = self::postXmlCurl($xml, $this->queryorder_url);
            $ret = $this->fromXml($ret);
            if ($ret) {
                if ($ret['return_code'] == 'SUCCESS' && $ret['result_code'] == 'SUCCESS') {
                    return array(
                        'code'  => 0,
                        'data'  => $ret
                    );
                } else {
                    Libs_Log_Logger::outputLog($ret);
                    return array('code' => 40003, 'errmsg' => $ret['return_msg'].':'.$ret['err_code_des']);
                }
            }
        }
        return array('code' => 40004, 'errmsg' => '未知错误');
    }
}