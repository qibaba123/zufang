<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/8/23
 * Time: 下午4:52
 */

class App_Helper_WxappApplet{

    const SEND_SETUP_ZFCG   = 'zfcg';
    const SEND_SETUP_MJFH   = 'mjfh';
    const SEND_SETUP_QRSH   = 'qrsh';
    const SEND_SETUP_AUDIT  = 'audit';
    const SEND_SETUP_COMMENT= 'comment';
    const SEND_SETUP_LIKE   = 'like';
    const SEND_SETUP_TRADEVERIFY = 'se_trade_verify'; //社区团购订单核销
    const SEND_SETUP_CREATEACTIVITY = 'se_create_activity'; //社区团购发起活动
    const SEND_SETUP_JOINACTIVITY = 'se_join_activity'; //社区团购参加活动

    private $sid;

    public function __construct($sid)
    {
        $this->sid  = $sid;
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $this->shop = $shop_model->getRowById($sid);
    }

    /*
     * 将置顶到期的帖子改成未置顶状态
     * $pid 帖子的主键ID
    */
    public function updateTopOvertimePost($pid) {
        $post_model = new App_Model_City_MysqlCityPostStorage($this->sid);
        $row = $post_model->getRowById($pid);
        // 如果第一次取不到数据就再取一次
        if(!$row){
            $row = $post_model->getRowById($pid);
        }
        // 判断记录是否存在
        if (!$row) {
            return false;
        }
        // 判断帖子是否在置顶状态，置顶时间是否到期
        if($row['acp_istop']==1 && ($row['acp_istop_expiration']-60) < time()){
            $set = array('acp_istop'=>0,'acp_top_date'=>0);
            return $post_model->updateById($set,$pid);
        }
        return false;
    }

    /*
     * 将置顶到期的车源改成未置顶状态
     * $pid 车源的主键ID
    */
    public function updateTopOvertimeCar($pid) {
        $post_model = new App_Model_Car_MysqlCarResourceStorage($this->sid);
        $row = $post_model->getRowById($pid);
        // 如果第一次取不到数据就再取一次
        if(!$row){
            $row = $post_model->getRowById($pid);
        }
        // 判断记录是否存在
        if (!$row) {
            return false;
        }
        // 判断车源是否在置顶状态，置顶时间是否到期
        if($row['acr_is_top']==1 && ($row['acr_top_expire']-60) < time()){
            $set = array('acr_is_top'=>0,'acr_top_date'=>0);
            return $post_model->updateById($set,$pid);
        }
        return false;
    }

    /*
     * 将置顶到期的职位改成未置顶状态
     * $pid 帖子的主键ID
    */
    public function updateTopOvertimePosition($pid) {
        $position_model = new App_Model_Job_MysqlJobPositionStorage($this->sid);
        $row = $position_model->getRowById($pid);
        // 如果第一次取不到数据就再取一次
        if(!$row){
            $row = $position_model->getRowById($pid);
        }
        // 判断记录是否存在
        if (!$row) {
            return false;
        }
        // 判断帖子是否在置顶状态，置顶时间是否到期
        if($row['ajp_is_top']==1 && ($row['ajp_top_expiration']-60) < time()){
            $set = array('ajp_is_top'=>0,'ajp_top_days'=>0);
            return $position_model->updateById($set,$pid);
        }
        return false;
    }

    /*
     * 多店
     * 将置顶到期的帖子改成未置顶状态
     * $pid 帖子的主键ID
    */
    public function updateCommunityTopOvertimePost($pid) {
        $post_model = new App_Model_Community_MysqlCommunityPostStorage($this->sid);
        $row = $post_model->getRowById($pid);
        // 如果第一次取不到数据就再取一次
        if(!$row){
            $row = $post_model->getRowById($pid);
        }
        // 判断记录是否存在
        if (!$row) {
            return false;
        }
        // 判断帖子是否在置顶状态，置顶时间是否到期
        if($row['acp_istop']==1 && ($row['acp_istop_expiration']-60) < time()){
            $set = array('acp_istop'=>0,'acp_top_date'=>0);
            return $post_model->updateById($set,$pid);
        }
        return false;
    }

