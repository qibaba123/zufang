<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/25
 * Time: 上午11:00
 */
class App_Helper_Trade {

    const TRADE_NO_CREATE_PAY       = 0;//没有创建支付交易,默认
    const TRADE_NO_PAY              = 1;//未付款、待付款
    const TRADE_WAIT_PAY_RETURN     = 2;//等待支付成功确认
    const TRADE_WAIT_GROUP          = 2;//等待成团,已支付,待组团成功
    const TRADE_HAD_PAY             = 3;//已支付、待发货
    const TRADE_SHIP                = 4;//已发货、待收货
    const TRADE_ACCEPT              = 5;//已确认收货,临时
    const TRADE_FINISH              = 6;//交易完成
    const TRADE_CLOSED              = 7;//交易关闭
    const TRADE_REFUND              = 8;//退款交易

    const TRADE_LOTTERY_WAIT_DRAW   = 10;//抽奖团,拼团成功,待抽奖
    const TRADE_AUCTION_NO_PAY   = 11;//拍卖，拍卖成功，未付款

    const TRADE_NORMAL      = 0;//普通订单
    const TRADE_GROUP       = 1;//拼团订单
    const TRADE_LOTTERY     = 2;//抽奖订单
    const TRADE_SECKILL     = 3;//秒杀订单
    const TRADE_POINT       = 4;//积分订单
    const TRADE_APPLET      = 5;//小程序订单
    const TRADE_APPOINTMENT = 6;//小程序通用付费预约订单
    const TRADE_AUCTION     = 7;//小程序拍卖订单
    //const TRADE_COMMUNITY_APPO = 8;//小程序 多店预约订单
    const TRADE_CASHIER     = 9;//收银台订单


    const TRADE_ORDER_NORMAL    = 0;//普通
    const TRADE_ORDER_SECKILL   = 1;//秒杀
    const TRADE_ORDER_GROUP     = 2;//拼团
    const TRADE_ORDER_LOTTERY   = 3;//抽奖
    const TRADE_ORDER_POINT     = 4;//积分
    const TRADE_ORDER_BARGAIN   = 5;//砍价
    const TRADE_ORDER_MEETING   = 6;//会议
    const TRADE_ORDER_RESERVATION   = 7;//预约版商城类型订单
    const TRADE_ORDER_TRAIN     = 8;//培训
    const TRADE_ORDER_WEDDING   = 9;//婚纱
    const TRADE_ORDER_AUCTION   = 10;//拍卖
    const TRADE_ORDER_SEQUENCE   = 11;//社区团购

    const TRADE_APPLET_NORMAL    = 0;//普通
    const TRADE_APPLET_SECKILL   = 1;//秒杀
    const TRADE_APPLET_GROUP     = 2;//拼团
    const TRADE_APPLET_LOTTERY   = 3;//抽奖
    const TRADE_APPLET_POINT     = 4;//积分
    const TRADE_APPLET_BARGAIN   = 5;//砍价
    const TRADE_APPLET_TRAIN     = 8;//培训
    const TRADE_APPLET_WEDDING   = 9;//婚纱
    const TRADE_APPLET_SEQUENCE  = 11;//社区团购

