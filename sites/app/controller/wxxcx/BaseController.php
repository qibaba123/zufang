<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/6/2
 * Time: 下午7:38
 */

class App_Controller_Wxxcx_BaseController extends Libs_Mvc_Controller_WxxcxController {
    /*
     * 会员的微信openID
     */
    protected $wx_openid;
    /*
     * 店铺唯一性ID
     */
    protected $suid;
    /*
     * 店铺信息，具体字段名可参考pre_shop
     */
    protected $shop;
    /*
     * 店铺ID
     */
    protected $sid;
    /*
     * 平台来源
     */
    protected $from;

    public function __construct($weixin_msg) {
        parent::__construct($weixin_msg);
        $msg_content        = $this->getWeixinMsg();
        Libs_Log_Logger::outputLog($msg_content);
        $this->wx_openid    = $msg_content['openid'];
        $shop_storage   = new App_Model_Shop_MysqlShopCoreStorage();
        if (isset($msg_content['suid'])) {
            $this->suid     = $msg_content['suid'];

            $this->shop     = $shop_storage->findShopByUniqid($this->suid);
            $this->sid      = $this->shop['s_id'];
        } else {
            $this->sid      = $msg_content['sid'];
            $this->shop     = $shop_storage->getRowById($this->sid);

            $this->suid     = $this->shop['s_unique_id'];
        }
        $this->from = isset($msg_content['from']) ? $msg_content['from'] : 'none';
    }

    /*
     * 转发客服消息
     */
    protected function transfer_customer_service() {
        //获取小程序配置
        $wxcfg_redis    = new App_Model_Applet_RedisAppletStorage($this->sid);
        $forward    = $wxcfg_redis->getMsgForward();

        Libs_Log_Logger::outputLog($this->weixinMsg['Content']);
        //转发到微信网页客服
        if ($forward) {
            $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        </xml>";
            $time = time();
            $msgType = "transfer_customer_service";
            $resultStr = sprintf(
                $textTpl,
                $this->weixinMsg['FromUserName'],
                $this->weixinMsg['ToUserName'],
                $time,
                $msgType);
            if ($this->is_encrypt) {
                $resultStr = App_Plugin_Weixin_MsgCrypt::encrypt($resultStr);
            }
            Libs_Log_Logger::outputLog($resultStr);
            echo $resultStr;
            exit;
        }
    }
}