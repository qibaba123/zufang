<?php

class App_Model_Gamebox_MysqlGameboxTaskProgressStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_gamebox_task_progress';
        $this->_pk = 'agtp_id';
        $this->_shopId = 'agtp_s_id';
        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    public function getRowByTidMid($tid, $mid){
        $where = array();
        $where[] = array('name' => 'agtp_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'agtp_m_id', 'oper' => '=', 'value' => $mid);
        $where[] = array('name' => 'agtp_agt_id', 'oper' => '=', 'value' => $tid);
        $where[] = array('name' => 'agtp_create_time', 'oper' => '>', 'value' => strtotime(date('Y-m-d', time())));
        return $this->getRow($where);
    }

    public function getUnReceiveByTidMid($tid, $mid){
        $where = array();
        $where[] = array('name' => 'agtp_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'agtp_m_id', 'oper' => '=', 'value' => $mid);
        $where[] = array('name' => 'agtp_status', 'oper' => '=', 'value' => 1);
        $where[] = array('name' => 'agtp_agt_id', 'oper' => '=', 'value' => $tid);
        $where[] = array('name' => 'agtp_create_time', 'oper' => '>', 'value' => strtotime(date('Y-m-d', time())));
        return $this->getRow($where);
    }

    public function getListByTidMid($tid, $mid){
        $where = array();
        $where[] = array('name' => 'agtp_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'agtp_m_id', 'oper' => '=', 'value' => $mid);
        $where[] = array('name' => 'agtp_agt_id', 'oper' => '=', 'value' => $tid);
        $where[] = array('name' => 'agtp_create_time', 'oper' => '>', 'value' => strtotime(date('Y-m-d', time())));
        return $this->getList($where, 0, 0, array('agtp_create_time' => 'desc'));
    }
}