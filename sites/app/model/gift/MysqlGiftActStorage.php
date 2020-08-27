<?php

class App_Model_Gift_MysqlGiftActStorage extends Libs_Mvc_Model_BaseModel{


    private $sid;
    private $format_table;
    private $match_table;

	public function __construct($sid = null){
		$this->_table 	= 'gift_act';
		$this->_pk 		= 'ga_id';
		$this->_shopId 	= 'ga_s_id';
		parent::__construct();

        $this->sid      = $sid;
	}

	/**
	 * @param $index
	 * @param $count
	 * @param $type :1、进行中的，2、活动结束的，3、进行中和未开始的（默认），4、全部
	 * @param $field
	 */
	public function fetchGiftList($index,$count,$type,$keyword='',$field=array('ga_id','ga_name','ga_start_time','ga_end_time')){
		$where		= $this->get_list_where_by_type($type,$keyword);
		$sort		= array('ga_update_time' => 'DESC');
		return $this->getList($where,$index,$count,$sort,$field);
	}

	public function getGiftCount($type,$keyword=''){
		$where		= $this->get_list_where_by_type($type,$keyword);
		return $this->getCount($where);
	}

	private function get_list_where_by_type($type,$keyword){
		$where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
		if($keyword){
			$where[]    = array('name' => 'ga_name', 'oper' => 'like', 'value' => "%{$keyword}%");
		}
		switch($type){
			case 1 :
				$where[]    = array('name' => 'ga_start_time', 'oper' => '<=', 'value' => time());
				$where[]    = array('name' => 'ga_end_time', 'oper' => '>', 'value' => time());
				break;
			case 2 :
				$where[]    = array('name' => 'ga_end_time', 'oper' => '<=', 'value' => time());
				break;
			case 3 :
				$where[]    = array('name' => 'ga_end_time', 'oper' => '>=', 'value' => time());
				break;
		}
		return $where;
	}

	public function getListByIds($gids,$type,$index,$count,$field=array('ga_id','ga_name','ga_start_time','ga_end_time')){
		$where      = array();
		$where[]    = array('name' => $this->_pk, 'oper' => $type, 'value' => $gids);
		$where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
		$sort       = array('ga_update_time' => 'DESC');
		return $this->getList($where,$index,$count,$sort,$field,true);
	}


}