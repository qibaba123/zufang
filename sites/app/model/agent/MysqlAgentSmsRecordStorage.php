<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/5/9
 * Time: 上午10:39
 */
class App_Model_Agent_MysqlAgentSmsRecordStorage extends Libs_Mvc_Model_BaseModel
{
    private $core_table;
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'agent_sms_record';
        $this->_pk = 'as_id';
        $this->core_table    = DB::table('agent_admin');
    }



}