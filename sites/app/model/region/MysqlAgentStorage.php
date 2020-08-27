<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/9/5
 * Time: 下午3:09
 */
class App_Model_Region_MysqlAgentStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id
    private $member_table = '';

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'region_agent';
        $this->_pk      = 'ra_id';
        $this->_shopId  = 'ra_s_id';

        $this->sid      = $sid;
        $this->member_table = DB::table('member');
    }

    public function getMemberList($where,$index,$count,$sort){
        $sql = 'select  ra.* , m_nickname,region_name ';
        $sql .= ' from `'.DB::table($this->_table).'` ra';
        $sql .= ' left join '.$this->member_table.' m on m_id= ra_m_id';
        $sql .= ' left join dpl_china_address ca on region_id= ra_rgid';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $ret  = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getMemberCount($where){
        $sql = 'select  count(*) ';
        $sql .= ' from `'.DB::table($this->_table).'` ra';
        $sql .= ' left join '.$this->member_table.' m on m_id= ra_m_id';
        $sql .= $this->formatWhereSql($where);

        $ret  = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param $row
     * @return array|bool
     * 检查该级代理是否存在
     */
    public function getHasLevel($row,$id){
        $where      = array();
        $where[]    = array('name'=>'ra_s_id','oper'=>'=','value'=>$this->sid);
        $where[]    = array('name'=>'ra_level','oper'=>'=','value'=>$row['ra_level']);
        $where[]    = array('name'=>'ra_id','oper'=>'!=','value'=>$id); //编辑时候，不是本记录
        $where[]    = array('name'=>'ra_status','oper'=>'=','value'=>1); //代理中
        $where[]    = array('name'=>'ra_rgid','oper'=>'=','value'=>$row['ra_rgid']); //代理区域
        return $this->getRow($where);
    }

    public function checkIsAgent($mid,$id){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ra_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'ra_id', 'oper' => '!=', 'value' => $id);
        return $this->getCount($where);
    }
    /*
     * 通过代理区域获取代理商
     */
    public function fetchAgentByRegion($level, $rgid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ra_level', 'oper' => '=', 'value' => $level);
        $where[]    = array('name' => 'ra_rgid', 'oper' => '=', 'value' => $rgid);
        $where[]    = array('name' => 'ra_status', 'oper' => '=', 'value' => 1);//正常状态

        return $this->getRow($where);
    }
    /*
     * 通过会员ID查找代理商
     */
    public function fetchAgentByMid($mid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ra_m_id', 'oper' => '=', 'value' => $mid);

        return $this->getRow($where);
    }
}