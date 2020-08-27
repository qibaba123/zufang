<?php

class App_Model_Group_MysqlGoodLuckStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $curr_table;

	public function __construct($sid = null){
		$this->_table 	= 'group_cjres';
		$this->_pk 		= 'gc_id';
		$this->_shopId 	= 'gc_s_id';
		parent::__construct();

        $this->sid         = $sid;
        $this->curr_table  = DB::table($this->_table);
	}

    public function fetchRowUpdateByGbId($gbid,$set=array()){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gc_gb_id', 'oper' => '=', 'value' => $gbid);
        if(!empty($set)){
            return $this->updateValue($set,$where);
        }else{
            return $this->getRow($where);

        }
    }

}