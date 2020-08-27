<?php

class App_Model_Blessing_MysqlBlessingListStorage extends Libs_Mvc_Model_BaseModel {
    private $sid;//店铺id
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_blessing_list';
        $this->_pk      = 'abl_id';
        $this->_shopId  = 'abl_s_id';
        $this->sid      = $sid;
    }


    /*
      * 通过店铺id和用户id获取用户最新编辑的一条记录
      */
    public function findRowBySidMid($mid) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'abl_m_id', 'oper' => '=', 'value' => $mid);
        $sort = array('abl_create_time'=>'DESC');
        $sql  = 'SELECT abl.* , m.m_id, m.m_nickname, m.m_avatar  ';
        $sql .= ' FROM '.DB::table($this->_table) . ' abl ';
        $sql .= ' LEFT JOIN pre_member m ON abl.abl_m_id = m.m_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql(0,1);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret[0];
    }

    /*
      * 通过店铺id和用户id获取用户最新编辑的一条记录
      */
    public function findRowByBlessingId($id) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'abl_id', 'oper' => '=', 'value' => $id);
        $sql  = 'SELECT abl.* , m.m_id, m.m_nickname, m.m_avatar  ';
        $sql .= ' FROM '.DB::table($this->_table) . ' abl ';
        $sql .= ' LEFT JOIN pre_member m ON abl.abl_m_id = m.m_id ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }



}