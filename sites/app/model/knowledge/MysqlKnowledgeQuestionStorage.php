<?php
/*
 * 问答小程序提问表
 */
class App_Model_Knowledge_MysqlKnowledgeQuestionStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $member_table;
    private $category_table;
    public function __construct($sid){
        $this->_table 	= 'applet_knowledge_question';
        $this->_pk 		= 'akq_id';
        $this->_shopId 	= 'akq_s_id';
        $this->_df = 'akq_deleted';
        parent::__construct();
        $this->sid  = $sid;
        $this->member_table = 'member';
        $this->category_table = 'applet_knowledge_category';
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
     * 获得问题列表  关联用户表
     */
    public function fetchListMember($where,$index,$count,$sort) {
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除
        $sql = 'SELECT akq.*,m.m_id,m.m_nickname,m.m_show_id,m.m_avatar,akc.akc_name,akc.akc_price ';
        $sql .= "FROM `".DB::table($this->_table)."` akq ";
        $sql .= " LEFT JOIN ".DB::table($this->member_table)." m on akq.akq_m_id = m.m_id ";
        $sql .= " LEFT JOIN ".DB::table($this->category_table)." akc on akq.akq_category = akc.akc_id ";
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
     * 获得问题列表数量  关联用户表
     */
    public function fetchListMemberCount($where) {
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除
        $sql = "select count(*) ";
        $sql .= "FROM `".DB::table($this->_table)."` akq ";
        $sql .= " LEFT JOIN ".DB::table($this->member_table)." m on akq.akq_m_id = m.m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
          trigger_error("query mysql failed.", E_USER_ERROR);
          return false;
        }
        return $ret;
    }



  /*
     * 获得单条问题  关联用户表
     */
    public function fetchRowMember($where) {
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除
        $sql = 'SELECT akq.*,m.m_id,m.m_nickname,m.m_show_id,m.m_avatar ';
        $sql .= "FROM ".DB::table($this->_table).' akq ';
        $sql .= " LEFT JOIN ".DB::table($this->member_table)." m on akq.akq_m_id = m.m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
          trigger_error("query mysql failed.", E_USER_ERROR);
          return false;
        }
        return $ret;
    }


}