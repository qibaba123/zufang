<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/5/13
 * Time: 下午5:49
 */
class App_Model_Unitary_MysqlOrderStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'unitary_order';
        $this->_pk      = 'uo_id';
        $this->sid      = $sid;
    }

    /*
     * 通过订单id获取订单
     */
    public function findUpdateOrderByTid($tid, $data = null) {
        $where[]    = array('name' => 'uo_tid', 'oper' => '=', 'value' => $tid);
        $where[]    = array('name' => 'uo_s_id', 'oper' => '=', 'value' => $this->sid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }
}