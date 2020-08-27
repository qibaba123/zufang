<?php
/**
 * 新用户邀请记录对应产生的订单
 * zhangzc
 * 2019-08-25
 */
class App_Model_Userinvite_MysqlUserinviteUserRecommendTradeStorage extends Libs_Mvc_Model_BaseModel{
	public function __construct($sid){
		parent::__construct();
		$this->sid 	   	=$sid;
		$this->_pk     	='asurt_id';
		$this->_table  	='applet_sequence_user_recommend_trade';
		$this->_shopId 	='asurt_sid';
	}
}