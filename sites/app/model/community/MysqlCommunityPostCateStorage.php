<?php

class App_Model_Community_MysqlCommunityPostCateStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    public function __construct($sid=0)
    {
        parent::__construct();
        $this->_table  = 'applet_community_post_cate';
        $this->_pk     = 'acpc_id';
        $this->_shopId = 'acpc_s_id';
        $this->_df     = 'acpc_deleted';

        $this->sid     = $sid;
    }




}