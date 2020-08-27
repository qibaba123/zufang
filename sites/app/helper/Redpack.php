<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/1/6
 * Time: 下午6:27
 */
class App_Helper_Redpack {

    const REDPACK_NORMAL    = 0;//普通类型
    const REDPACK_KEYWORD   = 1;//关键词红包
    const REDPACK_COMMAND   = 2;//口令红包
    const REDPACK_FOLLOW    = 3;//关注红包
    const REDPACK_FISSION   = 4;//裂变红包
    const REDPACK_QRCODE    = 5;//二维码红包

    const REDPACK_SEND_PLAN     = -1;//发放计划
    const REDPACK_SEND_RUN      = 0;//发放中
    const REDPACK_SEND_WAIT     = 1;//已发放,待领取
    const REDPACK_SEND_FAIL     = 2;//发放失败
    const REDPACK_SEND_RECEIVED = 3;//已领取
    const REDPACK_SEND_REFUND   = 4;//已退款

    private $sid;

    public function __construct($sid) {
        $this->sid  = intval($sid);
    }
    /*
     * 发送关键词红包
     */
    public function sendKeywordRedpack($rkid, $openid) {
        $rpkw_model = new App_Model_Redpack_MysqlKeywordStorage($this->sid);
        $rp     = $rpkw_model->findKeywordRedpack($rkid);
        
        $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_model->findUpdateMemberByWeixinOpenid($openid, $this->sid);
        if (!$member) {
            //会员不存在
            return array('errcode' => 1, 'errmsg' => '');
        }
        $wxcfg  = plum_parse_config('redpack_txt', 'weixin');
        $txt    = $wxcfg['keyword'];
        //查看是否已领取过
        $record_model   = new App_Model_Auth_MysqlRedpackRecordStorage();
        $received       = $record_model->findRedpackReceive($this->sid, $member['m_id'], $rp['rk_id'], self::REDPACK_KEYWORD);
        
        if ($received) {
            //已领取过
            $this->sendRedpackTmplmsg($rp['rk_lqsb_msgid'], $openid);
            $this->sendRedpackNewsmsg($rp['rk_lqsb_nwid'], $openid);
            return array('errcode' => -1, 'errmsg' => $rp['rk_cflq_txt'] ? $rp['rk_cflq_txt'] : $txt['cflq']);
        }
        //获取红包金额
        $money  = mt_rand(intval($rp['rk_min']*100), intval($rp['rk_max']*100));//随机红包数额,单位为分
        if ($money < 100) {
            //小于1元,无法发送
            return array('errcode' => 1, 'errmsg' => '');
        }
        //先将领取记录插入记录表
        $indata = array(
            'rr_s_id'       => $this->sid,
            'rr_m_id'       => $member['m_id'],
            'rr_nickname'   => $member['m_nickname'],
            'rr_tpl_id'     => $rp['rt_id'],
            'rr_actid'      => $rkid,
            'rr_type'       => self::REDPACK_KEYWORD,
            'rr_act_name'   => $rp['rk_keyword'],
            'rr_amount'     => $money/100,
            'rr_status'     => self::REDPACK_SEND_PLAN,
            'rr_update_time'=> time(),
        );
        $rrid   = $record_model->insertValue($indata);
        //修改已领取数加1
        $rpkw_model->incrementReceive($rkid, 1);

        $wxpay_client   = new App_Plugin_Weixin_NewPay($this->sid);
        $sdret  = $wxpay_client->sendActRedpack($openid, $money/100, $rp['rt_act_name'], $rp['rt_wishing'], $rp['rt_remark']);
        if ($sdret['code']) {
            //修改已领取数量减1
            $rpkw_model->incrementReceive($rkid, -1);
            //删除已领取记录
            $record_model->deleteById($rrid);
            //发送失败
            Libs_Log_Logger::outputLog($sdret);
            App_Helper_Tool::recordSystemError($sdret['errmsg'], $this->sid);
            App_Helper_Tool::sendShopNoticeMail($this->sid, $sdret['errmsg']);
            return array('errcode' => 1, 'errmsg' => '发放失败');
        } else {
            //发放成功,更新发放记录表
            $updata = array(
                'rr_billno'     => $sdret['send_listid'],
                'rr_out_no'     => $sdret['mch_billno'],
                'rr_send_time'  => time(),
                'rr_status'     => self::REDPACK_SEND_RUN,
                'rr_update_time'=> time(),
            );

            $record_model->updateById($updata, $rrid);
            $rdpk_redis = new App_Model_Redpack_RedisRedpackStorage($this->sid);
            $rdpk_redis->setRedpackCheck($rrid);

            //发送领取消息
            $this->sendRedpackTmplmsg($rp['rk_lqcg_msgid'], $openid);
            $this->sendRedpackNewsmsg($rp['rk_lqcg_nwid'], $openid);
            return array('errcode' => 0, 'errmsg' => $rp['rk_ffcg_txt'] ? $rp['rk_ffcg_txt'] : $txt['ffcg']);
        }
    }
    /*
     * 发放裂变红包
     */
    public function sendFissionRedpack($rfid, $openid) {
        $rpfs_model = new App_Model_Redpack_MysqlFissionStorage($this->sid);
        $rp     = $rpfs_model->findFissonRedpack($rfid);

        $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_model->findUpdateMemberByWeixinOpenid($openid, $this->sid);
        if (!$member) {
            //会员不存在
            return array('errcode' => 1, 'errmsg' => '');
        }
        $wxcfg  = plum_parse_config('redpack_txt', 'weixin');
        $txt    = $wxcfg['fission'];
        //查看是否已领取过
        $record_model   = new App_Model_Auth_MysqlRedpackRecordStorage();
        $received       = $record_model->findRedpackReceive($this->sid, $member['m_id'], $rp['rf_id'], self::REDPACK_FISSION);

        if ($received) {
            //已领取过
            $this->sendRedpackTmplmsg($rp['rk_lqsb_msgid'], $openid);
            $this->sendRedpackNewsmsg($rp['rk_lqsb_nwid'], $openid);
            return array('errcode' => -1, 'errmsg' => $rp['rf_cflq_txt'] ? $rp['rf_cflq_txt'] : $txt['cflq']);
        }
        //获取红包金额
        $money  = intval($rp['rf_amount']*100);//每组总金额,单位为分
        if ($money < intval($rp['rf_count']*100)) {
            //小于1元,无法发送
            return array('errcode' => 1, 'errmsg' => '');
        }
        $indata = array(
            'rr_s_id'       => $this->sid,
            'rr_m_id'       => $member['m_id'],
            'rr_nickname'   => $member['m_nickname'],
            'rr_tpl_id'     => $rp['rt_id'],
            'rr_actid'      => $rfid,
            'rr_type'       => self::REDPACK_FISSION,
            'rr_act_name'   => $rp['rf_keyword'],
            'rr_amount'     => $money/100,
            'rr_status'     => self::REDPACK_SEND_PLAN,
            'rr_update_time'=> time(),
        );
        $rrid   = $record_model->insertValue($indata);
        //修改已领取数加1
        $rpfs_model->incrementReceive($rfid, 1);

        $wxpay_client   = new App_Plugin_Weixin_NewPay($this->sid);
        $sdret  = $wxpay_client->sendGroupRedpack($openid, $money/100, $rp['rf_count'], $rp['rt_act_name'], $rp['rt_wishing'], $rp['rt_remark']);
        if ($sdret['code']) {
            //修改已领取数量减1
            $rpfs_model->incrementReceive($rfid, -1);
            //删除已领取记录
            $record_model->deleteById($rrid);
            //发送失败
            Libs_Log_Logger::outputLog($sdret);
            return array('errcode' => 1, 'errmsg' => '发送失败');
        }
        //发放成功,更新发放记录表
        $updata = array(
            'rr_billno'     => $sdret['send_listid'],
            'rr_out_no'     => $sdret['mch_billno'],
            'rr_send_time'  => time(),
            'rr_status'     => self::REDPACK_SEND_RUN,
            'rr_update_time'=> time(),
        );

        $record_model->updateById($updata, $rrid);
        $rdpk_redis = new App_Model_Redpack_RedisRedpackStorage($this->sid);
        $rdpk_redis->setRedpackCheck($rrid);

        //发送领取消息
        $this->sendRedpackTmplmsg($rp['rf_lqcg_msgid'], $openid);
        $this->sendRedpackNewsmsg($rp['rf_lqcg_nwid'], $openid);
        return array('errcode' => 0, 'errmsg' => $rp['rf_ffcg_txt'] ? $rp['rf_ffcg_txt'] : $txt['ffcg']);
    }
    /*
     * 发送微信模板消息
     * @param int $msgid 模板消息ID
     * @param string $openid 会员openID
     */
    public function sendRedpackTmplmsg($msgid, $openid) {
        $msgid  = intval($msgid);
        if ($msgid) {
            $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($msgid);
            //模板消息存在
            if ($tplmsg) {
                $tpl    = $tplmsg['wt_data'];
                $jump   = $tplmsg['wt_url'];

                $weixin_client  = new App_Plugin_Weixin_ClientPlugin($this->sid);
                $tpl = json_decode($tpl, true);
                $jump   = plum_is_url($jump) ? $jump : '';
                $ret = $weixin_client->sendTemplateMessage($openid, $tplmsg['wt_tplid'], $jump, $tpl);
            }
        }
    }
    /*
     * 发送微信客服图文消息
     */
    public function sendRedpackNewsmsg($nwid, $openid,$command = '',$suid = '') {
        $nwid   = intval($nwid);
        if ($nwid) {
            $news_model = new App_Model_Auth_MysqlWeixinNewsStorage();
            $news   = $news_model->findNewsById($nwid);

            if ($news) {
                $domain = plum_parse_config('shield_domain', 'weixin');
                for ($i = 0; $i < 8; $i++) {

                    if ($i == 0) {
                        if($command && $suid){
                            $url = $news['wn_url'].'?command='.$command.'&suid='.$suid.'&snsapi=base';
                        }else{
                            $url = $news['wn_url'];
                        }

                        $article[]  = array(
                            'title'         => $news['wn_title'],
                            'description'   => $news['wn_brief'],
                            'url'           => $url,
                            'picurl'        => "http://{$domain}".$news['wn_pic'],
                        );
                    } else {
                        if ($news["wn_title_{$i}"]) {
                            if($command && $suid){
                                $url = $news["wn_url_{$i}"].'?command='.$command.'&suid='.$suid.'&snsapi=base';
                            }else{
                                $url = $news["wn_url_{$i}"];
                            }
                            $article[]  = array(
                                'title'         => $news["wn_title_{$i}"],
                                'description'   => '',
                                'url'           => $url,
                                'picurl'        => "http://{$domain}".$news["wn_pic_{$i}"],
                            );
                        } else {
                            break;
                        }
                    }
                }

                $weixin_client  = new App_Plugin_Weixin_ClientPlugin($this->sid);

                $weixin_client->sendLinkNewsMessage($openid, $article);
            }
        }
    }

