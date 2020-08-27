<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/10/25
 * Time: 上午9:37
 */
class App_Helper_Group {
    const TRANSFER_ERROR    = 'LOG转换失败，非LOG信息';

    const GROUP_STATUS_RUNNING  = 0;//拼团进行中
    const GROUP_STATUS_SUCCESS  = 1;//拼团成功
    const GROUP_STATUS_FAILURE  = 2;//拼团失败
    const GROUP_STATUS_COMPLETE = 4;//拼团成功已发货

    const GROUP_TYPE_PTPT   = 1;//普遍拼团
    const GROUP_TYPE_CJT    = 2;//抽奖团
    const GROUP_TYPE_TZYHT  = 3;//团长优惠团
    const GROUP_TYPE_JTPT   = 4;//阶梯拼团

    const GROUP_GROUP_KIND  = 'ptg';

    const GROUP_WEIXIN_SCENE_BASE   = 177;//微信场景ID基数

    /**
     * @var array
     * 拼团订单交易状态菜单链接
     */
    public static $group_trade_status    = array(
        'all'   => array(
            'id'    => -1,
            'label' => '全部'
        ),
        'running'   => array(
            'id'    => self::GROUP_STATUS_RUNNING ,
            'label' => '待成团'
        ),
        'success'   => array(
            'id'    => self::GROUP_STATUS_SUCCESS ,
            'label' => '拼团成功'
        ),
        'failure'   => array(
            'id'    => self::GROUP_STATUS_FAILURE,
            'label' => '拼团失败'
        ),
    );

    private $sid;

    public function __construct($sid) {
        $this->sid  = intval($sid);
    }
    
    /*
     * 组团活动超过24小时,失败时调用
     * $param int $goid 组团活动ID
     */
    public function groupOrgOvertime($goid) {
        $goid   = intval($goid);
        $org_model  = new App_Model_Group_MysqlOrgStorage($this->sid);
        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->sid);
        $appletCfg        = $applet_cfg->findShopCfg();

        if($appletCfg['ac_type'] == 12){
            $group  = $org_model->findGroupOrgCourse($goid);
        }else{
            $group  = $org_model->findGroupOrg($goid);
        }

