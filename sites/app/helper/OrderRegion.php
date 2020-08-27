<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/2/18
 * Time: 上午9:49
 */
class App_Helper_OrderRegion {
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

    private $order_status_desc  = array(
        self::ORDER_NO_PAY      => '订单未付款',
        self::ORDER_HAD_PAY     => '订单已付款',
        self::ORDER_HAD_COMPLETE=> '订单已完成',
        self::ORDER_HAD_CLOSED  => '订单已关闭',
    );


    const TRADE_REGION_NONE     = 0;//返还中
    const TRADE_REGION_HAD      = 1;//已返还
    const TRADE_REGION_BACK     = 2;//已退回
    /*
     * 区域代理对应词
     */
    private $trade_region_tr    = array(
        1   => 'p',
        2   => 's',
        3   => 'z',
    );
    /*
     * 店铺ID
     */
    private $sid;
    /*
     * 店铺数据，字段名参考pre_shop
     */
    private $shop;
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
    private $deduct_storage;
    /*
     * 数据状态是否准备好
     */
    private $has_ready = true;
    /*
     * 是否开通区域代理功能
     */
    private $region_open    = 0;

    public function __construct($sid){
        $this->sid  = $sid;
        //获取店铺信息
        $shop_storage   = new App_Model_Shop_MysqlShopCoreStorage();
        $this->shop     = $shop_storage->getRowById($sid);
        $this->weixin_client    = new App_Plugin_Weixin_ClientPlugin($sid);
        $this->member_storage   = new App_Model_Member_MysqlMemberCoreStorage();
        $this->deduct_storage   = new App_Model_Region_MysqlDeductStorage($this->sid);

        if (!$this->shop) {
            $this->has_ready = false;
        }
    }
    /*
     * 检查店铺区域代理功能是否开通
     */
    public static function checkRegionOpen($sid) {
        //是否开通区域代理功能
        $flag   = App_Helper_PluginIn::checkShopRegionOpen($sid);
        if ($flag['code'] == 0) {
            return true;
        }
        return false;
    }

    /**
     * 创建订单提成佣金
     * @param array $trade 购买人ID
     * @return bool
     */
    public function createOrderDeduct($trade) {
        //获取地址信息
        $addr_model = new App_Model_Member_MysqlAddressStorage($this->sid);
        $address    = $addr_model->getRowByIdSid($trade['t_addr_id'], $this->sid);
        if ($address) {
            $addr_helper    = new App_Helper_Address();
            $region     = $addr_helper->getLevelRegion($address['ma_province'], $address['ma_city'], $address['ma_zone']);

            if (!$region) {
                //@todo 未查找记录信息
                Libs_Log_Logger::outputLog("地址信息映射失败");
                Libs_Log_Logger::outputLog($address);
                return false;
            }
            $agent_model    = new App_Model_Region_MysqlAgentStorage($this->sid);
            $cfg_model      = new App_Model_Region_MysqlCfgStorage($this->sid);
            $rgcfg      = $cfg_model->findShopCfg();
            //销售额==订单总价-运费
            $sale_amount= floatval($trade['t_total_fee']) - floatval($trade['t_post_fee']);
            //代理等级1省2市3区
            $indata     = array();
            $adrdata    = array();
            for ($i=1; $i<=3; $i++) {
                $rgid   = intval($region[$i]['region_id']);
                $agent  = $agent_model->fetchAgentByRegion($i, $rgid);
                $tmp    = $this->trade_region_tr[$i];
                $adrdata["rd_{$tmp}_name"]    = $region[$i]['region_name'];
                //代理商存在
                if ($agent) {
                    if ($agent['ra_m_id'] == $trade['t_m_id']) {
                        if (!$rgcfg['rc_is_deduct']) {
                            //内购不可分佣
                            continue;
                        }
                    }
                    $ratio  = floatval($rgcfg["rc_{$tmp}_ratio"]);
                    $indata["rd_{$tmp}_rid"]     = $agent['ra_m_id'];
                    $indata["rd_{$tmp}_ratio"]   = $ratio;
                    $indata["rd_{$tmp}_money"]   = ceil($sale_amount*$ratio)/100;
                }
            }
            //代理存在,不存在代理的订单不记录
            if (!empty($indata)) {
                $indata['rd_s_id']  = $this->sid;
                $indata['rd_tid']   = $trade['t_tid'];
                $indata['rd_sale_amount']   = $sale_amount;
                $indata['rd_m_id']  = $trade['t_m_id'];
                $indata['rd_status']= self::TRADE_REGION_NONE;
                $indata['rd_create_time']   = time();

                $indata     = array_merge($indata, $adrdata);
                $deduct_model   = new App_Model_Region_MysqlDeductStorage($this->sid);
                $deduct_model->insertValue($indata);
            }
        }
        return true;
    }
    /*
     * 订单状态更新时,发送提示信息
     * $tid 订单号
     * $mid 会员ID
     * $status 订单状态
     */
    public function updateOrderDeduct($trade) {

    }

