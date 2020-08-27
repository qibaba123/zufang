<?php

class App_Model_Goods_MysqlGroupKindStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $group_table;

    public function __construct($sid){
        parent::__construct();

        $this->_table   = 'group_kind';
		$this->_pk      = 'gk_id';
        $this->_shopId  = 'gk_s_id';
        $this->sid      = $sid;
        $this->group_table = DB::table('goods_group');
	}

    public function getListBySid(){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $sort       = array('gk_index' => 'ASC');
        $sql = 'SELECT gk.* ,gg.* ';
        $sql .= ' FROM `'.DB::table($this->_table).'` gk ';
        $sql .= ' LEFT JOIN '.$this->group_table.' gg on gg_id = gk_gg_id';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);

        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param array $insArr
     * @return bool
     * 批量插入数据
     */
    public function batchInsert(array $insArr){
        $sql  = 'INSERT '.' INTO '.DB::table($this->_table);
        $sql .= ' (`gk_id`, `gk_s_id`, `gk_gg_id`, `gk_name`,`gk_pic`, `gk_list_type`,`gk_show_num`, `gk_index`, `gk_create_time`, `gk_update_time`) ';
        $sql .= ' VALUES ';
        $sql .= implode(',',$insArr);

        $ret = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param $id
     * @return bool
     * 通过ID修改索引
     */
    public function changeIndex($where){
        $sql = 'UPDATE  '.DB::table($this->_table);
        $sql .= ' SET `gk_index` = gk_index - 1 ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function findKindById($gkid) {
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $gkid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        return $this->getRow($where);
    }

}