<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/3/10
 * Time: 下午4:29
 */
class App_Model_Point_MysqlPointQueueStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    private $curr_table;

    public function __construct($sid = null) {
        parent::__construct();
        $this->_table   = 'point_queue';
        $this->_pk      = 'pq_id';
        $this->_shopId  = 'pq_s_id';

        $this->sid      = $sid;
        $this->curr_table   = DB::table($this->_table);
    }

    public function getMemberList($where,$index,$count,$sort){
        $sql  = 'SELECT pq.*,m_nickname ';
        $sql .= ' FROM '.DB::table($this->_table).' pq ';
        $sql .= ' LEFT JOIN pre_member m on m_id=pq_m_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $ret  = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getMemberCount($where){
        $sql  = 'SELECT count(*) ';
        $sql .= ' FROM '.DB::table($this->_table).' pq ';
        $sql .= ' LEFT JOIN pre_member m on m_id=pq_m_id ';
        $sql .= $this->formatWhereSql($where);

        $ret  = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /*
     * 根据订单编号获取返还队列
     */
    public function getUpdateListByTid($tid, $data = null) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'pq_tid', 'oper' => '=', 'value' => $tid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getList($where, 0, 0);
        }
    }

    /*
     * 获取会员待返积分
     */
    public function getRunSum($mid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'pq_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'pq_status', 'oper' => '=', 'value' => 0);//待返还

        $sql    = "SELECT sum(`pq_total_point`) as total, sum(`pq_back_point`) as back FROM `{$this->curr_table}` ";
        $sql    .= $this->formatWhereSql($where);

        $ret  = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /*
     * 获取订单返回积分队列数量
     */
    public function fetchTradeBackNum($mid, $tid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'pq_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'pq_tid', 'oper' => '=', 'value' => $tid);

        return $this->getCount($where);
    }
}