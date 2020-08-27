<?php
/**
 * 订单提成
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/11
 * Time: 下午12:11
 */
class App_Helper_OrderDeduct {
    const ORDER_NO_PAY      = 1;//订单未付款
    const ORDER_HAD_PAY     = 2;//订单已付款
    const ORDER_HAD_COMPLETE = 3;//订单已完成
    const ORDER_HAD_CLOSED  = 4;//订单已关闭
    const ORDER_REFUND      = 5;//已退款订单

    const DEDUCT_NO_COMPLETE    = 0;//佣金未返现
    const DEDUCT_HAD_COMPLETE   = 1;//佣金已返现
    const DEDUCT_REFUND_BACK    = 2;//退款收回佣金

    const DEDUCT_CASHBACK_INCOME    = 1;//返现收入
    const DEDUCT_SHARE_INCOME       = 2;//分享收入
    const DEDUCT_REFUND_PAY         = 3;//退款收回
    const DEDUCT_WITHDRAW_PAY       = 4;//提现支出
    const GOODS_DEDUCT_CASHBACK_INCOME = 5; //单品分销返现收入

    private $order_status_desc  = array(
        self::ORDER_NO_PAY      => '订单未付款',
        self::ORDER_HAD_PAY     => '订单已付款',
        self::ORDER_HAD_COMPLETE=> '订单已完成',
        self::ORDER_HAD_CLOSED  => '订单已关闭',
    );
    /*
     * 店铺ID
     */
    private $sid;
    /*
     * 店铺数据，字段名参考pre_shop
     */
    private $shop;
    /*
     * 默认订单各级返利列表
     */
    private $order_deduct_list  = array(
        //购买人返利信息
        'od_0f_id'       => 0,
        'od_0f_deduct'   => 0,
        'od_0f_ratio'    => 0,
        //上级提成信息
        'od_1f_id'        => 0,
        'od_1f_deduct'    => 0,
        'od_1f_ratio'     => 0,
        //上上级提成信息
        'od_2f_id'       => 0,
        'od_2f_deduct'   => 0,
        'od_2f_ratio'    => 0,
        //上上上级提成信息
        'od_3f_id'      => 0,
        'od_3f_deduct'  => 0,
        'od_3f_ratio'   => 0
    );

    /**
     * @var App_Plugin_Weixin_ClientPlugin
     */
    private $weixin_client;
    /**
     * @var App_Model_Member_MysqlMemberCoreStorage
     */
    private $member_storage;
    /**
     * @var App_Model_Shop_MysqlOrderDeductStorage
     */
    private $order_deduct_storage;
    /*
     * 数据状态是否准备好
     */
    private $has_ready = true;
    /*
     * 微分销层级
     */
    private $three_level    = 0;

    public function __construct($sid){
        $this->sid  = $sid;
        //获取店铺信息
        $shop_storage   = new App_Model_Shop_MysqlShopCoreStorage($sid);
        $this->shop     = $shop_storage->getRowById($sid);
        $this->weixin_client    = new App_Plugin_Weixin_ClientPlugin($sid);
        $this->member_storage   = new App_Model_Member_MysqlMemberCoreStorage();
        $this->order_deduct_storage = new App_Model_Shop_MysqlOrderDeductStorage($sid);

        $this->three_level  = App_Helper_ShopWeixin::checkShopThreeLevel($sid, 0);
        if (!$this->shop) {
            $this->has_ready = false;
        }
    }

