<?php

class App_Model_Goods_MysqlPostWayStorage extends Libs_Mvc_Model_BaseModel{

	public function __construct(){
		$this->_table   = 'applet_post_way';
		$this->_pk      = 'apw_id';
        $this->_shopId  = '';
		parent::__construct();

	}

}