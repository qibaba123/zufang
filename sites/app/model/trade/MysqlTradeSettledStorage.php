<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/8/3
 * Time: 下午3:10
 */
class App_Model_Trade_MysqlTradeSettledStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;


    public function __construct($sid){
        $this->_table 	= 'trade_settled';
        $this->_pk 		= 'ts_id';
        $this->_shopId 	= 'ts_s_id';
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
        $where[]    = array('name' => 'ts_tid', 'oper' => '=', 'value' => $tid);

        return $this->getRow($where);
    }

    /**
     * @return bool
     * 统计单店铺待结算总额
     */
    public function statisticNoSettled(){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ts_status', 'oper' => '=', 'value' => 0);

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

    /**
     * @return bool
     * 统计单店铺待结算总额
     */
    public function statisticEnterShopNoSettled(){
        $where      = array();
        $where[]    = array('name' => 'ts_es_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ts_status', 'oper' => '=', 'value' => 0);

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

    /**
     * 入驻店铺
     * @param int $day 查询天数
     * @param int $type 1收入 2支出
     * @return bool
     */
    public function getEnterSumAmountByDay($day=7){
        $where      = array();
        $where[]    = array('name' => 'ts_es_id', 'oper' => '=', 'value' => $this->sid);
        $time       = strtotime(date('Y-m-d',time())) - ($day-1) * 86400;
        $where[]    = array('name' => 'ts_order_finish_time', 'oper' => '>=', 'value' => $time);
        $where[]    = array('name' => 'ts_status', 'oper' => '=', 'value' => 0);

        $sql = 'SELECT SUM(ts_amount) ';
        $sql .= ' FROM `'.DB::table($this->_table).'` ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getSettleTrade($where,$index,$count,$sort){
        $sql  = 'SELECT ts.*,t.t_express_method,t.t_post_fee ';
        $sql .= ' FROM `'.DB::table($this->_table).'` ts ';
        $sql .= ' LEFT JOIN pre_trade t on t.t_tid = ts.ts_tid ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $ret  = DB::fetch_all($sql, array());
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

}