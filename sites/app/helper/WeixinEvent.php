<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/9/7
 * Time: 上午10:51
 */
class App_Helper_WeixinEvent {
    private $sid;
    private $shop;

    public function __construct($sid) {
        $this->sid  = $sid;
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $this->shop = $shop_model->getRowById($sid);
    }
    /*
     * 设置关注后的信息回复
     */
    public function setFollowResponse(Libs_Mvc_Controller_WeixinController $obj, array $member) {

        $message_model  = new App_Model_Auth_MysqlWeixinMessageStorage();
        $message = $message_model->findWeixinBySid($this->sid);
        if (!$message) {
            return false;
        }
        $type   = intval($message['wm_type']);
        switch ($type) {
            //文本类型回复
            case 1 :
                $tpl    = $message['wm_content'];
                if (!$tpl) {
                    break;
                }
                $reply_cfg  = plum_parse_config('auto_reply', 'weixin');
                $msg        = array($member['m_show_id'], $member['m_nickname'], $this->shop['s_name']);
                $content    = App_Helper_MemberLevel::messageContentReplace($reply_cfg['usable'], $msg, $tpl);
                $obj->sendTextResponse($content);
                break;
            //图片类型回复
            case 2 :
                $media_id   = $message['wm_img_mid'];
                if (!$media_id) {
                    break;
                }
                $obj->sendImageResponse($media_id);
                break;
        }
        return true;
    }

    /**
     * 获取用户的openid 和 session_key
     * @param $appid 小程序的appid
     * @param $appSecret  小程序的appsecret
     * @param $code  用户换取openID的code
     * @return mixed|string 返回openid 和session_key
     */
    static public function getWxopenid($appid,$appSecret,$code){
        // 获取session_key和openid的地址
        $session_url = "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$appSecret}&js_code={$code}&grant_type=authorization_code";
        Libs_Log_Logger::outputLog($session_url);
        $result = file_get_contents($session_url);
        // 将获取的数据转换
        $result = json_decode($result,true);
        if ($result['openid']) {
            return $result;
        }
        //记录错误
        Libs_Log_Logger::outputLog($result);
        return false;
    }
}