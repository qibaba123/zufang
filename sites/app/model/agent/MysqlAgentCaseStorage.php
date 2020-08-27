<?php
/**
 * Created by PhpStorm.
 * User: zhaowei
 * Date: 16/7/16
 * Time: 下午1:24
 */
class App_Model_Agent_MysqlAgentCaseStorage extends Libs_Mvc_Model_BaseModel {

    private $case_table;

    public function __construct() {
        parent::__construct();
        $this->_table   = 'agent_case';
        $this->_pk      = 'ac_id';
        $this->_df      = 'ac_deleted';

        $this->case_table   = DB::table($this->_table);
    }

}