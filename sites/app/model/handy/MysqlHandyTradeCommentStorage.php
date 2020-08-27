<?php

class App_Model_Handy_MysqlHandyTradeCommentStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_handy_trade_comment';
        $this->_pk     = 'ahtc_id';
        $this->_shopId = 'ahtc_s_id';
        $this->sid     = $sid;
    }


    /*
     * 获得评分平均值
     */
    public function getScoreAvg($id,$index,$count,$sort = [],$time = 0){
        $where = [];
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ahtc_rider', 'oper' => '=', 'value' => $id);
        if($time){
            $where[]    = array('name' => 'ahtc_create_time', 'oper' => '>', 'value' => $time);
        }
        $sql = "SELECT AVG(a.ahtc_score) as score ";
        $sql .= "from ( ";
        $sql .= "SELECT ahtc.score ";
        $sql .= " FROM ".DB::table($this->_table)." ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $sql .= ") a ";
        $ret = DB::result_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function commentTradeListAction($where,$index,$count,$sort){
        $sql = "SELECT ahtc.*,aht.aht_type,aht.aht_title ";
        $sql .= " FROM ".DB::table($this->_table)." ahtc ";
        $sql .= " LEFT JOIN pre_applet_handy_trade aht on ahtc.ahtc_tid = aht.aht_tid ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }





}