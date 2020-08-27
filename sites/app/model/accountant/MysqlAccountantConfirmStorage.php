<?php

class App_Model_Accountant_MysqlAccountantConfirmStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_accountant_confirm';
        $this->_pk     = 'aac_id';
        $this->_shopId = 'aac_s_id';

        $this->sid     = $sid;
    }

    public function getRowByTypeId($type,$id,$status = 0){
        $where = [];
        $where[] = ['name'=>'aac_s_id','oper'=>'=','value'=>$this->sid];
        $where[] = ['name'=>'aac_confirm_id','oper'=>'=','value'=>$id];
        $where[] = ['name'=>'aac_type','oper'=>'=','value'=>$type];
        if($status){
            $where[] = ['name'=>'aac_handle_status','oper'=>'=','value'=>$status];
        }
        return $this->getRow($where);
    }




}
