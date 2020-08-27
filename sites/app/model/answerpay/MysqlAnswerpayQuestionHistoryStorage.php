<?php

class App_Model_Answerpay_MysqlAnswerpayQuestionHistoryStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    private $question_table;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_answerpay_question_history';
        $this->_pk      = 'aaqh_id';
        $this->_shopId  = 'aaqh_s_id';
        $this->sid      = $sid;
        $this->question_table = 'pre_applet_answerpay_question';
    }

    /*
     * 配置
     */
    public function findUpdateByQid($qid,$mid,$data = null) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'aaqh_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'aaqh_q_id', 'oper' => '=', 'value' => $qid);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    public function getHistoryQuestionList($where,$index,$count,$sort){
        $sql = "SELECT aaqh.aaqh_update_time,aaq.* ";
        $sql .= " FROM ".DB::table($this->_table)." aaqh ";
        $sql .= " LEFT JOIN  ".$this->question_table." aaq on aaqh.aaqh_q_id = aaq.aaq_id ";
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