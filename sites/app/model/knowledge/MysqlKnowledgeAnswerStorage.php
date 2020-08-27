<?php
/*
 * 问答小程序回答表
 */
class App_Model_Knowledge_MysqlKnowledgeAnswerStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $member_table;
    private $question_table;
    public function __construct($sid){
        $this->_table 	= 'applet_knowledge_answer';
        $this->_pk 		= 'aka_id';
        $this->_shopId 	= 'aka_s_id';
        parent::__construct();
        $this->sid  = $sid;
        $this->member_table = 'member';
        $this->question_table = 'applet_knowledge_question';
    }

    /*
     * mid 用户id
     * qid 提问id
     */
    public function getRowByMidQid($mid,$qid){
        $where[] = array('name' => $this->_shopId,'oper'=> '=', 'value' => $this->sid);
        $where[] = array('name' => 'aka_m_id','oper'=> '=', 'value' => $mid);
        $where[] = array('name' => 'aka_qid','oper'=> '=', 'value' => $qid);
        $where[] = array('name' => 'aka_is_extra','oper'=> '=', 'value' => 0); //非追问追答
        return $this->getRow($where);
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

    /*
     * 根据问题id获得获奖人数
     */
    public function getWinnerCount($qid){
        $where[] = array('name' => 'aka_qid','oper'=> '=', 'value' => $qid);
        $where[] = array('name' => $this->_shopId,'oper'=> '=', 'value' => $this->sid);
        $where[] = array('name' => 'aka_status','oper'=> '=', 'value' => 3); //获奖
        $where[] = array('name' => 'aka_is_extra','oper'=> '=', 'value' => 0); //非追问追答
        return $this->getCount($where);
    }

    /*
     * 获得回答及对应提问
     */
    public function getRowMemberQuestion($id){
        $where[] = array('name' => $this->_shopId,'oper'=> '=', 'value' => $this->sid);
        $where[] = array('name' => $this->_pk,'oper'=> '=', 'value' => $id);
        $sql = 'SELECT aka.*,akq.*,m.m_id,m.m_nickname,m.m_show_id,m.m_avatar ';
        $sql .= "FROM ".DB::table($this->_table).' aka ';
        $sql .= " LEFT JOIN ".DB::table($this->member_table)." m on aka.aka_m_id = m.m_id ";
        $sql .= " LEFT JOIN ".DB::table($this->question_table)." akq on aka.aka_qid = akq.akq_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
          trigger_error("query mysql failed.", E_USER_ERROR);
          return false;
        }
        return $ret;

    }

    /*
     * 获得问题列表  关联用户表 问题表
     */
    public function fetchListMemberQuestion($where,$index,$count,$sort) {
        $sql = 'SELECT aka.*,m.m_id,m.m_nickname,m.m_show_id,m.m_avatar,akq.akq_id,akq.akq_m_id ';
        $sql .= "FROM ".DB::table($this->_table).' aka ';
        $sql .= " LEFT JOIN ".DB::table($this->member_table)." m on aka.aka_m_id = m.m_id ";
        $sql .= " LEFT JOIN ".DB::table($this->question_table)." akq on aka.aka_qid = akq.akq_id ";
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

    public function fetchCountMemberQuestion($where) {
        $sql = 'SELECT count(*) as total ';
        $sql .= "FROM ".DB::table($this->_table).' aka ';
        $sql .= " LEFT JOIN ".DB::table($this->member_table)." m on aka.aka_m_id = m.m_id ";
        $sql .= " LEFT JOIN ".DB::table($this->question_table)." akq on aka.aka_qid = akq.akq_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得我回答的问题 根据问题id分组
     */
    public function fetchListQuestionMemberGroup($where,$index,$count,$sort){
        $sql = 'SELECT aka.*,akq.*,m.m_id,m.m_nickname,m.m_show_id,m.m_avatar ';
        $sql .= ' FROM ( SELECT * FROM '.DB::table($this->_table).' ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY aka_qid ';
        $sql .= ' ORDER BY aka_status DESC ';
        $sql .= $this->formatLimitSql($index,$count);
        $sql .= ' ) aka ';
        $sql .= " LEFT JOIN ".DB::table($this->question_table)." akq on aka.aka_qid = akq.akq_id ";
        $sql .= " LEFT JOIN ".DB::table($this->member_table)." m on akq.akq_m_id = m.m_id ";
        $sql .= " WHERE akq.akq_closure = 0 "; //未被封禁
        $sql .= $this->getSqlSort($sort);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
          trigger_error("query mysql failed.", E_USER_ERROR);
          return false;
        }
        return $ret;

    }

    /*
     * 获得回答的提问数量
     */
    public function getAnswerQuestionCountGroup($where){
        $sql = 'SELECT count(*) as total ';
        $sql .= ' FROM ( ';
        $sql .= ' SELECT aka.aka_id ';
        $sql .= "FROM ".DB::table($this->_table).' aka ';
        $sql .= " LEFT JOIN ".DB::table($this->question_table)." akq on aka.aka_qid = akq.akq_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= ' Group by akq_id ';
        $sql .= ' ) as question ';
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
          trigger_error("query mysql failed.", E_USER_ERROR);
          return false;
        }
        return $ret;
    }

}