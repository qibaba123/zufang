<?php

class App_Model_Giftcard_MysqlGiftCardUseStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_gift_card_use';
        $this->_pk = 'agcu_id';
        $this->_shopId = 'agcu_s_id';

        $this->sid = $sid;
    }



    public function getUseList($where,$index,$count,$sort){
        $sql  = "SELECT agcu.*,agcb.agcb_name,os.os_name,es.es_name ";
        $sql .= ' FROM '.DB::table($this->_table).' agcu ';
        $sql .= ' LEFT JOIN pre_applet_gift_card_buy agcb on agcb.agcb_id = agcu.agcu_buy_id ';
        $sql .= ' LEFT JOIN pre_enter_shop es on es.es_id = agcu.agcu_verify_shop ';
        $sql .= ' LEFT JOIN pre_offline_store os on os.os_id = agcu.agcu_verify_store ';
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

    public function getUseCount($where){
        $sql  = "SELECT count(*) ";
        $sql .= ' FROM '.DB::table($this->_table).' agcu ';
        $sql .= ' LEFT JOIN pre_applet_gift_card_buy agcb on agcb.agcb_id = agcu.agcu_buy_id ';
        $sql .= ' LEFT JOIN pre_enter_shop es on es.es_id = agcu.agcu_verify_shop ';
        $sql .= ' LEFT JOIN pre_offline_store os on os.os_id = agcu.agcu_verify_store ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

}