<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/3/31
 * Time: 下午6:47
 */
class App_Controller_Weixin_EventController extends App_Controller_Weixin_BaseController {

    public function __construct($weixin_msg) {
        parent::__construct($weixin_msg);
        $this->_qwfb_test();
    }

    /*
     * 默认动作
     */
    public function indexAction() {

    }
    /*
     * 全网发布测试,可注释
     */
    private function _qwfb_test() {
        Libs_Log_Logger::outputLog($this->weixinMsg);
        $username   = (string)$this->weixinMsg->ToUserName;
        $event      = (string)$this->weixinMsg->Event;
        if ($username == 'gh_3c884a361561') {
            $this->sendTextResponse($event."from_callback");
        }
    }

    /*
     * 关注公众号事件
     */
    public function subscribeAction() {
        //非授权公众号消息,丢弃掉
        if (!property_exists($this->weixinMsg, 'is_encrypt')) {
            $this->sendEmptyResponse();
        }
        $check_type     = App_Helper_ShopWeixin::checkWeixinVerifyType($this->shop['s_id']);
        //非认证订阅号、非认证服务号 无法使用
        if ($check_type == App_Helper_ShopWeixin::WX_VERIFY_WRZDYH || $check_type == App_Helper_ShopWeixin::WX_VERIFY_WRZFWH) {
            return;
        }

        $flag   = false;//无上级
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member = $member_storage->findUpdateMemberByWeixinOpenid($this->wx_openid, $this->shop['s_id']);
        if ($member) {
            $client_plugin  = new App_Plugin_Weixin_ClientPlugin($this->shop['s_id']);

            $user_info      = $client_plugin->fetchUserInfo($this->wx_openid);
            //已关注过
            $updata = array(
                'm_is_follow'   => 1,
                'm_follow_time' => date('Y-m-d H:i:s'),
                'm_is_slient'   => 0,//置为非观望者
                'm_nickname'    => $user_info['nickname'],
                'm_avatar'      => $user_info['headimgurl'],
            );
            $member_storage->findUpdateMemberByWeixinOpenid($this->wx_openid, $this->shop['s_id'], $updata);
            $mid    = $member['m_id'];
            $flag = $this->_set_level();
        } else {
            //未关注过
            $client_plugin  = new App_Plugin_Weixin_ClientPlugin($this->shop['s_id']);

            $user_info      = $client_plugin->fetchUserInfo($this->wx_openid);
            if ($user_info) {
                if (App_Plugin_Weixin_ClientPlugin::openIDVerify($user_info['openid'])) {
                    $indata = array(
                        'm_s_id'    => $this->shop['s_id'],
                        'm_c_id'    => $this->shop['s_c_id'],
                        'm_openid'  => $user_info['openid'],
                        'm_nickname'=> $user_info['nickname'],
                        'm_avatar'  => $user_info['headimgurl'],
                        'm_sex'     => $user_info['sex'] == 1 ? '男' : '女',
                        'm_province'=> $user_info['province'],
                        'm_city'    => $user_info['city'],
                        'm_union_id'=> $user_info['unionid'] ? $user_info['unionid'] : '',
                        'm_is_follow'   => 1,
                        'm_follow_time' => date('Y-m-d H:i:s', time()),
                        'm_is_slient'   => 0,//置为非观望者
                    );
                    $mid = $member_storage->insertShopNewMember($this->shop['s_id'], $indata);
                    $flag   = $this->_set_level();
                    $member = $member_storage->getRowById($mid);
                    //检查关注红包
                    $redpack_helper = new App_Helper_Redpack($this->sid);
                    $ret = $redpack_helper->followRedpackCheck($member);
                    if ($ret && $ret['errcode'] <= 0) {
                        //发放应答
                        if($this->sid!=16) {
                            $this->sendTextResponse($ret['errmsg']);
                        }
                    }
                }
            }
        }
        //无上级会员进入消息
        if (!$flag) {
            $client_plugin  = new App_Plugin_Weixin_ClientPlugin($this->shop['s_id']);
            $message_cfg    = plum_parse_config('message', 'message');
            $message_model  = new App_Model_System_MysqlMessageStorage($this->shop['s_id']);
            //向会员发送消息
            $msg    = array($member['m_show_id'], $member['m_nickname'], $this->shop['s_name']);
            $mtpl   = $message_model->fetchUpdateByKindId(1, 5);
            if($this->sid!=46 || $mtpl){
                $tpl    = $mtpl ? $mtpl['sm_content'] : $message_cfg[1][5]['default'];
                $reg    = $message_cfg[1][5]['usable'];
                if($this->sid!=16){
                    $content    = App_Helper_MemberLevel::messageContentReplace($reg, $msg, $tpl);
                    $client_plugin->sendTextMessage($member['m_openid'], $content);
                }
            }

        }

        //关注公众号回复
        if($this->sid!=16){
            $weixin_event   = new App_Helper_WeixinEvent($this->sid);
            $weixin_event->setFollowResponse($this, $member);
        }
    }

