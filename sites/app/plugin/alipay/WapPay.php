<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/8/22
 * Time: 上午10:52
 */
require_once "lib/alipay_submit.class.php";

class App_Plugin_Alipay_WapPay {

    const GATEWAY_URL   = "https://openapi.alipay.com/gateway.do";

    /*
     * 店铺ID
     */
    private $sid;

    public function __construct($sid) {
        $this->sid = $sid;

    }

    /*
     * 支付宝wap支付统一下单
     * @param string $tid 订单编号
     * @param string $subject 商品名
     * @param float $amount 订单金额
     * @param string $show_url 商品展示URL
     * @param string $notify_url 支付回调URL
     * @param string $return_url 支付通知URL
     */
    public function unifyOrder($tid, $subject, $amount, $show_url, $notify_url, $return_url) {
        $wap_pay    = plum_parse_config('wap_pay', 'alipay');
        //请求参数数组
        $params     = array(
            "service"       => $wap_pay['service'],
            "partner"       => $wap_pay['partner'],
            "seller_id"     => $wap_pay['seller_id'],
            "payment_type"	=> $wap_pay['payment_type'],
            "notify_url"	=> $notify_url,
            "return_url"	=> $return_url,
            "_input_charset"=> trim(strtolower($wap_pay['input_charset'])),
            "out_trade_no"	=> $tid,
            "subject"	=> $subject,
            "total_fee"	=> $amount,
            "show_url"	=> $show_url,
            "app_pay"	=> "Y",//启用此参数能唤起钱包APP支付宝
            "body"	    => $subject,
        );
        $wap_pay['notify_url']  = $notify_url;
        $wap_pay['return_url']  = $return_url;
        $alipay_submit  = new AlipaySubmit($wap_pay);

        $html_text  = $alipay_submit->buildRequestForm($params, "post", "确认");
        return $html_text;
    }

    public function unifyUrlOrder($tid, $subject, $amount, $show_url, $notify_url, $return_url) {
        $wap_pay    = plum_parse_config('wap_pay', 'alipay');
        //请求参数数组
        $params     = array(
            "service"       => $wap_pay['service'],
            "partner"       => $wap_pay['partner'],
            "seller_id"     => $wap_pay['seller_id'],
            "payment_type"	=> $wap_pay['payment_type'],
            "notify_url"	=> $notify_url,
            "return_url"	=> $return_url,
            "_input_charset"=> trim(strtolower($wap_pay['input_charset'])),
            "out_trade_no"	=> $tid,
            "subject"	=> $subject,
            "total_fee"	=> $amount,
            "show_url"	=> $show_url,
            "app_pay"	=> "Y",//启用此参数能唤起钱包APP支付宝
            "body"	    => $subject,
        );
        $wap_pay['notify_url']  = $notify_url;
        $wap_pay['return_url']  = $return_url;
        $alipay_submit  = new AlipaySubmit($wap_pay);

        $request_params = $alipay_submit->buildRequestPara($params);

        $url = $alipay_submit->alipay_gateway_new . '?' . http_build_query($request_params);
        return $url;
    }
    /*
     * 退款
     */
    public function refundPayOrder($pay_no, $refund_no, $refund_money, $notify_url) {
        $wap_refund    = plum_parse_config('wap_refund', 'alipay');
        //请求参数数组
        $params     = array(
            "service"       => $wap_refund['service'],
            "partner"       => $wap_refund['partner'],
            "notify_url"	=> $notify_url,
            "_input_charset"=> trim(strtoupper($wap_refund['input_charset'])),
            "seller_user_id"=> $wap_refund['seller_user_id'],
            "refund_date"   => $wap_refund['refund_date'],
            "batch_no"	    => '201701215968274623',
            "batch_num"	    => 1,
            "detail_data"	=> "{$pay_no}^{$refund_money}^协商退款",
        );
        $wap_refund['notify_url']  = $notify_url;
        $alipay_submit  = new AlipaySubmit($wap_refund);

        $request_params = $alipay_submit->buildRequestPara($params);

        $url = $alipay_submit->alipay_gateway_new . '?' . http_build_query($request_params);

        $response   = Libs_Http_Client::get($url);
        Libs_Log_Logger::outputLog($response);
        Libs_Log_Logger::outputLog($url);
        return false;
        if ($response['alipay_trade_refund_response']['code'] != '10000') {
            return false;
        }
        return $response['alipay_trade_refund_response'];
    }
    /*
     * 生成唯一性批次号
     */
    public static function makeBatchNo($key = '') {
        $shf_str    = (string)mt_rand(10000, 99999).(string)mt_rand(10000, 99999);//十位数字的字符串
        $oid    = array(
            $key,
            date('Ymd', time()),
            str_shuffle($shf_str)
        );

        return join('', $oid);
    }
    /*
     * 生成RSA签名
     */
    public static function makeSign(array $params) {
        ksort($params, SORT_NATURAL);

        $sign_data  = http_build_query($params);

        return base64_encode(sha1($sign_data));
    }
    /*
     * 生成RSA2签名
     */
    public static function makeRSA2Sign(array $params) {
        ksort($params, SORT_NATURAL);

        $sign_data  = http_build_query($params);

        return base64_encode(hash('sha256', $sign_data));
    }
}