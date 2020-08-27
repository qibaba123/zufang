<?php

class App_Helper_Legwork {

    //订单状态
    const TRADE_NO_PAY          = 1;//待付款
    const TRADE_WAIT_PAY_RETURN = 2;//等待支付成功确认
    const TRADE_HAD_PAY         = 3;//已支付
    const TRADE_HAD_TAKE        = 4;//已接单
    const TRADE_HAD_GET         = 5;//已取货/买货
    const TRADE_FINISH          = 6;//已完成
    const TRADE_CLOSED          = 7;//已关闭
    const TRADE_REFUND          = 8;//退款交易

    //支付方式
    const TRADE_PAY_WXZFZY      = 1;//微信支付--自有
    const TRADE_PAY_YEZF        = 5;//余额支付
    const TRADE_PAY_YHQM        = 6;//优惠全免

    const TRADE_PAY_WXZFDX              = 2;//微信支付--代销
    const TRADE_PAY_ZFBZFDX             = 3;//支付宝支付--代销
    const TRADE_PAY_HDFK                = 4;//货到付款
    const TRADE_PAY_JFZF                = 7;//积分支付
    const TRADE_PAY_XJZF                = 8;//现金支付
    const TRADE_PAY_HHZF                = 9;//混合支付 微信+余额支付

    //订单类型
    const TRADE_TYPE_BUY        = 1;//代买
    const TRADE_TYPE_RECEIVE    = 2;//代取
    const TRADE_TYPE_SEND       = 3;//代送

    //订单类型描述
    public static $trade_type_note_single = [
        self::TRADE_TYPE_BUY => '买',
        self::TRADE_TYPE_RECEIVE => '取',
        self::TRADE_TYPE_SEND => '送',
    ];

    //订单类型描述
    public static $trade_status_note = [
        self::TRADE_NO_PAY => '待支付',
        self::TRADE_HAD_PAY => '待骑手接单',
        self::TRADE_HAD_TAKE => '待取货',
        self::TRADE_HAD_GET => '已取货',
        self::TRADE_FINISH => '已完成',
        self::TRADE_CLOSED => '已取消',
        self::TRADE_REFUND => '已退款',
    ];

    public static $trade_pay_type       = array(
        self::TRADE_PAY_WXZFZY  => '微信支付',
        self::TRADE_PAY_WXZFDX  => '微信支付--代销',
        self::TRADE_PAY_ZFBZFDX => '支付宝支付--代销',
        self::TRADE_PAY_HDFK    => '货到付款',
        self::TRADE_PAY_YEZF    => '余额支付',
        self::TRADE_PAY_YHQM    => '优惠全免',
        self::TRADE_PAY_XJZF    => '现金支付',
        self::TRADE_PAY_JFZF    => '积分支付',
        self::TRADE_PAY_HHZF    => '微信支付+余额抵扣'
    );

    const WITHDRAW_WAY_WX = 1;
    const WITHDRAW_WAY_ZFB = 2;
    const WITHDRAW_WAY_BANK = 3;

    //提现类型描述
    public static $withdraw_note_single = [
        self::WITHDRAW_WAY_WX => '微',
        self::WITHDRAW_WAY_ZFB => '支',
        self::WITHDRAW_WAY_BANK => '卡',
    ];

    //提现类型描述
    public static $withdraw_note = [
        self::WITHDRAW_WAY_WX => '微信转账',
        self::WITHDRAW_WAY_ZFB => '支付宝转账',
        self::WITHDRAW_WAY_BANK => '银行卡转账',
    ];

    CONST CANCEL_SAFE_TIME = 60; //订单支付后可随意取消的时间


    /**
     * @var array
     * 交易状态菜单链接
     */
    public static $trade_link_status    = array(
        'all'   => array(
            'id'    => 0,
            'label' => '全部'
        ),
        'nopay'   => array(
            'id'    => self::TRADE_NO_PAY ,
            'label' => '待付款'
        ),
       // 'tuan'   => array(
       //     'id'    => self::TRADE_WAIT_PAY_RETURN ,
       //     'label' => '待成团'
       // ),
        'hadpay'   => array(
            'id'    => self::TRADE_HAD_PAY,
            'label' => '待接单'
        ),
        'take'   => array(
            'id'    => self::TRADE_HAD_TAKE,
            'label' => '已接单'
        ),
        'get'   => array(
            'id'    => self::TRADE_HAD_GET,
            'label' => '已取货'
        ),
        'finish'   => array(
            'id'    => self::TRADE_FINISH,
            'label' => '已完成'
        ),
        'closed'   => array(
            'id'    => self::TRADE_CLOSED,
            'label' => '已关闭'
        ),
    );



    /*
     * 店铺ID
     */
    private $sid;
    /*
     * 店铺数据，字段名参考pre_shop
     */
    private $shop;

    //生成图片存储实际路径
    private $hold_dir;
    //生成图片访问路径
    private $access_path;

    private $member_model;
    public function __construct($sid){
        $this->sid  = $sid;
        //获取店铺信息
        $shop_storage   = new App_Model_Shop_MysqlShopCoreStorage();
        $this->shop     = $shop_storage->getRowById($sid);
        $this->member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $this->hold_dir     = PLUM_APP_BUILD.'/spread/';
        $this->access_path  = PLUM_PATH_PUBLIC.'/build/spread/';
    }

