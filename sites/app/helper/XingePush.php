<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/12/24
 * Time: 上午10:00
 */
class App_Helper_XingePush{

    const TRADE_HAD_PAY  = 1;  //已支付、待发货
    const TRADE_FINISH   = 2;  //签收交易完成
    const TRADE_RIGHTS   = 3;  //申请维权
    const APPLY_WITHDRAW = 4;  //申请提现
    const REMIND_DELIVER = 5;  //买家提醒商家发货
    const CUSTOMER_SERVICE_NEWS =  6;  //客服消息推送
    const CASHIER_RECEIPTS = 7;       //收银台收款提醒
    /*
     * 店铺ID
     */
    private $sid;
    /*
     * 店铺数据，字段名参考pre_shop
     */
    private $shop;

    public function __construct($sid){
        $this->sid  = $sid;

        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $this->shop = $shop_model->getRowById($sid);
    }
    /*
     * 推送通知
     */
    public function pushNotice($type,$trade=''){
        $ret = array();
        // 获取信鸽推送配置
        $xg_cfg = plum_parse_config('xg_cfg');
        //获取推送消息内容
        $data = self::_get_push_content($type,$trade);
        //获取推送账户
        $accountList = self::_get_company_manager();
        if(!empty($accountList)){
            //先推安卓
            $android_model = new App_Plugin_XingeApp_XingeAppPlugin($xg_cfg['xg_android']['accessId'],$xg_cfg['xg_android']['secretKey']);
            $push_android = $android_model->PushAccountListAndroid($data['title'],$data['content'],$accountList,$data);

            // 推ios
            $ios_model = new App_Plugin_XingeApp_XingeAppPlugin($xg_cfg['xg_ios']['accessId'],$xg_cfg['xg_ios']['secretKey']);
            $push_ios = $ios_model->PushAccountListIos($data['content'],$accountList,$data);

            $ret = array(
                'android' => $push_android,
                'ios'     => $push_ios,
            );
        }
        Libs_Log_Logger::outputLog($ret);
        return $ret;

    }

    /*
     * 获取推送内容
     */
    private function _get_push_content($type,$trade=''){
        $data = array();
        if($type==self::TRADE_HAD_PAY){
            $data = array(
                'title'   => '订单已付款',
                'content' => '你管理的店铺'.$this->shop['s_name'].'有新的订单已付款，请及时处理',
                'status'  => self::TRADE_HAD_PAY,
                'shopName'=> $this->shop['s_name'],
                'orderNumber' => isset($trade) && $trade ? $trade['t_tid'] : '',
                'type'        => 'order',
            );
        }elseif($type==self::TRADE_FINISH){
            $data = array(
                'title'   => '订单已签收',
                'content' => '你管理的店铺'.$this->shop['s_name'].'有新的订单已签收',
                'status'  => self::TRADE_FINISH,
                'shopName'=> $this->shop['s_name'],
                'orderNumber' => isset($trade) && $trade ? $trade['t_tid'] : '',
                'type'        => 'sign',
            );
        }elseif($type==self::TRADE_RIGHTS){
            $data = array(
                'title'   => '退款申请',
                'content' => '你管理的店铺'.$this->shop['s_name'].'有新的退款申请，请及时处理',
                'status'  => self::TRADE_RIGHTS,
                'shopName'=> $this->shop['s_name'],
                'orderNumber' => isset($trade) && $trade ? $trade['t_tid'] : '',
                'type'        => 'refund',
            );
        }elseif($type==self::APPLY_WITHDRAW){
            $data = array(
                'title'   => '提现申请',
                'content' => '你管理的店铺'.$this->shop['s_name'].'有新的提现申请，请及时处理',
                'status'  => self::APPLY_WITHDRAW,
                'shopName'=> $this->shop['s_name'],
                'orderNumber' => isset($trade) && $trade ? $trade['t_tid'] : '',
                'type'        => 'withdraw',
            );
        }elseif($type==self::REMIND_DELIVER){
            $data = array(
                'title'   => '发货提醒',
                'content' => '你管理的店铺'.$this->shop['s_name'].'有买家购买的'.mb_substr($trade['t_title'],0,15).'提醒尽快发货，请及时处理',
                'status'  => self::REMIND_DELIVER,
                'shopName'=> $this->shop['s_name'],
                'orderNumber' => isset($trade) && $trade ? $trade['t_tid'] : '',
                'type'        => 'deliver',
            );
        }elseif($type==self::CUSTOMER_SERVICE_NEWS){
            $data = array(
                'title'   => '客服消息提醒',
                'content' => '你管理的店铺'.$this->shop['s_name'].'收到新的消息，请及时处理',
                'status'  => self::CUSTOMER_SERVICE_NEWS,
                'shopName'=> $this->shop['s_name'],
                'orderNumber' => isset($trade) && $trade ? $trade['t_tid'] : '',
                'type'        => 'customer',
            );
        }elseif($type==self::CASHIER_RECEIPTS){
            $data = array(
                'title'   => '收款到账提醒',
                'content' => '你管理的店铺'.$this->shop['s_name'].'收款到账'.$trade['cr_money'].'元，请查看确认',
                'status'  => self::CUSTOMER_SERVICE_NEWS,
                'shopName'=> $this->shop['s_name'],
                'orderNumber' => isset($trade) && $trade && $trade['cr_tid'] ? $trade['cr_tid'] : '',
                'type'        => 'arrival',
            );
        }
        return $data;
    }

    /*
     * 获取该公司的所有管理员
     */
    private function _get_company_manager(){
        $manager_model = new App_Model_Member_MysqlManagerStorage();
        $list = $manager_model->getManagerByCompany($this->shop['s_c_id']);
        $account = array();
        if(!empty($list)){
            foreach($list as $val){
                $account[] = $val['m_mobile'];
            }
        }
        return $account;
    }



}