    /*
     * 检查红包发送结果
     */
    public function checkRedpackSend($rrid) {
        $record_model   = new App_Model_Auth_MysqlRedpackRecordStorage();

        $record     = $record_model->getRowById($rrid);
        if ($record) {
            $wxpay_client   = new App_Plugin_Weixin_NewPay($this->sid);
            $sendret    = $wxpay_client->getActRedpack($record['rr_out_no']);

            if ($sendret['code']) {
                //获取失败
            } else {
                $updata = array(
                    'rr_status'     => $sendret['send_status'],
                    'rr_reason'     => $sendret['reason'],
                    'rr_update_time'=> time(),
                );
                $record_model->updateById($updata, $rrid);
            }
        }
    }
    /*
     * 关注发送红包检查
     */
    public function followRedpackCheck(array $member) {
        $fwrp_model = new App_Model_Redpack_MysqlFollowStorage($this->sid);
        
        $rp   = $fwrp_model->fetchCurrRunRedpack();
        //关注红包存在,且未发放完
        if ($rp) {
            $wxcfg  = plum_parse_config('redpack_txt', 'weixin');
            $txt    = $wxcfg['follow'];
            if(($rp['rf_total'] <= $rp['rf_had'])) {
                //红包被领取完
                $this->sendRedpackTmplmsg($rp['rf_lqsb_msgid'], $member['m_openid']);
                $this->sendRedpackNewsmsg($rp['rf_lqsb_nwid'], $member['m_openid']);
                return array('errcode' => -1, 'errmsg' => $rp['rc_blw_txt'] ? $rp['rc_blw_txt'] : $txt['blw']);
            }

            //获取红包金额
            if ($rp['rf_type'] == 1) {//固定金额
                $money  = intval($rp['rf_val']*100);//单位为分
            } else {//随机发放
                $money  = mt_rand(intval($rp['rf_min']*100), intval($rp['rf_max']*100));//随机红包数额,单位为分
            }
            if ($money < 100) {
                //小于1元,无法发送
                return array('errcode' => 1, 'errmsg' => '');
            }
            //修改已领取数加1
            $fwrp_model->incrementReceive($rp['rf_id'], 1);
            $wxpay_client   = new App_Plugin_Weixin_NewPay($this->sid);
            $sdret  = $wxpay_client->sendActRedpack($member['m_openid'], $money/100, $rp['rt_act_name'], $rp['rt_wishing'], $rp['rt_remark']);
            if ($sdret['code']) {
                //修改已领取数减1
                $fwrp_model->incrementReceive($rp['rf_id'], -1);
                //发送失败
                Libs_Log_Logger::outputLog($sdret);
                return array('errcode' => 1, 'errmsg' => '');
            }
            $record_model   = new App_Model_Auth_MysqlRedpackRecordStorage();
            $indata = array(
                'rr_s_id'       => $this->sid,
                'rr_m_id'       => $member['m_id'],
                'rr_nickname'   => $member['m_nickname'],
                'rr_tpl_id'     => $rp['rt_id'],
                'rr_actid'      => $rp['rf_id'],
                'rr_type'       => self::REDPACK_FOLLOW,
                'rr_act_name'   => $rp['rf_name'],
                'rr_amount'     => $money/100,
                'rr_billno'     => $sdret['send_listid'],
                'rr_out_no'     => $sdret['mch_billno'],
                'rr_send_time'  => time(),
                'rr_status'     => self::REDPACK_SEND_RUN,
                'rr_update_time'=> time(),
            );
            $rrid   = $record_model->insertValue($indata);
            //设置一小时后检查红包发放领取状态
            $rdpk_redis = new App_Model_Redpack_RedisRedpackStorage($this->sid);
            $rdpk_redis->setRedpackCheck($rrid);
            //发送领取消息
            $this->sendRedpackTmplmsg($rp['rf_lqcg_msgid'], $member['m_openid']);
            $this->sendRedpackNewsmsg($rp['rf_lqcg_nwid'], $member['m_openid']);
            return array('errcode' => 0, 'errmsg' => $rp['rc_ffcg_txt'] ? $rp['rc_ffcg_txt'] : $txt['ffcg']);
        }
        return array('errcode' => 1, 'errmsg' => '');
    }

