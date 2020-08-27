<?php

class App_Model_Applet_MysqlAppletInformationExtraStorage extends Libs_Mvc_Model_BaseModel{
    private $sid;
    public function __construct($sid){
        $this->_table 	= 'applet_information_extra';
        $this->_pk 		= 'aie_id';
        $this->_shopId 	= 'aie_s_id';
        $this->sid = $sid;
        parent::__construct();
    }

    /**
     * 根据会员id获取会员信息
     */
    public function findUpdateExtraByAid($aid, $updata=array()){
        $where = array();
        $where[] = array('name' => 'aie_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'aie_ai_id', 'oper' => '=', 'value' => $aid);
        if (!$updata) {
            return $this->getRow($where);
        } else {
            return $this->updateValue($updata, $where);
        }
    }


}