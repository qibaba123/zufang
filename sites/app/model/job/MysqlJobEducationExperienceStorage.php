<?php
/*
 * 问答小程序首页配置
 */
class App_Model_Job_MysqlJobEducationExperienceStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    public function __construct($sid){
        $this->_table 	= 'applet_job_education_experience';
        $this->_pk 		= 'ajee_id';
        $this->_shopId 	= 'ajee_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }

    //根据简历id获取列表
    public function getListByRId($rid){
        $where[] = array('name' => 'ajee_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajee_ajr_id', 'oper' => '=', 'value' => $rid);
        $where[] = array('name' => 'ajee_deleted', 'oper' => '=', 'value' => 0);
        $sort = array('ajee_create_time' => 'ASC');
        return $this->getList($where, 0, 0, $sort);
    }


}