    /*
     * 二维码红包生成
     */
    public function systemQrcodeRedpack($rqid) {
        $rq_model = new App_Model_Redpack_MysqlQrcodeStorage($this->sid);
        $rq = $rq_model->getRowById($rqid);

        if($rq){
            $amount = floatval($rq['rq_amount'])*100;//单位分
            $total  = intval($rq['rq_total']);

            //发放总数大于1000,提示失败
//            if ($total > 1000) {
//                return;
//            }

            $rules = json_decode($rq['rq_rules'],1);
            $rql_model = new App_Model_Redpack_MysqlQrcodeListStorage($this->sid);
            $insert = array();
            $data = array();
            if(!empty($rules)){
                foreach ($rules as $key => $val){
                    for($i = 0 ; $i < $val['num'] ; $i ++){
                        $code = plum_random_num_letter(5,3);
                        //生成二维码
//                        $filename = PLUM_APP_BUILD.'/'.$code.'.png';
//                        $savename = '/public/build/'.$code.'.png';
//                        $link     = App_Helper_Tool::outputMobileLink($this->sid,'Redpack','index',array('command'=>$code),true,'base');
//                        Libs_Qrcode_QRCode::png($link,$filename,0,3,1);
                        $savename = '';
                        if($total <= 500){
                            $insert[] = " (NULL, '{$this->sid}', '{$rqid}', '{$code}', '{$savename}', '{$val['money']}','0','0','0') ";
                        }
                        else{
                            $data = array(
                                'rql_s_id' => $this->sid,
                                'rql_actid' => $rqid,
                                'rql_command' => $code,
                                'rql_qrcode'  => $savename,
                                'rql_money'   => $val['money'],
                            );
                            $rql_model->insertValue($data);
                        }
                    }
                }
                if(!empty($insert)){
                    $rql_model->batchData($insert);
                }
            }
        }
    }

