<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/4
 * Time: 下午2:09
 */

class App_Helper_OrderLevel {
    const ORDER_NO_PAY      = 1;//订单未付款
    const ORDER_HAD_PAY     = 2;//订单已付款
    const ORDER_HAD_COMPLETE = 3;//订单已完成
    const ORDER_HAD_CLOSED  = 4;//订单已关闭
    const ORDER_REFUND      = 5;//已退款订单

    const DEDUCT_CASHBACK_INCOME    = 1;//订单返现收入
    const DEDUCT_SHARE_INCOME       = 2;//推广分享收入
    const DEDUCT_REFUND_PAY         = 3;//退款收回支出
    const DEDUCT_WITHDRAW_PAY       = 4;//会员提现支出
    const DEDUCT_POINT_EXCHANGE     = 5;//积分换入

    private $youzan_order_status = array(
        'TRADE_NO_CREATE_PAY'       => 1,
        'WAIT_BUYER_PAY'            => 2,
        'WAIT_PAY_RETURN'           => 3,//订单未付款
        'WAIT_SELLER_SEND_GOODS'    => 4,
        'WAIT_BUYER_CONFIRM_GOODS'  => 5,//订单已付款
        'TRADE_BUYER_SIGNED'        => 6,//订单已完成
        'TRADE_CLOSED'              => 7,
        'TRADE_CLOSED_BY_USER'      => 8,//订单已关闭
    );

    private $weidian_order_status   = array(
        'unpay'         => 1,//未付款
        'pay'           => 2,//待发货
        'unship_refunding'  => 3,//未发货，申请退款
        'ship'          => 4,//已发货
        'shiped_refunding'  => 5,//已发货，申请退款
        'accept'        => 6,//已确认收货
        'accept_refunding'  => 7,//已确认收货，申请退款
        'finish'        => 8,//订单完成
        'close'         => 9,//订单关闭
    );

    private $order_status_desc  = array(
        self::ORDER_NO_PAY      => '订单未付款',
        self::ORDER_HAD_PAY     => '订单已付款',
        self::ORDER_HAD_COMPLETE=> '订单已完成',
        self::ORDER_HAD_CLOSED  => '订单已关闭',
        self::ORDER_REFUND      => '订单已退款',
    );
    /*
     * 默认订单各级返利列表
     */
    private $order_deduct_list  = array(
        //购买人返利信息
        'o_0f_id'       => 0,
        'o_0f_deduct'   => 0.00,
        'o_0f_ratio'    => 0.00,
        'o_back_num'    => 0,//返利分期数，默认0不分期
        //上级提成信息
        'o_1f_id'        => 0,
        'o_1f_deduct'    => 0.00,
        'o_1f_ratio'     => 0,
        //上上级提成信息
        'o_2f_id'       => 0,
        'o_2f_deduct'   => 0.00,
        'o_2f_ratio'    => 0,
        //上上上级提成信息
        'o_3f_id'      => 0,
        'o_3f_deduct'  => 0.00,
        'o_3f_ratio'   => 0
    );
    /*
     * 店铺数据，字段名参考pre_shop
     */
    private $shop;

    /*
     * 店铺提成比例配置表，字段名参考pre_deduct_cfg
     */
    private $deduct;

    /*
     * 提成购买次数范围
     */
    private $range;
    /**
     * @var App_Model_Member_MysqlMemberCoreStorage
     */
    private $member_storage;
    /**
     * @var App_Model_Shop_MysqlOrderCoreStorage
     */
    private $order_storage;

    /**
     * @var App_Model_Shop_RedisOrderStatusStorage
     */
    private $redis_order;

    /**
     * @var App_Plugin_Weixin_ClientPlugin
     */
    private $weixin_client;

    /*
     * 数据状态是否准备好
     */
    private $has_ready = true;
    /*
     * 微分销层级
     */
    private $three_level    = 0;

