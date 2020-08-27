<?php

class App_Model_Gamebox_MysqlGameboxStatisticStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;
    private $game_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_gamebox_statistic';
        $this->_pk = 'ags_id';
        $this->_shopId = 'ags_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    public function findUpdateByDate($data=null){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ags_create_time', 'oper' => '=', 'value' => strtotime(date("Y-m-d")));

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    public function getClickSum($where){
        $sql = 'SELECT sum(ags_click_num) as total ';
        $sql .= ' FROM `'.DB::table($this->_table).'` ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}