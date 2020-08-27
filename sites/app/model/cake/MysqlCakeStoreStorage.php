<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/26
 * Time: 上午11:55
 */
class App_Model_Cake_MysqlCakeStoreStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    public function __construct($sid){
        $this->_table 	= 'applet_cake_store';
        $this->_pk 		= 'acs_id';
        $this->_shopId 	= 'acs_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }

    /**
     * @return array|bool
     * 获取活动列表
     */
    public function findListBySid() {
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'acs_deleted','oper'=>'=','value'=>0);
        return $this->getList($where,0,0,array('acs_create_time'=>'DESC'));
    }
}