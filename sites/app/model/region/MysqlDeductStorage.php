<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/9/5
 * Time: 下午3:09
 */
class App_Model_Region_MysqlDeductStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id
    private $trade_table = '';
    private $curr_table;
    private $mem_table;

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'region_deduct';
        $this->_pk      = 'rd_id';
        $this->_shopId  = 'rd_s_id';

        $this->sid      = $sid;
        $this->trade_table = DB::table('trade');
        $this->curr_table   = DB::table($this->_table);
        $this->mem_table    = DB::table('member');
    }
    /*
     * 通过订单号获取佣金分配
     */
    public function fetchDeductByTid($tid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'rd_tid', 'oper' => '=', 'value' => $tid);

        return $this->getRow($where);
    }

    public function getTradeCount($where){
        $sql  = 'select count(*) ';
        $sql .= ' from `'.DB::table($this->_table).'` rd ';
        $sql .= ' left join '.$this->trade_table.' t on t.t_tid = rd.rd_tid ';
        $sql .= $this->formatWhereSql($where);

        $ret  = DB::result_first($sql, array());
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    public function getTradeList($where, $index, $count, $sort){
        $sql  = 'select rd.*,t_title,t_buyer_nick,t_pic,t_total_fee,t_payment ';
        $sql .= ' from `'.DB::table($this->_table).'` rd ';
        $sql .= ' left join '.$this->trade_table.' t on t.t_tid = rd.rd_tid ';
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
    /*
     * 获取代理的统计分析数据
     */
    public function getAnalysisData($rgid, $level) {
        $rgid   = intval($rgid);
        $map    = array(1 => 'p', 2 => 's', 3 => 'z');
        $money_n= "rd_{$map[$level]}_money";

        $rgid_n = "rd_{$map[$level]}_rid";
        //首先获取待发分红
        $sql0   = "SELECT sum(`rd_sale_amount`) as sale0, sum(`{$money_n}`) as deduct0 FROM `{$this->curr_table}` WHERE `{$rgid_n}`={$rgid} AND `rd_status`=0";
        $ret0   = DB::fetch_first($sql0);
        //获取已发分红
        $sql1   = "SELECT sum(`rd_sale_amount`) as sale1, sum(`{$money_n}`) as deduct1 FROM `{$this->curr_table}` WHERE `{$rgid_n}`={$rgid} AND `rd_status`=1";
        $ret1   = DB::fetch_first($sql1);
        //获取收回分红
        $sql2   = "SELECT sum(`{$money_n}`) as deduct2 FROM `{$this->curr_table}` WHERE `{$rgid_n}`={$rgid} AND `rd_status`=2";
        $ret2   = DB::fetch_first($sql2);

        return  array(
            'sales' => floatval($ret0['sale0'])+floatval($ret1['sale1']),//总销售额
            'ready' => floatval($ret0['deduct0']),//待发分红
            'had'   => floatval($ret1['deduct1']),//已发分红
            'back'  => floatval($ret2['deduct2']),//收回分红
        );
    }
    /*
     * 获取代理商区域订单列表
     */
    public function fetchRegionDeductList($rgid, $level, $type = -1, $index = 0, $count = 20) {
        $rgid   = intval($rgid);
        $map    = array(1 => 'p', 2 => 's', 3 => 'z');
        $rgid_n = "rd_{$map[$level]}_rid";

        $type       = intval($type);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => $rgid_n, 'oper' => '=', 'value' => $rgid);
        if ($type >= 0) {
            $where[]    = array('name' => 'rd_status', 'oper' => '=', 'value' => $type);
        }
        $sort       = array('rd_create_time' => 'DESC');

        $sql    = "SELECT rd.*,m.m_avatar FROM `{$this->curr_table}` AS rd ";
        $sql    .= "LEFT JOIN `{$this->mem_table}` AS m ON rd.rd_m_id=m.m_id ";

        $sql    .= $this->formatWhereSql($where);
        $sql    .= $this->getSqlSort($sort);
        $sql    .= $this->formatLimitSql($index, $count);

        $ret    = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /*
     * 获取代理商区域订单数量
     */
    public function fetchRegionDeductCount($rgid, $level, $type = -1) {
        $rgid   = intval($rgid);
        $map    = array(1 => 'p', 2 => 's', 3 => 'z');
        $rgid_n = "rd_{$map[$level]}_rid";

        $type       = intval($type);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => $rgid_n, 'oper' => '=', 'value' => $rgid);

        if ($type >= 0) {
            $where[]    = array('name' => 'rd_status', 'oper' => '=', 'value' => $type);
        }

        $ret    = $this->getCount($where);
        return $ret;
    }
}