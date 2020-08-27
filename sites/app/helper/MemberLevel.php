<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/3
 * Time: 下午2:40
 */

class App_Helper_MemberLevel {

    const DEDUCT_INOUT_INCOME    = 1;//收入
    const DEDUCT_INOUT_OUTPUT    = 2;//支出

    private $mid;
    private $sid;
    private $member;

    public function __construct($mid = null){
        if ($mid) {
            $this->mid  = $mid;
            $mem_model  = new App_Model_Member_MysqlMemberCoreStorage();
            $this->member   = $mem_model->getRowById($mid);
            $this->sid      = $this->member['m_s_id'];
        }
    }

    /**
     * 递归地设置会员层级关系，并发送消息，并返回当前会员
     * @param int $sid
     * @param int $mid
     * @param int $fid
     * @return bool|array
     */
    public static function setLevelSendMessage($sid, $mid, $fid) {
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_storage->getRowById($mid);
       Libs_Log_Logger::outputLog('111','level.log');
        //存在层级关系,不可再设置
        if ($member['m_1f_id']) {
            return false;
        }
		 Libs_Log_Logger::outputLog('222','level.log');
        //微分销层级
        $three_level    = App_Helper_ShopWeixin::checkShopThreeLevel($sid);
        if (!$three_level) {
            return false;
        }
         Libs_Log_Logger::outputLog('333','level.log');
        $level = $member_storage->setLevelRecurse($mid, $fid, $sid);

        $user_id    = $member['m_show_id'];
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $shop       = $shop_model->getRowById($sid);
        //为会员生成邀请码
        $code   = plum_random_code();
        //为会员生成推广二维码及邀请码
        //$shop_weixin= new App_Helper_ShopWeixin($sid);
        //$shop_weixin->createSpreadQrcode($mid, $code);

        $message_cfg    = plum_parse_config('message', 'message');
        $message_model  = new App_Model_System_MysqlMessageStorage($sid);

        //向上级，上上级，上上上级分别发送消息
        $higher = array(0 => $member['m_nickname']);
       Libs_Log_Logger::outputLog('4444','level.log');
        if ($level) {
            $client_plugin  = new App_Plugin_Weixin_ClientPlugin($sid);
            for ($i=1; $i<=$three_level; $i++) {
                $tmp    = "{$i}f";
                //是否触发下级总数等级
                App_Helper_MemberLevel::memberLevelUpgrade($level["m_{$tmp}_id"], $sid);
                if ($level["m_{$tmp}_id"]) {
                    $f_member   = $member_storage->getRowById($level["m_{$tmp}_id"]);

                    $higher[$i] = $f_member['m_nickname'];
                    $kind2  = $i+1;
                    switch ($i) {
                        case 1 :
                            $msg    = array($user_id, $higher[0], $higher[1], $shop['s_name']);
                            $mtpl   = $message_model->fetchUpdateByKindId(1, $kind2);
                            $tpl    = $mtpl ? $mtpl['sm_content'] : $message_cfg[1][$kind2]['default'];
                            $reg    = $message_cfg[1][$kind2]['usable'];
                            break;
                        case 2 :
                            $msg    = array($user_id, $higher[0], $higher[1], $higher[2], $shop['s_name']);
                            $mtpl   = $message_model->fetchUpdateByKindId(1, $kind2);
                            $tpl    = $mtpl ? $mtpl['sm_content'] : $message_cfg[1][$kind2]['default'];
                            $reg    = $message_cfg[1][$kind2]['usable'];
                            break;
                        case 3 :
                            $msg    = array($user_id, $higher[0], $higher[1], $higher[2], $higher[3], $shop['s_name']);
                            $mtpl   = $message_model->fetchUpdateByKindId(1, $kind2);
                            $tpl    = $mtpl ? $mtpl['sm_content'] : $message_cfg[1][$kind2]['default'];
                            $reg    = $message_cfg[1][$kind2]['usable'];
                            break;
                    }
                    $content    = self::messageContentReplace($reg, $msg, $tpl);
                    $client_plugin->sendTextMessage($f_member['m_openid'], $content);
                   Libs_Log_Logger::outputLog('5555','level.log');
                } else {
                    break;
                }
            }
            //开启上级审核，将会员分销状态修改为待审核
            $three_cfg  = new App_Model_Three_MysqlCfgStorage($sid);
            $tcRow         = $three_cfg->findShopCfg();
            if($tcRow['tc_f_audit']){
                $extra_model = new App_Model_Member_MysqlMemberExtraStorage($sid);
                $extra = $extra_model->findUpdateExtraByMid($mid);
                if($extra){
                    $set = array('ame_distrib_faudit' => 1);
                    $extra_model->findUpdateExtraByMid($mid, $set);
                }else{
                    $extraUpdata['ame_s_id'] = $sid;
                    $extraUpdata['ame_m_id'] = $mid;
                    $extraUpdata['ame_distrib_faudit'] = 1;
                    $extra_model->insertValue($extraUpdata);
                }
            }
            //向会员发送消息
            $msg    = array($user_id, $higher[0], $higher[1], $shop['s_name']);
            $mtpl   = $message_model->fetchUpdateByKindId(1, 1);
            $tpl    = $mtpl ? $mtpl['sm_content'] : $message_cfg[1][1]['default'];
            $reg    = $message_cfg[1][1]['usable'];
            $content    = self::messageContentReplace($reg, $msg, $tpl);
            $client_plugin->sendTextMessage($member['m_openid'], $content);
        }
        return $member;
    }
    /*
     * 消息模板的搜索,替换
     */
    public static function messageContentReplace($reg, $msg, $tpl) {
        if (empty($reg) || empty($msg)) {
            return $tpl;
        }
        /*
        if (count($reg) != count($msg)) {
            return $tpl;
        }
        */
        foreach ($reg as &$item) {
            $item   = "/{$item}/";
        }

        return preg_replace($reg, $msg, $tpl);
    }

