<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/3/16
 * Time: 下午6:33
 */

class App_Model_Member_MysqlManagerOperateLogStorage extends Libs_Mvc_Model_BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table   = 'manager_operate_log';
        $this->_pk      = 'mol_id';
    }

    public function getManagerList($where, $index, $count, $sort){
        $sql = "select mol.*, m.m_nickname ";
        $sql .= " from `".DB::table($this->_table)."` mol ";
        $sql .= " left join pre_manager m on m.m_id = mol.mol_mid ";

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

    public function getManagerRowById($id){
        $where = array();
        $where[] = array('name' => 'mol_id', 'oper' => '=', 'value' => $id);

        $sql = "select mol.*, m.m_nickname ";
        $sql .= " from `".DB::table($this->_table)."` mol ";
        $sql .= " left join pre_manager m on m.m_id = mol.mol_mid ";

        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}