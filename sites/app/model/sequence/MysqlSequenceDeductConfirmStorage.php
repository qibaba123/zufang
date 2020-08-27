<?php
/*
 * 爆品分销 团长分佣结算记录表
 */
class App_Model_Sequence_MysqlSequenceDeductConfirmStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_sequence_deduct_confirm';
        $this->_pk = 'asdc_id';
        $this->_shopId = 'asdc_s_id';
        $this->sid = $sid;
    }


    public function getListLeader($leaderId,$index,$count){
        $where = [];
        $where[] = array('name'=>'asdc_s_id','oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'asdc_leader','oper'=>'=','value'=>$leaderId);
        $sort = array('asdc_create_time' => 'desc');
        return $this->getList($where,$index,$count,$sort);
    }




}