    /**
     * 创建订单提成佣金
     * @param int $mid 购买人ID
     * @param string $tid 订单编号
     * @param float $amount 订单总金额 例如123.45元
     * @param array $ratio 提成比例 array(0 => 12.00, 1 => 2.00, 2 => 4.50, 3 => 5.55)
     * @return bool
     */
    public function createOrderDeduct($mid, $tid, $amount, array $ratio, $gid = 0, $type=1,$round_type = 0) {
        //无微分销,直接返回
        if (!$this->three_level) {
            return false;
        }
        $member     = $this->member_storage->getRowById($mid);
        if (!$member) {
            return false;
        }
        $indata = array(
            'od_s_id'       => $this->sid,
            'od_tid'        => $tid,
            'od_type'       => $type,
            'od_amount'     => $amount,
            'od_round_type' => $round_type,
            'od_create_time'=> time(),
        );

        if($type == 8){
            $indata['od_cl_id'] = $gid;
        }else{
            $indata['od_g_id'] = $gid;
        }

        for ($i=0; $i<=$this->three_level; $i++) {
            $tmp    = "{$i}f";
            //购买人或其上级存在
            $benefit    = $i == 0 ? $member['m_id'] : $member["m_{$tmp}_id"];
            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
            if ($benefit) {
                $mrow = $member_model->getRowById($benefit);
                $deduct_model   = new App_Model_Shop_MysqlDeductStorage();
                    $deductarr      = $deduct_model->getRowById($mrow['m_is_highest']);
                    $deduct    = $deductarr["dc_{$i}f_ratio"];

                     $this->order_deduct_list["od_{$tmp}_id"]        = $benefit;
                if($mrow['m_is_highest'] > 0){
                    // 获取是否根据会员等级计算提成比例
//                    $leverDeduct = $this->fetchMemberLeverDeduct($benefit,$i);
//                    if($leverDeduct){
//                        $deduct  = (float)$leverDeduct;
//                    }else{
//                        $deduct  = (float)$ratio[$i];
//                    }
                  
                    $this->order_deduct_list["od_{$tmp}_ratio"]     = $deduct;

                    if($round_type > 0){
                        if($round_type == 1){
                            $this->order_deduct_list["od_{$tmp}_deduct"]    = ceil(($deduct*$amount)/100);
                        }elseif ($round_type == 2){
                            $this->order_deduct_list["od_{$tmp}_deduct"]    = floor(($deduct*$amount)/100);
                        }else{
                            $this->order_deduct_list["od_{$tmp}_deduct"]    = round(($deduct*$amount)/100, 2);
                        }
                    }else{
                        $this->order_deduct_list["od_{$tmp}_deduct"]    = round(($deduct*$amount)/100, 2);
                    }
                }


            } else {
                break;
            }
        }
        $indata = array_merge($indata, $this->order_deduct_list);
        if($this->sid==12855){
            Libs_Log_Logger::outputLog($gid,'zytest111.log');
            Libs_Log_Logger::outputLog($mid,'zytest111.log');
            Libs_Log_Logger::outputLog($tid,'zytest111.log');
            Libs_Log_Logger::outputLog($amount,'zytest111.log');
            Libs_Log_Logger::outputLog($ratio,'zytest111.log');
            Libs_Log_Logger::outputLog($indata,'zytest111.log');
        }
        $ret = $this->order_deduct_storage->insertValue($indata);
        //plum_open_backend('index', 'deductTempl', array('sid' => $this->sid, 'odId' => $ret));
        return true;
    }

    //获取会员等级获取会员提成
    private function fetchMemberLeverDeduct($mid,$level){
        $deduct = 0;
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member = $member_storage->getMemberLeverByMid($mid);
        if($member && $member['ml_'.$level.'f_proportion'] && $member['ml_'.$level.'f_proportion']>0){
            $deduct = (float)$member['ml_'.$level.'f_proportion'];
        }
        return $deduct;
    }

    /**
     * 创建单品分享订单提成佣金
     * @param int $mid 购买人ID
     * @param string $tid 订单编号
     * @param float $amount 订单总金额 例如123.45元
     * @param array $ratio 提成比例 array(0 => 12.00, 1 => 2.00, 2 => 4.50, 3 => 5.55)
     * @return bool
     */
    public function createShareOrderDeduct($mid, $fid, $tid, $amount, array $ratio, $gid = 0, $type=1) {
        $member     = $this->member_storage->getRowById($mid);
        if (!$member) {
            return false;
        }

        $indata = array(
            'od_share_goods'=> 1,
            'od_s_id'       => $this->sid,
            'od_g_id'       => $gid,
            'od_tid'        => $tid,
            'od_type'       => $type,
            'od_amount'     => $amount,
            'od_create_time'=> time(),
        );

        for ($i=0; $i<=1; $i++) {
            $tmp    = "{$i}f";
            //购买人或其上级存在
            $benefit    = $i == 0 ? $member['m_id'] : $fid;
            if ($benefit) {
                $deduct  = (float)$ratio[$i];

                $this->order_deduct_list["od_{$tmp}_id"]        = $benefit;
                $this->order_deduct_list["od_{$tmp}_ratio"]     = $deduct;
                $this->order_deduct_list["od_{$tmp}_deduct"]    = round(($deduct*$amount)/100, 2);
            } else {
                break;
            }
        }
        $indata = array_merge($indata, $this->order_deduct_list);
        $ret = $this->order_deduct_storage->insertValue($indata);
        //plum_open_backend('index', 'deductTempl', array('sid' => $this->sid, 'odId' => $ret));
        return true;
    }

