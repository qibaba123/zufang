<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/11/19
 * Time: 下午4:52
 */

class App_Helper_AgentSms{

    const SMS_TRADE_PAY     = 1;//支付成功通知
    const SMS_TRADE_DELIVER = 2;//发货完成通知
    const SMS_TRADE_COMPLETE= 3;//订单完成通知

    private $aaid;
    private $shop;
    private $cfg_model;

    public function __construct($aaid)
    {
        $this->aaid  = $aaid;
        $this->cfg_model    = new App_Model_Agent_MysqlAgentSmsCfgStorage($this->aaid);
    }
    /*
     * 获取可用短信条数
     */
    public function checkUsableSms() {
        $cfg    = $this->cfg_model->findRowByUid();

        return  intval($cfg['asc_useable']);
    }
    /*
     * 记录短信并扣费
     */
    public function recordSendSms($mobile, $text) {
        $len   = ceil(mb_strlen($text)/67);//计费条数
        //添加记录
        $record_model   = new App_Model_Agent_MysqlAgentSmsRecordStorage();
        $indata     = array(
            'asr_aa_id'        => $this->aaid,
            'asr_mobile'       => $mobile,
            'asr_text'         => plum_validate_utf8($text) ? $text : mb_convert_encoding($text, 'UTF-8'),
            'asr_count'        => $len,
            'asr_create_time'  => time(),
        );
        $record_model->insertValue($indata);
        //记录扣费
        $this->cfg_model->incrementSmsTotal(-$len, $len);
    }
    /*
     * 发送通知类短信
     */
    public function sendNoticeSms($type,$params = array()) {
        // 获取代理商短信配置
        $sms_storage = new App_Model_Agent_MysqlAgentSmsCfgStorage($this->aaid);
        $smsCfg = $sms_storage->findRowByUid();
        //开通短信通知功能
        if ($smsCfg) {
            //获取短信剩余条数
            $usable = $this->checkUsableSms();
            if ($usable > 0) {
                $ucpaas_plugin  = new App_Plugin_Sms_UcpaasPlugin();
                $result = $ucpaas_plugin->sendNoticeSms($smsCfg['asc_warn_phone'], $type, $params);
                if ($result && $result['code'] == 0) {
                    $this->recordSendSms($smsCfg['asc_warn_phone'], $result['text']);

                }
            }
        }

    }
}