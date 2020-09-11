<?php

class App_Model_Service_MysqlServiceFormatStorage extends Libs_Mvc_Model_BaseModel
{


    public function __construct()
    {
        parent::__construct();
        $this->_table = 'applet_service_format';
        $this->_pk = 'sf_id';
        $this->_shopId = 'sf_s_id';
        $this->_df     = 'sf_deleted';
    }


}