    /*
     * 订单状态更新时,发送提示信息
     * $tid 订单号
     * $mid 会员ID
     * $status 订单状态
     */
    public function updateOrderDeduct($tid, $mid, $status) {
        $ratio_list = $this->order_deduct_storage->findOrderDeductListNoTypeByTid($tid);
        if (!$ratio_list) {
            return false;
        }
        //无微分销 且 不是分享单品分销的订单,直接返回
        if (!$this->three_level && $ratio_list[0]['od_share_goods'] == 0) {
            return false;
        }
        $member     = $this->member_storage->getRowById($mid);
        if (!$member) {
            return false;
        }

        $higher     = array();
        $message_model  = new App_Model_System_MysqlMessageStorage($member['m_s_id']);
        $message_cfg    = plum_parse_config('message', 'message');
        $kind_base      = 6;
        foreach ($ratio_list as $ratio) {
            for ($i=0; $i<=$this->three_level; $i++) {
                $tmp    = "{$i}f";
                $deduct = (float)$ratio["od_{$tmp}_deduct"];
                //受益人存在
                if ($ratio["od_{$tmp}_id"] > 0) {
                    $f_member   = $this->member_storage->getRowById($ratio["od_{$tmp}_id"]);
                    //向各级发送提成信息，包括未生效提成
                    $higher[$i] = $f_member['m_nickname'];
                    //且收益额>0
                    if ($deduct > 0) {
                        //向会员发送消息
                        $kind2  = $kind_base+$i;
                        switch ($i) {
                            case 0 :
                                $msg    = array($deduct, $this->order_status_desc[$status], $higher[0], $tid, $this->shop['s_name']);
                                $mtpl   = $message_model->fetchUpdateByKindId(2, $kind2);
                                $tpl    = $mtpl ? $mtpl['sm_content'] : $message_cfg[2][$kind2]['default'];
                                $reg    = $message_cfg[2][$kind2]['usable'];
                                break;
                            case 1 :
                                $msg    = array($deduct, $this->order_status_desc[$status], $higher[0], $higher[1], $tid, $this->shop['s_name']);
                                $mtpl   = $message_model->fetchUpdateByKindId(2, $kind2);
                                $tpl    = $mtpl ? $mtpl['sm_content'] : $message_cfg[2][$kind2]['default'];
                                $reg    = $message_cfg[2][$kind2]['usable'];
                                break;
                            case 2 :
                                $msg    = array($deduct, $this->order_status_desc[$status], $higher[0], $higher[1], $higher[2], $tid, $this->shop['s_name']);
                                $mtpl   = $message_model->fetchUpdateByKindId(2, $kind2);
                                $tpl    = $mtpl ? $mtpl['sm_content'] : $message_cfg[2][$kind2]['default'];
                                $reg    = $message_cfg[2][$kind2]['usable'];
                                break;
                            case 3 :
                                $msg    = array($deduct, $this->order_status_desc[$status], $higher[0], $higher[1], $higher[2], $higher[3], $tid, $this->shop['s_name']);
                                $mtpl   = $message_model->fetchUpdateByKindId(2, $kind2);
                                $tpl    = $mtpl ? $mtpl['sm_content'] : $message_cfg[2][$kind2]['default'];
                                $reg    = $message_cfg[2][$kind2]['usable'];
                                break;
                        }
                        $content    = App_Helper_MemberLevel::messageContentReplace($reg, $msg, $tpl);
                        //发送提成消息
                        $this->weixin_client->sendTextMessage($f_member['m_openid'], $content);
                    }
                }
            }
        }
        return true;
    }

