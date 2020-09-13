<?php


class App_Model_Index_MysqlIndexNavStorage extends Libs_Mvc_Model_BaseModel
{


    public function __construct()
    {
        parent::__construct();
        $this->_table = 'index_nav';
        $this->_pk = 'in_id';
        $this->_shopId = 'in_s_id';


    }


}