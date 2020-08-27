<?php

class App_Helper_Handy {

    //订单状态
    const TRADE_NO_PAY          = 1;//待付款
    const TRADE_WAIT_PAY_RETURN = 2;//等待支付成功确认
    const TRADE_HAD_PAY         = 3;//已支付
    const TRADE_HAD_TAKE        = 4;//已接单
    const TRADE_HAD_GET         = 5;//骑手确认
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


    //订单类型描述
    public static $trade_status_note = [
        self::TRADE_NO_PAY => '待支付',
        self::TRADE_HAD_PAY => '待接单',
        self::TRADE_HAD_TAKE => '待确认',
        self::TRADE_HAD_GET => '帮手确认',
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


    CONST TRADE_TYPE_GET_EXPRESS = 1;
    CONST TRADE_TYPE_MEAL = 2;
    CONST TRADE_TYPE_SEAT = 3;
    CONST TRADE_TYPE_SEND_EXPRESS = 4;
    CONST TRADE_TYPE_MOVE = 5;
    CONST TRADE_TYPE_GAME = 6;
    CONST TRADE_TYPE_BUY = 7;
    CONST TRADE_TYPE_OTHER = 8;

    CONST REFUND_TYPE_CANCEL = 1;
    CONST REFUND_TYPE_APPLY = 2;


    CONST TRADE_REFUND_APPLY = 1;
    CONST TRADE_REFUND_PASS = 2;
    CONST TRADE_REFUND_REFUSE = 3;


    CONST TRADER_CANCEL_TYPE = [
        1 => '未支付超时',
        2 => '无人接单自动取消',
        3 => '用户取消',
        4 => '后台取消'
    ];

    //校园跑腿订单类型
    CONST TRADE_TYPE = [
        [
            'name' => '取件',
            'type' => 'getExpress',
            'type_id' => self::TRADE_TYPE_GET_EXPRESS,
            'index' => 0,
            'sort' => 0,
            'imgsrc' => '/public/manage/img/zhanwei/fenleinav.png',
            'title' => '取件',
            'open' => true,
            'min' => 0
        ],
        [
            'name' => '带饭',
            'type' => 'meal',
            'type_id' => self::TRADE_TYPE_MEAL,
            'index' => 1,
            'sort' => 0,
            'imgsrc' => '/public/manage/img/zhanwei/fenleinav.png',
            'title' => '带饭',
            'open' => true,
            'min' => 0
        ],
        [
            'name' => '占座',
            'type' => 'seat',
            'type_id' => self::TRADE_TYPE_SEAT,
            'index' => 2,
            'sort' => 0,
            'imgsrc' => '/public/manage/img/zhanwei/fenleinav.png',
            'title' => '占座',
            'open' => true,
            'min' => 0
        ],
        [
            'name' => '寄件',
            'type' => 'sendExpress',
            'type_id' => self::TRADE_TYPE_SEND_EXPRESS,
            'index' => 3,
            'sort' => 0,
            'imgsrc' => '/public/manage/img/zhanwei/fenleinav.png',
            'title' => '寄件',
            'open' => true,
            'min' => 0
        ],
        [
            'name' => '搬运',
            'type' => 'move',
            'type_id' => self::TRADE_TYPE_MOVE,
            'index' => 4,
            'sort' => 0,
            'imgsrc' => '/public/manage/img/zhanwei/fenleinav.png',
            'title' => '搬运',
            'open' => true,
            'min' => 0
        ],
        [
            'name' => '游戏',
            'type' => 'deal',
                'type_id' => self::TRADE_TYPE_GAME,
            'index' => 5,
            'sort' => 0,
            'imgsrc' => '/public/manage/img/zhanwei/fenleinav.png',
            'title' => '游戏',
            'open' => true,
            'min' => 0
        ],
        [
            'name' => '代买',
            'type' => 'move',
            'type_id' => self::TRADE_TYPE_BUY,
            'index' => 6,
            'sort' => 0,
            'imgsrc' => '/public/manage/img/zhanwei/fenleinav.png',
            'title' => '代买',
            'open' => true,
            'min' => 0
        ],
        [
            'name' => '其它',
            'type' => 'other',
            'type_id' => self::TRADE_TYPE_OTHER,
            'index' => 7,
            'sort' => 0,
            'imgsrc' => '/public/manage/img/zhanwei/fenleinav.png',
            'title' => '其它',
            'open' => true,
            'min' => 0
        ],
    ];
    //地址描述
    CONST TRADE_ADDRESS_DESC = [
        self::TRADE_TYPE_GET_EXPRESS => [
            'from' => '',
            'to' => '收件地址'
        ],
        self::TRADE_TYPE_MEAL => [
            'from' => '',
            'to' => '送饭地址'
        ],
        self::TRADE_TYPE_SEAT => [
            'from' => '',
            'to' => '占座地点'
        ],
        self::TRADE_TYPE_SEND_EXPRESS => [
            'from' => '取件地址',
            'to' => '寄件地址'
        ],
        self::TRADE_TYPE_MOVE => [
            'from' => '出发地',
            'to' => '目的地'
        ],
        self::TRADE_TYPE_GAME => [
            'from' => '',
            'to' => '目的地'
        ],
        self::TRADE_TYPE_BUY => [
            'from' => '',
            'to' => '收货地址'
        ],
        self::TRADE_TYPE_OTHER => [
            'from' => '出发地',
            'to' => '目的地'
        ],
    ];


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
            'label' => '帮手确认'
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

    //意见反馈原因
    public static $suggest_reason = [
        1 => '产品不好用',
        2 => '页面不好看',
        3 => '功能有Bug',
        4 => '内容太少，找不到想要的',
        5 => '其它'
    ];


    //意见反馈原因
    public static $refund_reason = [
        '服务态度差',
        '上门速度慢',
        '物品损坏',
        '其他'
    ];



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
        $shop_storage   = new App_Model_Shop_MysqlShopCoreStorage($sid);
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
        $postFee = $trade['aht_payment'] - $trade['aht_goods_fee'];
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
        $type = $trade['aht_type'];
        $tid = $trade['aht_tid'];
        $cfg_model = new App_Model_Handy_MysqlHandyCfgStorage($this->sid);
        $cfg = $cfg_model->findUpdateBySid();
        //删除订单自动关闭
        $trade_redis    = new App_Model_Trade_RedisTradeStorage($this->sid);
        $trade_redis->delHandyTradeClose($trade['aht_id']);
        //生成订单核销码
        $filename = $trade['aht_m_id'].'-'.$trade['aht_code']. '.png';
        $text = $trade['aht_code'];
        Libs_Qrcode_QRCode::png($text, $this->hold_dir . $filename, 'Q', 6, 1);

        $canCloseTime = $cfg['ahc_can_cancel_time'] ? time() + intval($cfg['ahc_can_cancel_time']) : 0;
        //修改订单完成状态
        $set = [
            'aht_status' => self::TRADE_HAD_PAY,
            'aht_qrcode' => $this->access_path.$filename,
            'aht_can_cancel_time' => $canCloseTime
        ];
        $trade_model = new App_Model_Handy_MysqlHandyTradeStorage($this->sid);
        $trade_model->findUpdateTradeByTid($tid,$set);

        //设置无人接单自动取消订单定时
        if($cfg['ahc_auto_cancel_time'] > 0){
            $overTime = $cfg['ahc_auto_cancel_time'] * 3600;
            $trade_redis->setHandyTradeCancelTtl($trade['aht_id'], $overTime);
        }



        //todo 发送通知
        //plum_open_backend('templmsg', 'sendLegworkTempl', array('sid' => $this->sid, 'tid' => $trade['aht_tid'], 'type' => 'handy_pay'));
    }
    /*
    * 处理退款  （同意退款处理）(新的接口返回错误提示)
    * @param $t_id 订单自增ID,非订单编号
    * @param string $param_type id 或 tid
    * @return
    */
    public function appletDealRefund($t_id, $param_type = 'id',$refund_type = self::REFUND_TYPE_CANCEL) {
        $trade_model    = new App_Model_Handy_MysqlHandyTradeStorage($this->sid);
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
        if($trade['aht_refund_wid']) {
            $refund_state   = array(
                'code' => 'fail',
                'msg'  => '退款已经处理完成',
            );
            return $refund_state;
        }

        $refundMoney = $trade['aht_payment'];



        //判断是否可退款
        $verify = $this->checkAppletTradeRefund($trade['aht_pay_type'],$refundMoney);

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
        );

