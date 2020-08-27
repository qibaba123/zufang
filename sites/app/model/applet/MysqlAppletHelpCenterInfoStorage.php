<?php

class App_Model_Applet_MysqlAppletHelpCenterInfoStorage extends Libs_Mvc_Model_BaseModel{

    public function __construct($sid){
        $this->_table 	= 'applet_help_center_info';
        $this->_pk 		= 'ahci_id';
        $this->_shopId 	= 'ahci_s_id';
        $this->_df 	    = 'ahci_deleted';
        parent::__construct();
    }




}