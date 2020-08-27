<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/11/5
 * Time: 上午10:59
 */
class App_Model_Store_MysqlOrderStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $member_table;
    private $level_table;
    private $card_table;
    private $offline_member;
    public function __construct($sid){
        $this->_table 	= 'offline_order';
        $this->_pk 		= 'oo_id';
        $this->_shopId 	= 'oo_s_id';
        parent::__construct();
        $this->sid  = $sid;
        $this->member_table = DB::table('member');
        $this->level_table = DB::table('member_level');
        $this->card_table = DB::table('offline_card');
        $this->offline_member = DB::table('offline_member');
    }

    public function findUpdateOrderByTid($tid, array $data = null) {
        $where[]    = array('name' => 'oo_tid', 'oper' => '=', 'value' => $tid);
        $where[]    = array('name' => 'oo_s_id', 'oper' => '=', 'value' => $this->sid);

        if ($data) {
            // 更新线下会员卡交易的支付状态时如果状态已经被改为了已支付就不再执行
            // zhangzc
            // 2019-08-20
            if($data['oo_status']==2)
                $where[]=['name'=>'oo_status','oper'=>'!=','value'=>2];
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }
    public function getMemberCardList($where, $index, $count, $sort){
        $sql = 'SELECT vo.* ,m.m_nickname,m.m_avatar,m.m_id ';
        $sql .= ' FROM `'.DB::table($this->_table).'` vo ';
        $sql .= ' LEFT JOIN '.$this->member_table.' m ON m_id=oo_m_id ';

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

    public function getMemberCardJobCompanyList($where, $index, $count, $sort){
        $sql = 'SELECT vo.* ,m.m_nickname,m.m_avatar,m.m_id,ajc.ajc_company_name ';
        $sql .= ' FROM `'.DB::table($this->_table).'` vo ';
        $sql .= ' LEFT JOIN '.$this->member_table.' m ON m_id=oo_m_id ';
        $sql .= ' left join pre_applet_job_bind ajb on m.m_id = ajb.ajb_m_id ';
        $sql .= ' left join pre_applet_job_company ajc on ajb.ajb_es_id = ajc.ajc_es_id ';
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

    public function getMemberCardRow($id,$type){
        $where[] = array('name' => 'oo_id', 'oper' => '=', 'value' => $id);
        $where[] = array('name' => 'oo_s_id', 'oper' => '=', 'value' => $this->sid);
        $sql = 'SELECT vo.*,ml.*,om.*,m.m_nickname,m.m_avatar,m.m_gold_coin ';
        $sql .= ' FROM `'.DB::table($this->_table).'` vo ';
        $sql .= ' LEFT JOIN '.$this->member_table.' m ON m_id=oo_m_id ';
        $sql .= ' LEFT JOIN '.$this->card_table.' oc ON oc.oc_id=vo.oo_cardid ';
        $sql .= ' LEFT JOIN '.$this->level_table.' ml ON oc.oc_identity=ml.ml_id ';
        $sql .= ' LEFT JOIN '.$this->offline_member.' om ON om.om_m_id=vo.oo_m_id AND om.om_type = '.$type.' ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getMemberCardCount($where){
        $sql = 'SELECT count(*) ';
        $sql .= ' FROM `'.DB::table($this->_table).'` vo ';
        $sql .= ' LEFT JOIN '.$this->member_table.' m ON m_id=oo_m_id ';

        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 收益统计
     */
    public function getTotalAction($where,$today = false){
        $where[] = array('name' => 'oo_status', 'oper' => '=', 'value' => 2);//已支付
        if($today){
            $date = strtotime(date('Y-m-d',time()));
            $where[] = array('name' => 'oo_pay_time', 'oper' => '>', 'value' => $date);
        }

        $sql = 'SELECT SUM(oo_amount) as money,count(oo_id) as total ';
        $sql .= ' FROM `'.DB::table($this->_table).'` ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 收益统计
     */
    public function getTotalMember($where,$today = false){
        $where[] = array('name' => 'oo_status', 'oper' => '=', 'value' => 2);//已支付
        if($today){
            $date = strtotime(date('Y-m-d',time()));
            $where[] = array('name' => 'oo_pay_time', 'oper' => '>', 'value' => $date);
        }

        $sql = 'SELECT count(*) as total ';
        $sql .= 'FROM ( ';
        $sql .= 'SELECT vo.oo_id  ';
        $sql .= ' FROM `'.DB::table($this->_table).'` vo ';
        $sql .= ' LEFT JOIN '.$this->member_table.' m ON m_id=oo_m_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' group by oo_m_id ';
        $sql .= ' ) as count_table ';
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    /**
     * 获取会员卡的开卡数量
     */
    public function getOpenNum($cardId){
        $where[] = array('name' => 'oo_cardid', 'oper' => '=', 'value' => $cardId);
        $where[] = array('name' => 'oo_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'oo_status', 'oper' => '=', 'value' => 2);//已支付
        return $this->getCount($where);
    }
}