    public function __construct($sid) {
        //获取店铺信息
        $shop_storage   = new App_Model_Shop_MysqlShopCoreStorage();
        $this->shop     = $shop_storage->getRowById($sid);
        //获取店铺提成比例配置信息
        $deduct_storage = new App_Model_Shop_MysqlDeductStorage();
        $this->deduct   = $deduct_storage->fetchDeductListBySid($sid);
        $this->range    = array_keys($this->deduct);
        sort($this->range, SORT_NUMERIC);//按数字来比较

        $this->member_storage   = new App_Model_Member_MysqlMemberCoreStorage();
        $this->order_storage    = new App_Model_Shop_MysqlOrderCoreStorage();
        $this->redis_order      = new App_Model_Shop_RedisOrderStatusStorage($sid);
        $this->weixin_client    = new App_Plugin_Weixin_ClientPlugin($sid);

        $this->three_level  = App_Helper_ShopWeixin::checkShopThreeLevel($sid);
        if (!$this->shop || !$this->redis_order || !$this->weixin_client) {
            $this->has_ready = false;
        }
    }

    /*
     * 微店新购订单处理,未支付订单
     * @link 微店订单接口字段说明 http://wiki.open.weidian.com/index.php?title=%E8%8E%B7%E5%8F%96%E8%AE%A2%E5%8D%95%E8%AF%A6%E6%83%85
     */
    public function weidianOrderCreateDeal(array $order) {
        $phone      = $order['user_phone'];//获取买家手机号
        $buyer_id   = $order['buyer_info']['buyer_id'];//买家在微店的id

        $member     = $this->member_storage->findUpdateMemberByBuyerid($buyer_id, $this->shop['s_id']);
        if (!$member) {
            //第一次下单,未绑定,通过手机号查找会员
            //定位系统中的买家信息
            $member     = $this->member_storage->findUpdateMemberByMobile($phone, $this->shop['s_id']);

            if ($member) {
                //绑定微店id
                $this->member_storage->findUpdateMemberByBuyerid($buyer_id, $this->shop['s_id'], $member['m_id']);
            } else {
                Libs_Log_Logger::outputLog("微店订单会员未查找到, phone: {$phone}");
                return false;
            }
        }

        //返利、佣金处理, 仅商品总价格,不包括运费
        $payment        = (float)$order['price'];
        $status         = self::ORDER_NO_PAY;//进来的都是未付款订单
        //无微分销,直接返回
        if ($this->three_level) {
            $deduct         = $this->_deduct_translate($member['m_traded_num']);
            for ($i=0; $i<=$this->three_level; $i++) {
                $tmp    = "{$i}f";
                //购买人或其上级存在
                $benefit    = $i == 0 ? $member['m_id'] : $member["m_{$tmp}_id"];
                if ($benefit) {
                    $ratio  = (float)$deduct["dc_{$tmp}_ratio"];
                    $this->order_deduct_list["o_{$tmp}_id"]        = $benefit;
                    $this->order_deduct_list["o_{$tmp}_ratio"]     = $ratio;
                    $this->order_deduct_list["o_{$tmp}_deduct"]    = round(($ratio*$payment)/100, 2);
                } else {
                    break;
                }
            }
        }

        //创建订单
        $indata = array(
            'o_m_id'        => $member['m_id'],
            'o_s_id'        => $this->shop['s_id'],
            'o_c_id'        => $this->shop['s_c_id'],
            'o_tid'         => $order['order_id'],
            'o_title'       => $order['items'][0]['item_name'],//获取第一个购买项目的标题
            'o_num'         => $order['quantity'],
            'o_weixin_user_id'  => $buyer_id,//用户在微信系统中的id
            'o_buyer_nick'  => $order['buyer_info']['name'],
            'o_total_fee'   => $order['price'],//商品总价，不包含运费
            'o_post_fee'    => $order['express_fee'],//运费
            'o_payment'     => $order['total'],//商品总价，实付款，包含运费
            'o_created'     => $order['add_time'],//下单时间
            'o_update_time' => '',
            'o_pay_time'    => '',
            'o_wd_status'   => $this->weidian_order_status[$order['status']],
            'o_status'      => $status,
            'o_feedback'    => 0,//没有维权
        );
        $indata = array_merge($indata, $this->order_deduct_list);
        //插入订单数据
        $oid = $this->order_storage->insert($indata, true);
        $indata['o_id'] = $oid;
        return true;
    }