    /*
     * 社区团购
     * 将置顶到期的帖子改成未置顶状态
     * $pid 帖子的主键ID
    */
    public function updateSequenceTopOvertimePost($pid) {
        $post_model = new App_Model_Sequence_MysqlSequencePostStorage($this->sid);
        $row = $post_model->getRowById($pid);
        // 如果第一次取不到数据就再取一次
        if(!$row){
            $row = $post_model->getRowById($pid);
        }
        // 判断记录是否存在
        if (!$row) {
            return false;
        }
        // 判断帖子是否在置顶状态，置顶时间是否到期
        if($row['asp_is_top']==1 && ($row['asp_top_expire']) <= time()){
            $set = array('asp_is_top'=>0,'asp_top_expire'=>0);
            return $post_model->updateById($set,$pid);
        }
        return false;
    }

    /*
     * 将到期未领完的红包退款
     * $pid 帖子的主键ID
     */
    public function updateBagOvertimePost($pid) {
        $post_model = new App_Model_City_MysqlCityPostStorage($this->sid);
        $row = $post_model->getRowById($pid);
        // 判断记录是否存在
        if (!$row) {
            return false;
        }
        // 判断帖子是否在置顶状态，置顶时间是否到期
        if($row['acp_isRedbag']==1 && ($row['acp_refund_time']-60) < time()){
            //增加会员同城账户的余额
            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
            $member = $member_model->getRowById($row['acp_m_id']);
            $mset = array(
                'm_deduct_ktx' => $member['m_deduct_ktx'] + $row['acp_redbag_balance']
            );
            $member_model->updateById($mset, $row['acp_m_id']);
            //记录领取记录
            $insert = array(
                'acrr_s_id' => $this->sid,
                'acrr_m_id' => $row['acp_m_id'],
                'acrr_post_id' => $pid,
                'acrr_post_balance' => 0,
                'acrr_type' => 1,
                'acrr_money' => $row['acp_redbag_balance'],
                'acrr_create_time' => time()
            );
            $receive_model = new App_Model_City_MysqlCityRedbagReceiveStorage($this->sid);
            $receive_model->insertValue($insert);
            $set = array('acp_redbag_balance'=>0);
            return $post_model->updateById($set,$pid);
        }
        return false;
    }

    /*
     * 将置顶到期的房源改成未置顶状态
     * $hid 房源的主键ID
    */
    public function updateTopOvertimeHouse($hid) {
        $resource_model = new App_Model_Resources_MysqlResourcesStorage($this->sid);
        $row = $resource_model->getRowById($hid);
        if($row['ahr_is_top'] == 1){
            $set = array('ahr_is_top'=>0,'ahr_top_date'=>0,'ahr_istop_expiration'=>0);
        }else{
            $set = array('ahr_status'=>0,'ahr_top_date'=>0,'ahr_istop_expiration'=>0);
        }
        return $resource_model->updateById($set,$hid);
    }


    /**
     * 面试时间过后，自动确认面试
     */
    public function confirmInterview($id){
        $send_model = new App_Model_Job_MysqlJobSendStorage($this->sid);
        $send   = $send_model->getRowById($id);
        if($send && $send['ajs_status'] == 4){
            //确认面试
            $set = array(
                'ajs_status'         => 5,
                'ajs_update_time'    => time(),
            );
            $ret = $send_model->updateById($set,$send['ajs_id']);
            $set = array('ajs_seeker_read' => 0);
            $send_model->updateById($set, $id);
            return $ret;
        }
        if($send && $send['ajs_status'] == 3){
            //确认面试
            $set = array(
                'ajs_status'         => 9,
                'ajs_end_time'       => time(),
                'ajs_update_time'    => time(),
            );
            $ret = $send_model->updateById($set,$send['ajs_id']);
            $set = array('ajs_seeker_read' => 0);
            $send_model->updateById($set, $id);
            return $ret;
        }
        return false;
    }