    const GROUP_TRADE_OVER_TIME = 86400;//拼团活动超时时间
    /*
     * 交易状态描述信息
     */
    public static $trade_status_desc    = array(
        self::TRADE_NO_CREATE_PAY   => '没有创建支付的交易',
        self::TRADE_NO_PAY          => '未付款/待付款的交易',
        self::TRADE_WAIT_GROUP      => '等待买家组团成功的交易',
        self::TRADE_HAD_PAY         => '已付款/待发货的交易',
        self::TRADE_SHIP            => '已发货/待收货的交易',
        self::TRADE_ACCEPT          => '已确认收货的交易',
        self::TRADE_FINISH          => '已完成的交易',
        self::TRADE_CLOSED          => '已关闭的交易',
        self::TRADE_REFUND          => '退款的交易',
    );
    public static $trade_status    = array(
        self::TRADE_NO_CREATE_PAY   => '未提交',
        self::TRADE_NO_PAY          => '未付款',
        self::TRADE_WAIT_GROUP      => '待成团',
        self::TRADE_HAD_PAY         => '已付款',
        self::TRADE_SHIP            => '已发货',
        self::TRADE_ACCEPT          => '已确认',
        self::TRADE_FINISH          => '已完成',
        self::TRADE_CLOSED          => '已关闭',
        self::TRADE_REFUND          => '退款',
    );

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
        'tuan'   => array(
            'id'    => self::TRADE_WAIT_PAY_RETURN ,
            'label' => '待成团'
        ),
        'hadpay'   => array(
            'id'    => self::TRADE_HAD_PAY,
            'label' => '待发货'
        ),
        'ship'   => array(
            'id'    => self::TRADE_SHIP,
            'label' => '已发货'
        ),
        'finish'   => array(
            'id'    => self::TRADE_FINISH,
            'label' => '已完成'
        ),
        'closed'   => array(
            'id'    => self::TRADE_CLOSED,
            'label' => '已关闭'
        ),
        'refund'   => array(
            'id'    => self::TRADE_REFUND,
            'label' => '已退款'
        ),
    );

    /**
     * @var array
     * 维权交易状态菜单链接
     */
    public static $trade_refund_link_status    = array(
        'all'   => array(
            'id'    => 0,
            'label' => '全部'
        ),
        'rights'   => array(
            'id'    => self::FEEDBACK_YES ,
            'label' => '维权中'
        ),
        'closure'   => array(
            'id'    => self::FEEDBACK_OVER ,
            'label' => '维权结束'
        ),

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
    const FEEDBACK_REFUND_ACCOUNTANT    = 4;//等待会计处理的退款操作

    const FEEDBACK_RESULT_WAIT          = 0;//等待处理
    const FEEDBACK_RESULT_REFUSE        = 1;//拒绝退款
    const FEEDBACK_RESULT_AGREE         = 2;//同意退款
    const FEEDBACK_RESULT_CANCEL        = 3;//买家撤销维权

    const TRADE_SETTLED_PENDING         = 0;//结算订单进行中
    const TRADE_SETTLED_SUCCESS         = 1;//结算成功
    const TRADE_SETTLED_REFUND          = 2;//退款订单,结算失败

    const TRADE_PAY_WXZFZY              = 1;//微信支付--自有
    const TRADE_PAY_WXZFDX              = 2;//微信支付--代销
    const TRADE_PAY_ZFBZFDX             = 3;//支付宝支付  //支付宝支付--代销
    const TRADE_PAY_HDFK                = 4;//货到付款
    const TRADE_PAY_YEZF                = 5;//余额支付
    const TRADE_PAY_YHQM                = 6;//优惠全免
    const TRADE_PAY_JFZF                = 7;//积分支付
    const TRADE_PAY_XJZF                = 8;//现金支付
    const TRADE_PAY_HHZF                = 9;//混合支付 微信+余额支付
    const TRADE_PAY_VCMZF               = 10;//微财猫储值卡支付
    const TRADE_PAY_VCMWXZF             = 11;//微财猫微信支付
    const TRADE_PAY_QQZF                = 12;//QQ财付通支付
   /* const TRADE_PAY_WXFACE              = 13;//微信刷脸支付*/

    const FEEDBACK_REFUND_HANDLE        = 1;// 退款订单已处理

    public static $trade_pay_type       = array(
        self::TRADE_PAY_WXZFZY  => '微信支付--自有',
        self::TRADE_PAY_WXZFDX  => '微信支付--代销',
        self::TRADE_PAY_ZFBZFDX => '支付宝支付',   //支付宝支付--代销
        self::TRADE_PAY_HDFK    => '货到付款',
        self::TRADE_PAY_YEZF    => '余额支付',
        self::TRADE_PAY_YHQM    => '优惠全免',
        self::TRADE_PAY_XJZF    => '现金支付',
        self::TRADE_PAY_JFZF    => '积分支付',
        self::TRADE_PAY_HHZF    => '微信支付+余额抵扣',
        self::TRADE_PAY_VCMZF   => '储值卡支付',
        self::TRADE_PAY_VCMWXZF => '微信支付',
        self::TRADE_PAY_QQZF    => 'QQ财付通支付',
    );
    // 对用户展示使用
    public static $trade_pay_type_note       = array(
        self::TRADE_PAY_WXZFZY  => '在线支付',  // 微信支付
        self::TRADE_PAY_WXZFDX  => '在线支付',  // 微信支付
        self::TRADE_PAY_ZFBZFDX => '在线支付',  // 支付宝支付
        self::TRADE_PAY_HDFK    => '货到付款',
        self::TRADE_PAY_YEZF    => '余额支付',
        self::TRADE_PAY_YHQM    => '优惠全免',
        self::TRADE_PAY_XJZF    => '现金支付',
        self::TRADE_PAY_HHZF    => '微信支付+余额抵扣',
        self::TRADE_PAY_VCMZF   => '微信储值卡支付',
        self::TRADE_PAY_VCMWXZF => '微信支付',
        self::TRADE_PAY_QQZF    => 'QQ财付通支付',
    );
    public static $trade_type    = array(
        self::TRADE_NORMAL   => '普通订单',
        self::TRADE_GROUP    => '拼团订单',
        self::TRADE_LOTTERY  => '抽奖订单',
    );

    public static $trade_applet_type    = array(
        self::TRADE_APPLET_NORMAL   => '普通订单',
        self::TRADE_APPLET_SECKILL => '秒杀订单',
        self::TRADE_APPLET_GROUP    => '拼团订单',
        self::TRADE_APPLET_LOTTERY  => '抽奖订单',
        self::TRADE_APPLET_POINT  => '积分订单',
        self::TRADE_APPLET_SEQUENCE => '普通订单'
    );

    const TRADE_MESSAGE_SEND_MJXD   = 1;//买家下单
    const TRADE_MESSAGE_SEND_CFDD   = 2;//催付订单
    const TRADE_MESSAGE_SEND_ZFCG   = 3;//支付成功
    const TRADE_MESSAGE_SEND_MJFH   = 4;//卖家发货
    const TRADE_MESSAGE_SEND_MJSH   = 5;//买家收货
    const TRADE_MESSAGE_SEND_MJTK   = 6;//买家退款
    const TRADE_MESSAGE_SEND_TKCG   = 7;//退款成功
    const TRADE_MESSAGE_SEND_TKSB   = 8;//退款失败
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

    public function __construct($sid){
        $this->sid  = $sid;
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage($sid);
        $this->shop = $shop_model->getRowById($sid);
        $this->hold_dir     = PLUM_APP_BUILD.'/spread/';
        $this->access_path  = PLUM_PATH_PUBLIC.'/build/spread/';
    }
 
  
      //订单分佣
    public function returnTrade($tid){
      
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade       = $trade_model->findUpdateTradeByTid($tid);
     
        //交易佣金提成通知
        $order_deduct = new App_Helper_OrderDeduct($this->sid);
        return $order_deduct->completeOrderDeduct($tid, $trade['t_m_id']);
    }


  
    /*
     * 关闭超时未支付的订单
     * $tid 订单ID,非订单号
     */
  public function closeOvertimeTrade($tid) {

        $trade_model = new App_Model_Trade_MysqlReserveTradeStorage();
        $trade      = $trade_model->getRowById($tid);
        if (!$trade) {
            return false;
        }
       //如果是园区商品  库存减一
       if($trade['rt_type'] == 1){
          $house_model   = new App_Model_Resources_MysqlResourcesStorage();
          $house         = $house_model->getRowById($trade['rt_g_id']);
          $update['ahr_stock'] = $house['ahr_stock'] + 1;
          $house_model->updateById($update,$trade['rt_g_id']);
       }
       //订单状态变成已关闭
        $updata = array(
            'rt_status'  => 4,
        );

        return $trade_model->updateById($updata, $trade['t_id']);

    }
    /*
     * 完成超时未确认订单
     * @param int $tid 订单自增ID,非订单编号
     */
    public function completeOvertimeTrade($tid) {
        $trade_model= new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade      = $trade_model->getRowById($tid);

        $cfg_model = new App_Model_Applet_MysqlCfgStorage($this->sid);
        $appletCfg = $cfg_model->findShopCfg();
        //订单查找失败
        if (!$trade) {
            return false;
        }
        // 有维权处理且未处理完成
        if($trade['t_fd_status'] > 0 && $trade['t_fd_status'] != 3){
            return false;
        }

        //订单处于已发货状态
        if ($trade['t_status'] == self::TRADE_SHIP || $trade['t_status'] == self::TRADE_ACCEPT || ($trade['t_status'] == self::TRADE_HAD_PAY && ($appletCfg['ac_type'] == 32 || $appletCfg['ac_type'] == 36))) {
            if($appletCfg['ac_type'] == 32 || $appletCfg['ac_type'] == 36){
                $sequence_helper = new App_Helper_Sequence($this->sid);
                $sequence_helper->dealSequenceVerify($trade,0);

                //获得该订单所有未核销商品
                $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
                $orderIds = [];
                $where_order = [];
                $where_order[] = ['name'=>'to_t_id','oper'=>'=','value'=>$trade['t_id']];
                $where_order[] = ['name'=>'to_se_verify','oper'=>'=','value'=>0];
                $order_list = $order_model->getList($where_order,0,0);
                foreach ($order_list as $order){
                    $orderIds[] = $order['to_id'];
                }
                if(!empty($orderIds)){
                    $where_order = [];
                    $set = [
                        'to_se_verify' => 1,
                        'to_se_verify_time' => time()
                    ];
                    $where_order[] = ['name'=>'to_id','oper'=>'in','value'=>$orderIds];
                    $order_model->updateValue($set,$where_order);
                }


                // 添加社区团购区域管理合伙人--佣金记录的状态回写
                $region_brokerage_model=new App_Model_Sequence_MysqlSequenceRegionBrokerageStorage($this->sid);
                $region_res=$region_brokerage_model->updateValue(
                    [
                        'armb_status'   =>1,
                        'armb_update_at'=>time()
                    ],
                    [
                        ['name'=>'armb_tid','oper'=>'=','value'=>$trade['t_tid']]
                    ]
                );

            }else{
                //是否触发通知
                $this->sendTradeStatusMessage($trade['t_tid'], self::TRADE_MESSAGE_SEND_MJSH);
                $this->dealCompleteTrade($trade);//处理订单完成后续
                //增加商品销量
                $this->modifyGoodsSold($trade['t_id']);
                //清除自动完成状态定时,防止二次调用
                $trade_redis    = new App_Model_Trade_RedisTradeStorage($this->sid);
                $trade_redis->delTradeFinish($trade['t_id']);
                //清除待结算状态 确认收货7天后再结算
                $settled_model  = new App_Model_Trade_MysqlTradeSettledStorage($this->sid);
                $settled        = $settled_model->findSettledByTid($trade['t_tid']);
                if ($settled && $settled['ts_status'] == self::TRADE_SETTLED_PENDING) {
                    $set = array('ts_order_finish_time' => time());
                    $settled_model->updateById($set, $settled['ts_id']);
                    if($this->shop['s_enter_settle'] > 0){
                        $countdown   = plum_parse_config('trade_overtime');
                        $trade_redis = new App_Model_Trade_RedisTradeStorage($this->sid);
                        $trade_redis->setTradeSettledTtl($settled['ts_id'], $this->shop['s_enter_settle']?$this->shop['s_enter_settle']*24*60*60:$countdown['settled']);
                    }else{
                        $trade_redis->delTradeSettledTtl($settled['ts_id']);
                        if($trade['t_es_id']>0){
                            $this->recordEnterShopSuccessSettled($settled['ts_id']);
                        }else{
                            $this->recordSuccessSettled($settled['ts_id']);
                        }
                    }
                }
                if($this->shop['s_return_time'] > 0){
                    $trade_redis = new App_Model_Trade_RedisTradeStorage($this->sid);
                    $trade_redis->setTradeReturn($tid,$this->shop['s_return_time'] * 24 * 60 * 60);
                }else{
                    //交易佣金完成通知
                    $order_deduct   = new App_Helper_OrderDeduct($this->sid);
                    $order_deduct->completeOrderDeduct($trade['t_tid'], $trade['t_m_id']);
                }

            }

            //修改状态
            $updata = array(
                't_status'      => self::TRADE_FINISH,//置于完成状态
                't_finish_time' => time(),
                't_finish_type' => 2 //订单自动完成
            );
            return $trade_model->updateById($updata, $trade['t_id']);
        }
        return false;
    }

    /**
     * 判断用户会员等级, 输出商品会员价
     */
    public static function getGoodsVipPirce($price, $sid, $gid, $fid, $mid, $detail=0){
        $offline_member = new App_Model_Store_MysqlMemberStorage($sid);
        $where[]    = array('name' => 'om_s_id', 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'om_m_id', 'oper' => '=', 'value' => $mid);
        // 未删除的会员卡
        // zhangzc
        // 2019-09-26
        $where[]    = array('name' => 'om_deleted', 'oper' => '=', 'value' => 0);
        $where[]    = array('name' => 'om_expire_time', 'oper' => '>', 'value' => time());
        $member_card    = $offline_member->getList($where, 0, 0, array('om_update_time' => 'desc'));
        $identity = 0;
        $isVipPrice = 0;
        $level = 0;

        $applet_model   = new App_Model_Applet_MysqlCfgStorage($sid);
        $applet     = $applet_model->findShopCfg();

        if($member_card){//先查找是否买了会员卡
            $cardid = $member_card[0]['om_card_id'];
            $card_model = new App_Model_Store_MysqlCardStorage($sid);
            $card   = $card_model->getRowById($cardid);
            $identity = intval($card['oc_identity']);
            $level_model = new App_Model_Member_MysqlLevelStorage();
            $level = $level_model->getRowById($identity);
        }

        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_storage->findMemberByIdSid($mid, $sid);

        //本身设置了折扣并且有会员日折扣
        if(in_array($applet['ac_type'],[21,32]) && $identity && $card['oc_member_day'] > 0 && $card['oc_member_day'] <= 31 && $card['oc_member_day_discount'] > 0){
            $today = date('d');
            if(intval($today) == intval($card['oc_member_day'])){
                $level['ml_discount'] = $card['oc_member_day_discount'];
            }
        }

        if(!$level){//取会员的等级
            $identity = $member['m_level'];
            $level_model = new App_Model_Member_MysqlLevelStorage();
            $level = $level_model->getRowById($identity);
        }

        $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
        $goods = $goods_model->getRowById($gid);
        $goodsJoinDiscount = $goods['g_join_discount'];
        if($goods['g_es_id']){
            $shop_storage  = new App_Model_Entershop_MysqlEnterShopStorage();
            $enterShop = $shop_storage->getRowById($goods['g_es_id']);
            $goodsJoinDiscount = $enterShop['es_goods_join_discount'];
        }



        //获取储值折扣权益
        if($applet['ac_type'] == 21){
            $right_model = new App_Model_Member_MysqlRechargeRightStorage($sid);
            $discount = $right_model->findMaxRight($member['m_gold_coin']);
            if($discount){
                $level['ml_discount'] = ($level['ml_discount'] && $level['ml_discount'] < $discount)?$level['ml_discount']:$discount;
            }
        }

        if($goodsJoinDiscount){
            if($level['ml_discount']>0){
                // $price = number_format(floatval($price * ($level['ml_discount']/10)),2);
                $price = floatval($price * ($level['ml_discount']/10));
                $isVipPrice = 1;
            }
        }

        if($fid){
            $format_model   = new App_Model_Goods_MysqlFormatStorage($sid);
            $format = $format_model->getRowById($fid);
            $vipPriceList = json_decode($format['gf_vip_price_list'], true);
            if($vipPriceList){
                foreach ($vipPriceList as $value){
                    if($value['identity'] == $identity){
                        if($value['price'] > 0){
                            $isVipPrice = 1;
                            $price = $value['price']?floatval($value['price']):$format['gf_price'];
                        }
                    }
                }
            }
        }else{
            $vipPriceList = json_decode($goods['g_vip_price_list'], true);
            if($vipPriceList){
                foreach ($vipPriceList as $value){
                    if($value['identity'] == $identity){
                        if($value['price'] > 0){
                            $isVipPrice = 1;
                            $price = $value['price']?floatval($value['price']):$goods['g_price'];
                        }
                    }
                }
            }
        }
        $currPrice = round($price,2);//只保留两位小数
        if($detail){
            return array(
                'isVip' => $identity?1:0,
                'price' => floatval($currPrice),
                'isVipPrice' => $isVipPrice,
            );
        }else {
            return $currPrice;
        }
    }

    /**
     * 判断用户会员等级, 输出商品会员价 知识付费  没有规格 加个可以为0
     */
    public static function getKnowpayGoodsVipPirce($price, $sid, $gid, $fid, $mid, $detail=0){
        $offline_member = new App_Model_Store_MysqlMemberStorage($sid);
        $where[]    = array('name' => 'om_s_id', 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'om_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'om_expire_time', 'oper' => '>', 'value' => time());
        $member_card    = $offline_member->getList($where, 0, 0, array('om_update_time' => 'desc'));
        $identity = 0;
        $isVipPrice = 0;
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

        if($level['ml_discount']>0){
            $price = number_format(floatval($price * ($level['ml_discount']/10)),2);
            $isVipPrice = 1;
        }

        $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
        $goods = $goods_model->getRowById($gid);

        $vipPriceList = json_decode($goods['g_vip_price_list'], true);
        if($vipPriceList){
            foreach ($vipPriceList as $value){
                if($value['identity'] == $identity){
                    $isVipPrice = 1;
                    $price = floatval($value['price']);
                }
            }
        }

        if($detail){
            return array(
                'isVip' => $identity?1:0,
                'price' => $price,
                'isVipPrice' => $isVipPrice
            );
        }else {
            return $price;
        }
    }


    /**
     * 判断用户会员等级, 输出商品会员价 知识付费  没有规格 加个可以为0
     */
    public static function getTrainCourseVipPirce($price, $sid, $courseId, $fid, $mid, $detail=0){
        $offline_member = new App_Model_Store_MysqlMemberStorage($sid);
        $where[]    = array('name' => 'om_s_id', 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'om_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'om_expire_time', 'oper' => '>', 'value' => time());
        $member_card    = $offline_member->getList($where, 0, 0, array('om_update_time' => 'desc'));
        $identity = 0;
        $isVipPrice = 0;
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

        $course_model = new App_Model_Train_MysqlTrainCourseStorage($sid);
        $course = $course_model->getRowById($courseId);
        $join_discount = intval($course['atc_join_discount']);
        if($join_discount){
            if($level['ml_discount']>0){
                $price = number_format(floatval($price * ($level['ml_discount']/10)),2);
                $isVipPrice = 1;
            }

            $vipPriceList = json_decode($course['atc_vip_price_list'], true);
            if($vipPriceList){
                foreach ($vipPriceList as $value){
                    if($value['identity'] == $identity){
                        $isVipPrice = 1;
                        $price = floatval($value['price']);
                    }
                }
            }
        }




        if($detail){
            return array(
                'isVip' => $identity?1:0,
                'price' => $price,
                'isVipPrice' => $isVipPrice
            );
        }else {
            return $price;
        }
    }

    /*
     * 检查店铺是否有微信支付功能
     */
    public static function checkHasWxpay($sid,$applet = 0) {
        $paytype_model  = new App_Model_Trade_MysqlPayTypeStorage($sid);

        $paytype    = $paytype_model->findUpdateCfgBySid();
        if($applet){
            if ($paytype && $paytype['pt_wxpay_applet']) {
                return true;
            }
        }else{
            if ($paytype && $paytype['pt_wxpay_zy']) {
                return true;
            }
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

        // 将拆分开的付款信息写入到trade_order表中去
        // zhangzc
        // 2019-08-11
        // 获取订单中的t_payment
        // 获取子订单中所有商品的单价*数量 to_price * to_num
        // 计算出子订单中商品的价格占比 * payment 得出当前商品在子订单中的价格
        $trade_model=new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade_info =$trade_model->getRowById($tid);
        $payment    =$trade_info['t_payment'];
        $order_price_total=0;


        $goods_model    = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $trade_redis_model   = new App_Model_Trade_RedisTradeStorage($this->sid); //订单redis 类
        foreach ($list as $item) {
            //减少库存量
            $goods = $goods_model->getRowById($item['to_g_id']);
            if($goods['g_stock_type'] == 2){
              //单日库存类型，处理单日库存
              $goods_model->adjustDayStock($goods, -$item['to_num'], $item['to_gf_id']);
            }else{
                //总库存类型，处理总库存
                $is_reduce_success=$goods_model->adjustStock($item['to_g_id'], -$item['to_num'], $item['to_gf_id'],$this->shop);
                // 删除商品末端库存锁
                $trade_redis_model->sequenceDelGoodsStockLock($item['to_g_id'],$item['to_gf_id']);

                // 判断减库存是否成功如果成功的话写入库存的减去的记录
                // zhangzc
                // 2019-09-03
                $trade_record_model=new App_Model_Trade_MysqlTradeRecordStorage($this->sid);
                $record_data=[
                    'tsr_sid'   =>$this->sid,
                    'tsr_gfid'  =>$item['to_gf_id'],
                    'tsr_gid'   =>$item['to_g_id'],
                    'tsr_tid'   =>$tid,
                    'tsr_stock' =>$item['to_num'],
                    'tsr_type'  =>2,                //减库存
                    'tsr_reason'=>2,                //下单减库存
                    'tsr_class' =>__CLASS__,
                    'tsr_method'=>__METHOD__,
                    'tsr_ip'    =>$_SERVER['SERVER_ADDR'],
                    'tsr_create_time'=>time()
                ];
                if(!$is_reduce_success){
                    $record_data['tsr_status']=0;
                }
                $trade_record_model->insertValue($record_data);
            }

            // 拆分主订单中的金额到子订单中去
            // zhangzc
            // 2019-08-11
            $order_price=$item['to_price'];
            $order_num  =$item['to_num'];
            $order_fee  =$order_price * $order_num *100; //存储的是以分为单位
            $order_price_total  +=$order_fee;
        }


        // 拆分主订单中的金额到子订单中去
        // zhangzc
        // 2019-08-11
        foreach ($list as $key => $value) {
            $order_price=$value['to_price'];
            $order_num  =$value['to_num'];
            $order_fee  =$order_price * $order_num *100; //存储的是以分为单位
            $to_fee     =round($payment * ($order_fee / $order_price_total),2) *100;
            $xxx=$order_model->updateById(['to_fee'=>$to_fee,'to_update_time'=>time()],$value['to_id']);
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
    public function recordPendingSettled($tid, $amount, $title, $esId = 0) {
        $settled_model  = new App_Model_Trade_MysqlTradeSettledStorage($this->sid);

        $indata     = array(
            'ts_s_id'       => $this->sid,
            'ts_es_id'      => $esId,
            'ts_title'      => $title,
            'ts_tid'        => $tid,
            'ts_amount'     => $amount,
            'ts_status'     => self::TRADE_SETTLED_PENDING,//进行中
            'ts_create_time'=> time(),
        );

        $tsid  = $settled_model->insertValue($indata);

        //设置待结算订单完成倒计时
        $countdown  = plum_parse_config('trade_overtime');
        $trade_redis    = new App_Model_Trade_RedisTradeStorage($this->sid);
        $trade_redis->setTradeSettledTtl($tsid, $countdown['settled']);
    }

    /*
     * 修改待结算交易为成功
     */
    public function recordSuccessSettled($tsid) {
        $settled_model  = new App_Model_Trade_MysqlTradeSettledStorage($this->sid);
        $settled    = $settled_model->findUpdateSettled($tsid);
        if (!$settled || $settled['ts_status'] != self::TRADE_SETTLED_PENDING) {
            return;
        }
        //获取订单状态
        $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade  = $trade_model->findUpdateTradeByTid($settled['ts_tid']);

        if($trade['t_es_id'] == 0){
            if ($trade['t_status'] == self::TRADE_HAD_PAY) {
                //商家仍未发货,不可结算
                //设置待结算订单完成倒计时
                $countdown  = plum_parse_config('trade_overtime');
                $trade_redis    = new App_Model_Trade_RedisTradeStorage($this->sid);
                $trade_redis->setTradeSettledTtl($tsid, $countdown['settled']);
                return;
            }

            $updata = array(
                'ts_status'     => self::TRADE_SETTLED_SUCCESS,
                'ts_update_time'=> time(),
            );
            $settled_model->findUpdateSettled($tsid, $updata);
            $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
            $shop       = $shop_model->getRowById($this->sid);
            //扣除扣点后置于
            $balance    = intval(100*$shop['s_balance']);//单位分
            $point      = plum_parse_config('wxpay_point', 'weixin');
            $amount     = intval(100*$settled['ts_amount']);//单位分
            $less       = ceil($amount*$point);

            $inout_model    = new App_Model_Shop_MysqlShopInoutStorage($this->sid);
            //记录收入
            $indata     = array(
                'si_s_id'   => $this->sid,
                'si_name'   => "订单收入 ".$settled['ts_title'],
                'si_amount' => $amount/100,
                'si_balance'=> ($balance+$amount)/100,
                'si_type'   => 1,
                'si_create_time'    => time(),
                'si_tid'    => $settled['ts_tid']   // 订单编号
            );
            $ret = $inout_model->insertValue($indata);
            //记录支出
            $outdata    = array(
                'si_s_id'   => $this->sid,
                'si_name'   => "订单入账手续费 ".$settled['ts_title'],
                'si_amount' => $less/100,
                'si_balance'=> ($balance+$amount-$less)/100,
                'si_type'   => 2,
                'si_create_time'    => time(),
                'si_tid'    => $settled['ts_tid']   // 订单编号
            );
            $inout_model->insertValue($outdata);
            //修改余额
            if($ret){
                $shop_model->incrementShopBalance($this->sid, ($amount-$less)/100);
            }
        }else{
            $this->recordEnterShopSuccessSettled($tsid,$this->sid);
        }
    }

    /*
     * 修改待结算交易为成功
     */
    public function recordEnterShopSuccessSettled($tsid) {
        $settled_model  = new App_Model_Trade_MysqlTradeSettledStorage($this->sid);
        $settled    = $settled_model->findUpdateSettled($tsid);

        if (!$settled || $settled['ts_status'] != self::TRADE_SETTLED_PENDING) {
            return;
        }
        //获取订单状态
        $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade  = $trade_model->findUpdateTradeByTid($settled['ts_tid']);

        $updata = array(
            'ts_status'     => self::TRADE_SETTLED_SUCCESS,
            'ts_update_time'=> time(),
        );
        $settled_model->findUpdateSettled($tsid, $updata);
        $store_model = new App_Model_Entershop_MysqlEnterShopStorage();
        $shop       = $store_model->getRowById($trade['t_es_id']);

        $balance    = intval(100*$shop['es_balance']);//单位分
        $amount     = intval(100*$settled['ts_amount']);//单位分

        $inout_model    = new App_Model_Shop_MysqlShopInoutStorage($this->sid);
        // 查询是否已经添加收入记录
        $isInout = $inout_model->getInoutRowByTid($settled['ts_tid'],1);
        if($isInout && !empty($isInout)){  //已经结算过
            return;
        }
        //记录收入
        $indata     = array(
            'si_s_id'   => $this->sid,
            'si_es_id'  => $trade['t_es_id'],
            'si_name'   => "订单收入 ".$settled['ts_title'],
            'si_amount' => $amount/100,
            'si_balance'=> ($balance+$amount)/100,
            'si_type'   => 1,
            'si_create_time'    => time(),
            'si_tid'    => $settled['ts_tid']   // 订单编号
        );
        $ret = $inout_model->insertValue($indata);
        // 获取分佣比例
        $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->shop['s_id']);
        $appcfg = $appletPay_Model->findRowPay();
        if($shop['es_maid_proportion'] && $shop['es_maid_proportion']>0){
            $maid = $shop['es_maid_proportion']/100;
        }elseif($appcfg['ap_shop_percentage'] && $appcfg['ap_shop_percentage']>0){
            $maid = $appcfg['ap_shop_percentage']/100;
        }else{
            $maid      = plum_parse_config('wxpay_point', 'weixin');
        }
        $less       = ceil($amount*$maid); //订单抽成比例

       // $legwork_post = 0;
       // if($trade['t_express_method'] == 7 && $trade['t_legwork_extra']){
       //     $legworkExtra = json_decode($trade['t_legwork_extra'],1);
       //     $price = $legworkExtra['price'];
       //     $legwork_post = $price * 100;//单位分
       // }
        //记录支出
        $outdata    = array(
            'si_s_id'   => $this->sid,
            'si_es_id'  => $trade['t_es_id'],
            'si_name'   => "订单入账手续费 ".$settled['ts_title'],
            'si_amount' => $less/100,
            'si_balance'=> ($balance+$amount-$less)/100,
            'si_type'   => 2,
            'si_create_time'    => time(),
            'si_tid'    => $settled['ts_tid']   // 订单编号
        );
        $inout_model->insertValue($outdata);
        //记录跑腿配送费
       // if($legwork_post > 0){
       //     $legwork_out = [
       //         'si_s_id'   => $this->sid,
       //         'si_es_id'  => $trade['t_es_id'],
       //         'si_name'   => "配送费用 ".$settled['ts_title'],
       //         'si_amount' => $legwork_post/100,
       //         'si_balance'=> ($balance+$amount-$less-$legwork_post)/100,
       //         'si_type'   => 2,
       //         'si_create_time'    => time(),
       //         'si_tid'    => $settled['ts_tid']   // 订单编号
       //     ];
       //     $inout_model->insertValue($legwork_out);
       // }

        //修改余额
        if($ret){
            $store_model->incrementShopBalance($trade['t_es_id'], ($amount-$less)/100);
        }
    }

    /*
     * 记录实时到账交易
     */
    public function recordRealtimeTransfer($money, $title) {
        $money      = floatval($money);
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $shop       = $shop_model->getRowById($this->sid);
        //扣除扣点后置于
        $balance    = intval(100*$shop['s_balance']);//单位分
        $point      = plum_parse_config('wxpay_point', 'weixin');
        $amount     = intval(100*$money);//单位分

        $less       = ceil($amount*$point);

        $inout_model    = new App_Model_Shop_MysqlShopInoutStorage($this->sid);
        //记录收入
        $indata     = array(
            'si_s_id'   => $this->sid,
            'si_name'   => $title,
            'si_amount' => $amount/100,
            'si_balance'=> ($balance+$amount)/100,
            'si_type'   => 1,
            'si_create_time'    => time(),
        );
        $ret = $inout_model->insertValue($indata);
        //记录支出
        $outdata    = array(
            'si_s_id'   => $this->sid,
            'si_name'   => "入账手续费 ".$title,
            'si_amount' => $less/100,
            'si_balance'=> ($balance+$amount-$less)/100,
            'si_type'   => 2,
            'si_create_time'    => time(),
        );
        $inout_model->insertValue($outdata);

        //修改余额
        if($ret){
            $shop_model->incrementShopBalance($this->sid, ($amount-$less)/100);
        }
    }
    /*
     * 处理退款  （同意退款处理）
     * @param $t_id 订单自增ID,非订单编号
     * @param string $param_type id 或 tid
     * @return
     */
    public function dealRefund($t_id, $param_type = 'id') {
        $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
        if ($param_type == 'id') {
            $trade      = $trade_model->getRowById($t_id);
        } else {
            $trade      = $trade_model->findUpdateTradeByTid($t_id);
        }

        $refund_model   = new App_Model_Trade_MysqlTradeRefundStorage($this->sid);
        $refund     = $refund_model->getLastRecord($trade['t_tid']);
        if (!$trade || !$refund) {
            return false;
        }
        // 判断退款是否已处理
        if($refund['tr_status']!=0){   // 退款已经处理
            return false;
        }
        $trade_redis    = new App_Model_Trade_RedisTradeStorage($this->sid);
        //要求退款金额大于总金额
        if ($trade['t_total_fee'] < $refund['tr_money']) {
            return false;
        }
        //判断是否可退款
        if($trade['t_type'] >= self::TRADE_APPLET){
            $verify = $this->checkAppletTradeRefund($trade['t_pay_type'], $refund['tr_money'], $trade['t_tid']);
        }else{
            $verify = $this->checkTradeRefund($trade['t_pay_type'], $refund['tr_money'], $trade['t_tid']);
        }

        //退款失败
        if ($verify['errno'] < 0) {
            return false;
        }
        $refund_state   = true;
        //判断退款方式
        switch ($trade['t_pay_type']) {
            //微信支付自有
            case App_Helper_Trade::TRADE_PAY_WXZFZY :
                //发起微信退款
                $new_pay    = new App_Plugin_Weixin_NewPay($this->sid);
                if($trade['t_type'] >= self::TRADE_APPLET){
                    $ret = $new_pay->appletRefundPayOrder($trade['t_pay_trade_no'], $refund['tr_wid'], $trade['t_total_fee'], $refund['tr_money'], 'wx');
                    $refund_state   = $ret && $ret['code']=='SUCCESS' ? true : false;
                }else{
                    $ret = $new_pay->refundPayOrder($trade['t_pay_trade_no'], $refund['tr_wid'], $trade['t_total_fee'], $refund['tr_money'], 'wx');
                    $refund_state   = $ret ? true : false;
                }
                if($trade['t_es_id'] > 0 && $refund_state){
                    $this->afterEntershopRefund($trade,$refund);
                }
                break;
            //微信支付代销
            case App_Helper_Trade::TRADE_PAY_WXZFDX :
            //支付宝支付代销
            case App_Helper_Trade::TRADE_PAY_ZFBZFDX :
                $balance    = floatval($this->shop['s_balance']);//店铺收益余额
                $recharge   = floatval($this->shop['s_recharge']);//店铺通天币
                $settled_model  = new App_Model_Trade_MysqlTradeSettledStorage($this->sid);
                $settled    = $settled_model->findSettledByTid($trade['t_tid']);
                //未找到结算,或已退款结算
                if (!$settled || $settled['ts_status'] == self::TRADE_SETTLED_REFUND) {
                    return false;
                }
                //已成功结算的交易,退款时,判断店铺余额是否充足
                if ($settled['ts_status'] == self::TRADE_SETTLED_SUCCESS) {
                    //需要判断店铺余额
                    if ($balance < floatval($refund['tr_money']) && $recharge < floatval($refund['tr_money'])) {
                        Libs_Log_Logger::outputLog("店铺余额不足以支撑退款金额,sid={$this->sid}");
                        return false;
                    }
                }
                //发起不同的退款
                if ($trade['t_pay_type'] == self::TRADE_PAY_WXZFDX) {
                    //发起微信退款
                    $fxb_pay    = new App_Plugin_Weixin_FxbPay($this->sid);
                    $ret = $fxb_pay->refundPayOrder($trade['t_pay_trade_no'], $refund['tr_wid'], $trade['t_total_fee'], $refund['tr_money'], 'wx');
                    $refund_state   = $ret ? true : false;
                } else if ($trade['t_pay_type'] == self::TRADE_PAY_ZFBZFDX) {
                    //发起支付宝退款
                    $zfb_pay    = new App_Plugin_Alipaysdk_Client($this->sid);
                    $ret = $zfb_pay->refundOrder($trade['t_pay_trade_no'], $refund['tr_wid'], $refund['tr_money']);
                    $refund_state   = $ret ? true : false;
                }

                if ($refund_state) {
                    //清除订单的自动结算
                    $trade_redis->delTradeSettledTtl($t_id);
                    //已成功结算的交易,退款
                    if ($settled['ts_status'] == self::TRADE_SETTLED_SUCCESS) {
                        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
                        $title      = "订单{$trade['t_tid']}退款, 扣除余额";
                        if ($balance >= floatval($refund['tr_money'])) {
                            //优先扣除收益额
                            $shop_model->incrementShopBalance($this->sid, -floatval($refund['tr_money']));
                            //记录支出流水
                            $inout_model    = new App_Model_Shop_MysqlShopInoutStorage($this->sid);
                            $outdata    = array(
                                'si_s_id'   => $this->sid,
                                'si_name'   => $title,
                                'si_amount' => $refund['tr_money'],
                                'si_balance'=> $balance-floatval($refund['tr_money']),
                                'si_type'   => 2,
                                'si_create_time'    => time(),
                            );
                            $inout_model->insertValue($outdata);
                        } else {
                            //其次扣除通天币
                            $shop_model->incrementShopRecharge($this->sid, -floatval($refund['tr_money']));
                            //记录支出流水
                            $inout_model    = new App_Model_Shop_MysqlBalanceInoutStorage($this->sid);
                            $indata = array(
                                'bi_s_id'       => $this->sid,
                                'bi_title'      => $title,
                                'bi_amount'     => $refund['tr_money'],
                                'bi_balance'    => $recharge-floatval($refund['tr_money']),
                                'bi_type'       => 2,
                                'bi_create_time'=> time(),
                            );
                            $inout_model->insertValue($indata);
                        }
                    }
                    //修改待结算交易为已退款状态
                    $updata = array(
                        'ts_status'     => self::TRADE_SETTLED_REFUND,
                        'ts_update_time'=> time(),
                    );
                    $settled_model->findUpdateSettled($settled['ts_id'], $updata);
                }
                break;
            //货到付款
            case App_Helper_Trade::TRADE_PAY_HDFK :
                //退款无任何操作
                break;
            //余额支付
            case App_Helper_Trade::TRADE_PAY_YEZF :
                //增加会员金币
                $result = App_Helper_MemberLevel::goldCoinTrans($this->sid, $trade['t_m_id'], $refund['tr_money']);
                if($trade['t_es_id'] > 0 && $result){
                    $this->afterEntershopRefund($trade,$refund);
                }
                break;
            //优惠全免
            case App_Helper_Trade::TRADE_PAY_YHQM :
                //退款无操作
                break;
        }
        if ($refund_state) {
            $this->dealRefundTrade($trade);//退款成功后的处理
            //设置订单为退款订单
            $trupdata   = array(
                't_status'      => self::TRADE_REFUND,
                't_feedback'    => self::FEEDBACK_OVER,//维权结束
                't_fd_result'   => self::FEEDBACK_RESULT_AGREE,// 同意退款
                't_fd_status'   => self::FEEDBACK_REFUND_SOLVE,  // 维权解决
                't_refund_time' => time()
            );
            $trade_model->updateById($trupdata, $trade['t_id']);
            //短信通知买家订单已退款
            $sms_helper = new App_Helper_Sms($this->sid);
            $sms_helper->sendNoticeSms($trade, 'tytktz');
            //成功退款，标注退款成功
            $tr_set = array(
                'tr_status'      => self::FEEDBACK_REFUND_HANDLE, //  商家已处理
                'tr_finish_time' => time(),
            );
            $refund_model->updateById($tr_set,$refund['tr_id']);
        }

        return $refund_state;
    }

    /*
   * 处理退款  （同意退款处理）(新的接口返回错误提示)
   * @param $t_id 订单自增ID,非订单编号
   * @param string $param_type id 或 tid
   * @param 默认2 从余额退款  1表示从待结算退款
   * @return
   */
    public function appletDealRefund($t_id, $param_type = 'id', $source = 2) {
        $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
        if ($param_type == 'id') {
            $trade      = $trade_model->getRowById($t_id);
        } else {
            $trade      = $trade_model->findUpdateTradeByTid($t_id);
        }

        $refund_model   = new App_Model_Trade_MysqlTradeRefundStorage($this->sid);
        $refund     = $refund_model->getLastRecord($trade['t_tid']);
        if (!$trade || !$refund) {
            return 20001;
        }
        // 判断退款是否已处理
        if($refund['tr_status']!=0){   // 退款已经处理
            return 20004;
        }
        $trade_redis    = new App_Model_Trade_RedisTradeStorage($this->sid);
        //要求退款金额大于总金额
        if ($trade['t_total_fee'] < $refund['tr_money']) {
            return 20002;
        }
        //判断是否可退款
        if($trade['t_type'] >= self::TRADE_APPLET){
            $verify = $this->checkAppletTradeRefund($trade['t_pay_type'], $refund['tr_money'], $trade['t_tid']);
        }else{
            $verify = $this->checkTradeRefund($trade['t_pay_type'], $refund['tr_money'], $trade['t_tid']);
        }
        //退款失败
        if ($verify['errno'] < 0) {
            return 20003;
        }
        $refund_state   = array(
            'code' => 'success',
            'msg'  => '退款处理成功',
        );
        //判断退款方式
        switch ($trade['t_pay_type']) {
            //微信支付自有
            case App_Helper_Trade::TRADE_PAY_WXZFZY :
                //发起微信退款
                $new_pay    = new App_Plugin_Weixin_NewPay($this->sid);
                if($trade['t_type'] >= self::TRADE_APPLET){
                    $ret = $new_pay->appletRefundPayOrder($trade['t_pay_trade_no'], $refund['tr_wid'], $trade['t_total_fee'], $refund['tr_money'], 'wx', $source);
                    if(!$ret || $ret['code']!='SUCCESS' ){
                        $refund_state = array(
                            'code' => 'fail',
                            'msg'  => $ret['errmsg'],
                        );
                    }
                }else{
                    $ret = $new_pay->refundPayOrder($trade['t_pay_trade_no'], $refund['tr_wid'], $trade['t_total_fee'], $refund['tr_money'], 'wx');
                    $refund_state   = $ret ? true : false;
                }
                break;
            //微信支付代销
            case App_Helper_Trade::TRADE_PAY_WXZFDX :
                //支付宝支付代销
            case App_Helper_Trade::TRADE_PAY_ZFBZFDX :
                $balance    = floatval($this->shop['s_balance']);//店铺收益余额
                $recharge   = floatval($this->shop['s_recharge']);//店铺通天币
                $settled_model  = new App_Model_Trade_MysqlTradeSettledStorage($this->sid);
                $settled    = $settled_model->findSettledByTid($trade['t_tid']);
                //未找到结算,或已退款结算
                if (!$settled || $settled['ts_status'] == self::TRADE_SETTLED_REFUND) {
                    return false;
                }
                //已成功结算的交易,退款时,判断店铺余额是否充足
                if ($settled['ts_status'] == self::TRADE_SETTLED_SUCCESS) {
                    //需要判断店铺余额
                    if ($balance < floatval($refund['tr_money']) && $recharge < floatval($refund['tr_money'])) {
                        Libs_Log_Logger::outputLog("店铺余额不足以支撑退款金额,sid={$this->sid}");
                        return false;
                    }
                }
                //发起不同的退款
                if ($trade['t_pay_type'] == self::TRADE_PAY_WXZFDX) {
                    //发起微信退款
                    $fxb_pay    = new App_Plugin_Weixin_FxbPay($this->sid);
                    $ret = $fxb_pay->refundPayOrder($trade['t_pay_trade_no'], $refund['tr_wid'], $trade['t_total_fee'], $refund['tr_money'], 'wx');
                    $refund_state   = $ret ? true : false;
                } else if ($trade['t_pay_type'] == self::TRADE_PAY_ZFBZFDX) {
                    //发起支付宝退款
                    $zfb_pay    = new App_Plugin_Alipaysdk_Client($this->sid);
                    $ret = $zfb_pay->refundOrder($trade['t_pay_trade_no'], $refund['tr_wid'], $refund['tr_money']);
                    $refund_state   = $ret ? true : false;
                }

                if ($refund_state) {
                    //清除订单的自动结算
                    $trade_redis->delTradeSettledTtl($t_id);
                    //已成功结算的交易,退款
                    if ($settled['ts_status'] == self::TRADE_SETTLED_SUCCESS) {
                        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
                        $title      = "订单{$trade['t_tid']}退款, 扣除余额";
                        if ($balance >= floatval($refund['tr_money'])) {
                            //优先扣除收益额
                            $shop_model->incrementShopBalance($this->sid, -floatval($refund['tr_money']));
                            //记录支出流水
                            $inout_model    = new App_Model_Shop_MysqlShopInoutStorage($this->sid);
                            $outdata    = array(
                                'si_s_id'   => $this->sid,
                                'si_name'   => $title,
                                'si_amount' => $refund['tr_money'],
                                'si_balance'=> $balance-floatval($refund['tr_money']),
                                'si_type'   => 2,
                                'si_create_time'    => time(),
                            );
                            $inout_model->insertValue($outdata);
                        } else {
                            //其次扣除通天币
                            $shop_model->incrementShopRecharge($this->sid, -floatval($refund['tr_money']));
                            //记录支出流水
                            $inout_model    = new App_Model_Shop_MysqlBalanceInoutStorage($this->sid);
                            $indata = array(
                                'bi_s_id'       => $this->sid,
                                'bi_title'      => $title,
                                'bi_amount'     => $refund['tr_money'],
                                'bi_balance'    => $recharge-floatval($refund['tr_money']),
                                'bi_type'       => 2,
                                'bi_create_time'=> time(),
                            );
                            $inout_model->insertValue($indata);
                        }
                    }
                    //修改待结算交易为已退款状态
                    $updata = array(
                        'ts_status'     => self::TRADE_SETTLED_REFUND,
                        'ts_update_time'=> time(),
                    );
                    $settled_model->findUpdateSettled($settled['ts_id'], $updata);
                }
                break;
            //货到付款
            case App_Helper_Trade::TRADE_PAY_HDFK :
                //退款无任何操作
                break;
            //余额支付
            case App_Helper_Trade::TRADE_PAY_YEZF :
                //增加会员金币
                App_Helper_MemberLevel::goldCoinTrans($this->sid, $trade['t_m_id'], $refund['tr_money']);
                break;
            //优惠全免
            case App_Helper_Trade::TRADE_PAY_YHQM :
                //退款无操作
                break;
        }
        if ($refund_state) {
            $this->dealRefundTrade($trade);//退款成功后的处理
            //设置订单为退款订单
            $trupdata   = array(
                't_status'      => self::TRADE_REFUND,
                't_feedback'    => self::FEEDBACK_OVER,//维权结束
                't_fd_result'   => self::FEEDBACK_RESULT_AGREE,// 同意退款
                't_fd_status'   => self::FEEDBACK_REFUND_SOLVE,  // 维权解决
                't_refund_time' => time()
            );
            $trade_model->updateById($trupdata, $trade['t_id']);
            //成功退款，标注退款成功
            $tr_set = array(
                'tr_status'      => self::FEEDBACK_REFUND_HANDLE, //  商家已处理
                'tr_finish_time' => time(),
            );
            $refund_model->updateById($tr_set,$refund['tr_id']);
        }

        return $refund_state;
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
     * 记录会员的销售额
     */
    public static function recordMemberSales($sid, $mid, $tid, $amount, $buyer, $type = 0, $refund = false) {
        $amount = floatval($amount);
        if ($amount <= 0) {
            return false;
        }
        $sales_model    = new App_Model_Shop_MysqlShopSalesStorage($sid);

        $indata = array(
            'ss_s_id'   => $sid,
            'ss_m_id'   => $mid,
            'ss_tid'    => $tid,
            'ss_amount' => $amount,
            'ss_type'   => $type,
            'ss_status' => $refund ? 2 : 1,
            'ss_buyer_id'   => $buyer,
            'ss_create_time'=> time(),
        );

        $sales_model->insertValue($indata);

        return true;
    }
    /*
     * 付款成功后对不同类型交易进行处理
     */
    public function dealTradeType($trade,$handMove = 0,$from='') {

        set_time_limit(0);
        $type   = intval($trade['t_type']);

        $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
        //将订单从超时处理队列中移除
        $trade_redis    = new App_Model_Trade_RedisTradeStorage($this->shop['s_id']);
        $trade_redis->delTradeClose($trade['t_id']);
        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->shop['s_id']);
        $cfg        = $applet_cfg->findShopCfg();
        //处理不同类型订单
        switch ($type) {
            //小程序商城订单（按照普通订单类型算）
            case self::TRADE_APPLET :
            //普通类型订单
            case self::TRADE_NORMAL :
            //小程序预约订单（按照普通订单类型算）
            case self::TRADE_APPOINTMENT :

                //是否开通分销功能
                if (App_Helper_ShopWeixin::checkShopThreeLevel($this->sid)) {
                    //交易佣金提成通知
                    $order_deduct   = new App_Helper_OrderDeduct($this->shop['s_id']);
                    $order_deduct->updateOrderDeduct($trade['t_tid'], $trade['t_m_id'], $order_deduct::ORDER_HAD_PAY);
                }
                //是否开通区域代理功能
                if (App_Helper_OrderRegion::checkRegionOpen($this->sid)) {
                    $order_region   = new App_Helper_OrderRegion($this->sid);
                    $order_region->createOrderDeduct($trade);
                }

                if($type>=5){
                    $point_helper   = new App_Helper_Point($this->sid);
                    if(!in_array(intval($trade['t_applet_type']),array(3,4,9))){  //4积分，3抽奖订单不再返积分，9婚纱订单；（1拼团，2秒杀，5砍价参与返积分）
                        //不知道积分有啥用  婚纱订单也先不返积分
                        $point_helper->gainPointBySource($trade['t_m_id'],App_Helper_Point::POINT_SOURCE_TRADE,$trade);
                    }
                }else{
                    if (App_Helper_Point::checkPointOpen($this->sid) && $trade['t_applet_type']!=App_Helper_Trade::TRADE_APPLET_POINT) {
                        $point_helper   = new App_Helper_Point($this->sid);
                        $point_helper->goodsBackPoint($trade);
                    }
                }
                if(intval($trade['t_applet_type']) == self::TRADE_APPLET_TRAIN || (intval($trade['t_applet_type']) == self::TRADE_APPLET_SECKILL && $cfg['ac_type'] == 12) || (intval($trade['t_applet_type']) == self::TRADE_APPLET_BARGAIN && $cfg['ac_type'] == 12)){
                    //培训订单  培训砍价订单  培训秒杀订单 增加培训课程的报名人数
                    $this->adjustTradeCourseApply($trade['t_id']);
                }elseif(intval($trade['t_applet_type']) == self::TRADE_APPLET_WEDDING){
                    //婚纱版
                }else{
                    //修改支付成功商品的库存量(如果小程序的类型是社区团购并且支付类型是微信支付或混合支付，那么就不再执行减库存的操作了)
                    //zhangzc
                    //2019-08-11
                    // $from=='wx'
                    // && $this->sid==9373
                    if(($cfg['ac_type'] == 32 || $cfg['ac_type'] == 36) && in_array($trade['t_pay_type'],[1,9])){
                        //如果是社区团购并且是从微信支付过来的回调不执行减库存 
                    }else{
                        $this->adjustTradeGoodsStock($trade['t_id']);
                    }
                }
                //增加成交订单数量及金额
                $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                $member_model->incrementMemberTrade($trade['t_m_id'], $trade['t_total_fee'], 1);
                //是否触发成功交易次数,累积消费等级
                App_Helper_MemberLevel::memberLevelUpgrade($trade['t_m_id'], $this->shop['s_id']);

                //订单返现
                if($this->shop['s_order_return_ratio'] > 0){
                    $returnData = array(
                        'or_s_id'       => $this->sid,
                        'or_m_id'       => $trade['t_m_id'],
                        'or_tid'        => $trade['t_tid'],
                        'or_amount'     => $trade['t_total_fee'],
                        'or_ratio'      => $this->shop['s_order_return_ratio'],
                        'or_return'     => round(($this->shop['s_order_return_ratio']*$trade['t_total_fee'])/100, 2),
                        'or_create_time'=> time(),
                    );
                    $returnModel = new App_Model_Shop_MysqlOrderReturnStorage($this->sid);
                    $returnModel->insertValue($returnData);
                }

                $trade_status   = self::TRADE_HAD_PAY;
                //如果是小程序订单，判断小程序的订单类型
                if($type == self::TRADE_APPLET){
                    //判断是否为酒店类型的订单
                    if($cfg['ac_type'] == 7 && intval($trade['t_applet_type']) != self::TRADE_APPLET_POINT && intval($trade['t_independent_mall']) != 1){
                        //记录预定记录
                        $this->_hotel_record($trade);
                    }
                    //小程序类型的秒杀订单
                    if(intval($trade['t_applet_type']) == self::TRADE_APPLET_SECKILL){
                        //培训版增加报名人数
                        if($cfg['ac_type'] == 12){
                            $trade_status   = self::TRADE_SHIP; //培训订单直接完成
                        }
                        if(($cfg['ac_type'] == 32 || $cfg['ac_type'] == 36) && $trade['t_se_send_time'] > 0){
                            //社区团购秒杀订单
                            $this->_deal_sequence_order_new($trade);
                        }else{
                            $this->_deal_seckill_order($trade);
                        }

                    }
                    //社区小程序积分订单
                    if(intval($trade['t_applet_type']) == self::TRADE_APPLET_POINT){
                        $this->_deal_point_order($trade);
                    }
                    //小程序类型的拼团订单
                    if(intval($trade['t_applet_type']) == self::TRADE_APPLET_GROUP || intval($trade['t_applet_type']) == self::TRADE_APPLET_LOTTERY){
                        $ret = $this->_deal_lottery_order($trade);
                        if(!$ret){
                            return false;
                        }else{
                            $trade_status = $ret;
                        }
                    }
                    //小程序类型的砍价订单
                    if(intval($trade['t_applet_type']) == self::TRADE_APPLET_BARGAIN){
                        //培训版增加报名人数
                        if($cfg['ac_type'] == 12){
                            $trade_status   = self::TRADE_SHIP; //培训订单直接完成
                        }
                        if($cfg['ac_type'] == 32 || $cfg['ac_type'] == 36){
                            $this->_deal_sequence_order_new($trade);
                        }else{
                            $this->_deal_bargain_order($trade);
                        }

                    }
                    //小程序类型的培训订单
                    if(intval($trade['t_applet_type']) == self::TRADE_APPLET_TRAIN){
                        $trade_status   = self::TRADE_SHIP; //培训订单为待确认状态
                        //@todo 发货成功，设置自动完成时间
                        $overtime   = plum_parse_config('trade_overtime');
                        $trade_redis= new App_Model_Trade_RedisTradeStorage($this->sid);
                        $trade_redis->setTradeFinishTtl($trade['t_id'], $overtime['finish']);
                        plum_open_backend('templmsg', 'trainTradeTempl', array('sid' => $this->sid, 'tid' => $trade['t_tid'], 'type' => 'zfcg'));
                    }
                    //小程序类型的婚纱订单
                    if(intval($trade['t_applet_type']) == self::TRADE_APPLET_WEDDING){
                        $trade_status   = self::TRADE_SHIP; //婚纱订单为待确认状态
                    }
                    //小程序类型的社区团购订单
                    if(intval($trade['t_applet_type']) == self::TRADE_APPLET_SEQUENCE){
                        $trade_status = self::TRADE_HAD_PAY;
                        if($trade['t_se_send_time'] > 0){
                            $this->_deal_sequence_order_new($trade);
                        }else{
                            $this->_deal_sequence_order($trade);
                        }

                    }
                }
                break;
            //拍卖类型
            case self::TRADE_AUCTION :
                $trade_status   = self::TRADE_WAIT_GROUP; //拍卖
                $join_model = new App_Model_Auction_MysqlAuctionJoinStorage($this->sid);
                $extra  = json_decode($trade['t_extra_data'], true);
                $actid  = intval($extra['gid']);
                $indata = array(
                    'aaj_s_id'      => $trade['t_s_id'],
                    'aaj_aal_id'    => $actid,
                    'aaj_m_id'      => $trade['t_m_id'],
                    'aaj_tid'       => $trade['t_tid'],
                    'aaj_join_time' => time(),
                );
                $join_model->insertValue($indata);
                //修改拍卖参与人数
                $auction_model = new App_Model_Auction_MysqlAuctionListStorage($this->sid);
                $auction = $auction_model->getRowById($actid);
                $set = array('aal_join_num' => ($auction['aal_join_num']+1));
                $auction_model->updateById($set, $actid);
                break;
            //拼团类型订单
            case self::TRADE_GROUP :

            case self::TRADE_LOTTERY :
                $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->shop['s_id']);
                $cfg        = $applet_cfg->findShopCfg();

                $mem_model  = new App_Model_Group_MysqlMemStorage($this->sid);
                $where_test[] = array('name' => 'gm_tid', 'oper' => '=', 'value' => $trade['t_tid']);
                $exist  = $mem_model->getRow($where_test);
                if ($exist) {
                    return false;
                }

                $org_model  = new App_Model_Group_MysqlOrgStorage($this->sid);
                $extra  = json_decode($trade['t_extra_data'], true);
                $actid  = intval($extra['actid']);
                //获取拼团活动详情
                $group_model    = new App_Model_Group_MysqlBuyStorage($this->sid);
                $where[]    = array('name' => 'gb_s_id', 'oper' => '=', 'value' => $this->sid);
                $where[]    = array('name' => 'gb_id', 'oper' => '=', 'value' => $actid);
                $group      = $group_model->getRow($where);
                $group_model->incrementJoin($actid);

                $group_redis    = new App_Model_Group_RedisOrgStorage($this->sid);
                $group_helper   = new App_Helper_Group($this->sid);
                //拼团成功标识
                $pintuan_success    = false;
                $kaituan_success    = false;

                if ($extra['ishead']) {//团长活动
                    $indata = array(
                        'go_s_id'       => $trade['t_s_id'],
                        'go_tz_mid'     => $trade['t_m_id'],
                        'go_tz_nick'    => $trade['t_buyer_nick'],
                        'go_gb_id'      => $actid,
                        'go_total'      => intval($group['gb_total']),
                        'go_had'        => 1,
                        'go_status'     => 0,//进行中
                        'go_create_time'=> time(),
                    );
                    $gbid   = $org_model->insertValue($indata);

                    //判断是否要求强制关注
                    if ($group['gb_sub_limit']) {
                        //生成临时二维码
                        $client_weixin  = new App_Plugin_Weixin_ClientPlugin($this->sid);
                        //生成场景值
                        $scene_id       = App_Helper_Group::GROUP_WEIXIN_SCENE_BASE * $gbid;
                        $result = $client_weixin->fetchSpreadQrcode($scene_id);
                        //更新
                        if ($result && $result['url']) {
                            $updata = array(
                                'go_follow_qrcode'      => $result['url'],
                            );
                            $org_model->updateById($updata, $gbid);
                        }
                    }
                    //创建开团成功定时任务
                    $leftTime = $group['gb_end_time'] - time();
                    $group_redis->recordOvertimeTask($gbid, ($leftTime > self::GROUP_TRADE_OVER_TIME)?self::GROUP_TRADE_OVER_TIME:$leftTime);

                    $kaituan_success    = true;
                } else {//团员参与
                    $gbid   = intval($extra['gbid']);//组团活动ID
                    $org    = $org_model->getRowByIdSid($gbid, $this->sid);
                    if (($org['go_had'] + 1) == $group['gb_total']) {
                        $updata = array(
                            'go_had'    => $org['go_had'] + 1,
                            'go_status' => App_Helper_Group::GROUP_STATUS_SUCCESS,//成功
                            'go_over_time'  => time(),//完成时间
                        );
                        //成功时删除已设置的拼团定时
                        $group_redis->deleteOvertimeTask($gbid);

                        $pintuan_success    = true;
                    } else {
                        $updata = array(
                            'go_had'    => $org['go_had'] + 1
                        );
                    }
                    $org_model->updateById($updata, $gbid);
                }
                //写入组员信息
                $zyindata   = array(
                    'gm_s_id'       => $this->sid,
                    'gm_go_id'      => $gbid,
                    'gm_gb_id'      => $actid,
                    'gm_mid'        => $trade['t_m_id'],
                    'gm_tid'        => $trade['t_tid'],
                    'gm_is_tz'      => $extra['ishead'],
                    'gm_join_time'  => time(),
                );

                $mem_model->insertValue($zyindata);
                //是否需要发送拼团模板消息
                $group_helper->sendGroupTmplmsg($trade['t_tid'], 'zfcg');
                $group_helper->sendGroupNewsmsg($actid, array($trade['t_m_id']), 'zfcg');
                //是否需要发送开团成功模板消息
                if ($kaituan_success) {
                    //是否需要发送开团模板消息
                    $group_helper->sendGroupTmplmsg($trade['t_tid'], 'ktcg');
                    $group_helper->sendGroupNewsmsg($actid, array($trade['t_m_id']), 'ktcg');
                }
                //是否需要发送组团成功模板消息
                if ($pintuan_success) {//拼团成功
                    $joiner = $mem_model->fetchJoinList($gbid);
                    $mids   = array();
                    //设置当前所有订单状态为待发货
                    $updata = array(
                        't_status'  => $group['gb_type'] == App_Helper_Group::GROUP_TYPE_CJT ? App_Helper_Trade::TRADE_LOTTERY_WAIT_DRAW : App_Helper_Trade::TRADE_HAD_PAY,
                    );
                    foreach ($joiner as $item) {
                        if ($item['gm_tid'] && !$item['gm_is_robot']) {
                            $trade_model->findUpdateTradeByTid($item['gm_tid'], $updata);
                            $mids[] = intval($item['gm_mid']);
                            $group_helper->sendGroupTmplmsg($item['gm_tid'], 'ptcg');
                        }
                    }
                    $group_helper->sendGroupNewsmsg($actid, $mids, 'ptcg');
                    //设置当前订单状态为拼团成功
                    $trade_status   = $updata['t_status'];
                    //非抽奖拼团,成功后修改库存量
                    if ($group['gb_type'] != App_Helper_Group::GROUP_TYPE_CJT) {
                        //拼团成功,商品库存量调整
                        $real   = $mem_model->getRealJoiner($gbid);
                        if($cfg['ac_type'] == 12 && $this->sid == 4230){//培训版
                            foreach ($real as $item) {
                                $this->adjustTradeCourseApply($item['t_id']);
                            }
                        }else{
                            foreach ($real as $item) {
                                $this->adjustTradeGoodsStock($item['t_id']);
                            }
                        }

                    }
                } else {//等待拼团成功
                    //设置当前订单状态为待成团
                    $trade_status   = self::TRADE_WAIT_GROUP;
                }
                break;
            //秒杀类型订单
            case self::TRADE_SECKILL :
                $trade_status   = self::TRADE_HAD_PAY;
                $order_model    = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
                $order  = $order_model->fetchOrderListByTid($trade['t_id']);

                $record_model   = new App_Model_Limit_MysqlLimitRecordStorage($this->sid);
                $actid      = intval(json_decode($trade['t_extra_data'], true)['actid']);
                foreach ($order as $item) {
                    //秒杀类型的商品
                    if ($item['to_type'] == self::TRADE_ORDER_SECKILL) {
                        $indata = array(
                            'lr_s_id'       => $this->sid,
                            'lr_m_id'       => $item['to_m_id'],
                            'lr_g_id'       => $item['to_g_id'],
                            'lr_gf_id'      => $item['to_gf_id'],
                            'lr_actid'      => $actid,
                            'lr_num'        => $item['to_num'],
                            'lr_create_time'=> time(),
                        );
                        $record_model->insertValue($indata);
                    }
                }
                //修改支付成功商品的库存量
                //修改支付成功商品的库存量(如果小程序的类型是社区团购并且支付类型是微信支付，那么就不再执行减库存的操作了)
                //zhangzc
                //2019-08-11
                // $from=='wx'
                //  && $this->sid==9373
                if(($cfg['ac_type'] == 32 || $cfg['ac_type'] == 36) && $trade['t_pay_type']==1 ){
                    //如果是社区团购并且是从微信支付过来的回调不执行减库存 
                }else{
                    $this->adjustTradeGoodsStock($trade['t_id']);
                }
                break;
            //积分类型订单
            case self::TRADE_POINT :
                $trade_status   = self::TRADE_HAD_PAY;
                //获取积分兑换记录
                $record_model   = new App_Model_Point_MysqlRecordStorage($this->sid);
                $record = $record_model->findRecordByTid($trade['t_tid']);
                //积分扣除成功后,增加商品兑换量
                $point_helper   = new App_Helper_Point($this->sid);
                $point_helper->goodsExchangeNum($record['pr_actid'], $record['pr_g_id'], $record['pr_num'], true, $record['pr_gf_id']);
                //设置兑换记录,积分兑换成功
                $redata = array('pr_status' => App_Helper_Point::POINT_STATUS_SUCCESS, 'pr_update_time' => time());
                $where_re[]     = array('name' => 'pr_tid', 'oper' => '=', 'value' => $trade['t_tid']);
                $record_model->updateValue($redata, $where_re);
                //修改支付成功商品的库存量
                $this->adjustTradeGoodsStock($trade['t_id']);
                //单轨制公排系统
                $point_helper->intoLineQueue($trade['t_m_id'], $record);
                break;
        }
        //生成订单核销码
        $filename = $trade['t_m_id'].'-'.$trade['t_tid']. '.png';
        $text = $trade['t_tid'];
        Libs_Qrcode_QRCode::png($text, $this->hold_dir . $filename, 'Q', 6, 1);

        // 判断是否有支付时间
       // if($trade['t_pay_time']){

       // }
        //如果是餐饮版，并且商家的自动接单是关闭状态，设置订单未待接单的状态（待成团）
        if($cfg['ac_type'] == 4){//餐饮版
            if(!$trade['t_es_id']){ //平台商品
                if(!$this->shop['s_auto_receive_order']){ //平台未开启自动接单
                    $trade_status = self::TRADE_WAIT_GROUP;  //状态改为待接单
                    //设置退款倒计时
                    $trade_redis = new App_Model_Trade_RedisTradeStorage($this->sid);
                    $trade_redis->setMealUnReceiveRefundTtl($trade['t_id'], 10*60);
                }
            }else{  //商家商品
                $enterShop_model = new App_Model_Entershop_MysqlEnterShopStorage();
                $enterShop = $enterShop_model->getRowById($trade['t_es_id']);
                if(!$enterShop['es_auto_receive_order']){ //商家未开启自动接单
                    $trade_status = self::TRADE_WAIT_GROUP;  //状态改为待接单
                    //设置退款倒计时
                    $trade_redis = new App_Model_Trade_RedisTradeStorage($this->sid);
                    $trade_redis->setMealUnReceiveRefundTtl($trade['t_id'], 10*60);
                }
            }
        }

        //修改支付完成状态
        $updateResult = $trade_model->findUpdateTradeByTid($trade['t_tid'],array('t_status' => $trade_status, 't_qrcode' => $this->access_path.$filename));

        if($trade['t_applet_type'] == self::TRADE_APPLET_TRAIN && ($this->sid == 4230 || $this->sid == 10380)){
            $this->saveInvoice($trade['t_id']);
        }

        //社区团购 对每个商品生成单独核销码及二维码
        if($cfg['ac_type'] == 32 || $cfg['ac_type'] == 36){
            $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
            $orderList = $order_model->fetchOrderListByTid($trade['t_id']);
            $to_gids=[];
            foreach ($orderList as $order){
                $code_order = 'GTO'.plum_random_code(8);
                $filename_order = $code_order.'-'.$order['to_id'].'-'.$trade['t_tid'].'.png';
                $text_order = $code_order;
                Libs_Qrcode_QRCode::png($text_order, $this->hold_dir . $filename_order, 'Q', 6, 1);
                $order_model->updateById(['to_code'=>$code_order,'to_qrcode'=>$this->access_path.$filename_order],$order['to_id']);
                $to_gids[]=$order['to_g_id'];
            }

            // 新人邀请的写入结果应该放到这里（避免微信支付调起的未支付的账单占用掉邀请记录里面的订单金额）
            // zhangzc
            // 2019-09-07
            plum_open_backend('index', 'inviteUserTrade', [
                'pay_type'  =>$trade['t_pay_type'],
                'gids'      =>json_encode($to_gids),
                't_tid'     =>$trade['t_id'],
                'payment'   =>$trade['t_payment'],
                'sid'       =>$this->sid,
                'mid'       =>$trade['t_m_id'],
            ]); 
                
        }

        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->sid);
        $cfg        = $applet_cfg->findShopCfg();

        //获得跑腿配置
        $legwork_model = new App_Model_Legwork_MysqlOtherLegworkCfgStorage($this->sid);
        $legworkCfg = $legwork_model->findUpdateBySidEsId($trade['t_es_id']);
        if($legworkCfg['aolc_open'] == 1 && $trade_status>2){
            //验证并将订单记录至跑腿订单表
            $this->_check_add_legwork_trade($trade['t_tid'],$legworkCfg,$cfg);
        }
        if(!$handMove){
            //成功支付触发通知
            $this->sendTradeStatusMessage($trade['t_tid'], self::TRADE_MESSAGE_SEND_ZFCG);
            // 支付成功向管理员发送推送通知
            $help_model = new App_Helper_XingePush($this->sid);
            $help_model->pushNotice($help_model::TRADE_HAD_PAY,$trade);  // 推送支付成功通知
            $notice_model = new App_Helper_JiguangPush($this->sid);
            $notice_model->pushNotice($help_model::TRADE_HAD_PAY,$trade);
            // 后台店铺消息
            $message_helper = new App_Helper_ShopMessage($this->sid);
            $message_helper->messageRecord($message_helper::TRADE_HAD_PAY,$trade);
            //短信通知
            $sms_helper = new App_Helper_Sms($this->sid);
            $sms_helper->sendNoticeSms($trade, 'ddzfcg');
        }

        if(intval($trade['t_applet_type']) != self::TRADE_APPLET_GROUP && intval($trade['t_applet_type']) != self::TRADE_APPLET_LOTTERY && $trade_status>2){ //拼团订单不在此打印
            // 支付成功打印订单信息
            if($this->shop['s_auto_refund'] > 0){ //定时打印
                $trade_redis = new App_Model_Trade_RedisTradeStorage($this->sid);
                $trade_redis->setTradePrintTtl($trade['t_id'], $this->shop['s_auto_refund']*60);
            }else{
                /** 直接用tid 节省一个对象的开销吧
                 * 区域合伙人订单自动打印
                 * zhangzc
                 * 2019-06-15
                **/
                // 订单是否是区域合伙人的订单
                $rm_id=$trade_model->getRegionManagerIdByTid($trade['t_id']);
                $print_model = new App_Helper_Print($this->sid);
                // 区域合伙人的 找到平台与合伙人的打印机
                // 非区域合伙人的订单查询打印机的时候去掉区域合伙人添加的打印机
                // 最后一个参数为1时标记自动打印时查询打印机列表的时候做区域合伙人的处理
                $print_model->printOrder($trade['t_tid'],'',$trade['t_es_id'],$rm_id,1);

                // $print_model = new App_Helper_Print($this->sid);
                // $print_model->printOrder($trade['t_tid'],'',$trade['t_es_id']);

            }
        }

        //普通订单 支付成功后如果订单是商家配送并且开启蜂鸟配送，设置退单倒计时
        //获得配送范围配置值及店铺经纬度
        /*$send_model = new App_Model_Cake_MysqlCakeSendStorage($this->sid);
        $sendCfg = $send_model->findUpdateBySid(null,$trade['t_es_id']);
        if($trade['t_express_method'] == 5 || ($trade['t_express_method'] == 1 && $sendCfg['acs_ele_delivery'] == 1 && $trade_status>2 && $trade['t_type'] == self::TRADE_APPLET && ($trade['t_applet_type'] == self::TRADE_APPLET_NORMAL || $trade['t_applet_type'] == self::TRADE_APPLET_SECKILL))){
            Libs_Log_Logger::outputLog('执行蜂鸟配送','test.log');
            $ele_cfg_model = new App_Model_Plugin_MysqlEleCfgStorage($this->sid);
            $eleCfg = $ele_cfg_model->fetchUpdateCfg(null, $trade['t_es_id']);
            $trade_redis = new App_Model_Trade_RedisTradeStorage($this->sid);
            $trade_redis->setEleDeliveryTtl($trade['t_id'], $eleCfg['ec_send_timeout']?$eleCfg['ec_send_timeout']*60:10*60);
        }*/

        //知识付费支付完成后直接完成订单
        if($cfg['ac_type'] == 27 && intval($trade['t_applet_type']) != self::TRADE_APPLET_POINT && !$trade['t_independent_mall']){
            $this->_finish_order($trade['t_tid']);
        }elseif($cfg['ac_type'] == 27 && intval($trade['t_applet_type']) == self::TRADE_APPLET_POINT){
            $goods_model    = new App_Model_Goods_MysqlGoodsStorage($this->sid);
            $goods = $goods_model->getRowById(json_decode($trade['t_extra_data'], true)['gid']);
            if($goods['g_type'] == 5){
                $this->_finish_order($trade['t_tid']);
            }
        }

        //发送分销消息提醒
        $order_deduct_storage = new App_Model_Shop_MysqlOrderDeductStorage($this->sid);
        $odlist = $order_deduct_storage->findOrderDeductListByTid($trade['t_tid']);
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $member = $member_model->getRowById($trade['t_m_id']);
        $appletType = plum_parse_config('member_source_menu_type')[$member['m_source']];
        $appletType = $appletType ? $appletType : 0;
        foreach ($odlist as $val){
            plum_open_backend('templmsg', 'deductTempl', array('sid' => $this->sid, 'odId' => $val['od_id'],'appletType'=>$appletType));
        }

        //支付成功，加入已购订单
        $this->_deal_add_order($trade);
        return $updateResult;
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

    private function _check_add_legwork_trade($tid,$legworkCfg = [],$appletCfg = []){
       
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade = $trade_model->findUpdateTradeByTid($tid);
        $applet_model = new App_Model_Applet_MysqlCfgStorage($this->sid);
        if(!$legworkCfg){
            $legwork_model = new App_Model_Legwork_MysqlOtherLegworkCfgStorage($this->sid);
            $legworkCfg = $legwork_model->findUpdateBySidEsId($trade['t_es_id']);
        }
        if(!$appletCfg){
            $appletCfg = $applet_model->findShopCfg();
        }
        $trade_update = [];
        $where = [];
        $where[] = ['name' => 'ac_appid' , 'oper' => '=', 'value' => $legworkCfg['aolc_appid']];
        $applet = $applet_model->getRow($where);
        $legwork_sid = $applet['ac_s_id'];

        $log_data = [
            'tid' => $trade['t_tid'],
            'sid' => $trade['t_s_id']
        ];
        Libs_Log_Logger::outputLog($log_data,'legwork-before-insert.log');

        $legwork_trade_model = new App_Model_Legwork_MysqlLegworkTradeStorage($legwork_sid);
        //跑腿配送非拼团订单
        if($legwork_sid && $trade['t_express_method'] == 7 && $trade['t_applet_type'] != self::TRADE_APPLET_GROUP){
           // $cfg_model = new App_Model_Legwork_MysqlLegworkCfgStorage($legwork_sid);
           // $cfg = $cfg_model->findUpdateBySid();
            $legwork_tid = App_Plugin_Weixin_PayPlugin::makeMchOrderid($legwork_sid);
            $legworkExtra = json_decode($trade['t_legwork_extra'],1);

            $log_data = [
                'tid' => $trade['t_tid'],
                'sid' => $trade['t_s_id'],
                'legwork_tid' => $legwork_tid,
                'legwork_sid' => $legwork_sid
            ];
            Libs_Log_Logger::outputLog($log_data,'legwork-do-insert.log');

            $legwork_code =  plum_random_code(5);
            $filename = $trade['t_m_id'].'-'.$legwork_code. '.png';
            $text = $legwork_code;
            Libs_Qrcode_QRCode::png($text, $this->hold_dir . $filename, 'Q', 6, 1);
            $insert = [
                'alt_s_id' => $legwork_sid,
                'alt_m_id' => $trade['t_m_id'],
                'alt_tid'  => $legwork_tid,
                'alt_status' => 3,
                'alt_distance' => $legworkExtra['distance'],
                'alt_basic_distance' => $legworkExtra['basicDistance'],
                'alt_plus_distance' => $legworkExtra['plusDistance'],
                'alt_basic_price' => $legworkExtra['basicPrice'],
                'alt_plus_price' => $legworkExtra['plusPrice'],
                'alt_create_time' => time(),
                'alt_other_tid' => $trade['t_tid'],
                'alt_other_sid' => $trade['t_s_id'],
                'alt_other_discount' => $legworkExtra['discountPost'],
                'alt_other_esid' => $trade['t_es_id'],
                'alt_buyer_openid' => $trade['t_buyer_openid'],
                'alt_time_fee' => $legworkExtra['timePrice'],
                'alt_type' => 3, //都是代送单
                'alt_code' => $legwork_code,
                'alt_qrcode' => $this->access_path.$filename,
                'alt_termini_id' => $trade['t_addr_id'],
                'alt_addr' => $legworkExtra['shopAddr'],
                'alt_addr_lng' => $legworkExtra['fromLng'],
                'alt_addr_lat' => $legworkExtra['fromLat'],
                'alt_addr_mobile' => $legworkExtra['shopMobile'],
                'alt_note' => $trade['t_note'],
                'alt_other_shop_name' => $appletCfg['ac_name'],
            ];
            if($trade['t_es_id'] > 0){
                $entershop_model = new App_Model_Entershop_MysqlEnterShopStorage();
                $entershop = $entershop_model->getRowById($trade['t_es_id']);
                if($entershop['es_name']){
                    $insert['alt_other_entershop_name'] = $entershop['es_name'];
                }
            }

            if($appletCfg['ac_type'] == 4){

                if($trade['t_meal_send_time'] && $trade['t_meal_send_time'] != '立即送达'){
                    $insert['alt_time'] = strtotime($trade['t_meal_send_time']);
                }
            }
            if (in_array($appletCfg['ac_type'],[4,6,8,21])){
                //获得今天已有的跑腿订单数
                $time_0 = strtotime(date('Y-m-d'));
                $where_today = [];
                $where_today[] = ['name' => 'alt_s_id' , 'oper' => '=', 'value' => $legwork_sid];
                $where_today[] = ['name' => 'alt_other_sid' , 'oper' => '=', 'value' => $trade['t_s_id']];
                $where_today[] = ['name' => 'alt_other_esid' , 'oper' => '=', 'value' => $trade['t_es_id']];
                $where_today[] = ['name' => 'alt_create_time' , 'oper' => '>=', 'value' => $time_0];
                $count_today = $legwork_trade_model->getCount($where_today);
                $count_now = intval($count_today) + 1;
                $insert['alt_other_num'] = $count_now;
                $trade_update['t_legwork_num'] = $count_now;
            }
           // else{
           //     $insert['alt_termini_id'] = $trade['t_addr_id'];
           //     $insert['alt_addr'] = $legworkExtra['shopAddr'];
           //     $insert['alt_addr_lng'] = $legworkExtra['fromLng'];
           //     $insert['alt_addr_lat'] = $legworkExtra['fromLat'];
           //     $insert['alt_addr_mobile'] = $legworkExtra['shopMobile'];
           //     $insert['alt_note'] = $trade['t_note'];
           // }

            $res = $legwork_trade_model->insertValue($insert);
            if($res){
                if(!empty($trade_update)){
                    $trade_model->findUpdateTradeByTid($tid,$trade_update);
                }

                $jiguang_model = new App_Helper_JiguangPush($insert['alt_s_id']);
                $jiguang_model->pushNotice($jiguang_model::LEGWORK_NEW_TRADE,$insert,'',true);
            }
        }
    }

    //完成订单
    private function _finish_order($tid){
        $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade = $trade_model->findUpdateTradeByTid($tid);
        // 判断订单状态是否是待收货状态
        if($trade['t_status'] == App_Helper_Trade::TRADE_SHIP || $trade['t_status'] == App_Helper_Trade::TRADE_HAD_PAY){
            $updata = array(
                't_finish_time' => time(),
                't_status'      => App_Helper_Trade::TRADE_FINISH,//置于完成状态
            );
            $trade_helper   = new App_Helper_Trade($this->sid);
            //清除自动完成状态定时
            $trade_redis    = new App_Model_Trade_RedisTradeStorage($this->sid);
            $trade_redis->delTradeFinish($trade['t_id']);
            //交易佣金提成通知
            $order_deduct   = new App_Helper_OrderDeduct($this->sid);
            $order_deduct->completeOrderDeduct($tid, $trade['t_m_id']);
            //清除待结算状态 确认收货7天后再结算
            $settled_model  = new App_Model_Trade_MysqlTradeSettledStorage($this->sid);
            $settled        = $settled_model->findSettledByTid($trade['t_tid']);
            if ($settled && $settled['ts_status'] == App_Helper_Trade::TRADE_SETTLED_PENDING) {
                $set = array('ts_order_finish_time' => time());
                $settled_model->updateById($set, $settled['ts_id']);
                if($this->shop['s_enter_settle'] > 0){
                    $countdown   = plum_parse_config('trade_overtime');
                    $trade_redis = new App_Model_Trade_RedisTradeStorage($this->sid);
                    $trade_redis->setTradeSettledTtl($settled['ts_id'], $this->shop['s_enter_settle']?$this->shop['s_enter_settle']*24*60*60:$countdown['settled']);
                }else{
                    $trade_redis->delTradeSettledTtl($settled['ts_id']);
                    if($trade['t_es_id']>0){
                        $this->recordEnterShopSuccessSettled($settled['ts_id']);
                    }else{
                        $this->recordSuccessSettled($settled['ts_id']);
                    }
                }
            }
            $ret = $trade_model->findUpdateTradeByTid($trade['t_tid'], $updata);
            //增加商品销量
            $trade_helper->modifyGoodsSold($trade['t_id']);
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

    private function _hotel_record($trade){
        $order_model    = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
        $list = $order_model->fetchOrderListByTid($trade['t_id']);
        $record_storage = new App_Model_Hotel_MysqlHotelRecordStorage();
        $dayArr = array();
        for($i = $trade['t_receive_start_time']; $i < $trade['t_receive_end_time']; $i += 86400) {
            $dayArr[] = $i;
        }
        foreach ($list as $value){
            $where[] = array('name' => 'ahr_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[] = array('name' => 'ahr_g_id', 'oper' => '=', 'value' => $value['to_g_id']);
            $where[] = array('name' => 'ahr_gf_id', 'oper' => '=', 'value' => $value['to_gf_id']);
            $where[] = array('name' => 'ahr_day', 'oper' => 'in', 'value' => $dayArr);
            $list = $record_storage->getList($where, 0,0,array());
            if($list){
                foreach ($list as $val){
                    $set = array('ahr_num' => $val['ahr_num']+$trade['t_room_num']);
                    $record_storage->updateById($set, $val['ahr_id']);
                }
            }else{
                foreach ($dayArr as $val){
                    $data = array(
                        'ahr_s_id' => $this->sid,
                        'ahr_g_id' => $value['to_g_id'],
                        'ahr_gf_id' => $value['to_gf_id'],
                        'ahr_day'  => $val,
                        'ahr_num'  => $trade['t_room_num'],
                        'ahr_create_time' => time()
                    );
         
                    $record_storage->insertValue($data);
                }
            }
        }
    }

    //处理小程序类型的砍价订单
    private function _deal_bargain_order($trade){
        //设置参与者已购买
        $bargain_helper = new App_Helper_BargainActivity($this->shop['s_id']);
        $bargain_helper->updateJoinerBuy($trade['t_bj_id']);

        $join_storage   = new App_Model_Bargain_MysqlJoinStorage($this->sid);
        $join = $join_storage->getRowById($trade['t_bj_id']);

        //递减商品数量
        $activity_storage   = new App_Model_Bargain_MysqlActivityStorage($this->shop['s_id']);
        $activity_storage->incrementGoodsBuyNum($join['bj_a_id']);
    }

    //处理社区小程序积分订单
    private function _deal_point_order($trade){
        //减去用户的积分
     /*   $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member = $member_storage->getRowById($trade['t_m_id']);
        $updata = array(
            'm_points'      => $member['m_points'] - $trade['t_points'],
        );
        $member_storage->updateById($updata, $trade['t_m_id']);*/
        //记录支出
        $title  = $trade['t_title'];
        $point_helper   = new App_Helper_Point($this->shop['s_id']);
        $point_helper->memberPointRecord($trade['t_m_id'], $trade['t_points'], $title, App_Helper_Point::POINT_INOUT_OUTPUT, App_Helper_Point::POINT_SOURCE_TRADE, $trade['t_tid']);
    }

    //处理秒杀订单
    private function _deal_seckill_order($trade){
        $order_model    = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
        $order  = $order_model->fetchOrderListByTid($trade['t_id']);

        $record_model   = new App_Model_Limit_MysqlLimitRecordStorage($this->sid);
        $actid      = intval(json_decode($trade['t_extra_data'], true)['actid']);
        foreach ($order as $item) {
            //秒杀类型的商品
            if ($item['to_type'] == self::TRADE_ORDER_SECKILL) {
              $indata = [
                'lr_s_id' => $this->sid,
                'lr_m_id' => $item['to_m_id'],
                'lr_g_id' => $item['to_g_id'],
                'lr_gf_id' => $item['to_gf_id'],
                'lr_actid' => $item['to_limit_act'] ? $item['to_limit_act'] : $actid,
                'lr_num' => $item['to_num'],
                'lr_create_time' => time(),
              ];
              $record_model->insertValue($indata);


              $lg_model = new App_Model_Limit_MysqlLimitGoodsStorage($this->sid);
              $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);
              $act = $lg_model->getActByGid($item['to_g_id'], 0);
              //设置了秒杀数量,减少秒杀数量
//              if ($act['lg_stock'] > 0) {
//                $lg_model->adjustStock($item['to_g_id'], -$item['to_num'], $item['to_gf_id']);
//              }
              //增加秒杀销量
              $lg_model->adjustSold($item['to_g_id'], $item['to_num'], $item['to_gf_id']);
            }

        }


    }

    //处理拼团订单
    private function _deal_lottery_order($trade){
        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->shop['s_id']);
        $cfg        = $applet_cfg->findShopCfg();

        $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $mem_model  = new App_Model_Group_MysqlMemStorage($this->sid);
        $where_test[] = array('name' => 'gm_tid', 'oper' => '=', 'value' => $trade['t_tid']);
        $exist  = $mem_model->getRow($where_test);
        if ($exist) {
            return false;
        }

        $org_model  = new App_Model_Group_MysqlOrgStorage($this->sid);
        $extra  = json_decode($trade['t_extra_data'], true);
        $actid  = intval($extra['actid']);
        //获取拼团活动详情
        $group_model    = new App_Model_Group_MysqlBuyStorage($this->sid);
        $where[]    = array('name' => 'gb_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gb_id', 'oper' => '=', 'value' => $actid);
        $group      = $group_model->getRow($where);
        $group_model->incrementJoin($actid);

        $group_redis    = new App_Model_Group_RedisOrgStorage($this->sid);
        $group_helper   = new App_Helper_Group($this->sid);
        //拼团成功标识
        $pintuan_success    = false;
        $kaituan_success    = false;

        if ($extra['ishead']) {//团长活动
            $indata = array(
                'go_s_id'       => $trade['t_s_id'],
                'go_tz_mid'     => $trade['t_m_id'],
                'go_tz_nick'    => $trade['t_buyer_nick'],
                'go_gb_id'      => $actid,
                'go_total'      => intval($group['gb_total']),
                'go_had'        => 1,
                'go_status'     => 0,//进行中
                'go_create_time'=> time(),
            );
            $gbid   = $org_model->insertValue($indata);

            //判断是否要求强制关注
            if ($group['gb_sub_limit']) {
                //生成临时二维码
                $client_weixin  = new App_Plugin_Weixin_ClientPlugin($this->sid);
                //生成场景值
                $scene_id       = App_Helper_Group::GROUP_WEIXIN_SCENE_BASE * $gbid;
                $result = $client_weixin->fetchSpreadQrcode($scene_id);
                //更新
                if ($result && $result['url']) {
                    $updata = array(
                        'go_follow_qrcode'      => $result['url'],
                    );
                    $org_model->updateById($updata, $gbid);
                }
            }
            //创建开团成功定时任务

            $group_redis->recordOvertimeTask($gbid, self::GROUP_TRADE_OVER_TIME);

            $kaituan_success    = true;
        } else {//团员参与
            $gbid   = intval($extra['gbid']);//组团活动ID
            $org    = $org_model->getRowByIdSid($gbid, $this->sid);
            if (($org['go_had'] + 1) >= $group['gb_total']) {
                $updata = array(
                    'go_had'    => $org['go_had'] + 1,
                    'go_status' => App_Helper_Group::GROUP_STATUS_SUCCESS,//成功
                    'go_over_time'  => time(),//完成时间
                );
                //成功时删除已设置的拼团定时
                $group_redis->deleteOvertimeTask($gbid);

                $pintuan_success    = true;
            } else {
                $updata = array(
                    'go_had'    => $org['go_had'] + 1
                );
            }
            $org_model->updateById($updata, $gbid);
        }
        //写入组员信息
        $zyindata   = array(
            'gm_s_id'       => $this->sid,
            'gm_go_id'      => $gbid,
            'gm_gb_id'      => $actid,
            'gm_mid'        => $trade['t_m_id'],
            'gm_tid'        => $trade['t_tid'],
            'gm_is_tz'      => $extra['ishead'],
            'gm_join_time'  => time(),
        );

        $mem_model->insertValue($zyindata);
        //是否需要发送拼团模板消息
        $group_helper->sendGroupTmplmsg($trade['t_tid'], 'zfcg');
        $group_helper->sendAppletGroupTmplmsg($trade['t_tid'], 'zfcg');
        $group_helper->sendGroupNewsmsg($actid, array($trade['t_m_id']), 'zfcg');
        //是否需要发送开团成功模板消息
        if ($kaituan_success) {
            //是否需要发送开团模板消息
            $group_helper->sendGroupTmplmsg($trade['t_tid'], 'ktcg');
            $group_helper->sendAppletGroupTmplmsg($trade['t_tid'], 'ktcg');
            $group_helper->sendGroupNewsmsg($actid, array($trade['t_m_id']), 'ktcg');
        }
        //是否需要发送组团成功模板消息
        if ($pintuan_success) {//拼团成功
            $joiner = $mem_model->fetchJoinList($gbid);
            $mids   = array();
            //设置当前所有订单状态为待发货
            $updata = array(
                't_status'  => $group['gb_type'] == App_Helper_Group::GROUP_TYPE_CJT ? App_Helper_Trade::TRADE_LOTTERY_WAIT_DRAW : ($cfg['ac_type'] == 12 ? App_Helper_Trade::TRADE_SHIP : App_Helper_Trade::TRADE_HAD_PAY),
            );
            foreach ($joiner as $item) {
                if ($item['gm_tid'] && !$item['gm_is_robot']) {
                    $trade_model->findUpdateTradeByTid($item['gm_tid'], $updata);
                    $mids[] = intval($item['gm_mid']);
                    $group_helper->sendGroupTmplmsg($item['gm_tid'], 'ptcg');
                    $group_helper->sendAppletGroupTmplmsg($item['gm_tid'], 'ptcg');
                }
            }
            $group_helper->sendGroupNewsmsg($actid, $mids, 'ptcg');
            //设置当前订单状态为拼团成功
            $trade_status   = $updata['t_status'];
            //非抽奖拼团,成功后修改库存量
            if ($group['gb_type'] != App_Helper_Group::GROUP_TYPE_CJT) {
                //拼团成功,商品库存量调整
                $real   = $mem_model->getRealJoiner($gbid);
                if($cfg['ac_type'] == 12 && $this->sid == 4230){//培训版
                    foreach ($real as $item) {
                        $this->adjustTradeCourseApply($item['t_id']);
                    }
                }else{
                    foreach ($real as $item) {
                        $this->adjustTradeGoodsStock($item['t_id']);
                    }
                }
                //todo 拼团成功打印拼团订单
                $print_model = new App_Helper_Print($this->sid);
                $print_model->printGroupOrder($joiner,'',0);

//                foreach ($real as $item) {
//                    $this->adjustTradeGoodsStock($item['t_id']);
//                }
            }
        } else {//等待拼团成功
            //设置当前订单状态为待成团
            $trade_status   = self::TRADE_WAIT_GROUP;
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
            case self::TRADE_APPLET :
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
                //退回商品库存
                if($trade['t_status'] != 6 ){
                    $this->goodsRefundStock($trade);
                }
                break;
        }
    }

    /*
     * 退回商品库存
     */
    public function goodsRefundStock($trade){
        $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
        $format_model = new App_Model_Goods_MysqlFormatStorage($this->sid);
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $where = [];
        $where[] = ['name' => 'to_s_id', 'oper' => '=', 'value' => $this->sid];
        $where[] = ['name' => 'to_t_id', 'oper' => '=', 'value' => $trade['t_id']];
        $where[] = ['name' => 'to_fd_result','oper'=>'=','value' =>2]; // 只查找被退款的子订单去恢复库存

        //$orderList = $order_model->getList($where,0,0,[],['to_g_id','to_gf_id','to_num']);
        $orderList = $order_model->getListGoods($where,0,0,[]);
        if($orderList){
            foreach ($orderList as $val){
                if($val['to_gf_id'] > 0 && $val['to_num'] > 0){
                    //增加规格库存
                    $is_reduce_format=$format_model->incrementGoodsStock($val['to_gf_id'],$val['to_g_id'],$val['to_num']);
                    //增加商品库存
                    $is_reduce_success=$goods_model->incrementGoodsStock($val['to_g_id'],$val['to_num']);
                    $is_reduce_success=($is_reduce_format && $is_reduce_success);
                }else{
                    //增加商品库存
                    $is_reduce_success=$goods_model->incrementGoodsStock($val['to_g_id'],$val['to_num']);
                }

                // 退款库存 记录
                // zhangzc
                // 2019-09-03
                $trade_record_model=new App_Model_Trade_MysqlTradeRecordStorage($this->sid);
                $record_data=[
                    'tsr_sid'   =>$this->sid,
                    'tsr_gfid'  =>$val['to_gf_id'],
                    'tsr_gid'   =>$val['to_g_id'],
                    'tsr_tid'   =>$trade['t_id'],
                    'tsr_stock' =>$val['to_num'],
                    'tsr_type'  =>1,                //减库存
                    'tsr_reason'=>3,                //下单减库存
                    'tsr_class' =>__CLASS__,
                    'tsr_method'=>__METHOD__,
                    'tsr_ip'    =>$_SERVER['SERVER_ADDR'],
                    'tsr_create_time'=>time()
                ];   
                if(!$is_reduce_success){ 
                    $record_data['tsr_status']=0;
                }
                $trade_record_model->insertValue($record_data);


                //减少销量？
//                if($val['g_sold'] > 0){
//                    if($val['g_sold'] > $val['to_num']){
//                        $goods_model->incrementGoodsSold($val['to_g_id'],-$val['to_num']);
//                    }else{
//                        $goods_model->updateById(['g_sold'=>0],$val['to_g_id']);
//                    }
//                }
            }
        }
    }

    /*
     * 替换交易模板
     */
    public function replaceTradeTpl($trade, $tpl, $jump = null,$applet = 0) {
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');

        if($applet == 27){
            $tplval  = array(
                $trade['t_tid'], $trade['t_title'],
                $trade['t_total_fee'], date("Y-m-d H:i:s", $trade['t_pay_time'])
            );
            $tplreg   = $cfg[53];

        }else{
            $t_express_time = $trade['t_express_time']>0 ? date("Y-m-d H:i:s", $trade['t_express_time']) : date("Y-m-d H:i:s", $trade['t_pay_time']+86400);
            $tplval  = array(
                $trade['t_buyer_nick'], $this->shop['s_name'], $trade['t_tid'], $trade['t_title'], $trade['t_num'],
                $trade['t_total_fee'], $trade['t_post_fee'], $trade['t_express_company'], $trade['t_express_code'], $trade['t_express_company'], $trade['t_express_code'], $t_express_time,
                date("Y-m-d H:i:s", $trade['t_pay_time']),$trade['m_gold_coin']
            );
            $tplreg   = $cfg[1];
        }

        if ($jump) {
            $jumpval    = array(
                App_Helper_Tool::outputMobileLink($this->sid, 'trade', 'detail', array('tid' => $trade['t_tid'])),
            );

            $jumpreg    = $cfg["url-1"];

            foreach ($tplreg as &$item) {
                $item   = "/{$item}/";
            }

            foreach ($jumpreg as &$one) {
                $one   = "/{$one}/";
            }
        }

        return array(
            preg_replace($tplreg, $tplval, $tpl),
            $jump ? preg_replace($jumpreg, $jumpval, $jump) : null,
        );
    }

    /*
 * 社区拼团订单通知团长
 */
    public function replaceNoticeLeaderTpl($trade, $tpl, $jump = null) {
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        $tplval  = array(
            $trade['t_tid'], date("Y-m-d H:i:s", $trade['t_pay_time']), $trade['t_buyer_nick'], $trade['t_title'], $trade['t_total_fee'], $trade['t_post_fee']
        );
        $tplreg   = $cfg[34];

        if ($jump) {
            $jumpval    = array(
                App_Helper_Tool::outputMobileLink($this->sid, 'trade', 'detail', array('tid' => $trade['t_tid'])),
            );

            $jumpreg    = $cfg["url-1"];

            foreach ($tplreg as &$item) {
                $item   = "/{$item}/";
            }

            foreach ($jumpreg as &$one) {
                $one   = "/{$one}/";
            }
        }

        return array(
            preg_replace($tplreg, $tplval, $tpl),
            $jump ? preg_replace($jumpreg, $jumpval, $jump) : null,
        );
    }

    /*
     * 替换入驻模板
     */
    public function replaceEnterTpl($audit, $tpl) {
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($audit as $key=>$val){
            $audit[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval  = array(
            $audit['name'],$audit['result'],$audit['apply_time'],$audit['audit_time'],$audit['audit_note']
        );
        $tplreg   = $cfg[3];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /*
     * 替换拼团
     */
    public function replaceGroupTpl($group, $tpl, $jump=null, $goods=array(), $winnerList='') {
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        $tplval  = array(
            $group['go_total'], $group['gb_price'], $group['go_tz_nick'], $group['go_had'], intval($group['go_total'])-intval($group['go_had']),
            date("Y-m-d H:i:s", $group['gm_join_time']), $goods['g_name'], $goods['g_price'], ($group['gm_is_winner']?'已中奖':'未中奖'), $winnerList
        );
        $tplreg   = $cfg[2];

        $jumpval    = array(
            App_Helper_Tool::outputMobileLink($this->sid, 'group', 'join', array('gbid' => $group['go_id'])),
            App_Helper_Tool::outputMobileLink($this->sid, 'group', 'detail', array('gbid' => $group['gb_id'])),
        );

        $jumpreg    = $cfg["url-2"];

        foreach ($tplreg as &$item) {
            $item   = "/{$item}/";
        }

        foreach ($jumpreg as &$item) {
            $item   = "/{$item}/";
        }

        return array(
            preg_replace($tplreg, $tplval, $tpl),
            $jump ? preg_replace($jumpreg, $jumpval, $jump) : null,
        );
    }

    /**
     * 替换充值推送模板
     */
    public function replaceRechargeTpl($infor, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($infor as $key=>$val){
            $infor[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval  = array(
            $infor['tid'],$infor['price'],$infor['coin'],$infor['time'], $infor['balance']
        );
        $tplreg   = $cfg[21];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 替换砍价完成推送模板
     */
    public function replaceBargainCompleteTpl($infor, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($infor as $key=>$val){
            $infor[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval  = array(
            $infor['goods'],$infor['minPrice'],$infor['helperNum'],$infor['helperMoney'],$infor['startTime'],$infor['endTime']
        );
        $tplreg   = $cfg[23];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 替换砍价帮砍推送模板
     */
    public function replaceBargainHelperTpl($infor, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($infor as $key=>$val){
            $infor[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval  = array(
            $infor['goods'],$infor['helperMember'],$infor['helperMoney'],$infor['leftMoney'],$infor['minPrice'],$infor['helperNum'],$infor['helperTotalMoney']
        );
        $tplreg   = $cfg[48];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 替换退款推送模板
     */
    public function replaceRefundTpl($infor, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($infor as $key=>$val){
            $infor[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval  = array(
            $infor['tid'],$infor['title'],$infor['num'],$infor['reason'],$infor['totalFee'],$infor['refundFee'],$infor['payTime'],$infor['refundTime']
        );
        $tplreg   = $cfg[22];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 积分变更提醒变量替换
     */
    public function replacePointsChangeTpl($infor, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($infor as $key=>$val){
            $infor[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval = array(
            $infor['before'],$infor['after'],$infor['change'],$infor['desc'],$infor['getTotal'],$infor['spendTotal']
        );
        $tplreg   = $cfg[43];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }


    /**
     * 余额变更提醒变量替换
     */
    public function replaceCoinChangeTpl($infor, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($infor as $key=>$val){
            $infor[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval = array(
            $infor['before'],$infor['after'],$infor['change'],$infor['desc'],
        );
        $tplreg   = $cfg[44];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 组队红包组队成功变量替换
     */
    public function replaceRedbagSuccessTpl($infor, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($infor as $key=>$val){
            $infor[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval = array(
            $infor['name'],$infor['money'],$infor['num'],$infor['joiner'],
        );
        $tplreg   = $cfg[45];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 会务报名成功
     */
    public function replaceMeetingTradeTpl($infor, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($infor as $key=>$val){
            $infor[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval = array(
            $infor['tid'],$infor['nickname'],$infor['meetingName'],$infor['meetingType'],$infor['typeDesc'],$infor['orderMoney'],$infor['orderTime'],$infor['meetingTime'],$infor['meetingAddr']
        );
        $tplreg   = $cfg[47];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 留言表单处理通知
     */
    public function replaceFormDealTpl($infor, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($infor as $key=>$val){
            $infor[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval = array(
            $infor['title'],$infor['createTime'],$infor['dealContent'],$infor['dealTime']
        );
        $tplreg   = $cfg[49];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 替换资讯推送模板
     */
    public function replaceInforTpl($infor, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($infor as $key=>$val){
            $infor[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval  = array(
            $infor['title'],$infor['time'],$infor['desc']
        );
        $tplreg   = $cfg[6];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 替换产品服务推送模板
     */
    public function replaceServiceTpl($infor, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($infor as $key=>$val){
            $infor[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval  = array(
            $infor['title'],$infor['price'],$infor['desc'],$infor['label'],$infor['time']
        );
        $tplreg   = $cfg[8];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 替换产品服务推送模板
     */
    public function replaceLotteryTpl($infor, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($infor as $key=>$val){
            $infor[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval  = array(
            $infor['title'],$infor['goods']
        );
        $tplreg   = $cfg[9];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 替换预约项目推送模板
     */
    public function replaceAppointmentTpl($infor, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($infor as $key=>$val){
            $infor[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval = array(
            $infor['title'],$infor['price'],$infor['long'],$infor['date'],$infor['time'],$infor['brief']
        );
        $tplreg   = $cfg[10];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 替换版本更新推送模板
     */
    public function replaceUpgradeTpl($infor, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        $tplval = array(
            $infor['code']
        );
        $tplreg   = $cfg[11];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 替换商品推送模板
     */
    public function replaceGoodsTpl($infor, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($infor as $key=>$val){
            $infor[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval = array(
            $infor['title'],$infor['oriPrice'],$infor['price'],$infor['limit'],$infor['sold'],$infor['stock']
        );
        $tplreg   = $cfg[12];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 替换拼团活动推送模板
     */
    public function replaceGroupActTpl($infor, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($infor as $key=>$val){
            $infor[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval = array(
            $infor['title'],$infor['rule'],$infor['tzPrice'],$infor['price'],$infor['total'],$infor['startTime'],$infor['endTime']
        );
        $tplreg   = $cfg[13];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 替换拼团活动推送模板
     */
    public function replaceLimitActTpl($infor, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($infor as $key=>$val){
            $infor[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval = array(
            $infor['title'],$infor['startTime'],$infor['endTime'],$infor['label']
        );
        $tplreg   = $cfg[14];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 替换帖子推送模板
     */
    public function replacePostTpl($infor, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($infor as $key=>$val){
            $val = strip_tags($val);
            $infor[$key] = str_replace("\n", "\\n",$val);
            $infor[$key] = str_replace("\r", "\\r",$val);
        }
        $tplval = array(
            $infor['nickname'],$infor['content'],$infor['time']
        );
        $tplreg   = $cfg[16];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 替换店铺推送模板
     */
    public function replaceShopTpl($infor, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($infor as $key=>$val){
            $infor[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval = array(
            $infor['name'],$infor['address'],$infor['phone']
        );
        $tplreg   = $cfg[17];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 替换拼团活动推送模板
     */
    public function replaceBargainActTpl($infor, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($infor as $key=>$val){
            $infor[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval = array(
            $infor['title'],$infor['buyPrice'],$infor['kjPrice'],$infor['startTime'],$infor['endTime']
        );
        $tplreg   = $cfg[15];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 优惠券推送模板
     */
    public function replaceCouponTpl($infor, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($infor as $key=>$val){
            $infor[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval = array(
            $infor['title'],$infor['value'],$infor['limit'],$infor['count'],$infor['receive'],$infor['rlimit'],$infor['startTime'],$infor['endTime']
        );
        $tplreg   = $cfg[18];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 答题模板
     */
    public function replaceAnswerTpl($infor, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($infor as $key=>$val){
            $infor[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval = array(
            $infor['time'],$infor['shareNum'],$infor['allowNum'],$infor['phone'],
        );
        $tplreg   = $cfg[19];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 店铺动态替换
     */
    public function replaceDynamicTpl($infor, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($infor as $key=>$val){
            $infor[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval = array(
            $infor['label'],$infor['desc'],
        );
        $tplreg   = $cfg[20];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 替换商家到期发送消息模板
     */
    public function replaceShopExpireTpl($shop, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        $tplval  = array(
            $shop['name'],$shop['time'],$shop['day']
        );
        $tplreg   = $cfg[7];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /*
     * 替换评论模板
     */
    public function replaceCommentTpl($comment, $tpl) {
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($comment as $key=>$val){
            $comment[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval  = array(
            $comment['observer'],$comment['content'],$comment['time']
        );
        $tplreg   = $cfg[4];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /*
     * 替换点赞模板
     */
    public function replaceLikeTpl($like, $tpl, $jump = null) {
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        $tplval  = array(
            $like['observer'],$like['time'],$like['times']
        );
        $tplreg   = $cfg[5];

        if ($jump) {
            $jumpval    = array(
                App_Helper_Tool::outputMobileLink($this->sid, 'trade', 'detail', array('tid' => $trade['t_tid'])),
            );

            $jumpreg    = $cfg["url-1"];

            foreach ($tplreg as &$item) {
                $item   = "/{$item}/";
            }

            foreach ($jumpreg as &$one) {
                $one   = "/{$one}/";
            }
        }


        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /*
     * 替换工单创建消息模板
     */
    public function replaceOrderCreateTpl($order, $tpl) {
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($order as $key=>$val){
            $order[$key] = str_replace("\n", "\\n",$val);
            $order[$key] = str_replace("\t", "\\t",$val);
        }
        $tplval  = array(
            $order['type'],$order['title'],$order['content'],$order['status'],$order['createTime'],$order['dealTime']
        );
        $tplreg   = $cfg[24];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /*
     * 替换工单评论消息模板
     */
    public function replaceOrderCommentTpl($comment, $tpl) {
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($comment as $key=>$val){
            $comment[$key] = str_replace("\n", "\\n",$val);
            $comment[$key] = str_replace("\t", "\\t",$val);
        }
        $tplval  = array(
            $comment['title'],$comment['status'],$comment['commenter'],$comment['content'],$comment['time']
        );
        $tplreg   = $cfg[25];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /*
     * 替换帖子赞赏消息模板
     */
    public function replacePostRewardTpl($reward, $tpl) {
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($reward as $key=>$val){
            $reward[$key] = str_replace("\n", "\\n",$val);
            $reward[$key] = str_replace("\t", "\\t",$val);
        }
        $tplval  = array(
            $reward['content'],$reward['member'],$reward['money'],$reward['time']
        );
        $tplreg   = $cfg[26];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /*
     * 替换投递状态变化消息模板
     */
    public function replaceSendStatusChangeTpl($comment, $tpl) {
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($comment as $key=>$val){
            $comment[$key] = str_replace("\n", "\\n",$val);
            $comment[$key] = str_replace("\t", "\\t",$val);
        }
        $tplval  = array(
            $comment['title'],$comment['company'],$comment['status'],$comment['time']
        );
        $tplreg   = $cfg[27];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /*
     * 替换简历被查看消息模板
     */
    public function replaceResumeShowTpl($showData, $tpl) {
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($showData as $key=>$val){
            $showData[$key] = str_replace("\n", "\\n",$val);
            $showData[$key] = str_replace("\t", "\\t",$val);
        }
        $tplval  = array(
            $showData['company'],$showData['date'],$showData['showTimes']
        );
        $tplreg   = $cfg[38];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }


    /*
     * 替换推荐成功消息模板
     */
    public function replaceRecommendSuccessTpl($comment, $tpl) {
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($comment as $key=>$val){
            $comment[$key] = str_replace("\n", "\\n",$val);
            $comment[$key] = str_replace("\t", "\\t",$val);
        }
        $tplval  = array(
            $comment['ninckname'],$comment['position'],$comment['time'],
        );
        $tplreg   = $cfg[28];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /*
     * 替换分销佣金消息模板
     */
    public function replaceDeductTpl($deduct, $tpl) {
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($deduct as $key=>$val){
            $deduct[$key] = str_replace("\n", "\\n",$val);
            $deduct[$key] = str_replace("\t", "\\t",$val);
        }
        $tplval  = array(
            $deduct['tid'],$deduct['goods'],$deduct['member'],$deduct['amount'],$deduct['deduct'],$deduct['status']
        );
        $tplreg   = $cfg[30];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
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
    public function checkAppletTradeRefund($pay_type, $refund_amount, $tid = null) {
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
            //微信支付代销
            case self::TRADE_PAY_WXZFDX :
                //获取结算记录
                $settled_model  = new App_Model_Trade_MysqlTradeSettledStorage($this->sid);
                $settled        = $settled_model->findSettledByTid($tid);
                //已成功结算的订单
                if ($settled && $settled['ts_status'] == 1) {
                    $store_model = new App_Model_Entershop_MysqlEnterShopStorage();
                    $store = $store_model->getRowById($settled['ts_es_id']);

                    if ($store['es_balance'] < $refund_amount) {  // && $store['es_recharge'] < $refund_amount
                        $return = array(
                            'errno'     => -4,
                            'errmsg'    => "您的平台账户可用余额{{$store['es_recharge']}}元, 少于本次退款金额{$refund_amount}元",
                        );
                    } else {
                        $return = array(
                            'errno'     => 0,
                            'errmsg'    => "您的店铺收益余额为{$store['es_balance']}元, 平台账户可用余额为{{$store['es_recharge']}}元。本次退款将优先扣除店铺收益余额,如果不足,将扣除平台账户可用余额。",
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
    public function orderDeliverUpdateTrade($tid,$company,$code,$need,$express='',$expressNote = ''){
        $ret = false;
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $row = $trade_model->findUpdateTradeByTid($tid);
        // 订单存在且订单支付完成则允许发货
        if($row && ($row['t_status']==3 || $row['t_status']==10)){
            $set = array(
                't_need_express'    => $need,
                't_status'          => 4,
                't_express_time'    => time(),
            );
            if($need == 1 || $need == 2){
                $set['t_express_company'] = $company;
                $set['t_express_code']    = $code;
            }
            if($express){
                $set['t_company_code'] = $express;
            }
            if($expressNote){
                $set['t_express_note'] = plum_sql_quote($expressNote);
            }
            $overtime   = plum_parse_config('trade_overtime');
            $currTime =$this->shop['s_finish_trade'] && $this->shop['s_finish_trade'] > 0 ? $this->shop['s_finish_trade']*86400 : $overtime['finish'];
            $set['t_finish_check_long'] = $currTime;
            $ret = $trade_model->findUpdateTradeByTid($tid,$set);
            if($ret){
                //@todo 发货成功，设置自动完成时间
                $trade_redis= new App_Model_Trade_RedisTradeStorage($this->sid);
                $trade_redis->setTradeFinishTtl($row['t_id'], $currTime);
                //@todo 发送订单发货状态消息
                self::sendTradeStatusMessage($tid, self::TRADE_MESSAGE_SEND_MJFH);
                //短信通知买家订单已发货
                $sms_helper = new App_Helper_Sms($this->sid);
                $sms_helper->sendNoticeSms($row, 'mjfhtz');
                if($row['t_type']>=self::TRADE_APPLET){  // 小程序订单，推送通知
                    $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                    $member = $member_model->getRowById($row['t_m_id']);
                    $appletType = plum_parse_config('member_source_menu_type')[$member['m_source']];
                    $appletType = $appletType ? $appletType : 0;
                    plum_open_backend('index', 'wxappTempl', array('sid' => $this->sid, 'tid' => $tid, 'type' => App_Helper_WxappApplet::SEND_SETUP_MJFH,'appletType' => $appletType));
                }
            }
        }
        return $ret;
    }
    /*
     * 处理自动退款订单
     * @param int $tid 订单主键ID
     */
    public function dealAutoRefund($tid, $toid=0) {
        $trade_model= new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade      = $trade_model->getRowById($tid);

        $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
        if($toid){
            $order = $order_model->getRowById($toid);
            $trade = $trade_model->getRowById($order['to_t_id']);
        }

       // $cfg_model = new App_Model_Applet_MysqlCfgStorage($trade['t_s_id']);
       // $cfg = $cfg_model->findShopCfg();

        if (!$trade) {
            return;
        }
        $ret = [];
        //维权中的订单
        if ($trade['t_feedback'] == self::FEEDBACK_YES) {
            //订单完成后不能退款
            if($trade['t_status'] == self::TRADE_FINISH){
                return;
            }
            //等待商家处理的维权到期
            if ($trade['t_fd_status'] == self::FEEDBACK_REFUND_SELLER) {
                //商家到期未处理,设置自动退款
                $ret = $this->appletDealRefundNew($tid, 'id', '', 2,'', $toid);
            } else if ($trade['t_fd_status'] == self::FEEDBACK_REFUND_CUSTOMER) {//等待买家处理的维权到期
                //买家到期未处理,设置维权结束
                if($trade['t_applet_status'] == self::TRADE_APPLET_WEDDING){
                    //婚纱版拒绝退款超时不做处理
                }else{
                    $updata = array(
                        't_feedback'    => self::FEEDBACK_OVER,
                        't_fd_status'   => self::FEEDBACK_REFUND_SOLVE,
                        't_fd_result'   => self::FEEDBACK_RESULT_CANCEL,//买家撤销
                    );
                    $trade_model->updateById($updata, $tid);
                    if($toid){
                        $toupdata = array(
                            'to_feedback'    => self::FEEDBACK_OVER,
                            'to_fd_status'   => self::FEEDBACK_REFUND_SOLVE,
                            'to_fd_result'   => self::FEEDBACK_RESULT_CANCEL,//买家撤销
                        );
                        $order_model->updateById($toupdata, $toid);
                    }
                }

            }
            if(isset($ret['code']) && $ret['code'] == 'success'){
                $accountant_model = new App_Model_Accountant_MysqlAccountantConfirmStorage($this->sid);
                $confirm_row = $accountant_model->getRowByTypeId(2,$trade['t_id'],1);
                if($confirm_row){
                    //如果有未审核的会计审核退款 自动完成
                    $confirm_set = [
                        'aac_handle_status' => 2,
                        'aac_handle_time' => time(),
                        'aac_handle_remark' => '系统自动退款'
                    ];
                    $accountant_model->updateById($confirm_set,$confirm_row['aac_id']);
                }
            }
        }
    }

    /*
     * 处理餐饮未接单自动退款
     * @param int $tid 订单主键ID
     */
    public function dealUnreceiveOrder($tid) {
        $trade_model= new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade      = $trade_model->getRowById($tid);
        if (!$trade) {
            return;
        }
        if($trade['t_status']==2){  //未接单的订单
            $refund_model   = new App_Model_Trade_MysqlTradeRefundStorage($this->sid);
            $indata     = array(
                'tr_s_id'       => $this->sid,
                'tr_wid'        => App_Plugin_Weixin_PayPlugin::makeMchOrderid('W'),
                'tr_tid'        => $tid,
                'tr_reason'     => '商家未接单, 系统自动退款',//退款原因
                'tr_money'      => $trade['t_payment'] + $trade['t_coin_payment'],
                'tr_create_time'=> time(),
                'tr_status'     => 0,//退款待处理
            );
            $ret = $refund_model->insertValue($indata);
            if($ret){
                $source = 2;
                if($this->sid==7449){
                    $source =1;
                }
                $this->appletHandleRefund($trade['t_tid'],2,'商家未接单, 系统自动退款',$source);
            }
        }else{
            return;
        }
    }

    /*
     * 处理退款逻辑
     * $tid:订单编号
     * $status : 1拒绝退款，2同意退款
     * $note : 退款备注
     */
    public function handleRefund($tid,$status,$note){
        $trade_ret = false;
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $row = $trade_model->findUpdateTradeByTid($tid);
        if(!empty($row) && in_array($status,array(1,2))){
            if($row['t_feedback'] == 0){
                $updata = array(
                    't_feedback'        => App_Helper_Trade::FEEDBACK_YES,
                    't_fd_status'       => App_Helper_Trade::FEEDBACK_REFUND_SELLER,//待商家处理
                );
                $trade_model->findUpdateTradeByTid($tid, $updata);
                //创建退款申请
                $refund_model   = new App_Model_Trade_MysqlTradeRefundStorage($this->sid);
                $indata = array(
                    'tr_s_id'       => $this->sid,
                    'tr_wid'        => App_Plugin_Weixin_PayPlugin::makeMchOrderid('W'),
                    'tr_tid'        => $tid,
                    'tr_reason'     => '',
                    'tr_contact'    => '',
                    'tr_money'      => $row['t_payment'],
                    'tr_create_time'=> time(),
                );
                $refund_model->insertValue($indata);
            }
            $row = $trade_model->findUpdateTradeByTid($tid);

            //@todo 1有维权；2维权结束，拒绝退款的，再给机会同意退款
            //if($row['t_feedback'] == self::FEEDBACK_YES || ($row['t_feedback'] == self::FEEDBACK_OVER && $row['t_fd_result'] == self::FEEDBACK_RESULT_REFUSE && $status == self::FEEDBACK_RESULT_AGREE)){
            if($row['t_feedback'] == self::FEEDBACK_YES && $row['t_fd_status']==self::FEEDBACK_REFUND_SELLER){
                $trade_redis    = new App_Model_Trade_RedisTradeStorage($this->sid);
                if($status == self::FEEDBACK_RESULT_AGREE){ //同意退款
                    $trade_ret    = self::dealRefund($row['t_id']);
                    //@todo 已完成订单，若同意退款，则收回佣金
                    if($trade_ret){
                        if ($row['t_status'] == self::TRADE_FINISH) {
                            $order_deduct_helper = new App_Helper_OrderDeduct($this->sid);
                            $order_deduct_helper->refundOrderDeduct($row['t_tid'],$row['t_m_id']);
                        }
                        // 同意退款清除定时任务
                        $trade_redis->delTradeRefundTtl($row['t_id']);

                        // 发送订单状态信息
                        self::sendTradeStatusMessage($tid, self::TRADE_MESSAGE_SEND_TKCG);
                    }
                }elseif($status == self::FEEDBACK_RESULT_REFUSE){ //拒绝退款
                    //@todo 修改交易状态
                    $set = array(
                        't_fd_result' => $status,
                        't_fd_status'  => self::FEEDBACK_REFUND_CUSTOMER,
                    );
                    $trade_ret = $trade_model->findUpdateTradeByTid($tid,$set);
                    //@todo 修改退款状态
                    $refund = array(
                        'tr_seller_note' => $note,
                        'tr_note_time'   => time(),
                        'tr_status'      => $status,
                    );
                    // 卖家拒绝重新设置定时任务
                    $overtime   = plum_parse_config('trade_overtime');
                    $trade_redis->setTradeRefundTtl($row['t_id'], $overtime['refund']);
                    $refund_model = new App_Model_Trade_MysqlTradeRefundStorage($this->sid);
                    //获取最新一条维权订单信息
                    $refund_new = $refund_model->getLastRecord($tid);
                    // 修改最近一次维权订单信息
                    $refund_model->findUpdateByTrid($refund_new['tr_id'],$refund);
                    // 发送订单状态信息
                    self::sendTradeStatusMessage($tid, self::TRADE_MESSAGE_SEND_TKSB);
                    //短信通知买家订单已拒绝退款
                    $sms_helper = new App_Helper_Sms($this->sid);
                    $sms_helper->sendNoticeSms($row, 'jjtktz');

                }
            }
        }
        return $trade_ret;
    }

    /*
     * 小程序处理退款逻辑
     * $tid:订单编号
     * $status : 1拒绝退款，2同意退款
     * $note : 退款备注
     * @param int $source 默认2 从余额退款  1表示从待结算退款
     * @param int $is_insert_refund 默认 1,从后台主动退款的通过会计审核过来的订单已经提前写入了记录了，所以会计审核的就不在重复写入了
     */
    public function  appletHandleRefund(
        $tid,                   //订单id
        $status,                //1拒绝退款 2同意退款
        $note,                  //退款备注
        $source=2,              //2余额退款，1待结算退款
        $manager = [],          //
        $toid = 0,              //子订单id
        $to_refund_fee=0,       //退款金额
        $is_insert_refund=1     //1,从后台主动退款的通过会计审核过来的订单已经提前写入了记录了，所以会计审核的就不在重复写入了
    ){
        $result = array(
            'ec' => 400,
            'em' => '退款处理失败'
        );;


        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $row = $trade_model->findUpdateTradeByTid($tid);

        $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);

        $cfg_model = new App_Model_Applet_MysqlCfgStorage($this->sid);
        $cfg = $cfg_model->findShopCfg();

        //已经结束的退款不再进行处理 dn 2019-09-12
        $enter_permisson= $toid ?TRUE:($row['t_fd_status'] != 3);
        if(!empty($row) && $enter_permisson && in_array($status,array(1,2))){
            if($cfg['ac_type'] == 32 || $cfg['ac_type'] == 36){
                $where_order = [];
                // 子订单判断子订单是否被核销
                // zhangzc
                // 2019-10-21
                if($toid){
                    $where_order[] = ['name'=>'to_id','oper'=>'=','value'=>$toid];
                }
                $where_order[] = ['name'=>'to_t_id','oper'=>'=','value'=>$row['t_id']];
                $where_order[] = ['name'=>'to_se_verify','oper'=>'=','value'=>1];

                $order_verify = $order_model->getRow($where_order);
                if($order_verify){
                    $result = [
                        'ec' => 400,
                        'em' => '订单有商品已经核销，不能退款'
                    ];
                    return $result;
                }
                if($row['t_status'] == self::TRADE_FINISH){
                    $result = [
                        'ec' => 400,
                        'em' => '订单已经核销，不能退款'
                    ];
                    return $result;
                }
            }
            // 没有退款状态或者是退款结束的
            if($toid){
                $order_info=$order_model->getRowById($toid);
                $feedback_status=($order_info['to_feedback'] == 0 || $order_info['to_feedback'] == 2);
            }else{
                $feedback_status=($row['t_feedback'] == 0 || $row['t_feedback'] == 2);
            }

            if($feedback_status){
                $updata = array(
                    't_feedback'        => App_Helper_Trade::FEEDBACK_YES,
                    't_feedback_type'   => $toid?1:0,
                    't_fd_status'       => App_Helper_Trade::FEEDBACK_REFUND_SELLER,//待商家处理
                );
                // 是否可以更新trade 表中的退款状态
                $can_update_trade=TRUE;
                
                $toupdata = array(
                    'to_feedback'        => App_Helper_Trade::FEEDBACK_YES,
                    'to_fd_status'       => App_Helper_Trade::FEEDBACK_REFUND_SELLER,//待商家处理
                );
                if($toid){
                    //单商品退款，修改单个商品订单的状态
                    $order_update_exec=$order_model->updateById($toupdata, $toid);
                    $order = $order_model->getRowById($toid);

                    // 计算单品退款的金额
                    if($to_refund_fee)
                        $refund_money=$to_refund_fee;
                    else
                        $refund_money = ($order['to_total']/$row['t_goods_fee']) * ($row['t_total_fee'] - $row['t_post_fee']);
                }else{
                    $order_model->updateOrderListByTid($toupdata, $row['t_id']);
                    if($to_refund_fee)
                        $refund_money=$to_refund_fee;
                    else
                        $refund_money = $row['t_pay_type'] == self::TRADE_PAY_HHZF ?  ($row['t_payment'] + $row['t_coin_payment']) : $row['t_payment'];
                }

                $trade_model->findUpdateTradeByTid($tid, $updata);


                //创建退款申请
                if($is_insert_refund){
                    $refund_model   = new App_Model_Trade_MysqlTradeRefundStorage($this->sid);
                    $indata = array(
                        'tr_s_id'       => $this->sid,
                        'tr_wid'        => App_Plugin_Weixin_PayPlugin::makeMchOrderid('W'),
                        'tr_tid'        => $tid,
                        'tr_to_id'      => $toid,
                        'tr_reason'     => $note ? $note : '',
                        'tr_contact'    => '',
                        'tr_money'      => $refund_money,
                        'tr_create_time'=> time(),
                    );
                    $refund_model->insertValue($indata);
                }
            }
            $row = $trade_model->findUpdateTradeByTid($tid);

            
            //if($row['t_feedback'] == self::FEEDBACK_YES || ($row['t_feedback'] == self::FEEDBACK_OVER && $row['t_fd_result'] == self::FEEDBACK_RESULT_REFUSE && $status == self::FEEDBACK_RESULT_AGREE)){
            

            //进入此代码块的条件-- 1有维权；2维权结束，拒绝退款的，再给机会同意退款 
            //这里只判断了整单的没有判断单品的-单品的如果也退了会更改主订单的状态的
            //如果是整单退款就查看是否在退款状态 FEEDBACK_YES=1有维权，  =1 等待商家处理的操作 ，FEEDBACK_REFUND_ACCOUNTANT=1等待会计处理的操作
            //如果是单品退款的应该调过这个直接看单品退款的里面的状态
            if($toid){
                $order_info=$order_model->getRowById($toid);
                $refund_status=($order_info['to_feedback'] == self::FEEDBACK_YES && ($order_info['to_fd_status']==self::FEEDBACK_REFUND_SELLER || $order_info['to_fd_status']==self::FEEDBACK_REFUND_ACCOUNTANT));
            }else{
                $refund_status=($row['t_feedback'] == self::FEEDBACK_YES && ($row['t_fd_status']==self::FEEDBACK_REFUND_SELLER || $row['t_fd_status']==self::FEEDBACK_REFUND_ACCOUNTANT));
            }
            if($refund_status){
                $trade_redis    = new App_Model_Trade_RedisTradeStorage($this->sid);
                if($status == self::FEEDBACK_RESULT_AGREE){ //同意退款

                    $trade_ret    = self::appletDealRefundNew($row['t_id'], 'id', '', $source,$manager, $toid);
                    //@todo 已完成订单，若同意退款，则收回佣金
                    if($trade_ret && $trade_ret['code'] == 'success'){
                        if ($row['t_status'] == self::TRADE_FINISH || $row['t_status'] == self::TRADE_HAD_PAY || $row['t_status'] == self::TRADE_SHIP) {
                            $order_deduct_helper = new App_Helper_OrderDeduct($this->sid);
                            $order_deduct_helper->refundOrderDeduct($row['t_tid'],$row['t_m_id'], $order_info['to_g_id']);
                        }
                        // 同意退款清除定时任务
                        if($toid){
                            $trade_redis->delTradeOrderRefundTtl($order_info['to_id']);
                        }else{
                            $trade_redis->delTradeRefundTtl($row['t_id']);
                        }
                        //查看订单有没有赠送积分，若有，则扣除积分
                        if($row['t_points']>0){   //说明有，扣除积分
                            $this->_reduceMemberPoints($row, $toid?($order_info['to_total']/$row['t_goods_fee']):0);

                        }
                        if($cfg['ac_type'] == 32 || $cfg['ac_type'] == 36){
                            //删除该订单的未结算佣金
                            $deduct_model = new App_Model_Entershop_MysqlManagerDeductStorage($row['t_s_id']);
                            $where_deduct = [];
                            $where_deduct[] = ['name'=>'emd_s_id','oper'=>'=','value'=>$row['t_s_id']];
                            $where_deduct[] = ['name'=>'emd_tid','oper'=>'=','value'=>$row['t_tid']];
                            $where_deduct[] = ['name'=>'emd_status','oper'=>'=','value'=>1];
                            $deduct_model->deleteValue($where_deduct);

                            $nosettled_model = new App_Model_Sequence_MysqlSequenceDeductNosettledStorage($row['t_s_id']);
                            $where_nosettled = [];
                            $where_nosettled[] = ['name'=>'asdn_s_id','oper'=>'=','value'=>$row['t_s_id']];
                            $where_nosettled[] = ['name'=>'asdn_tid','oper'=>'=','value'=>$row['t_tid']];
                            $where_nosettled[] = ['name'=>'asdn_status','oper'=>'=','value'=>0];
                            $nosettled_model->deleteValue($where_nosettled);

                        }

                        //同步更新购物单
                        plum_open_backend('index', 'updateOrder', array('sid' => $this->sid, 'tid' => $row['t_tid']));
                        // 发送订单状态信息
                        self::sendTradeStatusMessage($tid, self::TRADE_MESSAGE_SEND_TKCG);
                        //减去会员的成交订单量及订单额
                        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
                        $member_storage->incrementMemberTrade($row['t_m_id'], -$trade_ret['money'], $toid?0:-1);

                        $result = array(
                            'ec' => 200,
                            'em' => '退款处理成功'
                        );
                    }else{
                        $result['em'] = $trade_ret['msg'];
                    }
                }elseif($status == self::FEEDBACK_RESULT_REFUSE){ //拒绝退款
                    //修改交易状态
                    $set = array(
                        't_fd_result' => $status,
                        't_fd_status'  => self::FEEDBACK_REFUND_CUSTOMER,
                    );
                   // 更新子订单中的退款状态
                    $toset = array(
                        'to_fd_result' => $status,
                        'to_fd_status'  => self::FEEDBACK_REFUND_CUSTOMER,
                    );

                    //单品退款 判断trade_order里面还有没有正在退款（维权）中的订单(存在正在退款的订单则不更新trade表中的状态) 
                    //这里走的是用户申请的流程
                    //zhangzc
                    //2019-08-28
                    if($toid){
                        // 先更新状态在进行查询是否还有其他未结束的退款；否则查询到的恒成立了
                        $order_model->updateById($toset, $toid);

                        // 查看是否还有未完成的退款订单-执行主订单的相关操作
                        $can_update_trade=TRUE;
                        $refund_order_nums=$order_model->getCount([
                            ['name'=>'to_t_id','oper'=>'=','value'=>$row['t_id']],
                            ['name'=>'to_fd_status','oper'=>'=','value'=>1]     //等待商家处理的就是未完成的退款订单
                        ]);
                        if($refund_order_nums)
                            $can_update_trade=FALSE;

                        if($can_update_trade)
                            $trade_ret = $trade_model->findUpdateTradeByTid($tid,$set);
                        else
                            $trade_ret=true;                       
                    }else{
                        $trade_ret = $trade_model->findUpdateTradeByTid($tid,$set);
                        // 同步更新子订单中的退款状态
                        $order_model->updateOrderListByTid($toset, $row['t_id']);
                        if($row['t_fd_result']==$set['t_fd_result'] && $row['t_fd_status'] == $set['t_fd_status']){
                            $trade_ret = true;
                        }
                    }

                    //@todo 修改退款状态
                    $refund = array(
                        'tr_seller_note' => $note,
                        'tr_note_time'   => time(),
                        'tr_status'      => $status,
                    );
                    // 卖家拒绝重新设置定时任务
                    $overtime   = plum_parse_config('trade_overtime');
                    $trade_redis->setTradeRefundTtl($row['t_id'], $overtime['refund']);
                    $refund_model = new App_Model_Trade_MysqlTradeRefundStorage($this->sid);
                    //获取最新一条维权订单信息
                    $refund_new = $refund_model->getLastRecord($tid, $toid);
                    // 修改最近一次维权订单信息
                    $refund_model->findUpdateByTrid($refund_new['tr_id'],$refund);
                    // 发送订单状态信息
                    self::sendTradeStatusMessage($tid, self::TRADE_MESSAGE_SEND_TKSB);
                    //短信通知买家订单已拒绝退款
                    $sms_helper = new App_Helper_Sms($this->sid);
                    $sms_helper->sendNoticeSms($row, 'jjtktz');
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
    //退款后处理相应积分
    private function _reduceMemberPoints($row, $ratio){
        $point_helper   = new App_Helper_Point($this->sid);
        if($row['t_applet_type'] == 4){
            //积分商城订单 退还使用积分
            $title = '积分订单退款返还'.$row['t_points'].'积分';
            $point = $row['t_points'];
            $point_helper->memberPointRecord($row['t_m_id'], $point, $title, $point_helper::POINT_INOUT_INCOME, $point_helper::POINT_SOURCE_POINT_REFUND);
        }else{
            $title = '退款扣除'.$row['t_points'].'积分';
            $point = $ratio>0?round($ratio * $row['t_points']):$row['t_points'];
            $point_helper->memberPointRecord($row['t_m_id'], $point, $title, $point_helper::POINT_INOUT_OUTPUT, $point_helper::POINT_SOURCE_REFUND);
        }



    }


    /*
     * 入驻店铺处理退款  （同意退款处理）
     * @param $t_id 订单自增ID,非订单编号
     * @param string $param_type id 或 tid
     * @return
     */
    public function enterShoDealRefund($t_id, $param_type = 'id') {
        $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
        if ($param_type == 'id') {
            $trade      = $trade_model->getRowById($t_id);
        } else {
            $trade      = $trade_model->findUpdateTradeByTid($t_id);
        }

        $refund_model   = new App_Model_Trade_MysqlTradeRefundStorage($this->sid);
        $refund     = $refund_model->getLastRecord($trade['t_tid']);
        if (!$trade || !$refund) {
            return false;
        }
        $trade_redis    = new App_Model_Trade_RedisTradeStorage($this->sid);
        //要求退款金额大于总金额
        if ($trade['t_total_fee'] < $refund['tr_money']) {
            return false;
        }
        //判断是否可退款
        $verify = $this->checkAppletTradeRefund($trade['t_pay_type'], $refund['tr_money'], $trade['t_tid']);

        //退款失败
        if ($verify['errno'] < 0) {
            return false;
        }
        $refund_state   = true;


        //判断退款方式
        switch ($trade['t_pay_type']) {
            //微信支付自有
            case App_Helper_Trade::TRADE_PAY_WXZFZY :
                //发起微信退款
                $new_pay    = new App_Plugin_Weixin_NewPay($this->sid);
                if($trade['t_type'] >= self::TRADE_APPLET){
                    $ret = $new_pay->appletRefundPayOrder($trade['t_pay_trade_no'], $refund['tr_wid'], $trade['t_total_fee'], $refund['tr_money'], 'wx');
       
                    $refund_state   = $ret && $ret['code']=='SUCCESS' ? true : false;
                }else{
                    $ret = $new_pay->refundPayOrder($trade['t_pay_trade_no'], $refund['tr_wid'], $trade['t_total_fee'], $refund['tr_money'], 'wx');
                    $refund_state   = $ret ? true : false;
                }
                break;
            //微信支付代销
            case App_Helper_Trade::TRADE_PAY_WXZFDX :
                //支付宝支付代销
            case App_Helper_Trade::TRADE_PAY_ZFBZFDX :
                $balance    = floatval($this->shop['s_balance']);//店铺收益余额
                $recharge   = floatval($this->shop['s_recharge']);//店铺通天币
                $settled_model  = new App_Model_Trade_MysqlTradeSettledStorage($this->sid);
                $settled    = $settled_model->findSettledByTid($trade['t_tid']);
                //未找到结算,或已退款结算
                if (!$settled || $settled['ts_status'] == self::TRADE_SETTLED_REFUND) {
                    return false;
                }
                //已成功结算的交易,退款时,判断店铺余额是否充足
                if ($settled['ts_status'] == self::TRADE_SETTLED_SUCCESS) {
                    //需要判断店铺余额
                    if ($balance < floatval($refund['tr_money']) && $recharge < floatval($refund['tr_money'])) {
                        Libs_Log_Logger::outputLog("店铺余额不足以支撑退款金额,sid={$this->sid}");
                        return false;
                    }
                }
                //发起不同的退款
                if ($trade['t_pay_type'] == self::TRADE_PAY_WXZFDX) {
                    //发起微信退款
                    $fxb_pay    = new App_Plugin_Weixin_FxbPay($this->sid);
                    $ret = $fxb_pay->refundPayOrder($trade['t_pay_trade_no'], $refund['tr_wid'], $trade['t_total_fee'], $refund['tr_money'], 'wx');
                    $refund_state   = $ret ? true : false;
                } else if ($trade['t_pay_type'] == self::TRADE_PAY_ZFBZFDX) {
                    //发起支付宝退款
                    $zfb_pay    = new App_Plugin_Alipaysdk_Client($this->sid);
                    $ret = $zfb_pay->refundOrder($trade['t_pay_trade_no'], $refund['tr_wid'], $refund['tr_money']);
                    $refund_state   = $ret ? true : false;
                }

                if ($refund_state) {
                    //清除订单的自动结算
                    $trade_redis->delTradeSettledTtl($t_id);
                    //已成功结算的交易,退款
                    if ($settled['ts_status'] == self::TRADE_SETTLED_SUCCESS) {
                        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
                        $title      = "订单{$trade['t_tid']}退款, 扣除余额";
                        if ($balance >= floatval($refund['tr_money'])) {
                            //优先扣除收益额
                            $shop_model->incrementShopBalance($this->sid, -floatval($refund['tr_money']));
                            //记录支出流水
                            $inout_model    = new App_Model_Shop_MysqlShopInoutStorage($this->sid);
                            $outdata    = array(
                                'si_s_id'   => $this->sid,
                                'si_name'   => $title,
                                'si_amount' => $refund['tr_money'],
                                'si_balance'=> $balance-floatval($refund['tr_money']),
                                'si_type'   => 2,
                                'si_create_time'    => time(),
                            );
                            $inout_model->insertValue($outdata);
                        } else {
                            //其次扣除通天币
                            $shop_model->incrementShopRecharge($this->sid, -floatval($refund['tr_money']));
                            //记录支出流水
                            $inout_model    = new App_Model_Shop_MysqlBalanceInoutStorage($this->sid);
                            $indata = array(
                                'bi_s_id'       => $this->sid,
                                'bi_title'      => $title,
                                'bi_amount'     => $refund['tr_money'],
                                'bi_balance'    => $recharge-floatval($refund['tr_money']),
                                'bi_type'       => 2,
                                'bi_create_time'=> time(),
                            );
                            $inout_model->insertValue($indata);
                        }
                    }
                    //修改待结算交易为已退款状态
                    $updata = array(
                        'ts_status'     => self::TRADE_SETTLED_REFUND,
                        'ts_update_time'=> time(),
                    );
                    $settled_model->findUpdateSettled($settled['ts_id'], $updata);
                }
                break;
            //货到付款
            case App_Helper_Trade::TRADE_PAY_HDFK :
                //退款无任何操作
                break;
            //余额支付
            case App_Helper_Trade::TRADE_PAY_YEZF :
                //增加会员金币
                App_Helper_MemberLevel::goldCoinTrans($this->sid, $trade['t_m_id'], $refund['tr_money']);
                break;
            //优惠全免
            case App_Helper_Trade::TRADE_PAY_YHQM :
                //退款无操作
                break;
        }
        if ($refund_state) {
            $this->dealRefundTrade($trade);//退款成功后的处理
            //设置订单为退款订单
            $trupdata   = array(
                't_status'      => self::TRADE_REFUND,
                't_feedback'    => self::FEEDBACK_OVER,//维权结束
                't_fd_result'   => self::FEEDBACK_RESULT_AGREE,// 同意退款
                't_fd_status'   => self::FEEDBACK_REFUND_SOLVE,  // 维权解决
                't_refund_time' => time()
            );
            $trade_model->updateById($trupdata, $trade['t_id']);
            //短信通知买家订单已退款
            $sms_helper = new App_Helper_Sms($this->sid);
            $sms_helper->sendNoticeSms($trade, 'tytktz');
            //成功退款，标注退款成功
            $tr_set = array(
                'tr_status'      => self::FEEDBACK_REFUND_HANDLE, //  商家已处理
                'tr_finish_time' => time(),
            );
            $refund_model->updateById($tr_set,$refund['tr_id']);
        }

        return $refund_state;
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
  * @param int $source 默认2 从余额退款  1表示从待结算退款
  * @return
  */
    public function appletDealRefundNew($t_id, $param_type = 'id',$note='', $source=2,$manager = [], $toid=0) {

        $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
        if ($param_type == 'id') {
            $trade      = $trade_model->getRowById($t_id);
        } else {
            $trade      = $trade_model->findUpdateTradeByTid($t_id);
        }

        $refund_model   = new App_Model_Trade_MysqlTradeRefundStorage($this->sid);
        $refund     = $refund_model->getLastRecord($trade['t_tid'], $toid);

        if (!$trade || !$refund) {
            $refund_state   = array(
                'code' => 'fail',
                'msg'  => '订单不存在或退款申请不存在',
            );
            return $refund_state;
        }
        // 判断退款是否已处理
        if($refund['tr_status']!=0){   // 退款已经处理
            $refund_state   = array(
                'code' => 'fail',
                'msg'  => '该订单已进行过退款处理，请勿重复操作',
            );
            return $refund_state;
        }
        $trade_redis    = new App_Model_Trade_RedisTradeStorage($this->sid);
        //要求退款金额大于总金额
        if ($trade['t_total_fee'] < $refund['tr_money']) {
            $refund_state   = array(
                'code' => 'fail',
                'msg'  => '退款金额不符',
            );
            return $refund_state;
        }
        //判断是否可退款
        $verify = $this->checkAppletTradeRefund($trade['t_pay_type'], $refund['tr_money'], $trade['t_tid']);
        //退款失败
        if ($verify['errno'] < 0) {
            $refund_state   = array(
                'code' => 'fail',
                'msg'  =>  $verify['errmsg'],
            );
            return $refund_state;
        }

        //判断退款方式
        switch ($trade['t_pay_type']) {

            //微信支付自有
            case App_Helper_Trade::TRADE_PAY_WXZFZY :
                // 判断是否是服务商模式下支付
                $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
                $appcfg = $appletPay_Model->findRowPay();
                if($appcfg && $appcfg['ap_sub_pay']==1){
                    $subPay_storage = new App_Plugin_Weixin_AppletSubPay($this->sid);
                    $ret = $subPay_storage->appletRefundPayOrder($appcfg['ap_appid'],$trade['t_pay_trade_no'], $refund['tr_wid'], $trade['t_total_fee'], $refund['tr_money'], 'wx', $source);
                      
                    $ret_sub = $ret;

                    // 如果服务商模式退款处理失败，尝试普通商户退款
                    if($ret['code']!='SUCCESS'){
                        //发起微信退款
                        $new_pay    = new App_Plugin_Weixin_NewPay($this->sid);
                        $ret = $new_pay->appletRefundPayOrder($trade['t_pay_trade_no'], $refund['tr_wid'], $trade['t_total_fee'], $refund['tr_money'], 'wx', $source);
                        //当两次都失败时 防止尝试普通商户退款覆盖错误信息
                        if($ret_sub['code'] != 'SUCCESS' && $ret['code'] != 'SUCCESS'){
                            $ret['errmsg'] = $ret_sub['errmsg'];
                        }

                    }
                    $refund_state   = $ret && $ret['code']=='SUCCESS' ? true : false;
                }else{
                    //发起微信退款
                    $new_pay    = new App_Plugin_Weixin_NewPay($this->sid);
                    $ret = $new_pay->appletRefundPayOrder($trade['t_pay_trade_no'], $refund['tr_wid'], $trade['t_total_fee'], $refund['tr_money'], 'wx', $source);
                   
                    $refund_state   = $ret && $ret['code']=='SUCCESS' ? true : false;
                }

                if($trade['t_es_id'] > 0 && $refund_state){
                    $this->afterEntershopRefund($trade,$refund);
                }

                if(!$ret || $ret['code']!='SUCCESS' ){
                    if($trade['t_es_id']>0){
                        return array(
                            'code' => 'fail',
                            'msg'  => '退款处理失败，请联系平台管理员。失败原因：'.$ret['errmsg'],
                        );
                    }else{

                        return array(
                            'code' => 'fail',
                            'msg'  => $ret['errmsg'],
                        );
                    }
                }
                break;
            //微信支付代销
            case App_Helper_Trade::TRADE_PAY_WXZFDX :
                $store_model = new App_Model_Entershop_MysqlEnterShopStorage();
                $store = $store_model->getRowById($trade['t_es_id']);
                //支付宝支付代销
                $balance    = floatval($store['es_balance']);//店铺收益余额
                $recharge   = floatval($store['es_recharge']);//店铺通天币
                $settled_model  = new App_Model_Trade_MysqlTradeSettledStorage($this->sid);
                $settled    = $settled_model->findSettledByTid($trade['t_tid']);
                //未找到结算,或已退款结算
                if (!$settled || $settled['ts_status'] == self::TRADE_SETTLED_REFUND) {
                    return array(
                        'code' => 'fail',
                        'msg'  => '未找到结算,或已退款结算',
                    );
                }
                //已成功结算的交易,退款时,判断店铺余额是否充足
                if ($settled['ts_status'] == self::TRADE_SETTLED_SUCCESS) {
                    //需要判断店铺余额
                    if ($balance < floatval($refund['tr_money']) && $recharge < floatval($refund['tr_money'])) {
                        Libs_Log_Logger::outputLog("店铺余额不足以支撑退款金额,sid={$this->sid}");
                        return array(
                            'code' => 'fail',
                            'msg'  => '店铺余额不足以支撑退款金额',
                        );
                    }
                }
                //发起微信退款
                $new_pay    = new App_Plugin_Weixin_NewPay($this->sid);
                $ret = $new_pay->appletRefundPayOrder($trade['t_pay_trade_no'], $refund['tr_wid'], $trade['t_total_fee'], $refund['tr_money'], 'wx');
                if(!$ret || $ret['code']!='SUCCESS' ){
                    return array(
                        'code' => 'fail',
                        'msg'  => '退款处理失败，请联系平台管理员。失败原因：'.$ret['errmsg'],
                    );
                }
                //清除订单的自动结算
                $trade_redis->delTradeSettledTtl($t_id);
                //已成功结算的交易,退款
                if ($settled['ts_status'] == self::TRADE_SETTLED_SUCCESS) {
                    $title      = "订单{$trade['t_tid']}退款, 扣除余额";
                    $store_model->incrementShopBalance($store['es_id'], -floatval($refund['tr_money']));
                    //记录支出流水
                    $inout_model    = new App_Model_Shop_MysqlShopInoutStorage($this->sid);
                    $outdata    = array(
                        'si_s_id'   => $this->sid,
                        'si_es_id'  => $store['es_id'],
                        'si_name'   => $title,
                        'si_amount' => $refund['tr_money'],
                        'si_balance'=> $balance-floatval($refund['tr_money']),
                        'si_type'   => 2,
                        'si_create_time'    => time(),
                    );
                    $inout_model->insertValue($outdata);
                }
                //修改待结算交易为已退款状态
                $updata = array(
                    'ts_status'     => self::TRADE_SETTLED_REFUND,
                    'ts_update_time'=> time(),
                );
                $settled_model->findUpdateSettled($settled['ts_id'], $updata);
                break;
            //货到付款
            case App_Helper_Trade::TRADE_PAY_HDFK :
                //退款无任何操作
                break;
            //余额支付
            case App_Helper_Trade::TRADE_PAY_YEZF :
                //增加会员金币
                $res = App_Helper_MemberLevel::goldCoinTrans($this->sid, $trade['t_m_id'], $refund['tr_money']);
                if($res){
                    $this->_recharge_record($trade,$refund['tr_money']);
                }
                if($trade['t_es_id'] > 0 && $res){
                    $this->afterEntershopRefund($trade,$refund);
                }
                break;
            //混合支付
            case App_Helper_Trade::TRADE_PAY_HHZF :
                // 判断是否是服务商模式下支付
                $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
                $appcfg = $appletPay_Model->findRowPay();
                if($refund['tr_money'] > $trade['t_payment']){
                    $wxRefund = $trade['t_payment'];
                    $coinRefund = $refund['tr_money'] - $trade['t_payment'];
                }else{
                    $wxRefund = $refund['tr_money'];
                    $coinRefund = 0;
                }
                if($appcfg && $appcfg['ap_sub_pay']==1){
                    $subPay_storage = new App_Plugin_Weixin_AppletSubPay($this->sid);
                    $ret = $subPay_storage->appletRefundPayOrder($appcfg['ap_appid'],$trade['t_pay_trade_no'], $refund['tr_wid'], $trade['t_payment'], $wxRefund, 'wx', $source);
                    // 如果服务模式下退款失败，尝试一次普通商户退款
                    if($ret['code']!='SUCCESS'){
                        $new_pay    = new App_Plugin_Weixin_NewPay($this->sid);
                        $ret = $new_pay->appletRefundPayOrder($trade['t_pay_trade_no'], $refund['tr_wid'], $trade['t_payment'], $wxRefund, 'wx', $source);
                    }
                    $refund_state   = $ret && $ret['code']=='SUCCESS' ? true : false;
                }else{
                    //发起微信退款
                    $new_pay    = new App_Plugin_Weixin_NewPay($this->sid);
                    $ret = $new_pay->appletRefundPayOrder($trade['t_pay_trade_no'], $refund['tr_wid'], $trade['t_payment'], $wxRefund, 'wx', $source);
                    $refund_state   = $ret && $ret['code']=='SUCCESS' ? true : false;
                }
                if($trade['t_es_id'] > 0 && $refund_state){
                    $this->afterEntershopRefund($trade,$refund);
                }

                if(!$ret || $ret['code']!='SUCCESS' ){
                    if($trade['t_es_id']>0){
                        return array(
                            'code' => 'fail',
                            'msg'  => '退款处理失败，请联系平台管理员。失败原因：'.$ret['errmsg'],
                        );
                    }else{
                        return array(
                            'code' => 'fail',
                            'msg'  => $ret['errmsg'],
                        );
                    }
                }else{
                    //增加会员金币
                    $res = App_Helper_MemberLevel::goldCoinTrans($this->sid, $trade['t_m_id'], $coinRefund);
                    if($res){
                        $this->_recharge_record($trade,$coinRefund);
                    }
                    if($trade['t_es_id'] > 0 && $res){
                        $this->afterEntershopRefund($trade,$refund);
                    }
                }
                break;
            //优惠全免
            case App_Helper_Trade::TRADE_PAY_YHQM :
                //退款无操作
                break;
            //微财猫微信支付
            case App_Helper_Trade::TRADE_PAY_VCMWXZF :
                //发起微信退款
                $new_pay    = new App_Plugin_Vcaimao_PayClient($this->sid);
                $ret = $new_pay->tradeRefund($trade['t_pay_trade_no'],round($refund['tr_money']*100),$refund['tr_reason']);
                if(!$ret || $ret['errcode']){
                    return array(
                        'code' => 'fail',
                        'msg'  => '未找到结算,或已退款结算',
                    );
                }
                if($trade['t_es_id'] > 0){
                    $this->afterEntershopRefund($trade,$refund);
                }
                break;
            // 支付宝退款操作
            // zhangzc
            // 2019-08-01
            case App_Helper_Trade::TRADE_PAY_ZFBZFDX:
                //发起支付宝退款
                $zfb_pay    = new App_Plugin_Alipaysdk_Client($this->sid);

                // 读取头条小程序-支付宝的配置信息
                $pay_cfg_model=new App_Model_Toutiao_MysqlToutiaoPayStorage($this->sid);
                $pay_cfg=$pay_cfg_model->findRowPay();
                if(!$pay_cfg){
                    return array(
                        'code' => 'fail',
                        'msg'  => '获取支付配置信息失败',
                    );
                }
                $pay_config_param=[
                    'app_id'                    =>$pay_cfg['atp_alipay_appid'],
                    'sign_type'                 =>'RSA2',
                    'merchant_private_key'      =>$pay_cfg['atp_alipay_private_key'],
                    'alipay_public_key'         =>$pay_cfg['atp_alipay_public_key'],
                    'charset'                   =>'UTF-8',
                    'format'                    =>'json',
                    'gatewayUrl'                =>'https://openapi.alipay.com/gateway.do',
                    'MaxQueryRetry'             =>'5',
                    'QueryDuration'             =>'3',
                ];

                $ret = $zfb_pay->refundOrder($trade['t_pay_trade_no'], $refund['tr_wid'], $refund['tr_money'],$pay_config_param);

                $refund_state   = $ret['code']=='10000' ? true : false;
                if (!$refund_state) {
                    return array(
                        'code' => 'fail',
                        'msg'  => '退款处理失败，请联系平台管理员。失败原因：'.$ret['errmsg'],
                    );
                }
                break;
        }
        //设置订单为退款订单
        $trupdata   = array(
            't_feedback'    => self::FEEDBACK_OVER,//维权结束
            't_fd_result'   => self::FEEDBACK_RESULT_AGREE,// 同意退款
            't_fd_status'   => self::FEEDBACK_REFUND_SOLVE,  // 维权解决
            't_refund_time' => time()
        );

        $torupdata   = array(
            'to_feedback'    => self::FEEDBACK_OVER,//维权结束
            'to_fd_result'   => self::FEEDBACK_RESULT_AGREE,// 同意退款
            'to_fd_status'   => self::FEEDBACK_REFUND_SOLVE,  // 维权解决
            'to_refund_time' => time()
        );


        $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);


        $can_update_trade=TRUE;

        if(!$toid){
            $trupdata['t_status'] = self::TRADE_REFUND;
            $order_model->updateOrderListByTid($torupdata, $trade['t_id']);
        }else{
            $order_model->updateById($torupdata, $toid);
            //判断是否还有未退款的商品
            $noRefundOrder = $order_model->getNoRefundOrderByTid($trade['t_id']);
            if(!$noRefundOrder){
                //所有的商品都已退款
                $trupdata['t_status'] = self::TRADE_REFUND;
            }


            //单品退款的话判断trade_order里面还有没有正在退款中的订单(存在未退款的订单则不更新trade表中的状态) 
            //好多次查询，但是太乱并不想改动
            //zhangzc
            //2019-08-28
            $refund_order_nums=$order_model->getCount([
                ['name'=>'to_t_id','oper'=>'=','value'=>$trade['t_id']],
                ['name'=>'to_fd_status','oper'=>'=','value'=>1]
            ]);
            if($refund_order_nums)
                $can_update_trade=FALSE;

        }


        if($manager['m_id'] && $manager['m_nickname']){
            $trupdata['t_manager_id'] = $manager['m_id'];
            $trupdata['t_manager_name'] = $manager['m_nickname'];
        }
        // 单品退款是否更新trade表里面的字段
        // zhangzc
        // 2019-08-28
        if($can_update_trade)
            $trade_model->updateById($trupdata, $trade['t_id']);

        //成功退款，标注退款成功
        $tr_set = array(
            'tr_seller_note' => $note,
            'tr_status'      => self::FEEDBACK_REFUND_HANDLE, //  商家已处理
            'tr_finish_time' => time(),
        );
        $refund_model->updateById($tr_set,$refund['tr_id']);

        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $member = $member_model->getRowById($trade['t_m_id']);
        $appletType = plum_parse_config('member_source_menu_type')[$member['m_source']];
        $appletType = $appletType ? $appletType : 0;
        plum_open_backend('templmsg', 'refundTempl', array('sid' => $this->shop['s_id'], 'tid' => $trade['t_tid'],'toid'=>$toid,'appletType' => $appletType));


        //跑腿配送订单，将订单取消
        if($trade['t_express_method'] == 7){
            $this->_cancel_legwork_trade($trade);
        }

        // 在标记完订单状态后在执行后续的操作
        // zhangzc
        // 2019-11-13
        $this->dealRefundTrade($trade);//退款成功后的处理


        return array(
            'money' => $refund['tr_money'],
            'code' => 'success',
            'msg'  => '退款处理成功',
        );
    }

    private function _recharge_record($trade,$money){
        $record_storage = new App_Model_Member_MysqlRechargeStorage($this->sid);
        //消费记录保存
        $indata = array(
            'rr_tid'        => $trade['t_tid'],
            'rr_s_id'       => $this->sid,
            'rr_m_id'       => $trade['t_m_id'],
            'rr_amount'     => 0,
            'rr_gold_coin'  => $money,
            'rr_status'     => 1,//标识金币增加
            'rr_pay_type'   => 15,//订单退款
            'rr_remark'     => '订单退款',
            'rr_create_time'=> time(),
        );
        $record_storage->insertValue($indata);
    }


    private function _cancel_legwork_trade($trade){
        //将跑腿订单取消
        $legwork_trade_model = new App_Model_Legwork_MysqlLegworkTradeStorage(0);
        $legwork_trade = $legwork_trade_model->findUpdateTradeByOtherTid($trade['t_tid'],$trade['t_s_id']);
        if($legwork_trade['alt_status'] != App_Helper_Legwork::TRADE_CLOSED){
            $timeNow = time();
            $overtime = 0;
            if($legwork_trade['alt_overtime_time'] > 0 && $timeNow > $legwork_trade['alt_overtime_time']){
                $overtime = 1;
            }
            $set = [
                'alt_status' => App_Helper_Legwork::TRADE_CLOSED,
                'alt_cancel_done_time' => $timeNow,
                'alt_cancel_type' => 2,
                'alt_is_overtime' => $overtime
            ];
            //直接修改，不需要再退款
            $legwork_res = $legwork_trade_model->findUpdateTradeByOtherTid($trade['t_tid'],$trade['t_s_id'],$set);
            if($legwork_res && $legwork_trade['alt_rider'] > 0){
                //发通知给骑手
                $jiguang_model = new App_Helper_JiguangPush($legwork_trade['alt_s_id']);
                $jiguang_model->pushNotice($jiguang_model::LEGWORK_TRADE_CANCEL,$legwork_trade,'',true);
            }
        }
    }




    //门店退款后续

    private function afterEntershopRefund($trade,$refund){
        $store_model = new App_Model_Entershop_MysqlEnterShopStorage();
        $store = $store_model->getRowById($trade['t_es_id']);
        $t_id = $trade['t_id'];
        $balance    = floatval($store['es_balance']);//店铺收益余额
        $recharge   = floatval($store['es_recharge']);//店铺通天币
        $settled_model  = new App_Model_Trade_MysqlTradeSettledStorage($this->sid);
        $trade_redis    = new App_Model_Trade_RedisTradeStorage($this->sid);
        $settled    = $settled_model->findSettledByTid($trade['t_tid']);
        //未找到结算,或已退款结算
        if (!$settled || $settled['ts_status'] == self::TRADE_SETTLED_REFUND) {
            return array(
                'code' => 'fail',
                'msg'  => '未找到结算,或已退款结算',
            );
        }
        //已成功结算的交易,退款时,判断店铺余额是否充足
        if ($settled['ts_status'] == self::TRADE_SETTLED_SUCCESS) {
            //需要判断店铺余额
            if ($balance < floatval($refund['tr_money']) && $recharge < floatval($refund['tr_money'])) {
                return array(
                    'code' => 'fail',
                    'msg'  => '店铺余额不足以支撑退款金额',
                );
            }
        }
        //清除订单的自动结算
        $trade_redis->delTradeSettledTtl($t_id);
        //已成功结算的交易,退款
        if ($settled['ts_status'] == self::TRADE_SETTLED_SUCCESS) {
            $title      = "订单{$trade['t_tid']}退款, 扣除余额";
            $refundMoney = floatval($refund['tr_money']);
            //获得门店抽成百分比
            $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
            $appcfg = $appletPay_Model->findRowPay();
            if($store['es_maid_proportion'] && $store['es_maid_proportion']>0){
                $maid = $store['es_maid_proportion']/100;
            }elseif($appcfg['ap_shop_percentage'] && $appcfg['ap_shop_percentage']>0){
                $maid = $appcfg['ap_shop_percentage']/100;
            }else{
                $maid      = plum_parse_config('wxpay_point', 'weixin');
            }
            $less = ceil($refundMoney*$maid*100);
            $store_model->incrementShopBalance($store['es_id'], -($refundMoney-($less/100)));
            //记录支出流水
            $inout_model    = new App_Model_Shop_MysqlShopInoutStorage($this->sid);
            $outdata    = array(
                'si_s_id'   => $this->sid,
                'si_es_id'  => $store['es_id'],
                'si_name'   => $title,
                'si_amount' => $refund['tr_money'],
                'si_balance'=> $balance-($refundMoney - ($less/100)),
                'si_type'   => 2,
                'si_create_time'    => time(),
            );
            $inout_model->insertValue($outdata);
        }
        //修改待结算交易为已退款状态
        $updata = array(
            'ts_status'     => self::TRADE_SETTLED_REFUND,
            'ts_update_time'=> time(),
        );
        $settled_model->findUpdateSettled($settled['ts_id'], $updata);

    }

    /*
     * 处理社区团购订单
     */
    private function _deal_sequence_order($trade){
        $extraData = json_decode($trade['t_extra_data'],true);
        $groupId = intval($extraData['groupId']);
        $isLeader = intval($extraData['isLeader']);
        $leaderId = intval($extraData['leaderId']);
        $activityId = intval($extraData['activityId']);
        $mid = $trade['t_m_id'];


        $leader_model = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->sid);
        $group_model = new App_Model_Sequence_MysqlSequenceGroupStorage($this->sid);
        $join_model = new App_Model_Sequence_MysqlSequenceGroupJoinStorage($this->sid);
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $activity_model = new App_Model_Sequence_MysqlSequenceActivityStorage($this->sid);

        $leader = $leader_model->getRowById($leaderId);
        $tplType = 'se_join_activity';
        if(!$groupId){
            //创建活动群组
            $groupData = array(
                'asg_s_id' => $this->sid,
                'asg_a_id' => $activityId,
                'asg_c_id' => $trade['t_home_id'],
                'asg_leader' => $leaderId,
                'asg_leader_mid' => $leader['asl_m_id'],
                'asg_create_time' => time()
            );
            $groupId = $group_model->insertValue($groupData);
            $tplType = 'se_create_activity';
        }
        //保存参加活动记录
        $total = $join_model->getJoinCountByGroup($groupId);
        $joinData = array(
            'asgj_s_id' => $this->sid,
            'asgj_a_id' => $activityId,
            'asgj_m_id' => $mid,
            'asgj_asg_id' => $groupId,
            'asgj_t_id' => $trade['t_id'],
            'asgj_isleader' => $isLeader,
            'asgj_total' => intval($total) + 1,
            'asgj_create_time' => time()
        );
        $res = $join_model->insertValue($joinData);
        if($res){
            //活动群组更新参加人数
            $set = array(
                'asg_join' => intval($total) + 1
            );
            $group_model->updateById($set,$groupId);
            //活动更新参加人数
            $activity_model->incrementField('asa_join_num',$activityId,1);
        }
        //将群组和订单信息更新至订单
        $updata = array(
            't_se_group' => $groupId,
            't_se_leader' => $leaderId
        );
        $trade_model->updateById($updata,$trade['t_id']);

        $updata_order = array(
            'to_se_group' => $groupId,
            'to_se_leader' => $leaderId
        );
        $to_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
        $where_order[] = array('name' => 'to_s_id', 'oper' => '=', 'value' => $this->sid);
        $where_order[] = array('name' => 'to_t_id', 'oper' => '=', 'value' => $trade['t_id']);
        $to_model->updateValue($updata_order,$where_order);
        //$this->adjustTradeGoodsStock($trade['t_id']);
        $this->modifyGoodsSold($trade['t_id']);
        //删除该活动该用户的购物车
        $where_cart[] = array('name' => 'sc_s_id', 'oper' => '=', 'value' => $this->sid);
        $where_cart[] = array('name' => 'sc_se_aid', 'oper' => '=', 'value' => $activityId);
        $where_cart[] = array('name' => 'sc_m_id', 'oper' => '=', 'value' => $mid);
        $cart_model = new App_Model_Shop_MysqlShopCartStorage($this->sid);
        $cart_model->deleteValue($where_cart);
        //设置自动完成
        if($this->shop['s_auto_finish'] == 1){
            $overtime   = plum_parse_config('trade_overtime');
            $trade_redis= new App_Model_Trade_RedisTradeStorage($this->sid);
            $currTime =$this->shop['s_finish_trade'] && $this->shop['s_finish_trade'] > 0 ? $this->shop['s_finish_trade']*86400 : $overtime['finish'];
            //$currTime =120;
            $trade_redis->setTradeFinishTtl($trade['t_id'], $currTime);
        }

        //plum_open_backend('index', 'sendSequenceTempl', array('sid' => $this->sid, 'tid' => $trade['t_tid'], 'type' => $tplType));

        return $groupId;
    }

    private function _deal_sequence_order_new($trade){
        $extraData = json_decode($trade['t_extra_data'],true);
        $groupId = intval($extraData['groupId']);
        $leaderId = intval($extraData['leaderId']);
        $managerId = intval($extraData['managerId']);

        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $activity_model = new App_Model_Sequence_MysqlSequenceActivityStorage($this->sid);
        $leader_model = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->sid);
        $leader = $leader_model->getRowById($leaderId);
        //保存参加活动记录

        //将群组和订单信息更新至订单
        $updata = array(
            't_se_group' => $groupId,
            't_se_leader' => $leaderId,
            't_se_manager' => $managerId
        );
        $trade_model->updateById($updata,$trade['t_id']);

        $updata_order = array(
            'to_se_group' => $groupId,
            'to_se_leader' => $leaderId,
            'to_se_manager' => $managerId
        );
        $to_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
        $where_order[] = array('name' => 'to_s_id', 'oper' => '=', 'value' => $this->sid);
        $where_order[] = array('name' => 'to_t_id', 'oper' => '=', 'value' => $trade['t_id']);
        $to_model->updateValue($updata_order,$where_order);

        $join_insert = [];
        $join_gid = [];
        $aids = [];
        //获得订单所有商品id
        $order_list = $to_model->fetchOrderListByTid($trade['t_id'], ['to_g_id']);
        foreach ($order_list as $item) {
            if (!in_array($item['to_g_id'],$join_gid)) {
                $join_gid[] = $item['to_g_id'];
            }
        }
        //获得所有商品关联的活动
        if (!empty($join_gid)) {
            $asag_model = new App_Model_Sequence_MysqlSequenceActivityGoodsStorage($this->sid);
            $join_model = new App_Model_Sequence_MysqlSequenceActivityJoinStorage($this->sid);
            $where_asag[] = ['name' => 'asag_s_id', 'oper' => '=', 'value' => $this->sid];
            $where_asag[] = ['name' => 'asag_g_id', 'oper' => 'in', 'value' => $join_gid];
            $asag_list = $asag_model->getList($where_asag, 0, 0);
            if ($asag_list) {
                foreach ($asag_list as $val) {
                    if (!in_array($val['asag_a_id'],$aids)) {
                        $aids[] = $val['asag_a_id'];
                        $join_insert[] = " (NULL, '{$this->sid}','{$val['asag_a_id']}','{$trade['t_m_id']}','{$val['asag_g_id']}','" . time() . "') ";
                    }
                }
            }
            if (!empty($aids)) {
                //增加活动参与人数
                $activity_model->incrementFieldMulti('asa_join_num',$aids,1);
                //添加活动参与记录
                $join_model->insertBatch($join_insert);
            }
        }

        $this->modifyGoodsSold($trade['t_id']);
        //删除该活动该用户的购物车
       // $where_cart[] = array('name' => 'sc_s_id', 'oper' => '=', 'value' => $this->sid);
       // $where_cart[] = array('name' => 'sc_se_aid', 'oper' => '=', 'value' => $activityId);
       // $where_cart[] = array('name' => 'sc_m_id', 'oper' => '=', 'value' => $mid);
       // $cart_model = new App_Model_Shop_MysqlShopCartStorage($this->sid);
       // $cart_model->deleteValue($where_cart);
        //设置自动完成
        if($this->shop['s_auto_finish'] == 1){
            $overtime   = plum_parse_config('trade_overtime');
            $trade_redis= new App_Model_Trade_RedisTradeStorage($this->sid);
            $currTime =$this->shop['s_finish_trade'] && $this->shop['s_finish_trade'] > 0 ? $this->shop['s_finish_trade']*86400 : $overtime['finish'];


            $trade_redis->setTradeFinishTtl($trade['t_id'], $currTime);
        }

        if($this->shop['s_isopen_prize'] && $this->shop['s_send_pnum'] > 0){
            $lottety_model  = new App_Model_Meeting_MysqlMeetingLotteryListStorage($this->sid);
            $lotteryList    = $lottety_model->getLotteryRow();
            $number_model   = new App_Model_Meeting_MysqlMeetingLotteryNumberStorage($this->sid);
            //判断用户的是否参加过抽奖活动
            $numberList     = $number_model->checkMemNum($trade['t_m_id'],$lotteryList['amll_id']);
            if($numberList){   //说明参加过，增加抽奖次数
                $set   = array('amln_num'=>$numberList['amln_num']+$this->shop['s_send_pnum']);
                $number_model->checkMemNum($trade['t_m_id'],$lotteryList['amll_id'],$set);
            }else{
                //增加抽奖次数，插入一条新的新的记录
                $number_model->insertMemNum($trade['t_m_id'],$lotteryList['amll_id'],$lotteryList['amll_frequency'],$this->shop['s_send_pnum']);
            }
        }
//        if($this->sid == 9373){
//            $this->_deal_manager_deduct_record($trade,$leader);
//        }


        if($trade['t_applet_type'] == self::TRADE_APPLET_SECKILL){
            $this->_deal_seckill_order($trade);
        }
        if($trade['t_applet_type'] == self::TRADE_APPLET_BARGAIN){

            $this->_deal_bargain_order($trade);
        }

        $this->_deal_sequence_deduct_nosettled($trade['t_tid']);

//        plum_open_backend('index', 'sendSequenceTempl', array('sid' => $this->sid, 'tid' => $trade['t_tid'], 'type' => $tplType));

        return $groupId;
    }

    /*
     * 保存待结算收益记录
     */
    private function _deal_sequence_deduct_nosettled($tid){
        //将修改过的订单重新查出
        $trade_model        = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade              = $trade_model->findUpdateTradeByTid($tid);
        $leaderId           = $trade['t_se_leader'];
        $groupId            = $trade['t_se_group'];
        $insert = [];
        // 团长信息不存在直接返回
        if(empty($leaderId))
            return;
        
        $leader_model       = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->sid);
        $leader             = $leader_model->getRowById($leaderId);
        // 团长信息不存在直接返回
        if(empty($leader))
            return;

        $money              = 0;

        // 团长默认分佣的比例
        $percent            = intval($leader['asl_percent']);
        if($trade['t_se_send_time'] > 0){
            $goods_deduct           = [];
            $leader_deduct          = 0;
            $goods_total_money      = 0;
            // 获取子订单中的金额以及商品的佣金的比例
            $order_model    = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
            $orderList      = $order_model->getSequenceGoodsDeductListByTid($trade['t_id']);
            foreach ($orderList as $order){
                //子订单中如果有「忽略分佣字段」不进行分佣处理，
                //已退款的商品（单品退款的不进行分佣）
                if($order['to_se_ignore_deduct'] == 1 || $order['to_fd_status'] == 3){
                    $goods_total_money += $order['to_total'];
                }else{
                    if($order['asgd_id'] > 0 && is_numeric($order['asgd_1f_ratio'])){
                        if($order['asgd_1f_ratio'] > 0){
                            $goods_percent          = floatval($order['asgd_1f_ratio'])/100;

                            $goods_deduct[$order['to_id']]  = round(($order['to_total'] * $goods_percent),2);
                        }else{
                            $goods_deduct[$order['to_id']]  = 0;
                        }
                        $goods_total_money         += $order['to_total'];
                    }else{
                        $goods_deduct[$order['to_id']]      = round(($order['to_total'] * ($percent / 100)),2);
                    }
                }
            }

            // $remainGoodsFee = $trade['t_goods_fee'] - $goods_money;
            // $percent = intval($leader['asl_percent']);
            // if($remainGoodsFee > 0){
            //     $leader_deduct += round(($remainGoodsFee * ($percent/100)),2);
            // }

            // $money = $goods_deduct + $leader_deduct;
            $money = array_sum($goods_deduct);
        }else{
            //老版本 根据团长分佣比例计算佣金
            $money = round(($trade['t_payment'] * ($percent/100)),2);
        }
        // 没有佣金不执行下面的步骤
        if(empty($money))
            return;

        $seqcfg_model               = new App_Model_Sequence_MysqlSequenceCfgStorage($this->sid);
        $seqcfg                     = $seqcfg_model->findUpdateBySid();
        if($seqcfg && $seqcfg['asc_leader_recmd_reward']==1 && $leader['asl_parent_id']){
            $leader_recmd_reward_per= 0;  //推荐佣金的百分比
            $reward_money           = 0;  //推荐奖励的佣金
            $leader_recmd_reward_per= $seqcfg['asc_leader_recmd_reward_percent'];
            $reward_money           = $money*($leader_recmd_reward_per)/100;

            $money                 -= ($reward_money<0.01?0:$reward_money);  //重新计算团长的分佣-佣金数量（会减少团长的佣金）若金额小于0.01就直接进行抹除
            $money                  = substr($money,0,stripos($money,'.')+3); //转换一下保存两位小数

            $leader_parent          = $leader['asl_parent_id']; //团长推荐人
            if($leader_parent) {
                // 获取推荐团长的用户id
                $parent_row         = $leader_model->getRowById($leader_parent);
                if($reward_money >= 0.01){
                    $parent_row_mid = intval($parent_row['asl_m_id']);
                    $reward_money   = $reward_money * 100;
                    $insert[]       = " (NULL, '{$trade['t_s_id']}', '{$parent_row_mid}', '{$leader_parent}', '{$reward_money}', '{$tid}','0','2', '".time()."') ";
                }
            }
        }
        $money                      = $money * 100;
        $insert[]                   = " (NULL, '{$trade['t_s_id']}', '{$leader['asl_m_id']}', '{$leaderId}', '{$money}', '{$tid}','0','1', '".time()."') ";


        if(!empty($insert)){
            $deduct_model           = new App_Model_Sequence_MysqlSequenceDeductNosettledStorage($this->sid);
            $deduct_model->insertBatch($insert);
        }

        // 先写一份的记录记录下来对应的分佣比例（此处的值不作数，订单完成以后）
        // zhangzc
        // 2019-11-18
        if($trade['t_se_send_time'] > 0){
            $temp_money                 = array_sum($goods_deduct);
            if(empty($order_model))
                $order_model            = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);

            foreach ($goods_deduct as $gkey => $gval) {
                // 计算出来最终的money 在各个商品中占得比例 然后分钱
                // 因最原始的money被减去了团长推荐与自提点所以 需要按照对应的比例重新计算 
                $order_deduct_money     = round($money * ($gval / $temp_money),2);
                $set = [
                    'to_leader_deduct'  => $order_deduct_money,
                ];
                $order_model->updateById($set,$gkey);

            }
        }
    }


    /*
     * 记录合伙人分佣
     */
    private function _deal_manager_deduct_record($trade,$leader){
        //查找团长关联的上一级合伙人
        $aslm_model = new App_Model_Sequence_MysqlSequenceLeaderManagerStorage($this->sid);
        $row = $aslm_model->getRowByleaderManager($leader['asl_id']);
        if($row){
            //递归保存佣金
            $manager_model = new App_Model_Entershop_MysqlManagerStorage();
            $child_row = $manager_model->getRowById($row['aslm_manager']);
            $this->_save_manager_deduct_record($child_row,$trade);
        }
    }

    /*
     * 递归保存佣金
     */
    private function _save_manager_deduct_record($row,$trade){
//        Libs_Log_Logger::outputLog('开始执行递归记录分佣');
        $manager_model = new App_Model_Entershop_MysqlManagerStorage();
        //记录佣金
        if($row['esm_id'] && $row['esm_percent'] > 0){
//            Libs_Log_Logger::outputLog('有分佣比例');
            $deduct_model = new App_Model_Entershop_MysqlManagerDeductStorage($this->sid);
            $goodsFee = floatval($trade['t_goods_fee']);
            $money = round($goodsFee * (floatval($row['esm_percent'])/100),2);
            if($money > 0){
//                Libs_Log_Logger::outputLog('有钱');
                $insert = [
                    'emd_s_id' => $this->sid,
                    'emd_manager' => $row['esm_id'],
                    'emd_money' => $money,
                    'emd_tid' => $trade['t_tid'],
                    'emd_status' => 1,//待结算
                    'emd_create_time' => time()
                ];
                $res = $deduct_model->insertValue($insert);
//                if($res){
//                    //增加可提现金额
//                    $manager_model->incrementManagerField($row['esm_id'],$money,'esm_deduct_ktx');
//                }
            }
        }
        if($row['esm_fid']){
            $parent_row = $manager_model->getRowById($row['esm_fid']);
            $this->_save_manager_deduct_record($parent_row,$trade);
        }
    }

    /*
     * 替换社区团购模板
     */
    public function replaceSequenceTpl($replace, $tpl) {
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($replace as $key=>$val){
            $replace[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval  = array(
            $replace['leaderName'],$replace['leaderMobile'],$replace['community'],$replace['tid'],$replace['createTime'],$replace['finishTime'],$replace['title'],$replace['totalFee'],$replace['postFee']
        );
        $tplreg   = $cfg[29];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 替换房源推送模板
     */
    public function resourcesInforTpl($infor, $tpl ){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($infor as $key=>$val){
            $infor[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval  = array(
            $infor['title'], $infor['area'],$infor['price'], $infor['housetype'],$infor['orientation'],$infor['community'],$infor['saletype']
        );
        $tplreg   = $cfg[32];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 替换房源推送模板
     */
    public function replaceChatNoticeTpl($infor, $tpl ){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($infor as $key=>$val){
            $infor[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval  = array(
            $infor['member'], $infor['content'],$infor['time']
        );
        $tplreg   = $cfg[33];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }


    //蜂鸟配送推单
    public function dealEleDelivery($tid){
        /*Libs_Log_Logger::outputLog($tid);
        $trade_model= new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade      = $trade_model->getRowById($tid);

        if(!$trade || ($trade['t_status']!=3 && $trade['t_status']!=10)){
            return array(
                'ec' => 400,
                'msg' => '订单状态不正确'
            );
        }

        //计算费用
        $ele_cfg_model = new App_Model_Plugin_MysqlEleCfgStorage($this->sid);
        $eleCfg = $ele_cfg_model->fetchUpdateCfg(null);
        $shopEleCfg = $ele_cfg_model->fetchUpdateCfg(null, $trade['t_es_id']);
        if($eleCfg['ec_balance']<$trade['t_post_fee']){
            //余额不够
            return array(
                'ec' => 400,
                'msg' => '余额不足'
            );
        }

        //获取店铺信息
        $ele    = new App_Plugin_Food_AnubisEle();
        $storeRet = $ele->queryChainStore($trade['t_ele_store_id']);
        if($storeRet && $storeRet['errcode'] == 0){
            $store = $storeRet['result'][0];
        }
        if($store['status'] != 2){
            //店铺状态不正常
            return array(
                'ec' => 400,
                'msg' => '店铺尚未审核通过'
            );
        }
        //获取收货人信息
        $addr_storage   = new App_Model_Member_MysqlAddressStorage($this->sid);
        $address   = $addr_storage->getRowById($trade['t_addr_id']);

        $ele    = new App_Plugin_Food_AnubisEle();
        $tid    = $trade['t_ele_tid']?$trade['t_ele_tid']:$trade['t_tid'];
        $notify_url = 'https://www.tiandiantong.com/wxapp/receive/anubis';
        $tradeWeight = $trade['t_total_weight'];
        if(strstr($tradeWeight, 'Kg')){
            $tradeWeight = floatval($tradeWeight);
        }else{
            $tradeWeight = floatval($tradeWeight) / 1000;
        }

        $other  = array(
            'order_weight'  => $tradeWeight?$tradeWeight:1
        );

        $order  = array(
            'total'     => $trade['t_total_fee'], 'actual'    => $trade['t_payment'], 'hadpay'    => 1, 'agent'     => 0, 'count'     => $trade['t_num'],
        );
        if($trade['t_meal_send_time'] && $trade['t_meal_send_time']!='立即送达'){
            $order['receiveTime'] = strtotime($trade['t_meal_send_time']) * 1000; //毫秒
        }
        $store  = array(
            'chain_store_code' => $store['chain_store_code'], 'name' => $store['chain_store_name'], 'address' => $store['address'], 'phone' => $store['contact_phone'], 'map' => $ele::MAP_SOURCE_GAODE,
            'lng' => $store['longitude'], 'lat' => $store['latitude'],
        );
        $receiver   = array(
            'name' => $address['ma_name'], 'address' => $address['ma_province'].$address['ma_city'].$address['ma_zone'].$address['ma_detail'], 'phone' => $address['ma_phone'], 'map' => $ele::MAP_SOURCE_GAODE,
            'lng' => $address['ma_lng'], 'lat' => $address['ma_lat'],
        );

        $order_model    = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
        $orderList = $order_model->fetchOrderListByTid($trade['t_id']);
        $item = array();
        foreach ($orderList as $val){
            $item[] = array(
                //"item_id" => '123',
                "item_name" => $val['to_title'],
                "item_quantity" => $val['to_num'],
                "item_price" => $val['to_price'] * $val['to_num'],
                "item_actual_price" => $val['to_total'],
                //"item_size" => 2,
                //"item_remark" => "香蕉，轻放",
                "is_need_package" => 0,
                "is_agent_purchase" => 0,
                //"agent_purchase_price" => 10.00
            );
        }
        $ret = $ele->sendServiceOrder($tid, $store['chain_store_code'],$notify_url, $order, $store, $receiver, $item, $other);
        if($ret['errcode'] == 0){
            //推单成功
            //在记录表中插入一条记录
            $record_model = new App_Model_Plugin_MysqlEleRecordStorage($trade['t_s_id']);
            $record = $record_model->findRowByTid($trade['t_tid']);
            $indata = array(
                'er_s_id' => $trade['t_s_id'],
                'er_es_id' => $trade['t_es_id'],
                'er_tid'  => $trade['t_tid'],
                'er_ele_tid' => $trade['t_ele_tid'],
                'er_money' => $trade['t_post_fee'],
                'er_stauts' => 0, //未接单
                'er_update_time' => time()
            );
            if($record){
                $record_model->updateById($indata, $record['er_id']);
            }else{
                $record_model->insertValue($indata);
            }
            //将订单设置为已发货
            $set = array(
                't_need_express'    => 1,
                't_status'          => 4,
            );
            $trade_model->findUpdateTradeByTid($trade['t_tid'],$set);
            //扣除账户余额
            $ele_cfg_model->incrementMemberBalance(-$trade['t_post_fee']);

            //推单成功推送通知(极光推送)
            $notice_model = new App_Helper_JiguangPush($this->sid);
            $notice_model->pushNotice($notice_model::ELE_SEND_SERVICE_ORDER,$trade['t_tid']);
            return array(
                'ec' => 200,
                'msg' => '推单成功'
            );
        }
        return array(
            'ec' => 400,
            'msg' => '推单失败'
        );*/
    }


    //商品加入购物单
    public function dealAddShopping($mid, $gid, $gfid, $esId){
        $mall_widget = new App_Plugin_Weixin_MallWidget($this->sid);
        $extra_model = new App_Model_Member_MysqlMemberExtraStorage($this->sid);
        $extra = $extra_model->findUpdateExtraByMid($mid);
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member = $member_storage->getRowById($mid);
        //判断用户是否为第一次添加购物单
        if($extra['ame_weixin_cart']){
            $productList[] = $this->_format_goods_data($gid, $gfid, $esId);
            $ret = $mall_widget->importProduct($member['m_openid'], $productList);
        }else{
            //第一次导入设置购物车源路径
            //$ret = $mall_widget->setCartPath("pages/mycart/mycart");
            //如果是第一次导入，导入用户购物车中的所有商品
            $where      = array();
            $where[]    = array('name' => 'sc_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[]    = array('name' => 'sc_m_id', 'oper' => '=', 'value' => $mid);
            $index      = 0;
            $count      = 10;
            $cart_storage = new App_Model_Shop_MysqlShopCartStorage($this->sid);
            $sort         = array('sc_add_time' => 'DESC');
            $productList = array();
            do {
                $list   = $cart_storage->getList($where, $index, $count, $sort);
                foreach ($list as $val){
                    $product = $this->_format_goods_data($val['sc_g_id'], $val['sc_gf_id'], $val['sc_es_id']);
                    if($product){
                        $productList[] = $product;
                    }
                }
                $index += 10;
                $ret = $mall_widget->importProduct($member['m_openid'], $productList);
                if(!$ret['errcode']){
                    $extra = $extra_model->findUpdateExtraByMid($mid);
                    if($extra){
                        $set = array('ame_weixin_cart' => 1);
                        $extra_model->findUpdateExtraByMid($mid, $set);
                    }else{
                        $extraUpdata['ame_s_id'] = $this->sid;
                        $extraUpdata['ame_m_id'] = $mid;
                        $extraUpdata['ame_weixin_cart'] = 1;
                        $extra_model->insertValue($extraUpdata);
                    }
                }
            }while(count($list) == $count);
        }
    }

    /**
     * 获取商品信息
     */
    private function _format_goods_data($gid, $gfid, $esId){
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $goods = $goods_model->getRowById($gid);
        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->sid);
        $appletCfg        = $applet_cfg->findShopCfg();
        if($goods){
            //已经添加过的，直接将商品添加到购物单
            $slide[] = plum_deal_image_url($goods['g_cover']);
            $slide  = $this->_goods_slide($goods['g_id']);
            $category_model = new App_Model_Shop_MysqlKindStorage($this->sid);
            $cate1 = $category_model->getRowById($goods['g_kind1']);
            $cate2 = $category_model->getRowById($goods['g_kind2']);
            $wxxcx_client = new App_Plugin_Weixin_WxxcxClient($this->sid);
            if($esId){
                if($appletCfg['ac_type'] == 6){
                    $path = $wxxcx_client::CITY_SHOP_GOODS_DETAIL.'?id='.$goods['g_id'];
                }else{
                    $path = $wxxcx_client::SHOP_GOODS_DETAILS_PATH.'?id='.$goods['g_id'];
                }
            }else{
                $path = $wxxcx_client::GOODS_DETAIL_CODE_PATH.'?id='.$goods['g_id'];
            }
            $format = false;
            if($gfid){
                $format_model = new App_Model_Goods_MysqlFormatStorage($this->sid);
                $format       = $format_model->getRowById($gfid);
            }

            $skuAttrList = array();
            if($gfid && $goods['g_format_type']){
                $spec = json_decode($goods['g_format_type'], true);
                foreach($spec as $key => $val){
                    $skuAttrList[] = array(
                        "name"  => $val['name'],
                        "value" => $format['gf_name'.($key == 0?'':($key+1))]
                    );
                }
            }

            $product = array(
                "item_code"      => $goods['g_id'], //商品id
                "title"          => $goods['g_name'],   //商品名称
                "desc"           => $goods['g_brief'],   //商品简介
                "category_list"  => [$cate1['sk_name']?$cate1['sk_name']:'商品分类', $cate2['sk_name']?$cate2['sk_name']:'商品分类'],  //商品类目
                "image_list"     => $slide,    //商品图片
                "src_wxapp_path" => $path, // 商品详情页链接
                "sku_info" => array( //规格信息
                    "sku_id"         => $format?$format['gf_id']:$goods['g_id'],   //规格id, 若无规格则取商品id
                    'price'          => $format?$format['gf_price']*100:$goods['g_price']*100,   //商品价格，若无规格，取商品价格
                    "original_price" => $format?($format['gf_ori_price']?$format['gf_ori_price']*100:$goods['g_ori_price']*100):$goods['g_ori_price']*100,   //商品原价，若无规格，取商品原价
                    "status"         =>  1,               //商品状态  1在售  2停售
                    "sku_attr_list" => $skuAttrList,  //规格属性，取规格名称
                )
            );
            return $product;
        }
        return false;
    }

    /**
     * 获取商品的幻灯
     */
    private function _goods_slide($gid){
        //获取商品幻灯
        $slide_model = new App_Model_Goods_MysqlGoodsSlideStorage($this->sid);
        $slide       = $slide_model->getListByGidSid($gid, $this->sid);
        $data = array();
        if($slide){
            foreach ($slide as $val){
                $data[] = plum_deal_image_url($val['gs_path']);
            }
        }
        return $data;
    }

    //将商品从购物单中删除
    public function dealDelShopping($mid, $shopping){
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member = $member_storage->getRowById($mid);
        $productList = array();
        foreach ($shopping as $value){
            $productList[] = array(
                'item_code' => $value['gid'],
                'sku_id' => $value['gfid']?$value['gfid']:$value['gid'],
            );
        }
        $mall_widget = new App_Plugin_Weixin_MallWidget($this->sid);
        $ret = $mall_widget->deleteProduct($member['m_openid'], $productList);
    }

    //加入已购清单
    private function _deal_add_order($trade){
        $mall_widget = new App_Plugin_Weixin_MallWidget($this->sid);
        $this->shop['s_import_order'] = true;
        //判断该店铺是否为第一次导入
        if($this->shop['s_import_order']){
            //不是第一次导入，只导入当前的订单
            $orderList[] = $this->_format_order_data($trade);
            $ret = $mall_widget->importOrder($orderList);

        }else{
            //第一次导入，导入该店铺近3个月的订单
            $where      = array();
            $where[]    = array('name' => 't_status', 'oper' => 'in', 'value' => [2, 3, 4, 5, 6, 8]);
            $where[]    = array('name' => 't_deleted', 'oper' => '=', 'value' => 0);
            $where[]    = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[]    = array('name' => 't_create_time', 'oper' => '>', 'value' => strtotime('-3 month'));
            $index      = 0;
            $count      = 10;
            $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
            $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
            do {
                $orderList = array();
                $list   = $trade_model->getList($where, $index, $count);
                foreach ($list as $val){
                    $order = $this->_format_order_data($val);
                    if($order){
                        $orderList[] = $order;
                    }
                }
                $index += $count;
                $ret = $mall_widget->importOrder($orderList);


                $set = array('s_import_order' => 1);
                $shop_model->changeShopByUniqid($this->shop['s_unique_id'], $set);
            }while(count($list) == $count);
            //同步购物车路径
            $ret = $mall_widget->setCartPath("pages/mycart/mycart");
        }
    }

    private function _format_order_data($trade){
        $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade          = $trade_model->findUpdateTradeByTid($trade['t_tid']);
        $order_model    = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
        $orderList      = $order_model->getGoodsListByTid($trade['t_id']);
        $category_model = new App_Model_Shop_MysqlKindStorage($this->sid);
        $applet_cfg     = new App_Model_Applet_MysqlCfgStorage($this->sid);
        $appletCfg      = $applet_cfg->findShopCfg();
        $address_model  = new App_Model_Member_MysqlAddressStorage($this->sid);
        $address = $address_model->getRowById($trade['t_addr_id']);

        $wxxcx_client = new App_Plugin_Weixin_WxxcxClient($this->sid);

        $itemList = array();
        foreach ($orderList as $val){
            if($val['to_gf_id']){
                if($appletCfg['ac_type'] == 6){
                    $path = $wxxcx_client::CITY_SHOP_GOODS_DETAIL.'?id='.$val['g_id'];
                }else{
                    $path = $wxxcx_client::SHOP_GOODS_DETAILS_PATH.'?id='.$val['g_id'];
                }
            }else{
                $path = $wxxcx_client::GOODS_DETAIL_CODE_PATH.'?id='.$val['g_id'];
            }

            $skuAttrList = array();
            if($val['to_gf_id'] && $val['g_format_type']){
                $spec = json_decode($val['g_format_type'], true);
                foreach($spec as $key => $value){
                    $skuAttrList[] = array(
                        "attr_name"  => array(
                            'name' => $value['name'],
                        ),
                        "attr_value" => array(
                            'name' => $val['gf_name'.($key == 0?'':($key+1))]
                        )
                    );
                }
            }
            $cate1 = $category_model->getRowById($val['g_kind1']);
            $cate2 = $category_model->getRowById($val['g_kind2']);
            $itemList[] = array(
                "item_code"  => $val['to_g_id'],  //商品id
                "sku_id"     => $val['to_gf_id']?$val['to_gf_id']:$val['to_g_id'],     //规格id
                "amount"     => $val['to_num'],                                   //商品数量
                "total_fee"  => $val['to_total'] * 100,                                //商品总价
                "thumb_url"  => plum_deal_image_url($val['g_cover']),  //商品缩略图url
                "title"      => $val['g_name'],  //商品名称
                "desc"       => $val['g_brief'],     //商品详细描述
                "unit_price" => $val['g_price'] * 100,    //商品单价（实际售价），单位：分
                "original_price"  => $val['g_ori_price'] * 100, //商品原价，单位：分
                "stock_attr_info" => $skuAttrList,  //商品属性
                "category_list"  => [$cate1['sk_name']?$cate1['sk_name']:'商品分类', $cate2['sk_name']?$cate2['sk_name']:'商品分类'],  //商品类目
                "item_detail_page"=> array(   //商品详情页（小程序页面）
                    "path"=> $path
                )
            );
        }

        $expressPackageInfo = array();
        $expressGoodsInfo = array();
        foreach ($itemList as $value){
            $expressGoodsInfo[] = array(
                'item_code' => $value['item_code'],
                'sku_id' => $value['sku_id'],
            );
        }

        if(in_array($trade['t_status'], [4, 5, 6, 8])){  //已发货的订单
            $expressPackageInfo = array(
                "express_company_id"   => $trade['t_company_code']?$trade['t_company_code']:'123',
                "express_company_name" => $trade['t_express_company']?$trade['t_express_company']:'快递公司名称',
                "express_code"         => $trade['t_express_code']?$trade['t_express_code']:'123456789',
                "ship_time"            => $trade['t_express_time']?$trade['t_express_time']:'1546272000',
                "express_page" => array(
                    "path"=> "pages/myorder/myorder"
                ),
                "express_goods_info_list" => $expressGoodsInfo
            );
        }
        $expressInfo = array(
            "name"     => $address['ma_name'],        //收件人姓名
            "phone"    => $address['ma_phone'],     //收件人联系电话
            "address"  => $address['ma_detail'],  //收件人地址
            "price"    => $trade['t_post_fee']*100,       //运费，单位：分
            "province" => $address['ma_province'], // 省份
            "city"     => $address['ma_city'],  //城市
            "district" => $address['ma_zone'], //区
        );

        if($expressPackageInfo){
            $expressInfo['express_package_info_list'] = [$expressPackageInfo];
        }

        $orderStatusMap = array(
            '2' => 3, //待成团
            '3' => 3,
            '4' => 4,
            '6' => 100,
            '8' => 5
        );

        $importOrderList = array(
            "order_id"        => $trade['t_tid'],  //订单id
            "create_time"     => $trade['t_create_time'],  //订单创建时间
            "pay_finish_time" => $trade['t_pay_time']?$trade['t_pay_time']:time(),     //订单支付时间
            "desc"            => $trade['t_note'],         //订单备注
            "fee"             => $trade['t_total_fee'] * 100,        //订单金额
            "trans_id"        => $trade['t_pay_trade_no'],     //微信支付订单id
            "status"          => $orderStatusMap[$trade['t_status']],    //订单状态，3：支付完成 4：已发货 5：已退款 100: 已完成
            "ext_info" => array(
                "product_info"  => array(  //商品信息
                    "item_list" => $itemList
                ),
                "express_info"     => $expressInfo,  // 快递信息
                "promotion_info"   => array(       // 订单优惠信息
                    "discount_fee" => $trade['t_discount_fee'] + $trade['t_promotion_fee'] + $trade['t_new_promotion']
                ),
                "brand_info" => array( //商家信息
                    "phone"  => $this->shop['s_phone'],
                    "contact_detail_page"=> array(
                        "path" => "pages/index/index"
                    )
                ),
                "payment_method" => $trade['t_pay_type'] == 1?1:2, //订单支付方式，0：未知方式 1：微信支付 2：其他支付方式
                "user_open_id" =>$trade['t_buyer_openid'],  // 用户openid
                "order_detail_page" => array(
                    "path" => "pages/orderDetail/orderDetail?orderid=".$trade['t_tid']  //订单详情页
                )
            )
        );

        return $importOrderList;
    }

    //更新购物单信息
    public function updateOrder($tid){
        $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade          = $trade_model->findUpdateTradeByTid($tid);
        $address_model  = new App_Model_Member_MysqlAddressStorage($this->sid);
        $address = $address_model->getRowById($trade['t_addr_id']);
        $order_model    = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
        $orderList      = $order_model->getGoodsListByTid($trade['t_id']);

        $expressPackageInfo = array();
        $expressGoodsInfo = array();
        foreach ($orderList as $val){
            $expressGoodsInfo[] = array(
                'item_code' => $val['to_g_id'],
                'sku_id' => $val['to_gf_id']?$val['to_gf_id']:$val['to_g_id'],
            );
        }
        if(in_array($trade['t_status'], [4, 5, 6, 8])){  //已发货的订单
            $expressPackageInfo = array(
                "express_company_id"   => $trade['t_company_code']?$trade['t_company_code']:'123',
                "express_company_name" => $trade['t_express_company']?$trade['t_express_company']:'快递公司名称',
                "express_code"         => $trade['t_express_code']?$trade['t_express_code']:'123456789',
                "ship_time"            => $trade['t_express_time']?$trade['t_express_time']:'1546272000',
                "express_page" => array(
                    "path"=> "pages/myorder/myorder"
                ),
                "express_goods_info_list" => $expressGoodsInfo
            );
        }
        $expressInfo = array(
            "name"     => $address['ma_name'],        //收件人姓名
            "phone"    => $address['ma_phone'],     //收件人联系电话
            "address"  => $address['ma_detail'],  //收件人地址
            "price"    => $trade['t_post_fee']*100,       //运费，单位：分
            "province" => $address['ma_province'], // 省份
            "city"     => $address['ma_city'],  //城市
            "district" => $address['ma_zone'], //区
        );
        if($expressPackageInfo){
            $expressInfo['express_package_info_list'] = [$expressPackageInfo];
        }
        $orderStatusMap = array(
            '2' => 3, //待成团
            '3' => 3,
            '4' => 4,
            '6' => 100,
            '8' => 5
        );
        $updateOrderList[] = array(
            "order_id"=> $trade['t_tid'],   //订单id
            "trans_id"=> $trade['t_pay_trade_no'],   //微信支付订单ID
            "status"=> $orderStatusMap[$trade['t_status']],  //订单状态，4：已发货 5：已退款 12：已取消 100: 已完成
            "ext_info"=> array(
                "express_info"=> $expressInfo,
                "user_open_id"=> $trade['t_buyer_openid'],
                "order_detail_page"=> array(
                    "path"=> "pages/orderDetail/orderDetail?orderid=".$trade['t_tid']
                )
            )
        );
        $mall_widget = new App_Plugin_Weixin_MallWidget($this->sid);
        $ret = $mall_widget->updateOrder($updateOrderList);
    }

    /**
     * 同步更新购物单内商品信息
     */
    public function updateGoods($gid){
        $mall_widget = new App_Plugin_Weixin_MallWidget($this->sid);
        $keyList[] = array(
            'item_code' => $gid
        );
        $qret = $mall_widget->queryProduct($keyList);
        if($qret['data']['product_list']){
            $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);
            $goods = $goods_model->getRowById($gid);
            $slide[] = plum_deal_image_url($goods['g_cover']);
            $slide  = $this->_goods_slide($goods['g_id']);
            $category_model = new App_Model_Shop_MysqlKindStorage($this->sid);
            $cate1 = $category_model->getRowById($goods['g_kind1']);
            $cate2 = $category_model->getRowById($goods['g_kind2']);
            $wxxcx_client = new App_Plugin_Weixin_WxxcxClient($this->sid);
            $applet_cfg     = new App_Model_Applet_MysqlCfgStorage($this->sid);
            $appletCfg      = $applet_cfg->findShopCfg();
            if($goods['g_es_id']){
                if($appletCfg['ac_type'] == 6){
                    $path = $wxxcx_client::CITY_SHOP_GOODS_DETAIL.'?id='.$goods['g_id'];
                }else{
                    $path = $wxxcx_client::SHOP_GOODS_DETAILS_PATH.'?id='.$goods['g_id'];
                }
            }else{
                $path = $wxxcx_client::GOODS_DETAIL_CODE_PATH.'?id='.$goods['g_id'];
            }

            $format_model = new App_Model_Goods_MysqlFormatStorage($this->sid);
            $formatList       = $format_model->getListByGid($gid);

            $spec = json_decode($goods['g_format_type'], true);
            $skuList = array();
            foreach ($formatList as $value){
                $skuAttrList = array();
                foreach($spec as $key => $val){
                    $skuAttrList[] = array(
                        "name"  => $val['name'],
                        "value" => $value['gf_name'.($key == 0?'':($key+1))]
                    );
                }
                $skuList[] = array(
                    "sku_id" => $value['gf_id'],
                    "price"  => $value['gf_price']*100,
                    "original_price" => $value['gf_ori_price']*100,
                    "status" => $goods['g_is_sale'] == 1?1:2,
                    "sku_attr_list" => $skuAttrList,
                );
            }

            $productList[] = array(
                "item_code"      => $goods['g_id'], //商品id
                "title"          => $goods['g_name'],   //商品名称
                "desc"           => $goods['g_brief'],   //商品简介
                "category_list"  => [$cate1['sk_name'], $cate2['sk_name']],  //商品类目
                "image_list"     => $slide,    //商品图片
                "src_wxapp_path" => $path, // 商品详情页链接
                "sku_list"       => $skuList
            );

            $ret = $mall_widget->updateProduct($productList);
        }
    }

    /**
     * @param $tid
     * 订单打印
     */
    public function dealTradePrint($tid){
        $trade_model= new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade      = $trade_model->getRowById($tid);


        /** 直接用tid 节省一个对象的开销吧
         * 区域合伙人订单自动打印
         * zhangzc
         * 2019-06-15
        **/
        // 订单是否是区域合伙人的订单
        $rm_id=$trade_model->getRegionManagerIdByTid($tid);
        $print_model = new App_Helper_Print($this->sid);
        // 区域合伙人的 找到平台与合伙人的打印机
        // 非区域合伙人的订单查询打印机的时候去掉区域合伙人添加的打印机
        // 最后一个参数为1时标记自动打印时查询打印机列表的时候做区域合伙人的处理
        $print_model->printOrder($trade['t_tid'],'',$trade['t_es_id'],$rm_id,1);
    }

    /*
     * 培训版记录发票信息
     */
    public function saveInvoice($tid){
        //重新获得订单信息
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade = $trade_model->getRowById($tid);
        $tradeExtra = json_decode($trade['t_extra_data'],1);
        if(is_array($tradeExtra) && $tradeExtra['invoice'] > 0){
            $invoice_model = new App_Model_Train_MysqlTrainInvoiceStorage($this->sid);
            $data = [
                'ati_s_id' => $this->sid,
                'ati_m_id' => $trade['t_m_id'],
                'ati_tid'  => $trade['t_tid'],
                'ati_type' => $tradeExtra['invoice'],
                'ati_trade_type' => 1,//订单发票
                'ati_company_name' => $tradeExtra['companyName'],
                'ati_company_code' => $tradeExtra['companyCode'],
                'ati_status' => 1,//未开票
                'ati_create_time' => time()
            ];

            $invoice_model->insertValue($data);
        }
    }

    //TODO 城市合伙人
    /*
     * 记录合伙人分佣
     */
    public function dealTownDeduct($town,$number,$type,$totalCost){
       // Libs_Log_Logger::outputLog('++++'.$typeInfo,'test.log');
       // $typeArr = json_decode($typeInfo,1);
       // Libs_Log_Logger::outputLog('---'.$typeArr['type'],'test.log');
       // $postCost = floatval($postCost);
       // $topCost = floatval($topCost);
       // $shopCost = floatval($shopCost);
       // $totalCost = $postCost + $topCost + $shopCost;

        //查找当前合伙人
        $town_model = new App_Model_City_MysqlCityTownStorage($this->sid);
        $row = $town_model->getRowById($town);
        if($row){
            $this->_save_town_deduct($row,$type,$number,$totalCost);
        }
    }

    /*
     * 递归保存佣金
     */
    private function _save_town_deduct($row,$type,$number,$totalCost){

        $town_model = new App_Model_City_MysqlCityTownStorage($this->sid);
        //记录佣金
        if($row['act_id'] && $row['act_status'] != 1 && $row['act_percent'] > 0 && $totalCost > 0){//未被禁用 分佣比例和总价大于零

            $totalDeduct = 0;
            Libs_Log_Logger::outputLog('有分佣比例','test.log');
            $deduct_model = new App_Model_City_MysqlCityTownDeductStorage($this->sid);
            //帖子发布佣金
            if($type == 1) {

                $totalDeduct = round($totalCost * (floatval($row['act_percent']) / 100), 2);
                if ($totalDeduct > 0) {
                    Libs_Log_Logger::outputLog('发帖佣金', 'test.log');
                    $insert = [
                        'actd_s_id' => $this->sid,
                        'actd_act_id' => $row['act_id'],
                        'actd_number' => $number,
                        'actd_percent' => $row['act_percent'],
                        'actd_create_time' => time(),
                        'actd_total' => $totalCost,
                        'actd_money' => $totalDeduct,
                        'actd_type' => 1
                    ];
                    $deduct_model->insertValue($insert);
                    $town_model->incrementField('act_post_public', $row['act_id'], $totalDeduct);
                }
            }elseif($type == 2){//置顶佣金
                $totalDeduct = round($totalCost * (floatval($row['act_percent'])/100),2);
                if($totalDeduct > 0){
                    Libs_Log_Logger::outputLog('置顶佣金','test.log');
                    $insert = [
                        'actd_s_id' => $this->sid,
                        'actd_act_id' => $row['act_id'],
                        'actd_number' => $number,
                        'actd_percent' => $row['act_percent'],
                        'actd_create_time' => time(),
                        'actd_total' => $totalCost,
                        'actd_money' => $totalDeduct,
                        'actd_type' => 2
                    ];
                    $deduct_model->insertValue($insert);
                    $town_model->incrementField('act_post_top',$row['act_id'],$totalDeduct);
                }
            }elseif ($type == 3){//店铺入驻收费 此时支付接口有type='shop'
                $totalDeduct = round($totalCost * (floatval($row['act_percent'])/100),2);
                if($totalDeduct > 0){
                    Libs_Log_Logger::outputLog('入驻佣金','test.log');
                    $insert = [
                        'actd_s_id' => $this->sid,
                        'actd_act_id' => $row['act_id'],
                        'actd_number' => $number,
                        'actd_percent' => $row['act_percent'],
                        'actd_create_time' => time(),
                        'actd_total' => $totalCost,
                        'actd_money' => $totalDeduct,
                        'actd_type' => 3
                    ];
                    $deduct_model->insertValue($insert);
                    $town_model->incrementField('act_shop_enter',$row['act_id'],$totalDeduct);
                }
            } else{//店铺续费收费 此时支付接口没有type='shop'
                $totalDeduct = round($totalCost * (floatval($row['act_percent'])/100),2);
                if($totalDeduct > 0){
                    Libs_Log_Logger::outputLog('续费佣金','test.log');
                    $insert = [
                        'actd_s_id' => $this->sid,
                        'actd_act_id' => $row['act_id'],
                        'actd_number' => $number,
                        'actd_percent' => $row['act_percent'],
                        'actd_create_time' => time(),
                        'actd_total' => $totalCost,
                        'actd_money' => $totalDeduct,
                        'actd_type' => 4
                    ];
                    $deduct_model->insertValue($insert);
                    $town_model->incrementField('act_shop_renew',$row['act_id'],$totalDeduct);
                }
            }
            //计算总收入
            if($totalDeduct > 0){
                $town_model->incrementField('act_deduct_ktx',$row['act_id'],$totalDeduct);
            }
        }
        if($row['act_fid']){
            $parent_row = $town_model->getRowById($row['act_fid']);
            $this->_save_town_deduct($parent_row,$type,$number,$totalCost);
        }
    }

    /*-----------------------------------------------------------------------------------------------------------
     *                                              邀新活动订单处理
     *                                              zhangzc
     *                                              2019-08-27
    -----------------------------------------------------------------------------------------------------------*/
    /**
     * 当用户下单的时候根据活动的规则写入记录 (在console中的indexController中调用了了此方法)
     * 此方法会放到下单函数的最后环节 进行相关的数据处理
     * 此方法会写入到3张表中 活动表与邀请记录表更新金额与订单数量数据，邀新订单表中进行插入数据
     * @param  [type] $pay_type   [description]
     * @param  [type] $gids       [description]
     * @param  [type] $t_tid      [description]
     * @param  [type] $payment    [订单金额]
     * @param  [type] $mid        [用户id]
     * @return [type]             [description]
     */
    public function tradeInviteDeal($pay_type,$gids,$t_tid,$payment,$mid){
        // 查询当前用户是否在对应的邀请列表里面，并且当时的活动是否已经是结束的状态，结束的话不在进行后续逻辑操作
        $nur_model=new App_Model_Userinvite_MysqlUserinviteUserRecommendStorage($this->sid);
        $nurl_model=new App_Model_Userinvite_MysqlUserinviteUserRecommendListStorage($this->sid);
        $invite_record=$nurl_model->getRow([
            ['name'=>'asurl_reciever_mid','oper'=>'=','value'=>$mid]
        ]);
        // 邀请记录不存在直接终止
        if(!$invite_record)
            return;
        
        $act_info=$nur_model->getRow([
            ['name'=>'asur_id','oper'=>'=','value'=>$invite_record['asurl_aid']]
        ]);
        // 邀新活动已结束 直接终止
        if($act_info['asur_etime']<time())
            return;

        $invite_record_trade_model=new App_Model_Userinvite_MysqlUserinviteUserRecommendTradeStorage($this->sid);
        // 更新邀新记录中收益情况（产生订单就进行更新 act_money字段只在产生有效订单的时候进行更新）
        $asurl_data=[
            'asurl_total_trade' =>1,
            'asurl_act_money'   =>$payment * 100,
            'asurl_total_money' =>$payment * 100,
        ];
        // 更新邀新活动中收益情况（只要产生订单就需要更新）
        $asur_data=[
            'asur_record_trade' =>1,
            'asur_record_money' =>$payment * 100,
        ];


        // 判断该订单是否是微信支付
        if($act_info['asur_pay_type'] && $pay_type!=1){
            unset($asurl_data['asurl_act_money']);
        }
        // 判断订单中是否有指定商品的id 
        if($act_info['asur_goods']){
            // 获取商品中的活动id
            $act_goods=[];
            $act_goods_temp=json_decode($act_info['asur_goods'],true);
            $act_goods=array_column($act_goods_temp,'gid');
            $intersect=array_intersect($gids,$act_goods);
            if(!$intersect){
                unset($asurl_data['asurl_act_money']);
            }
        }
        // 判断是否是单笔订单-并且通过了前面的判断
        if($act_info['asur_trade_num']==1){
            // 满足金额并且以上验证正确
            if(($payment >= ($act_info['asur_trade_money'] / 100)) && $asurl_data['asurl_act_money']){
                if(!$invite_record['asurl_trade_status'])
                    $asurl_data['asurl_trade_status']=1;
            }else{
                unset($asurl_data['asurl_act_money']);
            }

        // 如果是多笔订单的话查看现有的act_money + 这笔订单的付款金额是否满足
        }else if($act_info['asur_trade_num']==0){
            // 查看邀请这状态是否完成-已完成的不在对act_money进行自增
            if(!$invite_record['asurl_trade_status']){
                $now_pay=$asurl_data['asurl_act_money']?$asurl_data['asurl_act_money']:0;
                // 满足金额并且以上验证正确
                if($now_pay && (($invite_record['asurl_act_money'] + $now_pay) >= $act_info['asur_trade_money']))
                    $asurl_data['asurl_trade_status']=1;
            }else{
                unset($asurl_data['asurl_act_money']);
            }
        }

        // 插入邀新活动产生的订单数据
        $record_trade_data=[
            'asurt_sid'         =>$this->sid,
            'asurt_t_tid'       =>$t_tid,
            'asurt_aid'         =>$invite_record['asurl_aid'],
            'asurt_l_id'        =>$invite_record['asurl_id'],
            'asurt_create_time' =>time(),
            'asurt_m_id'        =>$mid,
        ];
        // 因为此操作跟下单有关所以不做事务限制，（也许会产生收不到推荐奖励的小可怜）
        // 插入订单记录
        $exec_trade_insert=$invite_record_trade_model->insertValue($record_trade_data);
        // 更新活动中产生的订单金额与数量

        $exec_act_update=$nur_model->incrementField(array_keys($asur_data),array_values($asur_data),[
            ['name'=>'asur_id','oper'=>'=','value'=>$act_info['asur_id']]
        ]);
        $exec_record_update=$nurl_model->incrementField(array_keys($asurl_data),array_values($asurl_data),[
            ['name'=>'asurl_id','oper'=>'=','value'=>$invite_record['asurl_id']]
        ]);

    }


    /**
     * （sequecne.php dealSequenceVerify方法中调用）
     * 订单完成的时候同步更新-要新纪录里面的完成状态-插入佣金获取记录-累加个人总佣金额度
     * todo 如果是多笔订单的话现在的逻辑是所有的订单都完成收货才算，而没有考虑满足金额后就可以的
     * @param  [type] $t_tid [订单主键]
     * @param  [type] $mid   [description]
     * @param  [type] $sid   [店铺id,调用此方法的时候在初始化时不会存在店铺信息]
     * @return [type]        [description]
     */
    public function tradeInviteFinishDeal($t_tid,$mid,$sid=0){
        $invite_record_trade_model=new App_Model_Userinvite_MysqlUserinviteUserRecommendTradeStorage($sid);
        $invite_trade_record=$invite_record_trade_model->getRow([
            ['name'=>'asurt_t_tid','oper'=>'=','value'=>$t_tid]
        ]);
        if(!$invite_trade_record)
            return;
        // 更新该订单记录的完成状态
        $invite_record_trade_model->updateById(['asurt_status'=>1],$invite_trade_record['asurt_id']);
        // 查找该邀请记录里面还有没有未完成的订单
        $trade_list=$invite_record_trade_model->getList([
            ['name'=>'asurt_l_id','oper'=>'=','value'=>$invite_trade_record['asurt_l_id']]
        ],0,0,[],['asurt_status']);
        $all_finish=TRUE;
        // 只要存在未完成的订单就不进行后续操作
        // @todo 只要已完成的订单额度大于等于指定的活动需要满足的金额 也算成功
        foreach ($trade_list as $key => $value) {
            if($value['asurt_status']==0){
                $all_finish=FALSE;
                break;
            }
        }
        if(!$all_finish)
            return;

        // 查看邀新记录中是否完成了任务
        $where=[
            ['name'=>'asurl_id','oper'=>'=','value'=>$invite_trade_record['asurt_l_id']],
            ['name'=>'asurl_trade_status','oper'=>'=','value'=>1]
        ];
        $set=[
            'asurl_status'   =>1,
        ];
        $nur_model=new App_Model_Userinvite_MysqlUserinviteUserRecommendStorage($this->sid);
        $nurl_model=new App_Model_Userinvite_MysqlUserinviteUserRecommendListStorage($this->sid);
        $nurl_exec=$nurl_model->updateValue($set,$where);
        // 更新完成则执行佣金相关逻辑
        if($nurl_exec){
            $act_info=$nur_model->getRow([
                ['name'=>'asur_id','oper'=>'=','value'=>$invite_trade_record['asurt_aid']]
            ]);

            $invite_record=$nurl_model->getRow([
                ['name'=>'asurl_sid','oper'=>'=','value'=>$this->sid],
                ['name'=>'asurl_reciever_mid','oper'=>'=','value'=>$mid]
            ]);

            // 个人佣金总额
            $deduct_money=$act_info['asur_reward_money'] / 100;
            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
            // 更新的应该是邀请者 mid 的佣金
            $exec=$member_model->incrementField(['m_deduct_ktx','m_deduct_amount'],[$deduct_money,$deduct_money],[
                ['name'=>'m_id','oper'=>'=','value'=>$invite_record['asurl_invite_mid']]
            ]);
        }
    }

    /*----------------------------------------------------------------------小程序退款流程重构---------------------------------------------------------------------------------------------
     *整单退款的逻辑与子订单退款的逻辑区分开来
     *
    ------------------------------------------------------------------------小程序退款流程重构---------------------------------------------------------------------------------------------*/

    /**
     * 商城商品退款流程重构 -再不重构这块的逻辑就没人再能看的懂了，
     * zhangzc
     * 2019-10-29
     * @param  [type]  $tid           [主订单ID]
     * @param  [type]  $toid          [子订单ID]
     * @param  integer $refund_status [是否同意退款 1拒绝 2同意]
     * @param  [type]  $refund_note   [退款备注信息]
     * @param  integer $refund_source [1待结算退款，2余额退款]
     * @param  integer $refund_fee    [退款金额]
     * @param  integer $refund_record [是否已经插入了维权记录]
     * @param  array   $manager       [现在还不知道传这个字段是干啥的]
     * @return [type]                 [description]
     */
    public function appletTradeRefundRevolution(
        $tid,                   
        $toid,                  
        $refund_status=2,       
        $refund_note,           
        $refund_source=2,       
        $refund_fee=0,          
        $refund_record=1,       
        $manager=[]             
    ){

    }
    /**
     * 子订单的退款（单品退款）
     * zhangzc
     * 2019-10-29
     * @return [type] [description]
     */
    private function childTradeRefund(){

    }

    /**
     * 主订单的退款(整单退款)
     * zhangzc
     * 2019-10-29
     * @return [type] [description]
     */
    private function mainTradeRefund(){

    }

}
