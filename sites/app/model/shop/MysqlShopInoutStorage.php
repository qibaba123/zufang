<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/8/3
 * Time: 下午12:00
 */
class App_Model_Shop_MysqlShopInoutStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'shop_inout';
        $this->_pk      = 'si_id';
        $this->_shopId  = 'si_s_id';
        $this->sid      = $sid;
    }

    /**
     * @param int $day 查询天数
     * @param int $type 1收入 2支出
     * @return bool
     */
    public function getSumAmountByDay($day=7,$type = 1){

        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $time       = strtotime(date('Y-m-d',time())) - ($day-1) * 86400;
        $where[]    = array('name' => 'si_create_time', 'oper' => '>=', 'value' => $time);
        $where[]    = array('name' => 'si_type', 'oper' => '=', 'value' => $type);

        $sql = 'SELECT SUM(si_amount) ';
        $sql .= ' FROM `pre_shop_inout` ';
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
    public function getEnterSumAmountByDay($day=7,$type = 1){

        $where      = array();
        $where[]    = array('name' => 'si_es_id', 'oper' => '=', 'value' => $this->sid);
        $time       = strtotime(date('Y-m-d',time())) - ($day-1) * 86400;
        $where[]    = array('name' => 'si_create_time', 'oper' => '>=', 'value' => $time);
        $where[]    = array('name' => 'si_type', 'oper' => '=', 'value' => $type);
        $where[]    = array('name' => 'si_name', 'oper' => '!=', 'value' => '账户提现');

        $sql = 'SELECT SUM(si_amount) ';
        $sql .= ' FROM `pre_shop_inout` ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    /**
     * @param $where
     * @param $index
     * @param $count
     * @param $sort
     * @return array|bool
     * 查询店铺信息及收支记录信息
     */
    public function getShopInout($where,$index,$count,$sort){
        $sql  = 'SELECT si.* , s_name ';
        $sql .= ' FROM `'.DB::table($this->_table).'` si ';
        $sql .= ' LEFT JOIN pre_shop s on s_id = si_s_id ';
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

    /**
     * @param $where
     * @return bool
     * 查询收支记录总数
     */
    public function getShopInoutCount($where){
        $sql  = 'SELECT count(*) ';
        $sql .= ' FROM `'.DB::table($this->_table).'` si ';
        $sql .= ' LEFT JOIN pre_shop s on s_id = si_s_id ';
        $sql .= $this->formatWhereSql($where);

        $ret  = DB::result_first($sql, array());
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getInoutRowByTid($tid,$type){
        $where      = array();
        $where[]    = array('name' => 'si_es_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'si_type', 'oper' => '=', 'value' => $type);
        $where[]    = array('name' => 'si_tid', 'oper' => '=', 'value' => $tid);
        return $this->getRow($where);
    }



    public function getInoutTrade($where,$index,$count,$sort){
        $sql  = 'SELECT si.*,t.t_express_method,t.t_post_fee ';
        $sql .= ' FROM `'.DB::table($this->_table).'` si ';
        $sql .= ' LEFT JOIN pre_trade t on t.t_tid = si.si_tid ';
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

    /**
     * @param int $day 查询天数
     * @param int $type 1收入 2支出
     * @return bool
     */
    public function getSumOutAmount($esid){
        $where      = array();
        $where[]    = array('name' => 'si_es_id', 'oper' => '=', 'value' => $esid);
        $where[]    = array('name' => 'si_name', 'oper' => 'like', 'value' => "订单入账手续费%");
        $where[]    = array('name' => 'si_type', 'oper' => '=', 'value' => 2);

        $sql = 'SELECT SUM(si_amount) ';
        $sql .= ' FROM `pre_shop_inout` ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

}