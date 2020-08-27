<?php
/*
 * 问答小程序退款申请
 */
class App_Model_Knowledge_MysqlKnowledgeRefundApplyStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $question_table;
    private $member_table;
    public function __construct($sid){
        $this->_table 	= 'applet_knowledge_refund_apply';
        $this->_pk 		= 'akra_id';
        $this->_shopId 	= 'akra_s_id';
        parent::__construct();
        $this->sid  = $sid;
        $this->question_table = 'applet_knowledge_question';
        $this->member_table = 'member';
    }

    /*
     * 获得申请列表  问题表 关联用户表
     */
    public function fetchListQuestionMember($where,$index,$count,$sort) {

        $sql = 'SELECT akra.*,m.m_id,m.m_nickname,m.m_show_id,m.m_avatar,akq.akq_id,akq.akq_question ';
        $sql .= "FROM ".DB::table($this->_table).' akra ';
        $sql .= " LEFT JOIN ".DB::table($this->question_table)." akq on akra.akra_qid = akq.akq_id AND akq.akq_deleted = 0 ";
        $sql .= " LEFT JOIN ".DB::table($this->member_table)." m on akra.akra_m_id = m.m_id ";
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

    public function getQuestionMemberCount($where) {

        $sql = 'SELECT count(*) ';
        $sql .= "FROM ".DB::table($this->_table).' akra ';
        $sql .= " LEFT JOIN ".DB::table($this->question_table)." akq on akra.akra_qid = akq.akq_id AND akq.akq_deleted = 0 ";
        $sql .= " LEFT JOIN ".DB::table($this->member_table)." m on akra.akra_m_id = m.m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
          trigger_error("query mysql failed.", E_USER_ERROR);
          return false;
        }
        return $ret;
    }


}