<?php
/**
 * 社区团购 团长推荐人佣金记录
 * zhanzgc
 * 2019-04-25
 */
class App_Model_Sequence_MysqlSequenceRecmdRewardStorage extends Libs_Mvc_Model_BaseModel{
	public function __construct($sid){
		parent::__construct();
		$this->_table 	= 'applet_sequence_recmd_reward';
        $this->_pk 		= 'asrr_id';
        $this->_shopId 	= 'asrr_s_id';
        $this->sid  = $sid;
	}


	/**
	 * 获取佣金奖励的条目列表
	 * @param  [type] $where [description]
	 * @param  [type] $index [description]
	 * @param  [type] $count [description]
	 * @param  [type] $sort  [description]
	 * @return [type]        [description]
	 */
	public function getRewardList($where,$index,$count,$sort){
		$sql=sprintf('SELECT asrr.*,leader.asl_name,leader.asl_mobile FROM %s AS asrr 
			LEFT JOIN `%s` AS leader ON `asl_id` =`asrr_leader` ',
			DB::table($this->_table),
			'pre_applet_sequence_leader');
		$where[]=['name'=>'asrr_s_id','oper'=>'=','value'=>$this->sid];
		$sql.=$this->formatWhereSql($where);
		$sql.=$this->getSqlSort($sort);
		$sql.=$this->formatLimitSql($index,$count);
		$ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
	}
	/**
	 * [getLeaderReward 获取被推荐团长每个人给推荐者带来的推荐收益]
	 * @param  [type] $parent_leader_id [description]
	 * @param  array  $leader_ids       [description]
	 * @return [type]                   [description]
	 */
	public function getLeaderReward($parent_leader_id,$leader_ids=[0]){
		$sql=sprintf('SELECT `t_se_leader`,SUM(`asrr_money`) AS money FROM %s 
			LEFT JOIN `pre_trade` ON `t_tid`=`asrr_tid` ',
			DB::table($this->_table));
		$where=[
			['name'=>'asrr_leader','oper'=>'=','value'=>$parent_leader_id],
			['name'=>'t_se_leader','oper'=>'in','value'=>$leader_ids],
		];
		$sql.=$this->formatWhereSql($where);
		$sql.=' GROUP BY `t_se_leader` ';
		$res=DB::fetch_all($sql);
		if($res===false){
			trigger_error('mysql query failed',E_USER_ERROR);
		}
		return $res;
	}
	/**
	 * [getLeaderRewardList 团长推荐的人员的订单佣金记录]
	 * @param  [type] $leader_id [团长id]
	 * @return [type]            [description]
	 */
	public function getLeaderRewardList($leader_parent_id,$leader_id,$index=0,$count){
		$sql=sprintf('SELECT `t_express_method`,`t_tid`,`t_create_time`,`asrr_money`,`asc_name` FROM `%s` 
            LEFT JOIN `pre_trade` ON `t_tid` = `asrr_tid` 
            LEFT JOIN `pre_applet_sequence_community` ON `asc_id`=`t_home_id` ',
            DB::table($this->_table));
        $where=[
            ['name'=>'asrr_s_id','oper'=>'=','value'=>$this->sid],
            ['name'=>'t_se_leader','oper'=>'=','value'=>$leader_id],
            ['name'=>'asrr_leader','oper'=>'=','value'=>$leader_parent_id],
        ];
        $sql.=$this->formatWhereSql($where);
        $sql.=$this->getSqlSort(['t_create_time'=>'DESC']);
        $sql.=$this->formatLimitSql($index,$count);

        $res=DB::fetch_all($sql);
        if($res===false){
        	trigger_error('mysql query failed.',E_USER_ERROR);
        }
        return $res;
	}
}