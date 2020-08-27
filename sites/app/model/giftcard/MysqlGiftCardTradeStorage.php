<?php

class App_Model_Giftcard_MysqlGiftCardTradeStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_gift_card_trade';
        $this->_pk = 'agct_id';
        $this->_shopId = 'agct_s_id';

        $this->sid = $sid;
    }

    /*
     * 通过订单id获取订单
     */
    public function findUpdateTradeByTid($tid, $data = null) {
        $where[]    = array('name' => 'agct_tid', 'oper' => '=', 'value' => $tid);
        if($this->sid){
            $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        }
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }


}