    /*
     * 购买人返利及上级佣金处理
     * @param array $member 会员信息
     * @param float $payment 实付款
     * @param string $tid 订单号
     * @param int $status 订单状态
     */
    private function _buyer_deduct_deal(array $member, $payment) {
        if (!$this->three_level) {
            return false;
        }
        $deduct         = $this->_deduct_translate($member['m_traded_num']);
        for ($i=0; $i<=$this->three_level; $i++) {
            $tmp    = "{$i}f";
            //购买人或其上级存在
            $benefit    = $i == 0 ? $member['m_id'] : $member["m_{$tmp}_id"];
            if ($benefit) {
                $ratio  = (float)$deduct["dc_{$tmp}_ratio"];
                $this->order_deduct_list["o_{$tmp}_id"]        = $benefit;
                $this->order_deduct_list["o_{$tmp}_ratio"]     = $ratio;
                $this->order_deduct_list["o_{$tmp}_deduct"]    = round(($ratio*$payment)/100, 2);
            } else {
                break;
            }
        }
        return true;
    }

    /*
     * 微店订单更新处理
     */
    public function weidianOrderUpdateDeal(array $order, $status) {
        $trade  = $this->order_storage->findOrderByTid($order['order_id']);
        //订单不存在
        if (!$trade) {
            Libs_Log_Logger::outputConsoleLog('订单不存在');
            return false;
        }
        //状态未改变，直接返回
        $old_status = intval($trade['o_status']);//原有订单状态
        if ($old_status == $status) {
            return false;
        }
        switch ($status) {
            case App_Helper_OrderLevel::ORDER_NO_PAY :
                //状态仍为未付款，不做处理
                break;
            case App_Helper_OrderLevel::ORDER_HAD_PAY :
                //已支付状态
                break;
            case App_Helper_OrderLevel::ORDER_HAD_COMPLETE :
                //完成状态
                //各级增加可提现佣金
                $this->_record_deduct_daybook($trade);
                break;
            case App_Helper_OrderLevel::ORDER_HAD_CLOSED :
                //关闭状态
                break;
            case App_Helper_OrderLevel::ORDER_REFUND :
                //已完成的订单退款时
                if ($old_status == self::ORDER_HAD_COMPLETE) {
                    //各级减去销售额及提成,可提现佣金
                    $this->_record_deduct_daybook($trade, false);
                }
                break;
        }

        $this->_order_update_message($trade, $status, $trade['o_status']);

        $updata = array(
            'o_update_time'     => date('Y-m-d H:i:s', time()),
            'o_pay_time'        => $order['pay_time'],
            'o_wd_status'       => $this->weidian_order_status[$order['status']],
            'o_status'          => $status,
            'o_feedback'        => $order['feedback'],
        );
        $this->order_storage->updateById($updata, $trade['o_id']);
        return true;
    }

