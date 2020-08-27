<?php

class App_Model_Limit_MysqlLimitFakeExampleStorage extends Libs_Mvc_Model_BaseModel{
    private $sid;
    public function __construct($sid) {
        $this->_table   = 'limit_fake_example';
        $this->_pk      = 'lfe_id';
        $this->_shopId  = 'lfe_s_id';
        $this->sid      = $sid;
        parent::__construct();

    }

    public function getExampleList($id, $index = 0, $count = 0, $primary = false){
        $where[] = ['name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid];
        $where[] = ['name' => 'lfe_la_id', 'oper' => '=', 'value' => $id];
        $sort = ['lfe_time'=>'desc'];
        return $this->getList($where,$index,$count,$sort,[],$primary);
    }

    /**
     * 批量插入
     */
    public function insertBatch(array $value){
        if(!empty($value)){
            $sql = 'INSERT '.' INTO '.DB::table($this->_table);
            $sql .= ' (`lfe_id`,`lfe_s_id`, `lfe_la_id`, `lfe_title`, `lfe_num`, `lfe_time`,`lfe_update_time`) ';
            $sql .= ' VALUES '.implode(',',$value);

            $ret  = DB::query($sql);
            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
            return $ret;
        }
        return false;
    }




}