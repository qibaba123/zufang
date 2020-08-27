<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/5/26
 * Time: 下午12:19
 */
require_once "lib/alipay_submit.class.php";
require_once "lib/alipay_notify.class.php";

class App_Plugin_Alipay_ClientPlugin {
    /*
     * 店铺ID
     */
    private $sid;
    /*
     * 支付宝配置
     */
    private $alipay_config;
    /*
     * 支付宝账户信息
     */
    private $alipay_account;

    public function __construct($sid) {
        $this->sid = $sid;

        $this->alipay_config    = array(
            'partner'       => '2088911449213181',//合作身份者ID
            'key'           => 's44v0293e2y123pimucwy1aq5dwds3dh',//安全校验码
            'sign_type'     => strtoupper('MD5'),//签名方式
            'input_charset' => strtolower('utf-8'),//字符编码格式
            'cacert'        => PLUM_DIR_APP.'/storage/file/cacert.pem',//CA证书路径地址
            'transport'     => 'http',
        );

        $this->alipay_account   = array(
            'email'     => 'tiandian@ikinvin.com',
            'name'      => '郑州天点科技有限公司',
        );
    }

    /**
     * 批量付款到支付宝账户
     * @param array $data 二维数据，0流水号、1收款方账号、2真实姓名、3付款金额、4备注说明
     * @param string $notify_url
     * @return bool|提交表单HTML文本
     */
    public function batchTrans(array $data, $notify_url) {
        $amount     = 0;
        $count      = 0;
        $detail     = '';

        foreach ($data as $item) {
            $amount += $item[3];
            $count++;
            $detail .= join('^', $item).'|';
        }

        if (!$count) {
            return false;
        }

        rtrim($detail, '|');
        //请求参数数组
        $parameter  = array(
            'service'       => 'batch_trans_notify',
            'partner'       => $this->alipay_config['partner'],//商户号
            'notify_url'    => $notify_url,//通知回调URL
            'email'         => $this->alipay_account['email'],//付款人账号
            'account_name'  => $this->alipay_account['name'],//付款人姓名
            'pay_date'      => date('Ymd', time()),//付款日期
            'batch_no'      => self::makeBatchNo(),//批次号
            'batch_fee'     => $amount,//付款总金额
            'batch_num'     => $count,//付款笔数
            'detail_data'   => $detail,//付款详细数据
            '_input_charset'=> $this->alipay_config['input_charset'],
        );
        $alipay_submit  = new AlipaySubmit($this->alipay_config);

        return $alipay_submit->buildRequestForm($parameter, 'get', '确认');
    }

    public function alipayNotify() {
        $alipay_notify  = new AlipayNotify($this->alipay_config);
        $verify_result  = $alipay_notify->verifyNotify();

        if ($verify_result) {
            //批量付款数据中转账成功的详细信息
            $success_details = $_POST['success_details'];
            Libs_Log_Logger::outputLog($success_details);
            //批量付款数据中转账失败的详细信息
            $fail_details = $_POST['fail_details'];
            Libs_Log_Logger::outputLog($fail_details);
            return "success";
        } else {
            return "fail";
        }
    }

    /*
     * 生成唯一性批次号
     */
    public static function makeBatchNo() {
        $shf_str    = (string)mt_rand(10000, 99999).(string)mt_rand(10000, 99999);//十位数字的字符串
        $oid    = array(
            date('Ymd', time()),
            str_shuffle($shf_str)
        );

        return join('', $oid);
    }
}