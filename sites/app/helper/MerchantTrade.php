<?php

class App_Helper_MerchantTrade {

    const TRADE_NO_CREATE_PAY       = 0;//没有创建支付交易,默认
    const TRADE_NO_PAY              = 1;//未付款、待付款
    const TRADE_WAIT_PAY_RETURN     = 2;//等待支付成功确认
    const TRADE_WAIT_GROUP          = 2;//等待成团,已支付,待组团成功
    const TRADE_HAD_PAY             = 3;//已支付、待核销
    const TRADE_FINISH              = 4;//交易完成、已核销
    const TRADE_CLOSED              = 5;//交易关闭
    const TRADE_REFUND              = 6;//退款交易


    const TRADE_GROUP       = 1;//拼团订单
    const TRADE_BARGAIN     = 2;//砍价订单
    const TRADE_SECKILL     = 3;//秒杀订单
    const TRADE_RESERVATION = 5;//预约订单

    const GROUP_TRADE_OVER_TIME = 86400;//拼团活动超时时间
    //const GROUP_TRADE_OVER_TIME = 60;//拼团活动超时时间

    public static $trade_status    = array(
        self::TRADE_NO_CREATE_PAY   => '未提交',
        self::TRADE_NO_PAY          => '未付款',
        self::TRADE_WAIT_GROUP      => '待成团',
        self::TRADE_HAD_PAY         => '待核销',
        self::TRADE_FINISH          => '已核销',
        self::TRADE_CLOSED          => '已关闭',
        self::TRADE_REFUND          => '已退款',
    );

    public static $group_trade_status    = array(
        self::TRADE_NO_CREATE_PAY   => '未提交',
        self::TRADE_NO_PAY          => '未付款',
        self::TRADE_WAIT_GROUP      => '待成团',
        self::TRADE_HAD_PAY         => '拼团成功',
        self::TRADE_FINISH          => '已核销',
        self::TRADE_CLOSED          => '拼团失败',
        self::TRADE_REFUND          => '已退款',
    );

    public static $refund_trade_status    = array(
        self::FEEDBACK_RESULT_WAIT   => '退款中',
        self::FEEDBACK_RESULT_REFUSE => '商家拒绝退款',
        self::FEEDBACK_RESULT_AGREE  => '已退款',
        self::FEEDBACK_RESULT_CANCEL => '买家撤销退款',
    );

    const FEEDBACK_NO                   = 0;//无维权
    const FEEDBACK_YES                  = 1;//有维权
    const FEEDBACK_OVER                 = 2;//维权结束

    const FEEDBACK_NO_SHIP_REFUND       = 1;//未发货,买家发起退款
    const FEEDBACK_HAD_SHIP_REFUND      = 2;//已发货,买家发起退款
    const FEEDBACK_HAD_ACCEPT_REFUND    = 3;//已收货,已完成,买家发起退款

    const FEEDBACK_REFUND_NO            = 0;//无退款操作
    const FEEDBACK_REFUND_SELLER        = 1;//等待商家处理的退款操作
    const FEEDBACK_REFUND_CUSTOMER      = 2;//等待买家处理的退款操作
    const FEEDBACK_REFUND_SOLVE         = 3;//退款操作已解决

    const FEEDBACK_RESULT_WAIT          = 0;//等待处理
    const FEEDBACK_RESULT_REFUSE        = 1;//拒绝退款
    const FEEDBACK_RESULT_AGREE         = 2;//同意退款
    const FEEDBACK_RESULT_CANCEL        = 3;//买家撤销维权

    const TRADE_SETTLED_PENDING         = 0;//结算订单进行中
    const TRADE_SETTLED_SUCCESS         = 1;//结算成功
    const TRADE_SETTLED_REFUND          = 2;//退款订单,结算失败

    const FEEDBACK_REFUND_HANDLE        = 1;// 退款订单已处理
    

    const TRADE_MESSAGE_SEND_MJXD   = 1;//买家下单
    const TRADE_MESSAGE_SEND_CFDD   = 2;//催付订单
    const TRADE_MESSAGE_SEND_ZFCG   = 3;//支付成功
    const TRADE_MESSAGE_SEND_MJFH   = 4;//卖家发货
    const TRADE_MESSAGE_SEND_MJSH   = 5;//买家收货
    const TRADE_MESSAGE_SEND_MJTK   = 6;//买家退款
    const TRADE_MESSAGE_SEND_TKCG   = 7;//退款成功
    const TRADE_MESSAGE_SEND_TKSB   = 8;//退款失败

    const TRADE_PAY_WXZFZY              = 1;//微信支付--自有
    const TRADE_PAY_WXZFDX              = 2;//微信支付--代销
    const TRADE_PAY_ZFBZFDX             = 3;//支付宝支付--代销
    const TRADE_PAY_HDFK                = 4;//货到付款
    const TRADE_PAY_YEZF                = 5;//余额支付
    const TRADE_PAY_YHQM                = 6;//优惠全免
    const TRADE_PAY_JFZF                = 7;//积分支付
    const TRADE_PAY_XJZF                = 8;//现金支付
    const TRADE_PAY_HHZF                = 9;//混合支付 微信+余额支付

    public static $trade_pay_type       = array(
        self::TRADE_PAY_WXZFZY  => '微信支付--自有',
        self::TRADE_PAY_WXZFDX  => '微信支付--代销',
        self::TRADE_PAY_ZFBZFDX => '支付宝支付--代销',
        self::TRADE_PAY_HDFK    => '货到付款',
        self::TRADE_PAY_YEZF    => '余额支付',
        self::TRADE_PAY_YHQM    => '优惠全免',
        self::TRADE_PAY_XJZF    => '现金支付',
        self::TRADE_PAY_JFZF    => '积分支付',
        self::TRADE_PAY_HHZF    => '微信支付+余额抵扣'
    );
    // 对用户展示使用
    public static $trade_pay_type_note       = array(
        self::TRADE_PAY_WXZFZY  => '微信支付',
        self::TRADE_PAY_WXZFDX  => '微信支付',
        self::TRADE_PAY_ZFBZFDX => '支付宝支付',
        self::TRADE_PAY_HDFK    => '货到付款',
        self::TRADE_PAY_YEZF    => '余额支付',
        self::TRADE_PAY_YHQM    => '优惠全免',
        self::TRADE_PAY_XJZF    => '现金支付',
        self::TRADE_PAY_HHZF    => '微信支付+余额抵扣'
    );
    /*
     * 店铺ID
     */
    private $sid;
    //生成图片存储实际路径
    private $hold_dir;
    //生成图片访问路径
    private $access_path;
    /*
     * 店铺数据，字段名参考pre_shop
     */
    private $shop;

