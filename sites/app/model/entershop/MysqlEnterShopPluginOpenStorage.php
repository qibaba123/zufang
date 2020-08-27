<?php

class App_Model_Entershop_MysqlEnterShopPluginOpenStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'enter_shop_plugin_open';
        $this->_pk     = 'espo_id';
        $this->_shopId = 'espo_s_id';
        $this->sid     = $sid;
    }

    public function findUpdateBySidEsId($esId,$data=null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'espo_es_id', 'oper' => '=', 'value' => $esId);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

}