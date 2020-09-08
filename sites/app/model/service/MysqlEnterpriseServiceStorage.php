<?php

class App_Model_Service_MysqlEnterpriseServiceStorage extends Libs_Mvc_Model_BaseModel
{


    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_enterprise_service';
        $this->_pk = 'es_id';
        $this->_shopId = 'es_s_id';
        $this->_df     = 'es_deleted';
    }


}