    /*
     * 发送返利、佣金信息
     * @param array $order
     * @param array $text_arr
     * @param $new_status
     * @param $old_status
     */
    private function _order_update_message(array $order, $new_status, $old_status) {
        $payment    = (float)$order['o_payment'];
        //未付款跳转到已付款、已完成状态时，增加成交订单量及成交订单额
        if ($old_status == App_Helper_OrderLevel::ORDER_NO_PAY) {
            if ($new_status == App_Helper_OrderLevel::ORDER_HAD_PAY || $new_status == App_Helper_OrderLevel::ORDER_HAD_COMPLETE) {
                $this->member_storage->incrementMemberTrade($order['o_m_id'], $payment, 1);
            }
        }
        //退款订单,原订单状态为已付款,已完成状态时,减少成交订单量及成交订单额
        if ($new_status == self::ORDER_REFUND) {
            if ($old_status == self::ORDER_HAD_PAY || $old_status == self::ORDER_HAD_COMPLETE) {
                $this->member_storage->incrementMemberTrade($order['o_m_id'], -$payment, -1);
            }
        }
        if (!$this->three_level) {
            return false;
        }
        //向各级发送提成信息
        $higher     = array();
        $message_model  = new App_Model_System_MysqlMessageStorage($order['o_s_id']);
        $message_cfg    = plum_parse_config('message', 'message');
        $kind_base  = 6;
        if ($new_status == self::ORDER_HAD_COMPLETE) {
            $kind_base  = 10;
        } else if ($new_status == self::ORDER_REFUND) {
            $kind_base  = 14;
        }
        for ($i=0; $i<=$this->three_level; $i++) {
            $tmp    = "{$i}f";
            if ($order["o_{$tmp}_id"]) {
                $deduct = floatval($order["o_{$tmp}_deduct"]);
                if ( $deduct > 0) {
                    $f_member   = $this->member_storage->getRowById($order["o_{$tmp}_id"]);
                    $higher[$i] = $f_member['m_nickname'];
                    $kind2  = $kind_base+$i;
                    switch ($i) {
                        case 0 :
                            $msg    = array($deduct, $this->order_status_desc[$new_status], $higher[0], $order['o_tid'], $this->shop['s_name']);
                            $mtpl   = $message_model->fetchUpdateByKindId(2, $kind2);
                            $tpl    = $mtpl ? $mtpl['sm_content'] : $message_cfg[2][$kind2]['default'];
                            $reg    = $message_cfg[2][$kind2]['usable'];
                            break;
                        case 1 :
                            $msg    = array($deduct, $this->order_status_desc[$new_status], $higher[0], $higher[1], $order['o_tid'], $this->shop['s_name']);
                            $mtpl   = $message_model->fetchUpdateByKindId(2, $kind2);
                            $tpl    = $mtpl ? $mtpl['sm_content'] : $message_cfg[2][$kind2]['default'];
                            $reg    = $message_cfg[2][$kind2]['usable'];
                            break;
                        case 2 :
                            $msg    = array($deduct, $this->order_status_desc[$new_status], $higher[0], $higher[1], $higher[2], $order['o_tid'], $this->shop['s_name']);
                            $mtpl   = $message_model->fetchUpdateByKindId(2, $kind2);
                            $tpl    = $mtpl ? $mtpl['sm_content'] : $message_cfg[2][$kind2]['default'];
                            $reg    = $message_cfg[2][$kind2]['usable'];
                            break;
                        case 3 :
                            $msg    = array($deduct, $this->order_status_desc[$new_status], $higher[0], $higher[1], $higher[2], $higher[3], $order['o_tid'], $this->shop['s_name']);
                            $mtpl   = $message_model->fetchUpdateByKindId(2, $kind2);
                            $tpl    = $mtpl ? $mtpl['sm_content'] : $message_cfg[2][$kind2]['default'];
                            $reg    = $message_cfg[2][$kind2]['usable'];
                            break;
                    }
                    $content    = App_Helper_MemberLevel::messageContentReplace($reg, $msg, $tpl);
                    //发送提成消息
                    $this->weixin_client->sendTextMessage($f_member['m_openid'], $content);
                }
            } else {
                break;
            }
        }
        return true;
    }