    /**
     * 招聘到期未确认 自动发放入职奖
     */
    public function sendAward($id){
        $receive_model = new App_Model_Job_MysqlJobReceiveAwardStorage($this->sid);
        $receive = $receive_model->getRowById($id);
        if($receive && $receive['ajra_status'] == 0){
            //增加会员账户的余额
            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
            $member = $member_model->getRowById($receive['ajra_m_id']);
            $mset = array(
                'm_deduct_ktx' => $member['m_deduct_ktx'] + $receive['ajra_award']
            );
            $ret = $member_model->updateById($mset, $receive['ajra_m_id']);

            //给上级增加余额
            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
            $member = $member_model->getRowById($receive['ajra_f1_mid']);
            $mset = array(
                'm_deduct_ktx' => $member['m_deduct_ktx'] + $receive['ajra_f1_award']
            );
            $ret = $member_model->updateById($mset, $receive['ajra_f1_mid']);
            //将状态修改为通过
            $set = array('ajra_status' => 1);
            $receive_model->updateById($set, $id);
            //修改职位奖励
            $position_model = new App_Model_Job_MysqlJobPositionStorage($this->sid);
            $position = $position_model->getRowById($receive['ajra_ajp_id']);
            $set = array(
                'ajp_left_entry_award'           => $position['ajp_left_entry_award'] - $receive['ajra_f1_award'],
                'ajp_left_entry_num'             => $position['ajp_left_entry_num'] - 1,
                'ajp_received_entry_award'       => $position['ajp_received_entry_award'] + $receive['ajra_f1_award'],
                'ajp_received_entry_num'         => $position['ajp_received_entry_num'] + 1,
                'ajp_left_recommended_award'     => $position['ajp_left_recommended_award'] - $receive['ajra_award'],
                'ajp_received_recommended_award' => $position['ajp_received_recommended_award'] + $receive['ajra_award'],
                'ajp_received_recommended_num'   => $position['ajp_received_recommended_num'] + 1,
            );
            $position_model->updateById($set, $position['ajp_id']);
            //做账户变动记录
            if($receive['ajra_f1_award']){
                $this->_deal_withdraw_result($receive['ajra_f1_award'],2,'推荐人已入职，奖励推荐入职奖', $receive['ajra_f1_mid']);
            }
            if($receive['ajra_award']){
                $this->_deal_withdraw_result($receive['ajra_award'],2,'已入职，奖励入职奖', $receive['ajra_m_id']);
            }
        }
        return false;
    }

    /**
     * @param array $record
     * @param $status
     * @param string $tid
     * @return bool
     * 转账成功后，1、处理用户金额；2、记录流水
     */
    private function _deal_withdraw_result($money,$inout=1,$desc, $mid){
        $data = array(
            'dd_s_id'           => $this->sid,
            'dd_m_id'           => $mid,
            'dd_o_id'           => 0,
            'dd_amount'         => $money,
            'dd_tid'            => '',
            'dd_level'          => 0,
            'dd_inout_put'     => $inout,
            'dd_record_type'    => 4,
            'dd_record_time'    => time(),
            'dd_record_remark'  => $desc
        );
        $book_model = new App_Model_Deduct_MysqlDeductDaybookStorage();
        $book_ret = $book_model->insertValue($data);
    }