    /*
     * 分配订单佣金
     * @param string $tid 订单号
     * @param $mid
     */
    public function completeOrderDeduct($trade) {
        //订单是否在区域代理佣金表存在
        $deduct_model   = new App_Model_Region_MysqlDeductStorage($this->sid);
        $deduct     = $deduct_model->fetchDeductByTid($trade['t_tid']);
        //佣金分配存在,且未返还
        if ($deduct && $deduct['rd_status'] == self::TRADE_REGION_NONE) {
            for ($i=1; $i<=3; $i++) {
                $tmp    = $this->trade_region_tr[$i];

                $mid    = $deduct["rd_{$tmp}_rid"];
                $money  = floatval($deduct["rd_{$tmp}_money"]);

                if ($mid && $money > 0) {
                    $dd_storage = new App_Model_Deduct_MysqlDeductDaybookStorage();
                    $indata = array(
                        'dd_s_id'       => $this->sid,
                        'dd_m_id'       => $mid,
                        'dd_o_id'       => 0,//订单id
                        'dd_tid'        => $trade['t_tid'],//订单编号
                        'dd_amount'     => $money,
                        'dd_level'      => $i,
                        'dd_record_type'=> self::DEDUCT_SHARE_INCOME,
                        'dd_record_time'=> time(),
                    );
                    $dd_storage->insertValue($indata);
                    //增加各级销售额,返现额,不增加自购销售额
                    $this->member_storage->incrementMemberAmount($mid, $deduct['rd_sale_amount'], $money);
                    App_Helper_Trade::recordMemberSales($this->sid, $mid, $trade['t_tid'], $deduct['rd_sale_amount'], $trade['t_m_id'], 0);
                    //增加各级可提现佣金额度
                    $this->member_storage->incrementMemberDeduct($mid, $money);
                }
            }
            //更新记录状态
            $updata = array('rd_status' => self::TRADE_REGION_HAD);
            $deduct_model->updateById($updata, $deduct['rd_id']);
        }
        return true;
    }
    /*
     * 退款收回订单佣金
     * @param string $tid 订单编号
     * @param int $mid 会员ID
     */
    public function refundOrderDeduct($trade) {
        Libs_Log_Logger::outputLog($trade);
        //订单是否在区域代理佣金表存在
        $deduct_model   = new App_Model_Region_MysqlDeductStorage($this->sid);
        $deduct     = $deduct_model->fetchDeductByTid($trade['t_tid']);
        //佣金分配存在
        if ($deduct) {
            //佣金已返回,需要扣除佣金
            if ($deduct['rd_status'] == self::TRADE_REGION_HAD) {
                for ($i=1; $i<=3; $i++) {
                    $tmp    = $this->trade_region_tr[$i];

                    $mid    = $deduct["rd_{$tmp}_rid"];
                    $money  = floatval($deduct["rd_{$tmp}_money"]);

                    if ($mid && $money > 0) {
                        $dd_storage = new App_Model_Deduct_MysqlDeductDaybookStorage();
                        $indata = array(
                            'dd_s_id'       => $this->sid,
                            'dd_m_id'       => $mid,
                            'dd_o_id'       => 0,//订单id
                            'dd_tid'        => $trade['t_tid'],//订单编号
                            'dd_amount'     => $money,
                            'dd_level'      => $i,
                            'dd_record_type'=> self::DEDUCT_REFUND_PAY,
                            'dd_record_time'=> time(),
                        );
                        $dd_storage->insertValue($indata);
                        $sale   = $deduct['rd_sale_amount'];
                        //减少各级销售额,返现额,不增加自购销售额
                        $this->member_storage->incrementMemberAmount($mid, -$sale, -$money);
                        App_Helper_Trade::recordMemberSales($this->sid, $mid, $trade['t_tid'], $sale, $trade['t_m_id'], 0, true);
                        //减少各级可提现佣金额度
                        $this->member_storage->incrementMemberDeduct($mid, -$money);
                    }
                }
            }
            //更新记录状态
            $updata = array('rd_status' => self::TRADE_REGION_BACK);
            $deduct_model->updateById($updata, $deduct['rd_id']);
        }
        return true;
    }
}