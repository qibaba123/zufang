<?php

class App_Model_Redbag_MysqlRedbagActivityStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_redbag_activity';
        $this->_pk     = 'ara_id';
        $this->_shopId = 'ara_s_id';
        $this->_df     = 'ara_deleted';
        $this->sid     = $sid;
    }

    public function getRowOpen(){
        $where = [];
        $where[] = ['name' => 'ara_s_id', 'oper' => '=', 'value' => $this->sid];
        $where[] = ['name' => 'ara_status', 'oper' => '=', 'value' => 1];
        return $this->getRow($where);
    }


}