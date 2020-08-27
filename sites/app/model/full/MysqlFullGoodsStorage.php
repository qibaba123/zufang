<?php

class App_Model_Full_MysqlFullGoodsStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $format_table;
    private $match_table;

	public function __construct($sid = null){
		$this->_table 	= 'full_goods';
		$this->_pk 		= 'fg_id';
		$this->_shopId 	= 'fg_s_id';
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
		$sql .= ' (`fg_id`, `fg_s_id`, `fg_actid`, `fg_gid`, `fg_act_type`, `fg_update_time`) ';
		$sql .= ' VALUES ';
		$sql .= implode(',',$value);
		$ret = DB::query($sql);

		if ($ret === false) {
			trigger_error("query mysql failed.", E_USER_ERROR);
			return false;
		}
		return $ret;
	}

//    public function insertBacthNew($value){
//        $sql  = 'INSERT INTO '.DB::table($this->_table);
//        $sql .= ' (`fg_id`, `fg_s_id`,`fg_es_id`, `fg_actid`, `fg_gid`, `fg_act_type`, `fg_update_time`) ';
//        $sql .= ' VALUES ';
//        $sql .= implode(',',$value);
//        $ret = DB::query($sql);
//
//        if ($ret === false) {
//            trigger_error("query mysql failed.", E_USER_ERROR);
//            return false;
//        }
//        return $ret;
//    }

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
		$where[]    = array('name' => 'g_s_id', 'oper' => '=', 'value' => $this->sid);
		$where[]    = array('name' => 'fg_actid', 'oper' => '=', 'value' => $actid);
		$sql = 'SELECT fg_id, fg_gid,g_name ';
		$sql .= ' FROM '.DB::table($this->_table);
		$sql .= ' LEFT JOIN pre_goods g on g_id=fg_gid ';
		$sql .= $this->formatWhereSql($where);
		$sql .= $this->formatLimitSql($index,$count);

		$ret  = DB::fetch_all($sql);
		if ($ret === false) {
			trigger_error("query mysql failed.", E_USER_ERROR);
			return false;
		}
		return $ret;
	}

	/**
	 * @param $actid
	 * @param $ids
	 * @param string $oper in 或者 not in
	 */
	public function deleteHasExist($actid,$ids=array(),$oper='in'){
		$where      = array();
		$where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
		$where[]    = array('name' => 'fg_actid', 'oper' => '=', 'value' => $actid);
		if(!empty($ids) && $oper){
			$where[]    = array('name' => $this->_pk, 'oper' => $oper, 'value' => $ids);
		}
		return $this->deleteValue($where);
	}
	/*
	 * 商品是否参与优惠活动
	 */
	public function actExistGid($gid, $actid) {
		$where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
		$where[]    = array('name' => 'fg_actid', 'oper' => '=', 'value' => $actid);
		$where[]    = array('name' => 'fg_gid', 'oper' => '=', 'value' => $gid);

		return $this->getRow($where);
	}
}