    /*
     * 分配订单佣金
     * @param string $tid 订单号
     * @param $mid
     */
  public function completeOrderDeduct($tid, $mid) {
        Libs_Log_Logger::outputLog("完成分销");
        $ratio_list = $this->order_deduct_storage->findOrderDeductListNoTypeByTid($tid);
    
        if (!$ratio_list) {
            return false;
        }

        //无微分销 且 不是分享单品分销的订单,直接返回
        if (!$this->three_level && $ratio_list[0]['od_share_goods'] != 0) {
            return false;
        }
        $member     = $this->member_storage->getRowById($mid);
     
        if (!$member) {
            return false;
        }


        Libs_Log_Logger::outputLog($ratio_list);

        foreach ($ratio_list as $ratio) {
            $ratio = $this->order_deduct_storage->getRowById($ratio['od_id']);
            if ($ratio['od_status'] != self::DEDUCT_NO_COMPLETE) {
                continue;
            }
            //修改佣金状态为已返佣
            $updata = array(
                'od_status'     => self::DEDUCT_HAD_COMPLETE
            );
            $this->order_deduct_storage->updateById($updata, $ratio['od_id']);
            //完成的订单才可进入操作
            $dd_storage = new App_Model_Deduct_MysqlDeductDaybookStorage();
            //购买人的第一次返利记入流水
            //上三级收入无分期情况，直接进入记账流水阶段
            $amount     = $ratio['od_amount'];//订单总额
            $higher     = array();
            $message_model  = new App_Model_System_MysqlMessageStorage($member['m_s_id']);
            $message_cfg    = plum_parse_config('message', 'message');
            $kind_base      = 10;
            for ($i=0; $i<=$this->three_level; $i++) {
                $tmp    = "{$i}f";
                $deduct = (float)$ratio["od_{$tmp}_deduct"];
                //受益人存在
                if ($ratio["od_{$tmp}_id"] > 0) {
                    $f_member   = $this->member_storage->getRowById($ratio["od_{$tmp}_id"]);
                    $higher[$i] = $f_member['m_nickname'];
                    //且收益额>0
                    if ($deduct > 0) {
                        $indata = array(
                            'dd_s_id'       => $this->sid,
                            'dd_m_id'       => $ratio["od_{$tmp}_id"],
                            'dd_o_id'       => 0,
                            'dd_od_id'      => $ratio['od_id'],
                            'dd_tid'        => $tid,
                            'dd_amount'     => $deduct,
                            'dd_level'      => $i,
                            'dd_record_type'=> $i ? self::DEDUCT_SHARE_INCOME : self::DEDUCT_CASHBACK_INCOME,
                            'dd_record_time'=> time(),
                        );
                        if($ratio['od_share_goods'] == 1 && $indata['dd_record_type'] == self::DEDUCT_CASHBACK_INCOME){
                            $indata['dd_record_type'] = self::GOODS_DEDUCT_CASHBACK_INCOME;
                        }
                        /*
                         * 根据会员信息订单信息和等级判断是否已经返佣
                         */
                        $pand = $this->_pand_is_deduct($mid,$tid,$i);
                        if($pand && !empty($pand)){   // 如果已经返佣则不再执行
                            continue;
                        }

                        $dd_storage->insertValue($indata);
                        //增加各级销售额,返现额,不增加自购销售额
                        $sale = $i==0 ? 0 : $amount;

                        if(!$ratio['od_share_goods']){
                            $this->member_storage->incrementMemberAmount($ratio["od_{$tmp}_id"], $sale, $deduct);
                        }

                        App_Helper_Trade::recordMemberSales($this->sid, $ratio["od_{$tmp}_id"], $tid, $sale, $mid, 0);
                        //增加各级可提现佣金额度
                        $this->member_storage->incrementMemberDeduct($ratio["od_{$tmp}_id"], $deduct);
                        //各级是否触发销售额等级
                        App_Helper_MemberLevel::memberLevelUpgrade($ratio["od_{$tmp}_id"], $member['m_s_id']);
                        //向各级发送提成信息，包括未生效提成

                        //向会员发送消息
                        $kind2  = $kind_base+$i;
                        switch ($i) {
                            case 0 :
                                $msg    = array($deduct, $this->order_status_desc[self::ORDER_HAD_COMPLETE], $higher[0], $tid, $this->shop['s_name']);
                                $mtpl   = $message_model->fetchUpdateByKindId(2, $kind2);
                                $tpl    = $mtpl ? $mtpl['sm_content'] : $message_cfg[2][$kind2]['default'];
                                $reg    = $message_cfg[2][$kind2]['usable'];
                                break;
                            case 1 :
                                $msg    = array($deduct, $this->order_status_desc[self::ORDER_HAD_COMPLETE], $higher[0], $higher[1], $tid, $this->shop['s_name']);
                                $mtpl   = $message_model->fetchUpdateByKindId(2, $kind2);
                                $tpl    = $mtpl ? $mtpl['sm_content'] : $message_cfg[2][$kind2]['default'];
                                $reg    = $message_cfg[2][$kind2]['usable'];
                                break;
                            case 2 :
                                $msg    = array($deduct, $this->order_status_desc[self::ORDER_HAD_COMPLETE], $higher[0], $higher[1], $higher[2], $tid, $this->shop['s_name']);
                                $mtpl   = $message_model->fetchUpdateByKindId(2, $kind2);
                                $tpl    = $mtpl ? $mtpl['sm_content'] : $message_cfg[2][$kind2]['default'];
                                $reg    = $message_cfg[2][$kind2]['usable'];
                                break;
                            case 3 :
                                $msg    = array($deduct, $this->order_status_desc[self::ORDER_HAD_COMPLETE], $higher[0], $higher[1], $higher[2], $higher[3], $tid, $this->shop['s_name']);
                                $mtpl   = $message_model->fetchUpdateByKindId(2, $kind2);
                                $tpl    = $mtpl ? $mtpl['sm_content'] : $message_cfg[2][$kind2]['default'];
                                $reg    = $message_cfg[2][$kind2]['usable'];
                                break;
                        }
                        $content    = App_Helper_MemberLevel::messageContentReplace($reg, $msg, $tpl);
                        $appletType = plum_parse_config('member_source_menu_type')[$f_member['m_source']];
                        $appletType = $appletType ? $appletType : 0;
                        plum_open_backend('templmsg', 'deductTempl', array('sid' => $this->sid, 'odId' => $ratio['od_id'],'appletType' => $appletType));
                        //发送提成消息
                        $this->weixin_client->sendTextMessage($f_member['m_openid'], $content);
                    }
                }
            }
        }
        //修改佣金状态为已返佣
        $updata = array(
            'od_status'     => self::DEDUCT_HAD_COMPLETE
        );
        $this->order_deduct_storage->findUpdateDeductByTid($tid, $updata);
        return true;
    }

