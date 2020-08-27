<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/5/9
 * Time: 上午10:39
 */
class App_Model_Answer_MysqlSubjectPointsRecordStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_subject_points_record';
        $this->_pk = 'aspr_id';
        $this->_shopId = 'aspr_s_id';

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
     * 获取店铺当日答题领取积分的总额
     */
    public function fetchAnswerPointsTotal(){
        $date = strtotime(date('Y-m-d',time()));
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'aspr_points', 'oper' => '>', 'value' => 0);
        $where[]    = array('name' => 'aspr_create_time', 'oper' => '>', 'value' => $date);
        $sql  = 'SELECT sum(aspr_points) total ';
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
    public function fetchAnswerPointsNum(){
        $date = strtotime(date('Y-m-d',time()));
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'aspr_points', 'oper' => '>', 'value' => 0);
        $where[]    = array('name' => 'aspr_create_time', 'oper' => '>', 'value' => $date);
        return $this->getCount($where);
    }


    /**
     * 获取会员当日答题的次数
     * all  获得所有记录, normal 仅获得非额外机会记录, chance 仅获得额外机会记录
     */
    public function fetchAnswerQuestionNum($mid ,$type = 'all'){
        $date = strtotime(date('Y-m-d',time()));
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'aspr_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'aspr_create_time', 'oper' => '>', 'value' => $date);
        switch ($type){
            case 'all':
                break;
            case 'normal':
                $where[]    = array('name' => 'aspr_use_chance', 'oper' => '=', 'value' => 0);
                break;
            case 'chance':
                $where[]    = array('name' => 'aspr_use_chance', 'oper' => '=', 'value' => 1);
                break;
        }

        return $this->getCount($where);
    }

    /**
     * 获取店铺当日红包领取记录
     */
    public function fetchPointsPacketList($where,$index,$count,$sort){
        $date = strtotime(date('Y-m-d',time()));
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'aspr_points', 'oper' => '>', 'value' => 0);
        $where[]    = array('name' => 'aspr_create_time', 'oper' => '>', 'value' => $date);
        $sql  = 'SELECT aspr.* , m.m_id, m.m_nickname, m.m_avatar  ';
        $sql .= ' FROM '.DB::table($this->_table) . ' aspr ';
        $sql .= ' LEFT JOIN pre_member m ON aspr.aspr_m_id = m.m_id ';
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