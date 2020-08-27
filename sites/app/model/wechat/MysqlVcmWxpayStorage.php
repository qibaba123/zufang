<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2018/12/27
 * Time: 5:34 PM
 */
class App_Model_Wechat_MysqlVcmWxpayStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    public function __construct($sid){
        $this->_table 	= 'vcm_wxpay';
        $this->_pk 		= 'vw_id';
        $this->_shopId 	= 'vw_sid';
        parent::__construct();
        $this->sid  = $sid;
    }

    /*
      * 通过店铺id获取支付配置
      */
    public function findUpdateBySid($data = null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

}