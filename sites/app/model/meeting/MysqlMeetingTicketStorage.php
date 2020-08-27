<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/7/29
 * Time: 下午2:59
 */
class App_Model_Meeting_MysqlMeetingTicketStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    public function __construct($sid){
        $this->_table 	= 'applet_meeting_ticket';
        $this->_pk 		= 'amt_id';
        $this->_shopId 	= 'amt_s_id';
        $this->_df 	    = 'amt_deleted';
        parent::__construct();
        $this->sid = $sid;
    }
    /**
     * 获取分类选择使用
     */
    public function getCategoryListForSelect(){
        $where = array();
        $where[] = array('name'=>'amc_deleted','oper'=>'=','value'=>0);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $list = $this->getList($where,0,0,array('amc_create_time'=>'DESC'));
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[$val['amc_id']] = $val['amc_name'];
            }
        }
        return $data;
    }
    /**
     * 获取会议票数(总票数、已售票数)
     */
    public  function ticketNumber($amid){
        $ticket_storage   = new App_Model_Meeting_MysqlMeetingTicketStorage($this->sid);
        $where = array();
        $where[] = array('name'=>'amt_s_id','oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'amt_am_id','oper'=>'=','value'=>$amid);
        $where[] = array('name'=>'amt_deleted','oper'=>'=','value'=>0);
        $ticket  = $ticket_storage->getList($where);
        $buy_total=0;
        $total=0;
        foreach($ticket as $val){
            $buy_total+=$val['amt_buy_num'];
            $total+=$val['amt_total'];
        }
        $data=array(
            'buy_total'=>$buy_total,
            'total'=>$total
        );
        return $data;
    }
}