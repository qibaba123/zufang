<?php
/**
 * 社区团购区域合伙人公用方法提取
 * zhangzc
 * 2019-06-14
 */
class App_Helper_SequenceRegion{

	private $sid;
	/**
	 * [__construct 构造函数]
	 * @param integer $sid [店铺id]
	 */
	public function __construct($sid=0){
		$this->sid=$sid;
	}
	/**
	 * [get_area_manager 判断当前用户是否为区域合伙人]
	 * @param  [type] $uid     [用户id  在initController中  $this->uid]
	 * @param  [type] $company [公司id  在initController中  $this->company['c_id']]
	 * @return [type]          [description]
	 */
    public function get_area_manager($uid,$company){
        $manager_model = new App_Model_Member_MysqlManagerStorage();
        $info=$manager_model->getSingleManagerWithArea($uid,$company);
        if($info){
            return [
                'm_area_id'     =>$info['m_area_id'],
                'm_area_type'   =>$info['m_area_type'],
                'region_name'   =>$info['region_name'],
                'region_child'  =>$info['m_area_region_child'], //是否是区域合伙人的子操作员
            ];
        }else{
            return null;
        }
    }
}