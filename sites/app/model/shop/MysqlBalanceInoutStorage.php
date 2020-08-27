<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/11/14
 * Time: 下午6:43
 */
class App_Model_Shop_MysqlBalanceInoutStorage extends Libs_Mvc_Model_BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table   = 'balance_inout';
        $this->_pk      = 'bi_id';
        $this->_shopId  = 'bi_s_id';
    }
    /**
     * 检测tid是否已经存在,用于小程序短信充值回调
     */
    public function checkTidExit($tid){
        $where   =  array();
        $where[] =  array('name'=>'bi_tid','oper'=>'=','value'=>$tid);
        return $this->getRow($where);
    }



}