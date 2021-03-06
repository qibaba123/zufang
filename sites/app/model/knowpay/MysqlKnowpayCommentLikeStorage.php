<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/8/17
 * Time: 上午10:39
 */
class App_Model_Knowpay_MysqlKnowpayCommentLikeStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;
    private $member_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_knowpay_comment_like';
        $this->_pk = 'akcl_id';
        $this->_shopId = 'akcl_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
        $this->member_table = DB::table('member');
    }

    /**
     * 根据会员ID和帖子ID获取点赞信息
     */
    public function getLikeByMidPid($mid,$pid){
        $where = array();
        $where[] = array('name'=>'akcl_m_id','oper'=>'=','value'=>$mid);
        $where[] = array('name'=>'akcl_akc_id','oper'=>'=','value'=>$pid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        return $this->getRow($where);
    }

    public function getLikeCount($pid){
        $where = array();
        $where[] = array('name'=>'akcl_akc_id','oper'=>'=','value'=>$pid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        return $this->getCount($where);
    }

}
