<?php

class App_Model_Redbag_MysqlRedbagJoinStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $member_table;
    private $group_table;
    private $activity_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_redbag_join';
        $this->_pk     = 'arj_id';
        $this->_shopId = 'arj_s_id';
        $this->sid     = $sid;
        $this->member_table = DB::table('member');
        $this->group_table = DB::table('applet_redbag_group');
        $this->activity_table = DB::table('applet_redbag_activity');
    }

    public function getListMember($where,$index,$count,$sort){
        $sql  = 'SELECT arj.*,m.m_id,m.m_avatar,m.m_nickname,m.m_openid ';
        $sql .= ' FROM '.DB::table($this->_table).' arj ';
        $sql .= ' LEFT JOIN '.$this->member_table.' m on m.m_id = arj.arj_m_id';
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

    public function getCountMember($where){
        $sql  = 'SELECT count(*) as total ';
        $sql .= ' FROM '.DB::table($this->_table).' arj ';
        $sql .= ' LEFT JOIN '.$this->member_table.' m on m.m_id = arj.arj_m_id';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getListMemberGroup($where,$index,$count,$sort){
        $sql  = 'SELECT arj.*,m.m_avatar ';
        $sql .= ' FROM '.DB::table($this->_table).' arj ';
        $sql .= ' LEFT JOIN '.$this->member_table.' m on m.m_id = arj.arj_m_id';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY arj.arj_m_id ';
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getJoinListGroup($where,$index,$count,$sort){
        $sql  = 'SELECT * ';
        $sql .= ' FROM '.DB::table($this->_table).' ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY arj_m_id ';
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getJoinCountGroup($where){
        $sql  = 'SELECT count(*) as total ';
        $sql .= ' FROM ( ';
        $sql .= 'SELECT arj_id ';
        $sql .= ' FROM '.DB::table($this->_table).' ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY arj_m_id ';
        $sql .= ' ) as count_table ';
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getCountMemberGroup($where){
        $sql  = 'SELECT count(*) as total ';
        $sql .= ' FROM ( ';
        $sql .= 'SELECT arj_id ';
        $sql .= ' FROM '.DB::table($this->_table).' ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY arj_m_id ';
        $sql .= ' ) as count_table ';
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getRowGroup($where){
        $sql  = 'SELECT * ';
        $sql .= ' FROM '.DB::table($this->_table).' arj ';
        $sql .= ' LEFT JOIN '.$this->group_table.' arg on arg.arg_id = arj.arj_group';
        $sql .= ' LEFT JOIN '.$this->activity_table.' ara on ara.ara_id = arg.arg_a_id';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getListGroup($where,$index,$count,$sort){
        $sql  = 'SELECT arj.*,arg.*,ara.ara_status ';
        $sql .= ' FROM '.DB::table($this->_table).' arj ';
        $sql .= ' LEFT JOIN '.$this->group_table.' arg on arg.arg_id = arj.arj_group';
        $sql .= ' LEFT JOIN '.$this->activity_table.' ara on ara.ara_id = arg.arg_a_id';
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