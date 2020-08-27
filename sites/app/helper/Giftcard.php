<?php

class App_Helper_Giftcard {

    //订单状态
    const TRADE_NO_PAY          = 1;//待付款
    const TRADE_WAIT_ACTIVE     = 2;//已支付待处理
    const TRADE_HAD_ACTIVE      = 3;//已处理
    const TRADE_CLOSED          = 4;//已关闭

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

    //礼品卡状态
    const CARD_NO_ACTIVE    = 1;//未激活
    const CARD_IS_ACTIVE    = 2;//已激活
    const CARD_USE_OUT      = 3;//已用完

    //订单类型描述
    public static $trade_status_note = [
        self::TRADE_NO_PAY => '待支付',
        self::TRADE_WAIT_ACTIVE => '待处理',
        self::TRADE_HAD_ACTIVE => '已处理',
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
        'hadpay'   => array(
            'id'    => self::TRADE_WAIT_ACTIVE,
            'label' => '待处理'
        ),
        'take'   => array(
            'id'    => self::TRADE_HAD_ACTIVE,
            'label' => '已处理'
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
     * 处理订单支付后 添加礼品卡
     */
    public function dealTradePay($trade){
        $res = false;
        $cardInfo = json_decode($trade['agct_card_info'],1);
        $timeNow = time();
        $card_model = new App_Model_Giftcard_MysqlGiftCardStorage($this->sid);
        $insert = [];
        foreach ($cardInfo as $val){
            $card = $card_model->getRowById($val['id']);
            $num = intval($val['num']);
            for($i = 0; $i < $num; $i++){
                $number = 'C'.date('is').plum_random_num_letter(9,0);
                $insert[] = " (NULL, '{$this->sid}', '{$card['agc_id']}', '{$trade['agct_m_id']}', '0','{$card['agc_name']}','{$card['agc_cover']}','{$trade['agct_cover']}','{$card['agc_type']}','{$card['agc_coin']}','{$number}','1','{$trade['agct_tid']}', '0','{$timeNow}','{$timeNow}')";
            }
        }
        $buy_model = new App_Model_Giftcard_MysqlGiftCardBuyStorage($this->sid);
        if($insert){
            $res = $buy_model->insertBatch($insert);
        }
        if($res){
            $trade_model = new App_Model_Giftcard_MysqlGiftCardTradeStorage($this->sid);
            $trade_model->findUpdateTradeByTid($trade['agct_tid'],['agct_status' => 3]);
        }

    }

    /*
     * 创建二维码
     */
    public function createQrcode($card){
        $filename = $card['agcb_id'].'-'.$card['agcb_number']. '.png';
        $text = $card['agcb_number'];
        Libs_Qrcode_QRCode::png($text, PLUM_APP_BUILD.'/spread/'.$filename, 'Q', 6, 1);
        return PLUM_PATH_PUBLIC.'/build/spread/'.$filename;
    }

    /*
     * 超时关闭订单
     */
    public function closeOvertimeTrade($id){
        $trade_model = new App_Model_Giftcard_MysqlGiftCardTradeStorage($this->sid);
        $trade = $trade_model->getRowById($id);
        if(!$trade){
            return false;
        }
        if($trade['agct_status'] == self::TRADE_NO_PAY){
            //修改订单状态
            $set = [
                'agct_status' => self::TRADE_CLOSED,
            ];
            $res = $trade_model->updateById($set,$id);
            return $res;
        }
        return false;

    }

    /*
     * 保存使用记录
     */
    public function saveUseRecordAction($id,$mid,$money){
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $member = $member_model->getRowById($mid);

        $insert = [
            'agcu_s_id' => $this->sid,
            'agcu_m_id' => $mid,
            'agcu_buy_id' => $id,
            'agcu_type' => 1,//扣费
            'agcu_m_nickname' => $member['m_nickname'],
            'agcu_m_avatar' => $member['m_avatar'] ?  $member['m_avatar'] : '',
            'agcu_money' => $money,
            'agcu_create_time' => time()
        ];
        $use_model = new App_Model_Giftcard_MysqlGiftCardUseStorage($this->sid);
        $res = $use_model->insertValue($insert);
    }




}