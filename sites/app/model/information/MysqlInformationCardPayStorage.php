<?php

class App_Model_Information_MysqlInformationCardPayStorage extends Libs_Mvc_Model_BaseModel{
    private $sid;
    private $member_table;
    private $information_table;
    public function __construct($sid){
        $this->_table 	= 'applet_information_card_pay';
        $this->_pk 		= 'aicp_id';
        $this->_shopId 	= 'aicp_s_id';

        parent::__construct();
        $this->sid = $sid;
        $this->member_table = 'member';
        $this->information_table = 'applet_information';
    }


    public function getRecordWithMem($where,$index,$count,$sort){
        $sql = "select aicp.*,m.m_nickname,m.m_avatar ";
        $sql .= " from `".DB::table($this->_table)."` aicp ";
        $sql .= " left join ".DB::table($this->member_table)." m on m.m_id = aicp.aicp_m_id ";
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

    /*
     * 统计信息
     */
    public function getSumInfo($where){
        $sql  = 'SELECT count(aicp_id) as total,sum(aicp_pay_money) as money ';
        $sql .= ' FROM '.DB::table($this->_table).' ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }



}