    /*
     * 删除二维码红包记录及对应文件
     */
    public function deleteQrcodeRecordFile($rqid,$count){
        $list_model = new App_Model_Redpack_MysqlQrcodeListStorage($this->sid);
        if($count <= 1000){
            $list = $list_model->getListByRqid($rqid);
            foreach ($list as $val){
                $path = PLUM_DIR_ROOT.$val['rql_qrcode'];
                if(file_exists($path)){
                    $res = unlink($path);
                }
                if($res){
                    $list_model->deleteById($val['rql_id']);
                }
            }
        }else{
            $num = ceil($count/1000);
            for($i = 0; $i < $num ; $i++){
                //每次删除1000条
                $index = $i * 1000;
                $list = $list_model->getListByRqid($rqid,$index,1000);
                foreach ($list as $val){
                    $path = PLUM_DIR_ROOT.$val['rql_qrcode'];
                    if(file_exists($path)){
                        $res = unlink($path);
                    }
                    if($res){
                        $list_model->deleteById($val['rql_id']);
                    }
                }
            }
        }
    }

    /*
     * 口令红包系统生成
     */
    public function systemCommandRedpack($rcid) {
        $cdrp_model = new App_Model_Redpack_MysqlCommandStorage($this->sid);
        $cdrp   = $cdrp_model->getRowUpdate($rcid);

        if ($cdrp) {
            $amount = floatval($cdrp['rc_amount'])*100;//单位分
            $total  = intval($cdrp['rc_total']);
            $digit  = intval($cdrp['rc_digit']);

            //发放总数大于1000,提示失败
            if ($total > 1000) {
                return;
            }
            if ($total*100 > $amount) {
                //低于一元
                $amount = $total*100;
            }

            if ($digit < 6) {
                //小于六位
                $digit  = 6;
            }

            $group  = $this->_random_group($total, $digit);

            if ($cdrp['rc_type'] == 1) {//固定金额
                //总金额除以总数量
                $money  = floor($amount/$total);//下取整,单位分
                $list   = array_fill(0, $total, $money);
            } else {//随机金额
                //避免出现低于1元的
                $all    = $amount-$total*100;
                if ($all == 0) {
                    $money  = 100;//刚好够均分
                    $list   = array_fill(0, $total, $money);
                } else {
                    $rp_rand    = new App_Helper_RedpackRandom($all, $total);
                    $money_rand = $rp_rand->compute();
                    $list   = array();
                    for ($i=0; $i<$total; $i++) {
                        $list[$i]   = floor($money_rand[$i])+100;
                    }
                }
            }
            $list_model = new App_Model_Redpack_MysqlListStorage($this->sid);
            for ($i=0; $i<$total; $i++) {
                $indata = array(
                    'rl_s_id'       => $this->sid,
                    'rl_actid'      => $rcid,
                    'rl_command'    => $group[$i],
                    'rl_money'      => $list[$i]/100,
                );
                $list_model->insertValue($indata);
            }
        }
    }
    /*
     * 生成随机数字组合
     * @param int $sum 组合数量
     * @param int $digit 位数
     */
    public function _random_group($sum, $digit) {
        $group  = array();

        $min    = 1;
        $max    = 10;
        for ($i=1; $i<$digit; $i++) {
            $min = $min*10;
            $max = $max*10;
        }
        $max--;
        do {
            $rand   = mt_rand($min, $max);
            array_push($group, $rand);
            $group  = array_unique($group);
        } while (count($group) < $sum);

        return $group;
    }
    /*
     * 发送口令红包
     */
    public function sendCommandRedpack($command, $openid) {
        $list_model = new App_Model_Redpack_MysqlListStorage($this->sid);
        $rp     = $list_model->findRedpackByCommand($command);
        if (!$rp) {
            //非红包口令,不做回复
            return array('errcode' => 1, 'errmsg' => '');
        }
        $wxcfg  = plum_parse_config('redpack_txt', 'weixin');
        $txt    = $wxcfg['command'];
        if ($rp['rl_received']) {
            $this->sendRedpackTmplmsg($rp['rc_lqsb_msgid'], $openid);
            $this->sendRedpackNewsmsg($rp['rc_lqsb_nwid'], $openid);
            return array('errcode' => -1, 'errmsg' => $rp['rc_ysy_txt'] ? $rp['rc_ysy_txt'] : $txt['ysy']);
        }

        if ($rp['rc_start_time'] > time()) {
            return array('errcode' => -2, 'errmsg' => $rp['rc_wks_txt'] ? $rp['rc_wks_txt'] : $txt['wks']);
        }

        if ($rp['rc_end_time'] < time()) {
            $this->sendRedpackTmplmsg($rp['rc_lqsb_msgid'], $openid);
            $this->sendRedpackNewsmsg($rp['rc_lqsb_nwid'], $openid);
            return array('errcode' => -2, 'errmsg' => $rp['rc_yjs_txt'] ? $rp['rc_yjs_txt'] : $txt['yjs']);
        }
        $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_model->findUpdateMemberByWeixinOpenid($openid, $this->sid);
        $count  = $list_model->countMemberReceived($member['m_id'], $rp['rc_id']);

        if ($count >= $rp['rc_received_max']) {
            $this->sendRedpackTmplmsg($rp['rc_lqsb_msgid'], $openid);
            $this->sendRedpackNewsmsg($rp['rc_lqsb_nwid'], $openid);
            return array('errcode' => -2, 'errmsg' => $rp['rc_lqcx_txt'] ? $rp['rc_lqcx_txt'] : $txt['lqcx']);
        }
        //先修改红包领取状态,假定红包已被领取,避免网络延迟导致红包被多次领取
        $updata = array(
            'rl_received'   => 1,
            'rl_m_id'       => $member['m_id'],
            'rl_receive_time'   => time(),
        );
        $list_model->updateById($updata, $rp['rl_id']);
        //可正常领取,口令可用
        $wxpay_client   = new App_Plugin_Weixin_NewPay($this->sid);
        $sdret  = $wxpay_client->sendActRedpack($openid, $rp['rl_money'], $rp['rt_act_name'], $rp['rt_wishing'], $rp['rt_remark']);
        if ($sdret['code']) {
            //清除口令领取状态
            $updata = array(
                'rl_received'   => 0,
                'rl_m_id'       => 0,
                'rl_receive_time'   => 0,
            );
            $list_model->updateById($updata, $rp['rl_id']);
            //发送失败
            Libs_Log_Logger::outputLog($sdret);
            return array('errcode' => 1, 'errmsg' => '');
        }

        $record_model   = new App_Model_Auth_MysqlRedpackRecordStorage();
        $indata = array(
            'rr_s_id'       => $this->sid,
            'rr_m_id'       => $member['m_id'],
            'rr_nickname'   => $member['m_nickname'],
            'rr_tpl_id'     => $rp['rt_id'],
            'rr_actid'      => $rp['rc_id'],
            'rr_type'       => self::REDPACK_COMMAND,
            'rr_act_name'   => $rp['rc_name'],
            'rr_amount'     => $rp['rl_money'],
            'rr_billno'     => $sdret['send_listid'],
            'rr_out_no'     => $sdret['mch_billno'],
            'rr_send_time'  => time(),
            'rr_status'     => self::REDPACK_SEND_RUN,
            'rr_update_time'=> time(),
        );
        $rrid   = $record_model->insertValue($indata);

        //设置一小时后检查红包发放领取状态
        $rdpk_redis = new App_Model_Redpack_RedisRedpackStorage($this->sid);
        $rdpk_redis->setRedpackCheck($rrid);
        //修改已领取数加1
        $cdrp_model = new App_Model_Redpack_MysqlCommandStorage($this->sid);
        $cdrp_model->incrementReceive($rp['rc_id'], 1);
        //发送领取消息
        $this->sendRedpackTmplmsg($rp['rc_lqcg_msgid'], $member['m_openid']);
        $this->sendRedpackNewsmsg($rp['rc_lqcg_nwid'], $member['m_openid']);
        return array('errcode' => 0, 'errmsg' => $rp['rc_ffcg_txt'] ? $rp['rc_ffcg_txt'] : $txt['ffcg']);
    }


    /*
     * 验证并发送二维码红包图文消息
     */
    public function verifyQrcodeRedpack($command, $openid , $suid){

        $list_model = new App_Model_Redpack_MysqlQrcodeListStorage($this->sid);
        $rql = $list_model->findRedpackByCommand($command);
        if (!$rql) {
            //非二维码口令,不做回复
            return array('errcode' => 1, 'errmsg' => '');
        }else{
            $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
            $member     = $member_model->findUpdateMemberByWeixinOpenid($openid, $this->sid);
            $this->sendRedpackNewsmsg($rql['rq_lqcg_nwid'], $member['m_openid'],$command,$suid);
        }
    }
}