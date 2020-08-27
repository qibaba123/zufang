<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/3/20
 * Time: 上午7:39
 */

class App_Model_Member_MysqlMemberFormidsStorage extends Libs_Mvc_Model_BaseModel
{
    private $sid;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_formids';
        $this->_pk = 'af_id';
        $this->_shopId  = 'af_s_id';
        $this->sid = $sid;

        $this->member_table = DB::table('member');
    }

    /**
     * 获取可发送模板消息的会员列表
     */
    public function getAbleMemberList($where=array(), $index, $count){
        $where[] = array('name' => 'af_expire_time', 'oper' => '>', 'value' => time());
        $where[] = array('name' => 'af_ids', 'oper' => '!=', 'value' => '[]');
        $where[] = array('name' => 'af_s_id', 'oper' => '=', 'value' => $this->sid);

        $sql = "select af.*, m.m_id,m.m_nickname,m.m_show_id ";
        $sql .= " from `".DB::table($this->_table)."` af ";
        $sql .= " left join ".$this->member_table." m on m.m_id = af.af_m_id ";

        $sql .= $this->formatWhereSql($where);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param $sid
     * @param $midArr
     * @param $index
     * @param $count
     * @param $source
     * @return array|bool
     * 获取以mid为key的会员信息
     */
    public function getMemberKeyMid($sid,$midArr,$index,$count,$source = 0){
        $where      = array();
        $where[]    = array('name' => 'af_s_id', 'oper' => '=', 'value' => $sid);
        $where[] = array('name' => 'af_expire_time', 'oper' => '>', 'value' => time());
        $where[] = array('name' => 'af_ids', 'oper' => '!=', 'value' => '[]');
        if(!empty($midArr) && is_array($midArr)){
            $where[]    = array('name' => 'm_id', 'oper' => 'in', 'value' => $midArr);
        }
        if($source > 0){
            $where[] = array('name' => 'm_source', 'oper' => '=', 'value' => $source);
        }

        $sort       = array('m_id' => 'DESC');
        $sql = "select af.*, m.m_id,m.m_nickname,m.m_openid,m.m_avatar ";
        $sql .= " from `".DB::table($this->_table)."` af ";
        $sql .= " left join ".$this->member_table." m on m.m_id = af.af_m_id ";

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
