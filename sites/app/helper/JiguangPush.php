<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/12/24
 * Time: 上午10:00
 */
class App_Helper_JiguangPush{

    const TRADE_HAD_PAY  = 1;  //已支付、待发货
    const TRADE_FINISH   = 2;  //签收交易完成
    const TRADE_RIGHTS   = 3;  //申请维权
    const APPLY_WITHDRAW = 4;  //申请提现
    const REMIND_DELIVER = 5;  //买家提醒商家发货
    const CUSTOMER_SERVICE_NEWS =  6;  //客服消息推送
    const CASHIER_RECEIPTS = 7;       //收银台收款提醒
    const LEAVING_MESSAGE = 8;       //预约留言提醒
    const LEAVING_APPLET_AUTH = 9;       //小程序审核通知
    const LEAVING_SHOP_ENTER = 10;       //店铺入驻通知
    const LEAVING_SUBMIT_POST = 11;       //小程序发帖通知
    const LEAVING_RECHARGE = 12;      //小程序充值提醒
    const FREETRADE_SUBMIT = 13; //免费预约订单支付

    const LEAVING_MOBILE_ENTER = 20;       //电话本店铺入驻通知
    const LEAVING_SHOP_CLAIM = 21;       //店铺认领通知

    const LEGWORK_TRADE_SEND = 14; //跑腿后台派单
    const LEGWORK_TRADE_CANCEL = 15; //跑腿取消订单
    const LEGWORK_TRADE_FINISH = 17; //跑腿完成订单
    const LEGWORK_RIDER_NOTICE = 16; //骑手通知消息
    const ELE_SEND_SERVICE_ORDER = 17; //蜂鸟推单成功通知消息
    const GOODS_STOCK_ALERT = 18; //商品库存不足推送
    const LEGWORK_NEW_TRADE = 19; //跑腿新订单提醒

