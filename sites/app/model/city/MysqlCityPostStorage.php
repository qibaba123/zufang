<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/8/17
 * Time: 上午10:39
 */
class App_Model_City_MysqlCityPostStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;
    private $member_table;

    public function __construct($sid=0)
    {
        parent::__construct();
        $this->_table  = 'applet_city_post';
        $this->_pk     = 'acp_id';
        $this->_shopId = 'acp_s_id';
        $this->_df     = 'acp_deleted';

        $this->sid     = $sid;
        $this->shop_table = DB::table('shop');
        $this->member_table = DB::table('member');
    }

    /*
      * 通过店铺id和订单编号获取帖子信息
      */
    public function findUpdateByNumber($number,$data=null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'acp_number', 'oper' => '=', 'value' => $number);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /**
     * 获取帖子信息及发帖人信息
     */
    public function getPostListMember($where,$index,$count,$sort,$comment=0){
        $sql = "select acp.*,m.m_id,m.m_nickname,m.m_avatar,m.m_level,m.m_level_long";
        if($comment){
            $sql.= ",c.acc_time";
        }
        $sql .= " from `".DB::table($this->_table)."` acp ";
        $sql .= " left join ".$this->member_table." m on m.m_id = acp.acp_m_id ";
        if($comment){
            $sql .= " left join pre_applet_city_comment c on acp.acp_id = c.acc_acp_id";
        }

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

    public function getPostListMemberCount($where){
        $sql = "select count(*)";
        $sql .= " from `".DB::table($this->_table)."` acp ";
        $sql .= " left join ".$this->member_table." m on m.m_id = acp.acp_m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    // 根据距离排序获取帖子信息
    public function getPostListMemberDistanceAsc($where,$index,$count,$sort,$lng,$lat){
        $sql  = ' SELECT acp.*,m.m_id,m.m_nickname,m.m_avatar,m.m_level,m.m_level_long,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-acp_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(acp_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-acp_lat)/360),2)))) distance ';
        $sql .= " from `".DB::table($this->_table)."` acp ";
        $sql .= " left join ".$this->member_table." m on m.m_id = acp.acp_m_id ";
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

    /**
     * 获取单条帖子信息
     */
    public function getPostRowMemberDistance($pid,$lng=null,$lat=null){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $pid);
        $where[]    = array('name' => 'acp_deleted', 'oper' => '=', 'value' => 0);
        if($lng && $lat){
            $sql  = ' SELECT acp.*,m.m_id,m.m_nickname,m.m_avatar,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-acp_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(acp_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-acp_lat)/360),2)))) distance ';
        }else{
            $sql  = ' SELECT acp.*,m.m_id,m.m_nickname,m.m_avatar ';
        }
        $sql .= " from `".DB::table($this->_table)."` acp ";
        $sql .= " left join ".$this->member_table." m on m.m_id = acp.acp_m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 增加或减少阅读数、评论数、点赞数、分享数 $operation=add添加 $operation=reduce减少
     */
    public function addReducePostNum($pid,$type,$operation='add',$num=1){
        if(is_array($pid)){
            $where[]    = array('name' => $this->_pk, 'oper' => 'in', 'value' => $pid);
        }else{
            $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $pid);
        }
        if($type=='like'){
            $field = 'acp_like_num';
        }elseif ($type=='comment'){
            $field = 'acp_comment_num';
        }elseif($type=='share'){
            $field = 'acp_share_num';
        }else{
            $field = 'acp_show_num';
        }
        $sql  = 'UPDATE '.DB::table($this->_table);
        if($operation=='add'){
            $sql .= ' SET  '.$field.' = '.$field.' + '.$num;
        }else{
            $sql .= ' SET  '.$field.' = '.$field.' - '.$num;
        }
        //$sql .= '  WHERE '.$this->_pk .' = '.intval($pid);
        $sql .= $this->formatWhereSql($where);
        $ret = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * ac_type =14 时候各个店铺的帖子
     */
    public function getPostList($where,$index,$count,$sort){
        $sql  =  '';
        $sql .= 'SELECT sh.s_name,acp.*,m.m_id,m.m_nickname,m.m_avatar';
        $sql .= ' FROM '.DB::table($this->_table).' acp';
        $sql .= " left join pre_applet_cfg ac on ac.ac_s_id = acp.acp_s_id ";
        $sql .= " left join pre_shop sh on sh.s_id= acp.acp_s_id";
        $sql .= " left join pre_member m on m.m_id = acp.acp_m_id";
        $sql .= " left join pre_agent_open ao on ao.ao_s_id = acp.acp_s_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql,array(),'');
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    public function getPostCount($where){
        $sql  =  '';
        $sql .= 'SELECT count(*)';
        $sql .= ' FROM '.DB::table($this->_table).' acp';
        $sql .= " left join pre_applet_cfg ac on ac.ac_s_id = acp.acp_s_id ";
        $sql .= " left join pre_shop sh on sh.s_id= acp.acp_s_id";
        $sql .= " left join pre_member m on m.m_id = acp.acp_m_id";
        $sql .= " left join pre_agent_open ao on ao.ao_s_id = acp.acp_s_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得指定条件当天发帖数量
     */
    public function getTodayPostCount($where){
        $date = strtotime(date('Y-m-d',time()));
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'acp_create_time', 'oper' => '>', 'value' => $date);
        return $this->getCount($where);
    }



}