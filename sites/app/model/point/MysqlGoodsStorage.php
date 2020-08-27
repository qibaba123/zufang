<?php

class App_Model_Point_MysqlGoodsStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $goods_table;
    private $match_table;
	private $curr_table;

	public function __construct($sid = null){
		$this->_table 	= 'point_goods';
		$this->_pk 		= 'pg_id';
		$this->_shopId 	= 'pg_s_id';
		parent::__construct();

        $this->sid      = $sid;
		$this->goods_table = DB::table('goods');
		$this->curr_table	= DB::table($this->_table);
	}

	/**
	 * @param $value
	 * @return bool
	 * 批量插入
	 */
	public function insertBatch($value){
		$sql  = 'INSERT INTO '.DB::table($this->_table);
		$sql .= ' (`pg_id`, `pg_s_id`, `pg_actid`, `pg_g_id`, `pg_limit`, `pg_has_format`, `pg_num`, `pg_point`, `pg_add_time`) ';
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
     * @param string|null $keyword
     * @return array|bool
     * 根据活动ID获取商品列表
     */
    public function getCountByActid($actid, $keyword = null){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'pg_actid', 'oper' => '=', 'value' => $actid);
        $sql = 'SELECT count(*) ';
        $sql .= ' FROM '.DB::table($this->_table).' AS pg ';
        $sql .= ' INNER JOIN '.$this->goods_table.' AS g ON pg_g_id=g_id ';
        if ($keyword) {
            $sql .= " AND g.g_name LIKE ".DB::quote("%{$keyword}%")." ";
        }
        $sql .= $this->formatWhereSql($where);

        $ret  = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
	/**
	 * @param $actid
     * @param string|null $keyword
	 * @param $index
	 * @param $count
	 * @return array|bool
	 * 根据活动ID获取商品列表
	 */
	public function getListByActid($actid, $keyword = null, $index = 0, $count = 0){
		$where      = array();
		$where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
		$where[]    = array('name' => 'pg_actid', 'oper' => '=', 'value' => $actid);
		$sql = 'SELECT pg.*,g.g_name,g.g_cover,g.g_price ';
		$sql .= ' FROM '.DB::table($this->_table).' AS pg ';
		$sql .= ' INNER JOIN '.$this->goods_table.' AS g ON pg_g_id=g_id ';
        if ($keyword) {
            $sql .= " AND g.g_name LIKE ".DB::quote("%{$keyword}%")." ";
        }
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
		$where[]    = array('name' => 'pg_actid', 'oper' => '=', 'value' => $actid);
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
		$where[]    = array('name' => 'pg_actid', 'oper' => '=', 'value' => $actid);
		$where[]    = array('name' => 'pg_g_id', 'oper' => '=', 'value' => $gid);

		return $this->getRow($where);
	}
	/*
	 * 获取商品详情
	 */
	public function findGoodsByGid($gid, $actid) {
		$where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
		$where[]    = array('name' => 'pg_actid', 'oper' => '=', 'value' => $actid);
		$where[]    = array('name' => 'pg_g_id', 'oper' => '=', 'value' => $gid);

		$sql	= "SELECT pg.*,g.* FROM `{$this->curr_table}` AS pg ";
		$sql	.= "LEFT JOIN `{$this->goods_table}` AS g ON pg.pg_g_id=g.g_id ";
		$sql	.= $this->formatWhereSql($where);

		$ret  = DB::fetch_first($sql);
		if ($ret === false) {
			trigger_error("query mysql failed.", E_USER_ERROR);
			return false;
		}
		return $ret;
	}

	/*
     * 设置已兑换量自增或自减
     */
	public function incrementExchangeNum($actid, $gid, $num = 1) {
		$field  = array('pg_had');
		$inc    = array($num);

		$where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
		$where[]    = array('name' => 'pg_actid', 'oper' => '=', 'value' => $actid);
		$where[]    = array('name' => 'pg_g_id', 'oper' => '=', 'value' => $gid);

		$sql = $this->formatIncrementSql($field, $inc, $where);
		return DB::query($sql);
	}
}