<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/4/8
 * Time: 上午9:43
 */
class App_Helper_System {

    const SHOP_COIN_INCOME      = 1;//收入
    const SHOP_COIN_OUTPUT      = 2;//支出
    const CREATE_SHOP           = 1; // 创建店铺成功
    const SHOP_PAY_BOND         = 2; // 店铺缴纳保证金
    const INVITE_CREATE_SHOP    = 3; // 邀请好友创建店铺
    const INVITE_PAY_BOND       = 4; // 邀请好友缴纳保证金
    const SHOP_PERSON_AUTH      = 5; // 个人认证
    const SHOP_COMPANY_AUTH     = 6; // 企业认证
    const SHOP_PAY_PLUG         = 7; // 购买插件
    const INVITE_PAY_PLUG       = 8; // 邀请好友购买插件
    const INVITE_PAY_PACKAGE    = 9; // 邀请好友购买7800套餐


    public function __construct() {
    }
    /*
     * 店铺金币进出记录
     * @param int $type 1收入,2支出
     */
    public function shopCoinInout($sid,$title, $amount, $type ) {
        $amount     = abs($amount);
        $coin       = $type == self::SHOP_COIN_INCOME ? $amount : -$amount;
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $shop       = $shop_model->getRowById($sid);
        $bi_model   = new App_Model_Shop_MysqlBalanceInoutStorage();
        $indata     = array(
            'bi_s_id'   => $sid,
            'bi_title'  => $title,
            'bi_type'   => $type,
            'bi_amount' => $amount,
            'bi_balance'=> floatval($shop['s_recharge'])+$coin,
            'bi_create_time'    => time(),
        );
        $bi_model->insertValue($indata);
        //增减店铺金币
        return $shop_model->incrementShopRecharge($sid, $coin);
    }

    /*
     * 根据类型给店铺增加赠送金币
     * @param int $type 1创建店铺，2缴纳保证金，3邀请好友创建店铺，4邀请好友缴纳保证金，5个人认证，6企业认证，7购买插件，8邀请好友购买插件，9邀请好友购买7800套餐
     */
    public function shopGetGold($type,$sid,$mark){
        $type_cfg = plum_parse_config('give_gold','system');
        $amount = $type_cfg[$type];    // 赠送金额
        // 添加赠送记录
        $data = array(
            'gr_s_id'        => $sid,
            'gr_type'        => $type,
            'gr_amount'      => $amount,
            'gr_mark'        => $mark,
            'gr_create_time' => time()
        );
        $give_storage = new App_Model_Shop_MysqlShopGiveRecordStorage($sid);
        $res = $give_storage->insertValue($data);
        // 为店铺增加金币
        self::shopCoinInout($sid,$mark,$amount,self::SHOP_COIN_INCOME);
        return $res;
    }

}