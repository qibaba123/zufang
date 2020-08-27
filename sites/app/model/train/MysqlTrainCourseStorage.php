<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/26
 * Time: 上午11:55
 */
class App_Model_Train_MysqlTrainCourseStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    public function __construct($sid){
        $this->_table 	= 'applet_train_course';
        $this->_pk 		= 'atc_id';
        $this->_shopId 	= 'atc_s_id';
        $this->_df      = 'atc_deleted';
        parent::__construct();
        $this->sid  = $sid;
    }

    /*
     * 根据课程分类分组 获得分组中limit条的课程
     */
    public function getListWithGroupLimit($limit,$where = array(),$sort = array()){
        $where[]      = array('name' => "A1.atc_s_id", 'oper' => '=', 'value' => $this->sid);
        $where[]      = array('name' => "A1.atc_deleted", 'oper' => '=', 'value' => 0);
        $limit = intval($limit);
        $sql = 'SELECT A1.* ';
        $sql .= 'FROM `'.DB::table($this->_table).'` AS A1 ';
        $sql .= 'INNER JOIN (SELECT A.atc_type_id,A.atc_create_time ';
        $sql .= 'FROM `'.DB::table($this->_table).'` AS A ';
        $sql .= 'LEFT JOIN '.DB::table($this->_table).' AS B ON A.atc_type_id = B.atc_type_id AND A.atc_create_time <= B.atc_create_time ';
        $sql .= 'GROUP BY A.atc_type_id,A.atc_create_time ';
        $sql .= 'HAVING COUNT(B.atc_create_time) <= '.$limit;
        $sql .= '  ) AS B1 ';
        $sql .= 'ON A1.atc_type_id = B1.atc_type_id AND A1.atc_create_time = B1.atc_create_time';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
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

    public function changeDeduct($gid,$is_deduct){
        $where      = array();
        $where[]    = array('name' => 'atc_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $set = array(
            'atc_is_deduct' => $is_deduct ? 1 : 0
        );
        return $this->updateValue($set,$where);
    }
}