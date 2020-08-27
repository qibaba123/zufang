<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/11/19
 * Time: 下午4:52
 */

class App_Helper_Sms{

    const SMS_TRADE_PAY     = 1;//支付成功通知
    const SMS_TRADE_DELIVER = 2;//发货完成通知
    const SMS_TRADE_COMPLETE= 3;//订单完成通知

    private $sid;
    private $shop;
    private $cfg_model;

    public function __construct($sid)
    {
        $this->sid  = $sid;
        $this->cfg_model    = new App_Model_Plugin_MysqlSmsCfgStorage($this->sid);

        $shop_model = new App_Model_Shop_MysqlShopCoreStorage($this->sid);
        $this->shop = $shop_model->getRowById($this->sid);
    }
    /*
     * 获取可用短信条数
     */
    public function checkUsableSms() {
        $cfg    = $this->cfg_model->fetchUpdateCfg();

        return  intval($cfg['sc_useable']);
    }
    /*
     * 记录短信并扣费
     */
    public function recordSendSms($mobile, $mid, $text) {
        $len   = ceil(mb_strlen($text)/67);//计费条数
        //添加记录
        $record_model   = new App_Model_Plugin_MysqlSmsRecordStorage($this->sid);
        $indata     = array(
            'sr_s_id'       => $this->sid,
            'sr_m_id'       => $mid,
            'sr_mobile'     => $mobile,
            'sr_text'       => plum_validate_utf8($text) ? $text : mb_convert_encoding($text, 'UTF-8'),
            'sr_count'      => $len,
            'sr_send_time'  => time(),
        );
        $record_model->insertValue($indata);
        //记录扣费
        $this->cfg_model->incrementSmsTotal(-$len, $len);
    }

    //发送验证码短信
    public function sendVerifySms($mobile, $code, $timestamp, $type){

        //获取短信剩余条数
        $usable = $this->checkUsableSms();
        if ($usable > 0) {
            $ucpaas_plugin  = new App_Plugin_Sms_UcpaasPlugin();
            if (plum_is_mobile($mobile)) {
                $result    = $ucpaas_plugin->webSendVerify($mobile, $code, null, $type);

                if ($result && $result['code'] == 0) {
                    $this->recordSendSms($mobile, 0, $result['text']);
                    return $result;
                }else{
                    return $ucpaas_plugin->verify_code_error[$result];
                }
            }
        }

        return "验证码发送失败";
    }

