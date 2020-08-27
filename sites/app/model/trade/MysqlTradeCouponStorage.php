<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/9/25
 * Time: 上午11:52
 */
class App_Model_Trade_MysqlTradeCouponStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    public function __construct($sid){
        $this->_table 	= 'trade_coupon';
        $this->_pk 		= 'tc_id';
        $this->_shopId 	= 'tc_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }

    /*
     * 通过订单编号查找优惠券使用
     */
    public function findCouponByTid($tid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'tc_tid', 'oper' => '=', 'value' => $tid);

        return $this->getRow($where);
    }

    public function getListByTid($tid){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'tc_tid', 'oper' => '=', 'value' => $tid);

        return $this->getList($where);

    }
}