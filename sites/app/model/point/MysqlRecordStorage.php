<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/3/6
 * Time: 上午11:18
 */
class App_Model_Point_MysqlRecordStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    private $member_table;
    private $curr_table;
    private $trade_table;

    public function __construct($sid = null) {
        parent::__construct();
        $this->_table   = 'point_record';
        $this->_pk      = 'pr_id';
        $this->_shopId  = 'pr_s_id';
        $this->member_table = DB::table('member');
        $this->curr_table   = DB::table($this->_table);
        $this->trade_table  = DB::table('trade');

        $this->sid      = $sid;
    }
    /*
     * 获取会员已兑换的商品数量
     */
    public function fetchMemberHadExchange($mid, $actid, $gid) {
        $where[]= array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]= array('name' => 'pr_m_id', 'oper' => '=', 'value' => $mid);
        $where[]= array('name' => 'pr_actid', 'oper' => '=', 'value' => $actid);
        $where[]= array('name' => 'pr_g_id', 'oper' => '=', 'value' => $gid);
        $where[]= array('name' => 'pr_status', 'oper' => '<', 'value' => 2);//兑换中,兑换成功,均记录

        $sql    = "SELECT SUM(pr_num) AS hadbuy FROM {$this->curr_table} ";
        $sql    .= $this->formatWhereSql($where);

        return DB::fetch_first($sql);
    }
    
    public function findRecordByTid($tid, $data = null) {
        $where[]= array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]= array('name' => 'pr_tid', 'oper' => '=', 'value' => $tid);
        
        if ($data) {
            return $this->updateValue($data, $where);   
        }
        return $this->getRow($where);
    }
    /*
     * 获取会员兑换记录数量
     */
    public function findMemberCount($mid, $type = -1) {
        $where[]= array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]= array('name' => 'pr_m_id', 'oper' => '=', 'value' => $mid);
        if ($type >= 0) {
            $where[]= array('name' => 'pr_status', 'oper' => '=', 'value' => $type);
        }
        return $this->getCount($where);
    }
    /*
     * 获取会员兑换记录列表
     */
    public function findMemberList($mid, $type = -1, $index = 0, $count = 20) {
        $where[]= array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]= array('name' => 'pr_m_id', 'oper' => '=', 'value' => $mid);
        if ($type >= 0) {
            $where[]= array('name' => 'pr_status', 'oper' => '=', 'value' => $type);
        }
        $sort   = array('pr_create_time' => 'DESC');

        $sql    = "SELECT pr.*,t.* FROM `{$this->curr_table}` AS pr ";
        $sql    .= "LEFT JOIN `{$this->trade_table}` AS t ON pr.pr_tid=t.t_tid ";
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
}