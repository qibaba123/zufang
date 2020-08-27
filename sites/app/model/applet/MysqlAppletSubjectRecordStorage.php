<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/5/9
 * Time: 上午10:39
 */
class App_Model_Applet_MysqlAppletSubjectRecordStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_subject_record';
        $this->_pk = 'asr_id';
        $this->_shopId = 'asr_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
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
     * 获取店铺当日答题领取红包的总金额
     */
    public function fetchAnswerRedTotal(){
        $date = strtotime(date('Y-m-d',time()));
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'asr_redpacket', 'oper' => '>', 'value' => 0);
        $where[]    = array('name' => 'asr_create_time', 'oper' => '>', 'value' => $date);
        $sql  = 'SELECT sum(asr_redpacket) total ';
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
     * 获取会员当日答题领取红包的次数
     */
    public function fetchAnswerRedNum(){
        $date = strtotime(date('Y-m-d',time()));
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'asr_redpacket', 'oper' => '>', 'value' => 0);
        $where[]    = array('name' => 'asr_create_time', 'oper' => '>', 'value' => $date);
        return $this->getCount($where);
    }


    /**
     * 获取会员当日答题的次数
     */
    public function fetchAnswerQuestionNum($mid){
        $date = strtotime(date('Y-m-d',time()));
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'asr_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'asr_create_time', 'oper' => '>', 'value' => $date);
        return $this->getCount($where);
    }

    /**
     * 获取店铺当日红包领取记录
     */
    public function fetchRedPacketList($where,$index,$count,$sort){
        $date = strtotime(date('Y-m-d',time()));
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'asr_redpacket', 'oper' => '>', 'value' => 0);
        $where[]    = array('name' => 'asr_create_time', 'oper' => '>', 'value' => $date);
        $sql  = 'SELECT asr.* , acc.acc_name, m.m_id, m.m_nickname, m.m_avatar  ';
        $sql .= ' FROM '.DB::table($this->_table) . ' asr ';
        $sql .= ' LEFT JOIN pre_member m ON asr.asr_m_id = m.m_id ';
        $sql .= ' LEFT JOIN pre_applet_city_currency acc ON asr.asr_acc_id = acc.acc_id ';
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