    /*
     * 会员信息修复，主要用于有赞会员id获取不到的情况
     */
    public static function restoreMemberInfo($user, $sid) {
        $member_storage     = new App_Model_Member_MysqlMemberCoreStorage();

        $open_id    = $user['weixin_openid'];
        $updata     = array(
            'm_user_id'     => $user['user_id'],
            'm_nickname'    => $user['nick'],
            'm_avatar'      => $user['avatar'],
            'm_union_id'    => $user['union_id'],
            'm_is_follow'   => $user['is_follow'] ? 1 : 0
        );
        $member_storage->findUpdateMemberByWeixinOpenid($open_id, $sid, $updata);

        return $member_storage->findUpdateMemberByWeixinOpenid($open_id, $sid);
    }

    /*
     * 获取会员所属的店铺信息
     */
    public static function fetchShopByMid($mid) {
        $member_storage     = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_storage->getRowById($mid);

        $shop_storage   = new App_Model_Shop_MysqlShopCoreStorage();
        $shop       = $shop_storage->getRowById($member['m_s_id']);

        return $shop;
    }

    /*
     * 实时检查会员
     */
    public static function isRealMember($sid, $mid) {
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_storage->getRowById($mid);
        //会员获取失败或店铺信息不对称，返回false
        if (!$member || $member['m_s_id'] != $sid ) {
            return false;
        }
        //最高级会员直接返回true
        if ($member['m_is_highest']) {
            return true;
        }
        //会员等级判断
        /*$level  = intval($member['m_level']);
        if ($level) {
            $level_model    = new App_Model_Member_MysqlLevelStorage();
            $exist  = $level_model->getRowByIdSid($level, $sid);
            if ($exist) {
                return true;
            }
        }*/
        //获取会员配置
        $center_storage = new App_Model_Member_MysqlMemberCenterStorage();
        $cfg        = $center_storage->findUpdateBySid($sid);
        $min_num    = $cfg ? intval($cfg['cc_min_num']) : 1;//最低购买数量
        $min_amount = $cfg ? floatval($cfg['cc_min_amount']) : 0;//最低消费额
        //无最低消费额、最低购买量
        if ($min_amount <= 0 && $min_num == 0) {
            return true;
        }
        $traded_num     = intval($member['m_traded_num']);
        $traded_amount  = floatval($member['m_traded_money']);
        /*
        if ($traded_num == 0 && $traded_amount == 0) {
            $shop_storage   = new App_Model_Shop_MysqlShopCoreStorage();
            $shop   = $shop_storage->getRowById($sid);
            //有赞类型店铺时，对未购买会员查找一次有赞接口，避免订单同步时间导致不能及时生成二维码
            $shop_type  = plum_parse_config('shop_type');
            if ($shop['s_type'] == $shop_type['youzan']) {
                $youzan_client  = new App_Plugin_Youzan_OauthClient($sid);

                $user   = $youzan_client->fetchWeixinFollower($member['m_openid']);
                //获取会员失败或未消费
                if (!$user || !$user['traded_num'] || !$user['traded_money']) {
                    return false;
                } else {
                    $traded_num     = intval($user['traded_num']);
                    $traded_amount  = floatval($user['traded_money']);
                }
            }
        }
        */
        $flag   = false;
        //如果设置了最低消费额，依次为判断标准
        if ($min_amount > 0) {
            $flag = $traded_amount < $min_amount ? false : true;
        }

        if (!$flag && $min_num > 0) {
            $flag   = $traded_num < $min_num ? false : true;
        }
        return $flag;
    }
    /*
     * 检查是否要求必须设置上级
     */
    public static function hasSetupHigher($sid, $mid) {
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_storage->getRowById($mid);
        //会员获取失败或店铺信息不对称，返回false
        if (!$member || $member['m_s_id'] != $sid ) {
            return false;
        }
        //最高级会员直接返回true
        if ($member['m_is_highest']) {
            return true;
        }
        //已设置上级
        if ($member['m_1f_id']) {
            return true;
        }
        //获取会员配置
        $center_storage = new App_Model_Member_MysqlMemberCenterStorage();
        $cfg        = $center_storage->findUpdateBySid($sid);
        $must   = intval($cfg['cc_must_set']);

        return $must == 0 ? true : false;
    }

