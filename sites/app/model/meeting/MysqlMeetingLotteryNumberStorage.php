<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_Meeting_MysqlMeetingLotteryNumberStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_meeting_lottery_number';
        $this->_pk = 'amln_id';
        $this->_shopId = 'amln_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }
    /**
     * 判断会员针对活动是否已经赠送
     */
    public function checkMemNum($mid,$lid,$data=array()){
        $where    =  array();
        $where[]  =  array('name'=>'amln_s_id','oper'=>'=','value'=>$this->sid);
        $where[]  =  array('name'=>'amln_mid','oper'=>'=','value'=>$mid);
        $where[]  =  array('name'=>'amln_l_id','oper'=>'=','value'=>$lid);//活动
        if($data){
            return $this->updateValue($data,$where);
        }else{
            return $this->getRow($where);
        }

    }
    /*
     * 向表中增加一条新的数据，会员的抽奖次数
     */
    public function insertMemNum($mid,$lid,$num,$sendNum){
        $data = array(
            'amln_s_id' => $this->sid,
            'amln_mid'  => $mid,
            'amln_l_id' => $lid,
            'amln_num'  => $num+$sendNum,
            'amln_create_time' => time(),
            'amln_update_time' => time()
        );
        return $this->insertValue($data);
    }




}