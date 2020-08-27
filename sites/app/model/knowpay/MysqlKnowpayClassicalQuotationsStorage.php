<?php

class App_Model_Knowpay_MysqlKnowpayClassicalQuotationsStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;
    private $member_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'knowpay_classical_quotations';
        $this->_pk = 'kcq_id';
        $this->_shopId = 'kcq_s_id';
        $this->_df = 'kcq_deleted';
        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
        $this->member_table = DB::table('member');
    }

    public function findRowById($id) {
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $id);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        return $this->getRow($where);
    }

    public function getQuotationMemberCount($where){
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sql = "select count(*)";
        $sql .= " from `".DB::table($this->_table)."` kcq ";
        $sql .= " left join ".$this->member_table." m on m.m_id = kcq.kcq_m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    // 根据距离排序获取帖子信息
    public function getQuotationMemberList($where,$index,$count,$sort){
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sql  = ' SELECT * ';
        $sql .= " from `".DB::table($this->_table)."` kcq ";
        $sql .= " left join ".$this->member_table." m on m.m_id = kcq.kcq_m_id ";
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

    // 根据距离排序获取帖子信息
    public function getQuotationMemberRow($id){
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $id);
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sql  = ' SELECT * ';
        $sql .= " from `".DB::table($this->_table)."` kcq ";
        $sql .= " left join ".$this->member_table." m on m.m_id = kcq.kcq_m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取评论及评论会员信息
     */
    public function getCommentMember($gid,$kid,$cid=0,$index=0,$count=20,$uid=0){
        $where = array();
        if($gid){
            $where[] = array('name'=>'akc_g_id','oper'=>'=','value'=>$gid);
        }
        if($kid){
            $where[] = array('name'=>'akc_k_id','oper'=>'=','value'=>$kid);
        }
        if($uid){
            $where[] = array('name'=>'akc_m_id', 'oper'=>'=', 'value'=>$uid);
        }
        if($cid != -1){
            $where[] = array('name'=>'akc_c_id','oper'=>'=','value'=>$cid);
        }
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        if($cid){
            $sort = array('akc_time'=>'ASC');
        }else{
            $sort = array('akc_time'=>'DESC');
        }
        $sql = "select akc.*,m.m_id,m.m_nickname,m.m_avatar,rm.m_id rm_id,rm.m_nickname rm_nickname,rm.m_avatar rm_avatar";
        $sql .= " from `".DB::table($this->_table)."` akc ";
        $sql .= " left join ".$this->member_table." m on m.m_id = akc.akc_m_id ";
        $sql .= " left join ".$this->member_table." rm on rm.m_id = akc.akc_reply_mid ";

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
     * 获取评论及评论会员信息
     */
    public function getCommentListByMid($gid,$kid,$cid=0,$index=0,$count=20){
        $where = array();
        $where[] = array('name'=>'akc_g_id','oper'=>'=','value'=>$gid);
        if($kid){
            $where[] = array('name'=>'akc_k_id','oper'=>'=','value'=>$kid);
        }
        if($cid){
            $where[] = array('name'=>'akc_c_id','oper'=>'=','value'=>$cid);
        }
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $sort = array('akc_time'=>'DESC');
        $sql = "select akc.* ";
        $sql .= " from `".DB::table($this->_table)."` akc ";

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
     * 获取评论数量
     */
    public function getCommentListMemberCount($where) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        $sql    = "SELECT count(*) as total FROM `".DB::table($this->_table)."` AS akc ";
        $sql    .= "LEFT JOIN `{$this->member_table}` AS m ON akc.akc_m_id=m.m_id ";
        $sql    .= "LEFT JOIN `pre_goods` AS g ON akc.akc_g_id=g.g_id ";

        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取评论列表
     */
    public function getCommentListMember($where, $index = 0, $count = 20) {
        $where[]    = array('name' => 'akc.akc_s_id', 'oper' => '=', 'value' => $this->sid);

        $sort   = array('akc.akc_time' => 'DESC');

        $sql    = "SELECT akc.*,m.m_nickname,m.m_avatar,g.g_name,g.g_cover FROM `".DB::table($this->_table)."` AS akc ";
        $sql    .= "LEFT JOIN `{$this->member_table}` AS m ON akc.akc_m_id=m.m_id ";
        $sql    .= "LEFT JOIN `pre_goods` AS g ON akc.akc_g_id=g.g_id ";

        $sql    .= $this->formatWhereSql($where);
        $sql    .= $this->getSqlSort($sort);
        $sql    .= $this->formatLimitSql($index, $count);

        $ret    = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    public function addReduceNum($qid,$type,$operation='add',$num=1){
        if(is_array($qid)){
            $where[]    = array('name' => $this->_pk, 'oper' => 'in', 'value' => $qid);
        }else{
            $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $qid);
        }
        if($type=='like'){
            $field = 'kcq_like_num';
        }elseif ($type=='comment'){
            $field = 'kcq_comment_num';
        }
        $sql  = 'UPDATE '.DB::table($this->_table);
        if($operation=='add'){
            $sql .= ' SET  '.$field.' = '.$field.' + '.$num;
        }else{
            $sql .= ' SET  '.$field.' = '.$field.' - '.$num;
        }
        $sql .= $this->formatWhereSql($where);
        $ret = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

}