<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_Meeting_MysqlMeetingLotteryListStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_meeting_lottery_list';
        $this->_pk = 'amll_id';
        $this->_shopId = 'amll_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    /**
     * 根据店铺id获取店铺的所有资讯分类
     */
    public function getListBySid($index, $count){
        $where = array();
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=> 'amll_deleted', 'oper'=>'=', 'value'=> 0);
        return $this->getList($where,$index,$count,array('amll_status' => 'ASC','amll_create_time'=>'DESC'));
    }

    /**
     * 根据店铺id获取店铺的所有资讯分类
     */
    public function getListCount(){
        $where = array();
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=> 'amll_deleted', 'oper'=>'=', 'value'=> 0);
        return $this->getCount($where);
    }
    /*
     * 根据店铺Id获取正在进行中的抽奖活动信息
     */
    public function getLotteryRow(){
        $where = array();
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=> 'amll_deleted', 'oper'=>'=', 'value'=> 0);
        $where[] = array('name'=> 'amll_status', 'oper'=>'=', 'value'=> 1);  //进行中的抽奖活动
        return $this->getRow($where);
    }
}