<?php

class App_Model_Gamebox_MysqlGameboxHistoryStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;
    private $game_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_gamebox_history';
        $this->_pk = 'agh_id';
        $this->_shopId = 'agh_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
        $this->game_table = DB::table('applet_gamebox_game');
    }

    /*
      * 通过会员id和游戏id获取历史记录
      */
    public function findUpdateByMidGid($mid,$gid,$data = null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'agh_g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => 'agh_m_id', 'oper' => '=', 'value' => $mid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /*
     * 获得历史记录  关联游戏表
     */
    public function getGameList($where,$index,$count,$sort=array()){
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'agg_deleted', 'oper' => '=', 'value' => 0);//游戏未删除
        $sql = "SELECT agh.*,agg.*,agc.* ";
        $sql .= " FROM ".DB::table($this->_table)." agh ";
        $sql .= " LEFT JOIN ".$this->game_table." agg on agh.agh_g_id = agg.agg_id ";
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
}