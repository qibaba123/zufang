<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/8/17
 * Time: 上午10:39
 */
class App_Model_Auction_MysqlAuctionPayBalanceStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id

    public function __construct($sid=0)
    {
        parent::__construct();
        $this->_table  = 'applet_auction_pay_balance';
        $this->_pk     = 'aapb_id';
        $this->_shopId = 'aapb_s_id';

        $this->sid     = $sid;
    }

    /*
      * 通过店铺id和订单编号获取帖子信息
      */
    public function findUpdateByNumber($number,$data=null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'aapb_number', 'oper' => '=', 'value' => $number);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }



}