    /**
     * 获取用户等级名称及生成永久二维码权限
     * @param int $sid
     * @param int $mid
     * @return array|bool
     */
    public static function fetchMemberLevel($sid, $mid) {
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_storage->getRowById($mid);
        //会员获取失败或店铺信息不对称，返回false
        if (!$member || $member['m_s_id'] != $sid ) {
            return false;
        }
        $default    = array(
            'level'     => '商城会员',//级别名称
            'forever'   => false,//是否生成永久二维码
        );
        if (!$member['m_level']) {
            return $default;
        }
        //获取会员等级配置列表
        $level_storage  = new App_Model_Member_MysqlLevelStorage();
        $level  = $level_storage->getListBySid($sid);

        if (isset($level[$member['m_level']])) {
            $default    = array(
                'level'     => $level[$member['m_level']]['ml_name'],
                'forever'   => (boolean)$level[$member['m_level']]['ml_is_forever'],
            );
        }
        return $default;
    }

    /**
     * 会员金币转换
     * @param int $sid
     * @param int $mid
     * @param int $price 正数或负数，增加或减少
     * @return bool
     */
    public static function goldCoinTrans($sid, $mid, $price) {
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_storage->getRowById($mid);
        //会员获取失败或店铺信息不对称，返回false
        if (!$member || $member['m_s_id'] != $sid ) {
            return false;
        }
        return $member_storage->incrementMemberGoldcoin($mid, $price);
    }
    /*
     * 会员积分转换
     */
    public static function pointTrans($sid, $mid, $point) {
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_storage->getRowById($mid);
        //会员获取失败或店铺信息不对称，返回false
        if (!$member || $member['m_s_id'] != $sid ) {
            return false;
        }

        return $member_storage->incrementMemberPoint($mid, $point);
    }
    /*
     * 会员佣金转换
     */
    public static function deductTrans($mid, $deduct) {
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        return $member_storage->incrementMemberDeduct($mid, $deduct);
    }
    /*
     * 检查会员是否拥有VIP特权
     */
    public static function checkVipMember($sid, $mid) {
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_storage->getRowById($mid);
        //会员获取失败或店铺信息不对称，返回false
        if (!$member || $member['m_s_id'] != $sid ) {
            return false;
        }

        $level_storage  = new App_Model_Member_MysqlLevelStorage();
        $level      = $level_storage->getRowById($member['m_level']);

        if ($level && $level['ml_is_vip']) {
            return true;
        }
        return false;
    }

