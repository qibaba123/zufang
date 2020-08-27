<?php

class App_Model_Full_MysqlFullRuleStorage extends Libs_Mvc_Model_BaseModel{


    private $sid;
    private $format_table;
    private $match_table;

	public function __construct($sid = null){
		$this->_table 	= 'full_rule';
		$this->_pk 		= 'fr_id';
		$this->_shopId 	= 'fr_s_id';
		parent::__construct();

        $this->sid      = $sid;
	}

	/**
	 * @param $value
	 * @return bool
	 * 批量插入
	 */
	public function insertBacth($value){
		$sql  = 'INSERT INTO '.DB::table($this->_table);
		$sql .= ' (`fr_id`, `fr_s_id`, `fr_actid`, `fr_limit`, `fr_kind`,`fr_value`, `fr_create_time`) ';
		$sql .= ' VALUES ';
		$sql .= implode(',',$value);
		$ret = DB::query($sql);

		if ($ret === false) {
			trigger_error("query mysql failed.", E_USER_ERROR);
			return false;
		}
		return $ret;
	}

	/**
	 * @param $actid
	 * @param $index
	 * @param $count
	 * @return array|bool
	 * 根据活动ID获取活动规则
	 */
	public function getListByActid($actid,$index=0,$count=0){
		$where      = array();
		$where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
		$where[]    = array('name' => 'fr_actid', 'oper' => '=', 'value' => $actid);

		$sort	= array('fr_limit' => 'ASC');
		return $this->getList($where,$index,$count, $sort);
	}

	/**
	 * @param $actid
	 * @param $ids
	 * @param string $oper in 或者 not in
	 */
	public function deleteHasExist($actid,$ids,$oper='in'){
		$where      = array();
		$where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
		$where[]    = array('name' => 'fr_actid', 'oper' => '=', 'value' => $actid);
		$where[]    = array('name' => $this->_pk, 'oper' => $oper, 'value' => $ids);
		return $this->deleteValue($where);
	}


}