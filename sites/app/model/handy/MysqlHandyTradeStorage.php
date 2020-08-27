<?php

class App_Model_Handy_MysqlHandyTradeStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $address_table;
    private $member_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_handy_trade';
        $this->_pk     = 'aht_id';
        $this->_shopId = 'aht_s_id';
        $this->sid     = $sid;
        $this->_df     = 'aht_deleted';
        $this->address_table    = DB::table('member_address');
        $this->member_table     = DB::table('member');
    }

    /*
     * 通过订单id获取订单
     */
    public function findUpdateTradeByTid($tid, $data = null) {
        $where[]    = array('name' => 'aht_tid', 'oper' => '=', 'value' => $tid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }


    public function tradeRiderList($where,$index,$count,$sort){
        $sql = "SELECT aht.*,ahr.ahr_name,ahr.ahr_mobile ";
        $sql .= " FROM ".DB::table($this->_table)." aht ";
        $sql .= " LEFT JOIN pre_applet_handy_rider ahr on ahr.ahr_id = aht.aht_rider ";
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

    public function tradeRiderRow($tid){
        $where = [];
        $where[]    = array('name' => 'aht_tid', 'oper' => '=', 'value' => $tid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        $sql = "SELECT aht.*,ahr.ahr_name,ahr.ahr_mobile ";
        $sql .= " FROM ".DB::table($this->_table)." aht ";
        $sql .= " LEFT JOIN pre_applet_handy_rider ahr on ahr.ahr_id = aht.aht_rider ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }




}