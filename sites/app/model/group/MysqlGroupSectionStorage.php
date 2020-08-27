<?php

class App_Model_Group_MysqlGroupSectionStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

	public function __construct($sid){
        parent::__construct();

        $this->_table   = 'group_buy_section';
		$this->_pk      = 'gbs_id';
        $this->_shopId  = 'gbs_s_id';
        $this->sid      = $sid;
	}

}