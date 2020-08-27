<?php

class App_Model_Business_MysqlBusinessCardStorage extends Libs_Mvc_Model_BaseModel {
    private $sid;//店铺id
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_business_card';
        $this->_pk      = 'abc_id';
        $this->_shopId  = 'abc_s_id';
        $this->_df      = 'abc_deleted';
        $this->sid      = $sid;
    }

    public function getRowByMidSid($mid){
        $where = array();
        $where[] = array('name' => 'abc_m_id','oper'=> '=', 'value' => $mid);
        $where[] = array('name' => $this->_shopId,'oper'=> '=', 'value' => $this->sid);
        return $this->getRow($where);
    }


    /*
     * 不同字段自增或自减
     */
    public function incrementField($field,$id,$num){
        $field = array($field);
        $inc   = array($num);
        $where[] = array('name' => 'abc_id','oper'=> '=', 'value' => $id);
        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    public function getStatInfo($where){
        $sql = 'SELECT count(*) as total,sum(abc_show) as showNum,sum(abc_like) as likeNum,sum(abc_collection) as collectionNum ';
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