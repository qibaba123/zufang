<?php
/*
 * 商家岛 砍价活动参与表
 */
class App_Model_Merchant_MysqlMerchantBargainJoinStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id
    private $activity_table; //活动表
    private $bargain_table;//砍价配置表
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'merchant_bargain_join';
        $this->activity_table = 'pre_merchant_activity';
        $this->bargain_table = 'pre_merchant_bargain_cfg';
        $this->_pk      = 'mbj_id';
        $this->_shopId  = 'mbj_s_id';

        $this->sid      = $sid;
    }

    /**
     * 通过会员id获取参与的活动
     */
    public function getJoinerList($where, $index, $count, $sort){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sql = "select mbj.*, ma.*, mbc.*";
        $sql .= " from `".DB::table($this->_table)."` mbj ";
        $sql .= " left join ".$this->activity_table." ma on mbj.mbj_a_id = ma.ma_id ";
        $sql .= " left join ".$this->bargain_table." mbc on mbc.mbc_a_id = ba.ba_g_id ";

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


    /*
     * 通过活动ID，会员ID查找参与者
     */
    public function findJoinerByAidMid($aid, $mid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'mbj_a_id', 'oper' => '=', 'value' => $aid);
        $where[]    = array('name' => 'mbj_m_id', 'oper' => '=', 'value' => $mid);

        return $this->getRow($where);
    }

    /*
     * 增加参与者，砍价次数及砍价金额
     */
    public function incrementActivityAmount($jid, $money) {
        $field  = array('mbj_total', 'mbj_amount');
        $inc    = array(1, $money);

        $where[]    = array('name' => 'mbj_id', 'oper' => '=', 'value' => $jid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    /*
     * 获取活动的砍价排行榜
     */
    public function fetchRankListByAid($aid, $index = 0, $count = 0) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'mbj_a_id', 'oper' => '=', 'value' => $aid);

        $sort   = array('mbj_amount' => 'DESC');

        return $this->getList($where, $index, $count, $sort);
    }

    /*
     * 通过活动id获得参与者信息
     */
    public function fetchMemberByAid($aid,$index = 0 ,$count = 0 ,$sort = array(),$field = array()){
      $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
      $where[]    = array('name' => 'mbj_a_id', 'oper' => '=', 'value' => $aid);

      return $this->getList($where, $index, $count, $sort , $field);
    }

    /**
     * @param array $aid
     * @return array|bool
     * 统计每个活动的参与总次数
     */
    public function statisticJoinByAids($aid = array()){
        $where = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if(!empty($aid)){
            $where[]    = array('name' => 'mbj_a_id', 'oper' => 'in', 'value' => $aid);
        }
        $sql = 'SELECT mbj_a_id, COUNT(*) total ';
        $sql .= ' FROM `pre_merchant_bargain_join` ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP by mbj_a_id ';
        $ret = DB::fetch_all($sql, array(), 'mbj_a_id');
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getActivityRow($id){
        $sql = ' SELECT * ';
        $sql .= ' FROM `pre_merchant_bargain_join`  mbj';
        $sql .= ' LEFT JOIN pre_merchant_activity ma ON ma.ma_id=mbj.mbj_a_id ';
        $sql .= ' WHERE mbj_id = '.intval($id).' AND mbj_s_id= '.$this->_shopId;
        $sql .= ' LIMIT 0,1 ';
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}