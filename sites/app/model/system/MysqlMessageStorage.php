<?php
/**
 * Created by PhpStorm.
 * User: zhaoweizhen
 * Date: 16/9/1
 * Time: 下午3:14
 */
class App_Model_System_MysqlMessageStorage extends Libs_Mvc_Model_BaseModel{

    private $sid=0;
    public function __construct($sid){
        $this->_table 	= 'system_message';
        $this->_pk 		= 'sm_id';
        $this->_shopId  = 'sm_s_id';
        parent::__construct();
        $this->sid = $sid;
    }

    public function fetchUpdateByKindId($kid,$gid,$data=array()) {
        $where      = array();
        $where[]    = array('name' => 'sm_kind1', 'oper' => '=', 'value' => $kid);
        $where[]    = array('name' => 'sm_kind2', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if(!empty($data)){
            return $this->updateValue($data,$where);
        }else{
            return $this->getRow($where);
        }
    }

}