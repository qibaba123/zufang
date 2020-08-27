<?php

class App_Model_Legwork_MysqlLegworkPriceCfgStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_legwork_price_cfg';
        $this->_pk = 'alc_id';
        $this->_shopId = 'alc_s_id';

        $this->sid = $sid;
    }

    /*
      * 通过店铺id获取模版配置
      */
    public function findUpdateBySid($tradeType = 0,$checkUse = 0,$data = null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'alc_trade_type', 'oper' => '=', 'value' => $tradeType);

        if($checkUse){
            $where[]    = array('name' => 'alc_using', 'oper' => '=', 'value' => 1);
        }

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }
}