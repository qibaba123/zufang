<?php
/**
 * 社区团购会员推荐奖励Model
 * zhangzc
 * 2019-08-22
 */
class App_Model_Userinvite_MysqlUserinviteUserRecommendStorage extends Libs_Mvc_Model_BaseModel{
	public function __construct($sid){
		parent::__construct();
		$this->sid 	   	=$sid;
		$this->_pk     	='asur_id';
		$this->_table  	='applet_sequence_user_recommend';
		$this->_shopId 	='asur_sid';
	}

	/**
	 * 获取当前正在进行的活动(只获取一个活动)
	 * @return [type] [description]
	 */
	public function getActiveAct(){
		$sql=sprintf('SELECT * FROM `%s` ',
			DB::table($this->_table));
		// 查询条件是活动已开始并且活动未结束
		$where=[
			['name'=>'asur_sid','oper'=>'=','value'=>$this->sid],
			['name'=>'asur_deleted','oper'=>'=','value'=>0],
			['name'=>'asur_stime','oper'=>'<=','value'=>time()],
			['name'=>'asur_etime','oper'=>'>','value'=>time()]
		];
		$sql.=$this->formatWhereSql($where);
		$sql.=$this->getSqlSort(['asur_etime'=>'ASC']);
		// $sql.=$this->formatLimitSql(0,1);
		$res=DB::fetch_first($sql);
		if($res===false){
			trigger_error('mysql query failed.',E_USER_ERROR);
		}
		return $res;
	}

	/**
	 * 字段的自增与自减操作
	 * @param  array  $field [description]
	 * @param  array  $inc   [description]
	 * @param  array  $where [description]
	 * @return [type]        [description]
	 */
	public function incrementField($field=[],$inc=[],$where=[]){
		$sql=$this->formatIncrementSql($field,$inc,$where);
		return DB::query($sql);
	}
}