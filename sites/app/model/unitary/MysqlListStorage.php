<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/5/14
 * Time: 下午3:54
 */
class App_Model_Unitary_MysqlListStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'unitary_list';
        $this->_pk      = 'ul_id';
        $this->sid      = $sid;
    }

    /*
     * 通过夺宝记录id获取分配的号码
     */
    public function findListByRid($rid) {
        $where[]    = array('name' => 'ul_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ul_r_id', 'oper' => '=', 'value' => $rid);

        return $this->getList($where, 0, 0);
    }
    /*
     * 通过夺宝计划id及会员id获取分配的号码
     */
    public function fetchListByPidMid($pid, $mid) {
        $where[]    = array('name' => 'ul_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ul_p_id', 'oper' => '=', 'value' => $pid);
        $where[]    = array('name' => 'ul_m_id', 'oper' => '=', 'value' => $mid);

        return $this->getList($where, 0, 0);
    }
    /*
     * 通过夺宝计划id及幸运号码获取记录
     */
    public function fetchRecordByPidNum($pid, $lucky) {
        $where[]    = array('name' => 'ul_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ul_p_id', 'oper' => '=', 'value' => $pid);
        $where[]    = array('name' => 'ul_number', 'oper' => '=', 'value' => $lucky);

        return $this->getRow($where);
    }

}