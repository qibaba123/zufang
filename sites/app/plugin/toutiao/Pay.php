<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2018/9/12
 * Time: 下午6:09
 */


class App_Plugin_Toutiao_Pay{

    const GATEWAY_URL   = "https://tp-pay.snssdk.com/gateway";
    const API_VERSION   = '1.0';

    public $client;
    public $alixcx_conf;

    public $sid;
    public $alixcx_app;

    public $app_auth_token;

    public function __construct($sid) {
        $this->sid  = $sid;
        //获取店铺数据
        $shop_storage   = new App_Model_Shop_MysqlShopCoreStorage();
        $this->shop     = $shop_storage->getRowById($sid);

        // 获取小程序百度支付相关配置
        $appletPay_Model = new App_Model_Baidu_MysqlBaiduPayCfgStorage($this->sid);
        $this->paycfg = $appletPay_Model->findRowPay();

        $this->rsaPriKeyStr = PLUM_DIR_ROOT.$this->paycfg['abp_private_rsa_key'];  //私钥文件
        $this->rsaPubKeyStr = PLUM_DIR_ROOT.$this->paycfg['abp_public_rsa_key'];   //公钥文件
    }

    /**
     * 小程序订单支付（买家版）
     */
    public function appletOrderPayRecharge($amount, $openid, $tid, $notify_url, $body, $trade_create_time, $trade_valid_time, $other=array()){

        $amount     = round($amount*100);//转化为分
        $body       = mb_strlen($body, 'UTF-8') > 40 ? mb_substr($body, 0, 40, 'UTF-8') : $body;

        // 获取小程序配置及支付相关配置
        $appletPay_Model = new App_Model_Toutiao_MysqlToutiaoPayStorage($this->sid);
        $appcfg = $appletPay_Model->findRowPay();
        if(!$appcfg){
            return 40005 ;    // 未配置头条支付
        }
        $request_params = array(
            'app_id' => $appcfg['atp_appid'],
            'method' => 'tp.trade.create',
            'charset' => 'utf-8',
            'sign_type' => 'MD5',
            'timestamp' => time(),
            'version'   => self::API_VERSION,
            'biz_content' => array(
                'out_order_no' => $tid,
                'uid' => $openid,
                'merchant_id' => $appcfg['atp_mchid'],
                'total_amount' => $amount,
                'currency' => 'CNY',
                'subject' => $body,
                'body' => $body,
                'trade_time' => $trade_create_time,  // 下单时间
                'valid_time' => $trade_valid_time,   // 订单有效时间（秒）
                'notify_url' => $notify_url,
                'risk_info'  => array(
                    'ip' => plum_get_server('SERVER_ADDR')
                ),
                'ext_param'  => $other['attach']
            )
        );

        $request_params = array_merge($request_params, $other);
        $sign   = self::makeToutiaoSign($request_params, $appcfg['atp_secret']);
        $request_params['sign'] = $sign;
        $request_params['biz_content'] = json_encode($request_params['biz_content']);
        $result = Libs_Http_Client::post(self::GATEWAY_URL, $request_params);
        $result = json_decode($result, true);
        if ($result) {
            if ($result['response']['code'] == '10000' && $result['response']['msg'] == 'Success') {
                return array(
                    'code'          => 0,
                    'appid'         => $request_params['app_id'],
                    'sign'          => $result['sign'],
                    'trade_no'      => $tid,
                    'merchant_id'   => $request_params['merchant_id'],
                    'uid'           => $openid,
                    'total_amount'  => $amount,
                    'risk_info'     => $request_params['risk_info']
                );
            }
        } else {
            return 40004;
        }

    }

    /*
     * 生成签名
     * @param string $appkey 微信支付商户密钥
     * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
     */
    public static function makeToutiaoSign(array $fields, $appkey) {
        //签名步骤一：按字典序排序参数
        ksort($fields);
        $string = self::toUrlParams($fields);
        //签名步骤二：在string后加入KEY
        $string = $string . $appkey;
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        #$result = strtoupper($string);
        return $string;
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
            }elseif($k != "sign" && $v != "" && is_array($v)){
                $buff .= $k . "=" . json_encode($v) . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }

}