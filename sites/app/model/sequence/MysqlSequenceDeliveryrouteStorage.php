<?php
/**
 * 社区团购 配送路线
 * zhangzc
 * 2019-07-04
 */
class App_Model_Sequence_MysqlSequenceDeliveryrouteStorage extends Libs_Mvc_Model_BaseModel{
	public function __construct($sid){
		parent::__construct();
		$this->sid 		= $sid;
		$this->_table	= 'applet_sequence_delivery_route';
		$this->_pk 		= 'asdr_id';
        $this->_shopId 	= 'asdr_s_id';
	}
	/**
	 * 获取配送路线的数量信息
	 * @param  array  $where 	[description]
	 * @param  array  $is_join 	[description]
	 * @return [type]        	[description]
	 */
	public function getRouteCount($where=[],$is_join=false){
		if($is_join){
			// 关联路线详细与小区表-查询小区名字的数据
			$sql=sprintf('SELECT COUNT(*) FROM `%s` 
				LEFT JOIN `%s` ON `asdr_id`=`asdrt_dr_id` 
				LEFT JOIN `%s` ON `asdrt_community_id`=`asc_id` ',
				DB::table($this->_table),
				'pre_applet_sequence_delivery_route_detail',
				'pre_applet_sequence_community');
		}
		else{
			$sql=sprintf('SELECT COUNT(*) FROM `%s` ',DB::table($this->_table));
		}

		$sql.=$this->formatWhereSql($where);
		$res=DB::result_first($sql);
		if($res===false){
			trigger_error('mysql query failed.',E_USER_ERROR);
		}
		return $res;
	}

	/**
	 * 配送路线表
	 * @param  [type]  $where   [description]
	 * @param  integer $index   [description]
	 * @param  integer $count   [description]
	 * @param  array   $sort    [description]
	 * @param  boolean $is_join [是否连接查询]
	 * @return [type]           [description]
	 */
	public function getRouteList($where,$index=0,$count=20,$sort=[],$is_join=false){
		if($is_join){
			// 关联路线详细与小区表-查询小区名字的数据
			$sql=sprintf('SELECT asdr.* FROM `%s` AS asdr 
				LEFT JOIN `%s` ON `asdr_id`=`asdrt_dr_id` 
				LEFT JOIN `%s` ON `asdrt_community_id`=`asc_id` ',
				DB::table($this->_table),
				'pre_applet_sequence_delivery_route_detail',
				'pre_applet_sequence_community');
		}else{
			$sql=sprintf('SELECT asdr.* FROM `%s` AS asdr ',
				DB::table($this->_table));
		}
		$sql.=$this->formatWhereSql($where);
		$sql.=$this->getSqlSort($sort);
		$sql.=$this->formatLimitSql($index,$count);
		$res=DB::fetch_all($sql);
		if($res===false){
			trigger_error('mysql query failed',E_USER_ERROR);
		}
		return $res;
	}

	/**
	 * 自增或者是自减 指定的数值
	 * @param  [type] $field_name [description]
	 * @param  array  $where      [description]
	 * @param  array  $inc        [description]
	 * @return [type]             [description]
	 */
	public function incrementField($field_name=[],$where=[],$inc=1){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sql = $this->formatIncrementSql($field_name, $inc, $where);
        return DB::query($sql);
	}
}