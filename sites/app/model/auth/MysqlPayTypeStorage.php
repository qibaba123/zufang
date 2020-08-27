<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/19
 * Time: 下午12:13
 */

class App_Model_Auth_MysqlPayTypeStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'pay_type';
        $this->_pk      = 'pt_id';
        $this->_shopId  = 'pt_s_id';
        $this->sid      = $sid;
    }

    /*
     * 通过店铺id查找微信配置
     */
    public function findRowPay($data = array()) {
        $where   = array();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if(!empty($data)){
            $ret = $this->updateValue($data,$where);
        }else{
           $ret = $this->getRow($where);
        }
        return $ret;
    }

}