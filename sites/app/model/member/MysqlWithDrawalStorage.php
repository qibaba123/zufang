<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/3/30
 * Time: 上午7:58
 */
class App_Model_Member_MysqlWithDrawalStorage extends Libs_Mvc_Model_BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table   = 'withdrawal';
        $this->_pk      = 'wd_id';
        $this->_shopId  = 'wd_s_id';
    }

    //获取统计信息
    public function getAllCount($where){
        $sql  = ' select count(*) mycount,sum(wd_money) mymoney from pre_withdrawal ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        return $ret;
    }

    public function getMemberList($where, $index = 0, $count = 20, $sort = array()) {
        $sql = 'select wd.*,m_nickname,m_traded_num ,m_traded_money ,m_sale_amount,m_deduct_amount,m_deduct_ktx ,m_deduct_ytx,m_deduct_dsh,m_deduct_amount';
        $sql .= ' from `'.DB::table($this->_table).'` wd ';
        $sql .= ' left join `pre_member` m on m.m_id = wd.wd_m_id ';
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

    public function getMemberCount($where){
        $sql = 'select count(*) ';
        $sql .= ' from `'.DB::table($this->_table).'` wd ';
        $sql .= ' left join `pre_member` m on m.m_id = wd.wd_m_id ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getLastHistory($type,$sid, $uid){
        $uid = $uid > 0 ? $uid : 0;
        $sql = 'select * ';
        $sql .= ' from `'.DB::table($this->_table).'` ';
        $sql .= ' where wd_create_time=(select max(wd_create_time) from `'.DB::table($this->_table).'` where wd_type='.$type.' and wd_s_id='.$sid.' and wd_m_id='.$uid.') and wd_type='.$type.' and wd_s_id='.$sid.' and wd_m_id='.$uid;
        $row = DB::fetch_first($sql);
        if ($row === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $row;
    }
    //答题含有币种类型专用
    public function getMemberCurrencyList($where, $index = 0, $count = 20, $sort = array()) {
        $sql = 'select wd.*,m_nickname,m_traded_num ,m_traded_money ,m_sale_amount,m_deduct_amount,m_deduct_ktx ,m_deduct_ytx,m_deduct_dsh,m_deduct_amount,acc_name,acc_id,aca_ktx,aca_ytx,aca_dsh';
        $sql .= ' from `'.DB::table($this->_table).'` wd ';
        $sql .= ' left join `pre_member` m on m.m_id = wd.wd_m_id ';
        $sql .= ' left join `pre_applet_city_currency` acc on acc.acc_id = wd.wd_acc_id && acc.acc_s_id = wd.wd_s_id ';
        $sql .= ' left join `pre_applet_city_account` aca on aca.aca_m_id = wd.wd_m_id && aca.aca_acc_id = wd.wd_acc_id && aca.aca_s_id = wd.wd_s_id';
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

    /**
     * @param $where
     * @param int $index
     * @param int $count
     * @param array $sort
     * @return array|bool
     * 获取列表同时，获得币种
     */
    public function getListShowCurrencyAction($where, $index = 0, $count = 20, $sort = array()){
        $sql = 'select wd.*,acc_name';
        $sql .= ' from `'.DB::table($this->_table).'` wd ';
        $sql .= ' left join `pre_applet_city_currency` acc on acc.acc_id = wd.wd_acc_id';
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

    public function getStatInfo($where){
        $sql = 'select count(*) as total,sum(wd_real_money) as money ';
        $sql .= ' from `'.DB::table($this->_table).'` ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}