<?php 
/**
 * 社区团购 区域管理合伙人（城市）
 * zhangzc
 * 2019-03-27
 */
class App_Model_Sequence_MysqlSequenceRegionGoodsStorage extends Libs_Mvc_Model_BaseModel{
	public function  __construct($sid){
		parent::__construct();
		$this->_table='applet_sequence_region_goods';
		$this->sid=$sid;
	}
	/**
	 * 获取区域管理合伙人所有限制购买的商品
	 * @param  [type] $region_id [description]
	 * @return [type]            [description]
	 */
	public function  getAllLimitGoods($region_id){
		$sql=sprintf('SELECT `asrg_goods_id` FROM `%s` ',
			DB::table($this->_table));
		$where=[
			['name'=>'asrg_region_id','oper'=>'=','value'=>$region_id],
			['name'=>'asrg_shop_id','oper'=>'=','value'=>$this->sid],
			['name'=>'asrg_limit_status','oper'=>'=','value'=>1]
		];
		$sql.=$this->formatWhereSql($where);
		$ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
	}
}