    public function __construct($sid = 0){
        $this->sid  = $sid;

        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $this->shop = $shop_model->getRowById($sid);
        $this->hold_dir     = PLUM_APP_BUILD.'/spread/';
        $this->access_path  = PLUM_PATH_PUBLIC.'/build/spread/';
    }
    /*
     * 关闭超时未支付的订单
     * $tid 订单ID,非订单号
     */
    public function closeOvertimeTrade($tid,$currSid) {
        Libs_Log_Logger::outputLog('商家岛订单自动关闭');
        $trade_model= new App_Model_Merchant_MysqlMerchantTradeStorage($currSid);
        $trade      = $trade_model->getRowById($tid);
        if (!$trade) {
            return false;
        }
        if ($trade['mt_status'] < self::TRADE_WAIT_GROUP) {
            Libs_Log_Logger::outputLog('修改商家岛订单状态至关闭');
            $updata = array(
                'mt_status'  => self::TRADE_CLOSED,
            );
            return $trade_model->updateById($updata, $trade['mt_id']);
        }
        return false;
    }
    /*
     * 完成超时未确认订单
     * @param int $tid 订单自增ID,非订单编号
     */
    public function completeOvertimeTrade($tid,$currSid) {
        Libs_Log_Logger::outputLog('商家岛订单自动完成');
        $trade_model= new App_Model_Merchant_MysqlMerchantTradeStorage($currSid);
        $trade      = $trade_model->getRowById($tid);
        $tradeSid   = $trade['mt_s_id'];
        //订单查找失败
        if (!$trade) {
            return false;
        }
        //订单处于已发货状态
        if ($trade['t_status'] == self::TRADE_HAD_PAY ) {
            Libs_Log_Logger::outputLog('修改商家岛订单状态至完成');
            $trade_redis    = new App_Model_Trade_RedisTradeStorage( $tradeSid);
            $trade_redis->delMerchantTradeFinish($trade['mt_id']);
            //清除待结算状态
            $settled_model  = new App_Model_Merchant_MysqlMerchantTradeSettledStorage( $tradeSid);
            $settled        = $settled_model->findSettledByTid($trade['t_tid']);
            if ($settled && $settled['mts_status'] == self::TRADE_SETTLED_PENDING) {
                $trade_redis->delMerchantTradeSettledTtl($settled['mts_id']);
                $this->recordSuccessSettled($settled['mts_id'], $tradeSid);

            }
            //修改状态
            $updata = array(
                'mt_status'      => self::TRADE_FINISH,//置于完成状态
                'mt_finish_time' => time(),
            );
            return $trade_model->updateById($updata, $trade['mt_id']);
        }
        return false;
    }


    /*
     * 检查店铺是否有微信支付功能
     */
    public static function checkHasWxpay($sid) {
        $paytype_model  = new App_Model_Trade_MysqlPayTypeStorage($sid);

        $paytype    = $paytype_model->findUpdateCfgBySid();
        if ($paytype && $paytype['pt_wxpay_zy']) {
            return true;
        }
        return false;
    }
    /*
     * 检查店铺的微信支付是否上传证书
     */
    public static function checkHasUploadCert($sid) {
        $wxpay_model    = new App_Model_Auth_MysqlWeixinPayStorage($sid);
        $paycfg     = $wxpay_model->findRowPay();

        if ($paycfg && $paycfg['wp_sslcert'] && $paycfg['wp_sslkey']) {
            if (file_exists(PLUM_DIR_ROOT.$paycfg['wp_sslcert']) && file_exists(PLUM_DIR_ROOT.$paycfg['wp_sslkey'])) {
                return true;
            }
        }
        return false;
    }

    /*
     * 调整订单中商品库存数量或秒杀商品的秒杀数量
     * $tid 为交易表自增索引
     */
    public function adjustTradeGoodsStock($tid) {
        $order_model    = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
        $list   = $order_model->fetchOrderListByTid($tid);

        $goods_model    = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        foreach ($list as $item) {
            //减少库存量

              $goods_model->adjustStock($item['to_g_id'], -$item['to_num'], $item['to_gf_id']);


        }
    }

    /*
     * 增加培训课程的报名人数
     */
    public function adjustTradeCourseApply($tid){
        $order_model    = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
        $list   = $order_model->fetchOrderListByTid($tid);
        $course_model = new App_Model_Train_MysqlTrainCourseStorage($this->sid);
        foreach ($list as $item){
            $course_model->incrementField('atc_apply',$item['to_g_id'],$item['to_num']);
        }

    }

    /*
     * 记录待结算交易
     * $tid 为订单号
     */
    public function recordPendingSettled($tid, $amount, $title, $curr_sid) {
        $settled_model  = new App_Model_Merchant_MysqlMerchantTradeSettledStorage($curr_sid);

        $indata     = array(
            'mts_s_id'       => $curr_sid,
            'mts_title'      => $title,
            'mts_tid'        => $tid,
            'mts_amount'     => $amount,
            'mts_status'     => self::TRADE_SETTLED_PENDING,//进行中
            'mts_create_time'=> time(),
            'mts_update_time'=> time()
        );

        $tsid  = $settled_model->insertValue($indata);

        //设置待结算订单完成倒计时
        $countdown  = plum_parse_config('trade_overtime');
        $trade_redis    = new App_Model_Trade_RedisTradeStorage($curr_sid);
        $trade_redis->setTradeSettledTtl($tsid, $countdown['settled']);
    }
    