    /**
     * @param $tid
     * @param $type
     * @param $applet
     * 拍卖活动结束
     */
    public function auctionEnd($id){
        $auction_model = new App_Model_Auction_MysqlAuctionListStorage($this->sid);
        $auction = $auction_model->getRowById($id);
        if($auction['aal_end_time'] < time()){
            $set['aal_is_end'] = 1;
            $auction_model->updateById($set, $id);
            $record_model = new App_Model_Auction_MysqlAuctionRecordStorage($this->sid);
            $record = $record_model->getMaxPrice($id);
            $join_model = new App_Model_Auction_MysqlAuctionJoinStorage($this->sid);
            $hadJoin = $join_model->hadJoin($id, $record['aar_m_id']);
            $set = array(
                'aaj_is_winner' => 1,
                'aaj_status' => 2,
                'aaj_win_time' => time()
            );
            $join_model->updateById($set, $hadJoin['aaj_id']);
            $trade_model= new App_Model_Trade_MysqlTradeStorage($this->sid);
            $trade      = $trade_model->findUpdateTradeByTid($hadJoin['aaj_tid']);
            //设置付尾款超时倒计时
            $tpl_model = new App_Model_Auction_MysqlAuctionIndexStorage($this->sid);
            $tpl  = $tpl_model->findUpdateBySid();
            $overTime = $tpl&& $tpl['aai_confirm_time'] > 0 ? $tpl['aai_confirm_time']*60*60*24 : 7*60*60*24;
            //拍卖结束倒计时
            $applet_redis = new App_Model_Applet_RedisAppletStorage($this->sid);
            $applet_redis->setAuctionTradeCloseTtl($trade['t_id'], $overTime);

            //订单退款
            $where[]    = array('name' => 'aaj_aal_id', 'oper' => '=', 'value' => $id);
            $where[]    = array('name' => 'aaj_is_winner', 'oper' => '=', 'value' => 0);
            $where[]    = array('name' => 'aaj_status', 'oper' => '=', 'value' => 1);
            $where[]    = array('name' => 'aaj_had_refund', 'oper' => '=', 'value' => 0);//未退款订单
            $join_list  = $join_model->getList($where, 0, 0);
            $tids       = array();
            foreach ($join_list as $item) {
                array_push($tids, $item['aaj_tid']);
            }
            $this->_trade_refund_deal($tids);
        }

    }

    /**
     * @param array $tids
     * 拍卖订单关闭
     */
    public function auctionTradeClose($tid){
        $trade_model= new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade      = $trade_model->getRowById($tid);

        if (!$trade) {
            return false;
        }
        if ($trade['t_status'] == App_Helper_Trade::TRADE_WAIT_GROUP) {
            $updata = array(
                't_status'  => App_Helper_Trade::TRADE_AUCTION_NO_PAY,
            );
            return $trade_model->updateById($updata, $trade['t_id']);
        }
        return false;
    }

    /*
     * 订单退款处理
     */
    private function _trade_refund_deal(array $tids) {
        $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade_helper   = new App_Helper_Trade($this->sid);

        $join_model = new App_Model_Auction_MysqlAuctionJoinStorage($this->sid);
        $flag   = true;
        foreach ($tids as $tid) {
            $trade      = $trade_model->findUpdateTradeByTid($tid);
            $refund_model   = new App_Model_Trade_MysqlTradeRefundStorage($this->sid);

            $indata     = array(
                'tr_s_id'       => $this->sid,
                'tr_wid'        => App_Plugin_Weixin_PayPlugin::makeMchOrderid('W'),
                'tr_tid'        => $tid,
                'tr_reason'     => '拍卖未获拍,系统自动退款',//退款原因
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
                $updata = array('aaj_had_refund' => 1, 'aaj_status' => 3);
                $join_model->updateJoinByTid($tid, $updata);
                $refund_model->updateById(array('tr_status' => 1, 'tr_finish_time' => time()), $rfid);
            } else {//退款失败
                $flag   = false;
                Libs_Log_Logger::outputLog($ret['errmsg']);
            }
        }
        return $flag;
    }

