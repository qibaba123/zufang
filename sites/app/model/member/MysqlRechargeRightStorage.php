<?php
/**
 * Created by PhpStorm.
 * User: zhaoweizhen
 * Date: 16/9/19
 * Time: 下午1:49
 */
class App_Model_Member_MysqlRechargeRightStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    public function __construct($sid=0) {
        parent::__construct();
        $this->_table   = 'recharge_right';
        $this->_pk      = 'rr_id';
        $this->_shopId  = 'rr_s_id';

        $this->sid = $sid;
    }

    /**
     * 获取最高权益
     */
    public function findMaxRight($money){
        $where = array();
        $where[] = array('name' => 'rr_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'rr_money', 'oper' => '<=', 'value' => $money);
        $where[] = array('name' => 'rr_discount', 'oper' => '!=', 'value' => 0);
        $where[] = array('name' => 'rr_deleted', 'oper' => '=', 'value' => 0);
        $list = $this->getList($where, 0, 0, array('rr_discount' => 'ASC'));
        if($list){
            return $list[0]['rr_discount'];
        }else{
            return false;
        }
    }


}