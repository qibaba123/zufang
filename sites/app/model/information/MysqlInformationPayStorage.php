<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/7/29
 * Time: 下午2:59
 */
class App_Model_Information_MysqlInformationPayStorage extends Libs_Mvc_Model_BaseModel{
    private $sid;
    private $member_table;
    private $information_table;
    public function __construct($sid){
        $this->_table 	= 'applet_information_pay';
        $this->_pk 		= 'aip_id';
        $this->_shopId 	= 'aip_s_id';

        parent::__construct();
        $this->sid = $sid;
        $this->member_table = 'member';
        $this->information_table = 'applet_information';
    }

    /*
     * 根据文章店铺id、文章id、会员id获取记录信息
     */
    public function fetchRowById($mid,$inid){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'aip_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'aip_in_id', 'oper' => '=', 'value' => $inid);
        return $this->getRow($where);

    }


    public function getRecordWithMemInfo($where,$index,$count,$sort){
        $sql = "select aip.*,m.m_nickname,m.m_avatar,ai.ai_title,ai.ai_category ";
        $sql .= " from `".DB::table($this->_table)."` aip ";
        $sql .= " left join ".DB::table($this->information_table)." ai on ai.ai_id = aip.aip_in_id ";
        $sql .= " left join ".DB::table($this->member_table)." m on m.m_id = aip.aip_m_id ";
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

    public function getRecordWithMemInfoCount($where){
        $sql = "select count(*) ";
        $sql .= " from `".DB::table($this->_table)."` aip ";
        $sql .= " left join ".DB::table($this->information_table)." ai on ai.ai_id = aip.aip_in_id ";
        $sql .= " left join ".DB::table($this->member_table)." m on m.m_id = aip.aip_m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 统计信息
     */
    public function getSumInfo($where){
        $sql  = 'SELECT count(aip_id) as total,sum(aip_pay_money) as money ';
        $sql .= " from `".DB::table($this->_table)."` aip ";
        $sql .= " left join ".DB::table($this->information_table)." ai on ai.ai_id = aip.aip_in_id ";
        $sql .= " left join ".DB::table($this->member_table)." m on m.m_id = aip.aip_m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }



}