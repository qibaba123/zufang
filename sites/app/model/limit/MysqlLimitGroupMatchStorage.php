<?php

class App_Model_Limit_MysqlLimitGroupMatchStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    private $group_table;
    private $match_table;

	public function __construct($sid){
        parent::__construct();

        $this->_table   = 'applet_limit_group_match';
		$this->_pk      = 'algm_id';
        $this->_shopId  = 'algm_s_id';
        $this->sid      = $sid;

        $this->goods_table  = DB::table("limit_act");
        $this->match_table  = DB::table($this->_table);
	}

    /*
     * 获取分组商品列表
     */
    public function fetchGoodsList($gpid, $index = 0, $count = 20) {
        $where[]    = array('name' => 'gm.algm_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gm.algm_gg_id', 'oper' => '=', 'value' => $gpid);

        $where_sql  = $this->formatWhereSql($where);
        $sort_sql   = $this->getSqlSort(array('gm.algm_weight' => 'DESC'));
        $limit_sql  = $this->formatLimitSql($index, $count);
        $sql    = "SELECT gm.*,la.* FROM `{$this->match_table}` AS gm JOIN `{$this->goods_table}` AS la ON gm.algm_g_id=la.la_id ";
        $sql    .= " AND la.la_deleted=0 ";//未被删除的商品
        $sql    = $sql.$where_sql.$sort_sql.$limit_sql;

        return DB::fetch_all($sql);
    }
}