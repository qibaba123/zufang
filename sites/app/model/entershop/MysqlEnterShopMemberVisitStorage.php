<?php

class App_Model_Entershop_MysqlEnterShopMemberVisitStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    public function __construct($sid){
        $this->_table 	= 'enter_shop_member_visit';
        $this->_pk 		= 'esmv_id';
        $this->_shopId 	= 'esmv_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }

    public function getRowByMidEsId($mid,$esId){
        $where = [];
        $where[] = array('name'=>'esmv_s_id','oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'esmv_es_id','oper'=>'=','value'=>$esId);
        $where[] = array('name'=>'esmv_m_id','oper'=>'=','value'=>$mid);
        return $this->getRow($where);
    }

    public function memberList($where,$index,$count,$sort){
        $sql = "SELECT m.* ";
        $sql .= " FROM ".DB::table($this->_table)." esmv ";
        $sql .= " LEFT JOIN `pre_member` m on m.m_id=esmv.esmv_m_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function memberCount($where){
        $sql = "SELECT count(*) ";
        $sql .= " FROM ".DB::table($this->_table)." esmv ";
        $sql .= " LEFT JOIN `pre_member` m on m.m_id=esmv.esmv_m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}