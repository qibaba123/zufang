<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_House_MysqlHouseExpertsStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_house_experts';
        $this->_pk = 'ahe_id';
        $this->_shopId = 'ahe_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    public function getRowByMid($mid){
        $where[] = array('name'=>'ahe_m_id','oper'=>'=','value'=>$mid);
        $where[] = array('name'=>'ahe_deleted','oper'=>'=','value'=>0);
        $row = $this->getRow($where);
        return $row;
    }

    public function getExpertsList($where,$index,$count,$sort){
        $where[] = array('name'=>'ahe_s_id','oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'ahe_deleted','oper'=>'=','value'=>0);
        $list = $this->getList($where, $index, $count, $sort);
        return $list;
    }

    public function getExpertsCount($where){
        $where[] = array('name'=>'ahe_s_id','oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'ahe_deleted','oper'=>'=','value'=>0);
        $count = $this->getCount($where);
        return $count;
    }

    public function getAgentList(){
        $where[] = array('name'=>'ahe_s_id','oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'ahe_deleted','oper'=>'=','value'=>0);
        $sql = 'SELECT ahe_agent';
        $sql .= ' FROM `'.DB::table($this->_table).'` ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY trim(ahe_agent) ';

        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}