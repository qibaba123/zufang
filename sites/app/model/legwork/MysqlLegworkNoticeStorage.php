<?php

class App_Model_Legwork_MysqlLegworkNoticeStorage extends Libs_Mvc_Model_BaseModel {
    private $sid;

    public function __construct($sid = 0) {
        parent::__construct();
        $this->_table   = 'applet_legwork_notice';
        $this->_pk      = 'aln_id';
        $this->_df      = 'aln_deleted';
        $this->_shopId  = 'aln_s_id';
        $this->sid      = $sid;
    }


}