<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/22
 * Time: 上午9:10
 */
class App_Model_Shop_MysqlOrderReturnStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'order_return';
        $this->_pk      = 'or_id';
        $this->_shopId  = 'or_s_id';

        $this->sid      = $sid;
    }



    /*
     * 获取或设置佣金分配
     */
    public function findUpdateDeductByTid($tid, $data = null) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'or_tid', 'oper' => '=', 'value' => $tid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    public function getReturnTotal($mid, $status){
        $where[] = array('name' => 'or_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'or_m_id', 'oper' => '=', 'value' => $mid);
        $where[] = array('name' => 'or_status', 'oper' => '=', 'value' => $status);

        $sql  = 'SELECT SUM(or_return) ';
        $sql .= ' FROM `pre_order_return` ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret?$ret:0;
    }
}