<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/12/24
 * Time: 上午10:00
 */
class App_Helper_ShopMessage{

    const TRADE_HAD_PAY  = 1;  //已付款。新订单
    const TRADE_RIGHTS   = 2;  //申请维权
    const APPLY_THREE_WITHDRAW = 3;  //分销申请提现
    const REMIND_DELIVER = 4;  //买家提醒商家发货
    const LEAVING_MESSAGE = 5;      //预约留言提醒
    const LEAVING_APPLET_AUTH = 6;  //小程序审核通知
    const APPLY_WITHDRAW = 7;  //提现
    const LEAVING_SHOP_ENTER = 8;       //店铺入驻通知
    const LEAVING_MOBILE_ENTER = 15;       //电话本入驻通知
    const SEQUENCE_LEADER_APPLY = 9;    //社区团购申请团长
    const LEAVING_SHOP_CLAIM = 14; //店铺认领

    const SEQUENCE_REGION_GOODS_VERIFY = 10; //社区团购 处理合伙人商品审核
    const SEQUENCE_REGION_COMMUNITY_VERIFY = 11; //社区团购 处理合伙人小区审核
    const SEQUENCE_REGION_GOODS_SEND = 12; //社区团购 处理合伙人商品审核
    const SEQUENCE_REGION_COMMUNITY_SEND = 13; //社区团购 处理合伙人小区审核
    const SEQUENCE_SUPPLIER_GOODS_SEND = 16; //社区团购 供应商添加待审核商品

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

