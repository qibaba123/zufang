<?php

class App_Model_Gamebox_MysqlGameboxGameStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;
    private $category_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_gamebox_game';
        $this->_pk = 'agg_id';
        $this->_shopId = 'agg_s_id';
        $this->_df = 'agg_deleted';
        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
        $this->category_table = DB::table('applet_gamebox_category');

    }

    /**
     * 获取游戏列表
     */
    public function getGameListAction($where, $index, $count, $sort){
        $sql = "SELECT count(*) as total,agg.*,agc.* ";
        $sql .= " FROM ".DB::table($this->_table)." agg ";
        $sql .= " LEFT JOIN pre_applet_gamebox_history agh on agh.agh_g_id = agg.agg_id ";
        $sql .= " LEFT JOIN pre_applet_gamebox_category_link agcl on agcl.agcl_g_id = agg.agg_id ";
        $sql .= " LEFT JOIN pre_applet_gamebox_category agc on agc.agc_id = agcl.agcl_c_id ";

        $sql .= $this->formatWhereSql($where);
        $sql .= ' group by agg_id ';
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 不同字段 自增或自减
     */
    public function incrementGameField($field,$gid,$num) {
        $field  = array($field);
        $inc    = array($num);

        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

}