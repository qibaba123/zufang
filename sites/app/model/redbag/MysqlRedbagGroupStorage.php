<?php

class App_Model_Redbag_MysqlRedbagGroupStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $activity_table;
    private $join_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_redbag_group';
        $this->_pk     = 'arg_id';
        $this->_shopId = 'arg_s_id';
        $this->sid     = $sid;
        $this->activity_table = DB::table('applet_redbag_activity');
        $this->join_table = DB::table('applet_redbag_join');
    }

    public function getRowActivity($id){
        $where = [];
        $where[] = ['name' => 'arg_s_id', 'oper' => '=', 'value' => $this->sid];
        $where[] = ['name' => 'arg_id', 'oper' => '=', 'value' => $id];
        $sql  = 'SELECT * ';
        $sql .= ' FROM '.DB::table($this->_table).' arg ';
        $sql .= ' LEFT JOIN '.$this->activity_table.' ara on ara.ara_id = arg.arg_a_id';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getRowActivityWhere($where){
        $sql  = 'SELECT * ';
        $sql .= ' FROM '.DB::table($this->_table).' arg ';
        $sql .= ' LEFT JOIN '.$this->activity_table.' ara on ara.ara_id = arg.arg_a_id';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getListActivity($where,$index,$count,$sort){
        $sql  = 'SELECT arg.*,ara.ara_name,ara.ara_num,ara_status,ara_money ';
        $sql .= ' FROM '.DB::table($this->_table).' arg ';
        $sql .= ' LEFT JOIN '.$this->activity_table.' ara on ara.ara_id = arg.arg_a_id';
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

    public function getCountActivity($where){
        $sql  = 'SELECT count(*) as total ';
        $sql .= ' FROM '.DB::table($this->_table).' arg ';
        $sql .= ' LEFT JOIN '.$this->activity_table.' ara on ara.ara_id = arg.arg_a_id';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getCountType($type = '',$timeNow){
        $where = [];
        $where[] = ['name' => 'arg_s_id', 'oper' => '=', 'value' => $this->sid];
        $timeNow = $timeNow ? $timeNow : time();
        if($type){
            switch ($type){
                case 'going':
                    $where[] = ['name' => 'arg_status', 'oper' => '=', 'value' => 1];
                    $where[] = ['name' => 'ara_status', 'oper' => '=', 'value' => 1];
                    $where[] = ['name' => 'arg_overtime_time', 'oper' => '>', 'value' => $timeNow];
                    break;
                case 'fail':
                    $where[] = ['name' => 'arg_status', 'oper' => '=', 'value' => 1];
                    $where[] = " ( ara_status = 2 OR arg_overtime_time < {$timeNow} ) ";
                    break;
                case 'finish':
                    $where[] = ['name' => 'arg_status', 'oper' => '=', 'value' => 2];
                    break;
            }
        }
        $sql  = 'SELECT count(*) as total ';
        $sql .= ' FROM '.DB::table($this->_table).' arg ';
        $sql .= ' LEFT JOIN '.$this->activity_table.' ara on ara.ara_id = arg.arg_a_id';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得组队和参与组队的第一条记录
     */
    public function getListJoin($where,$index,$count,$sort){
        $sql  = 'SELECT arg.*,arj.arj_m_id,arj.arj_id ';
        $sql .= ' FROM '.DB::table($this->_table).' arg ';
        $sql .= ' LEFT JOIN '.$this->join_table.' arj on arj.arj_group = arg.arg_id';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' group by arg_id ';
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