    /*
     * 修改待结算交易为成功
     */
    public function recordSuccessSettled($tsid,$currSid) {
        $settled_model  = new App_Model_Merchant_MysqlMerchantTradeSettledStorage($currSid);
        $settled    = $settled_model->findUpdateSettled($tsid);
        if (!$settled || $settled['mts_status'] != self::TRADE_SETTLED_PENDING) {
            return;
        }
        //获取订单状态
        $trade_model    = new App_Model_Merchant_MysqlMerchantTradeStorage();
        $trade  = $trade_model->findUpdateTradeByTid($settled['mts_tid']);

        $updata = array(
            'mts_status'     => self::TRADE_SETTLED_SUCCESS,
            'mts_update_time'=> time(),
        );
        $settled_model->findUpdateSettled($tsid, $updata);

        //todo 记录收入
        $inout_model = new App_Model_Merchant_MysqlMerchantShopInoutStorage($currSid);
        //todo 更新余额

    }



    /*
     * 产品销量改动
     * $tid 订单ID,非订单号
     */
    public function modifyGoodsSold($tid) {
        $order_model    = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);

        $order  = $order_model->fetchOrderListByTid($tid);
        $goods_model    = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
        foreach ($order as $item) {
            $goods_model->incrementGoodsSold(intval($item['to_g_id']), intval($item['to_num']));
            //修改规格商品销量
            if ($item['to_gf_id']) {
                $format_model->incrementGoodsSold($item['to_gf_id'], $item['to_g_id'], intval($item['to_num']));
            }
        }
    }
    /*
     * 付款成功后对不同类型交易进行处理
     */
    public function dealTradeType($trade) {
        set_time_limit(0);
        $type   = intval($trade['mt_type']);
        $tradeSid = $trade['mt_s_id'];
        $trade_model    = new App_Model_Merchant_MysqlMerchantTradeStorage($tradeSid);
        $activity_model = new App_Model_Merchant_MysqlMerchantActivityStorage($tradeSid);
        //将订单从超时处理队列中移除
        $trade_redis    = new App_Model_Trade_RedisTradeStorage($tradeSid);
        $trade_redis->delMerchantTradeClose($trade['mt_id']);
        //处理不同类型订单
        //$applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->shop['s_id']);
        //$cfg        = $applet_cfg->findShopCfg();
        $trade_status = self::TRADE_HAD_PAY;
        switch ($type){
            case self::TRADE_SECKILL://秒杀
                $this->_deal_seckill_order($trade);
                break;
            case self::TRADE_RESERVATION://预约
                //增加活动销量
                $activity_model->incrementActivityField('ma_sold',$trade['mt_a_id'],$trade['mt_num']);

                break;
            case self::TRADE_GROUP://拼团
                $trade_status = $this->_deal_lottery_order($trade);
                break;
            case self::TRADE_BARGAIN://砍价
                $this->_deal_bargain_order($trade);
                break;
        }
        //生成订单核销码
        $filename = $trade['mt_m_id'].'-'.$trade['mt_tid']. '.png';
        $text = $trade['mt_tid'];
        Libs_Qrcode_QRCode::png($text, $this->hold_dir . $filename, 'Q', 6, 1);

        //TODO 订单支付相关通知

        //修改支付完成状态
        $trade_model->findUpdateTradeByTid($trade['mt_tid'],array('mt_status' => $trade_status, 'mt_qrcode' => $this->access_path.$filename));

    }

    //完成订单
    private function _finish_order($tid){
        $trade_model    = new App_Model_Merchant_MysqlMerchantTradeStorage();
        $trade = $trade_model->findUpdateTradeByTid($tid);
        $tradeSid = $trade['mt_s_id'];
        // 判断订单状态是否是待收货状态
        if($trade['mt_status'] == self::TRADE_HAD_PAY){
            $updata = array(
                'mt_finish_time' => time(),
                'mt_status'      => self::TRADE_FINISH,//置于完成状态
            );

            //清除自动完成状态定时
            $trade_redis    = new App_Model_Trade_RedisTradeStorage($tradeSid);
            $trade_redis->delMerchantTradeFinish($trade['mt_id']);
            //清除待结算状态
            $settled_model  = new App_Model_Merchant_MysqlMerchantTradeSettledStorage($tradeSid);
            $settled        = $settled_model->findSettledByTid($trade['mt_tid']);
            if ($settled && $settled['mts_status'] == self::TRADE_SETTLED_PENDING) {
                $this->recordSuccessSettled($settled['mts_id'],$tradeSid);
                $trade_redis->delMerchantTradeSettledTtl($settled['mts_id']);

            }
            $ret = $trade_model->findUpdateTradeByTid($trade['mt_tid'], $updata);
        }
        $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
        $orderList = $order_model->fetchOrderListByTid($trade['t_id']);
        // 在已购表里添加一条记录
        $buy_model = new App_Model_Knowpay_MysqlKnowpayBuyStorage($this->sid);
        $insertData = array(
            'akb_s_id' => $this->sid,
            'akb_m_id' => $trade['t_m_id'],
            'akb_t_id' => $trade['t_id'],
            'akb_g_id' => $orderList[0]['to_g_id'],
            'akb_create_time' => time()
        );
        $buy_model->insertValue($insertData);
    }



    //处理小程序类型的砍价订单
    private function _deal_bargain_order($trade){
        //设置参与者已购买
        $bargain_helper = new App_Helper_BargainActivity($trade['mt_s_id']);
        $bargain_helper->updateMerchantJoinerBuy($trade['mt_bj_id']);
    }


    //处理秒杀订单
    private function _deal_seckill_order($trade){
        $tradeSid = $trade['mt_s_id'];

        $record_model   = new App_Model_Merchant_MysqlMerchantLimitRecordStorage($tradeSid);
        $indata = [
            'mlr_s_id' => $tradeSid,
            'mlr_m_id' => $trade['mt_m_id'],
            'mlr_a_id' => $trade['mt_a_id'],
            'mlr_num' => $trade['mt_num'],
            'mlr_create_time' => time(),
        ];
        $record_model->insertValue($indata);
        //增加活动销量
        $activity_model = new App_Model_Merchant_MysqlMerchantActivityStorage($tradeSid);
        $activity_model->incrementActivityField('ma_sold',$trade['mt_a_id'],$trade['mt_num']);

    }

    //处理拼团订单
    private function _deal_lottery_order($trade){
        $extra  = json_decode($trade['mt_extra_data'], true);
        $actid  = intval($trade['mt_a_id']);

        if(isset($extra['singleBuy']) && $extra['singleBuy'] == 1){
            //单独购买拼团活动
            $trade_status = self::TRADE_HAD_PAY;
        }else{
            $trade_model    = new App_Model_Merchant_MysqlMerchantTradeStorage($trade['mt_s_id']);
            $mem_model  = new App_Model_Merchant_MysqlMerchantGroupMemStorage($trade['mt_s_id']);
            $where_test[] = array('name' => 'mgm_tid', 'oper' => '=', 'value' => $trade['mt_tid']);
            $exist  = $mem_model->getRow($where_test);
            if ($exist) {
                return false;
            }
            $org_model  = new App_Model_Merchant_MysqlMerchantGroupOrgStorage($trade['mt_s_id']);

            //获取拼团活动详情
            $group_model    = new App_Model_Merchant_MysqlMerchantActivityStorage($trade['mt_s_id']);
            $group      = $group_model->getActivityRow($actid);
            $group_model->incrementActivityField('ma_sold',$actid,1);

            $group_redis    = new App_Model_Group_RedisOrgStorage($trade['mt_s_id']);
            $group_helper   = new App_Helper_Group($trade['mt_s_id']);
            //拼团成功标识
            $pintuan_success    = false;
            $kaituan_success    = false;

            if ($extra['ishead']) {//团长活动
                $indata = array(
                    'mgo_s_id'       => $trade['mt_s_id'],
                    'mgo_tz_mid'     => $trade['mt_m_id'],
                    'mgo_tz_nick'    => $trade['mt_buyer_nick'],
                    'mgo_a_id'      => $actid,
                    'mgo_total'      => intval($group['mgc_total']),
                    'mgo_had'        => 1,
                    'mgo_status'     => 0,//进行中
                    'mgo_create_time'=> time(),
                );
                $gbid   = $org_model->insertValue($indata);
                //创建开团成功定时任务
                $group_redis->merchantRecordOvertimeTask($gbid, self::GROUP_TRADE_OVER_TIME);

                $kaituan_success    = true;
            } else {//团员参与
                $gbid   = intval($extra['gbid']);//组团活动ID
                $org    = $org_model->getRowByIdSid($gbid, $trade['mt_s_id']);
                if (($org['mgo_had'] + 1) >= $group['mgc_total']) {
                    $updata = array(
                        'mgo_had'    => $org['mgo_had'] + 1,
                        'mgo_status' => App_Helper_Group::GROUP_STATUS_SUCCESS,//成功
                        'mgo_over_time'  => time(),//完成时间
                    );
                    //成功时删除已设置的拼团定时
                    $group_redis->merchantDeleteOvertimeTask($gbid);

                    $pintuan_success    = true;
                } else {
                    $updata = array(
                        'mgo_had'    => $org['mgo_had'] + 1
                    );
                }
                $org_model->updateById($updata, $gbid);
            }
            //写入组员信息
            $zyindata   = array(
                'mgm_s_id'       => $trade['mt_s_id'],
                'mgm_mgo_id'      => $gbid,
                'mgm_a_id'      => $actid,
                'mgm_m_id'        => $trade['mt_m_id'],
                'mgm_tid'        => $trade['mt_tid'],
                'mgm_is_tz'      => $extra['ishead'],
                'mgm_join_time'  => time(),
            );

            $mem_model->insertValue($zyindata);

            if ($pintuan_success) {//拼团成功
                $joiner = $mem_model->fetchJoinList($gbid);
                $mids   = array();
                //设置当前所有订单状态为待发货
                $updata = array(
                    'mt_status'  => App_Helper_MerchantTrade::TRADE_HAD_PAY,
                );
                foreach ($joiner as $item) {
                    if ($item['mgm_tid'] && !$item['mgm_is_robot']) {
                        $trade_model->findUpdateTradeByTid($item['mgm_tid'], $updata);
                        $mids[] = intval($item['mgm_m_id']);
                    }
                }
                //设置当前订单状态为拼团成功
                $trade_status   = $updata['mt_status'];
                //成功后修改库存量
                $activity_model = new App_Model_Merchant_MysqlMerchantActivityStorage($this->sid);
                $activity_model->incrementActivityField('ma_sold',$group['ma_id'],$trade['mt_num']);
                //todo 拼团成功通知

            } else {//等待拼团成功
                //设置当前订单状态为待成团
                $trade_status   = self::TRADE_WAIT_GROUP;
            }
        }
        return $trade_status;
    }

    /*
     * 处理交易完成的订单
     */
    public function dealCompleteTrade($trade) {
        $type   = intval($trade['t_type']);
        switch ($type) {
            //普通类型订单交易完成
            case self::TRADE_NORMAL :
                //是否开通区域代理功能
                if (App_Helper_OrderRegion::checkRegionOpen($this->sid)) {
                    $order_region   = new App_Helper_OrderRegion($this->sid);
                    $order_region->completeOrderDeduct($trade);
                }
                break;
        }
        //短信通知
        $sms_helper = new App_Helper_Sms($this->sid);
        $sms_helper->sendNoticeSms($trade, 'ddwctz');
    }
    /*
     * 处理退款成功后的订单
     */
    public function dealRefundTrade($trade) {
        $type   = intval($trade['t_type']);
        switch ($type) {
            //普通类型订单交易完成
            case self::TRADE_NORMAL :
                //是否开通区域代理功能
                if (App_Helper_OrderRegion::checkRegionOpen($this->sid)) {
                    $order_region   = new App_Helper_OrderRegion($this->sid);
                    $order_region->refundOrderDeduct($trade);
                }
                //是否开通积分商城功能
                if (App_Helper_Point::checkPointOpen($this->sid)) {
                    $point_helper   = new App_Helper_Point($this->sid);
                    $point_helper->goodsRefundPoint($trade);
                }
                break;
        }
    }

    /*
     * 检查店铺是否可退款 （微商城使用）
     * @param int $pay_type 订单支付方式
     * @param float $refund_amount 要求退款金额
     * @param string $tid 订单编号
     */
    public function checkTradeRefund($pay_type, $refund_amount, $tid = null) {
        $return = null;
        $type   = intval($pay_type);

        switch ($type) {
            //微信支付自有
            case self::TRADE_PAY_WXZFZY :
                //获取微信支付配置
                $wxpay_storage  = new App_Model_Auth_MysqlWeixinPayStorage($this->sid);
                $wx_pay   = $wxpay_storage->findRowPay();
                if (!$wx_pay || strlen($wx_pay['wp_mchkey']) != 32) {
                    $return =  array(
                        'errno'     => -2,
                        'errmsg'    => "微信支付配置中支付商户号及API秘钥填写错误。",
                    );
                    break;
                }

                if (!$wx_pay['wp_sslcert'] || !$wx_pay['wp_sslkey']) {
                    $return = array(
                        'errno'     => -3,
                        'errmsg'    => "微信支付配置中未上传证书。",
                    );
                    break;
                }
                $return = array(
                    'errno'     => 0,
                    'errmsg'    => "微信支付配置正确。请确保微信商户平台余额大于退款金额，商户平台余额低于退款金额将退款失败，"."<a href='https://pay.weixin.qq.com/index.php/core/cashmanage/fund_withdraw' target=_blank >查看余额</a>"
                );
                break;
            //微信支付代销
            case self::TRADE_PAY_WXZFDX :
            //支付宝支付
            case self::TRADE_PAY_ZFBZFDX :
                //获取结算记录
                $settled_model  = new App_Model_Trade_MysqlTradeSettledStorage($this->sid);
                $settled        = $settled_model->findSettledByTid($tid);
                //已成功结算的订单
                if ($settled && $settled['ts_status'] == 1) {
                    $balance    = floatval($this->shop['s_balance']);//店铺收益余额
                    $recharge   = floatval($this->shop['s_recharge']);//店铺通天币

                    $recharge_span  = "<a href='/manage/index/index#recharge&amount={$refund_amount}'>充值</a>";

                    if ($balance < $refund_amount && $recharge < $refund_amount) {
                        $return = array(
                            'errno'     => -4,
                            'errmsg'    => "您的平台账户可用余额{{$recharge}}元, 少于本次退款金额{$refund_amount}元, 请前往{$recharge_span}。",
                        );
                    } else {
                        $return = array(
                            'errno'     => 0,
                            'errmsg'    => "您的店铺收益余额为{$balance}元, 平台账户可用余额为{{$recharge}}元。本次退款将优先扣除店铺收益余额,如果不足,将扣除平台账户可用余额。",
                        );
                    }
                } else {
                    //未进入待结算的代销或已退款的代销,不扣除余额
                    $return = array(
                        'errno'     => 0,
                        'errmsg'    => '',
                    );
                }
                break;
            //货到付款
            case self::TRADE_PAY_HDFK :
            //余额支付
            case self::TRADE_PAY_YEZF :
            //优惠全免
            case self::TRADE_PAY_YHQM :
                $return = array(
                    'errno'     => 0,
                    'errmsg'    => ""
                );
                break;
        }
        return $return;
    }
    /*
 * 检查店铺是否可退款 （小程序专用）
 * @param int $pay_type 订单支付方式
 * @param float $refund_amount 要求退款金额
 * @param string $tid 订单编号
 */
    public function checkAppletTradeRefund($pay_type, $refund_amount, $tid = null,$trade=array()) {
        $return = null;
        $type   = intval($pay_type);
        $tradeSid = $trade ? $trade['mt_s_id'] : 0;
        switch ($type) {
            //微信支付自有
            case self::TRADE_PAY_WXZFZY :
                //获取小程序微信支付配置
                $wxpay_storage  = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
                $wx_pay   = $wxpay_storage->findRowPay();
                if (!$wx_pay || strlen($wx_pay['ap_mchkey']) != 32) {
                    $return =  array(
                        'errno'     => -2,
                        'errmsg'    => "微信支付配置中支付商户号及API秘钥填写错误。",
                    );
                    break;
                }

                if (!$wx_pay['ap_sslcert'] || !$wx_pay['ap_sslkey']) {
                    $return = array(
                        'errno'     => -3,
                        'errmsg'    => "微信支付配置中未上传证书。",
                    );
                    break;
                }
                $return = array(
                    'errno'     => 0,
                    'errmsg'    => "微信支付配置正确。请确保微信商户平台余额大于退款金额，商户平台余额低于退款金额将退款失败，"."<a href='https://pay.weixin.qq.com/index.php/core/cashmanage/fund_withdraw' target=_blank >查看余额</a>"
                );
                break;
            //微信支付代销
            case self::TRADE_PAY_WXZFDX :
                //获取结算记录
                $settled_model  = new App_Model_Merchant_MysqlMerchantTradeSettledStorage($tradeSid);
                $settled        = $settled_model->findSettledByTid($tid);
                //已成功结算的订单
                if ($settled && $settled['mts_status'] == 1) {

                } else {
                    //未进入待结算的代销或已退款的代销,不扣除余额
                    $return = array(
                        'errno'     => 0,
                        'errmsg'    => '',
                    );
                }
                break;
            //货到付款
            case self::TRADE_PAY_HDFK :
                //余额支付
            case self::TRADE_PAY_YEZF :
                //优惠全免
            case self::TRADE_PAY_YHQM :
                $return = array(
                    'errno'     => 0,
                    'errmsg'    => ""
                );
                break;
        }
        return $return;
    }

    /*
     * 发送订单状态消息
     */
    public function sendTradeStatusMessage($tid, $type) {
        $type   = intval($type);
        $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade  = $trade_model->findUpdateTradeByTid($tid);
        $weixin_type    = App_Helper_ShopWeixin::checkWeixinVerifyType($this->sid);

        if (!$trade) {
            return;
        }
        $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
        $member         = $member_model->getRowById($trade['t_m_id']);
        $openid     = $member['m_openid'];
        $mobile     = $member['m_mobile'];

        $message_model  = new App_Model_System_MysqlMessageStorage($this->sid);

        $message_default    = plum_parse_config('message', 'message');
        $trade_message      = $message_default['3'];

        $kind1      = 3;
        $kind2      = 17+$type;
        //数据库中查找配置
        $sm     = $message_model->fetchUpdateByKindId($kind1, $kind2);
        $tpl    = $sm ? $sm['sm_content'] : $trade_message[$kind2]['default'];
        $reg    = $trade_message[$kind2]['usable'];
        $val    = array($trade['t_tid'], $this->shop['s_name'], $trade['t_title']);

        $msg    = App_Helper_Tool::messageContentReplace($reg, $val, $tpl);
        
        $open   = $sm ? array('wxkf' => $sm['sm_wxkf_open'], 'sms' => $sm['sm_sms_open'], 'wxtpl' => $sm['sm_wxtpl_open']) : plum_parse_config('send', 'message');
        //微信客服消息发送, 仅认证服务号
        if ($open['wxkf'] && $openid && $weixin_type == App_Helper_ShopWeixin::WX_VERIFY_YRZFWH) {
            $weixin_client  = new App_Plugin_Weixin_ClientPlugin($this->sid);
            $weixin_client->sendTextMessage($openid, $msg);
        }
        //短信发送
        if ($open['sms'] && $mobile) {
            $sms_helper = new App_Helper_Sms($this->sid);
            $usable     = $sms_helper->checkUsableSms();
            if ($usable > 0) {
                $quxun_helper   = new App_Plugin_Sms_QuXunPlugin();
                $sms_ret        = $quxun_helper->sendSms($mobile, $msg);

                if ($sms_ret) {
                    $sms_helper->recordSendSms($mobile, $member['m_id'], $msg);
                }
            }
        }
        //模板消息发送, 仅认证服务号
        if ($open['wxtpl'] && $sm && $sm['sm_wxtpl_id'] && $openid && $weixin_type == App_Helper_ShopWeixin::WX_VERIFY_YRZFWH) {
            $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($sm['sm_wxtpl_id']);

            if ($tplmsg) {
                //替换订单数据
                $tpl    = $tplmsg['wt_data'];
                $jump   = $tplmsg['wt_url'];
                list($tpl, $jump)    = $this->replaceTradeTpl($trade, $tpl, $jump);

                $weixin_client  = new App_Plugin_Weixin_ClientPlugin($this->sid);
                $tpl = json_decode($tpl, true);
                $jump   = plum_is_url($jump) ? $jump : '';
                $ret = $weixin_client->sendTemplateMessage($openid, $tplmsg['wt_tplid'], $jump, $tpl);
            }
        }

    }

    /*
     * 订单发货逻辑处理
     * $tid 订单编号；
     * $company : 物流公司；
     * $code : 物流单号；
     * $need : 是否需要物流；
     * $express : 快递公司编号
     */
    /*
     * 处理自动退款订单
     * @param int $tid 订单主键ID
     */
    public function dealAutoRefund($tid,$currSid) {
        $trade_model= new App_Model_Merchant_MysqlMerchantTradeStorage($currSid);
        $trade      = $trade_model->getRowById($tid);

        if (!$trade) {
            return;
        }
        //维权中的订单
        if ($trade['mt_refund'] == self::FEEDBACK_YES) {
            //等待商家处理的维权到期
            if ($trade['mt_refund_status'] == self::FEEDBACK_REFUND_SELLER) {
                //商家到期未处理,设置自动退款
                $this->merchantDealRefund($tid);
            } else if ($trade['mt_refund_status'] == self::FEEDBACK_REFUND_CUSTOMER) {//等待买家处理的维权到期

                $updata = array(
                    'mt_refund'    => self::FEEDBACK_OVER,
                    'mt_refund_status'   => self::FEEDBACK_REFUND_SOLVE,
                    'mt_refund_result'   => self::FEEDBACK_RESULT_CANCEL,//买家撤销
                );
                $trade_model->updateById($updata, $tid);

            }
        }
    }





    /*
     * 小程序处理退款逻辑
     * $tid:订单编号
     * $status : 1拒绝退款，2同意退款
     * $note : 退款备注
     */
    public function appletHandleRefund($tid,$status,$note){
        $result = array(
            'ec' => 400,
            'em' => '退款处理失败'
        );;
        $trade_model = new App_Model_Merchant_MysqlMerchantTradeStorage();
        $row = $trade_model->findUpdateTradeByTid($tid);
        $tradeSid = $row['mt_s_id'];
        if(!empty($row) && in_array($status,array(1,2))){
            if($row['mt_refund'] == 0){
                $updata = array(
                    'mt_refund'        => App_Helper_MerchantTrade::FEEDBACK_YES,
                    'mt_refund_status'       => App_Helper_MerchantTrade::FEEDBACK_REFUND_SELLER,//待商家处理
                );
                $trade_model->findUpdateTradeByTid($tid, $updata);
                //创建退款申请
                $refund_model   = new App_Model_Merchant_MysqlMerchantTradeRefundStorage($tradeSid);
                $indata = array(
                    'mtr_s_id'       => $tradeSid,
                    'mtr_wid'        => App_Plugin_Weixin_PayPlugin::makeMchOrderid('W'),
                    'mtr_tid'        => $tid,
                    'mtr_reason'     => '',
                    'mtr_contact'    => '',
                    'mtr_money'      => $row['mt_payment'],
                    'mtr_create_time'=> time(),
                );
                $refund_model->insertValue($indata);
            }
            $row = $trade_model->findUpdateTradeByTid($tid);

            //@todo 1有维权；2维权结束，拒绝退款的，再给机会同意退款
            //if($row['t_feedback'] == self::FEEDBACK_YES || ($row['t_feedback'] == self::FEEDBACK_OVER && $row['t_fd_result'] == self::FEEDBACK_RESULT_REFUSE && $status == self::FEEDBACK_RESULT_AGREE)){
            if($row['mt_refund'] == self::FEEDBACK_YES && $row['mt_refund_status']==self::FEEDBACK_REFUND_SELLER){
                $trade_redis    = new App_Model_Trade_RedisTradeStorage($this->sid);
                if($status == self::FEEDBACK_RESULT_AGREE){ //同意退款
                    $trade_ret    = self::merchantDealRefund($row['mt_id']);
                    //@todo 已完成订单，若同意退款，则收回佣金
                    if($trade_ret && $trade_ret['code'] == 'success'){

                        // 同意退款清除定时任务
                        $trade_redis->delMerchantTradeRefundTtl($row['mt_id']);

                        // 发送订单状态信息
                        //self::sendTradeStatusMessage($tid, self::TRADE_MESSAGE_SEND_TKCG);
                        $result = array(
                            'ec' => 200,
                            'em' => '退款处理成功'
                        );
                    }else{
                        $result['em'] = $trade_ret['msg'];
                    }
                }elseif($status == self::FEEDBACK_RESULT_REFUSE){ //拒绝退款
                    //@todo 修改交易状态
                    $set = array(
                        'mt_refund_result' => $status,
                        'mt_refund_status'  => self::FEEDBACK_REFUND_CUSTOMER,
                    );
                    $trade_ret = $trade_model->findUpdateTradeByTid($tid,$set);
                    //@todo 修改退款状态
                    $refund = array(
                        'mtr_seller_note' => $note,
                        'mtr_note_time'   => time(),
                        'mtr_status'      => $status,
                    );
                    // 卖家拒绝重新设置定时任务
                    $overtime   = plum_parse_config('trade_overtime');
                    $trade_redis->setMerchantTradeRefundTtl($row['mt_id'], $overtime['refund']);
                    $refund_model = new App_Model_Merchant_MysqlMerchantTradeRefundStorage($tradeSid);
                    //获取最新一条维权订单信息
                    $refund_new = $refund_model->getLastRecord($tid);
                    // 修改最近一次维权订单信息
                    $refund_model->findUpdateByTrid($refund_new['mtr_id'],$refund);
                    // 发送订单状态信息
                    //self::sendTradeStatusMessage($tid, self::TRADE_MESSAGE_SEND_TKSB);
                    //短信通知买家订单已拒绝退款
                    //$sms_helper = new App_Helper_Sms($this->sid);
                    //$sms_helper->sendNoticeSms($row, 'jjtktz');
                    if($trade_ret){
                        $result = array(
                            'ec' => 200,
                            'em' => '退款处理成功'
                        );
                    }
                }
            }
        }
        return $result;
    }

    /*
     * 检查店铺是否可退款 （小程序入驻店铺专用）
     * @param int $pay_type 订单支付方式
     * @param float $refund_amount 要求退款金额
     * @param string $tid 订单编号
     */
    public function checkAppletEnterShopTradeRefund($pay_type, $refund_amount,$tid,$esid) {
        $return = null;
        $type   = intval($pay_type);

        switch ($type) {
            //微信支付
            case self::TRADE_PAY_WXZFDX :
                //获取小程序微信支付配置
                $wxpay_storage  = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
                $wx_pay   = $wxpay_storage->findRowPay();
                if (!$wx_pay || strlen($wx_pay['ap_mchkey']) != 32) {
                    $return =  array(
                        'errno'     => -2,
                        'errmsg'    => "微信支付配置中支付商户号及API秘钥填写错误。",
                    );
                    break;
                }

                if (!$wx_pay['ap_sslcert'] || !$wx_pay['ap_sslkey']) {
                    $return = array(
                        'errno'     => -3,
                        'errmsg'    => "微信支付配置中未上传证书。",
                    );
                    break;
                }
                $return = array(
                    'errno'     => 0,
                    'errmsg'    => "微信支付配置正确。请确保微信商户平台余额大于退款金额，商户平台余额低于退款金额将退款失败，"
                );
                break;
            //余额支付
            case self::TRADE_PAY_YEZF :
                $settled_model  = new App_Model_Trade_MysqlTradeSettledStorage($this->sid);
                $settled    = $settled_model->findSettledByTid($tid);
                //未找到结算,或已退款结算
                if (!$settled || $settled['ts_status'] == self::TRADE_SETTLED_REFUND) {
                    $return = array(
                        'errno'     => -4,
                        'errmsg'    => "该订单已退款结算"
                    );
                }
                //已成功结算的交易,退款时,判断店铺余额是否充足
                if ($settled['ts_status'] == self::TRADE_SETTLED_SUCCESS) {
                    $enterShop_model = new App_Model_Entershop_MysqlEnterShopStorage();
                    $enterShop = $enterShop_model->getRowById($esid);
                    //需要判断店铺余额
                    if ($enterShop) {
                        Libs_Log_Logger::outputLog("店铺余额不足以支撑退款金额,sid={$this->sid}");
                        return false;
                    }
                }
                $return = array(
                    'errno'     => 0,
                    'errmsg'    => ""
                );
                break;
            //货到付款
            case self::TRADE_PAY_HDFK :
                //优惠全免
            case self::TRADE_PAY_YHQM :
                $return = array(
                    'errno'     => 0,
                    'errmsg'    => ""
                );
                break;
        }
        return $return;
    }

    /*
  * 处理退款  （同意退款处理）(新的接口返回错误提示)
  * @param $t_id 订单自增ID,非订单编号
  * @param string $param_type id 或 tid
  * @return
  */
    public function merchantDealRefund($t_id, $param_type = 'id',$note='') {
        $trade_model    = new App_Model_Merchant_MysqlMerchantTradeStorage();
        if ($param_type == 'id') {
            $trade      = $trade_model->getTradeRow($t_id);
        } else {
            $trade      = $trade_model->getTradeRow(0,$t_id);
        }
        $tradeSid = $trade['mt_s_id'] ? $trade['mt_s_id'] : 0;
        $refund_model   = new App_Model_Merchant_MysqlMerchantTradeRefundStorage($tradeSid);
        $refund     = $refund_model->getLastRecord($trade['mt_tid']);
        if (!$trade || !$refund) {
            $refund_state   = array(
                'code' => 'fail',
                'msg'  => '订单不存在或退款申请不存在',
            );
            return $refund_state;
        }
        // 判断退款是否已处理
        if($refund['mtr_status']!=0){   // 退款已经处理
            $refund_state   = array(
                'code' => 'fail',
                'msg'  => '退款已经处理完成',
            );
            return $refund_state;
        }
        $trade_redis    = new App_Model_Trade_RedisTradeStorage($tradeSid);
        //要求退款金额大于总金额
        if ($trade['mt_total'] < $refund['tr_money']) {
            $refund_state   = array(
                'code' => 'fail',
                'msg'  => '退款金额不符',
            );
            return $refund_state;
        }
        //判断是否可退款
        $verify = $this->checkAppletTradeRefund($trade['mt_pay_type'], $refund['mtr_money'], $trade['mt_tid'],$trade);
        //退款失败
        if ($verify['errno'] < 0) {
            $refund_state   = array(
                'code' => 'fail',
                'msg'  =>  $verify['errmsg'],
            );
            return $refund_state;
        }
        //判断退款方式
        switch ($trade['mt_pay_type']) {
            //微信支付自有
            case self::TRADE_PAY_WXZFZY :
                // 判断是否是服务商模式下支付
                $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
                $appcfg = $appletPay_Model->findRowPay();

                if($appcfg && $appcfg['ap_sub_pay']==1){
                    $subPay_storage = new App_Plugin_Weixin_AppletSubPay($this->sid);
                    $ret = $subPay_storage->appletRefundPayOrder($appcfg['ap_appid'],$trade['mt_pay_trade_no'], $refund['mtr_wid'], $trade['mt_total'], $refund['mtr_money'], 'wx');

                }else{
                    //发起微信退款
                    $new_pay    = new App_Plugin_Weixin_NewPay($this->sid);
                    $ret = $new_pay->appletRefundPayOrder($trade['mt_pay_trade_no'], $refund['mtr_wid'], $trade['mt_total'], $refund['mtr_money'], 'wx');

                }

                if(!$ret || $ret['code']!='SUCCESS' ){
                    return array(
                        'code' => 'fail',
                        'msg'  => $ret['errmsg'],
                    );
                }
                break;
            //货到付款
            case self::TRADE_PAY_HDFK :
                //退款无任何操作
                break;
            //余额支付
            case self::TRADE_PAY_YEZF :
                //增加会员金币
                App_Helper_MemberLevel::goldCoinTrans($this->sid, $trade['mt_m_id'], $refund['mtr_money']);
                break;
            //优惠全免
            case self::TRADE_PAY_YHQM :
                //退款无操作
                break;
        }
        //$this->dealRefundTrade($trade);//退款成功后的处理
        //设置订单为退款订单
        $trupdata   = array(
            'mt_status'      => self::TRADE_REFUND,
            'mt_refund'    => self::FEEDBACK_OVER,//维权结束
            'mt_refund_result'   => self::FEEDBACK_RESULT_AGREE,// 同意退款
            'mt_refund_status'   => self::FEEDBACK_REFUND_SOLVE,  // 维权解决
        );
        $trade_model->updateById($trupdata, $trade['mt_id']);
        //成功退款，标注退款成功
        $tr_set = array(
            'mtr_seller_note' => $note,
            'mtr_status'      => self::FEEDBACK_REFUND_HANDLE, //  商家已处理
            'mtr_finish_time' => time(),
        );
        $refund_model->updateById($tr_set,$refund['mtr_id']);
        $this->afterRefund($trade,$refund);
        //plum_open_backend('index', 'refundTempl', array('sid' => $this->shop['s_id'], 'tid' => $trade['mt_tid']));
        return array(
                'code' => 'success',
                'msg'  => '退款处理成功',
        );
    }


    //退款后续
    private function afterRefund($trade,$refund){
        Libs_Log_Logger::outputLog('开始退款后续');
        $t_id = $trade['mt_id'];
        $tradeSid = $trade['mt_s_id'];
        $settled_model  = new App_Model_Merchant_MysqlMerchantTradeSettledStorage($tradeSid);
        $trade_redis    = new App_Model_Trade_RedisTradeStorage($tradeSid);
        $settled    = $settled_model->findSettledByTid($trade['mt_tid']);
        Libs_Log_Logger::outputLog($settled);
        //未找到结算,或已退款结算
        if (!$settled || $settled['mts_status'] == self::TRADE_SETTLED_REFUND) {
            return array(
                'code' => 'fail',
                'msg'  => '未找到结算,或已退款结算',
            );
        }
        //清除订单的自动结算
        $trade_redis->delMerchantTradeSettledTtl($t_id);
        //已成功结算的交易,退款
        if ($settled['mts_status'] == self::TRADE_SETTLED_SUCCESS) {
            $title      = "订单{$trade['mt_tid']}退款, 扣除余额";
            //$refundMoney = floatval($refund['mtr_money']);
            //记录支出流水
            $inout_model    = new App_Model_Merchant_MysqlMerchantShopInoutStorage($tradeSid);
            $outdata    = array(
                'msi_s_id'   => $tradeSid,
                'msi_name'   => $title,
                'msi_amount' => $refund['mtr_money'],
                'msi_type'   => 2,
                'msi_create_time'    => time(),
            );
            $inout_model->insertValue($outdata);
        }
        //修改待结算交易为已退款状态
        $updata = array(
            'mts_status'     => self::TRADE_SETTLED_REFUND,
            'mts_update_time'=> time(),
        );
        $settled_model->findUpdateSettled($settled['mts_id'], $updata);

    }

}