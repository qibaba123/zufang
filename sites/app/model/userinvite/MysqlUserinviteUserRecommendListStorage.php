<?php
/**
 * 新用户邀请记录表
 * zhangzc
 * 2019-08-24
 */
class App_Model_Userinvite_MysqlUserinviteUserRecommendListStorage extends Libs_Mvc_Model_BaseModel{
	public function __construct($sid){
		parent::__construct();
		$this->sid 	   	=$sid;
		$this->_pk     	='asurl_id';
		$this->_table  	='applet_sequence_user_recommend_list';
		$this->_shopId 	='asurl_sid';
	}
	/**
	 * 获取邀请列表
	 * @param  array  $where [description]
	 * @param  [type] $index [description]
	 * @param  [type] $count [description]
	 * @param  array  $sort  [description]
	 * @return [type]        [description]
	 */
	public function getInviteList($where=[],$index=0,$count=10,$sort=[]){
		$sql=sprintf('SELECT asurl.*,`m_nickname`,`m_avatar` FROM `%s` AS asurl 
			LEFT JOIN `pre_member` ON `asurl_reciever_mid`=`m_id` ',
			DB::table($this->_table));
		$sql.=$this->formatWhereSql($where);
		$sql.=$this->getSqlSort($sort);
		$sql.=$this->formatLimitSql($index,$count);
		$res=DB::fetch_all($sql);
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