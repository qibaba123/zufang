<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/5/9
 * Time: 上午10:39
 */
class App_Model_Applet_MysqlAppletRewardRecordStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_reward_record';
        $this->_pk = 'arr_id';
        $this->_shopId = 'arr_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    /*
     * 通过订单ID查找充值记录
     */
    public function findRecordByTid($tid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'arr_number', 'oper' => '=', 'value' => $tid);

        return $this->getRow($where);
    }

    /*
      * 通过店铺id获取店铺题目
      */
    public function findUpdateBySid($data = null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /**
     * 获取店铺打赏的总金额
     */
    public function fetchRewardTotal($type){
        $date = strtotime(date('Y-m-d',time()));
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'arr_create_time', 'oper' => '>', 'value' => $date);
        if($type){
            $where[]    = array('name' => 'arr_type', 'oper' => '=', 'value' => $type);
        }
        $sql  = 'SELECT sum(arr_money) total ';
        $sql .= ' FROM '.DB::table($this->_table) ;
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取资讯或帖子打赏列表
     */
    public function fetchRewardMemberList($where,$index,$count,$sort){
        $sql  = 'SELECT arr.* , m.m_id, m.m_nickname, m.m_avatar  ';
        $sql .= ' FROM '.DB::table($this->_table) . ' arr ';
        $sql .= ' LEFT JOIN pre_member m ON arr.arr_m_id = m.m_id ';
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

    /**
     * 获取单条打赏记录
     */
    public function fetchRewardMemberRow($id){
        $where[] = array('name' => 'arr_id', 'oper' => '=', 'value' => $id);
        $sql  = 'SELECT arr.* , m.m_id, m.m_nickname, m.m_avatar  ';
        $sql .= ' FROM '.DB::table($this->_table) . ' arr ';
        $sql .= ' LEFT JOIN pre_member m ON arr.arr_m_id = m.m_id ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}