        $applet_storage = new App_Model_Applet_MysqlCfgStorage();
        $this->shop = $applet_storage->getAppletShopCfg($sid);
    }
    /*
     * 推送通知
     */
    public function messageRecord($type,$trade='',$content = '',$to_manager = 0,$extra_content = ''){

        $data = self::_get_notice_content($type,$trade,$content);

        $insertData = array(
            'sm_s_id'    => $this->sid,
            'sm_title'   => $data['title'],
            'sm_content' => $data['content'],
            'sm_type'    => $data['type'],
            'sm_tid'     => $data['orderNumber'],
            'sm_create_time' => time(),
            'sm_read'    => 0,
            'sm_to_manager' => $to_manager,
            'sm_extra_content' => $extra_content
        );

        $message_storage = new App_Model_Shop_MysqlShopMessageStorage($this->sid);
        $message_storage->insertValue($insertData);
    }

    /*
     * 获取推送内容
     */
    private function _get_notice_content($type,$trade='',$content = ''){
        $data = array();
        if($type==self::TRADE_HAD_PAY){
            $data = array(
                'title'   => '订单付款通知',
                'content' => '你管理的店铺'.$this->shop['s_name'].'有新的订单已付款，订单金额'.$trade['t_total_fee'].'，订单号：'.$trade['t_tid'],
                'type'  => self::TRADE_HAD_PAY,
                'orderNumber' => isset($trade) && $trade ? $trade['t_tid'] : '',
            );
        }elseif($type==self::TRADE_RIGHTS){
            $data = array(
                'title'   => '退款申请通知',
                'content' => '你管理的店铺'.$this->shop['s_name'].'有新的退款申请，订单号：'.$trade['t_tid'],
                'type'  => self::TRADE_RIGHTS,
                'orderNumber' => isset($trade) && $trade ? $trade['t_tid'] : '',
            );
        }elseif($type==self::APPLY_WITHDRAW){
            $data = array(
                'title'   => '提现申请通知',
                'content' => '你管理的店铺'.$this->shop['s_name'].'有新的提现申请，提现金额：'.$trade['money'].'元',
                'type'  => self::APPLY_WITHDRAW,
                'orderNumber' => '',
            );
        }elseif($type==self::REMIND_DELIVER){
            $data = array(
                'title'   => '发货提醒通知',
                'content' => '你管理的店铺'.$this->shop['s_name'].'有买家提醒尽快发货，订单号：'.$trade['t_tid'],
                'type'  => self::REMIND_DELIVER,
                'orderNumber' => isset($trade) && $trade ? $trade['t_tid'] : '',
            );
        }elseif($type==self::LEAVING_MESSAGE){
            $data = array(
                'title'   => '留言通知',
                'content' => '你管理的店铺'.$this->shop['s_name'].'收到新的留言，请及时处理',
                'type'  => self::LEAVING_MESSAGE,
                'orderNumber' => '',
            );
        }elseif($type==self::LEAVING_APPLET_AUTH){
            $data = array(
                'title'   => '小程序审核'.$trade['stauts'].'通知',
                'content' => $trade['content'],
                'type'  => self::LEAVING_APPLET_AUTH,
                'orderNumber' => '',
            );
        }elseif($type==self::APPLY_WITHDRAW){
            $data = array(
                'title'   => '提现申请通知',
                'content' => '你管理的店铺'.$this->shop['s_name'].'有新的提现申请，提现金额：'.$trade['money'].'元',
                'type'  => self::APPLY_WITHDRAW,
                'orderNumber' => '',
            );
        }elseif($type==self::LEAVING_SHOP_ENTER){
            $data = array(
                'title'   => '店铺入驻通知',
                'content' => '你管理的店铺'.$this->shop['s_name'].'收到新的商家入驻申请，请及时处理。店铺名称：'.$trade['name'],
                'type'  => self::LEAVING_SHOP_ENTER,
                'orderNumber' => $trade['id'],
            );
        }elseif($type==self::SEQUENCE_LEADER_APPLY){
            $data = array(
                'title'   => '团长申请通知',
                'content' => '你管理的店铺'.$this->shop['s_name'].'收到新的团长申请，请及时处理。',
                'type'  => self::SEQUENCE_LEADER_APPLY,
                'orderNumber' => '',
            );
        }elseif($type==self::SEQUENCE_REGION_GOODS_SEND){
            $data = array(
                'title'   => '商品申请通知',
                'content' => '你管理的店铺'.$this->shop['s_name'].'收到新的商品审核申请，请及时处理。',
                'type'  => self::SEQUENCE_REGION_GOODS_SEND,
                'orderNumber' => '',
            );
        }elseif($type==self::SEQUENCE_REGION_COMMUNITY_SEND){
            $data = array(
                'title'   => '小区申请通知',
                'content' => '你管理的店铺'.$this->shop['s_name'].'收到新的小区审核申请，请及时处理。',
                'type'  => self::SEQUENCE_REGION_COMMUNITY_SEND,
                'orderNumber' => '',
            );
        }elseif($type==self::SEQUENCE_REGION_GOODS_VERIFY){
            $data = array(
                'title'   => '商品审核结果',
                'content' => $content,
                'type'  => self::SEQUENCE_REGION_GOODS_VERIFY,
                'orderNumber' => '',
            );
        }elseif($type==self::SEQUENCE_REGION_COMMUNITY_VERIFY){
            $data = array(
                'title'   => '小区审核结果',
                'content' => '你管理的店铺'.$this->shop['s_name'].'收到新的小区审核申请，请及时处理。',
                'type'  => self::SEQUENCE_REGION_COMMUNITY_VERIFY,
                'orderNumber' => '',
            );
        }elseif($type==self::LEAVING_SHOP_CLAIM){
            $data = array(
                'title'   => '店铺认领通知',
                'content' => '你管理的店铺'.$this->shop['s_name'].'收到新的店铺认领信息，请及时处理。',
                'type'  => self::LEAVING_SHOP_CLAIM,
                'orderNumber' => $trade['id'],
            );
        }elseif($type==self::LEAVING_MOBILE_ENTER){
            $data = array(
                'title'   => '电话本入驻通知',
                'content' => '你管理的店铺'.$this->shop['s_name'].'收到新的电话本入驻申请，请及时处理。店铺名称：'.$trade['name'],
                'type'  => self::LEAVING_MOBILE_ENTER,
                'orderNumber' => $trade['id'],
            );
        }elseif($type==self::SEQUENCE_SUPPLIER_GOODS_SEND){
            $data = array(
                'title'   => '供应商商品待审核通知',
                'content' => '你管理的店铺'.$this->shop['s_name'].'收到新的供应商商品添加，请及时处理。',
                'type'  => self::SEQUENCE_SUPPLIER_GOODS_SEND,
                'orderNumber' =>'',
            );
        }
        return $data;
    }

}