<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/26
 * Time: 上午11:55
 */
class App_Model_Train_MysqlTrainCourseCollectionStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $course_table;
    public function __construct($sid){
        $this->_table 	= 'applet_train_course_collection';
        $this->_pk 		= 'atcc_id';
        $this->_shopId 	= 'atcc_s_id';
        parent::__construct();
        $this->sid  = $sid;
        $this->course_table = 'applet_train_course';
    }

    /*
     * 判断用户是否收藏
     */
    public function getRowByIdMid($id,$mid){
        $where = array();
        $where[] = array('name'=> 'atcc_atc_id','oper'=> '=','value'=>$id);
        $where[] = array('name'=> 'atcc_m_id','oper'=> '=','value'=>$mid);
        $where[] = array('name'=> $this->_shopId,'oper'=> '=','value'=>$this->sid);
        return $this->getRow($where);
    }

    /*
     * 获得收藏列表
     */
    public function getCollectionList($where,$index,$count,$sort){
        $sql = "select atcc.*,atc.* ";
        $sql .= " from `".DB::table($this->_table)."` atcc ";
        $sql .= " left join `".DB::table($this->course_table)."` atc on atc.atc_id = atcc.atcc_atc_id ";
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
}