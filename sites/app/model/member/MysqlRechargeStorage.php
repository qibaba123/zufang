<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/5/27
 * Time: 下午3:44
 */
class App_Model_Member_MysqlRechargeStorage extends Libs_Mvc_Model_BaseModel {
    private $sid;
    private $member_table='';
    private $manager_table;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'recharge_record';
        $this->_pk      = 'rr_id';
        $this->_shopId  = 'rr_s_id';
        $this->sid      = $sid;
        $this->member_table = DB::table('member');
        $this->manager_table = DB::table('manager');
    }

    /*
     * 通过订单ID查找充值记录
     */
    public function findRecordByTid($tid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'rr_tid', 'oper' => '=', 'value' => $tid);

        return $this->getRow($where);
    }

    /**
     * @param $where
     * @param $index
     * @param $count
     * @param $sort
     * @return array|bool
     */
    public function getMemberList($where,$index,$count,$sort){
        $sql = 'SELECT r.*,m.*,ma.m_mobile as manager_mobile,ma.m_id as manager_id,ma.m_nickname as  manager_name  ';
        $sql .= ' FROM '.DB::table($this->_table).' r ';
        $sql .= ' LEFT JOIN '.$this->member_table.' m ON m.m_id=r.rr_m_id';
        $sql .= ' LEFT JOIN '.$this->manager_table.' ma ON ma.m_id=r.rr_manager_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $row = DB::fetch_all($sql);
        if ($row === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $row;
    }

    public function getMemberListNew($where,$index,$count,$sort){
        $sql = 'SELECT r.*,m.m_avatar,m.m_nickname ';
        $sql .= ' FROM '.DB::table($this->_table).' r ';
        $sql .= ' LEFT JOIN '.$this->member_table.' m ON m.m_id=r.rr_m_id';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $row = DB::fetch_all($sql);
        if ($row === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $row;
    }

    public function getMemberCount($where){
        $sql = 'SELECT count(*)  ';
        $sql .= ' FROM '.DB::table($this->_table).' r ';
        $sql .= ' LEFT JOIN '.$this->member_table.' m ON m.m_id=r.rr_m_id';
        $sql .= ' LEFT JOIN '.$this->manager_table.' ma ON ma.m_id=r.rr_manager_id ';
        $sql .= $this->formatWhereSql($where);

        $row = DB::result_first($sql);
        if ($row === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $row;
    }

    public function getMemberRow($id){
        $where[] = array('name' => 'rr_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'rr_id', 'oper' => '=', 'value' => $id);
        $sql = 'SELECT r.*,m.*,ma.m_mobile as manager_mobile,ma.m_id as manager_id,ma.m_nickname as  manager_name  ';
        $sql .= ' FROM '.DB::table($this->_table).' r ';
        $sql .= ' LEFT JOIN '.$this->member_table.' m ON m.m_id=r.rr_m_id';
        $sql .= ' LEFT JOIN '.$this->manager_table.' ma ON ma.m_id=r.rr_manager_id ';
        $sql .= $this->formatWhereSql($where);
        $row = DB::fetch_first($sql);
        if ($row === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $row;
    }


    /*
     * 批量添加记录
     */
    public function batchData($insert){
         $ret = false;
        if(is_array($insert) && !empty($insert)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`rr_id`, `rr_s_id`, `rr_m_id`, `rr_amount`, `rr_gold_coin`, `rr_status` , `rr_pay_type`, `rr_remark` ,`rr_manager_id` , `rr_create_time`) ';
            $sql .= ' VALUES ';
            $sql .= implode(',',$insert);
            $ret = DB::query($sql);

            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
        }
        return $ret;
    }

    /*
     * 统计支付金额
     */
    public function getAmountSumAction($where,$today = false){
        if($today){
            $date = strtotime(date('Y-m-d',time()));
            $where[] = array('name' => 'rr_create_time', 'oper' => '>', 'value' => $date);
        }
        $sql = "SELECT sum(rr_amount) as total,count(*) as number ";
        $sql .= " FROM `".DB::table($this->_table)."` ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    public function getMemberLeaderCount($where){
        $sql = 'SELECT count(*)  ';
        $sql .= ' FROM '.DB::table($this->_table).' r ';
        $sql .= ' LEFT JOIN '.$this->member_table.' m ON m.m_id=r.rr_m_id';
        $sql .= ' LEFT JOIN '.$this->manager_table.' ma ON ma.m_id=r.rr_manager_id ';
        $sql .= ' LEFT JOIN pre_applet_sequence_leader asl ON m.m_id=asl.asl_m_id';
        $sql .= $this->formatWhereSql($where);

        $row = DB::result_first($sql);
        if ($row === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $row;
    }

    public function getMemberLeaderList($where,$index,$count,$sort){
        $sql = 'SELECT r.*,m.m_nickname,m.m_avatar,m.m_gold_coin,ma.m_mobile as manager_mobile,ma.m_id as manager_id,ma.m_nickname as manager_name,asl.asl_status ';
        $sql .= ' FROM '.DB::table($this->_table).' r ';
        $sql .= ' LEFT JOIN '.$this->member_table.' m ON m.m_id=r.rr_m_id';
        $sql .= ' LEFT JOIN '.$this->manager_table.' ma ON ma.m_id=r.rr_manager_id ';
        $sql .= ' LEFT JOIN pre_applet_sequence_leader asl ON m.m_id=asl.asl_m_id';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $row = DB::fetch_all($sql);
        if ($row === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $row;
    }


}