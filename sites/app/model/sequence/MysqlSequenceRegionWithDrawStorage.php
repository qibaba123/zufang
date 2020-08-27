<?php
/**
 * 社区团购 区域管理合伙人 提现申请记录表
 */
class App_Model_Sequence_MysqlSequenceRegionWithDrawStorage extends Libs_Mvc_Model_BaseModel{
	public function __construct($sid){
		parent::__construct();
		$this->sid=$sid;
		$this->_table   = 'applet_region_withdraw_record';
	}

	/**
	 * 获取用户已经提现的金额sum总和
	 * @prams. $all 包含审核中的提现金额
	 * @return [type] [description]
	 */
	public function getAlreadySum($manager_id,$all=false){
		$sql=sprintf('SELECT SUM(`arwr_money`) AS total FROM `%s` ',
			DB::table($this->_table));
		$where=[
			['name'=>'arwr_manager_id','oper'=>'=','value'=>$manager_id],
			['name'=>'arwr_s_id','oper'=>'=','value'=>$this->sid]
		];
		if($all){
			$where[]=['name'=>'arwr_status','oper'=>'in','value'=>[0,1]];
		}else{
			$where[]=['name'=>'arwr_status','oper'=>'=','value'=>1];
		}
		$sql.=$this->formatWhereSql($where);
		$ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
	}
	/**
	 * 管理员获取区域合伙人的提现申请列表
	 * @param  [type] $index [description]
	 * @param  [type] $count [description]
	 * @param  [type] $user_id [用户编号]
	 * @return [type]        [description]
	 */
	public function getWithdrawList($index,$count,$user_id=0){
		$sql=sprintf('SELECT withdraw.*,`m_nickname`,`m_mobile`,`region_name` FROM `%s` AS withdraw 
						LEFT JOIN `%s` ON `m_id`=`arwr_manager_id` 
						LEFT JOIN `%s` ON `region_id`=`m_area_id` ',
					DB::table($this->_table),
					'pre_manager',
					'dpl_china_address');
		$where=[
			['name'=>'arwr_s_id','oper'=>'=','value'=>$this->sid],
		];
		if($user_id){
			$where[]=['name'=>'arwr_manager_id','oper'=>'=','value'=>$user_id];
			$sort=['arwr_create_at'=>'DESC'];
		}else{
			$sort=['arwr_status'=>'ASC','arwr_create_at'=>'ASC'];
			
		}

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
	 * 获取微信提现时所需要用到的记录数据与用户数据
	 * @param  [type] $where [description]
	 * @return [type]        [description]
	 */
	public function getWxpayMangerInfo($where){
		$sql=sprintf('SELECT `m_nickname`,`m_wx_openid`,`arwr_money` FROM `%s` 
				LEFT JOIN `%s` ON `m_id`=`arwr_manager_id`',
				DB::table($this->_table),
				'pre_manager');
		$sql.=$this->formatWhereSql($where);
		$ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
	}
}