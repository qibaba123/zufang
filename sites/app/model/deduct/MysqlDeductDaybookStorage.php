<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/28
 * Time: 下午3:36
 */
class App_Model_Deduct_MysqlDeductDaybookStorage extends Libs_Mvc_Model_BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table   = 'deduct_daybook';
        $this->_pk      = 'dd_id';
        $this->shopId   = 'dd_s_id';
    }

    public function getOrderList($where = array(), $index = 0, $count = 20, $sort = array()) {
        $sql = 'select dd.*,o_title ';
        $sql .= ' from `'.DB::table($this->_table).'` dd ';
        $sql .= ' left join pre_order o on o.o_id=dd.dd_o_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql, array(), $this->_pk);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /*
     * 获取会员佣金流水记录
     */
    public function fetchMemberRecord($mid, $type, $index = 0, $count = 10) {
        $where[]    = array('name' => 'dd_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'dd_record_type', 'oper' => '=', 'value' => $type);

        $sort   = array('dd_record_time' => 'DESC');

        return $this->getList($where, $index, $count, $sort);
    }
    /*
     * 获取会员佣金流水记录总量
     */
    public function fetchMemberRecordCount($mid, $type) {
        $where[]    = array('name' => 'dd_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'dd_record_type', 'oper' => '=', 'value' => $type);

        return $this->getCount($where);
    }

    /*
     * 获取会员佣金流水记录
     */
    public function fetchMemberRecordRow($mid,$wdid) {
        $where[]    = array('name' => 'dd_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'dd_o_id', 'oper' => '=', 'value' => $wdid);
        $where[]    = array('name' => 'dd_record_type', 'oper' => '=', 'value' => 4);
        return $this->getRow($where);
    }
}