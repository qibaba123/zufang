<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/1/6
 * Time: 下午2:10
 */
class App_Helper_Coupon {

    private $sid;

    public function __construct($sid) {
        $this->sid  = intval($sid);
    }
    /*
     * 发送优惠券即将过期的提醒
     */
    public function sendCouponInvalid($crid) {
        $receive_model  = new App_Model_Coupon_MysqlReceiveStorage();
        
        $receive    = $receive_model->getRowById($crid);
        Libs_Log_Logger::outputLog($receive);
        if ($receive && $receive['cr_s_id'] == $this->sid) {
            $this->sendCouponTmplmsg($receive['cr_c_id'], 'gqtx', $receive['cr_m_id']);
            $this->sendCouponNewsmsg($receive['cr_c_id'], 'gqtx', $receive['cr_m_id']);
        }
    }
    /*
     * 发送微信模板消息
     * @param string $cid 优惠券ID
     * @param string $type 激发消息类型, dztz(到账通知), gqtx(过期提醒)
     * @param int $mid 会员ID
     */
    public function sendCouponTmplmsg($cid, $type, $mid) {
        $coupon_model   = new App_Model_Coupon_MysqlCouponStorage();
        $coupon         = $coupon_model->getCoupon($cid, $this->sid);

        if ($coupon && $coupon["cl_{$type}_msgid"]) {
            $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($coupon["cl_{$type}_msgid"]);
            //模板消息存在
            if ($tplmsg) {
                $tpl    = $tplmsg['wt_data'];
                $jump   = $tplmsg['wt_url'];

                $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                $openids        = $member_model->getOptionsBySidMid($this->sid, array($mid));
                if (!empty($openids) && $openids[0]) {
                    $weixin_client  = new App_Plugin_Weixin_ClientPlugin($this->sid);
                    $tpl = json_decode($tpl, true);
                    $jump   = plum_is_url($jump) ? $jump : '';
                    $ret = $weixin_client->sendTemplateMessage($openids[0], $tplmsg['wt_tplid'], $jump, $tpl);
                    Libs_Log_Logger::outputLog($ret);
                }
            }
        }
    }
    /*
     * 发送微信客服图文消息
     */
    public function sendCouponNewsmsg($cid, $type, $mid) {
        $coupon_model   = new App_Model_Coupon_MysqlCouponStorage();
        $coupon         = $coupon_model->getCoupon($cid, $this->sid);

        if ($coupon && $coupon["cl_{$type}_nwid"]) {
            $news_model = new App_Model_Auth_MysqlWeixinNewsStorage();
            $news   = $news_model->findNewsById($coupon["cl_{$type}_nwid"]);

            if ($news) {
                $domain = plum_parse_config('shield_domain', 'weixin');
                for ($i = 0; $i < 8; $i++) {
                    if ($i == 0) {
                        $article[]  = array(
                            'title'         => $news['wn_title'],
                            'description'   => $news['wn_brief'],
                            'url'           => $news['wn_url'],
                            'picurl'        => "http://{$domain}".$news['wn_pic'],
                        );
                    } else {
                        if ($news["wn_title_{$i}"]) {
                            $article[]  = array(
                                'title'         => $news["wn_title_{$i}"],
                                'description'   => '',
                                'url'           => $news["wn_url_{$i}"],
                                'picurl'        => "http://{$domain}".$news["wn_pic_{$i}"],
                            );
                        } else {
                            break;
                        }
                    }
                }

                $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                $openids        = $member_model->getOptionsBySidMid($this->sid, array($mid));
                if (!empty($openids)) {
                    $weixin_client  = new App_Plugin_Weixin_ClientPlugin($this->sid);

                    if (!empty($openids) && $openids[0]) {
                        $weixin_client->sendLinkNewsMessage($openids[0], $article);
                    }
                }
            }
        }
    }
}