        Libs_Log_Logger::outputLog($group);
        if (!$group) {
            return false;
        }
        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->sid);
        $appletCfg        = $applet_cfg->findShopCfg();

        //非进行中的拼团无法操作
        if ($group['go_status'] > self::GROUP_STATUS_RUNNING) {
            Libs_Log_Logger::outputLog("拼团已结束");
            return false;
        }
        $mem_model  = new App_Model_Group_MysqlMemStorage($this->sid);
        $joiner     = $mem_model->fetchJoinList($goid);

        $pintuan_success    = false;//拼团成功?
        //自动成团
        if ($group['gb_use_auto']) {
            $pintuan_success    = true;
            $updata = array(
                'go_status'     => self::GROUP_STATUS_SUCCESS,//置为成功
                'go_over_time'  => time(),
            );
            $org_model->updateById($updata, $group['go_id']);
            for ($i=1; $i<=($group['gb_total']-$group['go_had']); $i++) {
                $indata = array(
                    'gm_s_id'       => $this->sid,
                    'gm_go_id'      => $group['go_id'],
                    'gm_gb_id'      => $group['gb_id'],
                    'gm_mid'        => -$i,//匿名会员
                    'gm_is_robot'   => 1,
                    'gm_join_time'  => time(),
                );
                $mem_model->insertValue($indata);
            }
            //是否需要发送拼团成功模板消息
            $send_type  = 'ptcg';
            //非抽奖拼团,成功后修改库存量
            if ($group['gb_type'] != self::GROUP_TYPE_CJT) {
                //拼团成功,商品库存量调整
                $real   = $mem_model->getRealJoiner($goid);
                $trade_helper   = new App_Helper_Trade($this->sid);
                if($appletCfg['ac_type'] == 12){//培训版 增加课程报名人数
                    foreach ($real as $item) {
                        $trade_helper->adjustTradeCourseApply($item['t_id']);
                    }
                }else{
                    foreach ($real as $item) {
                        $trade_helper->adjustTradeGoodsStock($item['t_id']);
                    }
                }

            }
            //todo 拼团成功打印拼团订单
            $print_model = new App_Helper_Print($this->sid);
            $print_model->printGroupOrder($joiner,'',0);

        } else {
            //组团失败,订单退款
            $where[]    = array('name' => 'gm_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[]    = array('name' => 'gm_go_id', 'oper' => '=', 'value' => $goid);
            $where[]    = array('name' => 'gm_had_refund', 'oper' => '=', 'value' => 0);//未退款订单
            $join_list  = $mem_model->getList($where, 0, 0);
            $tids       = array();
            foreach ($join_list as $item) {
                array_push($tids, $item['gm_tid']);
            }
            $flag   = $this->_trade_refund_deal($tids);
            Libs_Log_Logger::outputLog($flag);
            //全部成功退款时
            if ($flag) {
                $updata = array(
                    'go_status'     => self::GROUP_STATUS_FAILURE,//置为失败
                    'go_over_time'  => time(),
                );
                $org_model->updateById($updata, $group['go_id']);
            }
            //是否需要发送拼团失败模板消息
            $send_type  = 'ptsb';
        }
        $mids   = array();
        $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
        if($appletCfg['ac_type'] == 12){//培训版订单直接完成
            $updata         = array('t_status' => App_Helper_Trade::TRADE_FINISH);
        }else{
            $updata         = array('t_status' => App_Helper_Trade::TRADE_HAD_PAY);
        }

        foreach ($joiner as $item) {
            if ($item['gm_tid'] && !$item['gm_is_robot']) {
                if ($pintuan_success) {
                    $trade_model->findUpdateTradeByTid($item['gm_tid'], $updata);
                }
                $mids[]     = intval($item['gm_mid']);
                $this->sendGroupTmplmsg($item['gm_tid'], $send_type);
                $this->sendAppletGroupTmplmsg($item['gm_tid'], $send_type);
            }
        }
        $this->sendGroupNewsmsg($group['gb_id'], $mids, $send_type);
        return true;
    }
    /*
     * 订单退款处理
     */
    private function _trade_refund_deal(array $tids) {
        $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade_helper   = new App_Helper_Trade($this->sid);

        $mem_model      = new App_Model_Group_MysqlMemStorage($this->sid);
        $flag   = true;
        foreach ($tids as $tid) {
            $trade      = $trade_model->findUpdateTradeByTid($tid);
            $refund_model   = new App_Model_Trade_MysqlTradeRefundStorage($this->sid);

            $indata     = array(
                'tr_s_id'       => $this->sid,
                'tr_wid'        => App_Plugin_Weixin_PayPlugin::makeMchOrderid('W'),
                'tr_tid'        => $tid,
                'tr_reason'     => '组团失败,系统自动退款',//退款原因
                'tr_money'      => $trade['t_total_fee'],
                'tr_create_time'=> time(),//退款编号创建时间
                'tr_status'     => 0,//退款处理中
            );
            $rfid = $refund_model->insertValue($indata);
            if($trade['t_type']>=5){
                $ret = $trade_helper->appletDealRefund($trade['t_id']);
            }else{
                $ret = $trade_helper->dealRefund($trade['t_id']);
            }
            if (!$ret['errcode']) {
                //设置退款成功
                $updata = array('gm_had_refund' => 1);
                $mem_model->updateJoinByTid($tid, $updata);
                $refund_model->updateById(array('tr_status' => 1, 'tr_finish_time' => time()), $rfid);
            } else {//退款失败
                $flag   = false;
                Libs_Log_Logger::outputLog($ret['errmsg']);
            }
        }
        return $flag;
    }
    /*
     * 替换拼团
     */
    public function replaceGroupTpl($group, $tpl, $jump) {
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        $tplval  = array(
            $group['go_total'], $group['gb_price'], $group['go_tz_nick'], $group['go_had'], intval($group['go_total'])-intval($group['go_had']),
            date("Y-m-d H:i:s", $group['gm_join_time']),
        );
        $tplreg   = $cfg[2];

        $jumpval    = array(
            App_Helper_Tool::outputMobileLink($this->sid, 'group', 'join', array('gbid' => $group['go_id'])),
            App_Helper_Tool::outputMobileLink($this->sid, 'group', 'detail', array('gbid' => $group['gb_id'])),
        );

        $jumpreg    = $cfg["url-2"];

        foreach ($tplreg as &$item) {
            $item   = "/{$item}/";
        }

        foreach ($jumpreg as &$item) {
            $item   = "/{$item}/";
        }

        return array(
            preg_replace($tplreg, $tplval, $tpl),
            preg_replace($jumpreg, $jumpval, $jump)
        );
    }

    /*
     * 发送微信模板消息
     * @param string $tid 交易订单号
     * @param string $type 激发消息类型, zfcg(支付成功), ptcg(拼团成功), ptsb(拼团失败), hdjs(活动结束)
     */
    public function sendGroupTmplmsg($tid, $type) {
        $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade      = $trade_model->findUpdateTradeByTid($tid);

        $mem_model  = new App_Model_Group_MysqlMemStorage($this->sid);
        $group      = $mem_model->findGroupOrg($tid, $trade['t_m_id']);

        if ($group && $group["gb_{$type}_msgid"]) {
            $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($group["gb_{$type}_msgid"]);

            if ($tplmsg) {
                $trade_helper   = new App_Helper_Trade($this->sid);
                //替换订单数据
                $tpl    = $tplmsg['wt_data'];
                $jump   = $tplmsg['wt_url'];
                list($tpl, $jump)    = $trade_helper->replaceTradeTpl($trade, $tpl, $jump);
                //替换拼团数据
                list($tpl, $jump)    = $this->replaceGroupTpl($group, $tpl, $jump);

                $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                $openids        = $member_model->getOptionsBySidMid($this->sid, array($trade['t_m_id']));
                if (!empty($openids) && $openids[0]) {
                    $weixin_client  = new App_Plugin_Weixin_ClientPlugin($this->sid);
                    $tpl = json_decode($tpl, true);
                    $jump   = plum_is_url($jump) ? $jump : '';
                    $ret = $weixin_client->sendTemplateMessage($openids[0], $tplmsg['wt_tplid'], $jump, $tpl);
                }
            }
        }
    }


    /*
     * 小程序拼团模板消息
     * @param string $tid 交易订单号
     * @param string $type 激发消息类型, zfcg(支付成功), ptcg(拼团成功), ptsb(拼团失败), hdjs(活动结束)
     */
    public function sendAppletGroupTmplmsg($tid, $type) {
        $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade      = $trade_model->findUpdateTradeByTid($tid);

        $mem_model  = new App_Model_Group_MysqlMemStorage($this->sid);
        $group      = $mem_model->findGroupOrg($tid, $trade['t_m_id']);

        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $goods = $goods_model->getRowById($group['gb_g_id']);

        if ($group && $group["gb_{$type}_msgid"]) {
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($group["gb_{$type}_msgid"]);

            if ($tplmsg) {
                $trade_helper   = new App_Helper_Trade($this->sid);
                //替换订单数据
                $tpl    = $tplmsg['awt_data'];
                list($tpl, $jump)    = $trade_helper->replaceTradeTpl($trade, $tpl);
                Libs_Log_Logger::outputLog($tpl);
                //替换拼团数据
                list($tpl, $jump)    = $trade_helper->replaceGroupTpl($group, $tpl, $goods);
                Libs_Log_Logger::outputLog($tpl);

                $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                $openids        = $member_model->getOptionsBySidMid($this->sid, array($trade['t_m_id']));
                if (!empty($openids) && $openids[0]) {
                    $weixin_client  = new App_Plugin_Weixin_WxxcxClient($this->sid);
                    $tpl = json_decode($tpl, true);
                    //处理数据data
                    $data   = array();
                    foreach ($tpl as $val) {
                        $data[$val['key']]  = array(
                            'value' => trim($val['contxt'], "{}"),
                            'color' => $val['color'],
                        );
                    }
                    $formid = '';
                    $formids_model = new App_Model_Member_MysqlMemberFormidsStorage($this->sid);
                    $where[] = array('name' => 'af_s_id', 'oper' => '=', 'value' => $this->sid);
                    $where[] = array('name' => 'af_m_id', 'oper' => '=', 'value' => $trade['t_m_id']);
                    $formids = $formids_model->getRow($where);
                    $ids = json_decode($formids['af_ids'],true);
                    foreach($ids as $k => $v){
                        if($v['expire']>time()){
                            $formid = $v['formId'];
                            unset($ids[$k]);
                            $udata = array('af_ids' => json_encode(array_values($ids)));
                            $formids_model->updateById($udata, $formids['af_id']);
                            break;
                        }
                    }
                    $emphasls   = intval($tplmsg['awt_emphasis']);
                    $ret = $weixin_client->sendTemplateMessage($openids[0], $tplmsg['awt_tplid'], $formid, $data, '', $emphasls);
                }
            }
        }
    }

    /*
     * 发送中奖模板消息
     * @param string $tid 订单编号
     * @param string $type tktz,zjjg,lqtz
     */
    public function sendLotteryTmplmsg($tid, $type) {
        $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade      = $trade_model->findUpdateTradeByTid($tid);

        $mem_model  = new App_Model_Group_MysqlMemStorage($this->sid);
        $group      = $mem_model->findGroupOrg($tid, $trade['t_m_id']);

        $cjres_model= new App_Model_Group_MysqlGoodLuckStorage($this->sid);
        $lottery    = $cjres_model->fetchRowUpdateByGbId($group['gb_id']);

        if ($lottery && $lottery["gc_{$type}_msgid"]) {
            $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($lottery["gc_{$type}_msgid"]);

            if ($tplmsg) {
                $trade_helper   = new App_Helper_Trade($this->sid);
                //替换订单数据
                $tpl    = $tplmsg['wt_data'];
                $jump   = $tplmsg['wt_url'];
                list($tpl, $jump)    = $trade_helper->replaceTradeTpl($trade, $tpl, $jump);
                //替换拼团数据
                list($tpl, $jump)    = $this->replaceGroupTpl($group, $tpl, $jump);

                $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                $openids        = $member_model->getOptionsBySidMid($this->sid, array($trade['t_m_id']));
                if (!empty($openids) && $openids[0]) {
                    $weixin_client  = new App_Plugin_Weixin_ClientPlugin($this->sid);
                    $tpl = json_decode($tpl, true);
                    $jump   = plum_is_url($jump) ? $jump : '';
                    $ret = $weixin_client->sendTemplateMessage($openids[0], $tplmsg['wt_tplid'], $jump, $tpl);
                }
            }
        }
    }
    /*
     * 发送微信客服图文消息
     */
    public function sendGroupNewsmsg($gbid, array $mids, $type) {
        set_time_limit(0);
        //排重,去空
        if (empty($mids)) {
            return;
        }
        $mids   = array_unique($mids);

        $group_model    = new App_Model_Group_MysqlBuyStorage($this->sid);
        $group  = $group_model->getRowById($gbid);

        if ($group && $group["gb_{$type}_nwid"]) {
            $news_model = new App_Model_Auth_MysqlWeixinNewsStorage();
            $news   = $news_model->findNewsById($group["gb_{$type}_nwid"]);

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
                $openids        = $member_model->getOptionsBySidMid($this->sid, $mids);
                if (!empty($openids)) {
                    $weixin_client  = new App_Plugin_Weixin_ClientPlugin($this->sid);

                    foreach ($openids as $oid) {
                        if ($oid) {
                            $weixin_client->sendLinkNewsMessage($oid, $article);
                            usleep(300);
                        }
                    }
                }
            }
        }
    }
    /*
     * 发送中奖图文消息
     * @param int $gbid 活动ID
     * @param array $mids 中奖人员ID数组
     * @param string $type
     */
    public function sendLotteryNewsmsg($gbid, array $mids, $type) {
        set_time_limit(0);
        //排重,去空
        if (empty($mids)) {
            return;
        }
        $mids   = array_unique($mids);
        $cjres_model= new App_Model_Group_MysqlGoodLuckStorage($this->sid);
        $lottery    = $cjres_model->fetchRowUpdateByGbId($gbid);

        if ($lottery && $lottery["gc_{$type}_nwid"]) {
            $news_model = new App_Model_Auth_MysqlWeixinNewsStorage();
            $news   = $news_model->findNewsById($lottery["gc_{$type}_nwid"]);

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
                $openids        = $member_model->getOptionsBySidMid($this->sid, $mids);
                if (!empty($openids)) {
                    $weixin_client  = new App_Plugin_Weixin_ClientPlugin($this->sid);

                    foreach ($openids as $oid) {
                        if ($oid) {
                            $weixin_client->sendLinkNewsMessage($oid, $article);
                            usleep(300);
                        }
                    }
                }
            }
        }
    }

    /*
     * 拼团活动结束时调用
     */
    public function groupBuyEndtime($gbid) {
        set_time_limit(0);//防止宕机
        $group_model    = new App_Model_Group_MysqlBuyStorage($this->sid);
        $group  = $group_model->getRowById($gbid);

        if ($group && ($group['gb_hdjs_msgid'] || $group['gb_hdjs_nwid'])) {
            $mem_model  = new App_Model_Group_MysqlMemStorage($this->sid);

            $index  = -20;
            $count  = 20;
            do {
                $index  += $count;
                $list   = $mem_model->fetchBuyJoinList($gbid, $index, $count);
                $mids   = array();
                foreach ($list as $item) {
                    //批量发送消息
                    if ($item['gm_tid'] && !$item['gm_is_robot']) {
                        $mids[] = intval($item['gm_mid']);
                        $this->sendGroupTmplmsg($item['gm_tid'], 'hdjs');
                        $this->sendAppletGroupTmplmsg($item['gm_tid'], 'hdjs');
                        usleep(300);
                    }
                }
                $this->sendGroupNewsmsg($gbid, $mids, 'hdjs');
            } while (count($list) == $count);
        }
    }
    /*
     * 拼团活动关闭前调用
     */
    public function groupCloseCountdown($goid) {
        $goid   = intval($goid);
        $org_model  = new App_Model_Group_MysqlOrgStorage($this->sid);
        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->sid);
        $appletCfg        = $applet_cfg->findShopCfg();
        if($appletCfg['ac_type'] == 12){
            $group  = $org_model->findGroupOrgCourse($goid);
        }else{
            $group  = $org_model->findGroupOrg($goid);
        }


        if (!$group) {
            return false;
        }
        //非进行中的拼团无法操作
        if ($group['go_status'] > self::GROUP_STATUS_RUNNING) {
            return false;
        }

        if ($group['gb_gbtx_msgid'] || $group['gb_gbtx_nwid']) {
            $mem_model  = new App_Model_Group_MysqlMemStorage($this->sid);
            $list       = $mem_model->fetchJoinList($goid);
            $mids   = array();
            foreach ($list as $item) {
                //批量发送消息
                if ($item['gm_tid'] && !$item['gm_is_robot']) {
                    $mids[] = intval($item['gm_mid']);
                    $this->sendGroupTmplmsg($item['gm_tid'], 'gbtx');
                    $this->sendAppletGroupTmplmsg($item['gm_tid'], 'gbtx');
                    usleep(300);
                }
            }
            $this->sendGroupNewsmsg($group['gb_id'], $mids, 'gbtx');
        }
    }
    /*
     * 拼团促销定时任务
     */
    public function groupPromotionTask($goid, $type) {


        $goid   = intval($goid);
        $org_model  = new App_Model_Group_MysqlOrgStorage($this->sid);
        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->sid);
        $appletCfg        = $applet_cfg->findShopCfg();
        if($appletCfg['ac_type'] == 12){
            $group  = $org_model->findGroupOrgCourse($goid);
        }else{
            $group  = $org_model->findGroupOrg($goid);
        }


        if (!$group) {
            return false;
        }

        $type   = $type == 'goods' ? 'spdt' : 'dpdt';
        if ($group["gb_{$type}_msgid"] || $group["gb_{$type}_nwid"]) {
            $mem_model  = new App_Model_Group_MysqlMemStorage($this->sid);
            $list       = $mem_model->fetchJoinList($goid);
            $mids   = array();
            foreach ($list as $item) {
                //批量发送消息
                if ($item['gm_tid'] && !$item['gm_is_robot']) {
                    $mids[] = intval($item['gm_mid']);
                    $this->sendGroupTmplmsg($item['gm_tid'], $type);
                    $this->sendAppletGroupTmplmsg($item['gm_tid'], $type);
                    usleep(300);
                }
            }
            $this->sendGroupNewsmsg($group['gb_id'], $mids, $type);
        }
    }

    public static function scanPushEvent($gbid, $openid) {
        $group_model    = new App_Model_Group_MysqlBuyStorage();
        $group      = $group_model->getRowById($gbid);

        $sid        = $group['gb_s_id'];

        if ($group) {
            $domain = plum_parse_config('shield_domain', 'weixin');
            $article    = array(
                array(
                    'title'         => $group['gb_share_title'],
                    'description'   => $group['gb_share_desc'],
                    'url'           => App_Helper_Tool::outputMobileLink($sid, 'group', 'detail', array('gbid' => $gbid)),
                    'picurl'        => "http://{$domain}".$group['gb_cover'],
                ),
            );

            $weixin_client  = new App_Plugin_Weixin_ClientPlugin($sid);
            $weixin_client->sendLinkNewsMessage($openid, $article);
        }
    }


    /*
     * 手动退款发送退款通知（抽奖团使用）
     */
    public function refundNoticeMsgAction($tid){
        $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade      = $trade_model->findUpdateTradeByTid($tid);

        $mem_model  = new App_Model_Group_MysqlMemStorage($this->sid);
        $group      = $mem_model->findGroupOrg($tid, $trade['t_m_id']);

        $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
        $tplmsg     = $tplmsg_model->findOneById(16);  // 获取退款id

        if ($tplmsg) {
            $trade_helper   = new App_Helper_Trade($this->sid);
            //替换订单数据
            $tpl    = $tplmsg['wt_data'];
            $jump   = $tplmsg['wt_url'];
            list($tpl, $jump)    = $trade_helper->replaceTradeTpl($trade, $tpl, $jump);
            //替换拼团数据
            list($tpl, $jump)    = $this->replaceGroupTpl($group, $tpl, $jump);

            $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
            $openids        = $member_model->getOptionsBySidMid($this->sid, array($trade['t_m_id']));
            if (!empty($openids) && $openids[0]) {
                $weixin_client  = new App_Plugin_Weixin_ClientPlugin($this->sid);
                $tpl = json_decode($tpl, true);
                $jump   = plum_is_url($jump) ? $jump : '';
                $ret = $weixin_client->sendTemplateMessage($openids[0], $tplmsg['wt_tplid'], $jump, $tpl);
            }
        }
    }

    /*
     * 扫码推送参与信息
     */
    public static function scanPushGroupJoin($goid, $sid, $openid) {
        $org_model      = new App_Model_Group_MysqlOrgStorage($sid);
        $group      = $org_model->getGroupOrgInfoById($goid);
        if ($group) {
            $domain = plum_parse_config('shield_domain', 'weixin');
            $article    = array(
                array(
                    'title'         => $group['gb_share_title'],
                    'description'   => $group['gb_share_desc'],
                    'url'           => App_Helper_Tool::outputMobileLink($sid, 'group', 'join', array('gbid' => $goid)),
                    'picurl'        => "http://{$domain}".$group['gb_cover'],
                ),
            );

            $weixin_client  = new App_Plugin_Weixin_ClientPlugin($sid);
            $weixin_client->sendLinkNewsMessage($openid, $article);
        }
    }

    /*
    * 商家岛订单退款处理
    */
    private function _merchant_trade_refund_deal(array $tids) {
        $trade_model    = new App_Model_Merchant_MysqlMerchantTradeStorage();
        $trade_helper   = new App_Helper_MerchantTrade($this->sid);

        $mem_model      = new App_Model_Merchant_MysqlMerchantGroupMemStorage($this->sid);
        $flag   = true;
        foreach ($tids as $tid) {
            $trade      = $trade_model->findUpdateTradeByTid($tid);
            $refund_model   = new App_Model_Merchant_MysqlMerchantTradeRefundStorage($this->sid);

            $indata     = array(
                'mtr_s_id'       => $this->sid,
                'mtr_wid'        => App_Plugin_Weixin_PayPlugin::makeMchOrderid('W'),
                'mtr_tid'        => $tid,
                'mtr_reason'     => '组团失败,系统自动退款',//退款原因
                'mtr_money'      => $trade['mt_total'],
                'mtr_create_time'=> time(),//退款编号创建时间
                'mtr_status'     => 0,//退款处理中
            );
            $rfid = $refund_model->insertValue($indata);
            $ret = $trade_helper->merchantDealRefund($trade['mt_id']);
            if (!$ret['errcode']) {
                //设置退款成功
                $updata = array('mgm_had_refund' => 1);
                $mem_model->updateJoinByTid($tid, $updata);
                $refund_model->updateById(array('mtr_status' => 1, 'mtr_finish_time' => time()), $rfid);
            } else {//退款失败
                $flag   = false;
                Libs_Log_Logger::outputLog($ret['errmsg']);
            }
        }
        return $flag;
    }

    /*
     * 商家岛
     * 组团活动超过24小时,失败时调用
     * $param int $goid 组团活动ID
     */
    public function merchantGroupOrgOvertime($goid) {
        Libs_Log_Logger::outputLog('商家岛 24小时组团失败');
        $goid   = intval($goid);
        $org_model  = new App_Model_Merchant_MysqlMerchantGroupOrgStorage($this->sid);
        $group  = $org_model->findGroupOrg($goid);
        if (!$group) {
            return false;
        }

        //非进行中的拼团无法操作
        if ($group['mgo_status'] > self::GROUP_STATUS_RUNNING) {
            Libs_Log_Logger::outputLog("拼团已结束");
            return false;
        }
        $mem_model  = new App_Model_Merchant_MysqlMerchantGroupMemStorage($this->sid);
        $joiner     = $mem_model->fetchJoinList($goid);

        $pintuan_success    = false;//拼团成功?
        //自动成团
        if ($group['mgc_use_auto']) {
            $pintuan_success    = true;
            $updata = array(
                'mgo_status'     => self::GROUP_STATUS_SUCCESS,//置为成功
                'mgo_over_time'  => time(),
            );
            $org_model->updateById($updata, $group['mgo_id']);
            for ($i=1; $i<=($group['mgc_total']-$group['mgo_had']); $i++) {
                $indata = array(
                    'mgm_s_id'       => $this->sid,
                    'mgm_mgo_id'      => $group['mgo_id'],
                    'mgm_a_id'      => $group['ma_id'],
                    'mgm_m_id'        => -$i,//匿名会员
                    'mgm_is_robot'   => 1,
                    'mgm_join_time'  => time(),
                );
                $mem_model->insertValue($indata);
            }
            //是否需要发送拼团成功模板消息
            $send_type  = 'ptcg';
            //拼团成功,商品库存量调整
            $real   = $mem_model->getRealJoiner($goid);
            $number = count($real);
            $activity_model = new App_Model_Merchant_MysqlMerchantActivityStorage($this->sid);
            $activity_model->incrementActivityField('ma_sold',$group['ma_id'],$number);
        } else {
            //组团失败,订单退款
            $where[]    = array('name' => 'mgm_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[]    = array('name' => 'mgm_mgo_id', 'oper' => '=', 'value' => $goid);
            $where[]    = array('name' => 'mgm_had_refund', 'oper' => '=', 'value' => 0);//未退款订单
            $join_list  = $mem_model->getList($where, 0, 0);
            $tids       = array();
            foreach ($join_list as $item) {
                array_push($tids, $item['mgm_tid']);
            }
            $flag   = $this->_merchant_trade_refund_deal($tids);
            Libs_Log_Logger::outputLog($flag);
            //全部成功退款时
            if ($flag) {
                $updata = array(
                    'mgo_status'     => self::GROUP_STATUS_FAILURE,//置为失败
                    'mgo_over_time'  => time(),
                );
                $org_model->updateById($updata, $group['mgo_id']);
            }
            //是否需要发送拼团失败模板消息
            $send_type  = 'ptsb';
        }
        $mids   = array();
        $trade_model    = new App_Model_Merchant_MysqlMerchantTradeStorage();

        $updata         = array('mt_status' => App_Helper_MerchantTrade::TRADE_HAD_PAY);
        foreach ($joiner as $item) {
            if ($item['mgm_tid'] && !$item['mgm_is_robot']) {
                if ($pintuan_success) {
                    $trade_model->findUpdateTradeByTid($item['mgm_tid'], $updata);
                }
                //$mids[]     = intval($item['gm_mid']);
                //$this->sendGroupTmplmsg($item['gm_tid'], $send_type);
                //$this->sendAppletGroupTmplmsg($item['gm_tid'], $send_type);
            }
        }
        //$this->sendGroupNewsmsg($group['gb_id'], $mids, $send_type);
        return true;
    }

    /*
     * 商家岛
     * 拼团活动关闭前调用
     */
    public function merchantGroupCloseCountdown($goid) {
        //TODO 发送消息通知
//        $goid   = intval($goid);
//        $org_model  = new App_Model_Merchant_MysqlMerchantGroupOrgStorage($this->sid);
//        $group  = $org_model->findGroupOrg($goid);
//
//        if (!$group) {
//            return false;
//        }
//        //非进行中的拼团无法操作
//        if ($group['mgo_status'] > self::GROUP_STATUS_RUNNING) {
//            return false;
//        }

//        if ($group['gb_gbtx_msgid'] || $group['gb_gbtx_nwid']) {
//            $mem_model  = new App_Model_Group_MysqlMemStorage($this->sid);
//            $list       = $mem_model->fetchJoinList($goid);
//            $mids   = array();
//            foreach ($list as $item) {
//                //批量发送消息
//                if ($item['gm_tid'] && !$item['gm_is_robot']) {
//                    $mids[] = intval($item['gm_mid']);
//                    $this->sendGroupTmplmsg($item['gm_tid'], 'gbtx');
//                    $this->sendAppletGroupTmplmsg($item['gm_tid'], 'gbtx');
//                    usleep(300);
//                }
//            }
//            $this->sendGroupNewsmsg($group['gb_id'], $mids, 'gbtx');
//        }
    }

    /*
     * 拼团促销定时任务
     */
    public function merchantGroupPromotionTask($goid, $type) {
        //TODO 发送通知
//        $goid   = intval($goid);
//        $org_model  = new App_Model_Merchant_MysqlMerchantGroupOrgStorage($this->sid);
//        $group  = $org_model->findGroupOrg($goid);
//        if (!$group) {
//            return false;
//        }
//
//        $type   = $type == 'goods' ? 'spdt' : 'dpdt';
//        if ($group["gb_{$type}_msgid"] || $group["gb_{$type}_nwid"]) {
//            $mem_model  = new App_Model_Group_MysqlMemStorage($this->sid);
//            $list       = $mem_model->fetchJoinList($goid);
//            $mids   = array();
//            foreach ($list as $item) {
//                //批量发送消息
//                if ($item['gm_tid'] && !$item['gm_is_robot']) {
//                    $mids[] = intval($item['gm_mid']);
//                    $this->sendGroupTmplmsg($item['gm_tid'], $type);
//                    $this->sendAppletGroupTmplmsg($item['gm_tid'], $type);
//                    usleep(300);
//                }
//            }
//            $this->sendGroupNewsmsg($group['gb_id'], $mids, $type);
//        }
    }

    /*
     * 拼团活动结束时调用
     */
    public function merchantGroupBuyEndtime($gbid) {

        set_time_limit(0);//防止宕机
        $activity_model = new App_Model_Merchant_MysqlMerchantActivityStorage();
        $activity = $activity_model->getRowById($gbid);
//        if ($group && ($group['gb_hdjs_msgid'] || $group['gb_hdjs_nwid'])) {
//            $mem_model  = new App_Model_Group_MysqlMemStorage($this->sid);
//
//            $index  = -20;
//            $count  = 20;
//            do {
//                $index  += $count;
//                $list   = $mem_model->fetchBuyJoinList($gbid, $index, $count);
//                $mids   = array();
//                foreach ($list as $item) {
//                    //批量发送消息
//                    if ($item['gm_tid'] && !$item['gm_is_robot']) {
//                        $mids[] = intval($item['gm_mid']);
//                        $this->sendGroupTmplmsg($item['gm_tid'], 'hdjs');
//                        $this->sendAppletGroupTmplmsg($item['gm_tid'], 'hdjs');
//                        usleep(300);
//                    }
//                }
//                $this->sendGroupNewsmsg($gbid, $mids, 'hdjs');
//            } while (count($list) == $count);
//        }
    }
}
