<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/7/29
 * Time: 下午2:59
 */
class App_Model_Information_MysqlInformationMemberCardStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $member_table;
    private $card_table;
    public function __construct($sid){
        $this->_table 	= 'applet_information_member_card';
        $this->_pk 		= 'aim_id';
        $this->_shopId 	= 'aim_s_id';
        parent::__construct();
        $this->sid = $sid;
        $this->member_table = 'member';
        $this->card_table = 'applet_information_card';
    }


    /*
     * 根据文章店铺id、会员id获取记录信息
    */
    public function fetchRowById($mid,$data=null){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'aim_m_id', 'oper' => '=', 'value' => $mid);
        if($data){
            return $this->updateValue($data,$where);
        }else{
            return $this->getRow($where);
        }

    }

    public function getRecordWithMember($where,$index,$count,$sort){
        $sql = "select aim.*,m.m_nickname,m.m_avatar ";
        $sql .= " from `".DB::table($this->_table)."` aim ";
        $sql .= " left join ".DB::table($this->member_table)." m on m.m_id = aim.aim_m_id ";
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
     * 统计数量
     */
    public function getSum($where){
        $sql  = 'SELECT count(*) as total ';
        $sql  .= ' from ( ';
        $sql  .= 'SELECT aim_id ';
        $sql .= ' FROM '.DB::table($this->_table).' ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' group by aim_m_id ) as count_table ';
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}