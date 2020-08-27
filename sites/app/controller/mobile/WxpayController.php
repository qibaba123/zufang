<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/5/11
 * Time: 下午9:03
 */
class App_Controller_Mobile_WxpayController extends Libs_Mvc_Controller_FrontBaseController{

    const ORDER_BARGAIN_PAY = 2;//微砍价确认支付状态
    /*
     * 会员信息，参考表pre_member
     */
    private $member;
    /*
     * 店铺表，参考表pre_shop
     */
    private $shop;

    //生成图片存储实际路径
    private $hold_dir;
    //生成图片访问路径
    private $access_path;

    public function __construct() {
        parent::__construct();
        $this->hold_dir     = PLUM_APP_BUILD.'/spread/';
        $this->access_path  = PLUM_PATH_PUBLIC.'/build/spread/';
    }
    /*
     * 获取店铺信息
     */
    private function _set_shop_info() {
        //获取店铺唯一性ID
        $suid   = $this->request->getStrParam('suid');
        $shop_storage = new App_Model_Shop_MysqlShopCoreStorage();
        $shop   = $shop_storage->findShopByUniqid($suid);

        if (!$shop) {
            $this->displayJsonError('店铺不存在，请核实');
        }
        $this->shop = $shop;
    }
    /*
     * 获取用户信息
     */
    private function _check_user_login() {
        $uid    = plum_app_user_islogin();
        if (!$uid) {
            $this->displayJsonError('用户不存在，请核实');
        }
        //通过session获取用户信息
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();

        $member   = $member_storage->getRowById($uid);
        //非同一个店铺
        if ($member['m_s_id'] != $this->shop['s_id']) {
            plum_app_user_logout();
            $this->displayJsonError('用户信息不正确，请核实');
        } else {
            $this->member = $member;
        }
    }
    /*
     * 一元夺宝支付通知
     */
    public function unitaryNotifyAction() {
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        $order_storage  = new App_Model_Unitary_MysqlOrderStorage($this->shop['s_id']);
        $order  = $order_storage->findUpdateOrderByTid($tid);

        //订单不存在，或者非待支付订单
        if (!$order) {
            $this->_respond_weixin_notify(false, '订单不存在，或已支付');
        }
        //订单金额不符
        if ($ret['total_fee'] != (100*floatval($order['uo_use_pay']))) {
            App_Helper_Tool::sendMail("支付费用不一致", array('wx_fee' => $ret['total_fee'], 'tdt_fee' => $order['uo_use_pay']));
            //$this->_respond_weixin_notify(false, '支付费用不一致');
        }

        $status = intval($order['uo_status']);
        if ($status == App_Helper_UnitaryOrder::UNITARY_ORDER_HADPAY) {
            $this->_respond_weixin_notify(false, '订单已支付，勿重复通知');
        }
        $updata = array(
            'uo_status'     => App_Helper_UnitaryOrder::UNITARY_ORDER_HADPAY,
            'uo_pay_time'   => time()
        );
        $order_storage->findUpdateOrderByTid($tid, $updata);

        $order_helper   = new App_Helper_UnitaryOrder($this->shop['s_id']);
        $order_helper->joinUnitary($tid);
        $this->_respond_weixin_notify(true, 'OK');
    }

    /*
     * 微信支付，充值回调方法
     */
    public function rechargeNotifyAction() {
        $ret = $this->_weixin_notify_base_verify();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }

        $tid    = $ret['out_trade_no'];
        $rcgrcd_storage = new App_Model_Member_MysqlRechargeStorage($this->shop['s_id']);
        $record = $rcgrcd_storage->findRecordByTid($tid);
        //记录已存在
        if ($record) {
            $this->_respond_weixin_notify(false, '订单已存在，勿重复通知');
        }
        //支付费用，单位分
        $price  = intval($ret['total_fee'])/100;

