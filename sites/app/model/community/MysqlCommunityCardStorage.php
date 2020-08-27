<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/8/17
 * Time: 上午10:39
 */
class App_Model_Community_MysqlCommunityCardStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;
    private $member_table;

    public function __construct($sid=0)
    {
        parent::__construct();
        $this->_table  = 'applet_community_card';
        $this->_pk     = 'acc_id';
        $this->_shopId = 'acc_s_id';
        $this->_df     = 'acc_deleted';

        $this->sid     = $sid;
        $this->shop_table = DB::table('shop');
        $this->member_table = DB::table('member');
    }


}