    /*
     * 发送通知类短信
     */
    public function sendNoticeSms(array $trade, $type,$appletName = '') {
        $type_enum  = array(
            'ddzfcg'    => array('const' => self::SMS_TRADE_PAY, 'suffix' => 's'),
            'mjfhtz'    => array('const' => self::SMS_TRADE_DELIVER, 'suffix' => 'b'),
            'ddwctz'    => array('const' => self::SMS_TRADE_COMPLETE, 'suffix' => 's'),
            'sqtktz'    => array('const' => 0, 'suffix' => 's'),
            'tytktz'    => array('const' => 0, 'suffix' => 'b'),
            'jjtktz'    => array('const' => 0, 'suffix' => 'b'),
            'xcxyytz'   => array('const' => 0, 'suffix' => 's'),   //小程序预约留言通知
            'xcxsqrz'   => array('const' => 0, 'suffix' => 's'),   //小程序商家申入驻通知
            'kfxxtz'   => array('const' => 0, 'suffix' => 's'),   //客服
        );

        $ntcfg_model    = new App_Model_Shop_MysqlShopSmsStorage($this->sid);
        $ntcfg      = $ntcfg_model->findUpdateBySid();
        //开通短信通知功能
        if ($ntcfg && $ntcfg["ss_{$type}_{$type_enum[$type]['suffix']}"]) {
            //防止重复通知,越级通知
            if (!$type_enum[$type]['const'] || $type_enum[$type]['const'] > $trade['t_sms_new']) {
                $shoper = $this->shop['s_phone'];
                if(!empty($trade) && $trade['t_addr_id']){
                    $addr_model = new App_Model_Member_MysqlAddressStorage($this->sid);
                    $addr_info  = $addr_model->getRowById($trade['t_addr_id']);//收货人信息

                    $buyer  = $addr_info['ma_phone'];
                }
                //获取短信剩余条数
                $usable = $this->checkUsableSms();
                if ($usable > 0) {
                    $ucpaas_plugin  = new App_Plugin_Sms_UcpaasPlugin();
                    switch ($type) {
                        case 'ddzfcg' :
                            $params = array(
                                mb_strlen($trade['t_buyer_nick']) > 12 ? mb_substr($trade['t_buyer_nick'], 0, 12)."..." : $trade['t_buyer_nick'],
                                mb_strlen($trade['t_title']) > 12 ? mb_substr($trade['t_title'], 0, 12)."..." : $trade['t_title'],
                                $trade['t_tid'],
                            );
                            $mobile = $shoper;
                            break;
                        case 'mjfhtz' :
                            $params = array(
                                mb_strlen($this->shop['s_name']) > 12 ? mb_substr($this->shop['s_name'], 0, 12)."..." : $this->shop['s_name'],
                                mb_strlen($trade['t_title']) > 12 ? mb_substr($trade['t_title'], 0, 12)."..." : $trade['t_title'],
                            );
                            $mobile = $buyer;
                            break;
                        case 'ddwctz' :
                            $params = array(
                                mb_strlen($trade['t_buyer_nick']) > 12 ? mb_substr($trade['t_buyer_nick'], 0, 12)."..." : $trade['t_buyer_nick'],
                                mb_strlen($trade['t_title']) > 12 ? mb_substr($trade['t_title'], 0, 12)."..." : $trade['t_title'],
                                $trade['t_tid'],
                            );
                            $mobile = $shoper;
                            break;
                        case 'sqtktz' :
                            $params = array(
                                mb_strlen($trade['t_buyer_nick']) > 12 ? mb_substr($trade['t_buyer_nick'], 0, 12)."..." : $trade['t_buyer_nick'],
                                mb_strlen($trade['t_title']) > 12 ? mb_substr($trade['t_title'], 0, 12)."..." : $trade['t_title'],
                                $trade['t_tid'],
                            );
                            $mobile = $shoper;
                            break;
                        case 'tytktz' :
                            $params = array(
                                mb_strlen($this->shop['s_name']) > 12 ? mb_substr($this->shop['s_name'], 0, 12)."..." : $this->shop['s_name'],
                                mb_strlen($trade['t_title']) > 12 ? mb_substr($trade['t_title'], 0, 12)."..." : $trade['t_title'],
                            );
                            $mobile = $buyer;
                            break;
                        case 'jjtktz' :
                            $refund_model   = new App_Model_Trade_MysqlTradeRefundStorage($this->sid);
                            $refund     = $refund_model->getLastRecord($trade['t_tid']);
                            $params = array(
                                mb_strlen($this->shop['s_name']) > 12 ? mb_substr($this->shop['s_name'], 0, 12)."..." : $this->shop['s_name'],
                                $trade['t_tid'],
                                mb_strlen($refund['tr_seller_note']) > 12 ? mb_substr($refund['tr_seller_note'], 0, 12)."..." : $refund['tr_seller_note'],
                            );
                            $mobile = $buyer;
                            break;
                        case 'xcxyytz' :
                            $params = array(
                                mb_strlen($appletName) > 12 ? mb_substr($appletName, 0, 12)."..." : $appletName,
                            );
                            $mobile = $shoper;
                            $trade['t_m_id'] = 0;
                            break;
                        case 'xcxsqrz' :    //店铺入驻申请
                            $params = array(
                                mb_strlen($appletName) > 12 ? mb_substr($appletName, 0, 12)."..." : $appletName,
                            );
                            $mobile = $shoper;
                            $trade['t_m_id'] = 0;
                            break;
                       case 'kfxxtz' :    //客服
                            $params = array(
                                mb_strlen($appletName) > 12 ? mb_substr($appletName, 0, 12)."..." : $appletName,
                            );
                            $mobile = $shoper;
                            $trade['t_m_id'] = 0;
                            break;
                    }
                    if (plum_is_mobile($mobile)) {
                        $result = $ucpaas_plugin->sendNoticeSms($mobile, $type, $params);

                        if ($result && $result['code'] == 0) {
                            $this->recordSendSms($shoper, $trade['t_m_id'], $result['text']);
                            //记录发送状态
                            if ($type_enum[$type]['const'] > 0) {
                                $updata = array(
                                    't_sms_new' => $type_enum[$type]['const'],
                                );
                                $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
                                $trade_model->updateById($updata, $trade['t_id']);
                            }
                        }
                    }
                }
            }
        }

    }
}