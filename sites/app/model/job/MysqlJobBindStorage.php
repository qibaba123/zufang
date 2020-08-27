<?php
/*
 * 问答小程序首页配置
 */
class App_Model_Job_MysqlJobBindStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    public function __construct($sid){
        $this->_table 	= 'applet_job_bind';
        $this->_pk 		= 'ajb_id';
        $this->_shopId 	= 'ajb_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }

    //校验登录
    public function verifyLogin($mid){
        $where[] = array('name' => 'ajb_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajb_m_id', 'oper' => '=', 'value' => $mid);
        return $this->getRow($where);
    }

    //添加会员与公司的绑定
    public function bind($mid, $esId){
        $data = array(
            'ajb_s_id' => $this->sid,
            'ajb_m_id' => $mid,
            'ajb_es_id' => $esId,
            'ajb_create_time' => time(),
        );
        return $this->insertValue($data);
    }

    //解除会员与公司的绑定
    public function unBind($mid){
        $where[] = array('name' => 'ajb_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajb_m_id', 'oper' => '=', 'value' => $mid);
        return $this->deleteValue($where);
    }


}