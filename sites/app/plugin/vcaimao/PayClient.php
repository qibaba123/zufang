<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2018/12/19
 * Time: 10:54 AM
 */
class App_Plugin_Vcaimao_PayClient {
    /*
     * 设备号与签名秘钥，每个小程序一个
     */
    public $device_id;
    public $secret_sign;

    /*
     * 店铺id
     */
    public $sid;

    public function __construct($sid){
        $vcm_model = new App_Model_Wechat_MysqlVcmWxpayStorage($sid);
        $cfg = $vcm_model->findUpdateBySid();
        $this->device_id    = $cfg['vw_device_id'];
        $this->secret_sign  = $cfg['vw_pay_secret'];
        $this->sid = $sid ;
    }
    /*
     * 获取设备号和接口秘钥
     * @param string $client_id 小程序APPID
     */
    public static function getPaySecret($client_id) {
        $dev_cfg    = plum_parse_config('developer', 'vcaimao');
        $req_url    = "http://pay.vcaimao.com/Device/mqauth";
        $fields     = array(
            'clientid'  => $client_id,
            'version'   => '201812',
            'device_id' => $dev_cfg['device_id'],
            'nonce_str' => App_Plugin_Weixin_PayPlugin::getNonceStr(8),
        );
        $sign   = App_Plugin_Weixin_PayPlugin::makeWxpaySign($fields, $dev_cfg['secret']);
        $params = array_merge($fields, array('sign' => $sign));
        $result = Libs_Http_Client::post($req_url, $params);
        return self::_format_response_output($result);
    }
    /*
    * 获取小程序绑定微财猫平台的open_appid
    */
    public function getOpenAppid() {
        $req_url    = "https://pay.vcaimao.com/Wxa/GetOpenAppid";
        $fields     = array(
            'device_id' => $this->device_id,
            'nonce_str' => App_Plugin_Weixin_PayPlugin::getNonceStr(8),
        );
        $sign   = App_Plugin_Weixin_PayPlugin::makeWxpaySign($fields, $this->secret_sign);
        $params = array_merge($fields, array('sign' => $sign));
        $result = Libs_Http_Client::post($req_url, $params);
        return $this->_format_response_output($result);
    }
    /*
     * 通过jscode获取用户的unionid
     */
    public function getUserUnionid($jscode) {
        $req_url    = "https://pay.vcaimao.com/Wxa/Jscode2session";
        $fields     = array(
            'jscode'    => $jscode,
            'device_id' => $this->device_id,
            'nonce_str' => App_Plugin_Weixin_PayPlugin::getNonceStr(8),
        );
        $sign   = App_Plugin_Weixin_PayPlugin::makeWxpaySign($fields, $this->secret_sign);
        $params = array_merge($fields, array('sign' => $sign));
        $result = Libs_Http_Client::post($req_url, $params);
        return $this->_format_response_output($result);
    }
    /*
     * 获取会员信息
     */
    public function getMemberInfo($unionid, $openid) {
        $req_url    = "https://pay.vcaimao.com/MemberCard/GetMemberInfo";
        $fields     = array(
            'unionid'       => $unionid,
            'wxa_openid'    => $openid,
            'device_id'     => $this->device_id,
            'nonce_str'     => App_Plugin_Weixin_PayPlugin::getNonceStr(8),
        );
        $sign   = App_Plugin_Weixin_PayPlugin::makeWxpaySign($fields, $this->secret_sign);
        $params = array_merge($fields, array('sign' => $sign));
        $result = Libs_Http_Client::post($req_url, $params);

        return $this->_format_response_output($result);
    }
    /*
     * 获取会员卡开卡组件参数
     */
    public function getMemberCard() {
        $req_url    = "https://pay.vcaimao.com/MemberCard/GetExtraData";
        $fields     = array(
            'device_id'     => $this->device_id,
            'nonce_str'     => App_Plugin_Weixin_PayPlugin::getNonceStr(8),
        );
        $sign   = App_Plugin_Weixin_PayPlugin::makeWxpaySign($fields, $this->secret_sign);
        $params = array_merge($fields, array('sign' => $sign));
        Libs_Log_Logger::outputLog($params,'test.log');
        $result = Libs_Http_Client::post($req_url, $params);
        Libs_Log_Logger::outputLog($result,'test.log');
        return $this->_format_response_output($result);
    }
    /*
     * 使用储值卡支付
     */
    public function payStoredCard($union_id, $trade_id, $total, $title, array $other = null){
        $req_url    = "https://pay.vcaimao.com/pay/StoredCardPay";
        $fields     = array(
            'unionid'       => $union_id,//用户的unionid
            'out_trade_no'  => $trade_id,//商户订单号
            'total_fee'     => $total,//总金额，单位分
            'body'          => $title,//商品名称
            'device_id'     => $this->device_id,
            'nonce_str'     => App_Plugin_Weixin_PayPlugin::getNonceStr(8),
        );
        if (!is_null($other) && !empty($other)) {
            $fields = array_merge($fields, $other);
        }
        $sign   = App_Plugin_Weixin_PayPlugin::makeWxpaySign($fields, $this->secret_sign);
        $params = array_merge($fields, array('sign' => $sign));
        $result = Libs_Http_Client::post($req_url, $params);

        return $this->_format_response_output($result);
    }
    /*
     * 使用微信支付
     */
    public function payWithWeixin($open_id, $trade_id, $total, $title, array $other = null) {
        $req_url    = "https://pay.vcaimao.com/pay/unifiedorder";
        $fields     = array(
            'sub_openid'    => $open_id,//当前小程序的APPID
            'out_trade_no'  => $trade_id,//商户订单号
            'total_fee'     => $total,//总金额，单位分
            'body'          => $title,//商品名称
            'device_id'     => $this->device_id,
            'nonce_str'     => App_Plugin_Weixin_PayPlugin::getNonceStr(8),
        );
        if (!is_null($other) && !empty($other)) {
            $fields = array_merge($fields, $other);
        }
        $sign   = App_Plugin_Weixin_PayPlugin::makeWxpaySign($fields, $this->secret_sign);
        $params = array_merge($fields, array('sign' => $sign));
        $result = Libs_Http_Client::post($req_url, $params);
        return $this->_format_response_output($result);
    }
    /*
     * 查询支付订单详情
     */
    public function queryPayTrade($trade_id) {
        $req_url    = "https://pay.vcaimao.com/pay/query";
        $fields     = array(
            'out_trade_no'  => $trade_id,//商户订单号
            'device_id'     => $this->device_id,
            'nonce_str'     => App_Plugin_Weixin_PayPlugin::getNonceStr(8),
        );
        $sign   = App_Plugin_Weixin_PayPlugin::makeWxpaySign($fields, $this->secret_sign);
        $params = array_merge($fields, array('sign' => $sign));
        $result = Libs_Http_Client::post($req_url, $params);

        return $this->_format_response_output($result);
    }
    /*
     * 发送订单打印和通知信息
     * @link https://pay.vcaimao.com/Help/Api/POST-Device-SendMsg
     */
    public function sendPrintNotice($trade,$title) {
        $req_url    = "https://pay.vcaimao.com/Device/SendMsg";
        $fields     = array(
            'device_id'     => $this->device_id,
            'nonce_str'     => App_Plugin_Weixin_PayPlugin::getNonceStr(8),
            'title'         => $title,
            'desc'          => $this->_format_trade_print($trade),
        );
        $sign   = App_Plugin_Weixin_PayPlugin::makeWxpaySign($fields, $this->secret_sign);
        $params = array_merge($fields, array('sign' => $sign));
        $result = Libs_Http_Client::post($req_url, $params);
        return $this->_format_response_output($result);
    }
    /*
     * 订单退款
     * @link http://pay.vcaimao.com/Help/Api/POST-pay-refund?from=groupmessage
     */
    public function tradeRefund($trade_no,$amount,$remark=''){
        $req_url    = "https://pay.vcaimao.com/pay/refund";
        $fields     = array(
            'refund_fee'    => $amount,
            'outid'         => $trade_no,
            'refund_desc'   => $remark,
            'device_id'     => $this->device_id,
            'nonce_str'     => App_Plugin_Weixin_PayPlugin::getNonceStr(8),
        );
        $sign   = App_Plugin_Weixin_PayPlugin::makeWxpaySign($fields, $this->secret_sign);
        $params = array_merge($fields, array('sign' => $sign));
        $result = Libs_Http_Client::post($req_url, $params);

        return $this->_format_response_output($result);
    }
    /*
     * 对输出结果进行格式化处理
     * @link https://smartprogram.baidu.com/docs/develop/third/error/
     */
    private function _format_response_output($response) {
        $res = json_decode($response, true);
        $code   = array();
        if ($res['return_code'] == 'FAIL') {//通信错误
            $code['errcode']    = -1;
            $code['errmsg']     = $res['return_msg'];
        } else if ($res['result_code'] == 'FAIL') {
            $code['errcode']    = $res['err_code'];
            $code['errmsg']     = $res['err_code_des'];
        } else {
            $code['errcode']    = 0;
            $code['errmsg']     = '获取成功';
            $code['data']       = $res;
        }
        return $code;
    }

    /*
     * 格式化订单打印数据
     */
    private function _format_trade_print($trade){
        //查询是否已经开通了微财猫会员卡
        $print_storage = new App_Helper_Print($trade['t_s_id']);
        $str = $print_storage->_order_print_str($trade['t_tid'],array());
        $str = preg_replace('/<BR+?>/', '{BR}', $str);
        $str = preg_replace('/<.*?>/', '', $str);
        $str = preg_replace('/{BR+?}/', '<BR>', $str);

        return $str;

    }
}