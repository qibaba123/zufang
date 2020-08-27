<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/6/12
 * Time: 下午7:09
 */
class App_Model_Plugin_MysqlSmsRecordStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'sms_record';
        $this->_pk = 'sr_id';
        $this->_shopId = 'sr_s_id';

        $this->sid = $sid;
    }
}