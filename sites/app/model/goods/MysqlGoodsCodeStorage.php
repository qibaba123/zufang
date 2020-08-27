<?php

class App_Model_Goods_MysqlGoodsCodeStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $curr_table;

	public function __construct($sid = null){
		$this->_table 	= 'applet_goods_code';
		$this->_pk 		= 'agc_id';
		$this->_shopId 	= 'agc_s_id';
		parent::__construct();

        $this->sid      = $sid;
        $this->curr_table   = DB::table($this->_table);
	}

    public function getCodeByGidMid($gid, $mid, $childAppid='',$appType = 1){
        $where = array();
        $where[] = array('name' => 'agc_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'agc_g_id', 'oper' => '=', 'value' => $gid);
        $where[] = array('name' => 'agc_m_id', 'oper' => '=', 'value' => $mid);
        $where[] = array('name' => 'agc_app_type', 'oper' => '=', 'value' => $appType);
        if($childAppid){
            $where[] = array('name' => 'agc_child_appid', 'oper' => '=', 'value' => $childAppid);
        }

        return $this->getRow($where);
    }

    public function getCodeByCidMid($cid, $mid, $childAppid=''){
        $where = array();
        $where[] = array('name' => 'agc_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'agc_course_id', 'oper' => '=', 'value' => $cid);
        $where[] = array('name' => 'agc_m_id', 'oper' => '=', 'value' => $mid);
        if($childAppid){
            $where[] = array('name' => 'agc_child_appid', 'oper' => '=', 'value' => $childAppid);
        }

        return $this->getRow($where);
    }

    public function getCodeByGroupIdMid($gid, $mid){
        $where = array();
        $where[] = array('name' => 'agc_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'agc_group_id', 'oper' => '=', 'value' => $gid);
        $where[] = array('name' => 'agc_m_id', 'oper' => '=', 'value' => $mid);

        return $this->getRow($where);
    }
}