    /*
     * 推送信息形式,创建有赞新订单,未支付订单
     */
    public function youzanTradeCreate($order) {
        if (!$this->has_ready) {
            Libs_Log_Logger::outputLog("获取新订单时，对象状态出错{$order['tid']}", "auto-shop.log");
            return false;
        }
        if (!$order['weixin_user_id']) {
            Libs_Log_Logger::outputLog("获取新订单时，有赞会员号{$order['weixin_user_id']}未设置{$order['tid']}", "auto-shop.log");
            return false;
        }
        //查找订单是否已存在
        $order_exists   = $this->order_storage->findOrderByTid($order['tid']);
        if ($order_exists) {
            Libs_Log_Logger::outputLog("订单{$order['tid']}已存在", "auto-shop.log");
            return false;
        }
        //获取会员信息
        $member         = $this->member_storage->findUpdateMemberBySidUid($this->shop['s_id'], $order['weixin_user_id']);
        if (!$member) {
            //会员未点击会员中心，直接下单支付，导致有赞user_id获取失败时，会员信息的修复功能
            $youzan_client  = new App_Plugin_Youzan_OauthClient($this->shop['s_id']);
            $member = $youzan_client->getWeixinFollower($order['weixin_user_id'], false);
            if (!$member) {
                //仍旧获取不到时，提示
                Libs_Log_Logger::outputLog("获取新订单时，获取会员信息失败{$order['weixin_user_id']}未设置{$order['tid']}", "auto-shop.log");
                return false;
            }
        }
        //返利、佣金处理
        $payment        = (float)$order['total_fee'];
        //转换订单状态
        $status         = $this->_status_translate($this->youzan_order_status[$order['status']]);
        $this->_buyer_deduct_deal($member, $payment);
        $indata = array(
            'o_m_id'        => $member['m_id'],
            'o_s_id'        => $this->shop['s_id'],
            'o_c_id'        => $this->shop['s_c_id'],
            'o_tid'         => $order['tid'],
            'o_title'       => $order['title'],
            'o_num'         => $order['num'],//商品购买数量
            'o_weixin_user_id'  => $order['weixin_user_id'],
            'o_buyer_nick'  => $order['buyer_nick'],
            'o_total_fee'   => $order['total_fee'],//商品总价,不包括运费
            'o_post_fee'    => $order['post_fee'],//运费
            'o_payment'     => $order['payment'],//实付金额,包括运费
            'o_created'     => $order['created'],
            'o_update_time' => $order['update_time'],
            'o_pay_time'    => $order['pay_time'],
            'o_yz_status'   => $this->youzan_order_status[$order['status']],
            'o_status'      => $status,
            'o_feedback'    => $order['feedback'],
        );

        $indata = array_merge($indata, $this->order_deduct_list);
        //插入订单数据
        $oid = $this->order_storage->insert($indata, true);
        $indata['o_id'] = $oid;
        Libs_Log_Logger::outputLog("插入新订单oid={$oid}", "auto-shop.log");
        return true;
    }
    /*
     * 推送信息形式,有赞订单更新
     */
    public function youzanTradeUpdate($order) {
        if (!$this->has_ready) {
            return false;
        }
        $status = $this->_status_translate($this->youzan_order_status[$order['status']]);
        $trade  = $this->order_storage->findOrderByTid($order['tid']);
        if (!$trade) {
            //订单不存在
            Libs_Log_Logger::outputConsoleLog('订单不存在');
            return false;
        }
        $oldStatus  = $trade['o_status'];
        if ($oldStatus && $oldStatus == $status) {
            //状态未改变，直接返回
            return false;
        }
        switch ($status) {
            case App_Helper_OrderLevel::ORDER_HAD_PAY :
                //已支付状态
                break;
            case App_Helper_OrderLevel::ORDER_HAD_COMPLETE :
                //完成状态
                //各级增加可提现佣金
                $this->_record_deduct_daybook($trade);
                break;
            case App_Helper_OrderLevel::ORDER_HAD_CLOSED :
                //关闭状态，从hash表中删除
                break;
        }

        Libs_Log_Logger::outputLog($status);
        $this->_order_update_message($trade, $status, $oldStatus);
        $updata = array(
            'o_update_time'     => $order['update_time'],
            'o_pay_time'        => $order['pay_time'],
            'o_yz_status'       => $this->youzan_order_status[$order['status']],
            'o_status'          => $status,
            'o_feedback'        => $order['feedback'],
        );
        $this->order_storage->updateById($updata, $trade['o_id']);
        return true;
    }
    /*
     * 推送信息形式,有赞订单退款
     */
    public function youzanTradeRefund($order) {
        if (!$this->has_ready) {
            return false;
        }
        $trade  = $this->order_storage->findOrderByTid($order['tid']);
        if (!$trade) {
            //订单不存在
            Libs_Log_Logger::outputConsoleLog('订单不存在');
            return false;
        }
        $oldStatus  = intval($trade['o_status']);
        if ($oldStatus == self::ORDER_REFUND) {
            //已退款订单，直接返回
            return false;
        }
        $status     = self::ORDER_REFUND;

        switch ($oldStatus) {
            case self::ORDER_HAD_PAY :
                break;
            case self::ORDER_HAD_COMPLETE :
                $this->_record_deduct_daybook($trade, false);
                break;
        }

        $this->_order_update_message($trade, $status, $oldStatus);
        $updata = array(
            'o_update_time'     => $order['update_time'],
            'o_pay_time'        => $order['pay_time'],
            'o_yz_status'       => $this->youzan_order_status[$order['status']],
            'o_status'          => $status,
            'o_feedback'        => $order['feedback'],
        );
        $this->order_storage->updateById($updata, $trade['o_id']);
        return true;
    }