    /*
     * 发送小程序模板消息
     * @param string $type [zfcg,mjfh,qrsh,audit,comment,like,share]支付成功、卖家发货、确认收货、入驻审核、帖子评论 帖子点赞, 帖子转发
     */
    public function sendWxappTmplmsg($tid, $type, $applet,$appletType = 0) {
        if($this->sid == 4546){
            Libs_Log_Logger::outputLog('appletType:'.$appletType,'test.log');
        }

        //查找当前类型是否开启模板消息
        if($appletType == 5){
            $setup_model    = new App_Model_Applet_MysqlWechatTplMsgSetupStorage($this->sid);
            $setup  = $setup_model->findOneBySid();
            $applet_model   = new App_Model_Weixin_MysqlWeixinCfgStorage($this->sid);
            $appletCfg     = $applet_model->findShopCfg();
        }else{
            $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->sid);
            $setup  = $setup_model->findOneBySid();
            $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->sid);
            $appletCfg     = $applet_model->findShopCfg();
        }


        if($appletCfg['ac_type'] == 32 || $appletCfg['ac_type'] == 36){ //社区拼团给团长发一条消息
            $this->_send_tpl_to_group_leader($tid);
        }
        Libs_Log_Logger::outputLog("发送订单支付消息".$tid);
        if (isset($setup["aws_{$type}_open"]) && $setup["aws_{$type}_open"]) {
            $mid    = $setup["aws_{$type}_mid"];
            if ($mid) {
                $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
                $trade      = $trade_model->findUpdateTradeByTid($tid);
                $jump = null;
                //发送消息模板
                if($appletType == 5){
                    $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
                    $tplmsg     = $tplmsg_model->findOneById($mid);
                    $tplmsg['awt_data'] = $tplmsg['wt_data'];
                    $jump   = $tplmsg['wt_url'];
                }else{
                    $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
                    $tplmsg     = $tplmsg_model->findOneById($mid);
                }


                if ($tplmsg) {
                    $trade_helper   = new App_Helper_Trade($this->sid);
                    //替换订单数据
                    $tpl    = $tplmsg['awt_data'];
                    $uid = 0;
                    $page = null;
                    $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                    if($type == 'audit'){
                        if($applet == 6){//同城
                            $apply_storage = new App_Model_City_MysqlCityShopStorage($this->sid);
                            $applyInfo = $apply_storage->getRowById($tid);
                            $audit['name'] = $applyInfo['acs_name'];
                            $audit['result'] = $applyInfo['acs_status']==2?'入驻申请已通过':'入驻申请被拒绝';
                            $audit['apply_time'] = date('Y-m-d H:i', $applyInfo['acs_create_time']);
                            $audit['audit_time'] = date('Y-m-d H:i', $applyInfo['acs_handle_time']);
                            $audit['audit_note'] = $applyInfo['acs_handle_remark'];
                            $uid = $applyInfo['acs_m_id'];
                        }elseif($applet == 8){//社区
                            $apply_storage = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
                            $applyInfo = $apply_storage->getRowById($tid);
                            $audit['name'] = $applyInfo['es_name'];
                            $audit['result'] = $applyInfo['es_handle_status']==2?'入驻申请已通过':'入驻申请被拒绝';
                            $audit['apply_time'] = date('Y-m-d H:i', $applyInfo['es_createtime']);
                            $audit['audit_time'] = date('Y-m-d H:i', $applyInfo['es_handle_time']);
                            $audit['audit_note'] = $applyInfo['es_handle_remark'];
                            $uid = $applyInfo['es_m_id'];
                        }else{//招聘
                            $company_model = new App_Model_Job_MysqlJobCompanyStorage($this->sid);
                            $applyInfo = $company_model->getRowById($tid);
                            $audit['name'] = $applyInfo['ajc_company_name'];
                            $audit['result'] = $applyInfo['ajc_status']==2?'入驻申请已通过':'入驻申请被拒绝';
                            $audit['apply_time'] = date('Y-m-d H:i', $applyInfo['ajc_create_time']);
                            $audit['audit_time'] = date('Y-m-d H:i', $applyInfo['ajc_deal_time']);
                            $audit['audit_note'] = $applyInfo['ajc_deal_note'];
                            $uid = $applyInfo['ajc_m_id'];
                        }
                        list($tpl,)    = $trade_helper->replaceEnterTpl($audit, $tpl);//替换入驻模板变量
                        //todo 公众号跳转
                    }elseif($type == 'comment'){
                        if($applet == 6){//同城
                            $comment_model = new App_Model_City_MysqlCityPostCommentStorage($this->sid);
                            $comment_info = $comment_model->getRowById($tid);
                            $post_model = new App_Model_City_MysqlCityPostStorage($this->sid);
                            $post = $post_model->getRowById($comment_info['acc_acp_id']);
                            $member = $member_model->getRowById($comment_info['acc_m_id']);
                            $comment['observer'] = $member['m_nickname'];
                            $comment['content']  = $comment_info['acc_comment'];
                            $comment['time']     = date('Y-m-d H:i', $comment_info['acc_time']);
                            $uid = $comment_info['acc_reply_mid']==0?$post['acp_m_id']:$comment_info['acc_reply_mid'];
                        }else{//社区
                            $comment_model = new App_Model_Community_MysqlCommunityPostCommentStorage($this->sid);
                            $comment_info = $comment_model->getRowById($tid);
                            $post_model = new App_Model_Community_MysqlCommunityPostStorage($this->sid);
                            $post = $post_model->getRowById($comment_info['acc_acp_id']);
                            $member = $member_model->getRowById($comment_info['acc_m_id']);
                            $comment['observer'] = $member['m_nickname'];
                            $comment['content']  = $comment_info['acc_comment'];
                            $comment['time']     = date('Y-m-d H:i', $comment_info['acc_time']);
                            $uid = $comment_info['acc_reply_mid']==0?$post['acp_m_id']:$comment_info['acc_reply_mid'];
                        }
                        $page = "pages/postDetail/postDetail?id=".$comment_info['acc_acp_id'];
                        list($tpl,)    = $trade_helper->replaceCommentTpl($comment, $tpl);//替换评论模板变量
                        //todo 公众号跳转
                    }elseif($type == 'like'){
                        if($applet == 6){//同城
                            $like_model = new App_Model_City_MysqlCityPostLikeStorage($this->sid);
                            $like_info = $like_model->getRowById($tid);
                            $post_model = new App_Model_City_MysqlCityPostStorage($this->sid);
                            $post = $post_model->getRowById($like_info['apl_acp_id']);
                            $member = $member_model->getRowById($like_info['apl_m_id']);
                            $like['observer'] = $member['m_nickname'];
                            $like['time']     = date('Y-m-d H:i', $like_info['apl_time']);
                            $like['times'] = $post['acp_like_num'];
                            $uid = $post['acp_m_id'];
                        }else{//社区

                        }
                        $page = "pages/postDetail/postDetail?id=".$like_info['apl_acp_id'];
                        list($tpl,)    = $trade_helper->replaceLikeTpl($like, $tpl);//替换评论模板变量
                        //todo 公众号跳转
                    }elseif($type == self::SEND_SETUP_TRADEVERIFY){

                    }else{
                        $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->sid);
                        $applet     = $applet_model->findShopCfg();
                        if($applet['ac_type'] == 4){
                            $page = "pages/orderDetail/orderDetail?orderid=".$trade['t_tid'];
                        }
                        $member = $member_model->getRowById($trade['t_m_id']);
                        $trade['m_gold_coin'] = $member['m_gold_coin'];
                        $uid = $trade['t_m_id'];
//                        if($jump){
//                            list($tpl,$jump)  = $trade_helper->replaceTradeTpl($trade, $tpl, $jump);
//                        }else{

                            list($tpl,)    = $trade_helper->replaceTradeTpl($trade, $tpl);
//                        }
                        //todo 公众号跳转
                    }
                    //替换拼团数据
                    //list($tpl, $jump)    = $this->replaceGroupTpl($group, $tpl, $jump);

                    $openids        = $member_model->getOptionsBySidMid($this->sid, ($type == 'audit' || $type == 'comment' || $type == 'like' || $type == 'mjfh')?array($uid):array($trade['t_m_id']));
                    if (!empty($openids) && $openids[0]) {
                        $tpl = json_decode($tpl, true);
                        if($appletType == 5){
                            //公众号模板消息
                            $weixin_client  = new App_Plugin_Weixin_ClientPlugin($this->sid,5);
//                            $jump   = plum_is_url($jump) ? $jump : '';
                            $shop_model = new App_Model_Shop_MysqlShopCoreStorage($this->sid);
                            $shop = $shop_model->getRowById($this->sid);
                            //暂时先用首页做跳转
                            $jump = plum_parse_config('weixin_index','weixin')[$appletCfg['ac_type']]."?suid={$shop['s_unique_id']}&appletType=5";

                            $sendData = [];
                            foreach ($tpl as $k => $v){
                                $sendData[$k]  = array(
                                    'value' => trim($v['value'], "{}"),
                                    'color' => $v['color'],
                                );
                            }

                            $ret = $weixin_client->sendTemplateMessage($openids[0], $tplmsg['wt_tplid'], $jump, $sendData);
                        }else{
                            $weixin_client  = new App_Plugin_Weixin_WxxcxClient($this->sid);

                            //处理数据data
                            $data   = array();
                            foreach ($tpl as $val) {
                                $data[$val['key']]  = array(
                                    'value' => trim($val['contxt'], "{}"),
                                    'color' => $val['color'],
                                );
                            }
                            $formid = '';
                            if($type == 'audit' || $type == 'comment' || $type == 'like' || $trade['t_pay_type'] == App_Helper_Trade::TRADE_PAY_YEZF || $trade['t_pay_type'] == App_Helper_Trade::TRADE_PAY_HDFK || $trade['t_pay_type'] == App_Helper_Trade::TRADE_PAY_YHQM){
                                if($trade['t_pay_type'] == App_Helper_Trade::TRADE_PAY_YEZF || $trade['t_pay_type'] == App_Helper_Trade::TRADE_PAY_YHQM){
                                    $uid = $trade['t_m_id'];
                                }
                                $formids_model = new App_Model_Member_MysqlMemberFormidsStorage($this->sid);
                                $where[] = array('name' => 'af_s_id', 'oper' => '=', 'value' => $this->sid);
                                $where[] = array('name' => 'af_m_id', 'oper' => '=', 'value' => $uid);
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
                            }
                            $emphasls   = intval($tplmsg['awt_emphasis']);
                            $ret = $weixin_client->sendTemplateMessage($openids[0], $tplmsg['awt_tplid'], $formid?$formid:$trade['t_prepay_id'], $data, $page, $emphasls);
                        }


                    }
                }
            }
        }
    }

    private function _send_tpl_to_group_leader($tid){
        $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->sid);
        $setup  = $setup_model->findOneBySid();
        if (isset($setup["aws_se_notice_leader_open"]) && $setup["aws_se_notice_leader_open"]) {
            $mid    = $setup["aws_se_notice_leader_mid"];
            if ($mid) {
                $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
                $trade      = $trade_model->findUpdateTradeByTid($tid);

                //发送消息模板
                $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
                $tplmsg     = $tplmsg_model->findOneById($mid);

                if ($tplmsg) {
                    $trade_helper   = new App_Helper_Trade($this->sid);
                    //替换订单数据
                    $tpl    = $tplmsg['awt_data'];
                    $page = null;
                    list($tpl,)    = $trade_helper->replaceNoticeLeaderTpl($trade, $tpl);
                    $formids_model = new App_Model_Member_MysqlMemberFormidsStorage($this->sid);

                    $tradeExtra = json_decode($trade['t_extra_data'], true);
                    $leader_model = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->sid);
                    $leader = $leader_model->getRowById($tradeExtra['leaderId']);

                    if($leader){
                        $weixin_client  = new App_Plugin_Weixin_WxxcxClient($this->sid);
                        $where = array();
                        $where[] = array('name' => 'af_s_id', 'oper' => '=', 'value' => $this->sid);
                        $where[] = array('name' => 'af_m_id', 'oper' => '=', 'value' => $leader['asl_m_id']);
                        $formids = $formids_model->getRow($where);
                        $ids = json_decode($formids['af_ids'],true);
                        $formid = '';
                        foreach($ids as $k => $v){
                            if($v['expire']>time()){
                                $formid = $v['formId'];
                                unset($ids[$k]);
                                $udata = array('af_ids' => json_encode(array_values($ids)));
                                $formids_model->updateById($udata, $formids['af_id']);
                                break 1;
                            }
                        }
                        if($formid){
                            $tplData = json_decode($tpl, true);
                            //处理数据data
                            $sendData   = array();
                            foreach ($tplData as $value) {
                                $sendData[$value['key']]  = array(
                                    'value' => trim($value['contxt'], "{}"),
                                    'color' => $value['color'],
                                );
                            }
                            $emphasis   = intval($tplmsg['awt_emphasis']);
                            $page = "";
                            $weixin_client->sendTemplateMessage($formids['af_openid'],$tplmsg['awt_tplid'],$formid,$sendData,$page, $emphasis);
                        }
                    }
                }
            }
        }
    }


    /**
     * 通知入驻店铺到期
     */
    public function noticeShopExpire($shId, $day){
        $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
        $apply_storage = new App_Model_City_MysqlCityShopStorage($this->sid);
        $row = $apply_storage->getRowById($shId);
        $uid = $row['acs_m_id'];
        $openids = [];
        $member = $member_model->getRowById($uid);
        $appletType = 0;
        if($member){
            $openids[] = $member['m_openid'];
            $appletType = plum_parse_config('member_source_menu_type')[$member['m_source']];
        }

        //查找当前类型是否开启模板消息
        if($appletType == 5){
            $setup_model    = new App_Model_Applet_MysqlWechatTplMsgSetupStorage($this->sid);
        }else{
            $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->sid);
        }
        $setup  = $setup_model->findOneBySid();
        if (isset($setup["aws_sexpire_open"]) && $setup["aws_sexpire_open"]) {
            $mid    = $setup["aws_sexpire_mid"];
            if ($mid) {
                //发送消息模板
                if($appletType == 5){
                    $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
                    $tplmsg     = $tplmsg_model->findOneById($mid);
                    $tplmsg['awt_data'] = $tplmsg['wt_data'];
                    $jump   = $tplmsg['wt_url'];
                }else{
                    $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
                    $tplmsg     = $tplmsg_model->findOneById($mid);
                }


                if ($tplmsg) {
                    $trade_helper   = new App_Helper_Trade($this->sid);
                    //替换订单数据
                    $tpl    = $tplmsg['awt_data'];
                    $page = null;
                    $shop['name'] = $row['acs_name'];
                    $shop['time'] = date('Y-m-d', $row['acs_expire_time']);
                    $shop['day'] = $day;
                    list($tpl,)  = $trade_helper->replaceShopExpireTpl($shop, $tpl);
                    $tpl = str_replace("\n", "\\n",$tpl);

                    if (!empty($openids) && $openids[0]) {
                        $tpl = json_decode($tpl, true);
                        if($appletType == 5){
                            //公众号模板消息
                            $weixin_client  = new App_Plugin_Weixin_ClientPlugin($this->sid,5);
//                            $jump   = plum_is_url($jump) ? $jump : '';
                            $shop_model = new App_Model_Shop_MysqlShopCoreStorage($this->sid);
                            $shop = $shop_model->getRowById($this->sid);
                            //暂时先用首页做跳转
                            //这里好像只有同城
                            $jump = plum_parse_config('weixin_index','weixin')[6]."?suid={$shop['s_unique_id']}&appletType=5";

                            $sendData = [];
                            foreach ($tpl as $k => $v){
                                $sendData[$k]  = array(
                                    'value' => trim($v['value'], "{}"),
                                    'color' => $v['color'],
                                );
                            }
                            $ret = $weixin_client->sendTemplateMessage($openids[0], $tplmsg['wt_tplid'], $jump, $sendData);
                        }else{
                            $weixin_client  = new App_Plugin_Weixin_WxxcxClient($this->sid);

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
                            $where[] = array('name' => 'af_m_id', 'oper' => '=', 'value' => $uid);
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
                            $ret = $weixin_client->sendTemplateMessage($openids[0], $tplmsg['awt_tplid'], $formid, $data, $page, $emphasls);
                        }
                    }
                }
            }
        }
    }
}
