<?php

class App_Model_Sequence_MysqlSequencePostStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;
    private $member_table;
    private $community_table;
    private $area_table;

    public function __construct($sid=0)
    {
        parent::__construct();
        $this->_table  = 'applet_sequence_post';
        $this->_pk     = 'asp_id';
        $this->_shopId = 'asp_s_id';
        $this->_df     = 'asp_deleted';

        $this->sid     = $sid;
        $this->shop_table = DB::table('shop');
        $this->member_table = DB::table('member');
        $this->community_table = DB::table('applet_sequence_community');
        $this->area_table = DB::table('applet_sequence_area');
    }

    /**
     * 获取帖子信息及发帖人信息
     */
    public function getPostListMember($where,$index,$count,$sort){
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sql = "select asp.*,m.m_id,m.m_nickname,m.m_avatar ";
        $sql .= " from `".DB::table($this->_table)."` asp ";
        $sql .= " left join ".$this->member_table." m on m.m_id = asp.asp_m_id ";
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
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sql = "select count(*)";
        $sql .= " from `".DB::table($this->_table)."` asp ";
        $sql .= " left join ".$this->member_table." m on m.m_id = asp.asp_m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取单条帖子信息
     */
    public function getPostRowMember($pid){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $pid);
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);

        $sql  = ' SELECT asp.*,m.m_id,m.m_nickname,m.m_avatar ';
        $sql .= " from `".DB::table($this->_table)."` asp ";
        $sql .= " left join ".$this->member_table." m on m.m_id = asp.asp_m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 增加或减少阅读数、评论数、点赞数 $operation=add添加 $operation=reduce减少
     */
    public function addReducePostNum($pid,$type,$operation='add',$num=1){
        if($type=='like'){
            $field = 'asp_like_num';
        }elseif ($type=='comment'){
            $field = 'asp_comment_num';
        }elseif($type=='collection'){
            $field = 'asp_collection_num';
        }elseif($type=='comment_like'){
            $field = 'asp_comment_like_num';
        }else{
            $field = 'asp_read_num';
        }
        $sql  = 'UPDATE '.DB::table($this->_table);
        if($operation=='add'){
            $sql .= ' SET  '.$field.' = '.$field.' + '.$num;
        }else{
            $sql .= ' SET  '.$field.' = '.$field.' - '.$num;
        }
        $sql .= '  WHERE '.$this->_pk .' = '.intval($pid);
        $ret = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得指定用户置顶类型今天发布数量
     */
    public function getTodayCount($mid,$type){
        $where = [];
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if($mid){
            $where[] = array('name' => 'asp_m_id', 'oper' => '=', 'value' => $mid);
        }
        if($type){
            $where[] = array('name' => 'asp_type', 'oper' => '=', 'value' => $type);
        }
        $where[] = array('name' => 'asp_create_time', 'oper' => '>', 'value' => strtotime(date('Y-m-d')));
        return $this->getCount($where);
    }

    /*
     * 获得置顶的帖子
     * topType 置顶类型  2.团长置顶 3.后台置顶
     */
    public function getTopPost($mid,$topType = 2,$sort = [],$field = []){
        $where = [];
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if($mid){
            $where[] = array('name' => 'asp_m_id', 'oper' => '=', 'value' => $mid);
        }
        $where[] = array('name' => 'asp_is_top', 'oper' => '=', 'value' => $topType);
        return $this->getList($where,0,0,$sort,$field);
    }

    /**
     * 获取帖子信息及发帖人信息
     */
    public function getPostListDistance($lng,$lat,$where,$index,$count,$sort){
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sql = 'select asp.*,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-asp_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(asp_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-asp_lat)/360),2)))) distance ';
        $sql .= " from `".DB::table($this->_table)."` asp ";
//        $sql .= " left join ".$this->member_table." m on m.m_id = asp.asp_m_id ";
        $sql .= " left join ".$this->community_table." asct on asct.asc_id = asp.asp_com_id ";
        $sql .= " left join ".$this->area_table." asa on asa.asa_id = asct.asc_area ";
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
     * 获取帖子信息及发帖人信息
     */
    public function getPostListArea($where,$index,$count,$sort){
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sql = 'select asp.* ';
        $sql .= " from `".DB::table($this->_table)."` asp ";
//        $sql .= " left join ".$this->member_table." m on m.m_id = asp.asp_m_id ";
        $sql .= " left join ".$this->community_table." asct on asct.asc_id = asp.asp_com_id ";
        $sql .= " left join ".$this->area_table." asa on asa.asa_id = asct.asc_area ";
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
     * 获取帖子信息及发帖人信息
     */
    public function getPostListCommunity($where,$index,$count,$sort){
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sql = 'select asp.* ';
        $sql .= " from `".DB::table($this->_table)."` asp ";
//        $sql .= " left join ".$this->member_table." m on m.m_id = asp.asp_m_id ";
        $sql .= " left join ".$this->community_table." asct on asct.asc_id = asp.asp_com_id ";
        $sql .= " left join ".$this->area_table." asa on asa.asa_id = asct.asc_area ";
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
     * 获取帖子信息及发帖人信息
     */
    public function getPostCommunityLeaderList($where,$index,$count,$sort){
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sql = "select asp.*,asct.asc_name,asl.asl_name ";
        $sql .= " from `".DB::table($this->_table)."` asp ";
        $sql .= " left join pre_applet_sequence_community asct on asp.asp_com_id = asct.asc_id ";
        $sql .= " left join pre_applet_sequence_leader asl on asl.asl_m_id = asp.asp_m_id ";
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
     * 获取帖子信息及发帖人信息
     */
    public function getPostCommunityLeaderCount($where){
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sql = "select count(*) as total ";
        $sql .= " from `".DB::table($this->_table)."` asp ";
        $sql .= " left join pre_applet_sequence_community asct on asp.asp_com_id = asct.asc_id ";
        $sql .= " left join pre_applet_sequence_leader asl on asl.asl_m_id = asp.asp_m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


}