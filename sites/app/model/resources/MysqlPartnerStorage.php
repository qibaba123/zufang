<?php

class App_Model_Resources_MysqlPartnerStorage extends Libs_Mvc_Model_BaseModel{

    const GOODS_IN_SALE     = 1;
    const GOODS_OUT_SALE    = 2;

    private $sid;
    private $format_table;
    private $match_table;
    private $curr_table;

	public function __construct($sid = null){
		$this->_table 	= 'applet_house_partner';
		$this->_pk 		= 'ahp_id';
        $this->_shopId  = 'ahp_s_id';
        $this->_df      = 'ahp_deleted';
		parent::__construct();
        $this->sid      = $sid;
        $this->format_table = DB::table('goods_format');
        $this->match_table  = DB::table('group_match');
        $this->curr_table   = DB::table($this->_table);
	}



}