        $attach = json_decode($ret['attach'], true);
        $pid    = intval($attach['pid']);
        $coin   = $price;
        if ($pid) {
            $value_model    = new App_Model_Member_MysqlRechargeValueStorage($this->shop['s_id']);
            $value  = $value_model->findValueById($pid);

            if ($value && $value['rv_money'] == $price) {
                $coin   = floatval($value['rv_coin']);
            }
        }
        //充值记录保存
        $indata = array(
            'rr_tid'        => $tid,
            'rr_s_id'       => $this->shop['s_id'],
            'rr_m_id'       => $this->member['m_id'],
            'rr_amount'     => $price,
            'rr_gold_coin'  => $coin,
            'rr_pay_type'   => 1,//微信支付
            'rr_create_time'=> time(),
        );
        $rcgrcd_storage->insertValue($indata);
        //增加用户金币数量
        App_Helper_MemberLevel::goldCoinTrans($this->shop['s_id'], $this->member['m_id'], $coin);
        //增加各级提成
        if ($pid) {
            App_Helper_MemberLevel::coinRechargeDeduct($this->shop['s_id'], $this->member['m_id'], $pid);
        }
        $this->_respond_weixin_notify(true, 'OK');
    }
    /*
     * 微信收银提醒
     */
    public function cashNotifyAction() {
        $ret = $this->_weixin_notify_base_verify();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }

        $tid    = $ret['out_trade_no'];
        $trade_model    = new App_Model_Cash_MysqlRecordStorage($this->shop['s_id']);
        $record = $trade_model->findUpdateTradeByTid($tid);
        //记录已存在
        if ($record) {
            $this->_respond_weixin_notify(false, '订单已存在，勿重复通知');
        }
        //支付费用，单位分
        $price  = intval($ret['total_fee'])/100;

        //充值记录保存
        $indata = array(
            'cr_tid'        => $tid,
            'cr_s_id'       => $this->shop['s_id'],
            'cr_money'      => $price,
            'cr_pay_type'   => App_Helper_Trade::TRADE_PAY_WXZFZY,//微信支付
            'cr_pay_time'   => time(),
        );
        $trade_model->insertValue($indata);
        $this->_respond_weixin_notify(true, 'OK');
    }

    /*
     * 微信回调基本数据校验
     */
    private function _weixin_notify_base_verify() {
        //获取通知的数据
        $ret    = App_Plugin_Weixin_NewPay::fromXml($GLOBALS['HTTP_RAW_POST_DATA']);
        if (!$ret || $ret['return_code'] == 'FAIL') {
            $this->_respond_weixin_notify(false, '数据异常');
        }
        //是否存在附加数据，以判别不同店铺
        if (!isset($ret['attach'])) {
            $this->_respond_weixin_notify(false, '数据格式不正确');
        }
        $attach         = json_decode($ret['attach'], true);
        $shop_storage   = new App_Model_Shop_MysqlShopCoreStorage();
        $shop           = $shop_storage->findShopByUniqid($attach['suid']);
        if (!$shop) {
            $this->_respond_weixin_notify(false, '店铺信息错误');
        }
        $this->shop     = $shop;
        //校验回调数据签名，防止假通知
        $wxpay_plugin   = new App_Plugin_Weixin_NewPay($this->shop['s_id']);
        $verify         = $wxpay_plugin->notifyVerify($ret);
        if (!$verify) {
            $this->_respond_weixin_notify(false, '签名校验失败');
        }
        //校验用户存在
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member         = $member_storage->findUpdateMemberByWeixinOpenid($ret['openid'], $this->shop['s_id']);
        if (!$member) {
            $this->_respond_weixin_notify(false, '会员不存在');
        }
        $this->member   = $member;

        return $ret;
    }

    /*
     * 微砍价订单支付回调
     */
    public function bargainNotifyAction() {
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        $order_storage  = new App_Model_Bargain_MysqlOrderStorage($this->shop['s_id']);
        $order      = $order_storage->findUpdateOrderByTid($tid);

        //订单不存在，或者非待支付订单
        if (!$order) {
            $this->_respond_weixin_notify(false, '订单不存在，或已支付');
        }
        //订单金额不符
        if ($ret['total_fee'] != (100*floatval($order['bo_amount']))) {
            App_Helper_Tool::sendMail("支付费用不一致", array('wx_fee' => $ret['total_fee'], 'tdt_fee' => $order['bo_amount']));
            //$this->_respond_weixin_notify(false, '支付费用不一致');
        }

        $status = intval($order['bo_status']);
        if ($status == self::ORDER_BARGAIN_PAY) {
            $this->_respond_weixin_notify(false, '订单已支付，勿重复通知');
        }
        $updata = array(
            'bo_status'     => self::ORDER_BARGAIN_PAY,
            'bo_pay_time'   => time()
        );
        $order_storage->findUpdateOrderByTid($tid, $updata);
        //设置参与者已购买
        $bargain_helper = new App_Helper_BargainActivity($this->shop['s_id']);
        $bargain_helper->updateJoinerBuy($order['bo_j_id']);
        //递减商品数量
        $activity_storage   = new App_Model_Bargain_MysqlActivityStorage($this->shop['s_id']);
        $activity_storage->incrementGoodsBuyNum($order['bo_a_id']);

        $this->_respond_weixin_notify(true, 'OK');
    }
    /*
     * VIP会员支付回调
     */
    public function vipNotifyAction() {
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        $order_storage  = new App_Model_Member_MysqlVipOrderStorage($this->shop['s_id']);
        $order      = $order_storage->findUpdateOrderByTid($tid);

        //订单不存在，或者非待支付订单
        if (!$order) {
            $this->_respond_weixin_notify(false, '订单不存在，或已支付');
        }
        //订单金额不符
        if ($ret['total_fee'] != (100*floatval($order['vo_amount']))) {
            App_Helper_Tool::sendMail("支付费用不一致", array('wx_fee' => $ret['total_fee'], 'tdt_fee' => $order['vo_amount']));
            //$this->_respond_weixin_notify(false, '支付费用不一致');
        }

        $status = intval($order['vo_status']);
        if ($status == self::ORDER_BARGAIN_PAY) {
            $this->_respond_weixin_notify(false, '订单已支付，勿重复通知');
        }
        $updata = array(
            'vo_status'     => self::ORDER_BARGAIN_PAY,
            'vo_pay_time'   => time()
        );
        $order_storage->findUpdateOrderByTid($tid, $updata);
        //设置会员购买的VIP
        App_Helper_MemberLevel::setMemberVip($order['vo_m_id'], $order['vo_lid']);
        //设置各级佣金提成
        $order_deduct   = new App_Helper_OrderDeduct($this->shop['s_id']);
        $order_deduct->completeOrderDeduct($tid, $order['vo_m_id']);
        //增加成交订单数量及金额
        $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
        $member_model->incrementMemberTrade($order['vo_m_id'], $order['vo_amount'], 1);
        $this->_respond_weixin_notify(true, 'OK');
    }

    /*
     * 门店会员卡支付回调
     */
    public function cardNotifyAction() {
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        $order_storage  = new App_Model_Store_MysqlOrderStorage($this->shop['s_id']);
        $order      = $order_storage->findUpdateOrderByTid($tid);

        //订单不存在，或者非待支付订单
        if (!$order) {
            $this->_respond_weixin_notify(false, '订单不存在，或已支付');
        }
        //订单金额不符
        if ($ret['total_fee'] != (100*floatval($order['oo_amount']))) {
            App_Helper_Tool::sendMail("支付费用不一致", array('wx_fee' => $ret['total_fee'], 'tdt_fee' => $order['oo_amount']));
            //$this->_respond_weixin_notify(false, '支付费用不一致');
        }

        $status = intval($order['oo_status']);
        if ($status == self::ORDER_BARGAIN_PAY) {
            $this->_respond_weixin_notify(false, '订单已支付，勿重复通知');
        }
        $updata = array(
            'oo_status'     => self::ORDER_BARGAIN_PAY,
            'oo_outer_tid'  => $ret['transaction_id'],
            'oo_pay_time'   => time()
        );

        // 修复会员卡充值后微信回调重复执行出现错误的充值金额叠加bug
        // zhangzc
        // 2019-08-20
        $update_exec=$order_storage->findUpdateOrderByTid($tid, $updata);
        if($update_exec){
            //设置会员购买的VIP
            App_Helper_MemberLevel::setMemberCard($order['oo_m_id'], $order['oo_cardid'], $this->shop['s_id'],0,$order['oo_tid']);
            //设置各级佣金提成
            $order_deduct   = new App_Helper_OrderDeduct($this->shop['s_id']);
            $order_deduct->completeOrderDeduct($tid, $order['oo_m_id']);
            //增加成交订单数量及金额
            $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
            $member_model->incrementMemberTrade($order['oo_m_id'], $order['oo_amount'], 1);
            // 开通会员获取积分
            $point_storage = new App_Helper_Point($this->shop['s_id']);
            $point_storage->gainPointBySource($order['oo_m_id'],App_Helper_Point::POINT_SOURCE_OPEN_MEMBER);
            $this->_respond_weixin_notify(true, 'OK');
        }
        
    }
    /*
     * 商城订单交易通知
     */
    public function tradeNotifyAction() {
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        //扫码支付订单号特殊处理
        $code   = substr($tid, -6);
        if ($code == 'native') {
            $tid    = substr($tid, 0, strlen($tid)-6);
        }
        $trade_model= new App_Model_Trade_MysqlTradeStorage($this->shop['s_id']);
        $trade      = $trade_model->findUpdateTradeByTid($tid);
        //订单不存在，或者非待支付订单
        if (!$trade) {
            $this->_respond_weixin_notify(false, '订单不存在，或已支付');
        }
        //订单金额不符
        if ($ret['total_fee'] != (100*floatval($trade['t_total_fee']))) {
            App_Helper_Tool::sendMail("支付费用不一致", array('wx_fee' => $ret['total_fee'], 'tdt_fee' => $trade['t_total_fee']));
            //$this->_respond_weixin_notify(false, "支付费用不一致:{$tid}");
        }
        $status = intval($trade['t_status']);
        if ($status >= App_Helper_Trade::TRADE_WAIT_PAY_RETURN && $trade['t_pay_trade_no']) {
            $this->_respond_weixin_notify(false, "订单已支付，勿重复通知:{$tid}");
        }
        $updata = array(
            't_pay_type'   => App_Helper_Trade::TRADE_PAY_WXZFZY,
            't_pay_trade_no'    => $ret['transaction_id'],
            't_status'     => App_Helper_Trade::TRADE_WAIT_PAY_RETURN,//等待支付完成确认状态
            't_pay_time'   => time(),
            't_payment'     => $ret['total_fee']/100,
        );
        $trade_model->findUpdateTradeByTid($tid, $updata);
        //订单活动后续处理
        plum_open_backend('index', 'tradeBack', array('sid' => $this->shop['s_id'], 'tid' => $tid, 'from' =>'wx'));
        $this->_respond_weixin_notify(true, 'OK');
    }

    /*
     * 响应微信回调通知
     */
    private function _respond_weixin_notify($true, $msg) {
        $code   = $true ? 'SUCCESS' : 'FAIL';
        $return = array(
            'return_code'   => $code,
            'return_msg'    => $msg
        );
        Libs_Log_Logger::outputLog($return);
        $xml    = App_Plugin_Weixin_PayPlugin::toXml($return);
        plum_send_http_header("Content-type:text/xml;charset=utf-8");
        echo $xml;
        die();
    }


    /*
     * 小程序商城订单交易通知
     */
    public function tradeNotifyAppletAction() {
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        //扫码支付订单号特殊处理
        $code   = substr($tid, -6);
        if ($code == 'native') {
            $tid    = substr($tid, 0, strlen($tid)-6);
        }
        $trade_model= new App_Model_Trade_MysqlTradeStorage($this->shop['s_id']);
        $trade      = $trade_model->findUpdateTradeByTid($tid);
        //订单不存在，或者非待支付订单
        if (!$trade) {
            $trade_spare  = $trade_model->findUpdateTradeBySpareTid($tid);
            if(!$trade_spare){
                $this->_respond_weixin_notify(false, '订单不存在，或已支付');
            }else{
                $trade  = $trade_spare;
                $tid    = $trade_spare['t_tid'];
            }
        }
        //订单金额不符
        /*
        if ($ret['total_fee'] != (100*floatval($trade['t_total_fee'])) && !in_array($trade['t_s_id'],array(4286,4298,11,24,4697,27,5205,5742))) {
            App_Helper_Tool::sendMail("小程序支付费用不一致", array('wx_fee' => $ret['total_fee'], 'tdt_fee' => $trade['t_total_fee']));
            //$this->_respond_weixin_notify(false, "支付费用不一致:{$tid}");
        }
        */
        $status = intval($trade['t_status']);
        if ($status >= App_Helper_Trade::TRADE_WAIT_PAY_RETURN && $trade['t_pay_trade_no']) {
            $this->_respond_weixin_notify(false, "订单已支付，勿重复通知:{$tid}");
        }
        //会务版票类数量计算
        if($trade['t_applet_type']==App_Helper_Trade::TRADE_ORDER_MEETING){
            $order_model      = new App_Model_Trade_MysqlTradeOrderStorage($this->shop['s_id']);
            $where = array();
            $where[]          = array('name' => 'to_t_id', 'oper' => '=', 'value' => $trade['t_id']);
            $where[]          = array('name' => 'to_s_id', 'oper' => '=', 'value' => $this->shop['s_id']);
            $order            = $order_model->getRow($where);
            $ticket_storage   = new App_Model_Meeting_MysqlMeetingTicketStorage($this->shop['s_id']);
            $ticket           = $ticket_storage->getRowById($order['to_gf_id']);
            $set=array('amt_buy_num'=>$ticket['amt_buy_num']+1);
            $ticket_storage->updateById($set,$ticket['amt_id']);
        }

        //餐饮版如果有包厢号 记录餐桌信息
        if(json_decode($trade['t_extra_data'],true)['type'] == 'meal' && $trade['t_home_id'] > 0){
            $table_model = new App_Model_Meal_MysqlMealTableStorage($this->shop['s_id']);
            $where_meal[] = array('name'=>'amt_id','oper'=>'=','value'=>$trade['t_home_id']);
            $where_meal[] = array('name'=>'amt_s_id','oper'=>'=','value'=>$this->shop['s_id']);
            $row_meal = $table_model->getRow($where_meal);
                if(!$row_meal['amt_use']){
                    $set_meal = array(
                        'amt_use' => 1,
                    );
                    $table_model->updateValue($set_meal,$where_meal);
                }
            $meal_end = $trade['t_meal_type'] == 2 ? 1 : 0; //如果是堂食 用餐状态标记为正在使用
        }
        $updata = array(
            't_pay_type'        => $trade['t_pay_type'] == App_Helper_Trade::TRADE_PAY_HHZF?App_Helper_Trade::TRADE_PAY_HHZF:App_Helper_Trade::TRADE_PAY_WXZFZY,
            't_pay_trade_no'    => $ret['transaction_id'],
            't_status'          => App_Helper_Trade::TRADE_WAIT_PAY_RETURN, //支付完成待确认状态
            't_pay_time'        => time(),
            't_meal_end'        => isset($meal_end) ? 1 : 0,
            't_payment'         => $ret['total_fee']/100,
        );
        $trade_model->findUpdateTradeByTid($tid, $updata);
        if($trade['t_es_id']>0){
            //入驻店铺添加待结算交易记录
            $trade_helper   = new App_Helper_Trade($this->shop['s_id']);
            if($trade['t_express_method'] == 4 || $trade['t_express_method'] == 5){//平台配送, 蜂鸟配送，减去配送费
                $trade['t_total_fee'] = $trade['t_total_fee'] - $trade['t_post_fee'];
            }
            if($trade['t_express_method'] == 7){
                $legworkExtra = json_decode($trade['t_legwork_extra'],1);
                if(isset($legworkExtra['price']) && $legworkExtra['price'] > 0){
                    $trade['t_total_fee'] = floatval($trade['t_total_fee']) - floatval($legworkExtra['price']) - floatval($trade['t_share_post_fee']);
                }
            }
            $trade_helper->recordPendingSettled($tid, $trade['t_total_fee'], $trade['t_title'], $trade['t_es_id']);
        }
        // //        // 非积分商城订单则返还积分
        //         if($trade['t_applet_type']!=App_Helper_Trade::TRADE_APPLET_POINT){
        // //            // 支付订单获取积分
        //            $point_storage = new App_Helper_Point($this->shop['s_id']);
        //             $point_storage->gainPointBySource($trade['t_m_id'],App_Helper_Point::POINT_SOURCE_TRADE,$trade);
        //        }

        //订单活动后续处理
        plum_open_backend('index', 'tradeBack', array('sid' => $this->shop['s_id'], 'tid' => $tid));
        if($trade['t_applet_type']==App_Helper_Trade::TRADE_ORDER_MEETING){
            plum_open_backend('templmsg', 'meetingTempl', array('sid' => $this->shop['s_id'], 'tid' => $tid));
        }else{
            plum_open_backend('index', 'wxappTempl', array('sid' => $this->shop['s_id'], 'tid' => $tid, 'type' => App_Helper_WxappApplet::SEND_SETUP_ZFCG));
        }
        $this->_respond_weixin_notify(true, 'OK');
    }

    /*
     * 小程序微信回调基本数据校验
     */
    private function _weixin_notify_base_verify_applet() {
        //获取通知的数据
        $ret    = App_Plugin_Weixin_NewPay::fromXml($GLOBALS['HTTP_RAW_POST_DATA']);
        if (!$ret || $ret['return_code'] == 'FAIL') {
//            Libs_Log_Logger::outputLog('数据异常','test.log');
            $this->_respond_weixin_notify(false, '数据异常');
        }
        //是否存在附加数据，以判别不同店铺
        if (!isset($ret['attach'])) {
//            Libs_Log_Logger::outputLog('数据格式不正确','test.log');
            $this->_respond_weixin_notify(false, '数据格式不正确');
        }
        $attach         = json_decode($ret['attach'], true);
        $shop_storage   = new App_Model_Shop_MysqlShopCoreStorage();
        $shop           = $shop_storage->findShopByUniqid($attach['suid']);
        if (!$shop) {
//            Libs_Log_Logger::outputLog('店铺信息错误','test.log');
            $this->_respond_weixin_notify(false, '店铺信息错误');
        }
        $this->shop     = $shop;
        //校验回调数据签名，防止假通知
        $wxpay_plugin   = new App_Plugin_Weixin_NewPay($this->shop['s_id']);
        $weixin_appid = $attach['wx'] == 1 ? $ret['appid'] : '';

        $verify         = $wxpay_plugin->notifyVerifyApplet($ret,$attach['appid'],$weixin_appid);
        if (!$verify) {
//            Libs_Log_Logger::outputLog('签名校验失败','test.log');
            $this->_respond_weixin_notify(false, '签名校验失败');
        }
        // 获取支付配置
        $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->shop['s_id']);
        $appcfg = $appletPay_Model->findRowPay();
        if($appcfg['ap_sub_pay']==1 && isset($ret['sub_openid']) && $ret['sub_openid']){
            $ret['openid'] = $ret['sub_openid'];
        }
        //校验用户存在
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member         = $member_storage->findUpdateMemberByWeixinOpenid($ret['openid'], $this->shop['s_id']);
        if (!$member) {
//            Libs_Log_Logger::outputLog('会员不存在','test.log');
            $this->_respond_weixin_notify(false, '会员不存在');
        }
        $this->member   = $member;

        return $ret;
    }

    /*
     * 小程序收银台订单交易通知
     */
    public function cashNotifyAppletAction() {
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        $cash_model    = new App_Model_Cash_MysqlRecordStorage($this->shop['s_id']);
        $record = $cash_model->findUpdateTradeByTid($tid);
        //记录已存在
        if ($record) {
            $this->_respond_weixin_notify(false, '订单已存在，勿重复通知');
        }
        // 配置信息
        $attach = json_decode($ret['attach'], true);
        //支付费用，单位分
        $price  = intval($ret['total_fee'])/100;
        $balance = $attach['balance'];
        $enterId = $attach['enterId'] && isset($attach['enterId']) ? $attach['enterId'] : 0;
        if(isset($balance) && $balance){
            //除会员余额
            $debit = App_Helper_MemberLevel::goldCoinTrans($this->shop['s_id'], $this->member['m_id'], -$balance);
            if(!$debit){
                // 如果执行不成功，等待3秒再执行一次
                sleep(3);
                $debit = App_Helper_MemberLevel::goldCoinTrans($this->shop['s_id'], $this->member['m_id'], -$balance);
            }
            if($debit){
                // 记录余额使用记录
                App_Helper_MemberLevel::rechargeRecord($this->shop['s_id'],$tid, $this->member['m_id'], $balance,'收银台付款');
                $price = $price+$balance;
            }
        }
        $applet_redis = new App_Model_Applet_RedisAppletStorage($this->shop['s_id']);
        $remarkExtra = $applet_redis->getCashRemarkTid($tid);
        $applet_redis->delCashRemarkTid($tid);
        //收银台支付记录保存
        $indata = array(
            'cr_tid'        => $tid,
            'cr_s_id'       => $this->shop['s_id'],
            'cr_es_id'      => $enterId,
            'cr_money'      => $price,
            'cr_m_id'       => $attach['mid'],
            'cr_from'       => 2,
            'cr_pay_type'   => isset($balance) && $balance ? App_Helper_Trade::TRADE_PAY_HHZF :App_Helper_Trade::TRADE_PAY_WXZFZY,//微信支付
            'cr_pay_time'   => time(),
            'cr_remark_extra' => $remarkExtra,
            'cr_balance'      => $balance,      // 余额支付金额
            'cr_online_money' => intval($ret['total_fee'])/100,         // 微信在线支付金额
        );
        $cash_model->insertValue($indata);

        //是否开通分销功能
        $order_deduct   = new App_Helper_OrderDeduct($this->shop['s_id']);
        $order_deduct->completeOrderDeduct($tid, $this->member['m_id']);
        //获得积分
        $point_helper   = new App_Helper_Point($this->shop['s_id']);
        $point_helper->gainPointBySource($attach['mid'],App_Helper_Point::POINT_SOURCE_CASHIER,$indata);

        //收款成功推动通知
        $help_model = new App_Helper_XingePush($this->shop['s_id']);
        $help_model->pushNotice($help_model::CASHIER_RECEIPTS,$indata);   //收款成功推动通知
        $notice_model = new App_Helper_JiguangPush($this->shop['s_id']);
        $notice_model->pushNotice($notice_model::CASHIER_RECEIPTS,$indata);
        // 如果是多店的店铺
        if($enterId>0){
            $store_model = new App_Model_Entershop_MysqlEnterShopStorage();
            $entershop       = $store_model->getRowById($enterId);
            $shopbalance    = intval(100*$entershop['es_balance']);//单位分
            $inout_model    = new App_Model_Shop_MysqlShopInoutStorage($this->shop['s_id']);
            //记录收入
            $indata     = array(
                'si_s_id'   => $this->shop['s_id'],
                'si_es_id'  => $enterId,
                'si_name'   => '买单收入',
                'si_amount' => $price,
                'si_balance'=> ($shopbalance+$price*100)/100,
                'si_type'   => 1,
                'si_create_time'    => time(),
            );
            $inout_model->insertValue($indata);
            // 获取分佣比例
            $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->shop['s_id']);
            $appcfg = $appletPay_Model->findRowPay();
            if($entershop['es_cash_proportion'] && $entershop['es_cash_proportion']>0){
                $maid = $entershop['es_cash_proportion']/100;
            }elseif($appcfg['ap_shop_percentage'] && $appcfg['ap_shop_percentage']>0){
                $maid = $appcfg['ap_shop_percentage']/100;
            }else{
                $maid      = plum_parse_config('wxpay_point', 'weixin');
            }
            Libs_Log_Logger::outputLog($maid);
            $less       = ceil($price*$maid*100); //订单抽成比例
            //记录支出
            $outdata    = array(
                'si_s_id'   => $this->shop['s_id'],
                'si_es_id'  => $enterId,
                'si_name'   => "买单入账手续费",
                'si_amount' => $less/100,
                'si_balance'=> ($shopbalance+($price*100)-$less)/100,
                'si_type'   => 2,
                'si_create_time'    => time(),
            );
            $inout_model->insertValue($outdata);
            //修改余额
            $ret = $store_model->incrementShopBalance($enterId, ($price-($less/100)));
        }
        $this->_respond_weixin_notify(true, 'OK');
    }

    /*
     * 小程序帖子置顶付款通知
     */
    public function appletCityPostTopAction() {
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        $post_model = new App_Model_City_MysqlCityPostStorage($this->shop['s_id']);
        $record = $post_model->findUpdateByNumber($tid);
        //记录不存在
        if (!$record) {
            $this->_respond_weixin_notify(false, '订单不存在');
        }

        $topTime = $record['acp_top_date']*60*60*24;
        $expiration = intval(time()+$topTime);
        $set = array(
            'acp_istop' => 1,
            'acp_istop_expiration' => $expiration,
            'acp_pay_time'  => time()
        );
        Libs_Log_Logger::outputLog($set);
        $post_model->findUpdateByNumber($tid,$set);
        //设置置顶到期时间
        $applet_redis = new App_Model_Applet_RedisAppletStorage($this->shop['s_id']);
        $applet_redis->recordTopPostTask($record['acp_id'],$topTime);
        $this->_respond_weixin_notify(true, 'OK');
    }

    /*
     * 招聘职位付款通知
     */
    public function appletJobPositionPayAction() {
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        $pay_model = new App_Model_Job_MysqlJobPositionPayStorage($this->shop['s_id']);
        $record = $pay_model->findUpdateByNumber($tid);
        //记录存在
        if ($record) {
            $this->_respond_weixin_notify(false, '订单已支付');
        }
        $attach         = json_decode($ret['attach'], true);
        $data = array(
            'ajpp_s_id'   => $this->shop['s_id'],
            'ajpp_m_id'   => $attach['mid'],
            'ajpp_number' => $tid,
            'ajpp_create_time' => time(),
            'ajpp_top_time'    => isset($attach['topTime']) && $attach['topTime'] ? $attach['topTime'] : 0,
            'ajpp_money'       => intval($ret['total_fee'])/100,
        );
        $pay_model->insertValue($data);
        $position_model = new App_Model_Job_MysqlJobPositionStorage($this->shop['s_id']);
        $position = $position_model->findUpdateByNumber($tid);
        if($position){
            $cost_storage = new App_Model_City_MysqlCityTopCostStorage($this->shop['s_id']);
            $cost = $cost_storage->findRowByActid($attach['topTime']);
            if($cost && $cost['act_data']){
                $topDate = intval($cost['act_data']);
                $dateTime = $topDate*60*60*24;
                $expiration = intval(time()+$dateTime);
                $data = array();
                $data['ajp_top_days'] = $topDate;
                $data['ajp_is_top']   = 1;
                $data['ajp_top_expiration'] = $expiration;
                $data['ajp_pay_time'] = time();
                $position_model->updateById($data, $position['ajp_id']);
                $applet_redis = new App_Model_Applet_RedisAppletStorage($this->shop['s_id']);
                $applet_redis->recordTopPositionTask($position['ajp_id'], $dateTime);
            }
        }
        $this->_respond_weixin_notify(true, 'OK');
    }

    /**
     * 招聘职位增加奖金
     */
    public function appletJobAddAwardNotifyAction() {
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid            = $ret['out_trade_no'];
        $record_storage = new App_Model_Job_MysqlJobAddRecordStorage($this->shop['s_id']);
        $record         = $record_storage->findRecordByTid($tid);
        //记录已存在
        if ($record) {
            $this->_respond_weixin_notify(false, '订单已存在，勿重复通知');
        }
        $price  = intval($ret['total_fee'])/100;

        $attach = json_decode($ret['attach'], true);
        $pid    = intval($attach['pid']);
        $type   = intval($attach['type']);
        $num    = intval($attach['num']);
        $recommendPrice   = floatval($attach['recommendPrice']);
        $recommendedPrice = floatval($attach['recommendedPrice']);

        if ($pid) {
            $position_model = new App_Model_Job_MysqlJobPositionStorage($this->shop['s_id']);
            $position = $position_model->getRowById($pid);
            $set = array();
            if($type == 1){
                $set['ajp_left_recommend_award'] = $position['ajp_left_recommend_award'] + $recommendPrice;
                $set['ajp_left_recommend_num'] = $position['ajp_left_recommend_num'] + $num;
            }
            if($type == 2){
                $set['ajp_left_entry_award'] = $position['ajp_left_entry_award'] + $recommendPrice;
                $set['ajp_left_recommended_award'] = $position['ajp_left_recommended_award'] + $recommendedPrice;
                $set['ajp_left_entry_num'] = $position['ajp_left_entry_num'] + $num;
            }

            if($set){
                $position_model->updateById($set, $pid);
            }

        }
        //增加奖金记录保存
        $indata = array(
            'ajar_tid'         => $tid,
            'ajar_ajp_id'      => $pid,
            'ajar_s_id'        => $this->shop['s_id'],
            'ajar_m_id'        => $this->member['m_id'],
            'ajar_amount'      => $price,
            'ajar_num'         => $num,//增加的数量
            'ajar_type'        => $type,//类型 1推荐奖 2入职奖
            'ajar_create_time' => time(),
        );
        $record_storage->insertValue($indata);

        $this->_respond_weixin_notify(true, 'OK');
    }

    /**
     * 拍卖支付尾款付款通知
     */
    public function appletAuctionPayBalanceAction(){
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        $pay_model = new App_Model_Auction_MysqlAuctionPayBalanceStorage($this->shop['s_id']);
        $record = $pay_model->findUpdateByNumber($tid);
        //记录已存在
        if ($record) {
            $this->_respond_weixin_notify(false, '订单已存在，勿重复通知');
        }

        $price  = intval($ret['total_fee'])/100;

        $attach  = json_decode($ret['attach'], true);
        $mid     = intval($attach['mid']);
        $aid     = intval($attach['aid']);
        $tradeId = $attach['tid'];

        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->shop['s_id']);
        $trade = $trade_model->findUpdateTradeByTid($tradeId);

        $auction_model = new App_Model_Auction_MysqlAuctionListStorage($this->shop['s_id']);
        $auction = $auction_model->getRowById($aid);

        $set = array(
            't_status'   => 3,
            't_payment'  => ($trade['t_payment'] + $price),
            't_total_fee' => $auction['aal_curr_price'],
            't_goods_fee' => $auction['aal_curr_price'],
            't_pay_time' => time(),
        );
        //把订单改成已支付
        $ret = $trade_model->findUpdateTradeByTid($tradeId, $set);

        $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->shop['s_id']);
        $order = $order_model->fetchOrderListByTid($trade['t_id']);
        foreach ($order as $val) {
            $set = array('to_price' => $auction['aal_curr_price'], 'to_total' => $auction['aal_curr_price']);
            $order_model->updateById($set, $val['to_id']);
        }

        if($ret){
            $data = array(
                'aapb_s_id'        => $this->shop['s_id'],
                'aapb_m_id'        => $mid,
                'aapb_number'      => $tid,
                'aapb_tid'         => $tradeId,
                'aapb_aal_id'      => $aid,
                'aapb_money'       => $price,
                'aapb_pay_type'    => 1,
                'aapb_create_time' => time(),
            );
            $pay_model->insertValue($data);
        }

        //清除订单的自动结算
        $applet_redis = new App_Model_Applet_RedisAppletStorage($this->shop['s_id']);
        $applet_redis->delAuctionTradeClose($trade['t_id']);

        $this->_respond_weixin_notify(true, 'OK');
    }


    /**
     * 房产小程序查看精品房源付款通知
     */
    public function appletHouseResourceAction(){
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        $order_model = new App_Model_House_MysqlHouseOrderStorage($this->shop['s_id']);
        $record = $order_model->findUpdateByNumber($tid);
        //记录不存在
        if (!$record) {
            $this->_respond_weixin_notify(false, '订单不存在');
        }

        $set = array(
            'aho_day' => date('Ymd', time()),
            'aho_pay_time' => time(),
            'aho_status'  => 1
        );
        $order_model->findUpdateByNumber($tid,$set);
        $this->_respond_weixin_notify(true, 'OK');
    }

    /**
     * 小程序购买门店会员卡回调通知
     */
    public function appletCardNotifyAction() {
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        $order_storage  = new App_Model_Store_MysqlOrderStorage($this->shop['s_id']);
        $order      = $order_storage->findUpdateOrderByTid($tid);

        //订单不存在，或者非待支付订单
        if (!$order) {
            $this->_respond_weixin_notify(false, '订单不存在，或已支付');
        }
        //订单金额不符
        if ($ret['total_fee'] != (100*floatval($order['oo_amount']))) {
            App_Helper_Tool::sendMail("支付费用不一致", array('wx_fee' => $ret['total_fee'], 'tdt_fee' => $order['oo_amount']));
            //$this->_respond_weixin_notify(false, '支付费用不一致');
        }
        $status = intval($order['oo_status']);
        if ($status == self::ORDER_BARGAIN_PAY) {
            $this->_respond_weixin_notify(false, '订单已支付，勿重复通知');
        }
        $updata = array(
            'oo_status'     => self::ORDER_BARGAIN_PAY,
            'oo_outer_tid'  => $ret['transaction_id'],
            'oo_pay_time'   => time()
        );
        $order_storage->findUpdateOrderByTid($tid, $updata);
        //设置会员购买的VIP
        App_Helper_MemberLevel::setMemberCard($order['oo_m_id'], $order['oo_cardid'], $this->shop['s_id'], $order['oo_es_id'],$order['oo_tid']);
//        //设置各级佣金提成
//        $order_deduct   = new App_Helper_OrderDeduct($this->shop['s_id']);
//        $order_deduct->completeOrderDeduct($tid, $order['oo_m_id']);
        //是否开通分销功能
        $order_deduct   = new App_Helper_OrderDeduct($this->shop['s_id']);
        $order_deduct->completeOrderDeduct($tid, $this->member['m_id']);
        //增加成交订单数量及金额
        $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
        $member_model->incrementMemberTrade($order['oo_m_id'], $order['oo_amount'], 1);
        // 开通会员获取积分
        $point_storage = new App_Helper_Point($this->shop['s_id']);
        $point_storage->gainPointBySource($order['oo_m_id'],App_Helper_Point::POINT_SOURCE_OPEN_MEMBER);
        //发送模板消息

        $appletType = plum_parse_config('member_source_menu_type')[$this->member['m_source']];
        $appletType = $appletType ? $appletType : 0;

        plum_open_backend('templmsg', 'memberCardTempl', array('sid' => $this->shop['s_id'], 'id' => $tid,'appletType' => $appletType));
        $this->_respond_weixin_notify(true, 'OK');
    }
    /**
     * 小程序会员充值回调
     */
    public function appletMemberRechargeNotifyAction() {
//        Libs_Log_Logger::outputLog('执行充值回调'.$this->shop['s_id'],'test.log');
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }

        $tid            = $ret['out_trade_no'];
        $record_storage = new App_Model_Member_MysqlRechargeStorage($this->shop['s_id']);
        $record         = $record_storage->findRecordByTid($tid);
        //记录已存在
        if ($record) {
            $this->_respond_weixin_notify(false, '订单已存在，勿重复通知');
        }
        //支付费用，单位分
        /*if($this->shop['s_id'] == 11){
            $price  = 10;
        }else{
            $price  = intval($ret['total_fee'])/100;
        }*/

        $price  = intval($ret['total_fee'])/100;
        $attach = json_decode($ret['attach'], true);
        $pid    = intval($attach['pid']);
        $coin   = $price;

