<?php

class App_Model_Handy_MysqlHandyRiderDepositStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_handy_rider_deposit';
        $this->_pk     = 'ahrd_id';
        $this->_shopId = 'ahrd_s_id';
        $this->sid     = $sid;
    }

    /*
     * 通过订单id获取订单
     */
    public function findUpdateTradeByTid($tid, $data = null) {
        $where[]    = array('name' => 'ahrd_tid', 'oper' => '=', 'value' => $tid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }




}