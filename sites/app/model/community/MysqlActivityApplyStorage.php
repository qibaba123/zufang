<?php

class App_Model_Community_MysqlActivityApplyStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id

    public function __construct($sid=0)
    {
        parent::__construct();
        $this->_table  = 'applet_activity_apply';
        $this->_pk     = 'aap_id';
        $this->_shopId = 'aap_s_id';

        $this->sid     = $sid;
    }
    /*
     * 判断用户是否申请过此次活动
     */
    public function getRowByUid($uid,$isjoin=false){
        $where    = array();
        $where[]  = array('name'=>'aap_s_id','oper'=>'=','value'=>$this->sid);
        $where[]  = array('name'=>'aap_m_id','oper'=>'=','value'=>$uid);
        /*if(!$isjoin){
            $where[]  = array('name'=>'aap_status','oper'=>'in','value'=>array(0,1));
        }*/
        $sort     = array('aap_id'=>'DESC','aap_create_time'=>'DESC');
        $row      = $this->getList($where,0,0,$sort);
        if($row){
            return $row[0];
        }else{
            return false;
        }
    }



}