//        $recharge_info = [
//            'price' => $price,
//            'attach' => $attach,
//            'pid' => $pid,
//            'coin' => $coin,
//            'sid' => $this->shop['s_id']
//        ];
//        Libs_Log_Logger::outputLog($recharge_info,'test.log');

        if ($pid) {
            $value_model    = new App_Model_Member_MysqlRechargeValueStorage($this->shop['s_id']);
            $value  = $value_model->findValueById($pid);
            if($this->shop['s_id'] == 11 || $this->shop['s_id']==5655 || $this->shop['s_id'] == 4697 || $this->shop['s_id'] == 5474 || $this->shop['s_id'] == 8298){
                $coin   = floatval($value['rv_coin']);
                $price = $coin;
            }else{
                if ($value && $value['rv_money'] == $price) {
                    $coin   = floatval($value['rv_coin']);
                }
            }
            $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->shop['s_id']);
            $applet     = $applet_model->findShopCfg();
            if($value['rv_identity'] && $applet['ac_type'] != 21){
                if($this->member['m_level'] > 0){
                    $level_model = new App_Model_Member_MysqlLevelStorage();
                    $curr_level = $level_model->getRowById($this->member['m_level']);
                    $level = $level_model->getRowById($value['rv_identity']);
                    if($level['ml_discount'] < $curr_level['ml_discount']){
                        $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                        $updata = array(
                            'm_level'   => $value['rv_identity']
                        );
                        $member_model->updateById($updata, $this->member['m_id']);
                    }
                }else{
                    $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                    $updata = array(
                        'm_level'   => $value['rv_identity']
                    );
                    $member_model->updateById($updata, $this->member['m_id']);
                }
            }
        }

        $remark_model = new App_Model_Member_MysqlRechargeRemarkStorage($this->shop['s_id']);
        $remark_record = $remark_model->findRecordByTid($tid);
        $remark = $remark_record['rrr_remark'] ? $remark_record['rrr_remark'] : '';

        //充值记录保存
        $indata = array(
            'rr_tid'        => $tid,
            'rr_s_id'       => $this->shop['s_id'],
            'rr_m_id'       => $this->member['m_id'],
            'rr_amount'     => $price,
            'rr_gold_coin'  => $coin,
            'rr_remark'     => $remark,
            'rr_status'     => 1,//标识金币增加
            'rr_pay_type'   => 1,//微信支付
            'rr_create_time'=> time(),
        );
        if($pid){
            $indata['rr_pid'] = $pid;
        }
        $recordId = $record_storage->insertValue($indata);

        $appletType = plum_parse_config('member_source_menu_type')[$this->member['m_source']];
        $appletType = $appletType ? $appletType : 0;

        plum_open_backend('templmsg', 'coinChangeTempl', array('sid' => $this->shop['s_id'], 'id' => $recordId,'appletType'=>$appletType));

        //增加用户金币数量
        App_Helper_MemberLevel::goldCoinTrans($this->shop['s_id'], $this->member['m_id'], $coin);
        //增加各级提成
        /*if ($pid) {
            App_Helper_MemberLevel::coinRechargeDeduct($this->shop['s_id'], $this->member['m_id'], $pid);
        }*/
        //是否开通分销功能
        /*$order_deduct   = new App_Helper_OrderDeduct($this->shop['s_id']);
        $order_deduct->completeOrderDeduct($tid, $this->member['m_id']);*/

        $notice_model = new App_Helper_JiguangPush($this->shop['s_id']);
        $recordInfo = array(
            'id'  => $recordId,
            'mid' => $this->member['m_id']
        );
        $notice_model->pushNotice($notice_model::LEAVING_RECHARGE,$recordInfo);

        $this->_increment_member($this->shop['s_id'],$this->member['m_id'],$price);
        plum_open_backend('templmsg', 'rechargeTempl', array('sid' => $this->shop['s_id'], 'tid' => $tid));
        $this->_respond_weixin_notify(true, 'OK');
    }

    /**
     * 小程序入驻充值回调
     */
    public function appletEnterShopRechargeNotifyAction() {
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }

        $tid            = $ret['out_trade_no'];
        $record_storage = new App_Model_Member_MysqlRechargeStorage($this->shop['s_id']);
        $record         = $record_storage->findRecordByTid($tid);
        //记录已存在
        if ($record) {
            $this->_respond_weixin_notify(false, '订单已存在，勿重复通知');
        }
        //支付费用，单位分

        $price  = intval($ret['total_fee'])/100;

        $attach = json_decode($ret['attach'], true);
        $pid    = intval($attach['pid']);
        $esId   = intval($attach['esId']);
        $coin   = $price;
        if ($pid) {
            $value_model    = new App_Model_Member_MysqlRechargeValueStorage($this->shop['s_id']);
            $value  = $value_model->findValueById($pid);
            if($this->shop['s_id'] == 8589){
                $coin   = floatval($value['rv_coin']);
                $price = $coin;
            }else{
                if ($value && $value['rv_money'] == $price) {
                    $coin   = floatval($value['rv_coin']);
                }
            }
        }

        //充值记录保存
        $indata = array(
            'rr_tid'        => $tid,
            'rr_s_id'       => $this->shop['s_id'],
            'rr_es_id'      => $esId,
            'rr_m_id'       => $this->member['m_id'],
            'rr_amount'     => $price,
            'rr_gold_coin'  => $coin,
            'rr_status'     => 1,//标识金币增加
            'rr_pay_type'   => 1,//微信支付
            'rr_create_time'=> time(),
        );
        if($pid){
            $indata['rr_pid'] = $pid;
        }
        $recordId = $record_storage->insertValue($indata);
        //给入驻店铺增加余额
        $enter_shop_model = new App_Model_Entershop_MysqlEnterShopStorage();
        $enter_shop_model->incrementShopBalance($esId, $coin);

        $notice_model = new App_Helper_JiguangPush($this->shop['s_id']);
        $recordInfo = array(
            'id'  => $recordId,
            'mid' => $this->member['m_id']
        );
        $notice_model->pushNotice($notice_model::LEAVING_RECHARGE,$recordInfo);

        plum_open_backend('templmsg', 'rechargeTempl', array('sid' => $this->shop['s_id'], 'tid' => $tid));
        $this->_respond_weixin_notify(true, 'OK');
    }

    /*
    * 小程序商家入驻申请
    */
    public function appletCityApplyAction() {
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        $apply_storage = new App_Model_City_MysqlCityShopApplyStorage($this->shop['s_id']);
        $record = $apply_storage->findUpdateByNumber($tid);
        //记录不存在
        if (!$record) {
            $this->_respond_weixin_notify(false, '订单不存在');
        }
        $set = array(
            'acs_pay_status' => 1,
            'acs_pay_time'  => time()
        );
        Libs_Log_Logger::outputLog($set);
        $apply_storage->findUpdateByNumber($tid,$set);
        $this->_respond_weixin_notify(true, 'OK');
    }

    /*
     * 帖子支付及商家入驻支付
     */
    public function appletCityPostPayAction() {
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        $pay_model = new App_Model_City_MysqlCityPostPayStorage($this->shop['s_id']);
        $record = $pay_model->findUpdateByNumber($tid);
        //记录存在
        if ($record) {
            $this->_respond_weixin_notify(false, '订单已支付');
        }
        $attach         = json_decode($ret['attach'], true);
        $data = array(
            'cpp_s_id'   => $this->shop['s_id'],
            'cpp_m_id'   => $attach['mid'],
            'cpp_number' => $tid,
            'cpp_acc_id' => $attach['cid'],
            'cpp_create_time' => time(),
            'cpp_top_time'    => isset($attach['topTime']) && $attach['topTime'] ? $attach['topTime'] : 0,
            'cpp_money'       => intval($ret['total_fee'])/100,
            'cpp_town'        => $attach['town'],
            'cpp_type'        => $attach['type']
        );
        $pay_model->insertValue($data);
        $post_model = new App_Model_City_MysqlCityPostStorage($this->shop['s_id']);
        $post = $post_model->findUpdateByNumber($tid);
        if($post){
            $cost_storage = new App_Model_City_MysqlCityTopCostStorage($this->shop['s_id']);
            $cost = $cost_storage->findRowByActid($attach['topTime']);
            $dateTime = 0;
            if($cost && $cost['act_data']){
                $topDate = intval($cost['act_data']);
                $dateTime = $topDate*60*60*24;
                $expiration = intval(time()+$dateTime);
                $data = array();
                $data['acp_top_date'] = $topDate;
                $data['acp_istop'] = 1;
                $data['acp_istop_expiration'] = $expiration;
                $data['acp_pay_time'] = time();
                $post_model->updateById($data, $post['acp_id']);
                $applet_redis = new App_Model_Applet_RedisAppletStorage($this->shop['s_id']);
                $applet_redis->recordTopPostTask($post['acp_id'], $dateTime);
            }
        }
        //是否开通分销功能
        $order_deduct   = new App_Helper_OrderDeduct($this->shop['s_id']);
        $order_deduct->completeOrderDeduct($tid, $attach['mid']);
        //TODO  城市合伙人
        if($this->shop['s_id'] == 4546 && isset($attach['town']) && $attach['town'] > 0){
            plum_open_backend('index', 'townDeduct', array('sid' => $this->shop['s_id'],'town' => $attach['town'],'type'=>$attach['type'],'totalCost'=>intval($ret['total_fee'])/100,'number'=>$tid));
        }
        $this->_respond_weixin_notify(true, 'OK');
    }

    /*
    * 社区小程序商家入驻申请
    */
    public function appletCommunityApplyAction() {
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        //$apply_storage = new App_Model_Community_MysqlCommunityShopApplyStorage($this->shop['s_id']);
        $apply_storage = new App_Model_Entershop_MysqlEnterShopStorage($this->shop['s_id']);
        $record = $apply_storage->findUpdateByNumber($tid);
        //记录不存在
        if (!$record) {
            $this->_respond_weixin_notify(false, '订单不存在');
        }
        $set = array(
            'es_handle_status' => 1,
            'es_pay_time'  => time(),
        );
        //Libs_Log_Logger::outputLog($set);
        $apply_storage->findUpdateByNumber($tid,$set);
        //将门店id更新至订单
        $pay_model = new App_Model_Community_MysqlCommunityApplyPayStorage($this->shop['s_id']);
        $pay_model->findUpdateByNumber($tid,array('acap_es_id'=> $record['es_id']));
        $this->_respond_weixin_notify(true, 'OK');
    }

    /**
     * 社区小程序购买vip
     */
    public function communityVipAction() {
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        $order_storage = new App_Model_Community_MysqlCommunityMemberOrderStorage($this->shop['s_id']);
        $order = $order_storage->findUpdateByNumber($tid);
        //记录不存在
        if (!$order) {
            $this->_respond_weixin_notify(false, '订单不存在');
        }
        $set = array(
            'acmo_status' => 1,
            'acmo_pay_time'  => time()
        );
        Libs_Log_Logger::outputLog($set);
        $order_storage->findUpdateByNumber($tid,$set);
        //设置会员购买的VIP
        App_Helper_MemberLevel::setCommunityMemberVip($order['acmo_m_id'], $order['acmo_cid']);
        $this->_respond_weixin_notify(true, 'OK');
    }

    //房源置顶支付
    public function appletHouseTopPayAction() {
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        $order_model = new App_Model_House_MysqlHouseOrderStorage($this->shop['s_id']);
        $record = $order_model->findUpdateByNumber($tid);
        //记录存在
        if ($record) {
            $this->_respond_weixin_notify(false, '订单已支付');
        }
        $attach         = json_decode($ret['attach'], true);
        $data = array(
            'aho_s_id'   => $this->shop['s_id'],
            'aho_t_id' => $tid,
            'aho_m_id'  => $attach['mid'],
            'aho_type' => 3,
            'aho_create_time' => time(),
            'aho_status' => 1,
            'aho_top_time'   => isset($attach['topTime']) && $attach['topTime'] ? $attach['topTime'] : 0
        );
        $order_model->insertValue($data);
        $this->_respond_weixin_notify(true, 'OK');
    }

    /**
     * 获取店铺配置是否充值计算到消费金额
     */
    private function _increment_member($sid,$mid,$money){
        $center_model = new App_Model_Member_MysqlMemberCenterStorage();
        $centerRow    = $center_model->findUpdateBySid($sid);
        // 判断是否添加了充值计算到消费金额
        if($centerRow && $centerRow['cc_recharge_amount']==1){
            //增加成交订单数量及金额
            $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
            $member_model->incrementMemberTrade($mid, $money, 0);

            //是否触发成功交易次数,累积消费等级或者是否触发分销条件
            App_Helper_MemberLevel::memberLevelUpgrade($mid, $sid);
        }
    }

    //资讯文章单次付费回调
    public function appletInformationSinglePayAction() {
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }

        $attach         = json_decode($ret['attach'], true);
        $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
        $row = $information_storage->getRowById($attach['id']);
        if($row['ai_price']!=($ret['total_fee']/100) && $this->shop['s_id']!=4546){
            $this->_respond_weixin_notify(false, '支付金额错误');
        }
        $pay_model = new App_Model_Information_MysqlInformationPayStorage($this->shop['s_id']);
        $record = $pay_model->fetchRowById($attach['mid'],$attach['id']);
        //记录存在
        if ($record) {
            $this->_respond_weixin_notify(false, '文章已支付');
        }
        $data = array(
            'aip_s_id'        => $this->shop['s_id'],
            'aip_m_id'        => $attach['mid'],
            'aip_in_id'       => $attach['id'],
            'aip_pay_money'   => intval($ret['total_fee'])/100,
            'aip_pay_time'    => time(),
            'aip_create_time' => time(),
        );
        $pay_model->insertValue($data);
        $this->_respond_weixin_notify(true, 'OK');
    }


    //资讯文章购买会员付费回调
    public function appletInformationMemberPayAction() {
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }

        $attach         = json_decode($ret['attach'], true);
        $card_storage = new App_Model_Information_MysqlInformationCardStorage($this->shop['s_id']);
        $card = $card_storage->fetchRowById($attach['id']);
        if($card['aic_money']!=($ret['total_fee']/100) && $this->shop['s_id']!=4546 && $this->shop['s_id']!=4298){
            $this->_respond_weixin_notify(false, '支付金额错误');
        }
        $pay_model = new App_Model_Information_MysqlInformationMemberCardStorage($this->shop['s_id']);
        $record = $pay_model->fetchRowById($attach['mid']);
        $time = 0;
        if($card['aic_type']==1){
            $time = 86400*$card['aic_time'];
        }elseif($card['aic_type']==2){   //月卡，一个月按30天计算
            $time = 86400*$card['aic_time']*30;
        }elseif($card['aic_type']==3){   // 年卡，一年按365天计算
            $time = 86400*$card['aic_time']*365;
        }
        //记录存在,修改到期时间
        if ($record) {
            if($record['aim_expire_time']>time()){
                $updata = array(
                    'aim_expire_time' => $record['aim_expire_time']+$time,
                    'aim_update_time' => time()
                );
            }else{
                $updata = array(
                    'aim_expire_time' => time()+$time,
                    'aim_update_time' => time()
                );
            }
            $pay_model->fetchRowById($attach['mid'],$updata);
        }else{
            $data = array(
                'aim_s_id'        => $this->shop['s_id'],
                'aim_m_id'        => $attach['mid'],
                'aim_title'       => $card['aic_title'],
                'aim_open_time'   => time(),
                'aim_expire_time' => time()+$time,
                'aim_update_time' => time(),
                'aim_create_time' => time(),
            );
            $pay_model->insertValue($data);
        }
        //记录支付
        $cardPay_model = new App_Model_Information_MysqlInformationCardPayStorage($this->shop['s_id']);
        $insert = [
            'aicp_s_id'        => $this->shop['s_id'],
            'aicp_m_id'        => $attach['mid'],
            'aicp_card_id'     => $card['aic_id'],
            'aicp_card_type'     => $card['aic_type'],
            'aicp_card_title'     => $card['aic_title'],
            'aicp_pay_money'     => intval($ret['total_fee'])/100,
            'aicp_create_time'     => time(),
        ];
        $cardPay_model->insertValue($insert);


        $this->_respond_weixin_notify(true, 'OK');
    }

    /*
     * 小程序电话本商家入驻支付
     */
    public function appletMobileApplyAction() {
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        $pay_model = new App_Model_Mobile_MysqlMobileApplyPayStorage($this->shop['s_id']);
        $record = $pay_model->findUpdateByNumber($tid);
        //记录存在
        if ($record) {
            $this->_respond_weixin_notify(false, '订单已支付');
        }
        $attach         = json_decode($ret['attach'], true);
        // 获取支付费用信息
        $cost_storage = new App_Model_Mobile_MysqlMobileApplyCostStorage($this->sid);
        $row = $cost_storage->getRowById($attach['dateId']);
        $data = array(
            'msp_s_id'        => $this->shop['s_id'],
            'msp_number'      => $tid,
            'msp_mac_id'      => $attach['dateId'],
            'msp_create_time' => time(),
            'msp_date'        => $row['mac_data'],
            'msp_money'       => intval($ret['total_fee'])/100
        );
        $pay_model->insertValue($data);
        $this->_respond_weixin_notify(true, 'OK');
    }

    /**
     * 小程序资讯或帖子打赏回调
     */
    public function appletRewardNotifyAction() {
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }

        $tid            = $ret['out_trade_no'];
        $reward_storage = new App_Model_Applet_MysqlAppletRewardRecordStorage($this->shop['s_id']);
        $record = $reward_storage->findRecordByTid($tid);
        //记录已存在
        if ($record) {
            $this->_respond_weixin_notify(false, '记录已存在，勿重复通知');
        }
        $money  = intval($ret['total_fee'])/100;

        $attach = json_decode($ret['attach'], true);
        $curr_id  = intval($attach['id']);
        $type     = intval($attach['type']);

        $data = array(
            'arr_s_id'        => $this->shop['s_id'],
            'arr_m_id'        => $this->member['m_id'],
            'arr_type'        => $type,
            'arr_corr_id'     => $curr_id,
            'arr_pay_type'    => 1,
            'arr_money'       => $money,
            'arr_number'      => $tid,
            'arr_create_time' => time()
        );
        $rid = $reward_storage->insertValue($data);
        if($type==2){
            $post_model = new App_Model_City_MysqlCityPostStorage($this->shop['s_id']);
            $row = $post_model->getRowById($curr_id);
            // 平台抽成比例
            $percentage = $this->shop['s_post_percentage'];
            $account = round($money*(100-$percentage)/100,2) ;
            // 增加发帖人余额
            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
            $member_storage->addWithdraw($account,$this->shop['s_id'],$row['acp_m_id']);
            $deduct_data = array(
                'dd_s_id'           => $this->shop['s_id'],
                'dd_m_id'           => $row['acp_m_id'],
                'dd_o_id'           => $record['arr_id'],
                'dd_amount'         => $account,
                'dd_tid'            => $data['arr_number'],
                'dd_inout_put'      => 2,
                'dd_level'          => 0,
                'dd_record_type'    => 4,
                'dd_record_time'    => time(),
                'dd_record_remark'  => '帖子打赏收入'
            );
            $book_model = new App_Model_Deduct_MysqlDeductDaybookStorage();
            $book_ret = $book_model->insertValue($deduct_data);

            $to_member = $member_storage->getRowById($row['acp_m_id']);
            $appletType = plum_parse_config('member_source_menu_type')[$to_member['m_source']];
            $appletType = $appletType ? $appletType : 0;

            plum_open_backend('templmsg', 'postRewardTempl', array('sid' => $this->shop['s_id'], 'id' => $rid,'appletType' => $appletType));
        }
        //是否开通分销功能
        $order_deduct   = new App_Helper_OrderDeduct($this->shop['s_id']);
        $order_deduct->completeOrderDeduct($tid, $attach['muid']);
        $this->_respond_weixin_notify(true, 'OK');
    }

    /*
     * 多店商家入驻回调
     */
    public function appletCommunityApplyPayAction() {
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        $pay_model = new App_Model_Community_MysqlCommunityApplyPayStorage($this->shop['s_id']);
        $record = $pay_model->findUpdateByNumber($tid);
        //记录存在
        if ($record) {
            $this->_respond_weixin_notify(false, '订单已支付');
        }
        $attach         = json_decode($ret['attach'], true);
        $data = array(
            'acap_s_id'   => $this->shop['s_id'],
            'acap_number' => $tid,
            'acap_create_time' => time(),
            'acap_date'    => isset($attach['costDate']) && $attach['costDate'] ? $attach['costDate'] : 0,
            'acap_money'       => intval($ret['total_fee'])/100,
        );
        $pay_model->insertValue($data);
        $this->_respond_weixin_notify(true, 'OK');
    }

    /*
     * 知识付费支付回调
     */
    public function appletKnowledgePayAction() {
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        $pay_model = new App_Model_Knowledge_MysqlKnowledgePayStorage($this->shop['s_id']);
        $record = $pay_model->findUpdateByNumber($tid);
        //记录存在
        if ($record) {
            $this->_respond_weixin_notify(false, '订单已支付');
        }
        $attach         = json_decode($ret['attach'], true);
        $data = array(
            'akp_s_id'   => $this->shop['s_id'],
            'akp_number' => $tid,
            'akp_category' => $attach['categoryId'],
            'akp_create_time' => time(),
            'akp_money'       => intval($ret['total_fee'])/100,
            'akp_pay_type'    => 1
        );
        $pay_model->insertValue($data);
        $this->_respond_weixin_notify(true, 'OK');
    }

    /*
     * 小程序餐饮预支付订单交易通知
     */
    public function mealPaymentNotifyAppletAction() {
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        //扫码支付订单号特殊处理
        $code   = substr($tid, -6);
        if ($code == 'native') {
            $tid    = substr($tid, 0, strlen($tid)-6);
        }
        $trade_model= new App_Model_Trade_MysqlTradeStorage($this->shop['s_id']);
        $trade      = $trade_model->findUpdateTradeByTid($tid);
        //订单不存在，或者非待支付订单
        if (!$trade) {
            $trade_spare  = $trade_model->findUpdateTradeBySpareTid($tid);
            if(!$trade_spare){
                $this->_respond_weixin_notify(false, '订单不存在，或已支付');
            }
        }
        if($trade['t_payment']==0){
            $updata = array(
                't_payment'         => $ret['total_fee']/100,
            );
            $trade_model->findUpdateTradeByTid($tid, $updata);
        }
        $this->_respond_weixin_notify(true, 'OK');
    }

    /*
     * 问答小程序 提问支付
     */
    public function appletHousePayAction() {
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        $pay_model = new App_Model_House_MysqlHouseOrderStorage($this->shop['s_id']);
        $record = $pay_model->findUpdateByNumber($tid);
        //记录存在
        if ($record) {
            $this->_respond_weixin_notify(false, '订单已支付');
        }
        $attach         = json_decode($ret['attach'], true);
        $data = array(
            'aho_s_id' => $this->shop['s_id'],
            'aho_m_id' => $attach['mid'],
            'aho_t_id' => $tid,
            'aho_type' => $attach['type'],
            'aho_payment' => $attach['fee'],
            'aho_status' => 1,
            'aho_create_time' => time(),
            'aho_top_time' => $attach['topTime'],
            'aho_pay_time' => time(), //余额支付,
        );
        $pay_model->insertValue($data);
        $this->_respond_weixin_notify(true, 'OK');
    }

    /**
     * 购买合伙人等级
     */
    public function appletCopartnerLevelPayAction(){
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        $pay_model = new App_Model_Copartner_MysqlCopartnerRecordStorage($this->shop['s_id']);
        $record = $pay_model->findUpdateByNumber($tid);
        //记录存在
        if ($record) {
            $this->_respond_weixin_notify(false, '订单已支付');
        }
        $attach         = json_decode($ret['attach'], true);

        $extra_model = new App_Model_Member_MysqlMemberExtraStorage($this->shop['s_id']);
        $extra = $extra_model->findUpdateExtraByMid($this->member['m_id']);
        if($extra){
            $set['ame_copartner'] = $attach['lid'];
            $set['ame_weixin'] = $attach['weixin'];
            $ret = $extra_model->findUpdateExtraByMid($this->member['m_id'], $set);
        }else{
            $extraUpdata['ame_s_id'] = $this->shop['s_id'];
            $extraUpdata['ame_m_id'] = $attach['mid'];
            $extraUpdata['ame_copartner'] = $attach['lid'];
            $extraUpdata['ame_weixin'] = $attach['weixin'];
            $ret = $extra_model->insertValue($extraUpdata);
        }
        if($ret){
            $data = array(
                'cr_tid' => $tid,
                'cr_lid' => $attach['lid'],
                'cr_s_id' => $this->shop['s_id'],
                'cr_m_id' => $attach['mid'],
                'cr_payment' => $attach['fee'],
                'cr_pay_type' => 1,
                'cr_create_time' => time()
            );
            $pay_model->insertValue($data);
        }
        if($attach['fid'] == 0){
            $update = array('m_is_highest'=>1);
            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
            $member_model->updateById($update,$attach['mid']);
        }
        //设置各级佣金提成
        $order_deduct   = new App_Helper_OrderDeduct($this->shop['s_id']);
        $order_deduct->completeOrderDeduct($tid, $attach['mid']);
        $this->_respond_weixin_notify(true, 'OK');
    }

    /*
     * 小程序商城订单交易通知
     */
    public function merchantTradeNotifyAction() {
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        //扫码支付订单号特殊处理
        $code   = substr($tid, -6);
        if ($code == 'native') {
            $tid    = substr($tid, 0, strlen($tid)-6);
        }
        $trade_model= new App_Model_Merchant_MysqlMerchantTradeStorage();
        $trade      = $trade_model->findUpdateTradeByTid($tid);
        $curr_sid = $trade['mt_s_id'];
        $status = intval($trade['mt_status']);
        if ($status >= App_Helper_MerchantTrade::TRADE_WAIT_PAY_RETURN && $trade['mt_pay_trade_no']) {
            $this->_respond_weixin_notify(false, "订单已支付，勿重复通知:{$tid}");
        }

        $updata = array(
            'mt_pay_type'        => App_Helper_MerchantTrade::TRADE_PAY_WXZFZY,
            'mt_pay_trade_no'    => $ret['transaction_id'],
            'mt_status'          => App_Helper_MerchantTrade::TRADE_WAIT_PAY_RETURN, //支付完成待确认状态
            'mt_pay_time'        => time(),
            'mt_payment'         => $ret['total_fee']/100,
        );
        //记录待结算交易
        $trade_helper   = new App_Helper_MerchantTrade($curr_sid);
        $trade_helper->recordPendingSettled($tid, $trade['mt_total'], $trade['mt_title'], $curr_sid);

        $trade_model->findUpdateTradeByTid($tid, $updata);

        plum_open_backend('index', 'merchantTradeBack', array('sid' => $curr_sid, 'tid' => $tid));
        $this->_respond_weixin_notify(true, 'OK');
    }

    /*
     * 二手车支付
     */
    public function appletCarPostPayAction() {
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        $pay_model = new App_Model_Car_MysqlCarPostPayStorage($this->shop['s_id']);
        $record = $pay_model->findUpdateByNumber($tid);
        //记录存在
        if ($record) {
            $this->_respond_weixin_notify(false, '订单已支付');
        }
        $attach         = json_decode($ret['attach'], true);
        $data = array(
            'cpp_s_id'   => $this->shop['s_id'],
            'cpp_m_id'   => $attach['mid'],
            'cpp_number' => $tid,
            'cpp_create_time' => time(),
            'cpp_time'    => isset($attach['topTime']) && $attach['topTime'] ? $attach['topTime'] : 0,
            'cpp_money'       => intval($ret['total_fee'])/100,
            'cpp_type'        => $attach['type']
        );
        $pay_model->insertValue($data);
//        $resource_model = new App_Model_City_MysqlCityPostStorage($this->shop['s_id']);
//        $resource = $resource_model->findUpdateByNumber($tid);
//        if($resource){
//            $dateTime = 0;
//            if($attach['topTime']){
//                $topDate = intval($attach['topTime']);
//                $dateTime = $topDate*60*60*24;
//                $expiration = intval(time()+$dateTime);
//                $data = array();
//                $data['acp_top_date'] = $topDate;
//                $data['acp_istop'] = 1;
//                $data['acp_istop_expiration'] = $expiration;
//                $data['acp_pay_time'] = time();
//                $resource_model->updateById($data, $resource['acp_id']);
//                $applet_redis = new App_Model_Applet_RedisAppletStorage($this->shop['s_id']);
//                $applet_redis->recordTopPostTask($resource['acp_id'], $dateTime);
//            }
//        }
        //是否开通分销功能
        $order_deduct   = new App_Helper_OrderDeduct($this->shop['s_id']);
        $order_deduct->completeOrderDeduct($tid, $attach['mid']);
        $this->_respond_weixin_notify(true, 'OK');
    }

    /*
     * 小程序跑腿订单交易通知
     */
    public function legworkTradeNotifyAppletAction() {
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        //扫码支付订单号特殊处理
        $code   = substr($tid, -6);
        if ($code == 'native') {
            $tid    = substr($tid, 0, strlen($tid)-6);
        }
        $trade_model= new App_Model_Legwork_MysqlLegworkTradeStorage($this->shop['s_id']);
        $trade      = $trade_model->findUpdateTradeByTid($tid);

        $status = intval($trade['alt_status']);
        if ($status >= App_Helper_Legwork::TRADE_WAIT_PAY_RETURN && $trade['alt_pay_trade_no']) {
            $this->_respond_weixin_notify(false, "订单已支付，勿重复通知:{$tid}");
        }

        $updata = array(
            'alt_pay_type'        => App_Helper_Legwork::TRADE_PAY_WXZFZY,
            'alt_pay_trade_no'    => $ret['transaction_id'],
            'alt_status'          => App_Helper_Legwork::TRADE_WAIT_PAY_RETURN, //支付完成待确认状态
            'alt_pay_time'        => time(),
            'alt_payment'         => $ret['total_fee']/100,
        );
        $trade_model->findUpdateTradeByTid($tid, $updata);
       //todo 订单活动后续处理
        plum_open_backend('index', 'legworkTradeBack', array('sid' => $this->shop['s_id'], 'tid' => $tid));
        //todo 发送模板消息
        //plum_open_backend('index', 'wxappTempl', array('sid' => $this->shop['s_id'], 'tid' => $tid, 'type' => App_Helper_WxappApplet::SEND_SETUP_ZFCG));
        $this->_respond_weixin_notify(true, 'OK');
    }

    /*
     * 小程序礼品卡订单交易通知
     */
    public function giftcardTradeNotifyAppletAction() {
//        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        //扫码支付订单号特殊处理
        $code   = substr($tid, -6);
        if ($code == 'native') {
            $tid    = substr($tid, 0, strlen($tid)-6);
        }
        $trade_model= new App_Model_Giftcard_MysqlGiftCardTradeStorage($this->shop['s_id']);
        $trade      = $trade_model->findUpdateTradeByTid($tid);

        $status = intval($trade['agct_status']);
        if ($status >= 2 && $trade['agct_pay_trade_no']) {
            $this->_respond_weixin_notify(false, "订单已支付，勿重复通知:{$tid}");
        }

        $updata = array(
            'agct_pay_type'        => App_Helper_Giftcard::TRADE_PAY_WXZFZY,
            'agct_pay_trade_no'    => $ret['transaction_id'],
            'agct_status'          => 2, //支付完成待确认状态
            'agct_pay_time'        => time(),
            'agct_payment'         => $ret['total_fee']/100,
        );
        $trade_model->findUpdateTradeByTid($tid, $updata);
        //todo 订单活动后续处理
        plum_open_backend('index', 'giftcardTradeBack', array('sid' => $this->shop['s_id'], 'tid' => $tid));
        //plum_open_backend('index', 'wxappTempl', array('sid' => $this->shop['s_id'], 'tid' => $tid, 'type' => App_Helper_WxappApplet::SEND_SETUP_ZFCG));
        $this->_respond_weixin_notify(true, 'OK');
    }


    /*
   * 小程序支付成功(支付宝支付成功回调)
   */
    public function orderSuccessAliNotifyAction() {
        // 第一步先验证签名
        $this->_verify_notify_new();
        $ret        = $_POST;
        //第二步判断支付返回状态
        if($ret['trade_status']!='TRADE_SUCCESS'){
            $this->_respond_alipay_notify(false, '订单状态不正确');
        }
        $tid = $ret['out_trade_no'];
        $trade_model= new App_Model_Trade_MysqlTradeStorage($this->shop['s_id']);
        $trade      = $trade_model->findUpdateTradeByTid($tid);
        //订单不存在，或者非待支付订单
        if (!$trade) {
            $this->_respond_alipay_notify(false, '订单不存在，或已支付');
        }
        //订单金额不符
        if ($ret['buyer_pay_amount'] != $trade['t_total_fee']) {
            App_Helper_Tool::sendMail("支付费用不一致", array('wx_fee' => $ret['total_fee'], 'tdt_fee' => $trade['t_total_fee']));
            $this->_respond_alipay_notify(false, "支付宝支付费用不一致:{$tid}");
        }
        $status = intval($trade['t_status']);
        if ($status >= App_Helper_Trade::TRADE_WAIT_PAY_RETURN && $trade['t_pay_trade_no']) {
            $this->_respond_alipay_notify(false, "订单已支付，勿重复通知:{$tid}");
        }
        $updata = array(
            't_pay_type'        => App_Helper_Trade::TRADE_PAY_ZFBZFDX,
            't_pay_trade_no'    => $ret['trade_no'],
            't_status'          => App_Helper_Trade::TRADE_WAIT_PAY_RETURN,//等待支付完成确认状态
            't_pay_time'        => time(),
            't_payment'         => $ret['buyer_pay_amount'],
        );
        $trade_model->findUpdateTradeByTid($tid, $updata);
        //订单活动后续处理
        plum_open_backend('index', 'tradeBack', array('sid' => $this->shop['s_id'], 'tid' => $tid));
        $this->_respond_alipay_notify();
    }

    private function _respond_alipay_notify($type = true, $msg = '') {
        Libs_Log_Logger::outputLog("支付宝支付回调通知{$msg}");
        if ($type)  {
            echo "success";
        } else {
            echo "fail";
            exit;
        }
    }

    /*
    * 支付宝小程序支付成功验签
    */
    private function _verify_notify_new() {
        $alixcx_conf = plum_parse_config('third_app', 'alixcx');
        $arr         = $_POST;
        $arr['fund_bill_list'] = stripslashes($arr['fund_bill_list']);
        $alipaySevice = new App_Plugin_Alixcx_XcxClient(0);
        $result = $alipaySevice->checkSign($arr);
        if ($result) {
            Libs_Log_Logger::outputLog("支付宝支付验签成功");
        } else {
            Libs_Log_Logger::outputLog($arr);
            echo "fail";
            die();
        }
    }

    /*
     * 付费问答微信支付回调
     */
    public function appletAnswerpayNotifyAction(){
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        $pay_model = new App_Model_Answerpay_MysqlAnswerpayPayRecordStorage($this->shop['s_id']);
        $record = $pay_model->findUpdateByNumber($tid);
        //记录存在
        if ($record) {
            $this->_respond_weixin_notify(false, '订单已支付');
        }
        $attach         = json_decode($ret['attach'], true);
        $money = intval($ret['total_fee'])/100;
        $data = array(
            'aapr_s_id' => $this->shop['s_id'],
            'aapr_m_id' => $attach['mid'],
            'aapr_money' => $money,
            'aapr_type' => $attach['type'],
            'aapr_pay_type' => 1,
            'aapr_question_type' => $attach['qType'],
            'aapr_number' => $tid,
            'aapr_create_time' => time()
        );
        if($attach['type'] == 2){
            $data['aapr_buy_id'] = $attach['aid'];
//            $buy_model = new App_Model_Answerpay_MysqlAnswerpayAnswerBuyStorage($this->shop['s_id']);
//            $buy_insert = [
//                'aaab_s_id' => $this->shop['s_id'],
//                'aaab_m_id' => $attach['mid'],
//                'aaab_a_id' => $attach['aid'],
//                'aaab_a_type' => $attach['qType'],
//                'aaab_create_time' => $_SERVER["REQUEST_TIME"]
//            ];
//            $buy_model->insertValue($buy_insert);
            plum_open_backend('index', 'dealAnswerBuy', array('sid' => $this->shop['s_id'], 'mid' => $attach['mid'], 'aid' => $attach['aid'], 'qType' => $attach['qType'], 'money' => $money));

        }

        $pay_model->insertValue($data);


        $this->_respond_weixin_notify(true, 'OK');
    }


    /*
     * 小程序跑腿订单交易通知
     */
    public function handyTradeNotifyAppletAction() {
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        //扫码支付订单号特殊处理
        $code   = substr($tid, -6);
        if ($code == 'native') {
            $tid    = substr($tid, 0, strlen($tid)-6);
        }
        $trade_model= new App_Model_Handy_MysqlHandyTradeStorage($this->shop['s_id']);
        $trade      = $trade_model->findUpdateTradeByTid($tid);

        $status = intval($trade['aht_status']);
        if ($status >= App_Helper_Handy::TRADE_WAIT_PAY_RETURN && $trade['aht_pay_trade_no']) {
            $this->_respond_weixin_notify(false, "订单已支付，勿重复通知:{$tid}");
        }

        $updata = array(
            'aht_pay_type'        => App_Helper_Handy::TRADE_PAY_WXZFZY,
            'aht_pay_trade_no'    => $ret['transaction_id'],
            'aht_status'          => App_Helper_Handy::TRADE_WAIT_PAY_RETURN, //支付完成待确认状态
            'aht_pay_time'        => time(),
            'aht_payment'         => $ret['total_fee']/100,
        );
        $trade_model->findUpdateTradeByTid($tid, $updata);
        //todo 订单活动后续处理
        plum_open_backend('index', 'handyTradeBack', array('sid' => $this->shop['s_id'], 'tid' => $tid));
        //todo 发送模板消息
        //plum_open_backend('index', 'wxappTempl', array('sid' => $this->shop['s_id'], 'tid' => $tid, 'type' => App_Helper_WxappApplet::SEND_SETUP_ZFCG));
        $this->_respond_weixin_notify(true, 'OK');
    }




    /*
     * 小程序跑腿订单交易通知
     */
    public function handyDepositNotifyAppletAction() {
        //获取通知的数据
        $ret    = $this->_weixin_notify_base_verify_applet();
        if (!$ret) {
            $this->_respond_weixin_notify(false, '未知错误');
        }
        $tid    = $ret['out_trade_no'];
        //扫码支付订单号特殊处理
        $code   = substr($tid, -6);
        if ($code == 'native') {
            $tid    = substr($tid, 0, strlen($tid)-6);
        }
        $trade_model= new App_Model_Handy_MysqlHandyRiderDepositStorage($this->shop['s_id']);
        $trade      = $trade_model->findUpdateTradeByTid($tid);

        $status = intval($trade['ahrd_status']);
        if ($status > 1 && $trade['ahrd_pay_trade_no']) {
            $this->_respond_weixin_notify(false, "订单已支付，勿重复通知:{$tid}");
        }

        $updata = array(
            'ahrd_pay_trade_no'    => $ret['transaction_id'],
            'ahrd_status'          => 2, //已支付
            'ahrd_pay_time'        => time(),
        );
        $trade_model->findUpdateTradeByTid($tid, $updata);

        //更新申请信息支付状态
        $rider_update = [
            'ahr_deposit_status' => 2,
            'ahr_audit' => 1
        ];
        $rider_model = new App_Model_Handy_MysqlHandyRiderStorage($this->shop['s_id']);
        $rider_model->findUpdateRiderByTid($tid,$rider_update);

        //todo 订单活动后续处理
//        plum_open_backend('index', 'legworkTradeBack', array('sid' => $this->shop['s_id'], 'tid' => $tid));
        //todo 发送模板消息
        //plum_open_backend('index', 'wxappTempl', array('sid' => $this->shop['s_id'], 'tid' => $tid, 'type' => App_Helper_WxappApplet::SEND_SETUP_ZFCG));
        $this->_respond_weixin_notify(true, 'OK');
    }


}
