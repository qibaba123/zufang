<?php

class App_Model_Answerpay_MysqlAnswerpayAnswerStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    private $question_model;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_answerpay_answer';
        $this->_pk      = 'aaa_id';
        $this->_shopId  = 'aaa_s_id';
        $this->_df      = 'aaa_deleted';
        $this->question_model = DB::table('applet_answerpay_question');
        $this->sid      = $sid;
    }


    public function getAnswerSortList($where,$index,$count){
        //将回答的评论数与点赞数相加，减去与当前时间相差的天数，作为权重
        $where[] = ['name' => $this->_df,'oper'=> '=', 'value' => 0];
        $sort = ['weight'=>'desc','aaa_id' => 'desc'];
        $sql = "SELECT aaa.*,( aaa_like_num + aaa_comment_num - ceiling((unix_timestamp() - aaa_create_time )/86400) ) as weight ";
        $sql .= " FROM ".DB::table($this->_table)." aaa ";
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


    public function getAnswerQuestionList($where,$index,$count,$sort){
        //将回答的评论数与点赞数相加，减去与当前时间相差的天数，作为权重
        $where[] = ['name' => $this->_df,'oper'=> '=', 'value' => 0];
        $sql = "SELECT aaa.*,aaq.aaq_title,aaq.aaq_payment,aaq.aaq_id,aaq.aaq_type,aaq.aaq_free_time ";
        $sql .= " FROM ".DB::table($this->_table)." aaa ";
        $sql .= " LEFT JOIN ".$this->question_model." aaq on aaq.aaq_id = aaa.aaa_q_id ";
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

    public function getAnswerQuestionRow($id){
        //将回答的评论数与点赞数相加，减去与当前时间相差的天数，作为权重
        $where[] = ['name' => $this->_pk,'oper'=> '=', 'value' => $id];
        $where[] = ['name' => $this->_df,'oper'=> '=', 'value' => 0];
        $sql = "SELECT aaa.*,aaq.aaq_title,aaq.aaq_payment,aaq.aaq_m_id,aaq.aaq_type,aaq.aaq_free_time,aaq.aaq_m_id ";
        $sql .= " FROM ".DB::table($this->_table)." aaa ";
        $sql .= " LEFT JOIN ".$this->question_model." aaq on aaq.aaq_id = aaa.aaa_q_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getAnswerQuestionSortList($where,$index,$count){
        //将回答的评论数与点赞数相加，减去与当前时间相差的天数，作为权重
        $sort = ['weight'=>'desc','aaa_id' => 'desc'];
        $where[] = ['name' => $this->_df,'oper'=> '=', 'value' => 0];
        $sql = "SELECT aaa.*,( aaa_like_num + aaa_comment_num - ceiling((unix_timestamp() - aaa_create_time )/86400) ) as weight,aaq.aaq_title,aaq.aaq_payment,aaq.aaq_type,aaq.aaq_free_time ";
        $sql .= " FROM ".DB::table($this->_table)." aaa ";
        $sql .= " LEFT JOIN ".$this->question_model." aaq on aaq.aaq_id = aaa.aaa_q_id ";
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
     * 根据提问id和用户id查找回答
     */
    public function getRowByMidQid($mid,$qid){
        $where = [];
        $where[] = ['name' => $this->_shopId,'oper'=> '=', 'value' => $this->sid];
        $where[] = ['name' => 'aaa_q_id','oper'=> '=', 'value' => $qid];
        $where[] = ['name' => 'aaa_m_id','oper'=> '=', 'value' => $mid];
        return $this->getRow($where);
    }


    /*
     * 获得评分平均值
     */
    public function getScoreAvg($id,$type){
        $where = [];
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'aaa_manager_id', 'oper' => '=', 'value' => $id);
        $where[]    = array('name' => 'aaa_type', 'oper' => '=', 'value' => $type);
        $where[]    = array('name' => 'aaa_score', 'oper' => '>', 'value' => 0);
        $sql = "SELECT AVG(aaa_score) as score ";
        $sql .= " FROM ".DB::table($this->_table)." ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得一条数据 无论是否删除
     */
    public function getRowDelete($where) {
        $sql = $this->formatSelectOneSql($where);
        $row = DB::fetch_first($sql);
        if ($row === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $row;
    }


}