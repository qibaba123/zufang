<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/19
 * Time: 下午12:13
 */

class App_Model_Auth_MysqlAlipayPayStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'alipay_pay';
        $this->_pk      = 'ap_id';
        $this->_shopId  = 'ap_s_id';
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