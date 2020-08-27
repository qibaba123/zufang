<?php

class App_Model_Point_MysqlGoodsFormatStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $format_table;
	private $curr_table;

	public function __construct($sid = null){
		$this->_table 	= 'point_goods_format';
		$this->_pk 		= 'pgf_id';
		$this->_shopId 	= 'pgf_s_id';
		parent::__construct();

        $this->sid      = $sid;
		$this->format_table = DB::table('goods_format');
		$this->curr_table	= DB::table($this->_table);
	}

	/**
	 * @param $value
	 * @return bool
	 * 批量插入
	 */
	public function insertBatch($value){
		$sql  = 'INSERT INTO '.DB::table($this->_table);
		$sql .= ' (`pgf_id`, `pgf_s_id`, `pgf_actid`, `pgf_g_id`, `pgf_gf_id`, `pgf_num`, `pgf_point`, `pgf_add_time`) ';
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
	 * @param int $index
	 * @param int $count
	 * @return array|bool
	 * 根据活动ID，获取规格
	 */
	public function getListByActid($actid,$index=0,$count=0){
		$where      = array();
		$where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
		$where[]    = array('name' => 'pgf_actid', 'oper' => '=', 'value' => $actid);
		return $this->getList($where,$index,$count);
	}

	/**
	 * @param $actid
	 * @param int $index
	 * @param int $count
	 * @return array|bool
	 * 根据活动ID，获取规格信息
	 */
	public function getFormatListByActid($actid,$index=0,$count=0){
		$where      = array();
		$where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
		$where[]    = array('name' => 'pgf_actid', 'oper' => '=', 'value' => $actid);
		$sql = 'SELECT pgf.* , gf_name, gf_price, gf_stock  ';
		$sql .= ' FROM '.DB::table($this->_table) . ' pgf ';
		$sql .= ' LEFT JOIN '.$this->format_table.' gf on gf_id = pgf_gf_id ';
		$sql .= $this->formatWhereSql($where);
		$sql .= $this->formatLimitSql($index,$count);

		$ret  = DB::fetch_all($sql);
		if ($ret === false) {
			trigger_error("query mysql failed.", E_USER_ERROR);
			return false;
		}
		return $ret;
	}
	/*
	 * 获取商品规格
	 */
	public function getGoodsFormat($gid, $actid) {
		$where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
		$where[]    = array('name' => 'pgf_actid', 'oper' => '=', 'value' => $actid);
		$where[]    = array('name' => 'pgf_g_id', 'oper' => '=', 'value' => $gid);

		$sql	= "SELECT pgf.*, gf.* FROM `{$this->curr_table}` AS pgf ";
		$sql	.= "LEFT JOIN `{$this->format_table}` AS gf ON pgf.pgf_gf_id=gf.gf_id ";
		$sql	.= $this->formatWhereSql($where);

		$ret  = DB::fetch_all($sql);
		if ($ret === false) {
			trigger_error("query mysql failed.", E_USER_ERROR);
			return false;
		}
		return $ret;
	}
	/*
	 * 查找积分规格商品
	 */
	public function findPointFormat($gfid, $gid, $actid) {
		$where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
		$where[]    = array('name' => 'pgf_gf_id', 'oper' => '=', 'value' => $gfid);
		$where[]    = array('name' => 'pgf_actid', 'oper' => '=', 'value' => $actid);
		$where[]    = array('name' => 'pgf_g_id', 'oper' => '=', 'value' => $gid);

		$sql	= "SELECT pgf.*,gf.* FROM `{$this->curr_table}` AS pgf ";
		$sql	.= "LEFT JOIN `{$this->format_table}` AS gf ON pgf.pgf_gf_id=gf.gf_id ";
		$sql	.= $this->formatWhereSql($where);

		$ret  = DB::fetch_first($sql);
		if ($ret === false) {
			trigger_error("query mysql failed.", E_USER_ERROR);
			return false;
		}
		return $ret;
	}

	/*
	 * @param $actid
	 * @param $ids
	 * @param string $oper in 或者 not in
	 */
	public function deleteHasExist($actid,$ids=array(),$oper='in'){
		$where      = array();
		$where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
		$where[]    = array('name' => 'pgf_actid', 'oper' => '=', 'value' => $actid);
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
		$where[]    = array('name' => 'pgf_actid', 'oper' => '=', 'value' => $actid);
		$where[]    = array('name' => 'pgf_g_id', 'oper' => '=', 'value' => $gid);

		return $this->getRow($where);
	}

	/*
     * 设置已兑换量自增或自减
     */
	public function incrementExchangeNum($actid, $gid, $gfid, $num = 1) {
		$field  = array('pgf_had');
		$inc    = array($num);

		$where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
		$where[]    = array('name' => 'pgf_actid', 'oper' => '=', 'value' => $actid);
		$where[]    = array('name' => 'pgf_g_id', 'oper' => '=', 'value' => $gid);
		$where[]    = array('name' => 'pgf_gf_id', 'oper' => '=', 'value' => $gfid);

		$sql = $this->formatIncrementSql($field, $inc, $where);
		return DB::query($sql);
	}
}