    /*
     * 设置会员等级关系
     */
    private function _set_level() {
        $event_key  = (string)$this->weixinMsg->EventKey;
        if ($event_key) {
            $parent = null;

            //扫码关注的话，用于获取上级id
            list(,$val) = explode('_', $event_key);
            if(!$val){
                $val = $event_key;
            }
            //数字类型场景值,设置上下级关系
            if (is_numeric($val)) {
                //取模
                $mode   = intval($val)%App_Helper_Group::GROUP_WEIXIN_SCENE_BASE;
                if ($mode == 0) {
                    $goid   = intval($val)/App_Helper_Group::GROUP_WEIXIN_SCENE_BASE;
                    //推送拼团购参与信息
                    App_Helper_Group::scanPushGroupJoin($goid, $this->sid, $this->wx_openid);
                }

                $parent = $val;
            } else if (is_string($val)) {//字符串类型场景值,设置事件
                list($type, $id)    = explode('|', $val);
                
                switch ($type) {
                    case App_Helper_Group::GROUP_GROUP_KIND :
                        App_Helper_Group::scanPushEvent($id, $this->wx_openid);
                        break;
                    case 'ambm': //小程序管理员绑定微信
                        $this->_applet_manager_bind_member($id);
                        break;
                    //微信推广码
                    case App_Helper_ShopWeixin::THREE_THREE_KIND :
                        $parent = $id;
                        break;
                }
            }
            //父级存在
            if ($parent) {
                $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
                $member = $member_storage->findUpdateMemberByWeixinOpenid($this->wx_openid, $this->shop['s_id']);

                if ($member) {
                    //非最高级且无上级
                    if (!$member['m_is_highest'] && !$member['m_1f_id']) {
                        //检查是否是真实会员
                        $is_real_member = App_Helper_MemberLevel::isRealMember($this->shop['s_id'], $parent);
                        if (!$is_real_member) {
                            return false;
                        }
                        return App_Helper_MemberLevel::setLevelSendMessage($this->shop['s_id'], $member['m_id'], $parent);
                    }
                }
            }
        }
        return false;
    }

    /**
     * 小程序管理员绑定微信
     */
    private function _applet_manager_bind_member($id){
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member = $member_storage->findUpdateMemberByWeixinOpenid($this->wx_openid, $this->shop['s_id']);

        $manager_model = new App_Model_Member_MysqlManagerStorage();
        $set = array('m_weixin_mid' => $member['m_id'], 'm_report_open' => 1);

        //获取所有店铺管理员
        $where   = array();
        $where[] = array('name' => 'ma.m_id', 'oper' => '=', 'value' => $id);
        $where[] = array('name' => 'ac_type', 'oper' => '>', 'value' => 0);
        $managerApplet = $manager_model->getListWithMember($where, 0, 1, array());
        $weixin_client  = new App_Plugin_Weixin_ClientPlugin($this->shop['s_id']);
        $content = "您已成功绑定【".$managerApplet[0]['ac_name']."】，小程序每日经营数据会在第2天08:00发送给您，请注意查收！";
        $weixin_client->sendTextMessage($this->wx_openid, $content);

        $manager_model->updateById($set, $id);
    }

    /*
     * 取消关注公众号事件
     */
    public function unsubscribeAction() {
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $updata = array(
            'm_is_follow'       => 0,
            'm_spread_qrcode'   => '',
            'm_wx_ticket'       => '',
            'm_ticket_expire'   => 0,//清空推广二维码信息
        );
        $member_storage->findUpdateMemberByWeixinOpenid($this->wx_openid, $this->shop['s_id'], $updata);
        //回复空信息
        $this->sendEmptyResponse();
    }

    /*
     * 关注后的扫码事件
     * @todo 接收不到
     */
    public function scanAction() {
        $this->_set_level();
    }
    /*
     * 模板发送任务完成通知事件
     */
    public function templateSendJobFinishAction() {
        $status     = (string)$this->weixinMsg->Status;
        $tplsend_model  = new App_Model_Wechat_MysqlTplsendStorage($this->sid);
        $tplsend_model->feedbackSendRecord($this->wx_openid, $status);
    }

    /*
     * 上报地理位置事件
     */
    public function locationAction() {
        
    }

    /*
     * 点击菜单拉取消息时的事件推送
     */
    public function clickAction() {
        $sid    = $this->shop['s_id'];
        $key    = (string)$this->weixinMsg->EventKey;
        $menu_sog   = new App_Model_Auth_MysqlWeixinMenuStorage();
        $extra      = $menu_sog->getRowByIdSid($key, $sid);
        if (!$extra) {
            $this->sendEmptyResponse();
        } else {
            $enum   = plum_parse_config('click_enum', 'weixin');
            if (isset($enum[$extra['wm_extra']])) {
                call_user_func(array(get_class($this), $enum[$extra['wm_extra']]['method']));
            } else {
                $this->sendTextResponse($extra['wm_extra']);
            }
        }
    }

    /*
     * 点击菜单跳转链接时的事件推送
     */
    public function viewAction() {

    }

    /*
     * 切勿删除
     * 获取用户的推广二维码
     */
    private function _fetch_spread_qrcode() {
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member = $member_storage->findUpdateMemberByWeixinOpenid($this->wx_openid, $this->shop['s_id']);
        //会员存在
        if ($member) {
            App_Helper_MemberLevel::sendSpreadQrcode($member['m_id']);
        }
    }
    /*
     * 切勿删除
     * 会员签到领取积分
     */
    private function _sign_gain_point() {
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member = $member_storage->findUpdateMemberByWeixinOpenid($this->wx_openid, $this->shop['s_id']);
        //会员存在
        if ($member) {
            $point_helper   = new App_Helper_Point($member['m_s_id']);
            $ret    = $point_helper->signGainPoint($member['m_id']);

            $this->sendTextResponse($ret['errmsg']);
        }

    }

    /*
     * 未定义动作被调用
     */
    public function __call($name, $arguments) {
        Libs_Log_Logger::outputLog("微信未定义事件动作{$name}");
    }

}