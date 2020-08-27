<?php
/**
 * 社区团购 配送路线 路线关联小区
 * zhangzc
 * 2019-07-04
 */
class App_Model_Sequence_MysqlSequenceDeliveryroutedetailStorage extends Libs_Mvc_Model_BaseModel{
	public function __construct($sid){
		parent::__construct();
		$this->sid 		= $sid;
		$this->_table	= 'applet_sequence_delivery_route_detail';
		$this->_pk 		= 'asdrt_id';
        $this->_shopId 	= 'asdrt_s_id';
	}

	/**
	 * 获取指定路线的小区的列表
	 * @param  [type]  $where [description]
	 * @param  integer $index [description]
	 * @param  integer $count [description]
	 * @param  [type]  $sort  [description]
	 * @return [type]         [description]
	 */
	public function getDeliveryDetailList($where,$index=0,$count=20,$sort=[]){
		$sql=sprintf('SELECT `asdrt_id`,`asdrt_community_id`,`asdrt_sort`,`asdrt_create_time`,`asl_name`,`asl_mobile`,`asc_name` FROM `%s` 
			LEFT JOIN `pre_applet_sequence_community` ON `asc_id`=`asdrt_community_id`
			LEFT JOIN `pre_applet_sequence_leader` ON `asc_leader`=`asl_id` ',
			DB::table($this->_table));
		$where[]=['name'=>'asdrt_s_id','oper'=>'=','value'=>$this->sid];
//		$where[]=['name'=>'asdrt_deleted','oper'=>'=','value'=>0];
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
	 * 获取配送路线中所属的社区与团长相关信息
	 * @param  [type] $route_id [description]
	 * @return [type]           [description]
	 */
	public function getCommunityAndLeaderInfo($route_id){
		$sql=sprintf('SELECT `asc_name`,`asc_address`,`asl_name`,`asl_mobile`,`asl_id`,`asc_id` FROM `%s` 
			LEFT JOIN `pre_applet_sequence_community` ON `asc_id`=`asdrt_community_id` 
			LEFT JOIN `pre_applet_sequence_leader` ON `asl_id`=`asc_leader` ',
			DB::table($this->_table));
		$where[]=['name'=>'asdrt_dr_id','oper'=>'=','value'=>$route_id];
		$where[]=['name'=>'asdrt_s_id','oper'=>'=','value'=>$this->sid];
//		$where[]=['name'=>'asdrt_deleted','oper'=>'=','value'=>0];
		$sql.=$this->formatWhereSql($where);
		$res=DB::fetch_all($sql);
		if($res===false){
			trigger_error('mysql query failed',E_USER_ERROR);
		}
		return $res;
	}


    /**
     * 根据配送线路社区id
     * @param  [type] $community_id [description]
     * @return [type]           [description]
     */
    public function getRouteInfo($community_id){
        $sql=sprintf('SELECT asdr.* FROM `%s` 
			LEFT JOIN `pre_applet_sequence_delivery_route` asdr ON `asdr_id`=`asdrt_dr_id` ',
            DB::table($this->_table));
        $where[]=['name'=>'asdrt_community_id','oper'=>'=','value'=>$community_id];
        $where[]=['name'=>'asdrt_s_id','oper'=>'=','value'=>$this->sid];
//        $where[]=['name'=>'asdrt_deleted','oper'=>'=','value'=>0];
        $sql.=$this->formatWhereSql($where);
        $res=DB::fetch_first($sql);
        if($res===false){
            trigger_error('mysql query failed',E_USER_ERROR);
        }
        return $res;
    }
}