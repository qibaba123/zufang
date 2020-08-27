<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/11/8
 * Time: 下午3:48
 */
class App_Model_Trade_MysqlTradeFullStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    public function __construct($sid){
        $this->_table 	= 'trade_full';
        $this->_pk 		= 'tf_id';
        $this->_shopId 	= 'tf_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }

    public function getListByTid($tid){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'tf_tid', 'oper' => '=', 'value' => $tid);
        return $this->getList($where);
    }

    /*
	 * 获得统计信息
	 */
    public function getStatInfoAction($where){
        $sql  = 'SELECT count(tf_id) as total,sum(tf_discount_fee) as money ';
        $sql .= ' FROM '.DB::table($this->_table).' ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }



}