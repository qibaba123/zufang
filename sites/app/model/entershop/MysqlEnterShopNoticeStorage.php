<?php

class App_Model_Entershop_MysqlEnterShopNoticeStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
	public function __construct($sid){
		$this->_table   = 'enter_shop_notice';
		$this->_pk      = 'esn_id';
        $this->_shopId  = 'esn_s_id';
        $this->sid      = $sid;
		parent::__construct();

	}


    /**
     * @return array|bool
     * 获取店铺所有分类
     */
    public function getListBySid(){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $sort       = array('esn_weight' => 'ASC');
        return $this->getList($where,0,0,$sort);
    }

}