        //判断退款方式
        if($refundMoney > 0){
            switch ($trade['aht_pay_type']) {
                //微信支付自有
                case App_Helper_Trade::TRADE_PAY_WXZFZY :
                    //发起微信退款
                    $wid = App_Plugin_Weixin_PayPlugin::makeMchOrderid('W');
                    // $ret = $new_pay->appletRefundPayOrder($trade['aht_pay_trade_no'], $wid, $trade['aht_payment'], $refundMoney, 'wx');

                    // 增加服务商模式退款
                    // zhangzc
                    // 2019-09-18
                    $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
                    $appcfg = $appletPay_Model->findRowPay();
                    if($appcfg && $appcfg['ap_sub_pay']==1){
                        $subPay_storage = new App_Plugin_Weixin_AppletSubPay($this->sid);
                        $ret = $subPay_storage->appletRefundPayOrder($appcfg['ap_appid'],$trade['aht_pay_trade_no'], $wid, $trade['aht_payment'], $refundMoney, 'wx');
                        // 如果服务商模式退款处理失败，尝试普通商户退款
                        if($ret['code']!='SUCCESS'){
                            //发起微信退款
                            $new_pay    = new App_Plugin_Weixin_NewPay($this->sid);
                            $ret = $new_pay->appletRefundPayOrder($trade['aht_pay_trade_no'], $wid, $trade['aht_payment'], $refundMoney, 'wx');
                        }
                    }else{
                        //发起微信退款
                        $new_pay    = new App_Plugin_Weixin_NewPay($this->sid);
                        $ret = $new_pay->appletRefundPayOrder($trade['aht_pay_trade_no'], $wid, $trade['aht_payment'], $refundMoney, 'wx');
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
                    $coin_res = App_Helper_MemberLevel::goldCoinTrans($this->sid, $trade['aht_m_id'], $refundMoney);
                    //记录收入
                    if($coin_res){
                        $record_storage = new App_Model_Member_MysqlRechargeStorage($this->sid);
                        //消费记录保存
                        $indata = array(
                            'rr_tid'        => $trade['aht_tid'],
                            'rr_s_id'       => $this->sid,
                            'rr_m_id'       => $trade['aht_m_id'],
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
                'aht_status' => self::TRADE_CLOSED,
                'aht_refund_wid'    => $wid,
                'aht_refund_type'    => $refund_type, //退款类型
                'aht_cancel_time' => $_SERVER['REQUEST_TIME']

            );

            if($refund_type == self::REFUND_TYPE_APPLY){
                //申请退款成功时  标记退款成功
                $trupdata['aht_refund_status'] = self::TRADE_REFUND_PASS; //退款成功
                $trupdata['aht_status'] = self::TRADE_REFUND;
            }

            $trade_model->updateById($trupdata, $trade['aht_id']);

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
        $trade_model = new App_Model_Handy_MysqlHandyTradeStorage($this->sid);
        $trade = $trade_model->getRowById($id);
        if(!$trade){
            return false;
        }
        if($trade['aht_status'] == self::TRADE_NO_PAY){
            //退还交易中使用的优惠券
            $this->_back_coupon($trade);
            //修改订单状态
            $set = [
                'aht_status' => self::TRADE_CLOSED,
                'aht_close_time' => time()
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
        $set = [
            'aht_status' => self::TRADE_CLOSED,
            'aht_close_time' => $timeNow,
            'aht_close_type' => 2,
        ];
        if($row){
            if($row['aht_status'] == self::TRADE_HAD_PAY){
                //先退款
                $refund = $this->appletDealRefund($row['aht_id']);
                if($refund['code'] == 'success'){
                    $res = $trade_model->findUpdateTradeByTid($row['aht_tid'],$set);
                }
            }
//            if($res){
//                plum_open_backend('templmsg', 'sendLegworkTempl', array('sid' => $this->sid, 'tid' => $row['aht_tid'], 'type' => 'legwork_cancel'));
//            }
        }
    }


    /*
     * 退还优惠券
     */
    private function _back_coupon($trade){
        $trade_coupon   = new App_Model_Trade_MysqlTradeCouponStorage($this->sid);
        $coupon_use     = $trade_coupon->findCouponByTid($trade['aht_tid']);
        if ($coupon_use) {
            $coupon_receive = new App_Model_Coupon_MysqlReceiveStorage();
            $updata = array('cr_is_used' => 0);
            $coupon_receive->updateCouponReceive($coupon_use['tc_rc_id'], $trade['aht_m_id'], $this->sid, $updata);
        }
    }

    /*
     * 骑手垫付记录
     */
    public function _save_rider_pay($riderId,$riderMid,$trade){
        $insert = [
            'ahtp_s_id' => $this->sid,
            'ahtp_m_id' => $riderMid,
            'ahtp_rider' => $riderId,
            'ahtp_tid' => $trade['aht_tid'],
            'ahtp_money' => $trade['aht_goods_fee'],
            'ahtp_create_time' => time()
        ];
        $alrp_model = new App_Model_Handy_MysqlHandyRiderPayStorage($this->sid);
        $alrp_model->insertValue($insert);

        //增加可提现费用
        $rider_model = new App_Model_Handy_MysqlHandyRiderStorage($this->sid);
        $rider_model->incrementRiderField($riderId,$trade['aht_goods_fee'],'ahr_goodsfee_ktx');
    }

    /*
     * 骑手收入记录
     */
    public function _save_rider_income($riderId,$trade,$timeNow){
        $punishFee = 0;
        $taxFee = 0;//平台抽成
        $totalFee = floatval($trade['aht_post_fee']);

        $post_percent = floatval($trade['aht_post_percent']);
        if($post_percent > 0){
            $taxFee = round($totalFee*$post_percent/100,2);
        }
        $totalFeeTaxPaid = $totalFee - $taxFee;//扣除平台抽成的总费用

        $totalFeeTrue  = $totalFeeTaxPaid - $punishFee;
        //记录收入
        $insert_income = [
            'alri_s_id' => $this->sid,
            'alri_m_id' => $trade['t_rider_mid'],
            'alri_rider' => $riderId,
            'alri_tid' => $trade['aht_tid'],
            'alri_t_type' => $trade['aht_type'],
            'alri_money' => $totalFeeTrue,
            'alri_post_fee' => $totalFee,
            'alri_tax_fee' => $taxFee,
            'alri_income_type' => 1,
            'alri_create_time' => $timeNow
        ];
        $income_model = new App_Model_Handy_MysqlHandyRiderIncomeStorage($this->sid);
        $income_model->insertValue($insert_income);


        //记录可提现金额
        $rider_model = new App_Model_Handy_MysqlHandyRiderStorage($this->sid);
        $rider_model->incrementRiderField($riderId,$totalFeeTrue,'ahr_income_ktx');

    }


    public function finishOvertimeTrade($id){
        $trade_model = new App_Model_Legwork_MysqlLegworkTradeStorage($this->sid);
        $row = $trade_model->getRowById($id);
        if($row){
            $this->_deal_trade_verify($row);
        }
    }




    public function _deal_trade_verify($trade){
        //todo 判断超时惩罚 没有规划 先不做

        $trade_model = new App_Model_Handy_MysqlHandyTradeStorage($this->sid);
        $set = [
            'aht_status' => self::TRADE_FINISH,
            'aht_finish_time' => $_SERVER['REQUEST_TIME']
        ];
        $res = $trade_model->updateById($set,$trade['aht_id']);
        if($res){
            if($trade['aht_goods_fee'] && $trade['aht_rider'] > 0){
                //记录垫付
                $this->_save_rider_pay($trade['aht_rider'],$trade['aht_rider_mid'],$trade);
            }

            if($trade['aht_post_fee'] >0 && $trade['aht_rider'] > 0){
                //记录收入
                $this->_save_rider_income($trade['aht_rider'],$trade,$_SERVER['REQUEST_TIME']);
            }


            $member_model=new App_Model_Member_MysqlMemberCoreStorage();
            $member_model->incrementMemberTrade($trade['alt_m_id'],$trade['alt_payment']);

            return true;
        }else{
            return false;
        }

    }


    /**
     * @param $rider
     * @param $cfg
     * @return bool
     * 是否通过分数审核
     */
    public function checkCommentScore($rider,$cfg){
        if(!$cfg){
            $cfg_model = new App_Model_Handy_MysqlHandyCfgStorage($this->sid);
            $cfg = $cfg_model->findUpdateBySid();
        }
        if($rider){
            $comment_model = new App_Model_Handy_MysqlHandyTradeCommentStorage($this->sid);
            $check_count = intval($cfg['ahc_take_check_num']);
            $check_score = floatval($cfg['ahc_take_check_score']);
            $time = intval($rider['ahr_ban_unseal_time']);

            $where = [];
            $where[]    = array('name' => 'ahtc_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[]    = array('name' => 'ahtc_rider', 'oper' => '=', 'value' => $rider['ahtc_id']);
            if($time){
                $where[]    = array('name' => 'ahtc_create_time', 'oper' => '>', 'value' => $time);
            }
            $total = $comment_model->getCount($where);
            if($total >= $check_count){
                $avg = $comment_model->getScoreAvg($rider['ahr_id'],0,$check_count,['ahtc_id'=>'desc'],$time);
                if(floatval($avg) < $check_score){
                    $set = [
                        'ahr_ban' => 1
                    ];
                    $rider_model = new App_Model_Handy_MysqlHandyRiderStorage($this->sid);
                    $rider_model->updateById($set,$rider['ahr_id']);
                    return false;
                }
            }
        }
        return true;
    }


    public function appletDealDepositRefund($t_id, $param_type = 'id') {
        $trade_model    = new App_Model_Handy_MysqlHandyRiderDepositStorage($this->sid);
        $wid = '';
        if ($param_type == 'id') {
            $trade      = $trade_model->getRowById($t_id);
        } else {
            $trade      = $trade_model->findUpdateTradeByTid($t_id);
        }
        if (!$trade) {
            $refund_state   = array(
                'code' => 'fail',
                'msg'  => '押金不存在',
            );
            return $refund_state;
        }
        if($trade['ahrd_refund_wid']) {
            $refund_state   = array(
                'code' => 'fail',
                'msg'  => '退款已经处理完成',
            );
            return $refund_state;
        }

        $refundMoney = $trade['ahrd_money'];



        //判断是否可退款
        $verify = $this->checkAppletTradeRefund(self::TRADE_PAY_WXZFZY,$refundMoney);

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
        );

        //判断退款方式
        if($refundMoney > 0){
            //发起微信退款
            $wid = App_Plugin_Weixin_PayPlugin::makeMchOrderid('W');
            // $ret = $new_pay->appletRefundPayOrder($trade['aht_pay_trade_no'], $wid, $trade['aht_payment'], $refundMoney, 'wx');

            // 增加服务商模式退款
            // zhangzc
            // 2019-09-18
            $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
            $appcfg = $appletPay_Model->findRowPay();
            if($appcfg && $appcfg['ap_sub_pay']==1){
                $subPay_storage = new App_Plugin_Weixin_AppletSubPay($this->sid);
                $ret = $subPay_storage->appletRefundPayOrder($appcfg['ap_appid'],$trade['ahrd_pay_trade_no'], $wid, $trade['ahrd_money'], $refundMoney, 'wx');
                // 如果服务商模式退款处理失败，尝试普通商户退款
                if($ret['code']!='SUCCESS'){
                    //发起微信退款
                    $new_pay    = new App_Plugin_Weixin_NewPay($this->sid);
                    $ret = $new_pay->appletRefundPayOrder($trade['ahrd_pay_trade_no'], $wid, $trade['ahrd_money'], $refundMoney, 'wx');
                }
            }else{
                //发起微信退款
                $new_pay    = new App_Plugin_Weixin_NewPay($this->sid);
                $ret = $new_pay->appletRefundPayOrder($trade['ahrd_pay_trade_no'], $wid, $trade['ahrd_money'], $refundMoney, 'wx');
            }

            if(!$ret || $ret['code']!='SUCCESS' ){
                $refund_state = array(
                    'code' => 'fail',
                    'msg'  => $ret['errmsg'],
                );
            }
        }

        if ($refund_state['code'] == 'success') {
            //$this->dealRefundTrade($trade);//退款成功后的处理
            //设置订单为退款订单
            $trupdata   = array(
                'ahrd_status' => 3,
                'ahrd_refund_wid'    => $wid,
                'ahrd_refund_time' => $_SERVER['REQUEST_TIME']

            );
            $trade_model->updateById($trupdata, $trade['ahrd_id']);

        }

        return $refund_state;
    }



}