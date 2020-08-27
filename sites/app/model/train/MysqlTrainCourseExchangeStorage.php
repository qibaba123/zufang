<?php

class App_Model_Train_MysqlTrainCourseExchangeStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $course_table;
    private $member_table;
    public function __construct($sid){
        $this->_table 	= 'applet_train_course_exchange';
        $this->_pk 		= 'atce_id';
        $this->_shopId 	= 'atce_s_id';
        parent::__construct();
        $this->sid  = $sid;
        $this->course_table = 'applet_train_course';
        $this->member_table = 'member';
    }

    /*
     * 判断用户是否收藏
     */
    public function getRowByIdMid($id,$mid){
        $where = array();
        $where[] = array('name'=> 'atce_atc_id','oper'=> '=','value'=>$id);
        $where[] = array('name'=> 'atce_m_id','oper'=> '=','value'=>$mid);
        $where[] = array('name'=> $this->_shopId,'oper'=> '=','value'=>$this->sid);
        return $this->getRow($where);
    }

    /*
     * 获得收藏列表
     */
    public function getExchangeList($where,$index,$count,$sort){
        $sql = "select atce.*,atc.* ";
        $sql .= " from `".DB::table($this->_table)."` atce ";
        $sql .= " left join `".DB::table($this->course_table)."` atc on atc.atc_id = atce.atce_course ";
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
     * 获得收藏列表
     */
    public function getExchangeDetail($id){
        $where[] = array('name' => 'atce_id', 'oper' => '=', 'value' => $id);
        $sql = "select atce.*,atc.* ";
        $sql .= " from `".DB::table($this->_table)."` atce ";
        $sql .= " left join `".DB::table($this->course_table)."` atc on atc.atc_id = atce.atce_course ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得列表
     */
    public function getExchangeMemberList($where,$index,$count,$sort){
        $sql = "select atce.*,atc.*,m.m_avatar,m.m_nickname ";
        $sql .= " from `".DB::table($this->_table)."` atce ";
        $sql .= " left join `".DB::table($this->course_table)."` atc on atc.atc_id = atce.atce_course ";
        $sql .= " left join `".DB::table($this->member_table)."` m on m.m_id = atce.atce_m_id ";
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
     * 获得数量
     */
    public function getExchangeMemberCount($where){
        $sql = "select count(*) as total ";
        $sql .= " from `".DB::table($this->_table)."` atce ";
        $sql .= " left join `".DB::table($this->course_table)."` atc on atc.atc_id = atce.atce_course ";
        $sql .= " left join `".DB::table($this->member_table)."` m on m.m_id = atce.atce_m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}