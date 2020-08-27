<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/5/9
 * Time: 上午10:39
 */
class App_Model_Answer_MysqlSubjectAwardRecordStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_subject_award_record';
        $this->_pk = 'asar_id';
        $this->_shopId = 'asar_s_id';

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
     * 获取店铺当日答题领取奖品的总数
     */
    public function fetchAnswerAwardTotal(){
        $date = strtotime(date('Y-m-d',time()));
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'asar_award_id', 'oper' => '>', 'value' => 0);
        $where[]    = array('name' => 'asar_create_time', 'oper' => '>', 'value' => $date);
//        $sql  = 'SELECT sum(asar_award_num) total ';
//        $sql .= ' FROM '.DB::table($this->_table) ;
//        $sql .= $this->formatWhereSql($where);
//        $ret = DB::result_first($sql);
//        if ($ret === false) {
//            trigger_error("query mysql failed.", E_USER_ERROR);
//            return false;
//        }
        $ret = $this->getCount($where);
        return $ret;
    }

    /**
     * 获取会员当日答题领取奖品的次数
     */
    public function fetchAnswerAwardNum(){
        $date = strtotime(date('Y-m-d',time()));
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'asar_award_num', 'oper' => '>', 'value' => 0);
        $where[]    = array('name' => 'asar_create_time', 'oper' => '>', 'value' => $date);
        return $this->getCount($where);
    }


    /**
     * 获取会员当日奖品赛答题的次数
     */
    public function fetchAnswerQuestionNum($mid){
        $date = strtotime(date('Y-m-d',time()));
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'asar_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'asar_create_time', 'oper' => '>', 'value' => $date);
        return $this->getCount($where);
    }

    /**
     * 获取店铺当日奖品领取记录
     */
    public function fetchAwardRecordList($where,$index,$count,$sort,$today = true,$getCount = false){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'asar_award_id', 'oper' => '>', 'value' => 0);
        if($today){
           $date = strtotime(date('Y-m-d',time()));
           $where[]    = array('name' => 'asar_create_time', 'oper' => '>', 'value' => $date);
        }
        if($getCount){
            $ret = $this->getCount($where);
        }else{
          $sql  = 'SELECT asar.* , m.m_id, m.m_nickname, m.m_avatar  ';
        $sql .= ' FROM '.DB::table($this->_table) . ' asar ';
        $sql .= ' LEFT JOIN pre_member m ON asar.asar_m_id = m.m_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        }

        return $ret;
    }



    /**
     * 获得指定会员的获奖记录
     */
    public function getMemberAwardRecord($mid,$index,$count,$sort = array(),$field = array()){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'asar_award_id', 'oper' => '>', 'value' => 0);
        $where[]    = array('name' => 'asar_m_id', 'oper' => '=', 'value' => $mid);
        return $this->getList($where,$index,$count,$sort,$field);
    }

    /**
     * 获得指定会员的可领奖数
     */
    public function getMemberAwardCount($mid){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'asar_award_id', 'oper' => '>', 'value' => 0);
        $where[]    = array('name' => 'asar_status', 'oper' => '=', 'value' => 0);
        $where[]    = array('name' => 'asar_m_id', 'oper' => '=', 'value' => $mid);
        return $this->getCount($where);
    }

    /*
     * 根据兑换码获得记录
     */
    public function getRowByCode($mid,$code){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'asar_code', 'oper' => '=', 'value' => $code);
        $where[]    = array('name' => 'asar_m_id', 'oper' => '=', 'value' => $mid);
        return $this->getRow($where);
    }

}