    /*
     * 判断是否已经返佣
     */
    private function _pand_is_deduct($mid,$tid,$level){
        $dd_storage = new App_Model_Deduct_MysqlDeductDaybookStorage();
        $where = array();
        $where[] = array('name'=>'dd_m_id','oper'=>'=','value'=>$mid);
        $where[] = array('name'=>'dd_tid','oper'=>'=','value'=>$tid);
        $where[] = array('name'=>'dd_record_type','oper'=>'=','value'=>2); // 分享收入
        $where[] = array('name'=>'dd_level','oper'=>'=','value'=>$level); // 会员等级
        $row = $dd_storage->getRow($where);
        return $row;

    }
    /*
     * 退款收回订单佣金
     * @param string $tid 订单编号
     * @param int $mid 会员ID
     */
    public function refundOrderDeduct($tid, $mid, $gid=0) {
        $ratio_list = $this->order_deduct_storage->findOrderDeductListNoTypeByTid($tid, $gid);
        if (!$ratio_list) {
            return false;
        }

        //无微分销 且 不是分享单品分销的订单,直接返回
        if (!$this->three_level && $ratio_list[0]['od_share_goods'] == 0) {
            return false;
        }
        $member     = $this->member_storage->getRowById($mid);
        if (!$member) {
            return false;
        }

        foreach ($ratio_list as $ratio) {
            //未返过佣金
            if ($ratio['od_status'] != self::DEDUCT_HAD_COMPLETE) {
                continue;
            }
            //返现的订单才可进入操作
            $dd_storage = new App_Model_Deduct_MysqlDeductDaybookStorage();
            //购买人的第一次返利记入流水
            //上三级收入无分期情况，直接进入记账流水阶段
            $amount     = floatval($ratio['od_amount']);//订单总额
            $higher     = array();
            $message_model  = new App_Model_System_MysqlMessageStorage($member['m_s_id']);
            $message_cfg    = plum_parse_config('message', 'message');
            $kind_base      = 14;
            for ($i=0; $i<=$this->three_level; $i++) {
                $tmp    = "{$i}f";
                $deduct = (float)$ratio["od_{$tmp}_deduct"];
                //受益人存在
                if ($ratio["od_{$tmp}_id"] > 0) {
                    $f_member   = $this->member_storage->getRowById($ratio["od_{$tmp}_id"]);
                    $higher[$i] = $f_member['m_nickname'];
                    //且收益额>0
                    if ($deduct > 0) {
                        $indata = array(
                            'dd_s_id'       => $this->sid,
                            'dd_m_id'       => $ratio["od_{$tmp}_id"],
                            'dd_od_id'      => $ratio["od_id"],
                            'dd_o_id'       => 0,
                            'dd_tid'        => $tid,
                            'dd_amount'     => $deduct,
                            'dd_level'      => $i,
                            'dd_record_type'=> self::DEDUCT_REFUND_PAY,
                            'dd_record_time'=> time(),
                        );
                        $dd_storage->insertValue($indata);
                        //减少各级销售额,返现额,不减少自购销售额
                        $sale = $i==0 ? 0 : $amount;
                        if(!$ratio['od_share_goods']){
                            $this->member_storage->incrementMemberAmount($ratio["od_{$tmp}_id"], -$sale, -$deduct);
                        }

                        App_Helper_Trade::recordMemberSales($this->sid, $ratio["od_{$tmp}_id"], $tid, $sale, $mid, 0, true);
                        //减少各级可提现佣金额度
                        $this->member_storage->incrementMemberDeduct($ratio["od_{$tmp}_id"], -$deduct);
                        //各级是否触发销售额等级
                        //App_Helper_MemberLevel::memberLevelUpgrade($ratio["od_{$tmp}_id"], $member['m_s_id']);
                        //向各级发送提成信息，包括未生效提成

                        //向会员发送消息
                        $kind2  = $kind_base+$i;
                        switch ($i) {
                            case 0 :
                                $msg    = array($deduct, $this->order_status_desc[self::ORDER_HAD_COMPLETE], $higher[0], $tid, $this->shop['s_name']);
                                $mtpl   = $message_model->fetchUpdateByKindId(2, $kind2);
                                $tpl    = $mtpl ? $mtpl['sm_content'] : $message_cfg[2][$kind2]['default'];
                                $reg    = $message_cfg[2][$kind2]['usable'];
                                break;
                            case 1 :
                                $msg    = array($deduct, $this->order_status_desc[self::ORDER_HAD_COMPLETE], $higher[0], $higher[1], $tid, $this->shop['s_name']);
                                $mtpl   = $message_model->fetchUpdateByKindId(2, $kind2);
                                $tpl    = $mtpl ? $mtpl['sm_content'] : $message_cfg[2][$kind2]['default'];
                                $reg    = $message_cfg[2][$kind2]['usable'];
                                break;
                            case 2 :
                                $msg    = array($deduct, $this->order_status_desc[self::ORDER_HAD_COMPLETE], $higher[0], $higher[1], $higher[2], $tid, $this->shop['s_name']);
                                $mtpl   = $message_model->fetchUpdateByKindId(2, $kind2);
                                $tpl    = $mtpl ? $mtpl['sm_content'] : $message_cfg[2][$kind2]['default'];
                                $reg    = $message_cfg[2][$kind2]['usable'];
                                break;
                            case 3 :
                                $msg    = array($deduct, $this->order_status_desc[self::ORDER_HAD_COMPLETE], $higher[0], $higher[1], $higher[2], $higher[3], $tid, $this->shop['s_name']);
                                $mtpl   = $message_model->fetchUpdateByKindId(2, $kind2);
                                $tpl    = $mtpl ? $mtpl['sm_content'] : $message_cfg[2][$kind2]['default'];
                                $reg    = $message_cfg[2][$kind2]['usable'];
                                break;
                        }
                        $content    = App_Helper_MemberLevel::messageContentReplace($reg, $msg, $tpl);
                        //发送提成消息
                        $this->weixin_client->sendTextMessage($f_member['m_openid'], $content);
                    }
                }
            }
        }
        //修改佣金状态为已返佣
        $updata = array(
            'od_status'     => self::DEDUCT_REFUND_BACK
        );
        $this->order_deduct_storage->findUpdateDeductByTid($tid, $updata, $gid);
        return true;
    }
}