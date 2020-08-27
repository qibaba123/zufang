<?php

class App_Model_Answerpay_MysqlAnswerpayQuestionStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_answerpay_question';
        $this->_pk      = 'aaq_id';
        $this->_shopId  = 'aaq_s_id';
        $this->_df      = 'aaq_deleted';
        $this->sid      = $sid;
    }

    /*
    * 不同字段自增或自减
    */
    public function incrementField($field,$id,$num){
        $field = array($field);
        $inc   = array($num);
        $where[] = array('name' => $this->_pk,'oper'=> '=', 'value' => $id);
        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    public function getQuestionSortList($where,$index,$count,$sort){
        //将回答数乘以5，减去与当前时间相差的天数，作为权重
        $where[] = ['name' => $this->_df,'oper'=> '=', 'value' => 0];
        $sql = "SELECT aaq.*,( aaq_answer_num * 5 - ceiling((unix_timestamp() - aaq_create_time )/86400) ) as weight ";
        $sql .= " FROM ".DB::table($this->_table)." aaq ";
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



}