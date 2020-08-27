<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/8/17
 * Time: 上午10:39
 */
class App_Model_Community_MysqlCommunitySearchHistoryStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    public function __construct($sid=0)
    {
        parent::__construct();
        $this->_table = 'applet_community_search_history';
        $this->_pk = 'acsh_id';
        $this->_shopId = 'acsh_s_id';
        $this->sid = $sid;
    }


}