<?php


class App_Model_Member_MysqlMemberCategoryStorage extends Libs_Mvc_Model_BaseModel {
    private $member_table;
    private $sid;

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'member_category';
        $this->_pk      = 'mc_id';
        $this->_shopId  = 'mc_s_id';
        $this->sid      = $sid;

        $this->member_table     = DB::table('member');
    }



}