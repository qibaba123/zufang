<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_Auction_MysqlAuctionListStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_auction_list';
        $this->_pk = 'aal_id';
        $this->_shopId = 'aal_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

}