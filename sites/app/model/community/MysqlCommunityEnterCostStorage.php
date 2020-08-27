<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_Community_MysqlCommunityEnterCostStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_community_enter_cost';
        $this->_pk = 'acec_id';
        $this->_shopId = 'acec_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    /*
    * 通过店铺id和订单编号获取帖子信息
    */
    public function findRowByActid($actid) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'acec_id', 'oper' => '=', 'value' => $actid);
        return $this->getRow($where);
    }
}