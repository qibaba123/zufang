<?php

class App_Model_Legwork_MysqlLegworkNoticePushStorage extends Libs_Mvc_Model_BaseModel {
    private $sid;
    private $notice_table;
    public function __construct($sid = 0) {
        parent::__construct();
        $this->_table   = 'applet_legwork_notice_push';
        $this->_pk      = 'alnp_id';
//        $this->_df      = 'alnp_deleted';
        $this->_shopId  = 'alnp_s_id';
        $this->sid      = $sid;
        $this->notice_table = DB::table('applet_legwork_notice');
    }

    /*
     * 获得列表
     */
    public function getNoticeList($where,$index,$count,$sort){
        $sql  = 'SELECT alnp.*,aln.aln_title,aln.aln_id ';
        $sql .= ' FROM '.DB::table($this->_table).' alnp ';
        $sql .= ' LEFT JOIN '.$this->notice_table.' aln on aln.aln_id = alnp.alnp_notice ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


}