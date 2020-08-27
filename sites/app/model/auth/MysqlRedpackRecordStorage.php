<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/19
 * Time: 下午12:13
 */

class App_Model_Auth_MysqlRedpackRecordStorage extends Libs_Mvc_Model_BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table   = 'redpack_record';
        $this->_pk      = 'rr_id';
        $this->_shopId  = 'rr_s_id';
    }
    /*
     * 查找会员已领取的红包
     */
    public function findRedpackReceive($sid, $mid, $actid, $type) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'rr_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'rr_actid', 'oper' => '=', 'value' => $actid);
        $where[]    = array('name' => 'rr_type', 'oper' => '=', 'value' => $type);

        return $this->getRow($where);
    }
}