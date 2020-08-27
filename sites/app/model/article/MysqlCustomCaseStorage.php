<?php
/**
 * Created by PhpStorm.
 * User: zhaowei
 * Date: 16/7/16
 * Time: 下午1:24
 */
class App_Model_Article_MysqlCustomCaseStorage extends Libs_Mvc_Model_BaseModel {

    private $case_table;

    public function __construct() {
        parent::__construct();
        $this->_table   = 'custom_case';
        $this->_pk      = 'cc_id';
        $this->_df      = 'cc_deleted';

        $this->case_table   = DB::table($this->_table);
    }


    /*
     * 随机获取客户案例
     */
    public function fetchRandomCase($count = 4) {
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未被删除
        $where_sql  = $this->formatWhereSql($where);
        $sql    = "SELECT * FROM `{$this->case_table}` {$where_sql} ORDER BY RAND() LIMIT {$count}";

        return DB::fetch_all($sql);
    }
}