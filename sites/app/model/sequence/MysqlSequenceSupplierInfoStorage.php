<?php

class App_Model_Sequence_MysqlSequenceSupplierInfoStorage extends Libs_Mvc_Model_BaseModel {
    private $sid;
    private $member_table;
    public function __construct($sid = 0) {
        parent::__construct();
        $this->_table   = 'applet_sequence_supplier_info';
        $this->_pk      = 'assi_id';
        $this->_df      = 'assi_deleted';
        $this->_shopId  = 'assi_s_id';
        $this->sid      = $sid;
        $this->member_table = DB::table('member');
    }


    /**
     * 按特定手机号字段检索
     * @param mixed $mobile
     * @return array|bool
     */
    public function findRowByMobile($mobile,$id = 0) {
        if($id){
            //排除自身
            $where[]    = array('name' => $this->_pk, 'oper' => '!=', 'value' => $id);
        }
        if($this->sid){
            $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        }

        $where[]    = array('name' => 'assi_mobile', 'oper' => '=', 'value' => $mobile);

        $ret = $this->getRow($where);

        return $ret;
    }



    /*
     * 获得列表
     * 关联用户表
     */
    public function getSupplierList($where,$index,$count,$sort){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sql  = 'SELECT assi.* ';
        $sql .= ' FROM '.DB::table($this->_table).' assi ';
//        $sql .= ' LEFT JOIN '.$this->member_table.' m on m.m_id = assi.assi_m_id';
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

    public function getSupplierCount($where){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sql  = 'SELECT count(*) as total ';
        $sql .= ' FROM '.DB::table($this->_table).' assi ';
//        $sql .= ' LEFT JOIN '.$this->member_table.' m on m.m_id = assi.assi_m_id';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 设置指定字段自增或自减
     */
    public function incrementSupplierField($id,$num,$field) {
        $fields  = array($field);
        $inc    = array($num);

        $where[]    = array('name' => 'assi_id', 'oper' => '=', 'value' => $id);

        $sql = $this->formatIncrementSql($fields, $inc, $where);
        return DB::query($sql);
    }






}