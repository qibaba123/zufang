<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/5/29
 * Time: 上午11:29
 */
class App_Controller_Wxxcx_EventController extends App_Controller_Wxxcx_BaseController
{

    public function __construct($weixin_msg) {
        parent::__construct($weixin_msg);
    }

    /*
     * 默认动作
     */
    public function indexAction() {

    }
    /*
     * 用户进入聊天界面
     */
    public function user_enter_tempsessionAction() {
        die('不再支持');
        //记录用户进行会话界面事件
        $tips       = "进入会话";
        //判断自动问候语是否启用
        $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->sid);
        $applet_cfg     = $applet_model->findShopCfg();
        if ($applet_cfg['ac_open_greetings']) {
            $tips   = $applet_cfg['ac_set_greetings'];
            //发送客服消息
            $client = new App_Plugin_Weixin_WxxcxClient($this->sid);
            $client->sendCustomText($this->wx_openid, $tips);
            //保存自动问候语
            $chatmsg_model  = new App_Model_Wechat_MysqlChatMsgStorage($this->sid);
            $indata     = array(
                'sc_s_id'       => $this->sid,
                'sc_openid'     => $this->wx_openid,
                'sc_content'    => $tips,
                'sc_type'       => $chatmsg_model::CHAT_TYPE_TEXT,
                'sc_from'       => $chatmsg_model::CHAT_FROM_SERVICE,
                'sc_create_time'=> time(),
            );
            $chatmsg_model->insertValue($indata);
        }
        $chat_model = new App_Model_Wechat_MysqlChatListStorage($this->sid);
        $chat_model->insertUpdateList($this->wx_openid, $tips);
    }
    /*
     * 小程序审核通过回调通知
     */
    public function weapp_audit_successAction() {
        $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->sid);
        $applet_cfg     = $applet_model->findShopCfg();
        if ($applet_cfg['ac_audit_auto'] == 1) {//审核通过后自动发布上线
            $applet_client  = new App_Plugin_Weixin_WxxcxClient($this->sid);
            $applet_client->releaseTemplateCode();

            $updata = array(
                'ac_audit_status'   => 0,//无审核
                'ac_base'   => $applet_cfg['ac_audit_base'],
                'ac_version'=> $applet_cfg['ac_audit_version'],
            );
        } else {
            $updata = array(
                'ac_audit_status'   => 2,//审核通过
                'ac_audit_time'     => $this->weixinMsg['SuccTime'],
            );
            //  关闭审核伪装版本
            $tpl_model = new App_Model_Applet_MysqlAppletSinglePageStorage($this->sid);
            $tpl_model->findUpdateBySid(26,array('asp_audit'=>0));
        }
        $applet_model->findShopCfg($updata);
        // 推送通知
        $notice_model = new App_Helper_JiguangPush($this->sid);
        $desc['content'] = '您管理的小程序'.$applet_cfg['ac_name'].'已通过审核，请查看';
        $notice_model->pushNotice($notice_model::LEAVING_APPLET_AUTH,$desc);
        $message_helper = new App_Helper_ShopMessage($this->sid);
        $message['status'] = '通过';
        $message['content'] = '您管理的小程序'.$applet_cfg['ac_name'].'已通过审核，请查看';
        $message_helper->messageRecord($message_helper::LEAVING_APPLET_AUTH,$message);
    }
    /*
     * 小程序审核失败回调通知
     */
    public function weapp_audit_failAction() {
        $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->sid);
        $applet_cfg     = $applet_model->findShopCfg();
        $updata = array(
            'ac_audit_status'   => 3,//审核失败
            'ac_audit_reason'   => $this->weixinMsg['Reason'],
            'ac_audit_time'     => $this->weixinMsg['FailTime'],
        );
        $applet_model->findShopCfg($updata);
        //推送审核结果通知
        $notice_model = new App_Helper_JiguangPush($this->sid);
        $desc['content'] = '您管理的小程序'.$applet_cfg['ac_name'].'审核被拒绝，请查看拒绝原因，修改后重新提交审核';
        $notice_model->pushNotice($notice_model::LEAVING_APPLET_AUTH,$desc);
        $message_helper = new App_Helper_ShopMessage($this->sid);
        $message['status'] = '拒绝';
        $message['content'] = $updata['ac_audit_reason'];
        $message_helper->messageRecord($message_helper::LEAVING_APPLET_AUTH,$message);
    }

    public function wx_verify_refillAction() {

    }

    public function wx_verify_dispatchAction() {

    }

    public function wx_verify_pay_succAction() {

    }
    /*
     * 代创建小程序，审核事件推送
     */
    public function notify_third_fasteregisterAction() {

    }

    public function nearby_category_audit_infoAction() {

    }
}