    /*
     * 获得取消订单的惩罚金额
     */
    public function _get_cancel_punish_money($trade){
        //获得跑腿配置
        $punishMoney = 0;
        $cfg_model = new App_Model_Legwork_MysqlLegworkCfgStorage($this->sid);
        $cfg = $cfg_model->findUpdateBySid();
        //除了代买商品费用其余都计算违约金
        $postFee = $trade['alt_payment'] - $trade['alt_goods_fee'];
        if($cfg['alc_cancel_punish_percent'] > 0){
            $punishMoney = round($postFee * (floatval($cfg['alc_cancel_punish_percent'])/100),2);
            //如果计算的违约金小于最低违约金，以最低违约金为准
            if($cfg['alc_cancel_punish_min'] > 0 && $punishMoney < $cfg['alc_cancel_punish_min']){
                $punishMoney = $cfg['alc_cancel_punish_min'];
            }
        }
        //如果总配送费小于违约金，则将配送费全部计入违约金
        if($punishMoney > $postFee){
            $punishMoney = $postFee;
        }

        return $punishMoney;
    }

    /*
     * 处理不同类型的跑腿订单
     */
    public function dealTradeType($trade){
        $type = $trade['alt_type'];
        $tid = $trade['alt_tid'];
        $cfg_model = new App_Model_Legwork_MysqlLegworkCfgStorage($this->sid);
        $cfg = $cfg_model->findUpdateBySid();
        //删除订单自动关闭
        $trade_redis    = new App_Model_Trade_RedisTradeStorage($this->sid);
        $trade_redis->delLegworkTradeClose($trade['alt_id']);
        //生成订单核销码
        $filename = $trade['alt_m_id'].'-'.$trade['alt_code']. '.png';
        $text = $trade['alt_code'];
        Libs_Qrcode_QRCode::png($text, $this->hold_dir . $filename, 'Q', 6, 1);
        //修改订单完成状态
        $cantCancelTime = $cfg['alc_cant_cancel_time'] ? time() + intval($cfg['alc_cant_cancel_time']) + self::CANCEL_SAFE_TIME: 0;
        $set = [
            'alt_status' => self::TRADE_HAD_PAY,
            'alt_qrcode' => $this->access_path.$filename,
            'alt_cant_cancel_time' => $cantCancelTime
        ];
        $trade_model = new App_Model_Legwork_MysqlLegworkTradeStorage($this->sid);
        $trade_model->findUpdateTradeByTid($tid,$set);

        //设置无人接单自动取消订单定时
        if($cfg['alc_auto_cancel_time'] > 0){
            $overTime = $cfg['alc_auto_cancel_time'] * 3600;
            $trade_redis->setLegworkTradeCancelTtl($trade['alt_id'], $overTime);
        }



        //todo 发送通知
        plum_open_backend('templmsg', 'sendLegworkTempl', array('sid' => $this->sid, 'tid' => $trade['alt_tid'], 'type' => 'legwork_pay'));
        //提醒在工作中的骑手有新订单了
        $jiguang_model = new App_Helper_JiguangPush($this->sid);
        $jiguang_model->pushNotice($jiguang_model::LEGWORK_NEW_TRADE,$trade,'',true);
    }
    /*
    * 处理退款  （同意退款处理）(新的接口返回错误提示)
    * @param $t_id 订单自增ID,非订单编号
    * @param string $param_type id 或 tid
    * @return
    */
    public function appletDealRefund($t_id, $param_type = 'id',$punish = false) {
        $trade_model    = new App_Model_Legwork_MysqlLegworkTradeStorage($this->sid);
        $wid = '';
        if ($param_type == 'id') {
            $trade      = $trade_model->getRowById($t_id);
        } else {
            $trade      = $trade_model->findUpdateTradeByTid($t_id);
        }
        if (!$trade) {
            $refund_state   = array(
                'code' => 'fail',
                'msg'  => '订单不存在',
            );
            return $refund_state;
        }
        if($trade['alt_refund_finish'] == 1) {
            $refund_state   = array(
                'code' => 'fail',
                'msg'  => '退款已经处理完成',
            );
            return $refund_state;
        }

        $refundMoney = $trade['alt_payment'];
        $punishMoney = 0;
        if($punish){
            $punishMoney = $this->_get_cancel_punish_money($trade);
            $refundMoney = $refundMoney - $punishMoney;
        }


        //判断是否可退款
        $verify = $this->checkAppletTradeRefund($trade['alt_pay_type'],$refundMoney);

        //退款失败
        if ($verify['errno'] < 0) {
            $refund_state   = array(
                'code' => 'fail',
                'msg'  =>  $verify['errmsg'],
            );
            return $refund_state;
        }
        $refund_state   = array(
            'code' => 'success',
            'msg'  => '退款处理成功',
            'refundMoney'=> $refundMoney,
            'punishMoney'=> $punishMoney
        );

        //判断退款方式
        if($refundMoney > 0){
            switch ($trade['alt_pay_type']) {
                //微信支付自有
                case App_Helper_Trade::TRADE_PAY_WXZFZY :
                    //发起微信退款
                    $wid = App_Plugin_Weixin_PayPlugin::makeMchOrderid('W');
                    // $ret = $new_pay->appletRefundPayOrder($trade['alt_pay_trade_no'], $wid, $trade['alt_payment'], $refundMoney, 'wx');

                    // 增加服务商模式退款
                    // zhangzc
                    // 2019-09-18
                    $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
                    $appcfg = $appletPay_Model->findRowPay();
                    if($appcfg && $appcfg['ap_sub_pay']==1){
                        $subPay_storage = new App_Plugin_Weixin_AppletSubPay($this->sid);
                        $ret = $subPay_storage->appletRefundPayOrder($appcfg['ap_appid'],$trade['alt_pay_trade_no'], $wid, $trade['alt_payment'], $refundMoney, 'wx');
                        // 如果服务商模式退款处理失败，尝试普通商户退款
                        if($ret['code']!='SUCCESS'){
                            //发起微信退款
                            $new_pay    = new App_Plugin_Weixin_NewPay($this->sid);
                            $ret = $new_pay->appletRefundPayOrder($trade['alt_pay_trade_no'], $wid, $trade['alt_payment'], $refundMoney, 'wx');
                        }
                    }else{
                        //发起微信退款
                        $new_pay    = new App_Plugin_Weixin_NewPay($this->sid);
                        $ret = $new_pay->appletRefundPayOrder($trade['alt_pay_trade_no'], $wid, $trade['alt_payment'], $refundMoney, 'wx');
                    }
                    
                    if(!$ret || $ret['code']!='SUCCESS' ){
                        $refund_state = array(
                            'code' => 'fail',
                            'msg'  => $ret['errmsg'],
                        );
                    }

                    break;
                //货到付款
                case App_Helper_Trade::TRADE_PAY_HDFK :
                    //退款无任何操作
                    break;
                //余额支付
                case App_Helper_Trade::TRADE_PAY_YEZF :
                    //增加会员金币
                    $coin_res = App_Helper_MemberLevel::goldCoinTrans($this->sid, $trade['alt_m_id'], $refundMoney);
                    //记录收入
                    if($coin_res){
                        $record_storage = new App_Model_Member_MysqlRechargeStorage($this->sid);
                        //消费记录保存
                        $indata = array(
                            'rr_tid'        => $trade['alt_tid'],
                            'rr_s_id'       => $this->sid,
                            'rr_m_id'       => $trade['alt_m_id'],
                            'rr_amount'     => 0,
                            'rr_gold_coin'  => $refundMoney,
                            'rr_status'     => 1,//标识金币增加
                            'rr_pay_type'   => 10,//订单退款
                            'rr_remark'     => '订单退款',
                            'rr_create_time'=> time(),
                        );
                        $record_storage->insertValue($indata);
                    }
                    break;
                //优惠全免
                case App_Helper_Trade::TRADE_PAY_YHQM :
                    //退款无操作
                    break;
            }
        }

        if ($refund_state['code'] == 'success') {
            //$this->dealRefundTrade($trade);//退款成功后的处理
            //设置订单为退款订单
            $trupdata   = array(
                'alt_status' => self::TRADE_CLOSED,
                'alt_refund_wid'    => $wid,
                'alt_refund_finish'    => 1,//维权结束

            );
            $trade_model->updateById($trupdata, $trade['alt_id']);

            //如果有惩罚，将惩罚金额作为骑手补偿
            if($punish && $punishMoney > 0 && $trade['alt_rider'] > 0){
                $taxFee = 0;
                $post_percent = floatval($trade['alt_post_percent']);
                if($post_percent > 0){
                    $taxFee = round($punishMoney*$post_percent/100,2);
                }
                $punishMoney = $punishMoney - $taxFee;

                //惩罚金额作为骑手补贴
                $insert_income = [
                    'alri_s_id' => $this->sid,
                    'alri_rider' => $trade['alt_rider'],
                    'alri_tid' => $trade['alt_tid'],
                    'alri_t_type' => $trade['alt_type'],
                    'alri_money' => $punishMoney,
                    'alri_post_fee' => 0,
                    'alri_tip_fee' => 0,
                    'alri_format_fee' => 0,
                    'alri_tax_fee' => $taxFee,
                    'alri_income_type' => 3,
                    'alri_create_time' => time()
                ];
                $income_model = new App_Model_Legwork_MysqlLegworkRiderIncomeStorage($this->sid);
                $income_res = $income_model->insertValue($insert_income);
                if($income_res){
                    //记录可提现金额
                    $rider_model = new App_Model_Legwork_MysqlLegworkRiderStorage($this->sid);
                    $rider_model->incrementRiderField($trade['alt_rider'],$punishMoney,'alr_income_ktx');
                }

            }
        }

        return $refund_state;
    }

