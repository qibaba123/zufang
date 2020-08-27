<?php
/*
 * 知识付费小程序首页配置
 */
class App_Model_Knowpay_MysqlKnowpayStudyStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    public function __construct($sid){
        $this->_table 	= 'applet_knowpay_study';
        $this->_pk 		= 'aks_id';
        $this->_shopId 	= 'aks_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }

    //学习情况统计
    public function getStudyTotal($where){
        $sql = "select sum(aks_study_article_count) as articleCount, sum(aks_study_audio_count) as audioCount, sum(aks_study_video_count) as videoCount";
        $sql .= " from `".DB::table($this->_table)."` ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


}