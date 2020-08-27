<?php

class App_Model_Coupon_MysqlCouponGoodsStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

	public function __construct($sid = null){
		$this->_table 	= 'coupon_goods';
		$this->_pk 		= 'cg_id';
		$this->_shopId 	= 'cg_s_id';
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
		$sql .= ' (`cg_id`, `cg_s_id`, `cg_yhid`, `cg_g_id`, `cg_create_time`) ';
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
		$where[]    = array('name' => 'g_s_id', 'oper' => '=', 'value' => $this->sid);
		$where[]    = array('name' => 'cg_yhid', 'oper' => '=', 'value' => $actid);
		$sql = 'SELECT cg_id, g_id,g_name,cg_g_id,g_cover,g_price,g_ori_price,g.g_stock,g.g_sold,g.g_brief,g.g_limit ';
		$sql .= ' FROM '.DB::table($this->_table);
		$sql .= ' LEFT JOIN pre_goods g on g_id=cg_g_id ';
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
		$where[]    = array('name' => 'cg_yhid', 'oper' => '=', 'value' => $actid);
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
		$where[]    = array('name' => 'cg_yhid', 'oper' => '=', 'value' => $actid);
		$where[]    = array('name' => 'cg_g_id', 'oper' => '=', 'value' => $gid);

		return $this->getRow($where);
	}

	public function getGoodsLimit($actid,$index = 0,$count = 0){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'cg_yhid', 'oper' => '=', 'value' => $actid);
        return $this->getList($where,$index,$count);
    }
}