    /*
 * 检查会员是否拥有VIP特权
 */
    public static function newCheckVipMember($sid, $mid) {
        $offline_member = new App_Model_Store_MysqlMemberStorage($sid);
        $where[]    = array('name' => 'om_s_id', 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'om_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'om_expire_time', 'oper' => '>', 'value' => time());
        $member_card    = $offline_member->getList($where, 0, 0, array('om_update_time' => 'desc'));
        $level = 0;

        if($member_card){//先查找是否买了会员卡
            $cardid = $member_card[0]['om_card_id'];
            $card_model = new App_Model_Store_MysqlCardStorage($sid);
            $card   = $card_model->getRowById($cardid);
            $identity = intval($card['oc_identity']);
            $level_model = new App_Model_Member_MysqlLevelStorage();
            $level = $level_model->getRowById($identity);
        }

        if(!$level){//取会员的等级
            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
            $member     = $member_storage->findMemberByIdSid($mid, $sid);
            $identity = $member['m_level'];
            $level_model = new App_Model_Member_MysqlLevelStorage();
            $level = $level_model->getRowById($identity);
        }
        return $level;
    }

    /*
     * 设置会员的VIP特权,及会员到期时间
     */
    public static function setMemberVip($mid, $level) {
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_storage->getRowById($mid);

        if (!$member) {
            return false;
        }

        $sid    = intval($member['m_s_id']);
        $vipcfg_model    = new App_Model_Member_MysqlVipCfgStorage($sid);
        $vipcfg = $vipcfg_model->findUpdateOrderBySid();
        $long   = $vipcfg ? intval($vipcfg['vc_day_long']) : 0;

        //设置到期时间
        $expire_time    = $member['m_level_long'] > time() ? $member['m_level_long'] : time();

        $add    = $long*24*60*60;
        $expire_time    += $add;
        $level  = intval($level);
        //设置用户会员卡号
        $updata = array(
            'm_level'       => $level,
            'm_level_long'  => $expire_time,
        );

        $member_storage->updateById($updata, $mid);
        return true;
    }

    /*
     * 社区小程序设置会员的VIP特权,及会员到期时间
     */
    public static function setCommunityMemberVip($mid, $cid) {
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_storage->getRowById($mid);

        if (!$member) {
            return false;
        }

        $sid    = intval($member['m_s_id']);
        $card_model = new App_Model_Community_MysqlCommunityCardStorage($sid);
        $card = $card_model->getRowById($cid);
        //设置到期时间
        $expire_time    =$member['m_level_long'] > time() ? $member['m_level_long'] : time();

        $add    = $card['acc_long']*24*60*60;
        $expire_time += $add;
        $level  = intval($card['acc_id']);
        //设置用户会员卡号
        $updata = array(
            'm_level'       => $level,
            'm_level_long'  => $expire_time,
            'm_level_number'  => $member['m_level_number']?$member['m_level_number']:App_Helper_Tool::exportCardNum()
        );
        $member_storage->updateById($updata, $mid);
        return true;
    }

    /*
     * 设置门店会员卡信息
     */
    public static function setMemberCard($mid, $cardid, $sid, $esId=0,$tid = '',$remark = '') {
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_storage->findMemberByIdSid($mid, $sid);

        if (!$member && !$esId) {
            return false;
        }


        

        /*if(intval($card['oc_identity'])){
            if($member['m_level'] > 0){
                $level_model = new App_Model_Member_MysqlLevelStorage();
                $curr_level = $level_model->getRowById($member['m_level']);
                $level = $level_model->getRowById(intval($card['oc_identity']));
                if($level['ml_discount'] < $curr_level['ml_discount']){
                    $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                    $updata = array(
                        'm_level'   => intval($card['oc_identity'])
                    );
                    $member_model->updateById($updata, $member['m_id']);
                }
            }else{
                $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                $updata = array(
                    'm_level'   => intval($card['oc_identity'])
                );
                $member_model->updateById($updata, $member['m_id']);
            }
        }*/

        // 充值记录
        $card_model = new App_Model_Store_MysqlCardStorage($sid);
        $card   = $card_model->getRowById($cardid);
        if($card['oc_return_price'] > 0){            
            // if($coin_res){
            $record_model = new App_Model_Member_MysqlRechargeStorage($sid);
            $coin_record = [
                'rr_tid'        => $tid,
                'rr_s_id'       => $sid,
                'rr_m_id'       => $member['m_id'],
                'rr_amount'     => 0,
                'rr_gold_coin'  => $card['oc_return_price'],
                'rr_status'     => 1,//标识金币增加
                'rr_pay_type'   => 13,//会员卡赠送
                'rr_remark'     => '购买会员卡赠送',
                'rr_create_time'=> time(),
            ];
            $a=$record_model->insertValue($coin_record);
            $coin_res = App_Helper_MemberLevel::goldCoinTrans($sid, $member['m_id'], $card['oc_return_price']);
            // }
        }

        // 线下门店会员
        $add    = intval($card['oc_long'])*24*60*60;
        $offline_member = new App_Model_Store_MysqlMemberStorage($sid);
        if(!$mid && $esId){
            $member_card    = $offline_member->findUpdateMemberByEsId($esId, [], $card['oc_type']);
        }else{
            $member_card    = $offline_member->findUpdateMemberByMid($mid, [], $card['oc_type']);
        }

        if ($member_card) {
            //设置到期时间
            if($member_card['om_card_id']==$cardid && $member_card['om_expire_time'] > time()){
                $expire_time    = $member_card['om_expire_time'] + $add;
                $left_num       = $member_card['om_left_num'] + $card['oc_times'];
            }else{
                $expire_time    = time() + $add;
                $left_num       = $card['oc_times'];
            }
            //设置用户会员卡号
            $card_num = $member_card['om_card_num'] ? $member_card['om_card_num'] : App_Helper_Tool::exportCardNum();
            $card_id = $member_card['om_card_id'] == $cardid ? $member_card['om_card_id'] : $cardid;
            $updata = array(
                'om_type'       => $card['oc_type'],
                'om_expire_time'    => $expire_time,
                'om_card_num'       => $card_num,
                'om_curr_id'        => $card['oc_identity'],
                'om_left_num'       => $left_num,
                'om_card_id'        => $card_id,
//                'om_remark'         => $remark,
                'om_update_time'    => time()
            );
            $offline_member->findUpdateMemberByMid($mid, $updata, $card['oc_type']);
        } else {
            $expire_time    = time() + $add;
            $indata = array(
                'om_s_id'       => $sid,
                'om_m_id'       => $mid,
                'om_es_id'      => $esId,
                'om_type'       => $card['oc_type'],
                'om_expire_time'=> $expire_time,
                'om_card_num'   => App_Helper_Tool::exportCardNum(),
                'om_card_id'    => $cardid,
                'om_curr_id'    => $card['oc_identity'],
                'om_left_num'   => $card['oc_times'],
               // 'om_remark'         => $remark,
                'om_create_time'=> time(),
                'om_update_time'    => time()
            );
            // 生成会员卡二维码
            if (plum_setmod_dir(PLUM_APP_BUILD.'/spread/')) {
                $filename = $mid.'-'.$indata['om_card_num']. '.png';
                $text = $indata['om_card_num'];
                Libs_Qrcode_QRCode::png($text, PLUM_APP_BUILD.'/spread/'.$filename, 'Q', 6, 1);
                $indata['om_card_qrcode'] =  PLUM_PATH_PUBLIC.'/build/spread/'.$filename;
            }
            $offline_member->insertValue($indata);
        }

        if($tid && ($sid == 4230 || $sid == 10380)){
            $trade_model = new App_Model_Store_MysqlOrderStorage($sid);
            $trade = $trade_model->findUpdateOrderByTid($tid);
            $tradeExtra = json_decode($trade['oo_trade_extra'],1);
            if(is_array($tradeExtra) && $tradeExtra['invoice'] > 0){
                $invoice_model = new App_Model_Train_MysqlTrainInvoiceStorage($sid);
                $data = [
                    'ati_s_id' => $sid,
                    'ati_m_id' => $trade['oo_m_id'],
                    'ati_tid'  => $trade['oo_tid'],
                    'ati_type' => $tradeExtra['invoice'],
                    'ati_trade_type' => 2,//会员卡发票
                    'ati_company_name' => $tradeExtra['companyName'],
                    'ati_company_code' => $tradeExtra['companyCode'],
                    'ati_status' => 1,//未开票
                    'ati_create_time' => time()
                ];
                $invoice_model->insertValue($data);
            }
        }


        return true;
    }

    /*
     * 发送推广二维码
     */
    public static function sendSpreadQrcode($mid) {
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_storage->getRowById($mid);
        $client_plugin = new App_Plugin_Weixin_ClientPlugin($member['m_s_id']);

        $center_model   = new App_Model_Member_MysqlMemberCenterStorage();
        $center_cfg     = $center_model->findUpdateBySid($member['m_s_id']);
        $default_cfg    = plum_parse_config('center_cfg');
        //VIP会员判断
        $vip_cfg_storage    = new App_Model_Member_MysqlVipCfgStorage($member['m_s_id']);
        $vip_cfg    = $vip_cfg_storage->fetchConfigOrDefault();
        if ($vip_cfg['vc_qrcode_limit'] && !self::checkVipMember($member['m_s_id'], $mid)) {
            $tip    = "非VIP会员不能获得推广二维码,请先购买";
            $client_plugin->sendTextMessage($member['m_openid'], $tip);
            return;
        }

        $real   = self::isRealMember($member['m_s_id'], $member['m_id']);
        if (!$real) {
            if ($center_cfg && $center_cfg['cc_noqr_tip']) {
                $tip    = $center_cfg['cc_noqr_tip'];
            } else {
                $tip    = $default_cfg['cc_noqr_tip'];
            }
            $client_plugin->sendTextMessage($member['m_openid'], $tip);
            return;
        }
        //创建二维码发布定时任务
        if ($center_cfg && $center_cfg['cc_qrcode_tip']) {
            $tip    = $center_cfg['cc_qrcode_tip'];
        } else {
            $tip    = $default_cfg['cc_qrcode_tip'];
        }
        
        $member_redis   = new App_Model_Member_RedisMemberStorage($member['m_s_id']);
        $member_redis->createQrcodeEvent($mid);
        $client_plugin->sendTextMessage($member['m_openid'], $tip);
        exit;
    }

    /*
     * 清除当前店铺下所有会员的推广二维码图片
     * 店铺分销中心上传新的背景图时使用
     */
    public static function clearSpreadImage($sid) {
        $member_model   = new App_Model_Member_MysqlMemberCoreStorage();

        $where[]    = array('name' => 'm_s_id', 'oper' => '=', 'value' => $sid);
        $updata     = array(
            'm_spread_image'    => '',//清空
        );
        $member_model->updateValue($updata, $where);
    }
    /*
     * 会员升级功能
     */
    public static function memberLevelUpgrade($mid, $sid) {
        $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_model->getRowByIdSid($mid, $sid);

        if (!$member) {
            return false;
        }
        // 判断是否达到分销条件
        self::monetaryFrequencyDistrib($sid,$member);

        $level_model    = new App_Model_Member_MysqlLevelStorage();
        $level  = $level_model->getListBySid($sid);
        if (!$level) {
            return false;
        }
        //增加级别默认值
        $level[0]   = array(
            'ml_sale_amount'    => 0,
            'ml_down_count'     => 0,
            'ml_traded_money'   => 0,
            'ml_traded_num'     => 0,
        );

        $level_xse  = intval($member['m_level']);//销售额等级
        $level_xxzs = intval($member['m_level']);//下线总数
        $level_cgjy = intval($member['m_level']);//成功交易
        $level_ljxf = intval($member['m_level']);//累计消费

        foreach ($level as $key => $one) {
            $key    = intval($key);
            //销售额计算
            if ($one['ml_sale_amount'] > 0 && $level[$level_xse]['ml_sale_amount'] < $one['ml_sale_amount']) {
                if ($member['m_sale_amount'] >= $one['ml_sale_amount']) {
                    $level_xse  = $key;
                }
            }
            //直推人数
            if ($one['ml_down_count'] > 0 && $level[$level_xxzs]['ml_down_count'] < $one['ml_down_count']) {
                //仅计算下一级
                $down_total     = intval($member["m_1c_count"]);
                if ($down_total >= $one['ml_down_count']) {
                    $level_xxzs = $key;
                }
            }
            //累积消费金额计算
            if ($one['ml_traded_money'] > 0 && $level[$level_ljxf]['ml_traded_money'] < $one['ml_traded_money']) {
                if ($member['m_traded_money'] >= $one['ml_traded_money']) {
                    $level_ljxf = $key;
                }
            }
            //成功交易次数计算
            if ($one['ml_traded_num'] > 0 && $level[$level_cgjy]['ml_traded_num'] < $one['ml_traded_num']) {
                if ($member['m_traded_num'] >= $one['ml_traded_num']) {
                    $level_cgjy = $key;
                }
            }
        }
        $level_index    = array($level_xse, $level_xxzs, $level_cgjy, $level_ljxf);
        $ret_index      = array_unique($level_index, SORT_NUMERIC);

        if (count($ret_index) == 1) {
            $level_now  = current($ret_index);
        } else {
            $level_now  = array_shift($ret_index);
            $weight     = $level[$level_now]['ml_weight'];
            foreach ($ret_index as $index) {
                if ($level[$index]['ml_weight'] > $weight) {
                    $level_now  = $index;
                }
            }
        }
        if ($level_now) {
            $updata = array(
                'm_level'   => $level_now
            );
            $member_model->updateById($updata, $member['m_id']);
            return true;
        }
        return false;
    }
    /*
     * 为会员设置新的上级
     */
    public static function setNewLeaderForMember($mid, $leader_id) {
        $member_model   = new App_Model_Member_MysqlMemberCoreStorage();

        $member     = $member_model->getRowById($mid);
        $leader     = $member_model->getRowById($leader_id);

        if ($member['m_s_id'] != $leader['m_s_id']) {
            return array('code' => 4001, 'msg' => "非同一个店铺的会员不能设置等级关系");
        }

        $level  = 0;
        //如果新上级是原来会员的下级
        for ($i=1; $i<=3; $i++) {
            if ($leader["m_{$i}f_id"] == $mid) {
                $level = $i;
                break;
            }
        }
        if (!$level) {
            
        } else {
            //如果新上级是原来会员的下级
        }
    }
    /*
     * 金币充值分佣
     * $pid 为充值
     */
    public static function coinRechargeDeduct($sid, $mid, $pid) {
        //获取店铺分销等级
        $level  = App_Helper_ShopWeixin::checkShopThreeLevel($sid);
        if (!$level) {
            return;
        }
        $value_model    = new App_Model_Member_MysqlRechargeValueStorage($sid);
        $value  = $value_model->findValueById($pid);

        if (!$value) {
            return;
        }

        $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_model->getRowById($mid);

        $client_plugin  = new App_Plugin_Weixin_ClientPlugin($sid);
        for ($i=1; $i<=$level; $i++) {
            $coin   = floatval($value["rv_{$i}f_coin"]);
            $fmid   = $member["m_{$i}f_id"];

            if ($coin > 0 && $fmid) {
                self::goldCoinTrans($sid, $fmid, $coin);

                $f_member   = $member_model->getRowById($fmid);
                $content    = "您的下级会员{$member['m_nickname']}充值{$value['rv_money']}元,您获得返现金额{$coin}元,请在我的钱包中查看。";
                //向会员发送消息
                $client_plugin->sendTextMessage($f_member['m_openid'], $content);
            }
        }
    }

    /*
     * 会员积分记录
     * @param int $type 增加或减少会员积分
     */
    public function memberDeductRecord($deduct, $title, $type, $source = App_Helper_OrderLevel::DEDUCT_CASHBACK_INCOME, $extra = null) {
        $deduct     = abs($deduct);
        $fee        = $type == self::DEDUCT_INOUT_INCOME ? $deduct : -$deduct;
        //会员积分
        self::deductTrans($this->mid, $fee);
        //记录
        $indata = array(
            'dd_s_id'       => $this->sid,
            'dd_m_id'       => $this->mid,
            'dd_inout_put'  => $type,
            'dd_title'      => $title,
            'dd_amount'     => $deduct,
            'dd_curr'       => floatval($this->member[''])+$fee,
            'dd_record_type'=> $source,
            'dd_tid'        => strval($extra),
            'dd_record_time'=> time(),
        );
        $inout_model    = new App_Model_Deduct_MysqlDeductDaybookStorage();
        $inout_model->insertValue($indata);
    }

    /**
     * 记录余额变动
     * type 支付方式  1微信支付 2余额支付 3充值码充值 4.管理员操作 5帖子打赏 6关闭职位退回余额 7邀请好友 8 抽奖 9游戏盒子积分兑换 10跑腿订单退款 11.组队红包收益 12 积分商城积分兑换 13.购买会员卡 14 混合支付退回
     */
    public static function coinInoutRecord($sid,$mid,$amount,$coin,$type,$remark='', $tid=''){
        $rcgrcd_storage = new App_Model_Member_MysqlRechargeStorage($sid);
        $indata = array(
            'rr_tid'        => $tid,
            'rr_s_id'       => $sid,
            'rr_m_id'       => $mid,
            'rr_amount'     => $amount,
            'rr_gold_coin'  => $coin,
            'rr_pay_type'   => $type,
            'rr_remark'     => $remark,
            'rr_create_time'=> time(),
        );
        $ret = $rcgrcd_storage->insertValue($indata);
        plum_open_backend('templmsg', 'coinChangeTempl', array('sid' => $sid, 'id' => $ret));

    }

    /**
     * 会员使用余额记录
     */
    public static function rechargeRecord($sid,$tid,$mid,$coin,$remark=''){
        $record_storage = new App_Model_Member_MysqlRechargeStorage($sid);
        //消费记录保存
        $indata = array(
            'rr_tid'        => $tid,
            'rr_s_id'       => $sid,
            'rr_m_id'       => $mid,
            'rr_amount'     => 0,
            'rr_gold_coin'  => $coin,
            'rr_status'     => 2,//标识金币减少
            'rr_pay_type'   => 2,//余额支付
            'rr_remark'     => $remark,
            'rr_create_time'=> time(),
        );
        $ret = $record_storage->insertValue($indata);
        plum_open_backend('templmsg', 'coinChangeTempl', array('sid' => $sid, 'id' => $ret));

    }

    /**
     * 店铺使用余额记录
     */
    public static function enterShopRechargeRecord($sid,$tid,$mid,$edId,$coin,$status,$type=2,$remark=''){
        $record_storage = new App_Model_Member_MysqlRechargeStorage($sid);
        //消费记录保存
        $indata = array(
            'rr_tid'        => $tid,
            'rr_s_id'       => $sid,
            'rr_es_id'      => $edId,
            'rr_m_id'       => $mid,
            'rr_amount'     => 0,
            'rr_gold_coin'  => $coin,
            'rr_status'     => $status,//标识金币减少
            'rr_pay_type'   => $type,//类型
            'rr_remark'     => $remark,
            'rr_create_time'=> time(),
        );
        $record_storage->insertValue($indata);
    }

    /**
     * 购买余额记录
     */
    public static function enterBuyRechargeRecord($sid,$tid,$mid,$edId,$coin,$status,$type=2,$pid=0,$amount=0){
        $record_storage = new App_Model_Member_MysqlRechargeStorage($sid);
        //消费记录保存
        $indata = array(
            'rr_tid'        => $tid,
            'rr_s_id'       => $sid,
            'rr_es_id'      => $edId,
            'rr_m_id'       => $mid,
            'rr_amount'     => $amount,
            'rr_gold_coin'  => $coin,
            'rr_status'     => $status,//标识金币减少
            'rr_pay_type'   => $type,//类型
            'rr_remark'     => '',
            'rr_create_time'=> time(),
            'rr_pid'        => $pid
        );
        $record_storage->insertValue($indata);
    }


    /**
     * 根据会消费金额或消费次数添加分销
     */
    public static function monetaryFrequencyDistrib($sid,$member){
        //获取三级分销配置
        $three_cfg  = new App_Model_Three_MysqlCfgStorage($sid);
        $tcRow = $three_cfg->findShopCfg();
        //开通了分销且分销未到期
        if($tcRow && $tcRow['tc_isopen'] && $tcRow['tc_expire_time']>time()){
            //获取成为分销条件数据
            $center_model = new App_Model_Member_MysqlMemberCenterStorage();
            $centerRow    = $center_model->findUpdateBySid($sid);
            if($centerRow && ($centerRow['cc_min_num']>0 || $centerRow['cc_min_amount']>0)){
                // 判断是否满足成为分销员的条件
                if($member['m_traded_num']>=$centerRow['cc_min_num'] || $member['m_traded_money']>=$centerRow['cc_min_amount']){
                    if(!$member['m_is_highest'] && !$member['m_1f_id']){
                        $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                        $member_model->updateById(array('m_is_highest'=>1), $member['m_id']);
                        // 添加一条分销商申请记录
                        $branch_model = new App_Model_Shop_MysqlShopBranchStorage($sid);
                        $row = $branch_model->findBranchByMid($member['m_id']);
                        if($row){
                            $ret = $branch_model->updateById(array('sb_status'=> 1,'sb_update_time'=>time()),$row['sb_id']);
                        }else{
                            $data = array(
                                'sb_m_id'     => $member['m_id'],
                                'sb_s_id'     => $sid,
                                'sb_realname' => $member['m_nickname'],
                                'sb_phone'    => $member['m_mobile'],
                                'sb_wxno'     => '',
                                'sb_status'   => 1,
                                'sb_create_time' => time(),
                                'sb_update_time' => time(),
                            );
                            $ret = $branch_model->insertValue($data);
                        }
                    }
                }
            }
        }
    }

    /*
     * 获得用户等级
     */
    public static function getMemberLevel($sid,$mid){
        $offline_member = new App_Model_Store_MysqlMemberStorage($sid);
        $where[]    = array('name' => 'om_s_id', 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'om_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'om_expire_time', 'oper' => '>', 'value' => time());
        $member_card    = $offline_member->getList($where, 0, 0, array('om_update_time' => 'desc'));
        $level = [];
        if($member_card){//先查找是否买了会员卡
            $cardid = $member_card[0]['om_card_id'];
            $card_model = new App_Model_Store_MysqlCardStorage($sid);
            $card   = $card_model->getRowById($cardid);
            $identity = intval($card['oc_identity']);
            $level_model = new App_Model_Member_MysqlLevelStorage();
            $level = $level_model->getRowById($identity);
        }

        if(!$level){//取会员的等级
            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
            $member     = $member_storage->findMemberByIdSid($mid, $sid);
            $identity = $member['m_level'];
            $level_model = new App_Model_Member_MysqlLevelStorage();
            $level = $level_model->getRowById($identity);
        }
        return $level;
    }
}