    /*
     * 返利分期，做特殊处理
     * 记录收入流水，并增加可提现额度
     */
    private function _record_deduct_daybook(array $order, $add = true) {
        if (!$this->three_level) {
            return false;
        }
        //完成的订单, 退款的订单才可进入操作
        $dd_storage = new App_Model_Deduct_MysqlDeductDaybookStorage();
        //购买人的第一次返利记入流水
        //上三级收入无分期情况，直接进入记账流水阶段
        $amount = floatval($order['o_total_fee']);//订单总金额, 不包含运费
        for ($i=0; $i<=$this->three_level; $i++) {
            $tmp    = "{$i}f";
            //受益人存在，且收益额>0
            $deduct = (float)$order["o_{$tmp}_deduct"];
            if ($order["o_{$tmp}_id"] && $deduct > 0) {
                $indata = array(
                    'dd_s_id'       => $this->shop['s_id'],
                    'dd_m_id'       => $order["o_{$tmp}_id"],
                    'dd_o_id'       => $order['o_id'],
                    'dd_tid'        => $order['o_tid'],
                    'dd_amount'     => $deduct,
                    'dd_level'      => $i,
                    //标记是退款,还是收入,以及收入类型
                    'dd_record_type'=> $add ? ($i ? self::DEDUCT_SHARE_INCOME : self::DEDUCT_CASHBACK_INCOME) : self::DEDUCT_REFUND_PAY,
                    'dd_record_time'=> time(),
                );
                $dd_storage->insertValue($indata);
                //增加或减少各级销售额,返现额,不增加自购销售额
                $sale = $i==0 ? 0 : $amount;

                $sale   = $add ? $sale : -$sale;
                $deduct = $add ? $deduct : -$deduct;
                $this->member_storage->incrementMemberAmount($order["o_{$tmp}_id"], $sale, $deduct);
                $ss_type    = $order['o_yz_status'] > 0 ? 1 : 2;
                App_Helper_Trade::recordMemberSales($this->shop['s_id'], $order["o_{$tmp}_id"], $order['o_tid'], $sale, $order['o_m_id'], $ss_type, !$add);
                $this->member_storage->incrementMemberDeduct($order["o_{$tmp}_id"], $deduct);
            }
        }
        return true;
    }

