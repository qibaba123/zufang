<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/11/11
 * Time: 上午11:19
 */
class App_Model_Goods_MysqlCollectionStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    private $curr_table;
    private $goods_table;
    private $member_table;

    public function __construct($sid = null){
        $this->_table 	= 'collection';
        $this->_pk 		= 'c_id';
        $this->_shopId 	= 'c_s_id';
        parent::__construct();

        $this->sid      = $sid;
        $this->curr_table   = DB::table($this->_table);
        $this->member_table = DB::table('member');
        $this->goods_table   = DB::table('goods');
    }

    public function getGoodsList($where, $index, $count, $sort){
        $sql = 'select * ';
        $sql .= ' from '.$this->curr_table.' c ';
        $sql .= ' left join '.$this->goods_table.' g on g.g_id = c.c_g_id ';
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
}