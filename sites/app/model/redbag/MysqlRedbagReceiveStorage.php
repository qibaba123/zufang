<?php

class App_Model_Redbag_MysqlRedbagReceiveStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $member_table;
    private $group_table;
    private $join_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_redbag_receive';
        $this->_pk     = 'arr_id';
        $this->_shopId = 'arr_s_id';
        $this->sid     = $sid;
        $this->member_table = DB::table('member');
        $this->group_table = DB::table('applet_redbag_group');
        $this->join_table = DB::table('applet_redbag_join');
    }

    public function getListMember($where,$index,$count,$sort){
        $sql  = 'SELECT arr.*,m.m_avatar,m.m_nickname ';
        $sql .= ' FROM '.DB::table($this->_table).' arr ';
        $sql .= ' LEFT JOIN '.$this->member_table.' m on m.m_id = arr.arr_m_id';
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
        $sql .= ' FROM '.DB::table($this->_table).' ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY arr_m_id ';
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getSum($where){
        $sql  = 'SELECT SUM(arr_money) as total ';
        $sql .= ' FROM '.DB::table($this->_table).' ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getRowGroup($where){
        $sql  = 'SELECT * ';
        $sql .= ' FROM '.DB::table($this->_table).' arr ';
        $sql .= ' LEFT JOIN '.$this->group_table.' arg on arg.arg_id = arr.arr_group';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    public function getListGroup($where,$index,$count,$sort){
        $sql  = 'SELECT arr.*,arg.arg_create_mid,arj.arj_nickname ';
        $sql .= ' FROM '.DB::table($this->_table).' arr ';
        $sql .= ' LEFT JOIN '.$this->group_table.' arg on arg.arg_id = arr.arr_group';
        $sql .= ' LEFT JOIN '.$this->join_table.' arj on arj.arj_group = arg.arg_id and arg.arg_create_mid = arj.arj_m_id ';
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