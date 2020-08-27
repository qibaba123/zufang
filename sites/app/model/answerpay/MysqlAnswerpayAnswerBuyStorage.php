<?php

class App_Model_Answerpay_MysqlAnswerpayAnswerBuyStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    private $question_table;
    private $answer_table;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_answerpay_answer_buy';
        $this->_pk      = 'aaab_id';
        $this->_shopId  = 'aaab_s_id';
        $this->sid      = $sid;
        $this->question_table = 'pre_applet_answerpay_question';
        $this->answer_table = 'pre_applet_answerpay_answer';
    }


    public function getRowByMidAid($mid,$aid){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'aaab_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'aaab_a_id', 'oper' => '=', 'value' => $aid);
        return $this->getRow($where);
    }


    public function getAnswerBuyList($where,$index,$count,$sort){
        $sql = "SELECT aaab.*,aaa.aaa_nickname,aaa.aaa_avatar,aaa.aaa_show_num,aaa.aaa_comment_num,aaa.aaa_content,aaa.aaa_like_num,aaq.aaq_id,aaq.aaq_title,aaq.aaq_payment ";
        $sql .= " FROM ".DB::table($this->_table)." aaab ";
        $sql .= " LEFT JOIN  ".$this->answer_table." aaa on aaab.aaab_a_id = aaa.aaa_id ";
        $sql .= " LEFT JOIN  ".$this->question_table." aaq on aaa.aaa_q_id = aaq.aaq_id ";
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