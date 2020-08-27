<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/8/27
 * Time: 下午5:49
 */
class App_Model_Member_MysqlRechargeValueStorage extends Libs_Mvc_Model_BaseModel {
    private $sid;

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'recharge_value';
        $this->_pk      = 'rv_id';
        $this->_shopId  = 'rv_s_id';
        $this->sid      = $sid;
    }

    public function findValueById($id) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'rv_id', 'oper' => '=', 'value' => $id);

        return $this->getRow($where);
    }

    public function fetchValueList() {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        $sort   = array('rv_weight' => 'DESC');

        return $this->getList($where, 0, 0, $sort);
    }

    public function fetchGradeValueList() {
        $where = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sort   = array('rv_weight' => 'DESC');
        $sql = 'select * ';
        $sql .= ' from `'.DB::table($this->_table).'` rv ';
        $sql .= ' left join `pre_member_level` ml on rv.rv_identity = ml.ml_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

}