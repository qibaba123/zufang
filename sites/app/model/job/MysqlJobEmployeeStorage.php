<?php
/*
 * 问答小程序首页配置
 */
class App_Model_Job_MysqlJobEmployeeStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $member_table;

    public function __construct($sid){
        $this->_table 	= 'applet_job_employee';
        $this->_pk 		= 'aje_id';
        $this->_shopId 	= 'aje_s_id';
        $this->member_table = DB::table('member');
        parent::__construct();
        $this->sid  = $sid;
    }

    /**
     * 根据公司id和会员id取出认证中和已认证的一条数据
     */
    public function getEmployeeRowByEsIdMId($esId, $mid){
        $where[] = array('name' => 'aje_s_id', 'oper' => '=', 'value' => $this->sid);
        if($esId){
            $where[] = array('name' => 'aje_es_id', 'oper' => '=', 'value' => $esId);
        }
        $where[] = array('name' => 'aje_m_id', 'oper' => '=', 'value' => $mid);
        $where[] = array('name' => 'aje_deleted', 'oper' => '=', 'value' => 0);

        $sql  = ' SELECT  *';
        $sql .= " from `".DB::table($this->_table)."`";
        $sql .= $this->formatWhereSql($where);
        $sql .= " and((aje_status=1 and aje_record_deleted=0) or (aje_status=2))";

        $ret = DB::fetch_first($sql,array(),'');
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 根据公司id所有数据
     */
    public function getEmployeeApplyList($where, $index, $count){
        $where[] = array('name' => 'aje_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'aje_deleted', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'aje_record_deleted', 'oper' => '=', 'value' => 0);

        $sort = array('aje_create_time' => 'desc');
        $sql  = ' SELECT  aje.*, m_nickname, m_avatar, ajd_name';
        $sql .= " from `".DB::table($this->_table)."` aje ";
        $sql .= " left join `".$this->member_table."` m on m.m_id = aje.aje_m_id ";
        $sql .= " left join `pre_applet_job_department` ajd on ajd.ajd_id = aje.aje_department ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql,array(),'');
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 根据会员id取出已认证的一条数据
     */
    public function getHadEmployeeRowByEsIdMId($mid){
        $where[] = array('name' => 'aje_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'aje_m_id', 'oper' => '=', 'value' => $mid);
        $where[] = array('name' => 'aje_status', 'oper' => '=', 'value' => 2);
        $where[] = array('name' => 'aje_deleted', 'oper' => '=', 'value' => 0);
        return $this->getRow($where);
    }


    /**
     * 根据会员id和公司id取出一条已认证记录
     */
    public function getEmployeeByEsIdMId($esId,$mid){
        $where[] = array('name' => 'aje_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'aje_es_id', 'oper' => '=', 'value' => $esId);
        $where[] = array('name' => 'aje_m_id', 'oper' => '=', 'value' => $mid);
        $where[] = array('name' => 'aje_status', 'oper' => '=', 'value' => 2);
        $where[] = array('name' => 'aje_deleted', 'oper' => '=', 'value' => 0);
        $sql  = ' SELECT  aje.*, ajd_id, ajd_name, m_avatar';
        $sql .= " from `".DB::table($this->_table)."` aje ";
        $sql .= " left join `pre_applet_job_department` ajd on ajd.ajd_id = aje.aje_department ";
        $sql .= " left join `pre_member` m on m.m_id = aje.aje_m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql,array(),'');
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 根据公司id获取已通过的员工
     */
    public function getEmployeeListAction($where, $index, $count){
        $where[] = array('name' => 'aje_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'aje_status', 'oper' => '=', 'value' => 2);
        $where[] = array('name' => 'aje_deleted', 'oper' => '=', 'value' => 0);
        $sort = array('aje_create_time' => 'ASC');
        $sql  = ' SELECT  aje.*, ajd_id, ajd_name';
        $sql .= " from `".DB::table($this->_table)."` aje ";
        $sql .= " left join `pre_applet_job_department` ajd on ajd.ajd_id = aje.aje_department ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql,array(),'');
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

}