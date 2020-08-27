<?php

class App_Model_Business_MysqlBusinessCardCollectionStorage extends Libs_Mvc_Model_BaseModel {
    private $sid;//店铺id
    private $card_table; //名片表
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_business_card_collection';
        $this->_pk      = 'abcc_id';
        $this->_shopId  = 'abcc_s_id';
        $this->sid      = $sid;
        $this->card_table = 'applet_business_card';
    }

    /*
     * 判断用户是否收藏
     */
    public function getRowByIdMid($id,$mid){
        $where = array();
        $where[] = array('name'=> 'abcc_card_id','oper'=> '=','value'=>$id);
        $where[] = array('name'=> 'abcc_m_id','oper'=> '=','value'=>$mid);
        $where[] = array('name'=> $this->_shopId,'oper'=> '=','value'=>$this->sid);
        return $this->getRow($where);
    }

    /*
     * 获得收藏列表
     */
    public function getListCard($where,$index,$count,$sort){
        $sql = "select abcc.*,abc.* ";
        $sql .= " from `".DB::table($this->_table)."` abcc ";
        $sql .= " left join `".DB::table($this->card_table)."` abc on abc.abc_id = abcc.abcc_card_id ";
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

    /*
     * 获得收藏列表数量
     */
    public function getCollectionCount($where){
        $sql = "select count(*) as total ";
        $sql .= " from `".DB::table($this->_table)."` abcc ";
        $sql .= " left join `".DB::table($this->card_table)."` abc on abc.abc_id = abcc.abcc_card_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}