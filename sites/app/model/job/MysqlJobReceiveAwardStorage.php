<?php
/*
 * 问答小程序首页配置
 */
class App_Model_Job_MysqlJobReceiveAwardStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $member_table;
    public function __construct($sid){
        $this->_table 	= 'applet_job_receive_award';
        $this->_pk 		= 'ajra_id';
        $this->_shopId 	= 'ajra_s_id';
        parent::__construct();
        $this->sid  = $sid;
        $this->member_table = DB::table('member');
    }

    //根据职位id和会员id取出待审核的一条记录
    public function getRowByPidMid($pid, $mid){
        $where[] = array('name' => 'ajra_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajra_ajp_id', 'oper' => '=', 'value' => $pid);
        $where[] = array('name' => 'ajra_m_id', 'oper' => '=', 'value' => $mid);
        $where[] = array('name' => 'ajra_status', 'oper' => '=', 'value' => 0);
        return $this->getRow($where);
    }

    //根据职位id和会员id取出待审核的一条记录
    public function getEntryByPidMid($pid, $mid){
        $where[] = array('name' => 'ajra_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajra_ajp_id', 'oper' => '=', 'value' => $pid);
        $where[] = array('name' => 'ajra_m_id', 'oper' => '=', 'value' => $mid);
        $where[] = array('name' => 'ajra_type', 'oper' => '=', 'value' => 2);
        return $this->getRow($where);
    }

    /**
     * 根据职位id获取领取明细
     */
    public function getListByPid($pid, $type=0,$index, $count){
        $where[] = array('name' => 'ajra_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajra_ajp_id', 'oper' => '=', 'value' => $pid);
        if($type){
            $where[] = array('name' => 'ajra_type', 'oper' => '=', 'value' => $type);
        }
        $where[] = array('name' => 'ajra_status', 'oper' => '!=', 'value' => 2);
        $sql = "select ajra.*, m1.m_nickname as m1Nickname, m2.m_nickname as m2Nickname, m1.m_avatar as m1Avatar, m2.m_avatar as m2Avatar";
        $sql .= " from `".DB::table($this->_table)."` ajra ";
        $sql .= " left join ".$this->member_table." m1 on m1.m_id = ajra.ajra_m_id ";
        $sql .= " left join ".$this->member_table." m2 on m2.m_id = ajra.ajra_f1_mid ";
        $sort = array('ajra_create_time' => 'desc');

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

}