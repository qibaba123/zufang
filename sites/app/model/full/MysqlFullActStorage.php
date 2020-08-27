<?php

class App_Model_Full_MysqlFullActStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $format_table;
    private $match_table;

	public function __construct($sid = null){
		$this->_table 	= 'full_act';
		$this->_pk 		= 'fa_id';
		$this->_shopId 	= 'fa_s_id';
		$this->_df		= 'fa_deleted';
		parent::__construct();

        $this->sid      = $sid;
	}
	/*
	 * 获取所有进行中的活动
	 */
	public function getAllRunningAct($esId = 0) {
		$curr	= time();

		$where[]	= array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
		$where[]	= array('name' => 'fa_start_time', 'oper' => '<', 'value' => $curr);
		$where[]	= array('name' => 'fa_end_time', 'oper' => '>', 'value' => $curr);
        $where[]	= array('name' => 'fa_es_id', 'oper' => '=', 'value' => $esId);
//		if($esId > 0){
//
//        }

		$sort	= array('fa_create_time' => 'DESC');

		return $this->getList($where, 0, 50, $sort);
	}

	public function getListByIds($ids,$oper='in',$index=0,$count=0){
		$where[]	= array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
		$where[]	= array('name' => $this->_pk, 'oper' => $oper, 'value' => $ids);
		$field		= array();
		$sort		= array('fa_update_time' => 'DESC');
		return $this->getList($where,$index,$count,$sort,$field,true);
	}
}