    /*
     * 自动计算下次分期日期Y-m-d
     * @param string $date 上次分期日期
     * @param int $timestamp 创建分期时间戳
     */
    private function _auto_divide_date($date, $timestamp) {
        list($year, $month, $day)   = explode('-', $date);
        list(,,$cday)   = explode('-', date('Y-m-d', $timestamp));

        $year   = intval($year);
        $month  = intval($month);
        $day    = intval($day);
        $cday   = intval($cday);

        $nyear  = $year;
        $nmonth = $month+1;
        $nday   = $day;
        switch ($nmonth) {
            case 3 :
            case 5 :
            case 7 :
            case 8 :
            case 10 :
            case 12 :
                $nday   = max($cday, $day);
                break;
            case 4 :
            case 6 :
            case 9 :
            case 11 :
                $nday   = min($day, 30);
                break;
            case 2 :
                //二月份统一到28日，不再分平年、闰年
                $nday   = min($day, 28);
                break;
            case 13 :
                $nyear  = $year+1;
                $nmonth = 1;
                $nday   = max($cday, $day);
                break;
        }

        return $nyear.'-'.($nmonth < 10 ? '0'.$nmonth : $nmonth).'-'.($nday < 10 ? '0'.$nday : $nday);
    }

    /*
     * 提成比例转换
     */
    private function _deduct_translate($has_buy) {
        $has_buy = intval($has_buy) >= 0? intval($has_buy) : 0;
        $has_buy++;

        $index = 1;//提成字段索引
        foreach ($this->range as $val) {
            $val = intval($val);
            if ($has_buy < $val) {
                break;
            }
            $index = $val;
        }
        return $this->deduct[$index];
    }

