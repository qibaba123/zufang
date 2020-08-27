<?php

class App_Model_Sequence_MysqlSequencePostCommentStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;
    private $member_table;
    private $post_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_sequence_post_comment';
        $this->_pk = 'aspc_id';
        $this->_shopId = 'aspc_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
        $this->member_table = DB::table('member');
        $this->post_table = DB::table('applet_sequece_post');
    }

    /**
     * 获取帖子评论及评论会员信息
     */
    public function getCommentMember($pid,$index=0,$count=20,$where = [],$sort = ['aspc_time'=>'ASC']){
        $where[] = array('name'=>'aspc_asp_id','oper'=>'=','value'=>$pid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $sql = "select acc.*,m.m_id,m.m_nickname,m.m_avatar,rm.m_id rm_id,rm.m_nickname rm_nickname,rm.m_avatar rm_avatar";
        $sql .= " from `".DB::table($this->_table)."` acc ";
        $sql .= " left join ".$this->member_table." m on m.m_id = acc.aspc_m_id ";
        $sql .= " left join ".$this->member_table." rm on rm.m_id = acc.aspc_reply_mid ";

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


    public function getCommentListByMid($mid,$index=0,$count=20){
        $where = array();
        $where[] = array('name'=>'aspc_m_id','oper'=>'=','value'=>$mid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $sort = array('aspc_time'=>'DESC');
        $sql = "select aspc.* ";
        $sql .= " from `".DB::table($this->_table)."` aspc ";

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
     * 获取我所评论过的帖子
     */

    public function getCommentPostListMember($where,$index,$count,$sort){
        $sql = "select asp.*,aspc.*,m.m_id,m.m_nickname,m.m_avatar ";
        $sql .= " from `".DB::table($this->_table)."` aspc ";
        $sql .= " left join ".$this->post_table." aspc on aspc.aspc_id = aspc.aspc_asp_id ";
        $sql .= " left join ".$this->member_table." m on m.m_id = asp.asp_m_id ";

        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY aspc_asp_id ';
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
     * 增加或减少阅读数、评论数、点赞数 $operation=add添加 $operation=reduce减少
     */
    public function addReduceCommentNum($cid,$type,$operation='add',$num=1){
        if($type=='like'){
            $field = 'aspc_like_num';
        }
//        elseif ($type=='comment'){
//            $field = 'asp_comment_num';
//        }elseif($type=='collection'){
//            $field = 'asp_collection_num';
//        }else{
//            $field = 'asp_read_num';
//        }
        $sql  = 'UPDATE '.DB::table($this->_table);
        if($operation=='add'){
            $sql .= ' SET  '.$field.' = '.$field.' + '.$num;
        }else{
            $sql .= ' SET  '.$field.' = '.$field.' - '.$num;
        }
        $sql .= '  WHERE '.$this->_pk .' = '.intval($cid);
        $ret = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得帖子的全部评论点赞总数
     */
    public function getCommentLikeSum($pid){
        $where = [];
        $where[] = array('name'=>'aspc_asp_id','oper'=>'=','value'=>$pid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $sql = 'SELECT sum(aspc_like_num) as total ';
        $sql .= ' FROM `'.DB::table($this->_table).'` ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

}