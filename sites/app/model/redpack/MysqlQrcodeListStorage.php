<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/1/7
 * Time: 下午2:32
 */
class App_Model_Redpack_MysqlQrcodeListStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id
    private $curr_table = '';
    private $member_table;
    private $act_table;
    private $tpl_table;

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'redpack_qrcode_list';
        $this->_pk      = 'rql_id';
        $this->_shopId  = 'rql_s_id';

        $this->sid          = $sid;
        $this->curr_table   = DB::table($this->_table);
        $this->member_table = DB::table('member');
        $this->act_table    = DB::table('redpack_qrcode');
        $this->tpl_table    = DB::table('redpack_tpl');
    }

    /*
     * 修改或插入一条数据
     */
    public function getRowUpdate($id,$data = null) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $id);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }
    /*
     * 查找未被领取的二维码红包
     */
    public function findNoReceived($command, $actid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'rql_actid', 'oper' => '=', 'value' => $actid);
        $where[]    = array('name' => 'rql_command', 'oper' => '=', 'value' => $command);
        $where[]    = array('name' => 'rql_received', 'oper' => '=', 'value' => 0);//未被领取

        return $this->getRow($where);
    }

    /*
     * 根据活动id获取二维码红包
     */
    public function getListByRqid($rcid,$index = 0 , $count = 0 ,  $sort = array(),$field = array(),$money = 0,$where = array()){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'rql_actid', 'oper' => '=', 'value' => $rcid);
        if($money){
            $where[]    = array('name' => 'rql_money', 'oper' => '=', 'value' => $money);
        }
        return $this->getList($where,$index,$count,$sort,$field);
    }
    public function getCountByRqid($rcid){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'rql_actid', 'oper' => '=', 'value' => $rcid);
        return $this->getCount($where);
    }

    /*
     * 根据条件获取二维码红包列表及会员信息
     */
    public function getListMemberByRqid($where,$index=0,$count=20,$sort){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sql    = "SELECT rql.*,m.m_id,m.m_nickname FROM `{$this->curr_table}` AS rql ";
        $sql    .= " LEFT JOIN `{$this->member_table}` AS m ON rql.rql_m_id=m.m_id ";
        $sql    .= $this->formatWhereSql($where);
        $sql    .= $this->getSqlSort($sort);
        $sql    .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 根据活动id获取二维码红包列表及会员信息
     */
    public function getListMemberCountByRqid($where){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sql    = "SELECT count(*) FROM `{$this->curr_table}` AS rql ";
        $sql    .= " LEFT JOIN `{$this->member_table}` AS m ON rql.rql_m_id=m.m_id ";
        $sql    .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /*
     * 通过二维码获取红包活动
     */
    public function findRedpackByCommand($command) {
        $command = strtoupper($command);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'rql_command', 'oper' => '=', 'value' => $command);

        $sql    = "SELECT rql.*,rq.*,rt.* FROM `{$this->curr_table}` AS rql ";
        $sql    .= " LEFT JOIN `{$this->act_table}` AS rq ON rql.rql_actid=rq.rq_id ";
        $sql    .= " LEFT JOIN `{$this->tpl_table}` AS rt ON rq.rq_rp_id=rt.rt_id ";
        $sql    .= $this->formatWhereSql($where);

        $ret    = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /*
     * 判断单会员、单活动已领取数量
     */
    public function countMemberReceived($mid, $actid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'rql_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'rql_actid', 'oper' => '=', 'value' => $actid);

        return $this->getCount($where);
    }

    /**
     * @param $insert
     * @return bool
     * 批量插入
     */
    public function batchData($insert){
        $ret = false;
        if(is_array($insert) && !empty($insert)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`rql_id`, `rql_s_id`, `rql_actid`, `rql_command`, `rql_qrcode`, `rql_money`, `rql_received`, `rql_m_id` , `rql_receive_time`) ';
            $sql .= ' VALUES ';
            $sql .= implode(',',$insert);
            $ret = DB::query($sql);

            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
        }
        return $ret;
    }

    /*
     * 统计金额
     */
    public function getSumAction($where){
        $sql = "select SUM(rql_money) ";
        $sql .= " from `".DB::table($this->_table)."` rql ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}