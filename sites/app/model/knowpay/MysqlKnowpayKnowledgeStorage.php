<?php
/*
 * 付费阅读小程序课程表
 */
class App_Model_Knowpay_MysqlKnowpayKnowledgeStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    public function __construct($sid){
        $this->_table 	= 'applet_knowpay_knowledge';
        $this->_pk 		= 'akk_id';
        $this->_shopId 	= 'akk_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }


    public function getKnowledgeByGid($gid, $index, $count, $sort='asc'){
        $where = array();
        $where[] = array('name'=> 'akk_deleted','oper'=> '=','value'=>0);
        $where[] = array('name'=> 'akk_g_id','oper'=> '=','value'=>$gid);
        $where[] = array('name'=> $this->_shopId,'oper'=> '=','value'=>$this->sid);
        $sort = array('akk_sort' => $sort, 'akk_create_time' => $sort);
        return $this->getList($where, $index, $count, $sort);
    }

    public function getKnowledgeCountByGid($gid, $hadRead=array()){
        $where = array();
        $where[] = array('name'=> 'akk_deleted','oper'=> '=','value'=>0);
        $where[] = array('name'=> 'akk_g_id','oper'=> '=','value'=>$gid);
        $where[] = array('name'=> $this->_shopId,'oper'=> '=','value'=>$this->sid);
        if(!empty($hadRead)){
            $where[] = array('name'=> 'akk_id','oper'=> 'in','value'=>$hadRead);
        }
        return $this->getCount($where);
    }

    public function getReadNumByGid($gid){
        $where = array();
        $where[] = array('name'=> 'akk_deleted','oper'=> '=','value'=>0);
        $where[] = array('name'=> 'akk_g_id','oper'=> '=','value'=>$gid);
        $where[] = array('name'=> $this->_shopId,'oper'=> '=','value'=>$this->sid);
        $sql = "select sum(akk_read_num) ";
        $sql .= " from `".DB::table($this->_table)."` ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret?$ret:0;
    }

    //增加浏览量
    public function increaseReadNum($kid){
        $where[]    = array('name' => 'akk_id', 'oper' => '=', 'value' => $kid);
        $sql = $this->formatIncrementSql('akk_read_num', 1, $where);
        return DB::query($sql);
    }
}