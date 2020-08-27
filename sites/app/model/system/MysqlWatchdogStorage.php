<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/3/11
 * Time: 上午10:47
 */
class App_Model_System_MysqlWatchdogStorage extends Libs_Mvc_Model_BaseModel{

    public function __construct(){
        $this->_table 	= 'watchdog';
        $this->_pk 		= 'w_id';
        parent::__construct();
    }

}