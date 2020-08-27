<?php

class App_Model_Goods_MysqlGroupMatchStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    private $goods_table;
    private $match_table;
    private $entershop_table;
	public function __construct($sid){
        parent::__construct();

        $this->_table   = 'group_match';
		$this->_pk      = 'gm_id';
        $this->_shopId  = 'gm_s_id';
        $this->sid      = $sid;

        $this->goods_table  = DB::table("goods");
        $this->match_table  = DB::table($this->_table);
        $this->entershop_table = DB::table("enter_shop");
	}

    /*
     * 获取分组商品列表
     */
    public function fetchGoodsList($gpid, $index = 0, $count = 20, $where=array()) {
        $where[]    = array('name' => 'gm.gm_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gm.gm_gg_id', 'oper' => '=', 'value' => $gpid);

        $where_sql  = $this->formatWhereSql($where);
        $sort_sql   = $this->getSqlSort(array('gm.gm_weight' => 'DESC'));
        $limit_sql  = $this->formatLimitSql($index, $count);
        $sql    = "SELECT gm.*,g.* FROM `{$this->match_table}` AS gm JOIN `{$this->goods_table}` AS g ON gm.gm_g_id=g.g_id ";
        $sql    .= " AND g.g_deleted=0 ";//未被删除的商品
        $sql    .= " AND g.g_is_sale=1 ";//未下架在售的商品
        $sql    = $sql.$where_sql.$sort_sql.$limit_sql;

        return DB::fetch_all($sql);
    }

    public function fetchEntershopGoodsList($gpid, $index = 0, $count = 20, $where=array()){
        $where[]    = array('name' => 'gm.gm_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gm.gm_gg_id', 'oper' => '=', 'value' => $gpid);
        $where_sql  = $this->formatWhereSql($where);
        $sort_sql   = $this->getSqlSort(array('gm.gm_weight' => 'DESC'));
        $limit_sql  = $this->formatLimitSql($index, $count);
        $sql    = "SELECT gm.*,g.* FROM `{$this->match_table}` AS gm JOIN `{$this->goods_table}` AS g ON gm.gm_g_id=g.g_id ";
        $sql    .= " AND g.g_deleted=0 ";//未被删除的商品
        $sql    .= " AND g.g_is_sale=1 ";//未下架在售的商品
        $sql    .= " JOIN `{$this->entershop_table}` AS es on es.es_id = g.g_es_id AND es.es_deleted = 0 ";//门店为被删除
        $sql    = $sql.$where_sql.$sort_sql.$limit_sql;

        return DB::fetch_all($sql);
    }
}