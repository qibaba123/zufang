<?php
/*
 *
 */
class App_Model_Merchant_MysqlMerchantTradeSettledStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;


    public function __construct($sid){
        $this->_table 	= 'merchant_trade_settled';
        $this->_pk 		= 'mts_id';
        $this->_shopId 	= 'mts_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }

    public function findUpdateSettled($tsid, $data = null) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $tsid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /*
     * 通过订单号获取待结算交易
     */
    public function findSettledByTid($tid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'mts_tid', 'oper' => '=', 'value' => $tid);

        return $this->getRow($where);
    }

    /**
     * @return bool
     * 统计单店铺待结算总额
     */
    public function statisticNoSettled(){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'mts_status', 'oper' => '=', 'value' => 0);

        $sql  = 'SELECT SUM(ts_amount)';
        $sql .= ' FROM `'.DB::table($this->_table).'` ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


}