    /*
     * 状态转换
     */
    private function _status_translate($yzStatus) {
        $yzStatus   = intval($yzStatus);
        switch($yzStatus) {
            case 1 :
            case 2 :
            case 3 :
                $status = self::ORDER_NO_PAY;
                break;
            case 4 :
            case 5 :
                $status = self::ORDER_HAD_PAY;
                break;
            case 6 :
                $status = self::ORDER_HAD_COMPLETE;
                break;
            case 7 :
            case 8 :
            default :
                $status = self::ORDER_HAD_CLOSED;
                break;
        }
        return $status;
    }
    /*
     * @废弃
     * 创建订单，设置分销提成，发送消息
     */
    public function youzanOrderCreateDeal(array $order) {
        if (!$this->has_ready) {
            Libs_Log_Logger::outputLog("获取新订单时，对象状态出错{$order['tid']}", "auto-shop.log");
            return false;
        }
        if (!$order['weixin_user_id']) {
            Libs_Log_Logger::outputLog("获取新订单时，有赞会员号{$order['weixin_user_id']}未设置{$order['tid']}", "auto-shop.log");
            return false;
        }
        //查找订单是否已存在
        $order_exists   = $this->order_storage->findOrderByTid($order['tid']);
        if ($order_exists) {
            Libs_Log_Logger::outputLog("订单{$order['tid']}已存在", "auto-shop.log");
            return false;
        }
        //获取会员信息
        $member         = $this->member_storage->findUpdateMemberBySidUid($this->shop['s_id'], $order['weixin_user_id']);
        Libs_Log_Logger::outputLog($member);
        if (!$member) {
            //会员未点击会员中心，直接下单支付，导致有赞user_id获取失败时，会员信息的修复功能
            $youzan_client  = new App_Plugin_Youzan_OauthClient($this->shop['s_id']);
            $member = $youzan_client->getWeixinFollower($order['weixin_user_id'], false);
            if (!$member) {
                //仍旧获取不到时，提示
                Libs_Log_Logger::outputLog("获取新订单时，获取会员信息失败{$order['weixin_user_id']}未设置{$order['tid']}", "auto-shop.log");
                return false;
            }
        }
        //返利、佣金处理
        $payment        = (float)$order['payment'];
        //转换订单状态
        $status         = $this->_status_translate($this->youzan_order_status[$order['status']]);
        $this->_buyer_deduct_deal($member, $payment);
        $indata = array(
            'o_m_id'        => $member['m_id'],
            'o_s_id'        => $this->shop['s_id'],
            'o_c_id'        => $this->shop['s_c_id'],
            'o_tid'         => $order['tid'],
            'o_title'       => $order['title'],
            'o_num'         => $order['num'],
            'o_weixin_user_id'  => $order['weixin_user_id'],
            'o_buyer_nick'  => $order['buyer_nick'],
            'o_total_fee'   => $order['total_fee'],
            'o_post_fee'    => $order['post_fee'],
            'o_payment'     => $order['payment'],
            'o_created'     => $order['created'],
            'o_update_time' => $order['update_time'],
            'o_pay_time'    => $order['pay_time'],
            'o_yz_status'   => $this->youzan_order_status[$order['status']],
            'o_status'      => $status,
            'o_feedback'    => $order['feedback'],
        );

        $indata = array_merge($indata, $this->order_deduct_list);
        //插入订单数据
        $oid = $this->order_storage->insert($indata, true);
        $indata['o_id'] = $oid;
        Libs_Log_Logger::outputLog("插入新订单oid={$oid}", "auto-shop.log");

        if ($status == self::ORDER_HAD_CLOSED) {
            //已关闭订单，不做处理

        } else {
            if ($status < self::ORDER_HAD_COMPLETE) {
                //将未付款，已付款但未完成的订单放置到redis中，以便后续更新订单时使用
                $this->redis_order->addNewToHash($order['tid'], $status);
            }
            //已付款，已完成订单增加用户成交订单数量及金额
            if ($status == self::ORDER_HAD_PAY || $status == self::ORDER_HAD_COMPLETE) {
                //增加成交订单数量及金额
                $this->member_storage->incrementMemberTrade($member['m_id'], $payment, 1);
                //已完成订单，增加各级可提现佣金
                if ($status == self::ORDER_HAD_COMPLETE) {
                    $this->_record_deduct_daybook($indata);
                }
            }
        }
        return true;
    }
    /*
     * @废弃
     * 更新订单，分销提成，成交订单信息，发送消息
     */
    public function youzanOrderUpdateDeal(array $order, $oldStatus = 0) {
        if (!$this->has_ready) {
            return false;
        }
        $status = $this->_status_translate($this->youzan_order_status[$order['status']]);
        if ($oldStatus && $oldStatus == $status) {
            //状态未改变，直接返回
            return false;
        }

        $trade  = $this->order_storage->findOrderByTid($order['tid']);
        if (!$trade) {
            //订单不存在
            Libs_Log_Logger::outputConsoleLog('订单不存在');
            return false;
        }

        switch ($status) {
            case App_Helper_OrderLevel::ORDER_NO_PAY :
                //状态仍为未付款，不做处理
                $this->redis_order->addNewToHash($order['tid'], $status);
                break;
            case App_Helper_OrderLevel::ORDER_HAD_PAY :
                //已支付状态，修改hash表中订单状态
                $this->redis_order->addNewToHash($order['tid'], $status);
                break;
            case App_Helper_OrderLevel::ORDER_HAD_COMPLETE :
                //完成状态，从hash表中删除
                $this->redis_order->delTidFromHash($order['tid']);
                //各级增加可提现佣金
                $this->_record_deduct_daybook($trade);
                break;
            case App_Helper_OrderLevel::ORDER_HAD_CLOSED :
                //关闭状态，从hash表中删除
                $this->redis_order->delTidFromHash($order['tid']);
                break;
        }

        $this->_order_update_message($trade, $status, $oldStatus);
        $updata = array(
            'o_update_time'     => $order['update_time'],
            'o_pay_time'        => $order['pay_time'],
            'o_yz_status'       => $this->youzan_order_status[$order['status']],
            'o_status'          => $status,
            'o_feedback'        => $order['feedback'],
        );
        $this->order_storage->updateById($updata, $trade['o_id']);
        return true;
    }
    /*
     * 获取有赞店铺状态描述
     */
    public function getYouzanOrderStatus() {
        return $this->youzan_order_status;
    }
}