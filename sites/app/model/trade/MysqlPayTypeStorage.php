<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/29
 * Time: 下午3:19
 */
class App_Model_Trade_MysqlPayTypeStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    public function __construct($sid){
        $this->_table 	= 'pay_type';
        $this->_pk 		= 'pt_id';
        $this->_shopId 	= 'pt_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }

    public function findUpdateCfgBySid($data = null) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }
}