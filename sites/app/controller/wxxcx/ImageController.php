<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/5/29
 * Time: 上午11:24
 */

class App_Controller_Wxxcx_ImageController extends App_Controller_Wxxcx_BaseController{

    public function __construct($weixin_msg) {
        parent::__construct($weixin_msg);
    }

    public function indexAction() {
        $this->_transfer_image_message();
    }
    /*
     * 转发图片消息到聊天系统
     */
    private function _transfer_image_message() {
        $picurl    = $this->weixinMsg['PicUrl'];
        $chatmsg_model  = new App_Model_Wechat_MysqlChatMsgStorage($this->sid);
        $indata     = array(
            'sc_s_id'       => $this->sid,
            'sc_openid'     => $this->wx_openid,
            'sc_content'    => $picurl,
            'sc_type'       => $chatmsg_model::CHAT_TYPE_IMAGE,
            'sc_from'       => $chatmsg_model::CHAT_FROM_CUSTOMER,
            'sc_create_time'=> time(),
        );
        $chatmsg_model->insertValue($indata);
        $chatlist_model = new App_Model_Wechat_MysqlChatListStorage($this->sid);
        $tips   = "发来了一张图片";
        $chatlist_model->insertUpdateList($this->wx_openid, $tips);

        $gateway_client = new App_Plugin_Gateway_Client();
        //当前店铺所在APP是否在线
        if ($gateway_client->isUidOnline($this->sid)) {
            $msg = array('openid'=>$this->weixinMsg['openid'],'msg' => $tips, 'type' => 'image','picurl'=>$picurl);
            $gateway_client->sendToUid($this->sid, json_encode($msg));
        } else {
            //设置不在线,通过信鸽推送形式
            $help_model = new App_Helper_XingePush($this->sid);
            $help_model->pushNotice($help_model::CUSTOMER_SERVICE_NEWS);  // 收到客服消息推送通知
            $notice_model = new App_Helper_JiguangPush($this->sid);
            $notice_model->pushNotice($notice_model::CUSTOMER_SERVICE_NEWS);
        }
    }
}