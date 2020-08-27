<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/3/26
 * Time: 上午11:13
 */
class App_Model_Member_MysqlCompanyCoreStorage extends Libs_Mvc_Model_BaseModel {

    private $shop_table;
    public function __construct() {
        parent::__construct();
        $this->_table   = 'company';
        $this->_pk      = 'c_id';
        $this->shop_table  = DB::table('shop');
    }

    public function getMemberList($where, $index, $count, $sort,$primary=false){
        $sql = "select c.*,m.* ";
        $sql .= " from `".DB::table($this->_table)."` c";
        $sql .= " left join pre_manager m on m_id = c_founder_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $keyfield = '';
        if ($primary) {
            $keyfield   = $this->_pk;
        }
        $ret = DB::fetch_all($sql,array(),$keyfield);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    public function getMemberCount($where){
        $sql = "select count(*) ";
        $sql .= " from `".DB::table($this->_table)."` c";
        $sql .= " left join pre_manager m on m_id = c_founder_id ";
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getManagerByIds($ids, $index, $count,$primary=false){
        $where = array();
        if(!empty($ids) && is_array($ids)){
            $where[] = array('name'=>'s_c_id','oper'=>'in','value'=>$ids);
        }
        $sql = "select c_name,m_mobile,m_nickname ";
        $sql .= " from `".DB::table($this->_table)."` c";
        $sql .= " left join pre_manager m on m_id = c_founder_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->formatLimitSql($index,$count);
        $keyfield = '';
        if ($primary) {
            $keyfield   = $this->_pk;
        }
        $ret = DB::fetch_all($sql,array(),$keyfield);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getCompanyBySid($sid){
        $sql = "select * ";
        $sql .= " from `".DB::table($this->_table)."` c ";
        $sql .= ' LEFT JOIN '.$this->shop_table.'  s ON s_c_id = c_id';
        $sql .= ' WHERE s_id='.intval($sid);

        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}