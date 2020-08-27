<?php

class App_Model_Giftcard_MysqlGiftCardBuyStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    public function __construct($sid){
        $this->_table 	= 'applet_gift_card_buy';
        $this->_pk 		= 'agcb_id';
        $this->_shopId 	= 'agcb_s_id';

        parent::__construct();

        $this->sid = $sid;
    }

    /*
     * 增减卡内金额
     */
    public function incrementCoin($id, $money) {
        $field  = array('agcb_coin');
        $inc    = array($money);
        $where[]    = array('name' => 'agcb_id', 'oper' => '=', 'value' => $id);
        $where[]    = array('name' => 'agcb_s_id', 'oper' => '=', 'value' => $this->sid);
        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    /*
     *
     */
    public function findUpdateCardByNumber($number, $data = null) {
        $where[]    = array('name' => 'agcb_number', 'oper' => '=', 'value' => $number);
        if($this->sid){
            $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        }
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /**
     * 批量插入分类使用
     * @param array $val_arr
     * @return bool
     */
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`agcb_id`, `agcb_s_id`,`agcb_card_id`,`agcb_buy_mid`,`agcb_use_mid`,`agcb_name`,`agcb_cover`,`agcb_gift_cover`,`agcb_type`,`agcb_coin`,`agcb_number`,`agcb_status`,`agcb_tid`,`agcb_store_id`,`agcb_create_time`,`agcb_update_time`) ';
            $sql .= ' VALUES ';
            $sql .= implode(',',$val_arr);
            $ret = DB::query($sql);

            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
        }
        return $ret;
    }

    public function getCardTradeList($where,$index,$count,$sort){
        $sql  = "SELECT agcb.*,agct.agct_m_nickname,agct.agct_m_avatar ";
        $sql .= ' FROM '.DB::table($this->_table).' agcb ';
        $sql .= ' LEFT JOIN pre_applet_gift_card_trade agct on agct.agct_tid = agcb.agcb_tid ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getCardTradeCount($where){
        $sql  = "SELECT count(*) ";
        $sql .= ' FROM '.DB::table($this->_table).' agcb ';
        $sql .= ' LEFT JOIN pre_applet_gift_card_trade agct on agct.agct_tid = agcb.agcb_tid ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


}