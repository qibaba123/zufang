<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/3/1
 * Time: 下午2:10
 */
class App_Model_Point_MysqlPointMemberStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    private $member_table;
    private $curr_table;

    public function __construct($sid = null) {
        parent::__construct();
        $this->_table   = 'line_member';
        $this->_pk      = 'lm_id';
        $this->_shopId  = 'lm_s_id';
        $this->member_table = DB::table('member');
        $this->curr_table   = DB::table($this->_table);

        $this->sid      = $sid;
    }

    /**
     * 获取公排会员信息
     */
    public function getLineMemberList($where,$index,$count,$sort = null){
        $sql = 'SELECT * ';
        $sql .= ' FROM '.DB::table($this->_table) . ' lm ';
        $sql .= ' LEFT JOIN '.$this->member_table.' m on m.m_id = lm.lm_m_id ';
        $sql .= $this->formatWhereSql($where);
        if ($sort) {
            $sql .= $this->getSqlSort($sort);
        }
        $sql .= $this->formatLimitSql($index,$count);

        $ret  = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取公排会员总数
     */
    public function getLineMemberCount($where){
        $sql = 'SELECT count(*) ';
        $sql .= ' FROM '.DB::table($this->_table) . ' lm ';
        $sql .= ' LEFT JOIN '.$this->member_table.' m on m.m_id = lm.lm_m_id ';
        $sql .= $this->formatWhereSql($where);

        $ret  = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获取队列中第一个未出队人员
     */
    public function findQueueFirst() {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'lm_status', 'oper' => '=', 'value' => 0);//排队中

        $sort   = array('lm_line' => 'ASC');

        $list   = $this->getList($where, 0, 1, $sort);

        return $list ? $list[0] : null;
    }
    /*
     * 插入排队会员
     */
    public function insertQueueMember($mid) {
        $sql    = "SELECT max(`lm_line`) as curr_max FROM `{$this->curr_table}` WHERE `lm_s_id`=".$this->sid;
        $max    = DB::result_first($sql);

        $max    = $max ? $max+1 : 1;
        $indata = array(
            'lm_s_id'       => $this->sid,
            'lm_m_id'       => $mid,
            'lm_line'       => $max,
            'lm_status'     => 0,
            'lm_create_time'=> time(),
        );
        return $this->insertValue($indata);
    }

    /*
     * 获取排队中的会员列表
     */
    public function getQueueList($type = 0, $mid = null, $index = 0, $count = 20) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if ($type >= 0) {
            $where[]    = array('name' => 'lm_status', 'oper' => '=', 'value' => $type);//排队中
        } else {
            $where[]    = array('name' => 'lm_m_id', 'oper' => '=', 'value' => $mid);
        }
        $sort   = array('lm_line' => 'ASC');

        $sql    = "SELECT lm.*,m.m_nickname FROM `{$this->curr_table}` AS lm ";
        $sql    .= "LEFT JOIN `{$this->member_table}` AS m ON lm.lm_m_id=m.m_id ";
        $sql    .= $this->formatWhereSql($where);
        $sql    .= $this->getSqlSort($sort);
        $sql    .= $this->formatLimitSql($index, $count);

        $ret  = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}