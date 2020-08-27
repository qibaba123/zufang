<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/11/5
 * Time: 下午3:34
 */
class App_Model_Store_MysqlMemberStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $member;
    private $offline_order;
    public function __construct($sid){
        $this->_table 	= 'offline_member';
        $this->_pk 		= 'om_id';
        $this->_shopId 	= 'om_s_id';
        $this->_df      = 'om_deleted';
        $this->sid      = $sid;
        $this->member   = DB::table('member');
        $this->offline_order = DB::table('offline_order');
       parent::__construct();
 }

    public function findUpdateMemberByMid($mid, array $data = null, $type = 1) {
        $where[]    = array('name' => 'om_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'om_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'om_type', 'oper' => '=', 'value' => $type);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    public function findMemberExprire($mid){
        $where[]    = array('name' => 'om_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'om_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'om_expire_time', 'oper' => '<', 'value' => time());
        $where[]    = array('name' => 'om_curr_id', 'oper' => '<>', 'value' => '');
        return $this->getRow($where);

    }

    public function currLevel($mid){
        $where[]    = array('name' => 'om_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'om_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'om_curr_id', 'oper' => '>', 'value' => 0);
        $where[]    = array('name' => 'om_expire_time', 'oper' => '>', 'value' => time());
        $member_card    = $this->getList($where, 0, 0, array('om_update_time' => 'desc'));
        if($member_card){
            $cardid = $member_card[0]['om_card_id'];
            if($cardid){
                $card_model = new App_Model_Store_MysqlCardStorage($this->sid);
                $card   = $card_model->getRowById($cardid);
                $identity = intval($card['oc_identity']);
            }else{
                $identity = $member_card[0]['om_curr_id'];
            }
        }else{
            $identity = 0;
        }
        $level_model = new App_Model_Member_MysqlLevelStorage();
        $level = $level_model->getRowById($identity);
        return $level?$identity:0;
    }

    public function getMemberCardList($where,$index,$count,$sort=array('om_create_time'=>'DESC'),$field=array(),$type = ''){
        if($this->_df){
            $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        }
        $sql  = 'SELECT * ';
        $sql .= ' FROM `'.DB::table($this->_table).'` om ';
        $sql .= ' LEFT JOIN '.$this->member.' m on m_id=om_m_id ';
        $sql .= ' LEFT JOIN  pre_applet_job_company ajc on ajc.ajc_es_id=om_es_id ';
        if($type == 2){
            $sql .= " LEFT JOIN (select * from ".$this->offline_order." where oo_id in (SELECT SUBSTRING_INDEX(group_concat(oo_id order by `oo_create_time` desc),',',1) 
FROM `pre_offline_order` where oo_s_id = ".$this->sid." group by oo_m_id)) oo on m_id=oo_m_id ";
//            $sql .= ' LEFT JOIN (select * from '.$this->offline_order.' where oo_s_id = '.$this->sid.' and oo_card_type = 2 order by oo_create_time desc) oo on m_id=oo_m_id ';

            $sql .= $this->formatWhereSql($where);
            $sql .= ' group by om_card_num ';
        }elseif ($type == 1 && $this->sid == 10380){
            $sql .= ' LEFT JOIN (select * from '.$this->offline_order.' where oo_s_id = '.$this->sid.' and oo_card_type = 1 and oo_status = 2 order by oo_create_time desc limit 0,1) oo on m_id=oo_m_id ';
            $sql .= $this->formatWhereSql($where);
            $sql .= ' group by om_card_num ';
        }else{
            $sql .= $this->formatWhereSql($where);
        }
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        //Libs_Log_Logger::outputLog($sql,'test.log');
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getMemberCardCount($where,$type = ''){
        $sql  = 'SELECT count(*) as total ';
        $sql  .= 'from ( ';
        $sql  .= 'SELECT om_id ';
        $sql .= ' FROM `'.DB::table($this->_table).'` om ';
        $sql .= ' LEFT JOIN '.$this->member.' m on m_id=om_m_id ';
        if($type == 2){
            $sql .= ' LEFT JOIN (select * from '.$this->offline_order.' where oo_s_id = '.$this->sid.' and oo_card_type = 2) oo on m_id=oo_m_id ';
            $sql .= $this->formatWhereSql($where);
            $sql .= ' group by om_card_num ';
        }else{
            $sql .= $this->formatWhereSql($where);
        }
        $sql .= ' ) as count_table ';
        //Libs_Log_Logger::outputLog($sql);
        $ret  = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /**
     * @param $where
     * @return array|bool
     * 获取会员信息单条记录
     */
    public function getMemberCard($where){
        $list = $this->getMemberCardList($where,0,1);
        $ret  = array();
        if (!empty($list)) {
            $ret = $list[0];
        }
        return $ret;
    }

    /**
     * @param $mid
     * @return bool
     * 核销递减
     */
    public function verifyByMid($mid){
        $sql  = ' UPDATE '.DB::table($this->_table);
        $sql .= ' SET `om_left_num` = om_left_num - 1 ';
        $sql .= ' WHERE om_left_num >0 AND om_m_id = '.intval($mid);
        $ret = DB::query($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     *获取会员信息
     */
    public function getStoreMemberInfo($mid, $type=1, $esId=0){
        if($this->_df){
            $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        }
        $where[]    = array('name' => 'om_s_id', 'oper' => '=', 'value' => $this->sid);
        if($esId){
            $where[]    = array('name' => 'om_es_id', 'oper' => '=', 'value' => $esId);
        }else{
            $where[]    = array('name' => 'om_m_id', 'oper' => '=', 'value' => $mid);
        }
        $where[]    = array('name' => 'om_type', 'oper' => '=', 'value' => $type);
        $sql  = 'SELECT * ';
        $sql .= ' FROM `'.DB::table($this->_table).'` om ';
        $sql .= ' LEFT JOIN '.$this->member.' m on m_id=om_m_id ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     *获取会员信息
     */
    public function getMemberInfo($id){
        if($this->_df){
            $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        }
        $where[]    = array('name' => 'om_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'om_id', 'oper' => '=', 'value' => $id);
        $sql  = 'SELECT om.*,m.m_nickname,m.m_avatar ';
        $sql .= ' FROM `'.DB::table($this->_table).'` om ';
        $sql .= ' LEFT JOIN '.$this->member.' m on m_id=om_m_id ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     *获取会员信息
     */
    public function getUnexpireMemberInfo($mid, $type=1, $esId=0){
        if($this->_df){
            $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        }
        $where[]    = array('name' => 'om_s_id', 'oper' => '=', 'value' => $this->sid);
        if($esId){
            $where[]    = array('name' => 'om_es_id', 'oper' => '=', 'value' => $esId);
        }else{
            $where[]    = array('name' => 'om_m_id', 'oper' => '=', 'value' => $mid);
        }
        $where[]    = array('name' => 'om_type', 'oper' => '=', 'value' => $type);
        $sql  = 'SELECT * ';
        $sql .= ' FROM `'.DB::table($this->_table).'` om ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function findUpdateMemberByCardId($mid , $card ) {
        $where[]    = array('name' => 'om_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'om_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'om_curr_id', 'oper' => '=', 'value' => $card);
        return $this->getRow($where);

    }

    /*
     * 不同字段自增或自减
     */
    public function incrementField($field,$id,$num){
        $field = array($field);
        $inc   = array($num);
        $where[] = array('name' => $this->_pk,'oper'=> '=', 'value' => $id);
        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }
    /**
     * 根据会员卡号获取数据
     */
    public function getRowDataByNum($cardNum,$update=''){
        $where    = array();
        $where[]  = array('name'=>'om_s_id','oper'=>'=','value'=>$this->sid);
        $where[]  = array('name'=>'om_card_num','oper'=>'=','value'=>$cardNum);
        if($update){
            return $this->updateValue($update,$cardNum);
        }else{
            return  $this->getRow($where);
        }

    }

    public function findUpdateMemberByEsId($esid, array $data = null, $type = 1) {
        $where[]    = array('name' => 'om_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'om_m_id', 'oper' => '=', 'value' => $esid);
        $where[]    = array('name' => 'om_type', 'oper' => '=', 'value' => $type);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }






}