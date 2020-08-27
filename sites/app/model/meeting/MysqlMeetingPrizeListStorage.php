<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_Meeting_MysqlMeetingPrizeListStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_meeting_prize_list';
        $this->_pk     = 'ampl_id';
        $this->_shopId = 'ampl_s_id';
        $this->_df     = 'ampl_deleted';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    /**
     * 获取店铺的所有奖品
     */
    public function getListBySid($name=''){
        $where   =  array();
        $where[] =  array('name'=>'ampl_s_id','oper'=>'=','value'=>$this->sid);
        if($name){
            $where[] =  array('name'=>'ampl_name','oper'=>'=','value'=>$name);
        }
        return $this->getList($where,0,0,array('ampl_create_time'=>'DESC'));
    }



}