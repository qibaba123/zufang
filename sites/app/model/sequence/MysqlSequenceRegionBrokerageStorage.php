<?php
/**
 * 社区团购区域管理合伙人佣金model
 */
 class App_Model_Sequence_MysqlSequenceRegionBrokerageStorage extends Libs_Mvc_Model_BaseModel{
 	public function __construct($sid){
 		parent::__construct();
 		$this->_table = 'applet_region_manager_brokerage';
        $this->_pk = 'armb_id';
        $this->_shopId = 'armb_s_id';
        $this->sid = $sid;
 	}

 	/**
 	 * 获取区域管理合伙人的佣金总额-以分为单位进行的存储于提取使用的时候需要除以100
 	 * @return [type] [description]
 	 */
 	public function getRegionBrokerageSum($manager_id){
 		$sql=sprintf('SELECT SUM(`armb_money`)  as total  FROM `%s` ',
			DB::table($this->_table));
 		$where=[
 			['name'=>'armb_s_id','oper'=>'=','value'=>$this->sid],
 			['name'=>'armb_manager_id','oper'=>'=','value'=>$manager_id],
 			['name'=>'armb_status','oper'=>'=','value'=>1]
 		];
 		$sql.=$this->formatWhereSql($where);
 		
 		$ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;

 	}
 }