    /*
* 检查店铺是否可退款 （小程序专用）
* @param int $pay_type 订单支付方式
* @param float $refund_amount 要求退款金额
* @param string $tid 订单编号
*/
    public function checkAppletTradeRefund($pay_type, $refund_amount = 0, $tid = null) {
        $return = null;
        $type   = intval($pay_type);

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
     * 替换订单模板
     */
    public function replaceLegworkTradeTpl($replace, $tpl) {
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($replace as $key=>$val){
            $replace[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval  = array(
            $replace['tid'],$replace['totalFee'],$replace['createTime'],$replace['type'],$replace['status'],$replace['toAddress'],$replace['fromAddress'],$replace['riderName'],$replace['riderMobile'],$replace['takeTime'],$replace['getTime'],$replace['finishTime'],$replace['cancelTime'],$replace['cancelType'],$replace['refundMoney'],$replace['note']
        );
        $tplreg   = $cfg[35];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 替换邀请模板
     */
    public function replaceShareTpl($infor, $tpl ){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($infor as $key=>$val){
            $infor[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval  = array(
            $infor['member'],$infor['time'], $infor['money'],$infor['total']
        );
        $tplreg   = $cfg[36];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /*
     * 超时关闭订单
     */
    public function closeOvertimeTrade($id){
        $trade_model = new App_Model_Legwork_MysqlLegworkTradeStorage($this->sid);
        $trade = $trade_model->getRowById($id);
        if(!$trade){
            return false;
        }
        if($trade['alt_status'] == self::TRADE_NO_PAY){
            Libs_Log_Logger::outputLog('开始执行跑腿执行超时关闭');
            //退还交易中使用的优惠券
            $this->_back_coupon($trade);
            //修改订单状态
            $set = [
                'alt_status' => self::TRADE_CLOSED,
                'alt_cancel_done_time' => time()
            ];
            $res = $trade_model->updateById($set,$id);
            return $res;
        }
        return false;

    }


    /*
     * 取消订单
     */
    public function cancelOvertimeTrade($id){
        $trade_model = new App_Model_Legwork_MysqlLegworkTradeStorage($this->sid);

//        Libs_Log_Logger::outputLog('执行自动取消订单1','test.log');
//        Libs_Log_Logger::outputLog($id,'test.log');
//        Libs_Log_Logger::outputLog($this->sid,'test.log');

        $row = $trade_model->getRowById($id);

        $res = 0;
        $timeNow = time();
        $overtime = 0;
        if($row['alt_overtime_time'] > 0 && $timeNow > $row['alt_overtime_time']){
            $overtime = 1;
        }
        $set = [
            'alt_status' => self::TRADE_CLOSED,
            'alt_cancel_done_time' => $timeNow,
            'alt_cancel_type' => 1,
            'alt_is_overtime' => $overtime
        ];
        if($row){
            if($row['alt_status'] == self::TRADE_HAD_PAY){
                //先退款
                $refund = $this->appletDealRefund($row['alt_id']);
                if($refund['code'] == 'success'){
                    $res = $trade_model->findUpdateTradeByTid($row['alt_tid'],$set);
                }
            }
            if($res){
                plum_open_backend('templmsg', 'sendLegworkTempl', array('sid' => $this->sid, 'tid' => $row['alt_tid'], 'type' => 'legwork_cancel'));
            }
        }
    }


    /*
     * 退还优惠券
     */
    private function _back_coupon($trade){
        $trade_coupon   = new App_Model_Trade_MysqlTradeCouponStorage($this->sid);
        $coupon_use     = $trade_coupon->findCouponByTid($trade['alt_tid']);
        if ($coupon_use) {
            $coupon_receive = new App_Model_Coupon_MysqlReceiveStorage();
            $updata = array('cr_is_used' => 0);
            $coupon_receive->updateCouponReceive($coupon_use['tc_rc_id'], $trade['alt_m_id'], $this->sid, $updata);
        }
    }

    /*
     * 骑手垫付记录
     */
    public function _save_rider_pay($riderId,$trade){
        $insert = [
            'alrp_s_id' => $this->sid,
//                            'alrp_m_id' => $this->manager['alr_m_id'],
            'alrp_rider' => $riderId,
            'alrp_tid' => $trade['alt_tid'],
            'alrp_money' => $trade['alt_goods_fee'],
            'alrp_create_time' => time()
        ];
        $alrp_model = new App_Model_Legwork_MysqlLegworkRiderPayStorage($this->sid);
        $alrp_model->insertValue($insert);

        //增加可提现费用
        $rider_model = new App_Model_Legwork_MysqlLegworkRiderStorage($this->sid);
        $rider_model->incrementRiderField($riderId,$trade['alt_goods_fee'],'alr_goodsfee_ktx');
    }

    /*
     * 骑手收入记录
     */
    public function _save_rider_income($riderId,$trade,$timeNow){
        $punishFee = 0;
        $taxFee = 0;//平台抽成
        $totalFee = floatval($trade['alt_basic_price']) + floatval($trade['alt_plus_price']) + floatval($trade['alt_tip_fee']) + floatval($trade['alt_format_price']) + floatval($trade['alt_time_fee']) + floatval($trade['alt_weight_fee']) + floatval($trade['alt_volume_fee']);

        $post_percent = floatval($trade['alt_post_percent']);
        if($post_percent > 0){
            $taxFee = round($totalFee*$post_percent/100,2);
        }
        $totalFeeTaxPaid = $totalFee - $taxFee;//扣除平台抽成的总费用

        $totalPost = floatval($trade['alt_basic_price']) + floatval($trade['alt_plus_price']);
        if($trade['alt_overtime_time'] > 0 && $trade['alt_overtime_time'] < $timeNow){
            $cfg_model = new App_Model_Legwork_MysqlLegworkCfgStorage($this->sid);
            $cfg = $cfg_model->findUpdateBySid();
            $percent = floatval($cfg['alc_overtime_punish']);
            $punishFee = round($totalFeeTaxPaid * ($percent/100),2);
        }
        $totalFeeTrue  = $totalFeeTaxPaid - $punishFee;
        //记录收入
        $insert_income = [
            'alri_s_id' => $this->sid,
//                                    'alri_m_id' => $rider['alr_m_id'],
            'alri_rider' => $riderId,
            'alri_tid' => $trade['alt_tid'],
            'alri_t_type' => $trade['alt_type'],
            'alri_money' => $totalFeeTrue,
            'alri_post_fee' => $totalPost,
            'alri_tip_fee' => $trade['alt_tip_fee'],
            'alri_format_fee' => $trade['alt_format_price'],
            'alri_tax_fee' => $taxFee,
            'alri_income_type' => 1,
            'alri_create_time' => $timeNow
        ];
        $income_model = new App_Model_Legwork_MysqlLegworkRiderIncomeStorage($this->sid);
        $income_model->insertValue($insert_income);

        if($punishFee > 0){
            //记录超时惩罚
            $insert_punish = [
                'alri_s_id' => $this->sid,
//                                    'alri_m_id' => $rider['alr_m_id'],
                'alri_rider' => $riderId,
                'alri_tid' => $trade['alt_tid'],
                'alri_t_type' => $trade['alt_type'],
                'alri_money' => $punishFee,
                'alri_post_fee' => $totalPost,
                'alri_tip_fee' => $trade['alt_tip_fee'],
                'alri_format_fee' => $trade['alt_format_price'],
                'alri_tax_fee' => $taxFee,
                'alri_income_type' => 2,
                'alri_create_time' => $timeNow
            ];
            $income_model->insertValue($insert_punish);
        }

        if($trade['alt_other_tid'] && $trade['alt_other_sid'] > 0){
            //记录其它店铺配送费
            $shop_post_model = new App_Model_Legwork_MysqlLegworkShopPostStorage($this->sid);
            $insert_post = [
                'alsp_s_id' => $this->sid,
                'alsp_other_sid' => $trade['alt_other_sid'],
                'alsp_other_esid' => $trade['alt_other_esid'],
                'alsp_tid' => $trade['alt_tid'],
                'alsp_other_tid' => $trade['alt_other_tid'],
                'alsp_rider_money' => $totalPost,
                'alsp_discount_money' => $trade['alt_other_discount'],
                'alsp_status' => 1,//未结算
                'alsp_create_time' => $timeNow
            ];
            $shop_post_model->insertValue($insert_post);
        }


        //记录可提现金额
        $rider_model = new App_Model_Legwork_MysqlLegworkRiderStorage($this->sid);
        $rider_model->incrementRiderField($riderId,$totalFeeTrue,'alr_income_ktx');

    }

    /*
     * 处理抢单逻辑
     */
    public function _deal_take_trade($trade,$riderId){
        $trade_model = new App_Model_Legwork_MysqlLegworkTradeStorage($this->sid);
        $timeNow = time();
        //获得配置信息
        $cfg_model = new App_Model_Legwork_MysqlLegworkCfgStorage($this->sid);
        $cfg = $cfg_model->findUpdateBySid();
        //获得骑手信息
        $rider_model = new App_Model_Legwork_MysqlLegworkRiderStorage($this->sid);
        $rider = $rider_model->getRowById($riderId);

        $cancelTime = $cfg['alc_cancel_time'] ? $timeNow + intval($cfg['alc_cancel_time']) : 0;
        $overtimeHour = intval($cfg['alc_overtime']);
//        $overtimeHour = 1/60;
        $overTime = $overtimeHour ? ($timeNow > $trade['alt_time'] ? $timeNow + $overtimeHour*3600 : $trade['alt_time'] + $overtimeHour*3600): 0;

        //平台抽成比例
        $cfg_percent = floatval($cfg['alc_post_percent']);
        $rider_percent = floatval($rider['alr_post_percent']);
        $postPercent = $rider_percent > 0 ? $rider_percent : ($cfg_percent > 0 ? $cfg_percent : 0);

        $set = [
            'alt_status' => self::TRADE_HAD_TAKE,
            'alt_rider' =>  $riderId,
            'alt_take_time' => $timeNow,
            'alt_cancel_time' => $cancelTime,
            'alt_overtime_time' => $overTime,
            'alt_post_percent' => $postPercent
        ];
        $res = $trade_model->findUpdateTradeByTid($trade['alt_tid'],$set);
        //如果有其它订单
        if($res && $trade['alt_other_tid'] && $trade['alt_other_sid']){
            $other_trade_model = new App_Model_Trade_MysqlTradeStorage($trade['alt_other_sid']);
            $other_trade_model->findUpdateTradeByTid($trade['alt_other_tid'],['t_status'=>self::TRADE_HAD_TAKE]);
        }

        return $res;
    }


    /*
     * 获得普通订单跑腿配送费用
     */
    public function _get_legwork_post_price($appid,$fromLat,$fromLng,$toLat,$toLng){
        $applet_model = new App_Model_Applet_MysqlCfgStorage();
        $where_applet[] = ['name'=>'ac_appid','oper'=>'=','value'=>$appid];
        $applet = $applet_model->getRow($where_applet);
        $legwork_sid = $applet['ac_s_id'];
        $distance = 0;
        if($fromLat && $fromLng && $toLat && $toLng && $legwork_sid){
            //获得两点间最短骑行距离
            $url = 'https://restapi.amap.com/v4/direction/bicycling?parameters';
            $params = array(
                'origin' => $fromLng.','.$fromLat,
                'destination' => $toLng.','.$toLat,
                'output'  => 'JSON',
                'key'     => plum_parse_config('mapKay')  //web服务key
            );
            $res = Libs_Http_Client::post($url,$params);
            $geoArr = json_decode($res,1);
            $mapDistance = floatval($geoArr['data']['paths'][0]['distance']);
            $distance = round($mapDistance/1000,3);
//            return $distance;
        }
        $data = array(
            'needSum' => false,
            'price'   => '',
            'basicDistance' => 0,
            'basicPrice' => 0,
            'plusDistance' => 0,
            'plusPrice' => 0
        );
        if($distance){
            //获得配送配置
            $cfg_model = new App_Model_Legwork_MysqlLegworkCfgStorage($legwork_sid);
            $cfg = $cfg_model->findUpdateBySid();
            $basicDistance = floatval($cfg['alc_basic_distance']);
            $basicPrice    = floatval($cfg['alc_basic_price']);
            $maxDistance   = floatval($cfg['alc_max_distance']);
            if($basicDistance > 0){
                if(($maxDistance > 0 && $maxDistance > $distance) || $maxDistance <= 0){
                    $data = array(
                        'needSum' => true,
                        'price'   => $basicPrice,
                        'basicDistance' => $basicDistance,
                        'basicPrice' => $basicPrice,
                        'plusDistance' => 0,
                        'plusPrice' => 0
                    );
                    if($basicDistance < $distance){
                        $plusDistance = floatval($cfg['alc_plus_distance']);
                        $plusPrice = floatval($cfg['alc_plus_price']);
                        if($plusDistance && $plusPrice){
                            $dif = $distance - $basicDistance;
                            $num = ceil($dif/$plusDistance);
                            $plusTotal = $num * $plusPrice;
                            $total = $basicPrice + $plusTotal;
                            $data = array(
                                'needSum' => true,
                                'price'   => $total,
                                'basicDistance' => $basicDistance,
                                'basicPrice' => $basicPrice,
                                'plusDistance' => $dif,
                                'plusPrice' => $plusTotal
                            );
                        }
                    }
                }else{
                    return array(
                        'errcode' => 400,
                        'msg' => "超出配送范围",
                    );
                }
            }
        }else{
            return array(
                'errcode' => 400,
                'msg' => "暂无法配送，请选择其他配送方式。",
            );
        }

        $data['distance'] = $distance;
        $data['fromLng'] = $fromLng;
        $data['fromLat'] = $fromLat;
        $data['toLng'] = $toLng;
        $data['toLat'] = $toLat;

        return array(
            'errcode' => 0,
            'msg' => "",
            'data' => $data
        );
    }

    /**
     * 跑腿营业时间检测
     * zhangzc
     * 2019-10-19
     * @return [type] [description]
     */
    private function shop_open_time_check($legwork_sid=0){
        // 跑腿获取营业时间
        $legworkcfg_model=new App_Model_Legwork_MysqlLegworkCfgStorage($legwork_sid?$legwork_sid:$this->sid);
        $legwork_cfg=$legworkcfg_model->findUpdateBySid();
        $open_time  = $legwork_cfg['alc_open_time']?strtotime($legwork_cfg['alc_open_time']):0;
        $close_time = $legwork_cfg['alc_close_time']?strtotime($legwork_cfg['alc_close_time']):0;
        $time_now=time();
        // 都为0的时候不进行判断
        if($open_time==0 && $close_time==0){
            return true;
        }else if ($open_time==0){
            if($time_now > $close_time)
                return false;
        }else if ($close_time==0){
            if($time_now < $open_time)
                return false;
        }else{
            if($open_time >= $close_time){
                $time_now=date('H:i:s',$time_now);
                if(($time_now < $legwork_cfg['alc_open_time'] ) && ($time_now > $legwork_cfg['alc_close_time'] )|| ($time_now > $legwork_cfg['alc_close_time']) && ($time_now < $legwork_cfg['alc_open_time']))
                    return false;
            }else{
                if($open_time > $time_now || $time_now > $close_time)
                    return false;
            }
        }
        return true;
    }

    /*
    * 获得普通订单跑腿配送费用
    */
    public function _get_legwork_post_price_new($appid,$fromLat,$fromLng,$toLat,$toLng,$type = 0){
        $applet_model = new App_Model_Applet_MysqlCfgStorage();
        $where_applet[] = ['name'=>'ac_appid','oper'=>'=','value'=>$appid];
        $applet = $applet_model->getRow($where_applet);
        $legwork_sid = $applet['ac_s_id'];
        $distance = 0;


        // 跑腿营业时间检测-不在营业时间内退出不进行订单推送
        if(!$this->shop_open_time_check($legwork_sid)){
            return array(
                'errcode' => 400,
                'msg' => "不在配送时间内",
            );
        }


//        if($this->sid == 11068){
//            Libs_Log_Logger::outputLog('fromLat--'.$fromLat,'test.log');
//            Libs_Log_Logger::outputLog('fromLng--'.$fromLng,'test.log');
//            Libs_Log_Logger::outputLog('toLat--'.$toLat,'test.log');
//            Libs_Log_Logger::outputLog('toLng--'.$toLng,'test.log');
//        }

        if($fromLat && $fromLng && $toLat && $toLng && $legwork_sid){
            //获得两点间最短骑行距离
            $url = 'https://restapi.amap.com/v4/direction/bicycling?parameters';
            $params = array(
                'origin' => $fromLng.','.$fromLat,
                'destination' => $toLng.','.$toLat,
                'output'  => 'JSON',
                'key'     => plum_parse_config('mapKay')  //web服务key
            );
            $res = Libs_Http_Client::post($url,$params);

//            if($this->sid == 11068){
//                Libs_Log_Logger::outputLog('-----------高德地图返回内容-----------','test.log');
//                Libs_Log_Logger::outputLog($res,'test.log');
//            }

            $geoArr = json_decode($res,1);
            $mapDistance = floatval($geoArr['data']['paths'][0]['distance']);
            $distance = round($mapDistance/1000,3);
//            return $distance;
        }
        $data = array(
            'needSum' => false,
            'price'   => '',
            'basicDistance' => 0,
            'basicPrice' => 0,
            'plusDistance' => 0,
            'plusPrice' => 0,
            'timePrice' => 0
        );

//        if($legwork_sid == 10043){
//            Libs_Log_Logger::outputLog('distance--'.$distance,'test.log');
//            Libs_Log_Logger::outputLog('max--'.$maxDistance,'test.log');
//        }

        if($distance){
            $type = $type > 0 ? (in_array($type,[2,3]) ? 2 : $type) : 0;//代取和代买使用同样配置
            $cfg_model = new App_Model_Legwork_MysqlLegworkPriceCfgStorage($legwork_sid);
            $cfg = $cfg_model->findUpdateBySid($type,1);
            //默认配置
            if(!$cfg){
                $cfg_model = new App_Model_Legwork_MysqlLegworkPriceCfgStorage($legwork_sid);
                $cfg = $cfg_model->findUpdateBySid();
            }

            //获得配送配置
//            if($this->sid == 10043){
//
//            }else{
//                $cfg_model = new App_Model_Legwork_MysqlLegworkCfgStorage($legwork_sid);
//                $cfg = $cfg_model->findUpdateBySid();
//            }

            $basicDistance = floatval($cfg['alc_basic_distance']);
            $basicPrice    = floatval($cfg['alc_basic_price']);
            $maxDistance   = floatval($cfg['alc_max_distance']);
            if($basicDistance > 0){

                if(($maxDistance > 0 && $maxDistance > $distance) || $maxDistance <= 0){
                    //获得特殊时段费用
                    $time_fee = 0;
                    $timeList = json_decode($cfg['alc_time_section'],1);
                    $now = time();
                    if(is_array($timeList)){
                        foreach ($timeList as $time_val){
                            if($now >= strtotime($time_val['min']) && $now < strtotime($time_val['max'])){
                                $time_fee = floatval($time_val['price']);
                                break;
                            }
                        }
                    }

                    $data = array(
                        'needSum' => true,
                        'price'   => $basicPrice + $time_fee,
                        'basicDistance' => $basicDistance,
                        'basicPrice' => $basicPrice,
                        'plusDistance' => 0,
                        'plusPrice' => 0,
                        'timePrice' => $time_fee,
                    );
                    if($basicDistance < $distance){
                        $dif = $plusDistance = $distance - $basicDistance;
                        $distanceList = json_decode($cfg['alc_distance_section'],1);
                        $plusTotal = 0;
                        if(!empty($distanceList) && is_array($distanceList)){
                            foreach ($distanceList as $key => &$val){
                                $val['min'] = $val['min'] + $basicDistance;
                                $val['max'] = $val['max'] + $basicDistance;
                            }
                            //将费用配置数组按最低费用从小到大排序
                            $min_column = array_column($distanceList,'min');
                            array_multisort($min_column,SORT_ASC,$distanceList);
                            $key_mate = 0;

                            //获得配送范围满足的最后一个区间
                            foreach ($distanceList as $k => $v){
                                if($distance > $v['min'] && $distance <= $v['max']){
                                    $key_mate = $k;
                                }
                            }
                            $diff = $distance - $basicDistance;
                            for ($i=0;$i<=$key_mate;$i++){
                                if($diff > 0){
                                    $row = $distanceList[$i];
                                    $section = $row['max'] - $row['min'];
                                    //
                                    if($diff >= $section){
                                        $plusTotal += $section * $row['price'];
                                        $diff = $diff - $section;
                                    }else{
                                        $plusTotal += ceil($diff) * $row['price'];
                                        $diff = 0;
                                    }
                                }else{
                                    break;
                                }
                            }
                        }

                        $total = $basicPrice + $plusTotal + $time_fee;
                        $data = array(
                            'needSum' => true,
                            'price'   => $total,
                            'basicDistance' => $basicDistance,
                            'basicPrice' => $basicPrice,
                            'plusDistance' => $plusDistance,
                            'plusPrice' => $plusTotal,
                            'timePrice' => $time_fee
                        );
                    }
                }else{
                    return array(
                        'errcode' => 400,
                        'msg' => "超出配送范围",
                    );
                }
            }
        }else{
            return array(
                'errcode' => 400,
                'msg' => "暂无法配送，请选择其他配送方式。。",
            );
        }

        $data['distance'] = $distance;
        $data['fromLng'] = $fromLng;
        $data['fromLat'] = $fromLat;
        $data['toLng'] = $toLng;
        $data['toLat'] = $toLat;

        return array(
            'errcode' => 0,
            'msg' => "",
            'data' => $data
        );
    }

    public function _deal_trade_verify($trade,$managerId = 0,$send = true){
        $trade_model = new App_Model_Legwork_MysqlLegworkTradeStorage($this->sid);
        $legwork_helper = new App_Helper_Legwork($this->sid);

        //如果有其它订单,优先判断其它订单
        if($trade['alt_other_tid'] && $trade['alt_other_sid'] > 0){
//                $order_controller = new App_Controller_Wxapp_OrderController();
            $other_res = $this->finish_other_order($trade['alt_other_tid'],$trade['alt_other_sid']);
            if($other_res['ec'] == 400){
                return $other_res;
            }
        }
        //计算耗时
        $timeNow = time();
        $overtime = 0;
        if($trade['alt_overtime_time'] > 0 && $timeNow > $trade['alt_overtime_time']){
            $overtime = 1;
        }
        $costTime = $timeNow - $trade['alt_take_time'];
        $set = [
            'alt_status' => App_Helper_Legwork::TRADE_FINISH,
            'alt_finish_time' => $timeNow,
            'alt_cost_time' => $costTime,
            'alt_is_overtime' => $overtime
        ];
        $res = $trade_model->updateById($set,$trade['alt_id']);
        if($res){
            if($trade['alt_type'] == 1 && $trade['alt_goods_fee'] > 0){
                //记录垫付
                $legwork_helper->_save_rider_pay($managerId,$trade);
            }

            if($trade['alt_basic_price'] > 0  || $trade['alt_plus_price'] > 0 || $trade['alt_tip_fee'] > 0 || $trade['alt_format_price'] > 0 || $trade['alt_weight_fee'] > 0 || $trade['alt_time_fee'] > 0 || $trade['alt_volume_fee'] > 0){
                //记录收入
                $legwork_helper->_save_rider_income($managerId,$trade,$timeNow);
            }
            //todo 发通知
            if($send){
                plum_open_backend('templmsg', 'sendLegworkTempl', array('sid' => $this->sid, 'tid' => $trade['alt_tid'], 'type' => 'legwork_finish'));
            }


            // 跑腿完成订单后-更新用户成交的订单数量
            // zhangzc
            // 2019-09-17
            $member_model=new App_Model_Member_MysqlMemberCoreStorage();
            $member_model->incrementMemberTrade($trade['alt_m_id'],$trade['alt_payment']);
            return true;

        }else{
            return false;
        }
    }

    public function finish_other_order($tid = 0,$sid = 0){
        $result = array(
            'ec' => 400,
            'em' => '请求数据错误'
        );

        $trade_model= new App_Model_Trade_MysqlTradeStorage($sid);
        $trade      = $trade_model->findUpdateTradeByTid($tid);

        $cfg_model = new App_Model_Applet_MysqlCfgStorage($sid);
        $wxapp_cfg = $cfg_model->findShopCfg();
        if($trade){
//            // 有维权处理且未处理完成
            if($trade['t_fd_status'] > 0 && $trade['t_fd_status'] != 3){
                $result = array(
                    'ec' => 400,
                    'em' => '订单有未完成的退款处理'
                );
                return $result;
            }

            // 判断订单状态是否是待收货或已支付状态
            if($trade['t_status'] == App_Helper_Trade::TRADE_SHIP || $trade['t_status'] == App_Helper_Trade::TRADE_HAD_PAY || ($trade['t_express_method'] == 7 && $trade['t_status'] == App_Helper_Legwork::TRADE_HAD_GET)){
                $updata = array(
                    't_finish_time' => time(),
                    't_status'      => App_Helper_Trade::TRADE_FINISH,//置于完成状态
                );

                $trade_helper   = new App_Helper_Trade($sid);
                //清除自动完成状态定时
                $trade_redis    = new App_Model_Trade_RedisTradeStorage($sid);
                $trade_redis->delTradeFinish($trade['t_id']);
                //清除待结算状态 确认收货7天后再结算
                $settled_model  = new App_Model_Trade_MysqlTradeSettledStorage($sid);
                $settled        = $settled_model->findSettledByTid($tid);
                if ($settled && $settled['ts_status'] == App_Helper_Trade::TRADE_SETTLED_PENDING) {
                    $set = array('ts_order_finish_time' => time());
                    $settled_model->updateById($set, $settled['ts_id']);
                    $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
                    $shop = $shop_model->getRowById($trade['t_s_id']);
                    if($shop['s_enter_settle']>0) {
                        $countdown   = plum_parse_config('trade_overtime');
                        $trade_redis = new App_Model_Trade_RedisTradeStorage($sid);
                        $trade_redis->setTradeSettledTtl($settled['ts_id'], $shop['s_enter_settle']?$shop['s_enter_settle']*24*60*60:$countdown['settled']);
                    }else{
                        $trade_redis->delTradeSettledTtl($settled['ts_id']);
                        if($trade['t_es_id']>0){
                            $trade_helper->recordEnterShopSuccessSettled($settled['ts_id']);
                        }else{
                            $trade_helper->recordSuccessSettled($settled['ts_id']);
                        }
                    }
                }
                //交易佣金提成通知
                $order_deduct   = new App_Helper_OrderDeduct($sid);
                $order_deduct->completeOrderDeduct($tid, $trade['t_m_id']);
                $ret = $trade_model->findUpdateTradeByTid($tid, $updata);

                //订单返现
                $returnModel = new App_Model_Shop_MysqlOrderReturnStorage($sid);
                $return = $returnModel->findUpdateDeductByTid($tid);
                if($return){
                    if(App_Helper_MemberLevel::goldCoinTrans($sid, $return['or_m_id'], $return['or_return'])){
                        $returnSet = array('or_status' => 1);
                        $returnModel->findUpdateDeductByTid($tid, $returnSet);
                    }
                }

                if($wxapp_cfg['ac_type'] != 12 && $wxapp_cfg['ac_type'] != 9){
                    //增加商品销量
                    $trade_helper->modifyGoodsSold($trade['t_id']);
                }elseif ($wxapp_cfg['ac_type'] == 12){
                    $trade_helper->adjustTradeCourseApply($trade['t_id']);
                }
                if($ret){
                    //同步更新购物单
                    plum_open_backend('index', 'updateOrder', array('sid' => $sid, 'tid' => $tid));
                    $result = array(
                        'ec' => 200,
                        'em' => '订单已完成'
                    );
                }else{
                    $result = array(
                        'ec' => 400,
                        'em' => '确认收货失败'
                    );
                }
            }else{
                $result = array(
                    'ec' => 400,
                    'em' => '订单状态不正确'
                );
            }
        }else{
            $result = array(
                'ec' => 400,
                'em' => '订单不存在'
            );
        }
        return $result;

    }


}