<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/9/20
 * Time: 下午8:48
 */
class App_Model_Cash_MysqlRecordStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    private $member_table;
    private $store_table;
    private $trade_inout_table;
    private $enter_shop_table;

    public function __construct($sid='') {
        parent::__construct();
        $this->_table   = 'cash_record';
        $this->_pk      = 'cr_id';
        $this->_shopId  = 'cr_s_id';

        $this->sid      = $sid;
        $this->member_table  = DB::table('member');
        $this->store_table   = DB::table('offline_store');
        $this->trade_inout_table = DB::table('face_trade_inout');
        $this->enter_shop_table  = DB::table('enter_shop');

    }





    /*
     * 通过订单id获取订单
     */
    public function findUpdateTradeByTid($tid, $data = null) {
        $where[]    = array('name' => 'cr_tid', 'oper' => '=', 'value' => $tid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /**
     * 统计数量和金额
     */
    public function findCashRecordMemberStorageSum($where){
        $sql  = "select count(*) as total, sum(cr_money) as money ";//【wqx】
        $sql .= " from `".DB::table($this->_table)."` cr ";
        $sql .= " left join ".$this->member_table." m on m.m_id = cr.cr_m_id ";
        $sql .= " left join ".$this->store_table." as os on os.os_id = cr.cr_os_id ";
        //$sql .= " left join ".$this->trade_inout_table." as fti on cr.cr_tid = fti.fti_tid "; //【wqx】
        $sql .= $this->formatWhereSql($where);

        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }





    /**
     * 获取收款会员信息
     */
    public function findCashRecordMemberStorage($where,$index,$count,$sort){
        $sql = "select * ";
        $sql .= " from `".DB::table($this->_table)."` cr ";
        $sql .= " left join ".$this->member_table." m on m.m_id = cr.cr_m_id ";
        $sql .= " left join ".$this->store_table." as os on os.os_id = cr.cr_os_id ";
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
    public function findCashRecordMemberStorageCount($where){
        $sql = "select count(*) ";
        $sql .= " from `".DB::table($this->_table)."` cr ";
        $sql .= " left join ".$this->member_table." m on m.m_id = cr.cr_m_id ";
        $sql .= " left join ".$this->store_table." as os on os.os_id = cr.cr_os_id ";
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    /**
     * 获取收款会员信息
     */
    public function findCashRecordMember($where,$index,$count,$sort, $test=0){
        $sql = "select cr.*, m.*, tr.t_pay_trade_no ,ma.m_nickname as ma_nickname  ";
        $sql .= " from `".DB::table($this->_table)."` cr ";
        $sql .= " left join ".$this->member_table." m on m.m_id = cr.cr_m_id ";
        $sql .= " left join `pre_trade` tr on tr.t_tid=cr.cr_tid ";
        $sql .= " left Join `pre_manager` ma on ma.m_id = cr.cr_uid ";

        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        if($test) return $sql;

        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    public function findCashRecordMemberCount($where){
        $sql = "select count(*) ";
        $sql .= " from `".DB::table($this->_table)."` cr ";
        $sql .= " left join ".$this->member_table." m on m.m_id = cr.cr_m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取收款会员信息
     */
    public function findCashRecordMemberShop($where,$index,$count,$sort){
        $sql = "select cr.*,m.*,es.es_name,tr.t_pay_trade_no ,ma.m_nickname as ma_nickname ";
        $sql .= " from `".DB::table($this->_table)."` cr ";
        $sql .= " left join ".$this->member_table." m on m.m_id = cr.cr_m_id ";
        $sql .= " left join ".$this->enter_shop_table." es on es.es_id = cr.cr_es_id ";
        $sql .= " left join `pre_trade` tr on tr.t_tid=cr.cr_tid ";
        $sql .= " left Join `pre_manager` ma on ma.m_id = cr.cr_uid ";
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
    public function findCashRecordMemberCountShop($where){
        $sql = "select count(*) ";
        $sql .= " from `".DB::table($this->_table)."` cr ";
        $sql .= " left join ".$this->member_table." m on m.m_id = cr.cr_m_id ";
        $sql .= " left join ".$this->enter_shop_table." es on es.es_id = cr.cr_es_id ";
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 根据店铺获得总收入
     */
    public function getSumMoneyAction($where,$today = false){
        if($today){
            $date = strtotime(date('Y-m-d',time()));
            $where[] = array('name'=>'cr_pay_time','oper'=>'>','value'=>$date);//当天
        }
        $where[] = array('name'=>'cr_isrefund','oper'=>'=','value'=>0);//未退款
        $sql = "select SUM(cr_money) ";
        $sql .= " from `".DB::table($this->_table)."` cr ";
        $sql .= " left join ".$this->member_table." m on m.m_id = cr.cr_m_id ";
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    /*
     * 根据店铺获得总收入
     */
    public function getSumInfo($where,$today = false){
        if($today){
            $date = strtotime(date('Y-m-d',time()));
            $where[] = array('name'=>'cr_pay_time','oper'=>'>','value'=>$date);//当天
        }
//        $where[] = array('name'=>'cr_isrefund','oper'=>'=','value'=>0);//未退款
        $sql = "select SUM(cr_money) as money,count(cr_id) as total, sum(cr_refund_money) as refund ";
        $sql .= " from `".DB::table($this->_table)."` cr ";
        $sql .= " left join ".$this->member_table." m on m.m_id = cr.cr_m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 根据店铺获得总收入
     */
    public function getSumInfoMember($where,$today = false){
        if($today){
            $date = strtotime(date('Y-m-d'));
            $where[] = array('name'=>'cr_pay_time','oper'=>'>','value'=>$date);//当天
        }
        $where[] = array('name'=>'cr_isrefund','oper'=>'=','value'=>0);//未退款
        $sql = "select SUM(cr_money) as money,count(cr_id) as total ";
        $sql .= " from `".DB::table($this->_table)."` cr ";
        $sql .= " left join ".$this->member_table." m on m.m_id = cr.cr_m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function fetchCashierProfitGroupByDate($where){
        $sql  = 'SELECT sum(cr_money) as total, FROM_UNIXTIME (`cr_pay_time`,"%m/%d") AS curr_date ';
        $sql .= ' FROM '.DB::table($this->_table);
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY curr_date ';
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function fetchCashierProfitGroupByTime($where){
        $sql  = 'SELECT sum(cr_money) as total, FROM_UNIXTIME (`cr_pay_time`,"%H") AS curr_date ';
        $sql .= ' FROM '.DB::table($this->_table);
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY curr_date ';
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /**
     * 收银台统计 按支付方式汇总数据
     */
    public function fetchCashierMoneyData($where){
        $sql  = 'SELECT sum(cr_money) as total,sum(cr_refund_money) as refund,sum(cr_balance) as balance,cr_pay_type as ptype ';
        $sql .= ' FROM '.DB::table($this->_table);
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY cr_pay_type ';
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param array $where
     * @param int $index
     * @param int $count
     * @param array $sort
     * @return array|bool
     * 收银台代理商
     */
    public function getFaceTradeList($where=array(), $index=0, $count=0, $sort= array()) {

        $sql = "Select * From   ".DB::table($this->_table);
        $sql.= " Left Join {$this->trade_inout_table} ";
        $sql.= " ON cr_tid = fti_tid ";
        $sql.= ' Left Join `pre_cash_bind_record` cbr ON cbr.cbr_bind_code=cr_code ';
        $sql.= $this->formatWhereSql($where);
        $sql.= $this->getSqlSort($sort);
        $sql.= $this->formatLimitSql($index, $count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    //代理商获取订单统计
    public function getFaceTradeCount($where=array(), $test=0) {
        $sql = "Select count(*) as total , sum(fti_total_money) as fee, sum(cr_money) as cr_fee  ";
        $sql.= ' From `'.DB::table($this->_table).'`';
        $sql.= " Left Join {$this->trade_inout_table} ";
        $sql.= " ON cr_tid = fti_tid ";
        $sql.= ' Left Join `pre_cash_bind_record` cbr ON cbr.cbr_bind_code=cr_code ';
        $sql.= $this->formatWhereSql($where);

        if($test) {
            return $sql;
        }

        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getFaceTradeInoutList($where=array(), $index=0, $count=0, $sort= array(), $test=0) {
        $sql = "Select *";
        $sql.= " From {$this->trade_inout_table}  ";
        $sql.= " Left Join `".DB::table($this->_table)."`";
        $sql.= " ON cr_tid = fti_tid ";
//        $sql.= ' Left Join `pre_cash_bind_record` cbr ON cbr.cbr_bind_code=cr_code ';
        $sql.= $this->formatWhereSql($where);
        $sql.= $this->getSqlSort($sort);
        $sql.= $this->formatLimitSql($index, $count);

        if($test) {
            return $sql;
        }

        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    public function getFaceTradeInoutCount($where=array(), $test=0) {
        $sql = "Select count(*) as total , sum(fti_total_money) as fee, sum(cr_money) as cr_fee  ";
        $sql.= " From {$this->trade_inout_table}  ";
        $sql.= " Left Join `".DB::table($this->_table)."`";
        $sql.= " ON cr_tid = fti_tid ";
//        $sql.= ' Left Join `pre_cash_bind_record` cbr ON cbr.cbr_bind_code=cr_code ';
        $sql.= $this->formatWhereSql($where);

        if($test) {
            return $sql;
        }

        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }



}