    const LEGWORK_COMPLAINT=22; //跑腿投诉订单
    const LEGWORK_COMPLAINT_FINISHED=23; //跑腿投诉订单完结时推送

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
    public function pushNotice($type,$trade='',$pushType='',$legwork = false){

        if(isset($trade['t_es_id'])){//订单
            $esId = $trade['t_es_id'];
        }elseif (isset($trade['cr_es_id'])){//收银台
            $esId = $trade['cr_es_id'];
        }elseif (isset($trade['acft_es_id'])){
            $esId = $trade['acft_es_id'];
        }elseif (isset($trade['g_es_id']) && $trade['g_es_id'] > 0){
            $esId = $trade['g_es_id'];
        }else{
            $esId = 0;
        }
        $ret = array();
        $accountList = [];
        if($legwork){
            //跑腿相关推送
            $rider_model = new App_Model_Legwork_MysqlLegworkRiderStorage($this->sid);
            if(isset($trade['alt_rider']) && $trade['alt_rider'] > 0){
                $riderRow = $rider_model->getRowById($trade['alt_rider']);
                $accountList[] = $riderRow['alr_mobile'];
            }else{
                $checkWork = $type == self::LEGWORK_NEW_TRADE ? 1 : 0;
                $accountList = self::_get_legwork_rider($checkWork);
            }

        }else{
            // 判断是否是多店的入驻店铺订单
            if($trade && !empty($trade) && $esId>0){
                $accountList = self::_get_enter_shop_manager($esId);
                // 获取入驻店铺信息
                $store_model = new App_Model_Entershop_MysqlEnterShopStorage();
                $store = $store_model->getRowById($esId);
                $this->shop['s_name'] = $store['es_name'];
            }elseif(isset($trade['t_store_id']) && $trade['t_store_id'] > 0){
                $store_model = new App_Model_Store_MysqlStoreStorage();
                $store = $store_model->getRowById($trade['t_store_id']);
                if($store['os_manager_mobile']){
                    $accountList[] = 'store_'.$store['os_manager_mobile'];
                    $this->shop['s_name'] = $store['os_name'];
                }
                
            }else{
                //获取推送账户
                $accountList = self::_get_company_manager();
            }
        }



        $data = self::_get_push_content($type,$trade);

        if(!empty($accountList)){
            $push_storage = new App_Plugin_Jpush_JpushPlugin($this->shop['ac_type']);
            if($pushType){  //客服消息则推送通知，不再推送消息
                $ret = $push_storage->push($accountList,$data['title'],$data['content'],$data,$pushType,86400,true,$legwork);
            }else{
                $ret = $push_storage->push($accountList,$data['title'],$data['content'],$data,'all',86400,true,$legwork);
            }
        }
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
        }elseif($type==self::CUSTOMER_SERVICE_NEWS){  //消息只推送通知
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
                'status'  => self::CASHIER_RECEIPTS,
                'shopName'=> $this->shop['s_name'],
                'orderNumber' => isset($trade) && $trade && $trade['cr_tid'] ? $trade['cr_tid'] : '',
                'type'        => 'arrival',
            );
        }elseif($type==self::LEAVING_MESSAGE){
            $data = array(
                'title'   => '预约留言提醒',
                'content' => '你管理的店铺'.$this->shop['s_name'].'收到新的预约留言，请及时处理',
                'status'  => self::LEAVING_MESSAGE,
                'shopName'=> $this->shop['s_name'],
                'orderNumber' => isset($trade) && $trade && $trade['cr_tid'] ? $trade['cr_tid'] : '',
                'type'        => 'message',
            );
        }elseif($type==self::LEAVING_APPLET_AUTH){
            $data = array(
                'title'   => '小程序审核通知',
                'content' => $trade['content'],
                'status'  => self::LEAVING_APPLET_AUTH,
                'shopName'=> $this->shop['s_name'],
                'orderNumber' => '',
                'type'        => 'appletAudit',
            );
        }elseif($type==self::LEAVING_SHOP_ENTER){
            $data = array(
                'title'   => '店铺入驻提醒',
                'content' => '你管理的店铺'.$this->shop['s_name'].'收到新的商家入驻申请，请及时处理',
                'status'  => self::LEAVING_SHOP_ENTER,
                'shopName'=> $this->shop['s_name'],
                'orderNumber' => isset($trade) && $trade ? intval($trade) : '',
                'type'        => 'shopEnter',
            );
        }elseif($type==self::LEAVING_SHOP_CLAIM){
            $data = array(
                'title'   => '店铺认领提醒',
                'content' => '你管理的店铺'.$this->shop['s_name'].'收到新的店铺认领信息，请及时处理',
                'status'  => self::LEAVING_SHOP_CLAIM,
                'shopName'=> $this->shop['s_name'],
                'orderNumber' => isset($trade) && $trade ? intval($trade) : '',
                'type'        => 'shopClaim',
            );
        }elseif($type==self::LEAVING_MOBILE_ENTER){
            $data = array(
                'title'   => '电话本入驻提醒',
                'content' => '你管理的店铺'.$this->shop['s_name'].'收到新的电话本入驻申请，请及时处理',
                'status'  => self::LEAVING_MOBILE_ENTER,
                'shopName'=> $this->shop['s_name'],
                'orderNumber' => isset($trade) && $trade ? intval($trade) : '',
                'type'        => 'mobileEnter',
            );
        }elseif($type==self::LEAVING_SUBMIT_POST){
            $data = array(
                'title'   => '发帖提醒',
                'content' => '你管理的店铺'.$this->shop['s_name'].'有新的帖子发布，请登录查看',
                'status'  => self::LEAVING_SUBMIT_POST,
                'shopName'=> $this->shop['s_name'],
                'orderNumber' => isset($trade) && $trade  ? intval($trade) : '',
                'type'        => 'submitPost',
            );
        }elseif ($type==self::LEAVING_RECHARGE){
            $data = array(
                'title'   => '充值提醒',
                'content' => '你管理的店铺'.$this->shop['s_name'].'有会员充值，请登录查看',
                'status'  => self::LEAVING_RECHARGE,
                'shopName'=> $this->shop['s_name'],
                'orderNumber' => isset($trade) && $trade  ? intval($trade['id']) : '',
                'mid'     => isset($trade) && $trade  ? intval($trade['mid']) : '',
                'type'        => 'recharge',
            );
        }elseif ($type==self::FREETRADE_SUBMIT){
            $data = array(
                'title'   => '预约订单提醒',
                'content' => '你管理的店铺'.$this->shop['s_name'].'有新的预约订单，请及时处理',
                'status'  => self::FREETRADE_SUBMIT,
                'shopName'=> $this->shop['s_name'],
                'orderNumber' => isset($trade) && $trade  ? intval($trade['acft_id']) : '',
                //'mid'     => isset($trade) && $trade  ? intval($trade['acft_m_id']) : '',
                'type'        => 'freeTrade',
            );
        }elseif ($type==self::LEGWORK_TRADE_SEND){
            $data = array(
                'title'   => '派单提醒',
                'content' => '您有新的订单，请及时处理',
                'status'  => self::LEGWORK_TRADE_SEND,
                'shopName'=> '',
                'orderNumber' => isset($trade) && $trade  ? $trade['alt_tid'] : '',
                //'mid'     => isset($trade) && $trade  ? intval($trade['acft_m_id']) : '',
                'type'        => 'legworkSendTrade',
            );
        }elseif ($type==self::LEGWORK_TRADE_CANCEL){
            $data = array(
                'title'   => '订单取消提醒',
                'content' => '您的订单已被取消，请及时查看',
                'status'  => self::LEGWORK_TRADE_CANCEL,
                'shopName'=> '',
                'orderNumber' => isset($trade) && $trade  ? $trade['alt_tid'] : '',
                //'mid'     => isset($trade) && $trade  ? intval($trade['acft_m_id']) : '',
                'type'        => 'legworkTradeCancel',
            );
        }elseif ($type==self::LEGWORK_TRADE_FINISH){
            $data = array(
                'title'   => '订单完成提醒',
                'content' => '您的订单已完成，请及时查看',
                'status'  => self::LEGWORK_TRADE_FINISH,
                'shopName'=> '',
                'orderNumber' => isset($trade) && $trade  ? $trade['alt_tid'] : '',
                //'mid'     => isset($trade) && $trade  ? intval($trade['acft_m_id']) : '',
                'type'        => 'legworkTradeFinish',
            );
        }elseif ($type==self::LEGWORK_RIDER_NOTICE){
            $data = array(
                'title'   => '通知消息',
               // 'content' => $trade['aln_title'],
                'content' => '您有新的通知消息，请及时查看',
                'status'  => self::LEGWORK_RIDER_NOTICE,
                'shopName'=> '',
                'orderNumber' => isset($trade) && $trade  ? intval($trade['aln_id']) : '',
                //'mid'     => isset($trade) && $trade  ? intval($trade['acft_m_id']) : '',
                'type'        => 'legworkRiderNotice',
            );
        }elseif ($type==self::ELE_SEND_SERVICE_ORDER){
            $data = array(
                'title'   => '蜂鸟配送推单成功',
                'content' => '蜂鸟配送推单成功，请尽快准备订单商品',
                'status'  => self::ELE_SEND_SERVICE_ORDER,
                'shopName'=> '',
                'orderNumber' => isset($trade) && $trade  ? intval($trade['t_tid']) : '',
                'type'        => 'eleSendServiceOrder',
            );
        }elseif ($type==self::GOODS_STOCK_ALERT){
            $data = array(
                'title'   => '商品补货提醒',
                'content' => '您的商品'.$trade['g_name'].'库存达到提醒值，请及时处理',
                'status'  => self::GOODS_STOCK_ALERT,
                'shopName'=> '',
                'orderNumber' => isset($trade) && $trade  ? intval($trade['g_id']) : '',
                'type'        => 'goodsStockAlert',
            );
        }elseif ($type==self::LEGWORK_NEW_TRADE){
            $data = array(
                'title'   => '新订单提醒',
                'content' => '有新订单了，请及时查看',
                'status'  => self::LEGWORK_NEW_TRADE,
                'shopName'=> '',
                'orderNumber' => isset($trade) && $trade  ? $trade['alt_tid'] : '',
                'type'        => 'legworkNewTrade',
            );
        }elseif ($type==self::LEGWORK_COMPLAINT){
            $data = array(
                'title'   => '订单投诉',
                'content' => '您有未处理的投诉信息，点击进行查看',
                'status'  => self::LEGWORK_COMPLAINT,
                'shopName'=> '',
                'orderNumber' =>$trade['alt_tid'],
                'type'        => 'legworkComplaint',
            );
        }elseif ($type==self::LEGWORK_COMPLAINT_FINISHED){
            $data = array(
                'title'   => '订单投诉结果',
                'content' => '您的被投诉订单有新的进展',
                'status'  => self::LEGWORK_COMPLAINT_FINISHED,
                'shopName'=> '',
                'orderNumber' =>$trade['alt_tid'],
                'type'        => 'legworkComplaint',
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

    /*
     * 获取该公司的所有管理员
     */
    private function _get_legwork_rider($checkWork = 0){
        $rider_model = new App_Model_Legwork_MysqlLegworkRiderStorage($this->sid);
        $where[] = ['name'=>'alr_s_id','oper'=>'=','value'=>$this->sid];
        $where[] = ['name'=>'alr_status','oper'=>'=','value'=>0]; //未被封禁
        if($checkWork){
            $where[] = ['name'=>'alr_work','oper'=>'=','value'=>1];
        }
        $list = $rider_model->getList($where,0,0);
        $account = array();
        if(!empty($list)){
            foreach($list as $val){
                $account[] = $val['alr_mobile'];
            }
        }
        return $account;
    }

    /*
     * 获取该公司的所有管理员
     */
    private function _get_enter_shop_manager($esid){
        $manager_model = new App_Model_Entershop_MysqlManagerStorage();
        $list = $manager_model->findManagerEsid($this->sid,$esid);
        $account = array();
        if(!empty($list)){
            foreach($list as $val){
                $account[] = 'entershop_'.$val['esm_mobile'];
            }
        }
        return $account;
    }

}