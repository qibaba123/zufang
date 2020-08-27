<?php
/*
 * 问答小程序提问分享表
 */
class App_Model_Knowledge_MysqlKnowledgeQuestionShareStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $member_table;
    private $category_table;
    private $question_table;
    public function __construct($sid){
        $this->_table 	= 'applet_knowledge_question_share';
        $this->_pk 		= 'akqs_id';
        $this->_shopId 	= 'akqs_s_id';
        parent::__construct();
        $this->sid  = $sid;
        $this->member_table = 'member';
        $this->category_table = 'applet_knowledge_category';
        $this->question_table = 'applet_knowledge_question';
    }

    /*
     * 获得转发记录
     * qid 提问id
     * mid 转发人id
     * fmid 转发人上级id
     */
    public function findRowByQidMid($qid,$mid,$fmid = 0){
        $where = array();
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'akqs_m_id','oper'=>'=','value'=>$mid);
        $where[] = array('name'=>'akqs_q_id','oper'=>'=','value'=>$qid);
        //$where[] = array('name'=>'akqs_m_fid','oper'=>'=','value'=>$fmid);

        return $this->getRow($where);
    }

    /*
     * 获得转发记录  关联会员表
     * qid 提问id
     * mid 转发人id
     * fmid 转发人上级id
     */
    public function findRowByQidMidMember($qid,$mid){
        $where = array();
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'akqs_m_id','oper'=>'=','value'=>$mid);
        $where[] = array('name'=>'akqs_q_id','oper'=>'=','value'=>$qid);

        $sql = 'SELECT akqs.*,m.m_id,m.m_nickname,m.m_avatar ';
        $sql .= "FROM ".DB::table($this->_table).' akqs ';
        $sql .= " LEFT JOIN ".DB::table($this->member_table)." m on akqs.akqs_m_id = m.m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得转发列表
     * 转发会员信息
     */
    public function getShareMemberList($where,$index,$count,$sort){
        $sql = 'SELECT akqs.*,m.m_id,m.m_nickname,m.m_avatar ';
        $sql .= "FROM ".DB::table($this->_table).' akqs ';
        $sql .= " LEFT JOIN ".DB::table($this->member_table)." m on akqs.akqs_m_id = m.m_id ";
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
     * 获得转发列表
     * 提问信息 提问会员信息
     */
    public function getShareQuestionMemberList($where,$index,$count,$sort){
        $sql = 'SELECT akqs.*,akq.*,m.m_id,m.m_nickname,m.m_avatar ';
        $sql .= "FROM ".DB::table($this->_table).' akqs ';
        $sql .= " LEFT JOIN ".DB::table($this->question_table)." akq on akqs.akqs_q_id = akq.akq_id ";
        $sql .= " LEFT JOIN ".DB::table($this->member_table)." m on akq.akq_m_id = m.m_id ";
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
     * 获得转发记录
     * qid 提问id
     * mid 转发人id
     * fmid 转发人上级id
     */
    public function findRowByQidFmid($qid,$fmid){
        $where = array();
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'akqs_q_id','oper'=>'=','value'=>$qid);
        $where[] = array('name'=>'akqs_m_fid','oper'=>'=','value'=>$fmid);

        return $this->getRow($where);
    }




}