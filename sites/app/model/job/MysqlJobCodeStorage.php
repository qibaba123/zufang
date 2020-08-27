<?php
/*
 * 问答小程序首页配置
 */
class App_Model_Job_MysqlJobCodeStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    public function __construct($sid){
        $this->_table 	= 'applet_job_code';
        $this->_pk 		= 'ajc_id';
        $this->_shopId 	= 'ajc_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }

    public function getCodeByPid($pid, $mid){
        $where[] = array('name' => 'ajc_ajp_id', 'oper' => '=', 'value' => $pid);
        $where[] = array('name' => 'ajc_m_id', 'oper' => '=', 'value' => $mid);
        $code = $this->getRow($where);
        return $code['ajc_code'];
    }

    public function getCodeByCid($cid, $mid){
        $where[] = array('name' => 'ajc_ajc_id', 'oper' => '=', 'value' => $cid);
        $where[] = array('name' => 'ajc_m_id', 'oper' => '=', 'value' => $mid);
        $code = $this->getRow($where);
        return $code['ajc_code'];
    }

}