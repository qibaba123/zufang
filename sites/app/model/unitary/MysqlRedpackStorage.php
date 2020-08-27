<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/5/19
 * Time: 下午5:38
 */
class App_Model_Unitary_MysqlRedpackStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'unitary_redpack';
        $this->_pk      = 'ur_id';
        $this->_shopId  = 'ur_s_id';

        $this->sid      = $sid;
    }

    /*
     * 获取所有正在进行中的红包列表
     */
    public function fetchOningList() {
        $where[]    = array('name' => 'ur_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ur_status', 'oper' => '<', 'value' => 2);//进行中,揭晓中
        $where[]    = array('name' => 'ur_start_time', 'oper' => '<=', 'value' => time());

        $sort   = array('ur_create_time' => 'ASC');
        $list   = $this->getList($where, 0, 0, $sort);
        return $list;
    }

    /*
     * 获取红包详情
     */
    public function fetchRedpack($rid) {
        $where[]    = array('name' => 'ur_id', 'oper' => '=', 'value' => $rid);
        $where[]    = array('name' => 'ur_s_id', 'oper' => '=', 'value' => $this->sid);

        return $this->getRow($where);
    }

    /*
     * 增加已参与金额及人次
     */
    public function incrementHadJoin($amount, $num, $pid) {
        $field  = array('ur_amount', 'ur_num');
        $inc    = array($amount, $num);

        $where[]    = array('name' => 'ur_id', 'oper' => '=', 'value' => $pid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }
    /**
     * 获取当前红包的最大期号
     * $id红包的展示id
     */
   public function getIssueMax(){
        $where = array();
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $sql = 'select MAX(ur_issue) ';
        $sql .= ' from `'.DB::table($this->_table).'` ' ;
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}