<?php
/*
 * 问答小程序首页配置
 */
class App_Model_Job_MysqlJobWorkExperienceStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    public function __construct($sid){
        $this->_table 	= 'applet_job_work_experience';
        $this->_pk 		= 'ajwe_id';
        $this->_shopId 	= 'ajwe_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }


    //根据简历id获取列表
    public function getListByRId($rid){
        $where[] = array('name' => 'ajwe_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajwe_ajr_id', 'oper' => '=', 'value' => $rid);
        $where[] = array('name' => 'ajwe_deleted', 'oper' => '=', 'value' => 0);
        $sort = array('ajwe_create_time' => 'ASC');
        return $this->getList($where, 0, 0, $sort);
    }

}