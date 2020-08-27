<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_Meeting_MysqlMeetingShareRecordStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_meeting_share_record';
        $this->_pk = 'amsr_id';
        $this->_shopId = 'amsr_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }
    /**
     * 判断会员针对活动是否已经赠送
     */
    public function checkMemNum($mid,$lid,$data=array()){
        $where    =  array();
        $where[]  =  array('name'=>'amsr_s_id','oper'=>'=','value'=>$this->sid);
        $where[]  =  array('name'=>'amsr_mid','oper'=>'=','value'=>$mid);
        $where[]  =  array('name'=>'amsr_l_id','oper'=>'=','value'=>$lid);//活动
        if($data){
            return $this->updateValue($data,$where);
        }else{
            return $this->getRow($where);
        }

    }



}