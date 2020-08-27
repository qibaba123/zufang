<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/23
 * Time: 下午7:14
 */
class App_Model_System_MysqlNoticeStorage extends Libs_Mvc_Model_BaseModel{

    public function __construct(){
        $this->_table 	= 'system_notice';
        $this->_pk 		= 'sn_id';
        $this->_df      = 'sn_deleted';
        parent::__construct();
    }

    public function fetchSortList($index = 0, $count = 5, $type = 1) {
        $where[]    = array('name' => 'sn_deleted', 'oper' => '=', 'value' => 0);//获取未删除
        $where[]    = array('name' => 'sn_type', 'oper' => '=', 'value' => $type);//默认获取微商城的
        $sort   = array('sn_create_time' => 'DESC');

        return $this->getList($where, $index, $count, $sort);
    }

    public function fetchAppletList($index = 0, $count = 1, $type) {
        $where[]    = array('name' => 'sn_deleted', 'oper' => '=', 'value' => 0);//获取未删除
        $where[]    = array('name' => 'sn_type', 'oper' => '=', 'value' => 2);
        $where[]    = array('name' => 'sn_applet_type', 'oper' => '=', 'value' => $type);
        $sort   = array('sn_create_time' => 'DESC');

        return $this->getList($where, $index, $count, $sort);
    }

    public function fetchAppletCount($type) {
        $where[]    = array('name' => 'sn_deleted', 'oper' => '=', 'value' => 0);//获取未删除
        $where[]    = array('name' => 'sn_type', 'oper' => '=', 'value' => 2);
        $where[]    = array('name' => 'sn_applet_type', 'oper' => '=', 'value' => $type);

        return $this->getCount($where);
    }
}