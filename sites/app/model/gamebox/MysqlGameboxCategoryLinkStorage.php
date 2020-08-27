<?php

class App_Model_Gamebox_MysqlGameboxCategoryLinkStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;
    private $category_table;
    private $game_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_gamebox_category_link';
        $this->_pk = 'agcl_id';
        $this->_shopId = 'agcl_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
        $this->category_table = DB::table('applet_gamebox_category');
        $this->game_table = DB::table('applet_gamebox_game');
    }

    public function getListByGid($gid){
        $where = array();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'agcl_g_id', 'oper' => '=', 'value' => $gid);
        return $this->getList($where,0,0);
    }

    /*
     * 获得分类关联信息  关联分类表
     */
    public function getCategoryList($where,$index,$count,$sort=array()){
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'agc_deleted', 'oper' => '=', 'value' => 0);//分类未删除
        $sql = "SELECT agcl.*,agc.* ";
        $sql .= " FROM ".DB::table($this->_table)." agcl ";
        $sql .= " LEFT JOIN ".$this->category_table." agc on agcl.agcl_c_id = agc.agc_id ";
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

    /*
     * 获得分类关联信息  关联游戏表
     */
    public function getGameList($where,$index,$count,$sort=array()){
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'agg_deleted', 'oper' => '=', 'value' => 0);//游戏未删除
        $sql = "SELECT agcl.*,agg.*,agc.* ";
        $sql .= " FROM ".DB::table($this->_table)." agcl ";
        $sql .= " LEFT JOIN ".$this->game_table." agg on agcl.agcl_g_id = agg.agg_id ";
        $sql .= " LEFT JOIN ".$this->category_table." agc on agcl.agcl_c_id = agc.agc_id ";
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

    /*
     * 获得分类关联数量
     */
    public function getGameCount($where){
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'agg_deleted', 'oper' => '=', 'value' => 0);//游戏未删除
        $sql = "SELECT count(*) ";
        $sql .= " FROM ".DB::table($this->_table)." agcl ";
        $sql .= " LEFT JOIN ".$this->game_table." agg on agcl.agcl_g_id = agg.agg_id ";
        $sql .= " LEFT JOIN ".$this->category_table." agc on agcl.agcl_c_id = agc.agc_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 批量插入分类对应关系
     * @param array $val_arr
     * @return bool
     */
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`agcl_id`, `agcl_s_id`, `agcl_g_id`, `agcl_c_id`) ';
            $sql .= ' VALUES ';
            $sql .= implode(',',$val_arr);
            $ret = DB::query($sql);

            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
        }
        return $ret;
    }

}