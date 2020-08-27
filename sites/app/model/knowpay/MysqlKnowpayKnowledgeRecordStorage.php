<?php

class App_Model_Knowpay_MysqlKnowpayKnowledgeRecordStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    public function __construct($sid){
        $this->_table 	= 'applet_knowpay_knowledge_record';
        $this->_pk 		= 'akk_id';
        $this->_shopId 	= 'akk_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }


    public function findUpdateRowBySidMidKid($sid,$mid,$kid,$data = []){
        $where = array();
        $where[] = array('name'=> 'akkr_s_id','oper'=> '=','value'=>$sid);
        $where[] = array('name'=> 'akkr_m_id','oper'=> '=','value'=>$mid);
        $where[] = array('name'=> 'akkr_k_id','oper'=> '=','value'=>$kid);

        if($data){
            return $this->updateValue($data,$where);
        }else{
            return $this->getRow($where);
        }
    }

    public function getListGoodsKnowledge($where,$index,$count,$sort){

        $where[] = ['name'=> 'g_deleted','oper'=> '=','value'=>0];
        $where[] = ['name'=> 'akk_deleted','oper'=> '=','value'=>0];

        $sql  = 'SELECT akkr.*,g.g_name,g.g_cover,g.g_knowledge_pay_type,akk.akk_name,akk.akk_cover ';
        $sql .= ' FROM '.DB::table($this->_table).' akkr ';
        $sql .= ' LEFT JOIN  pre_goods g on g.g_id = akkr.akkr_g_id ';
        $sql .= ' LEFT JOIN  pre_applet_knowpay_knowledge akk on akk.akk_id = akkr.akkr_k_id ';
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